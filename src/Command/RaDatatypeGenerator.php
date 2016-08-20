<?php

namespace Drupal\ra_drupal\Command;

use Drupal\Console\Generator\Generator;

class RaDatatypeGenerator extends Generator{
  public function generate($module, $id, $description, $label) {
    $template = 'generate-ra-datatype.html.twig';

    $class = ucfirst($id) . 'Type';

    $parameters = [
      'module' => $module,
      'class' => $class,
      'id' => $id,
      'description' => $description,
      'label' => $label,
    ];

    $target = $this->getSite()->getModulePath($module) . '/src/Plugin/RaDatatype/' . $class . '.php';

    $this->renderFile(
      $template,
      $target,
      $parameters
    );
  }
}