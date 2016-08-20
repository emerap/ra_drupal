<?php

namespace Drupal\ra_drupal\Plugin\RaDataType;

use Drupal\ra_drupal\RaDatatypeBase;

/**
 * @RaDatatype(
 *   id = "vk_user",
 *   label = @Translation("Vk user"),
 *   description = @Translation("User object from id or screen name from vk.com")
 * )
 */
class VkUserType extends RaDatatypeBase {

  /**
   * Check value$value = (int) $value;
   *
   * @param String|int|bool $value
   * @param \Emerap\Ra\Core\Definition $definition
   * @return \Emerap\Ra\Core\Error|bool
   */
  public function check(&$value, $definition) {
    $arrContextOptions = array(
      "ssl" => array(
        "verify_peer" => FALSE,
        "verify_peer_name" => FALSE,
      ),
    );

    $vk_req = file_get_contents(
      'https://api.vk.com/method/users.get?user_ids=' . $value,
      FALSE, stream_context_create($arrContextOptions));

    if (($value = json_decode($vk_req)) && isset($value->response)) {
      $value = $value->response;
      return TRUE;
    }
    return FALSE;
  }
}