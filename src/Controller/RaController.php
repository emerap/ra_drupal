<?php

namespace Drupal\ra_drupal\Controller;

use Drupal\Core\Controller\ControllerBase;
use Emerap\Ra\RaConfig;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RaController.
 *
 * @package Drupal\ra_drupal\Controller
 */
class RaController extends ControllerBase {

  public function method($method) {
    
    $args = (\Drupal::request()->getMethod() == 'GET') ? $_GET: $_POST;

    $ra = RaConfig::instanceRa();
    $methodObj = RaConfig::instanceMethod($method, $args);

    $result = $ra->call($methodObj);
    $format =  $result->getFormat();

    $response = new Response();
    $content = [
      '#markup' => $result->format()
    ];
    $response->setContent(render($content));
    $response->headers->set('Content-Type', $format->getMimeType() . ' charset=UTF-8');

    return $response;
  }

}

// https://www.drupal.org/node/2150267