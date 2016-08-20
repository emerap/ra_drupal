<?php

namespace Drupal\ra_docs\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Emerap\Ra\RaConfig;

/**
 * Class RaDocsController.
 *
 * @package Drupal\ra_docs\Controller
 */
class RaDocsController extends ControllerBase {
  /**
   * Docs main page.
   *
   * @return string
   *   Return Hello string.
   */
  public function docs_main() {

    $build = [];

    $build['greeting'] = [
      '#markup' => '',
    ];

    $build['available_methods'] = [
      '#type' => 'theme',
      '#theme' => 'ra_docs_section',
      '#label' => 'Methods',
      '#items' => $this->getAvailableMethods(),
    ];

    $build['available_data-types'] = [
      '#type' => 'theme',
      '#theme' => 'ra_docs_section',
      '#label' => 'DataTypes',
      '#items' => $this->getAvailableDataTypes(),
    ];

    $build['available_formats'] = [
      '#type' => 'theme',
      '#theme' => 'ra_docs_section',
      '#label' => 'Formats',
      '#items' => $this->getAvailableFormats(),
    ];

    return $build;
  }

  public function docs_method($method) {
    return [
      \Drupal::formBuilder()->getForm('Drupal\ra_docs\Form\RaDocsForm'),
    ];
  }

  public function docsMethodTitle($method) {
    return 'Method - ' . $method;
  }

  private function getAvailableFormats() {
    $items = [];
    foreach (RaConfig::getFormats() as $format) {
      /** @var \Emerap\Ra\Core\FormatInterface $format */
      $items[] = [
        'id' => $format->getType(),
        'title' => $format->getLabel(),
        'description' => $format->getDescription(),
      ];
    }

    return $items;
  }

  private function getAvailableMethods() {
    $items = [];
    foreach (RaConfig::getDefinitions() as $definition) {
      /** @var \Emerap\Ra\Core\Definition $definition  */
      $items[] = [
        'id' => $definition->getName(),
        'title' => $definition->getName(),
        'description' => $definition->getDescription(),
        'url' => Url::fromRoute('ra_docs.method', ['method' => $definition->getName()]),
      ];

    }

    return $items;
  }

  private function getAvailableDataTypes() {
    $items = [];
    foreach (RaConfig::getDatatypes() as $datatype) {
      /** @var \Emerap\Ra\Core\DatatypeInterface $datatype */
      $items[] = [
        'id' => $datatype->getType(),
        'title' => $datatype->getLabel(),
        'description' => $datatype->getDescription(),
      ];
    }

    return $items;
  }

}
