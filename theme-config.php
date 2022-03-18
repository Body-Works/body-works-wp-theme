<?php
/**
 * Template "hard" configuration.
 *
 * Do not modify files here! Use repository like a civilized programmer.
 * Mess with the best, die like the rest! Hack the planet!
 *
 * @author Konrad Fedorczyk <contact@realhe.ro>
 * @link https://github.com/fedek6/body-works
 */
define("TEMPLATE_VERSION", "1.0.42");
define("TEMPLATE_VARIANT", "body-works");

abstract class BwConfig {
  /** @var array $logos Logos for the header grid */
  public static $logos = [
    [
      "image"     => "logo-body-works.png?ver=2",
      "url"       => "https://body-works.pl",
      "modifier"  => "--body-works",
    ],
    [
      "image"     => "logo-body-worksout.png?ver=2",
      "url"       => "https://www.bodyworksout.pl/",
      "modifier"  => "--body-worksout",
    ],
    [
      "image"     => "logo-kids-fitness.png?ver=2",
      "url"       => "http://silowniedladzieci.eu/",
      "modifier"  => "--kids-fitness",
    ],
    [
      "image"     => "logo-fit-system.png?ver=2",
      "url"       => "http://fit-system.pl",
      "modifier"  => "--fit-system",
    ],
    [
      "image"     => "logo-fit-energy.png?ver=2",
      "url"       => null,
      "modifier"  => "--fit-energy",
    ],
  ];

  /** @var int $hederHeight Category header height */
  public static $headerHeight = 180;

  /** @var array $allowedMimes Allowed mimetypes */
  public static $allowedMimes = [
    '3ds' => 'image/x-3ds',
    'dwg' => 'image/vnd.dwg',
    'max' => 'application/CDFV2',
    'skp' => 'application/octet-stream'
  ];

  /** @var string $gaId Google analytics id */
  public static $gaId = "UA-16322686-4";
}
