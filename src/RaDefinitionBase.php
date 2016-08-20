<?php

namespace Drupal\ra_drupal;

use Drupal\Component\Plugin\PluginBase;
use Drupal\user\Entity\User;
use Emerap\Ra\RaConfig;

/**
 * Base class for RaDefinition method plugins.
 */
abstract class RaDefinitionBase extends PluginBase implements RaDefinitionInterface {

  public function getDescription() {
    return $this->pluginDefinition['description'];
  }

  public function getMethodName() {
    $this->pluginDefinition['id'];
  }

  public function getMethodParams() {
    return array();
  }

  public function getModule() {
    return $this->getPluginDefinition()['provider'];
  }

  public function getSection() {
    return 'Custom';
  }

  public function isPublic() {
    return true;
  }

  public function getAccessCallback() {
    $user = User::load(RaConfig::getUserID());
    return [$user, 'hasPermission'];
  }

  public function getAccessParams() {
    return 'access content';
  }

  public function isLog() {
    return FALSE;
  }

}
