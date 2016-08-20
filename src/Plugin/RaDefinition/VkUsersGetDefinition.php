<?php

namespace Drupal\ra_drupal\Plugin\RaDefinition;

use Drupal\ra_drupal\RaDefinitionBase;
use Emerap\Ra\RaConfig;

/**
 *
 * @RaDefinition(
 *   id = "vk.usersGet",
 *   description = @Translation("Возвращает расширенную информацию о пользователях")
 * )
 */
class VkUsersGetDefinition extends RaDefinitionBase {

  public function execute($params) {
    return $params['vk_user'];
  }

  public function getMethodParams() {
    return [
      RaConfig::instanceParam('vk_user', NULL, 'vk_user'),
    ];
  }

}