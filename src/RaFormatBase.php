<?php

namespace Drupal\ra_drupal;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for RA Format plugins.
 */
abstract class RaFormatBase extends PluginBase implements RaFormatInterface {
  
  /**
   * Get format title
   * @return string
   */
  public function getLabel() {
    return $this->pluginDefinition['label'];
  }

  /**
   * Get format type
   * @return string
   */
  public function getType() {
    return $this->pluginDefinition['id'];
  }

  /**
   * Get format description
   * @return string
   */
  public function getDescription() {
    return $this->pluginDefinition['description'];
  }

  /**
   * Get format mime-type
   * @return string
   */
  public function getMimeType() {
    return $this->pluginDefinition['mime_type'];
  }

  /**
   * Check requirements
   * @return bool
   */
  public function requirements() {
    return true;
  }
}
