<?php
/*
Plugin Name: Side
Version: 1.0.0
Author: Side
License: GPLv2 or later
Text Domain: side
*/

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
}