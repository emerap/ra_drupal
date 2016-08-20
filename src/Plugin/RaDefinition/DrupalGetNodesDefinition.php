<?php

namespace Drupal\ra_drupal\Plugin\RaDefinition;

use Drupal\ra_drupal\RaDefinitionBase;

/**
 *
 * @RaDefinition(
 *   id = "drupal.getNodes",
 *   description = @Translation("get all nodes")
 * )
 */
class DrupalGetNodesDefinition extends RaDefinitionBase {

  public function execute($params) {
    return \Drupal::database()->select('node', 'n')
      ->fields('n', ['nid'])
      ->execute()->fetchAll();
  }

  public function isPublic() {
    return FALSE;
  }

  public function getSection() {
    return 'Drupal';
  }

}
