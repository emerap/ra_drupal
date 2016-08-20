<?php

namespace Drupal\ra_drupal\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a RA Data Type item annotation object.
 *
 * @see \Drupal\ra\Plugin\RaDataTypeManager
 * @see plugin_api
 *
 * @Annotation
 */
class RaDatatype extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

  public $description;

}
