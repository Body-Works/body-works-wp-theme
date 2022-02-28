<?php
/**
 * Get modifier for text depending
 * on its length.
 *
 * @param int $length
 * @return string
 */
function bwGetFontSizeModifier(int $length): string
{
  $modifier = "";

  // Fine tune font size
  if ($length >= 80) {
    $modifier .= "--xsmall";
  } elseif ($length >= 60) {
    $modifier .= "--small";
  } elseif ($length >= 50) {
    $modifier .= "--medium";
  }

  return $modifier;
}
