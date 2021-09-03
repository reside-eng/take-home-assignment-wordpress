<?php
/*
Plugin Name: Side
Version: 1.0.0
Author: Side
License: GPLv2 or later
Text Domain: side
*/

defined( 'ABSPATH' ) || die(); // WordPress must exist.

if ( ! function_exists('side_plugin_setup') ) {

    add_action( 'wp_enqueue_scripts', 'side_plugin_setup' );

    function side_plugin_setup() {
        wp_enqueue_style(
            'side-plugin-styles',
            plugin_dir_url(__FILE__) . '/build/style.css',
            [],
            filemtime(plugin_dir_path( __FILE__ ) . '/build/style.css')
        );

        wp_enqueue_script(
            'side-plugin-scripts',
            plugin_dir_url(__FILE__) . '/build/scripts.js',
            array( 'jquery' ),
            filemtime(plugin_dir_path( __FILE__ ) . '/build/scripts.js'),
            true
        );
    }

    add_filter ('theme_page_templates', 'reside_add_page_template');
    function reside_add_page_template ($templates) {
        $templates['templates/property-listings.php'] = 'Property Listings';
        return $templates;
    }

    /**
     * Load template.
     * @param string $template The template location.
     */
    function reside_redirect_page_template ( $template ) {
        $post = get_post();
        $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
        if ( 'property-listings.php' == basename ( $page_template ) ) {
           $template = WP_PLUGIN_DIR . '/side/templates/property-listings.php';
        }
        return $template;
    }
    add_filter ( 'page_template', 'reside_redirect_page_template' );

    /**
     * Call the SIMPLYRETS api and save locally.
     *
     * return array The properties.
     */
    function get_properties_data() : array {
        $args = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode( 'simplyrets' . ':' . 'simplyrets' )
            ],
        ];

        if ( ! get_transient( 'property_listings' ) ) {
            $response = wp_remote_get( 'https://api.simplyrets.com/properties?status=active', $args );
            if ( is_wp_error( $response ) || 404 === $response_code ) {
                return $response;
            }
            $listings = json_decode( wp_remote_retrieve_body( $response ) );

            if ( ! $listings ) {
                return [ 'No properties found.' ];
            }

            set_transient( 'property_listings', $listings, (60*5) ); // HOUR_IN_SECONDS
        }

        $results = build_property_card( $listings );

        return $results;
    }

    /**
     * Build property card
     *
     * @return array the properties.
     */
    function build_property_card( $listings ) {
        $listings = get_transient( 'property_listings' );

        foreach( $listings as $listing ) {
            $listingdate = strtotime( $listing->listDate );
            $listingdate = date( 'n/d/y', $listingdate );

            $half_baths = $listing->property->bathsHalf / 2;
            $baths      = $listing->property->bathsFull + $half_baths;

            $property = [
                'mls_id' => $listing->mlsId,
                'price' => number_format( $listing->listPrice ),
                'image' => $listing->photos[0],
                'bedrooms' => $listing->property->bedrooms,
                'baths' => $baths,
                'footage' => $listing->property->area,
                'list_date' => $listingdate,
                'address' => [
                    'full' => $listing->address->full,
                    'city' => $listing->address->city,
                    'state' => $listing->address->state,
                ],
            ];

            $properties[] = $property;
        }

        return $properties;
    }


}