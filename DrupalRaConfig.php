<?php

namespace Emerap\Ra;

use Emerap\Ra\Base\Base;

class RaConfig extends Base {

  /**
   * {@inheritdoc}
   */
  public static function getEngine() {
    return 'Drupal 8.x';
  }

  /**
   * {@inheritdoc}
   */
  public static function getUserID($user_id = NULL) {
    return \Drupal::currentUser()->getAccount()->id();
  }

  /**
   * {@inheritdoc}
   */
  public static function getRaDatabaseClass() {
    return 'Drupal\ra_drupal\RaDrupalDatabase';
  }

  /**
   * {@inheritdoc}
   */
  public static function getDatatypes() {
    /** @var \Drupal\ra_drupal\RaDatatypeManager $manager */
    $manager = \Drupal::service('plugin.manager.ra.data_type');
    $types = [];

    foreach ($manager->getDefinitions() as $id => $definition) {
      /** @var \Drupal\ra_drupal\RaFormatBase $instance */
      $instance = $manager->createInstance($id);
      $types[$id] = $instance;
    }
    return array_merge($types, self::getCoreDatatypes());
  }

  /**
   * {@inheritdoc}
   */
  public static function getDefinitions() {

    /** @var \Drupal\ra_drupal\RaDefinitionManager $manager */
    $manager = \Drupal::service('plugin.manager.ra.definition');
    $definitions = [];

    foreach ($manager->getDefinitions() as $id => $definition) {
      /** @var \Drupal\ra_drupal\RaDefinitionBase $instance */
      $instance = $manager->createInstance($id);

      $definition = self::instanceDefinition();
      $definition->setName($id)
        ->setMethodCallback($instance, 'execute')
        ->setMethodParams($instance->getMethodParams())
        ->setSecurity(!$instance->isPublic())
        ->setSection($instance->getSection())
        ->setAccessCallback($instance->getAccessCallback())
        ->setAccessArguments($instance->getAccessParams())
        ->setDescription($instance->getDescription());

      $definitions[$id] = $definition;
    }
    return array_merge($definitions, self::getCoreDefinitions());
  }

  /**
   * {@inheritdoc}
   */
  public static function getFormats() {

    /** @var \Drupal\ra_drupal\RaFormatManager $manager */
    $manager = \Drupal::service('plugin.manager.ra.format');
    $formats = [];

    foreach ($manager->getDefinitions() as $id => $definition) {
      /** @var \Drupal\ra_drupal\RaFormatBase $instance */
      $instance = $manager->createInstance($id);

      $formats[$id] = $instance;
    }
    return array_merge($formats, self::getCoreFormats());
  }

}
