<?php

namespace Drupal\ra_drupal;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the RA Format plugin manager.
 */
class RaFormatManager extends DefaultPluginManager {

  /**
   * Constructor for RaFormatManager objects.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/RaFormat', $namespaces, $module_handler, 'Drupal\ra_drupal\RaFormatInterface', 'Drupal\ra_drupal\Annotation\RaFormat');
    $this->alterInfo('ra_drupal_format_info');
    $this->setCacheBackend($cache_backend, 'ra_drupal_format_plugins');
  }

}
