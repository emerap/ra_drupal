<?php

namespace Drupal\ra_docs\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Emerap\Ra\RaConfig;


/**
 * Class RaDocsForm.
 *
 * @package Drupal\ra_docs\Form
 */
class RaDocsForm extends FormBase {

  /** @var string methodName */
  protected $methodName = NULL;
  /** @var \Emerap\Ra\Core\Definition methodDefinition */
  protected $methodDefinition;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    $this->methodName = \Drupal::routeMatch()->getParameter('method');
    $this->methodDefinition = RaConfig::instanceDefinition()
      ->getDefinitionByName($this->methodName);
    return 'ra_docs_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#prefix'] = '<div id="ra-dev-method-form-wrapper">';
    $form['#suffix'] = '</div>';

    if (!is_null($this->methodName)) {

      /** @var \Emerap\Ra\Core\Definition $definition */
      $definition = $this->methodDefinition;

      if ($definition->isSecurity()) {
        $form['warning'] = [
          '#type' => 'markup',
          '#markup' => '<div class="messages messages--warning">This method can be called with a token.</div>',
          '#weight' => -50,
        ];
      }

      foreach ($definition->getMethodParams() as $param) {

        if ($param->getName() !== 'token') {
          $optionsCount = count($param->getOptions());
          $isOptions = ($optionsCount > 1) ? TRUE : FALSE;

          $optionsKind = 'radios';

          if ($optionsCount > 2) {
            $optionsKind = 'select';
          }

          $form['param_' . $param->getName()] = [
            '#title' => 'Parameter - ' . $param->getName(),
            '#type' => ($isOptions) ? $optionsKind : 'textfield',
            '#required' => $param->isRequire(),
            '#description' => ((!empty($param->getHelp())) ? $param->getHelp() :
                $param->getTypeObject()->getDescription()) . ' (' .
              $param->getTypeObject()->getLabel() . ')',
            '#default_value' => $param->getDefault(),
          ];

          if ($isOptions) {
            $form['param_' . $param->getName()]['#options'] = $param->getOptions();
          }
        }

      }
    }

    $form['actions'] = [
      '#type' => 'actions',
      '#weight' => -20,
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => t('Call method'),
      '#button_type' => 'primary',
      '#ajax' => [
        'wrapper' => 'ra-dev-method-form-wrapper',
      ],
    ];

    if ($form_state->isSubmitted()) {

      $params = [];
      foreach ($this->methodDefinition->getMethodParams() as $parameter) {
        $value = $form_state->getValue('param_' . $parameter->getName());
        $params[$parameter->getName()] = (!empty($value)) ? $value : $parameter->getDefault();
      }

      $time_before = microtime(TRUE);

      $client_id = NULL;
      if ($this->methodDefinition->isSecurity() && ($client = $this->registerClient())) {
        $params['token'] = $client->getToken();
        $client_id = $client->getClientId();
      }

      $result = $this->call($params);

      if (($result->getError()->getCode() === 201) || ($result->getError()->getCode() === 105)) {
        if ($token = RaConfig::instanceToken()->updateToken($client_id)) {
          $params['token'] = $token;
          drupal_set_message('Token was updated', 'warning');
          $result = $this->call($params);
        }
      }

      $total_result = $result->format();

      $time_after = microtime(TRUE);
      drupal_set_message('Time request: ' . round(($time_after - $time_before) * 1000, 0) . ' ms');
      drupal_set_message('Request length: ' . mb_strlen($total_result) . ' bytes');

      $message_type = ($result->getError()->getCode() > 0) ? 'error' : 'status';

      $form['result'] = [
        '#type' => 'markup',
        '#markup' => '<div class="messages messages--' . $message_type . '">' . $total_result . '</div>',
        '#weight' => -10,
      ];
    }

    return $form;
  }

  private function registerClient() {
    $client = RaConfig::instanceServerClient()
      ->getClientByTag('ra_docs', RaConfig::getUserID());

    if (!$client) {
      $invite = RaConfig::instanceServerClient()
        ->pair('ra_docs', rand(1000, 9999), 'Drupal 8');
      RaConfig::instanceServerClient()
        ->activate($invite['invite_id'], $invite['pin'], RaConfig::getUserID());
    }

    return RaConfig::instanceServerClient()
      ->getClientByTag('ra_docs', RaConfig::getUserID());
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRebuild(TRUE);
  }

  /**
   * Helper for call method.
   *
   * @param array $params
   * @return \Emerap\Ra\Core\Result
   */
  private function call($params = []) {
    $ra = RaConfig::instanceRa();
    $method = RaConfig::instanceMethod($this->methodName, $params);
    return $ra->call($method);
  }

}
