<?php

namespace Drupal\ra_drupal;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for RA Data Type plugins.
 */
abstract class RaDatatypeBase extends PluginBase implements RaDatatypeInterface {

  /**
   * Get DataType field label
   * @return String
   */
  public function getLabel() {
    return $this->pluginDefinition['label'];
  }

  /**
   * Get DataType field description
   * @return String
   */
  public function getDescription() {
    return $this->pluginDefinition['description'];
  }

  /**
   * Get DataType field type
   * @return String
   */
  public function getType() {
    return $this->pluginDefinition['id'];
  }

}
