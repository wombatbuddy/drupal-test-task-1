<?php

declare(strict_types=1);

namespace Drupal\server_general\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure Server General settings for this site.
 */
final class SettingsForm extends ConfigFormBase {

  /**
   * Entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Class constructor.
   */
  public function __construct(ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($config_factory);
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'server_general_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['server_general.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('server_general.settings');

    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled'),
      '#default_value' => $config->get('enabled'),
    ];

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#default_value' => $config->get('name'),
    ];

    $node = NULL;
    $nid = $config->get('node');
    if ($nid) {
      $node = $this->entityTypeManager->getStorage('node')->load($nid);
    }

    $form['node'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'node',
      // There is an issue with this element that allows users to enter
      // multiple values even if #tags is set to FALSE.
      // See https://www.drupal.org/project/drupal/issues/2692289
      '#tags' => FALSE,
      '#default_value' => $node,
      '#selection_handler' => 'default',
      '#selection_settings' => [
        'target_bundles' => ['article', 'page'],
      ],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('server_general.settings')
      ->set('enabled', $form_state->getValue('enabled'))
      ->set('name', $form_state->getValue('name'))
      ->set('node', $form_state->getValue('node'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
