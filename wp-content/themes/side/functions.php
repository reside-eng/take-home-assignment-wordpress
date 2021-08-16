<?php

if ( ! function_exists('side_theme_setup') ) {

    add_action( 'wp_enqueue_scripts', 'side_theme_setup' );

    function side_theme_setup() {
        wp_enqueue_style(
            'side-theme-styles',
            get_stylesheet_directory_uri() . '/build/style.css',
            array( 'twenty-twenty-one-style' ),
            filemtime(get_stylesheet_directory() . '/build/style.css')
        );
    
        wp_enqueue_script( 
            'side-theme-scripts', 
            get_stylesheet_directory_uri() . '/build/scripts.js',
            array( 'jquery' ),
            filemtime(get_stylesheet_directory() . '/build/scripts.js'),
            true
        );
    }
}