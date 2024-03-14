<?php

declare(strict_types=1);

namespace Drupal\server_general\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a simple Ajax form.
 */
final class ExampleAjaxForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'ajax_form_example';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text to submit'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::ajaxSubmitCallback',
      ],
    ];

    $form['submission_message'] = [
      '#type' => 'item',
      '#prefix' => '<div id="ajax-wrapper">',
      '#suffix' => '</div>',
    ];

    if ($form_state->getValue('text')) {
      $text = $form_state->getValue('text');
      $message = $this->t('Result: @text.', ['@text' => $text]);
      $form['submission_message']['#markup'] = $message;
    }

    return $form;
  }

  /**
   * Ajax submit callback.
   *
   * Render a submitted value or the error message if the "text" field is empty.
   */
  public function ajaxSubmitCallback(array $form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $text = $form_state->getValue('text');
    if (!$text) {
      // Clear the previous submit message and display the error message.
      $response->addCommand(new HtmlCommand('.form-item-submission-message', ''));
      $response->addCommand((new MessageCommand('The value is required', '.form-item-submission-message', ['type' => 'error'])));
    }
    else {
      $message = $this->t('Result: @text', ['@text' => $text]);
      $response->addCommand(new InvokeCommand('.form-item-submission-message', 'text', [$message]));
    }
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {

  }

}
