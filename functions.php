<?php
define("TEMPLATE_VERSION", "1.0.0");

/**
 * Load child theme style.
 */
add_action('wp_enqueue_scripts', 'body_works_enqueue_styles');
function body_works_enqueue_styles()
{
	// wp_enqueue_style('body-works-style', get_template_directory_uri() . '/style.css', [], TEMPLATE_VERSION);
	wp_enqueue_style('twentysixteen-style', get_stylesheet_directory_uri() . "/parent.css");
}

/**
 * Remove zoom on products.
 */
add_action('wp', 'njengah_remove_zoom_effect_theme_support', 99);
function njengah_remove_zoom_effect_theme_support()
{
	remove_theme_support('wc-product-gallery-zoom');
	remove_theme_support('wc-product-gallery-lightbox');
	remove_theme_support('wc-product-gallery-slider');
}

/**
 * Loads the child theme textdomain.
 */
function wpdocs_child_theme_setup() {
    load_child_theme_textdomain( 'body_works', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'wpdocs_child_theme_setup' );


// parent-style-css
add_action( 'wp_enqueue_scripts', 'mywptheme_child_deregister_styles', 11 );
function mywptheme_child_deregister_styles() {
    wp_dequeue_style( 'parent-style-css' );
 
}