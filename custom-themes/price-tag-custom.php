<?php
/**
 * Template for custom price tag in single product view.
 *
 * Do not modify files here! Use repository like a civilized programmer.
 * Mess with the best, die like the rest! Hack the planet!
 *
 * @author Konrad Fedorczyk <contact@realhe.ro>
 * @link https://github.com/fedek6/body-works
 */
$product = wc_get_product();
?>

<div class="bw-custom-price-tag">
  <?= $product->get_price_html(); ?>
</div>
