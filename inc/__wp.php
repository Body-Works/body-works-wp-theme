<?php
/**
 * WP hooks strictly.
 *
 * Do not modify files here! Use repository like a civilized programmer.
 * Mess with the best, die like the rest! Hack the planet!
 *
 * @author Konrad Fedorczyk <contact@realhe.ro>
 * @link https://github.com/fedek6/body-works
 */
add_filter( 'wp_check_filetype_and_ext', function($types, $file, $filename, $mimes) {

  foreach (BwConfig::$allowedMimes as $ext => $mime) {
    if ( false !== strpos( $filename, ".{$ext}" ) ) {
      $types['ext'] = $ext;
      $types['type'] = $mime;
    }
  }

  return $types;
}, 10, 4 );

// Allow mimetypes uploads
add_filter('upload_mimes', function($existing_mimes) {
  foreach (BwConfig::$allowedMimes as $ext => $mime) {
    $existing_mimes[$ext] = $mime;
  }

  return $existing_mimes;
});
