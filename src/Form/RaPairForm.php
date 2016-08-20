<?php

namespace Drupal\ra_drupal\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Emerap\Ra\RaConfig;

/**
 * Class RaPairForm.
 *
 * @package Drupal\ra\Form
 */
class RaPairForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ra_pair_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#prefix'] = '<div id="ra-pair-form-wrapper">';
    $form['#suffix'] = '</div>';

    $form['invite_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Pair ID'),
      '#description' => $this->t('Typing here your pair id'),
      '#maxlength' => 4,
      '#size' => 4,
      '#required' => TRUE,
    ];

    $form['pin'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Pin'),
      '#description' => $this->t('Typing here pin'),
      '#maxlength' => 4,
      '#size' => 4,
      '#required' => TRUE,
    ];

    if (!\Drupal::currentUser()->getAccount()->id()) {

      $login_link = Link::fromTextAndUrl($this->t('Login'),
        Url::fromRoute('user.login', ['destination' => '/ra/pair']));

      $form['guest'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Guest account'),
        '#required' => TRUE,
        '#description' => $login_link,
      ];
    }

    $form['actions'] = ['#type' => 'actions'];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
      '#button_type' => 'primary',
      '#ajax' => [
        'wrapper' => 'ra-pair-form-wrapper',
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $error = RaConfig::instanceServerClient()->activate(
      $form_state->getValue('invite_id'), $form_state->getValue('pin'),
      RaConfig::getUserID());

    $type = ($error->getCode() === 0) ? 'status' : 'error';
    $message = ($error->getCode() === 0) ?
      $this->t('Successful pairing client') : $error->getMessage();

    drupal_set_message($message, $type);
  }

}
