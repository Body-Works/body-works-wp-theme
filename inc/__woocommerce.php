<?php

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
 * Change a look of cart
 */
function bw_woocommerce_header_add_to_cart_fragment($fragments)
{
  global $woocommerce;

  ob_start(); ?>
  <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>">
    <div class="cart-icon-wrap bw-cart-icon-wrap">

      <div class="bw-btn --primary engage-shake">
        <?= __("Evaluation", "body_works"); ?>
      </div>

      <div class="cart-wrap bw-cart-wrap-item-count">
        <div>
          <?php echo $woocommerce->cart->cart_contents_count; ?>
        </div>
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
add_action('woocommerce_before_shop_loop_item_title', function () {
  global $product;
  global $woocommerce;
  global $product_hover_alt_image;
  global $nectar_quick_view_in_use;

  require __DIR__ . '/../custom-themes/product-thumbnail-minimal.php';
}, 10);

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

/**
 * Add product moodel to the title
 */
add_action('woocommerce_shop_loop_item_title', function () {
  $model = get_field("model");

  if ($model && $model = esc_html($model)) {
    echo "<h3 class='woocommerce-loop-product__model'>{$model}</h3>";
  }
}, 9);

/**
 * Show the product title in the product loop. By default this is an H2.
 */
function woocommerce_template_loop_product_title()
{
  /** @var string $title */
  $title = get_the_title();

  /** @var string $classes */
  $classes = '';

  /** @var integer $length */
  $length = strlen($title);

  // Fine tune font size
  $classes .= bwGetFontSizeModifier($length);

  echo "<h2 class=\"bw-product-title  $classes " . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')) . '">' . get_the_title() . '</h2>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}


/**
 * Woocommerce sort by model.
 */
add_filter('woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args');
function custom_woocommerce_get_catalog_ordering_args($args)
{
  $orderby_value = isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby'));
  if ('model' == $orderby_value) {
    $args['orderby'] = 'meta_value title';
    $args['order'] = 'ASC';
    $args['meta_key'] = 'model';
  }
  return $args;
}


add_filter('woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby');
add_filter('woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby');
function custom_woocommerce_catalog_orderby($sortby)
{
  $sortby['model'] = 'Model';
  return $sortby;
}

add_filter('woocommerce_default_catalog_orderby', 'custom_default_catalog_orderby');
function custom_default_catalog_orderby()
{
  return 'model';
}

/**
 * Generate automatic order meta.
 * Using model create data for ordering.
 */
add_action('save_post', 'set_automatic_product_ordering', 10, 3);
function set_automatic_product_ordering($post_id, $post)
{
  if ('product' !== $post->post_type) {
    return;
  }

  $model = get_field("model");

  if ($model) {
    $matches = [];
    preg_match("/[0-9]+[a-z_]*[0-9]*/im", $model, $matches);

    if (!empty($matches)) {
      update_field("order", $matches[0], $post_id);
    } else {
      update_field("order", $model, $post_id);
    }
  }
}

/**
 * Add model column to products.
 */
add_filter('manage_product_posts_columns', 'bw_filter_posts_columns');
function bw_filter_posts_columns($columns)
{
  $columns['model'] = "Model";
  // $columns['order'] = "Order";
  return $columns;
}

add_action('manage_product_posts_custom_column', 'bw_pop_column', 10, 2);
function bw_pop_column($column, $post_id)
{
  switch ($column) {
    case "model":
      echo get_field("model", $post_id);
      break;

    // Note needded any more
    /* case "order":
      echo get_field("order", $post_id);
      break; */
  }
}
