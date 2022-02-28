<?php

/**
 * Template displaying logo grid on top
 * of website.
 *
 * Do not modify files here! Use repository like a civilized programmer.
 * Mess with the best, die like the rest! Hack the planet!
 *
 * Sorry for the spaghetti! WP sucks.
 *
 * @author Konrad Fedorczyk <contact@realhe.ro>
 * @link https://github.com/fedek6/body-works
 */
?>
<div class="bw-alternative-logo-grid">
  <?php foreach(BwConfig::$logos as $logo): ?>
    <?php if(!is_null($logo['url'])): ?>
      <a class="bw-alternative-logo-grid__column <?= $logo['modifier']; ?>" href="<?= $logo['url']; ?>" target="_blank">
        <img src="<?= get_stylesheet_directory_uri() . "/assets/img/{$logo['image']}" ?>" />
      </a>
    <?php else: ?>
      <div class="bw-alternative-logo-grid__column <?= $logo['modifier']; ?>">
        <img src="<?= get_stylesheet_directory_uri() . "/assets/img/{$logo['image']}" ?>" />
      </div>
    <?php endif; ?>
  <?php endforeach; ?>
</div>
