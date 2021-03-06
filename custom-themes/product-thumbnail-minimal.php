<?php
/**
 * Template for custom thumbnail view.
 *
 * Do not modify files here! Use repository like a civilized programmer.
 * Mess with the best, die like the rest! Hack the planet!
 *
 * @author Konrad Fedorczyk <contact@realhe.ro>
 * @link https://github.com/fedek6/body-works
 */
$product = wc_get_product();
?>
<div class="background-color-expand"></div>
<div class="bw-single-product product-wrap">
  <?php

  $product_second_image = null;
  if ($product_hover_alt_image == '1') {

    if ($woocommerce && version_compare($woocommerce->version, "3.0", ">=")) {
      $product_attach_ids = $product->get_gallery_image_ids();
    } else {
      $product_attach_ids = $product->get_gallery_attachment_ids();
    }

    if (isset($product_attach_ids[0]))
      $product_second_image = wp_get_attachment_image($product_attach_ids[0], 'shop_catalog', false, array('class' => 'hover-gallery-image'));
  }

  echo '<a class="bw-single-product__thumb" href="' . get_permalink() . '">';
  echo  woocommerce_get_product_thumbnail() . $product_second_image;
  echo '</a>';


  echo '<div class="product-meta">';
  echo '<a href="' . get_permalink() . '">';
  do_action('woocommerce_shop_loop_item_title');
  echo '</a>';
  do_action('woocommerce_after_shop_loop_item_title');
  echo '<div class="price-hover-wrap">';

  // Show price in shop mode
  if (BwConfig::$shopMode) {
    echo "<div class='bw-single-product__price'>";
    do_action('nectar_woo_minimal_price');
    echo "</div>";
  }

  echo '<div class="product-add-to-cart" data-nectar-quickview="' . $nectar_quick_view_in_use . '">';
  woocommerce_template_loop_add_to_cart();
  do_action('nectar_woocommerce_before_add_to_cart');
  echo '</div></div></div>'; ?>
</div>
