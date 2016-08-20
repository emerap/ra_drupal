<?php

namespace Drupal\ra_drupal\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a RA Format item annotation object.
 *
 * @see \Drupal\ra\Plugin\RaFormatManager
 * @see plugin_api
 *
 * @Annotation
 */
class RaFormat extends Plugin {

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

  /**
   * The label of the format.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $description;

  /**
   * Format MIME type.
   *
   * @var string
   */
  public $mime_type;

}
