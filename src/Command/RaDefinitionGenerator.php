<?php

namespace Drupal\ra_drupal\Command;

use Drupal\Console\Generator\Generator;

class RaDefinitionGenerator extends Generator{

  static public function idToClass($id) {
    return str_replace('.', '', ucwords($id, '.')) . 'Definition';
  }

  private function idToDefinitionId($id) {
    $id = ucwords($id, '.');
    $words = explode('.', $id);
    $definition_id = strtolower($words[0]) . '.' . strtolower($words[1]);
    return $definition_id . implode('', array_slice($words, 2));
  }

  public function generate($module, $id, $description) {
    $template = 'generate-ra-definition.html.twig';

    $class = self::idToClass($id);

    $parameters = [
      'module' => $module,
      'class' => $class,
      'id' => $this->idToDefinitionId($id),
      'description' => $description,
    ];

    $target = $this->getSite()->getModulePath($module) . '/src/Plugin/RaDefinition/' . $class . '.php';

    $this->renderFile(
      $template,
      $target,
      $parameters
    );
  }

}