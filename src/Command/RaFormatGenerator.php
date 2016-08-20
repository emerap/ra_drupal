<?php

namespace Drupal\ra_drupal\Command;

use Drupal\Console\Generator\Generator;

class RaFormatGenerator extends Generator{

  public function generate($module, $id, $description, $label, $mime_type) {
    $template = 'generate-ra-format.html.twig';

    $class = ucfirst($id) . 'Format';

    $parameters = [
      'module' => $module,
      'class' => $class,
      'id' => $id,
      'description' => $description,
      'label' => $label,
      'mime_type' => $mime_type,
    ];

    $target = $this->getSite()->getModulePath($module) . '/src/Plugin/RaFormat/' . $class . '.php';

    $this->renderFile(
      $template,
      $target,
      $parameters
    );
  }
}