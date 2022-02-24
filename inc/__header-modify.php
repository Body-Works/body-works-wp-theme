<?php
/**
 * Override header buttons.
 */
function nectar_header_button_items()
{
  global $options;
  global $woocommerce;

  $headerSearch = (!empty($options['header-disable-search']) && $options['header-disable-search'] == '1') ? 'false' : 'true';
  $userAccountBtn = (!empty($options['header-account-button']) && $options['header-account-button'] == '1') ? 'true' : 'false';
  $userAccountBtnURL = (!empty($options['header-account-button-url'])) ? $options['header-account-button-url'] : '';
  $headerFormat = (!empty($options['header_format'])) ? $options['header_format'] : 'default';

  $theme_skin = (!empty($options['theme-skin'])) ? $options['theme-skin'] : 'original';
  if ($headerFormat == 'centered-menu-bottom-bar') {
    $theme_skin = 'material';
  }

  $sideWidgetArea = (!empty($options['header-slide-out-widget-area']) && $headerFormat != 'left-header') ? $options['header-slide-out-widget-area'] : 'off';

  if ($headerSearch != 'false') {
    echo '<li id="search-btn"><div><a href="#searchbox"><span class="icon-salient-search" aria-hidden="true"></span></a></div> </li>';
  }

  if ($userAccountBtn != 'false') {
    echo '<li id="nectar-user-account"><div><a href="' . $userAccountBtnURL . '"><span class="icon-salient-m-user" aria-hidden="true"></span></a></div> </li>';
  }

  // Add a service button
  echo '<li class="bw-additional-header-button">
    <a href="https://body-works.pl/serwis/" class="bw-btn --secondary --wrench-icon">Serwis</a>
  </li>';


  if (!empty($options['enable-cart']) && $options['enable-cart'] == '1' && $theme_skin == 'material') {
    if ($woocommerce) {
      echo '<li class="nectar-woo-cart">' . nectar_header_cart_output() . '</li>';
    }
  }


  if ($sideWidgetArea == '1') {
    echo '<li class="slide-out-widget-area-toggle" data-icon-animation="simple-transform">';
    echo '<div> <a href="#sidewidgetarea" class="closed"> <span> <i class="lines-button x2"> <i class="lines"></i> </i> </span> </a> </div>';
    echo '</li>';
  }
}
