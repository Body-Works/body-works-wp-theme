<?php

/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

/** @var string $cssModifier */
$cssModifier = '--no-variant';

/** @var mixed $model */
$model = get_field("model");

// Let's determine additional classes
if (get_field("variant")) {
  $cssModifier = '--' . get_field("variant");
}

?>

<div class='bw-custom-product-description <?= $cssModifier ?>'>
  <h1><?= get_the_title() ?></h1>
<?php if ($model): ?>
  <h2><?= get_field("model"); ?></h2>
<?php endif; ?>
</div>

