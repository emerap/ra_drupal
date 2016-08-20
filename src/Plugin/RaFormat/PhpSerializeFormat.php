<?php

namespace Drupal\ra_drupal\Plugin\RaFormat;

use Drupal\ra_drupal\RaFormatBase;

/**
 * @RaFormat(
 *   id = "php-serialize",
 *   label = @Translation("Php serialize"),
 *   description = @Translation("Php serialize object"),
 *   mime_type = "text/plain"
 * )
 */
class PhpSerializeFormat extends RaFormatBase {
  
  /**
   * Convert object to format
   * @param mixed $object
   * @return mixed
   */
  public function convert($object) {
    return serialize($object);
  }
}