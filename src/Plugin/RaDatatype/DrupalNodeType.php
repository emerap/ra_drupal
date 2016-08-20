<?php

namespace Drupal\ra_drupal\Plugin\RaDataType;

use Drupal\node\Entity\Node;
use Drupal\ra_drupal\RaDatatypeBase;

/**
 * @RaDataType(
 *   id = "drupal_node",
 *   label = @Translation("Drupal node object"),
 *   description = @Translation("Get drupal node object by nid")
 * )
 */
class DrupalNodeType extends RaDatatypeBase {

 /**
   * Check value.
   *
   * @param string|int|float|bool $value
   * @param \Emerap\Ra\Core\Definition $definition
   * @return \Emerap\Ra\Core\Error|bool
   */
 public function check(&$value, $definition) {
    if ($node = Node::load($value)) {
      $value = $node;
      return true;
    }

    return false;
 }

}