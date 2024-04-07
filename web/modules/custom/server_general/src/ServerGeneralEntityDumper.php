<?php

declare(strict_types=1);

namespace Drupal\server_general;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;

/**
 * Provides an entity dumper.
 */
final class ServerGeneralEntityDumper implements ServerGeneralEntityDumperInterface {

  use StringTranslationTrait;

  /**
   * Constructs a ServerGeneralEntityDumper object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly MessengerInterface $messenger,
    TranslationInterface $translation,
  ) {
    $this->setStringTranslation($translation);
  }

  /**
   * {@inheritdoc}
   */
  public function dump(string $entityTypeId, int|string $entityId) {
    try {
      $entityStorage = $this->entityTypeManager->getStorage($entityTypeId);
    }
    catch (PluginNotFoundException $e) {
      $this->messenger->addError($this->t('The entity type does not exist.'));
      return;
    }
    catch (InvalidPluginDefinitionException $e) {
      $this->messenger->addError($this->t('The sorage handler could not be loaded.'));
      return;
    }

    $entity = $entityStorage->load($entityId);

    if (!$entity) {
      $this->messenger->addError($this->t('Entity with ID :id does not exist', [':id' => $entityId]));
      return;
    }

    dump($entity);
  }

}
