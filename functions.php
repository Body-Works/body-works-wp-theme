<?php
define("TEMPLATE_VERSION", "1.0.0");

/**
 * Load child theme style.
 */
add_action('wp_enqueue_scripts', 'body_works_enqueue_styles');
function body_works_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css', [], TEMPLATE_VERSION);
}
