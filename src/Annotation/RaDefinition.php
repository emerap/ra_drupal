<?php

namespace Drupal\ra_drupal\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a RaDefinition method item annotation object.
 *
 * @see \Drupal\ra\Plugin\RaMethodManager
 * @see plugin_api
 *
 * @Annotation
 */
class RaDefinition extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * Method description of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $description;

}
