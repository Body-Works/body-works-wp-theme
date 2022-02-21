<?php
define("TEMPLATE_VERSION", "1.0.8");
define("TEMPLATE_VARIANT", "body-works");

/**
 * Load child theme style.
 */
add_action('wp_enqueue_scripts', 'body_works_enqueue_styles');
function body_works_enqueue_styles()
{
	// wp_enqueue_style('body-works-style', get_template_directory_uri() . '/style.css', [], TEMPLATE_VERSION);
	wp_enqueue_style('twentysixteen-style', get_stylesheet_directory_uri() . "/parent.css");
}

//
function change_childtheme_stylesheet_ver()
{
	wp_dequeue_style('main-styles');
	wp_deregister_style('main-styles');
	wp_enqueue_style('main-styles', get_stylesheet_uri(), [], TEMPLATE_VERSION);
}
add_action('wp_print_styles', 'change_childtheme_stylesheet_ver');

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
function wpdocs_child_theme_setup()
{
	load_child_theme_textdomain('body_works', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'wpdocs_child_theme_setup');


// parent-style-css
add_action('wp_enqueue_scripts', 'mywptheme_child_deregister_styles', 11);
function mywptheme_child_deregister_styles()
{
	wp_dequeue_style('parent-style-css');
}

/**
 * Reorder templates in a single product view.
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
// Let's pack it in an additional div
add_action('woocommerce_before_single_product_summary', function () {
	echo "<div class='bw-custom-add-to-cart-wrapper'>";
}, 20);
add_action('woocommerce_before_single_product_summary', 'woocommerce_template_single_add_to_cart', 21);
add_action('woocommerce_before_single_product_summary', function () {
	echo "</div>";
}, 22);


/**
 * Change look of cart
 */
function bw_woocommerce_header_add_to_cart_fragment($fragments)
{
	global $woocommerce;

	ob_start(); ?>
	<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>">
		<div class="cart-icon-wrap">

			<div class="bw-btn-primary engage-shake">
				<?= __("Evaluation", "body_works"); ?>
			</div>

			<div class="cart-wrap">
				<span>
					<?php echo $woocommerce->cart->cart_contents_count; ?>
				</span>
			</div>
		</div>
	</a>
<?php

	$fragments['a.cart-contents'] = ob_get_clean();

	return $fragments;
}

// Remove parent filters
add_action('after_setup_theme', function () {
	remove_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
	remove_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

  // Disable salient product listing
  remove_action('woocommerce_before_shop_loop_item_title', 'product_thumbnail_minimal');
});


add_filter('add_to_cart_fragments', 'bw_woocommerce_header_add_to_cart_fragment');
add_filter('woocommerce_add_to_cart_fragments', 'bw_woocommerce_header_add_to_cart_fragment');

/**
 * Add a custom product listing.
 *
 */
add_action('woocommerce_before_shop_loop_item_title', function() {
  global $product;
  global $woocommerce;
  global $product_hover_alt_image;
  global $nectar_quick_view_in_use;

  require __DIR__ . '/custom-themes/product-thumbnail-minimal.php';
}, 10 );

/**
 * Replace mini cart buttons
 */

// Remove original buttons
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

// Add custom ones
add_action('woocommerce_widget_shopping_cart_buttons', function () {
	echo '<a style="text-transform: uppercase !important" href="' . esc_url(wc_get_cart_url()) . '" class="button wc-forward">' . __('Selected items', 'body_works') . '</a>';
}, 10);
add_action('woocommerce_widget_shopping_cart_buttons', function () {
	echo '<a style="text-transform: uppercase !important" href="' . esc_url(wc_get_checkout_url()) . '" class="button checkout wc-forward">' . __('Evaluate the products', 'body_works') . '</a>';
}, 20);

/**
 * Customize empty card message.
 */
remove_action('woocommerce_cart_is_empty', 'wc_empty_cart_message', 10);
add_action('woocommerce_cart_is_empty', 'custom_empty_cart_message', 10);

function custom_empty_cart_message()
{
	$html  = '<p class="cart-empty bw-custom-notification">';
	$html .= wp_kses_post(apply_filters('wc_empty_cart_message', __('Please choose your items before a price evaluation.<br>You can do this by using product catalog:', 'body_works')));
	echo $html . '</p>';
}
