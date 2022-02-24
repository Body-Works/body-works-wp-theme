<?php

/**
 * Override category header.
 */
function nectar_page_header($postid)
{

  global $options;
  global $post;
  global $nectar_theme_skin;
  global $woocommerce;


  $header_auto_title = (!empty($options['header-auto-title']) && $options['header-auto-title'] == '1') ? true : false;
  $bg = get_post_meta($postid, '_nectar_header_bg', true);
  $bg_color = get_post_meta($postid, '_nectar_header_bg_color', true);
  $bg_type = get_post_meta($postid, '_nectar_slider_bg_type', true);
  $height = get_post_meta($postid, '_nectar_header_bg_height', true);
  $font_color = get_post_meta($postid, '_nectar_header_font_color', true);
  $title = get_post_meta($postid, '_nectar_header_title', true);
  $subtitle = get_post_meta($postid, '_nectar_header_subtitle', true);
  $bg_overlay_color = get_post_meta($postid, '_nectar_header_bg_overlay_color', true);

  if ($header_auto_title && is_page() && empty($title)) {
    $title = esc_html(get_the_title());
    if (empty($bg_color)) {
      $bg_color = (!empty($options['overall-bg-color'])) ? $options['overall-bg-color'] : '#ffffff';
    }
    if (empty($bg_overlay_color)) {
      $bg_overlay_color = 'rgba(0,0,0,0.07)';
    }
    if (empty($height)) {
      $height = '225';
    }
  } else {
    $title = get_post_meta($postid, '_nectar_header_title', true);
  }



  if (empty($bg_type)) {
    $bg_type = 'image_bg';
  }

  $early_exit = (isset($post->post_type) && $post->post_type == 'page' && $bg_type == 'image_bg' && empty($bg_color) && empty($bg) && empty($height) && empty($title)) ? true : false;

  $headerRemoveStickiness = (!empty($options['header-remove-fixed'])) ? $options['header-remove-fixed'] : '0';
  $headerFormat = (!empty($options['header_format'])) ? $options['header_format'] : 'default';
  $condense_header_on_scroll = (!empty($options['condense-header-on-scroll']) && $headerFormat == 'centered-menu-bottom-bar' && $headerRemoveStickiness != '1' && $options['condense-header-on-scroll'] == '1') ? 'true' : 'false';

  $fullscreen_rows = get_post_meta($postid, '_nectar_full_screen_rows', true);
  if ($fullscreen_rows == 'on' || $early_exit) {
    return;
  }

  $parallax_bg = get_post_meta($postid, '_nectar_header_parallax', true);

  //woocommerce archives
  if (function_exists('woocommerce_page_title')) {
    if ($woocommerce && is_product_category() || $woocommerce && is_product_tag() || $woocommerce && is_product_taxonomy()) {
      $subtitle = '';
      $title = woocommerce_page_title(false);

      $cate = get_queried_object();
      $t_id = (property_exists($cate, 'term_id')) ? $cate->term_id : '';
      $product_terms =  get_option("taxonomy_$t_id");

      $bg = (!empty($product_terms['product_category_image'])) ? $product_terms['product_category_image'] : $bg;
    }
  }

  $page_template = get_post_meta($postid, '_wp_page_template', true);
  $display_sortable = get_post_meta($postid, 'nectar-metabox-portfolio-display-sortable', true);
  $inline_filters = (!empty($options['portfolio_inline_filters']) && $options['portfolio_inline_filters'] == '1') ? '1' : '0';
  $filters_id = (!empty($options['portfolio_inline_filters']) && $options['portfolio_inline_filters'] == '1') ? 'portfolio-filters-inline' : 'portfolio-filters';
  $text_align = get_post_meta($postid, '_nectar_page_header_alignment', true);
  $text_align_v = get_post_meta($postid, '_nectar_page_header_alignment_v', true);
  $fullscreen_header = (!empty($options['blog_header_type']) && $options['blog_header_type'] == 'fullscreen' && is_singular('post')) ? true : false;
  $post_header_style = (!empty($options['blog_header_type'])) ? $options['blog_header_type'] : 'default';
  $bottom_shadow = get_post_meta($postid, '_nectar_header_bottom_shadow', true);
  $bg_overlay = get_post_meta($postid, '_nectar_header_overlay', true);
  $text_effect = get_post_meta($postid, '_nectar_page_header_text-effect', true);
  $animate_in_effect = (!empty($options['header-animate-in-effect'])) ? $options['header-animate-in-effect'] : 'none';
  (!empty($display_sortable) && $display_sortable == 'on') ? $display_sortable = '1' : $display_sortable = '0';

  //incase no title is entered for portfolio, still show the filters
  if ($page_template == 'template-portfolio.php' && empty($title)) $title = get_the_title($post->ID);


  if ((!empty($bg) || !empty($bg_color) || $bg_type == 'video_bg' || $bg_type == 'particle_bg') && !is_post_type_archive('post')) {

    $social_img_src = (empty($bg)) ? 'none' : $bg;
    $bg = (empty($bg)) ? 'none' : $bg;

    if ($bg_type == 'image_bg' || $bg_type == 'particle_bg') {
      (empty($bg_color)) ? $bg_color = '#000' : $bg_color = $bg_color;
    } else {
      $bg = 'none'; //remove stnd bg image for video BG type
    }
    $bg_color_string = (!empty($bg_color)) ? 'background-color: ' . $bg_color . '; ' : null;

    if ($bg_type == 'particle_bg') {
      $rotate_timing = get_post_meta($postid, '_nectar_particle_rotation_timing', true);
      $disable_explosion = get_post_meta($postid, '_nectar_particle_disable_explosion', true);
      $shapes = get_post_meta($postid, '_nectar_canvas_shapes', true);
      if (empty($shapes)) $bg_type = 'image_bg';
    }
    if ($bg_type == 'video_bg') {
      $video_webm = get_post_meta($postid, '_nectar_media_upload_webm', true);
      $video_mp4 = get_post_meta($postid, '_nectar_media_upload_mp4', true);
      $video_ogv = get_post_meta($postid, '_nectar_media_upload_ogv', true);
      $video_image = get_post_meta($postid, '_nectar_slider_preview_image', true);
    }
    $box_roll = get_post_meta($postid, '_nectar_header_box_roll', true);
    if (!empty($options['boxed_layout']) && $options['boxed_layout'] == '1' || $condense_header_on_scroll == 'true') $box_roll = 'off';
    $bg_position = get_post_meta($postid, '_nectar_page_header_bg_alignment', true);
    if (empty($bg_position)) $bg_position = 'top';

    if ($post_header_style == 'default_minimal' && (isset($post->post_type) && $post->post_type == 'post' && is_single())) {
      $height = (!empty($height)) ? preg_replace('/\s+/', '', $height) : 550;
    } else {
      $height = (!empty($height)) ? preg_replace('/\s+/', '', $height) : 350;
    }

    //mobile padding calc
    if (intval($height) < 350) {
      $mobile_padding_influence = 'low';
    } else if (intval($height) < 600) {
      $mobile_padding_influence = 'normal';
    } else {
      $mobile_padding_influence = 'high';
    }

    $not_loaded_class = ($nectar_theme_skin != 'ascend') ? "not-loaded" : null;
    $page_fullscreen_header = get_post_meta($postid, '_nectar_header_fullscreen', true);
    $fullscreen_class = ($fullscreen_header == true || $page_fullscreen_header == 'on') ? "fullscreen-header" : null;
    $bottom_shadow_class = ($bottom_shadow == 'on') ? " bottom-shadow" : null;
    $bg_overlay_class = ($bg_overlay == 'on') ? " bg-overlay" : null;
    $ajax_page_loading = (!empty($options['ajax-page-loading']) && $options['ajax-page-loading'] == '1') ? true : false;

    $hentry_post_class = (isset($post->post_type) && $post->post_type == 'post' && is_single()) ? ' hentry' : '';

    if ($animate_in_effect == 'slide-down') {
      $wrapper_height_style = null;
    } else {
      $wrapper_height_style = 'style="height: ' . $height . 'px;"';
    }
    if ($fullscreen_header == true && ($post->post_type == 'post' && is_single()) || $page_fullscreen_header == 'on') $wrapper_height_style = null; //diable slide down for fullscreen headers

    $force_transparent_header_color = (isset($post->ID)) ? get_post_meta($post->ID, '_force_transparent_header_color', true) : '';
    if (empty($force_transparent_header_color)) {
      $force_transparent_header_color = 'light';
    }

    $midnight_non_parallax = (!empty($parallax_bg) && $parallax_bg == 'on') ? null : 'data-midnight="light"';
    $regular_page_header_midnight_override = 'data-midnight="' . $force_transparent_header_color . '"';

    if ($box_roll != 'on') {
      echo '<div id="page-header-wrap" data-animate-in-effect="' . $animate_in_effect . '" data-midnight="' . $force_transparent_header_color . '" class="' . $fullscreen_class . '" ' . $wrapper_height_style . '>';
    }
    if (!empty($box_roll) && $box_roll == 'on') {
      wp_enqueue_style('box-roll');
      echo '<div class="nectar-box-roll">';
    }

    //starting fullscreen height
    ////conditional checking pages and posts
    if ($page_fullscreen_header == 'on' || $fullscreen_header == true) {
      $starting_height = ' ';
    } else {
      $starting_height = 'height:' . $height . 'px;';
    }


?>
    <div class="<?php echo $not_loaded_class . ' ' . $fullscreen_class . $bottom_shadow_class . $hentry_post_class . $bg_overlay_class; ?>" <?php if (isset($post->post_type) && $post->post_type == 'post' && is_single()) echo 'data-post-hs="' . $post_header_style . '"'; ?> data-padding-amt="<?php echo $mobile_padding_influence; ?>" data-animate-in-effect="<?php echo $animate_in_effect; ?>" id="page-header-bg" <?php echo $regular_page_header_midnight_override; ?> data-text-effect="<?php echo $text_effect; ?>" data-bg-pos="<?php echo $bg_position; ?>" data-alignment="<?php echo (!empty($text_align)) ? $text_align : 'left'; ?>" data-alignment-v="<?php echo (!empty($text_align_v)) ? $text_align_v : 'middle'; ?>" data-parallax="<?php echo (!empty($parallax_bg) && $parallax_bg == 'on') ? '1' : '0'; ?>" data-height="<?php echo (!empty($height)) ? $height : '350'; ?>" style="<?php echo $bg_color_string; ?> <?php echo $starting_height; ?>">

      <?php

      if (!empty($bg) && $bg != 'none') { ?><div class="page-header-bg-image-wrap" id="nectar-page-header-p-wrap" data-parallax-speed="medium">
          <div class="page-header-bg-image" style="background-image: url(<?php echo $bg; ?>);"></div>
        </div> <?php  }

              if (!empty($bg_overlay_color)) { ?><div class="page-header-overlay-color" style="background-color: <?php echo $bg_overlay_color; ?>;"></div> <?php }  ?>

      <?php if ($bg_type != 'particle_bg') {
        echo '<div class="container">';
      }


      if ($post->ID != 0 && $post->post_type && $post->post_type == 'portfolio') { ?>

        <div class="row project-title">
          <div class="container">
            <div class="col span_6 section-title <?php if (empty($options['portfolio_social']) || $options['portfolio_social'] == 0 || empty($options['portfolio_date']) || $options['portfolio_date'] == 0) echo 'no-date' ?>">
              <div class="inner-wrap">
                <h1><?php the_title(); ?></h1>
                <?php if (!empty($subtitle)) { ?> <span class="subheader"><?php echo $subtitle; ?></span> <?php } ?>

                <?php

                global $options;
                $single_nav_pos = (!empty($options['portfolio_single_nav'])) ? $options['portfolio_single_nav'] : 'in_header';

                if ($single_nav_pos == 'in_header') project_single_controls(); ?>
              </div>
            </div>
          </div>

        </div>
        <!--/row-->







      <?php } elseif ($post->ID != 0 && $post->post_type == 'post' && is_single()) {

        // also set as an img for social sharing/
        if ($social_img_src != 'none') echo '<img class="hidden-social-img" src="' . $social_img_src . '" alt="' . get_the_title() . '" />';

      ?>

        <div class="row">

          <div class="col span_6 section-title blog-title">
            <div class="inner-wrap">

              <?php
              global $options;
              $theme_skin = (!empty($options['theme-skin'])) ? $options['theme-skin'] : 'default';

              if (($post->post_type == 'post' && is_single()) && $post_header_style == 'default_minimal' ||
                ($post->post_type == 'post' && is_single()) && $fullscreen_header == true && $theme_skin == 'material'
              ) {

                $categories = get_the_category();
                if (!empty($categories)) {
                  $output = null;
                  foreach ($categories as $category) {
                    $output .= '<a class="' . $category->slug . '" href="' . esc_url(get_category_link($category->term_id)) . '" >' . esc_html($category->name) . '</a>';
                  }
                  echo trim($output);
                }
              } ?>

              <h1 class="entry-title"><?php the_title(); ?></h1>

              <?php if (($post->post_type == 'post' && is_single()) && $fullscreen_header == true) { ?>
                <div class="author-section">
                  <span class="meta-author">
                    <?php if (function_exists('get_avatar')) {
                      echo get_avatar(get_the_author_meta('email'), 100);
                    } ?>
                  </span>
                  <div class="avatar-post-info vcard author">
                    <span class="fn"><?php the_author_posts_link(); ?></span>
                    <span class="meta-date date updated"><i><?php echo get_the_date(); ?></i></span>
                  </div>
                </div>
              <?php } ?>


              <?php if ($fullscreen_header != true) { ?>
                <div id="single-below-header">
                  <span class="meta-author vcard author"><span class="fn"><?php echo __('By', 'salient'); ?> <?php the_author_posts_link(); ?></span></span>
                  <!--
                  --><span class="meta-date date updated"><?php echo get_the_date(); ?></span>
                  <!--
                  --><?php if ($post_header_style != 'default_minimal') { ?> <span class="meta-category"><?php the_category(', '); ?></span> <?php } else { ?>
                    <!--
                  --><span class="meta-comment-count"><a href="<?php comments_link(); ?>"> <?php comments_number(__('No Comments', 'salient'), __('One Comment ', 'salient'), __('% Comments', 'salient')); ?></a></span>
                  <?php } ?>
                </div>
                <!--/single-below-header-->
              <?php } ?>

              <?php if ($fullscreen_header != true && $post_header_style != 'default_minimal') { ?>

                <div id="single-meta" data-sharing="<?php echo (!empty($options['blog_social']) && $options['blog_social'] == 1) ? '1' : '0'; ?>">
                  <ul>



                    <li class="meta-comment-count">
                      <a href="<?php comments_link(); ?>"><i class="icon-default-style steadysets-icon-chat"></i> <?php comments_number(__('No Comments', 'salient'), __('One Comment ', 'salient'), __('% Comments', 'salient')); ?></a>
                    </li>
                    <li>
                      <?php echo '<span class="n-shortcode">' . nectar_love('return') . '</span>'; ?>
                    </li>
                    <?php
                    $blog_social_style = (!empty($options['blog_social_style'])) ? $options['blog_social_style'] : 'default';

                    if (!empty($options['blog_social']) && $options['blog_social'] == 1 &&  $blog_social_style != 'fixed_bottom_right') {

                      echo '<li class="meta-share-count"><a href="#"><i class="icon-default-style steadysets-icon-share"></i><span class="share-count-total">0</span></a> <div class="nectar-social">';


                      //facebook
                      if (!empty($options['blog-facebook-sharing']) && $options['blog-facebook-sharing'] == 1) {
                        echo "<a class='facebook-share nectar-sharing' href='#' title='" . __('Share this', 'salient') . "'> <i class='fa fa-facebook'></i> <span class='count'></span></a>";
                      }
                      //twitter
                      if (!empty($options['blog-twitter-sharing']) && $options['blog-twitter-sharing'] == 1) {
                        echo "<a class='twitter-share nectar-sharing' href='#' title='" . __('Tweet this', 'salient') . "'> <i class='fa fa-twitter'></i> <span class='count'></span></a>";
                      }
                      //google plus
                      if (!empty($options['blog-google-plus-sharing']) && $options['blog-google-plus-sharing'] == 1) {
                        echo "<a class='google-plus-share nectar-sharing-alt' href='#' title='" . __('Share this', 'salient') . "'> <i class='fa fa-google-plus'></i> <span class='count'>0</span></a>";
                      }

                      //linkedIn
                      if (!empty($options['blog-linkedin-sharing']) && $options['blog-linkedin-sharing'] == 1) {
                        echo "<a class='linkedin-share nectar-sharing' href='#' title='" . __('Share this', 'salient') . "'> <i class='fa fa-linkedin'></i> <span class='count'> </span></a>";
                      }
                      //pinterest
                      if (!empty($options['blog-pinterest-sharing']) && $options['blog-pinterest-sharing'] == 1) {
                        echo "<a class='pinterest-share nectar-sharing' href='#' title='" . __('Pin this', 'salient') . "'> <i class='fa fa-pinterest'></i> <span class='count'></span></a>";
                      }

                      echo '</div></li>';
                    }
                    ?>



                  </ul>

                </div>
                <!--/single-meta-->

              <?php } //end if theme skin default
              ?>
            </div>
          </div>
          <!--/section-title-->
        </div>
        <!--/row-->





      <?php //default
      } else if ($bg_type != 'particle_bg') {

        if (!empty($box_roll) && $box_roll == 'on') {
          $alignment = (!empty($text_align)) ? $text_align : 'left';
          $v_alignment = (!empty($text_align_v)) ? $text_align_v : 'middle';
          echo '<div class="overlaid-content" data-text-effect="' . $text_effect . '" data-alignment="' . $alignment . '" data-alignment-v="' . $v_alignment . '"><div class="container">';
        }

        $empty_title_class = (empty($title) && empty($subtitle)) ? 'empty-title' : '';
      ?>

        <div class="row">
          <div class="col span_6 <?php echo $empty_title_class; ?>">
            <?php
              /**
               * Get term information.
               */
              $term = get_queried_object();

              $alternativeHeader = get_field("alternative-header", $term);
              $subHeader = get_field("sub-header", $term);
            ?>
            <div class="inner-wrap">
            <?php if($alternativeHeader): ?>
              <h1 class="bw-special-category-header">
                <small><?= esc_html($subHeader); ?></small>
                <?= esc_html($alternativeHeader); ?>
              </h1>
            <?php else: ?>
              <?php if (!empty($title)) { ?><h1><?php echo $title; ?></h1> <?php } ?>
              <span class="subheader"><?php echo $subtitle; ?></span>
            <?php endif; ?>
            </div>

            <?php // portfolio filters
            if ($page_template == 'template-portfolio.php' && $display_sortable == '1' && $inline_filters == '0') { ?>
              <div class="<?php echo $filters_id; ?>" instance="0">
                <a href="#" data-sortable-label="<?php echo (!empty($options['portfolio-sortable-text'])) ? $options['portfolio-sortable-text'] : 'Sort Portfolio'; ?>" id="sort-portfolio"><span><?php echo (!empty($options['portfolio-sortable-text'])) ? $options['portfolio-sortable-text'] : __('Sort Portfolio', 'salient'); ?></span> <i class="icon-angle-down"></i></a>
                <ul>
                  <li><a href="#" data-filter="*"><?php echo __('All', 'salient'); ?></a></li>
                  <?php wp_list_categories(array('title_li' => '', 'taxonomy' => 'project-type', 'show_option_none'   => '', 'walker' => new Walker_Portfolio_Filter())); ?>
                </ul>
              </div>
            <?php } ?>
          </div>
        </div>

      <?php if (!empty($box_roll) && $box_roll == 'on') echo '</div></div><!--/overlaid-content-->';
      } ?>



      <?php if ($bg_type != 'particle_bg') {
        echo '</div>';
      } //closing container


      if (($post->ID != 0 && $post->post_type == 'post' && is_single()) && $fullscreen_header == true || $page_fullscreen_header == 'on') {
        $rotate_in_class = ($text_effect == 'rotate_in') ? 'hidden' : null;
        $button_styling = (!empty($options['button-styling'])) ? $options['button-styling'] : 'default';

        $header_down_arrow_style = (!empty($options['header-down-arrow-style'])) ? $options['header-down-arrow-style'] : 'default';

        if ($header_down_arrow_style == 'scroll-animation' || $button_styling == 'slightly_rounded' || $button_styling == 'slightly_rounded_shadow') {
          echo '<div class="scroll-down-wrap no-border"><a href="#" class="section-down-arrow ' . $rotate_in_class . '"><svg class="nectar-scroll-icon" viewBox="0 0 30 45" enable-background="new 0 0 30 45">
                    <path class="nectar-scroll-icon-path" fill="none" stroke="#ffffff" stroke-width="2" stroke-miterlimit="10" d="M15,1.118c12.352,0,13.967,12.88,13.967,12.88v18.76  c0,0-1.514,11.204-13.967,11.204S0.931,32.966,0.931,32.966V14.05C0.931,14.05,2.648,1.118,15,1.118z"></path>
                  </svg></a></div>';
        } else {
          if ($button_styling == 'default') {
            echo '<div class="scroll-down-wrap"><a href="#" class="section-down-arrow ' . $rotate_in_class . '"><i class="icon-salient-down-arrow icon-default-style"> </i></a></div>';
          } else {
            echo '<div class="scroll-down-wrap ' . $rotate_in_class . '"><a href="#" class="section-down-arrow"><i class="fa fa-angle-down top"></i><i class="fa fa-angle-down"></i></a></div>';
          }
        }
      }


      //video bg
      if ($bg_type == 'video_bg') {

        if (floatval(get_bloginfo('version')) >= "3.6") {
          //wp_enqueue_script('wp-mediaelement');
          //wp_enqueue_style('wp-mediaelement');
        } else {
          //register media element for WordPress 3.5
          wp_register_script('wp-mediaelement', get_template_directory_uri() . '/js/mediaelement-and-player.min.js', array('jquery'), '1.0', TRUE);
          wp_register_style('wp-mediaelement', get_template_directory_uri() . '/css/mediaelementplayer.min.css');

          wp_enqueue_script('wp-mediaelement');
          wp_enqueue_style('wp-mediaelement');
        }

        //parse video image
        if (strpos($video_image, "http://") !== false || strpos($video_image, "https://") !== false) {
          $video_image_src = $video_image;
        } else {
          $video_image_src = wp_get_attachment_image_src($video_image, 'full');
          $video_image_src = $video_image_src[0];
        }

        //$poster_markup = (!empty($video_image)) ? 'poster="'.$video_image_src.'"' : null ;
        $poster_markup = null;
        $video_markup = null;

        $video_markup .=  '<div class="video-color-overlay" data-color="' . $bg_color . '"></div>';


        $video_markup .= '

    <div class="mobile-video-image" style="background-image: url(' . $video_image_src . ')"></div>
    <div class="nectar-video-wrap" data-bg-alignment="' . $bg_position . '">


      <video class="nectar-video-bg" width="1800" height="700" ' . $poster_markup . '  preload="auto" loop autoplay muted playsinline>';
        if (!empty($video_webm)) {
          $video_markup .= '<source type="video/webm" src="' . $video_webm . '">';
        }
        if (!empty($video_mp4)) {
          $video_markup .= '<source type="video/mp4" src="' . $video_mp4 . '">';
        }
        if (!empty($video_ogv)) {
          $video_markup .= '<source type="video/ogg" src="' . $video_ogv . '">';
        }

        $video_markup .= '</video>

    </div>';

        echo $video_markup;
      }

      //particle bg
      if ($bg_type == 'particle_bg') {

        wp_enqueue_script('nectarParticles');

        echo '<div class=" nectar-particles" data-disable-explosion="' . $disable_explosion . '" data-rotation-timing="' . $rotate_timing . '"><div class="canvas-bg"><canvas id="canvas" data-active-index="0"></canvas></div>';

        $images = explode(',', $shapes);
        $i = 0;

        if (!empty($shapes)) {

          if (!empty($box_roll) && $box_roll == 'on') {
            $alignment = (!empty($text_align)) ? $text_align : 'left';
            $v_alignment = (!empty($text_align_v)) ? $text_align_v : 'middle';
            echo '<div class="overlaid-content" data-text-effect="' . $text_effect . '" data-alignment="' . $alignment . '" data-alignment-v="' . $v_alignment . '">';
          }

          echo '<div class="container"><div class="row"><div class="col span_6" >';

          foreach ($images as $attach_id) {
            $i++;

            $img = wp_get_attachment_image_src($attach_id, 'full');

            $attachment = get_post($attach_id);
            $shape_meta = array(
              'caption' => $attachment->post_excerpt,
              'title' => $attachment->post_title,
              'bg_color' => get_post_meta($attachment->ID, 'nectar_particle_shape_bg_color', true),
              'color' => get_post_meta($attachment->ID, 'nectar_particle_shape_color', true),
              'color_mapping' => get_post_meta($attachment->ID, 'nectar_particle_shape_color_mapping', true),
              'alpha' => get_post_meta($attachment->ID, 'nectar_particle_shape_color_alpha', true),
              'density' => get_post_meta($attachment->ID, 'nectar_particle_shape_density', true),
              'max_particle_size' => get_post_meta($attachment->ID, 'nectar_particle_max_particle_size', true)
            );
            if (!empty($shape_meta['density'])) {
              switch ($shape_meta['density']) {
                case 'very_low':
                  $shape_meta['density'] = '19';
                  break;
                case 'low':
                  $shape_meta['density'] = '16';
                  break;
                case 'medium':
                  $shape_meta['density'] = '13';
                  break;
                case 'high':
                  $shape_meta['density'] = '10';
                  break;
                case 'very_high':
                  $shape_meta['density'] = '8';
                  break;
              }
            }

            if (!empty($shape_meta['color']) && $shape_meta['color'] == '#fff' || !empty($shape_meta['color']) && $shape_meta['color'] == '#ffffff') $shape_meta['color'] = '#fefefe';

            //data for particle shape
            echo '<div class="shape" data-src="' . nectar_ssl_check($img[0]) . '" data-max-size="' . $shape_meta['max_particle_size'] . '" data-alpha="' . $shape_meta['alpha'] . '" data-density="' . $shape_meta['density'] . '" data-color-mapping="' . $shape_meta['color_mapping'] . '" data-color="' . $shape_meta['color'] . '" data-bg-color="' . $shape_meta['bg_color'] . '"></div>';

            //overlaid content
            echo '<div class="inner-wrap shape-' . $i . '">';
            echo '<h1>' . $shape_meta["title"] . '</h1> <span class="subheader">' . $shape_meta["caption"] . '</span>';
            echo '</div>';
          } ?>

    </div>
    </div>
    </div>

    <div class="pagination-navigation">
      <div class="pagination-current"></div>
      <div class="pagination-dots">
        <?php foreach ($images as $attach_id) {
            echo '<button class="pagination-dot"></button>';
          } ?>
      </div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="690">
      <defs>
        <filter id="goo">
          <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
          <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 69 -16" result="goo"></feColorMatrix>
          <feComposite in="SourceGraphic" in2="goo" operator="atop"></feComposite>
        </filter>
      </defs>
    </svg>

    <?php if (!empty($box_roll) && $box_roll == 'on') echo '</div><!--/overlaid-content-->'; ?>

    </div>
    <!--/nectar particles-->

<?php }
      } //particle bg
?>

</div>

<?php

    echo '</div>';
  } else if (!empty($title) && !is_archive()) { ?>

  <div class="row page-header-no-bg" data-alignment="<?php echo (!empty($text_align)) ? $text_align : 'left'; ?>">
    <div class="container">
      <div class="col span_12 section-title">
        <h1><?php echo $title; ?><?php if (!empty($subtitle)) echo '<span>' . $subtitle . '</span>'; ?></h1>

        <?php // portfolio filters
        if ($page_template == 'template-portfolio.php' && $display_sortable == '1' && $inline_filters == '0') { ?>
          <div class="<?php echo $filters_id; ?>" instance="0">

            <a href="#" data-sortable-label="<?php echo (!empty($options['portfolio-sortable-text'])) ? $options['portfolio-sortable-text'] : 'Sort Portfolio'; ?>" id="sort-portfolio"><span><?php echo (!empty($options['portfolio-sortable-text'])) ? $options['portfolio-sortable-text'] : __('Sort Portfolio', 'salient'); ?></span> <i class="icon-angle-down"></i></a>

            <ul>
              <li><a href="#" data-filter="*"><?php echo __('All', 'salient'); ?></a></li>
              <?php wp_list_categories(array('title_li' => '', 'taxonomy' => 'project-type', 'show_option_none'   => '', 'walker' => new Walker_Portfolio_Filter())); ?>
            </ul>
          </div>
        <?php } ?>

      </div>
    </div>

  </div>

<?php } else if (is_category() || is_tag() || is_date() || is_author()) {

    /*blog archives*/
    $archive_bg_img = (isset($options['blog_archive_bg_image'])) ? nectar_options_img($options['blog_archive_bg_image']) : null;
    $t_id =  get_cat_ID(single_cat_title('', false));
    $terms =  get_option("taxonomy_$t_id");

    $heading = null;
    $subtitle = null;

    if (is_author()) {

      $heading =  get_the_author();
      $subtitle = __('All Posts By', 'salient');
    } else if (is_category()) {

      $heading =  single_cat_title('', false);
      $subtitle = __('Category', 'salient');
    } else if (is_tag()) {

      $heading =  wp_title("", false);
      $subtitle = __('Tag', 'salient');
    } else if (is_date()) {

      if (is_day()) :

        $heading = get_the_date();
        $subtitle = __('Daily Archives', 'salient');

      elseif (is_month()) :

        $heading = get_the_date(_x('F Y', 'monthly archives date format', 'salient'));
        $subtitle = __('Monthly Archives', 'salient');

      elseif (is_year()) :

        $heading =  get_the_date(_x('Y', 'yearly archives date format', 'salient'));
        $subtitle = __('Yearly Archives', 'salient');

      else :
        $heading = __('Archives', 'salient');

      endif;
    } else {
      $heading = wp_title("", false);
    } ?>


  <?php
    //category archive text align
    $blog_type = $options['blog_type'];
    if ($blog_type == null) $blog_type = 'std-blog-sidebar';

    $blog_standard_type = (!empty($options['blog_standard_type'])) ? $options['blog_standard_type'] : 'classic';
    $archive_header_text_align = ($blog_type != 'masonry-blog-sidebar' && $blog_type != 'masonry-blog-fullwidth' && $blog_type != 'masonry-blog-full-screen-width' && $blog_standard_type == 'minimal') ? 'center' : 'left';

    if (!empty($terms['category_image']) || !empty($archive_bg_img)) {

      $bg_img = $archive_bg_img;
      if (!empty($terms['category_image'])) $bg_img = $terms['category_image'];

      if ($animate_in_effect == 'slide-down') {
        $wrapper_height_style = null;
      } else {
        $wrapper_height_style = 'style="height: 350px;"';
      }
  ?>

    <div id="page-header-wrap" data-midnight="light" <?php echo $wrapper_height_style; ?>>
      <div id="page-header-bg" data-animate-in-effect="<?php echo $animate_in_effect; ?>" id="page-header-bg" data-text-effect="" data-bg-pos="center" data-alignment="<?php echo $archive_header_text_align; ?>" data-alignment-v="middle" data-parallax="0" data-height="350" style="height: 350px;">

        <div class="page-header-bg-image" style="background-image: url(<?php echo $bg_img; ?>);"></div>

        <div class="container">
          <div class="row">
            <div class="col span_6">
              <div class="inner-wrap">
                <span class="subheader"><?php echo $subtitle; ?></span>
                <h1><?php echo $heading; ?></h1>
              </div>

            </div>
          </div>

        </div>
      </div>

    </div>
  <?php } else { ?>


    <div class="row page-header-no-bg" data-alignment="<?php echo (!empty($text_align)) ? $text_align : 'left'; ?>">
      <div class="container">
        <div class="col span_12 section-title">
          <span class="subheader"><?php echo $subtitle; ?></span>
          <h1><?php echo $heading; ?></h1>
        </div>
      </div>

    </div>


<?php }
  }
}
