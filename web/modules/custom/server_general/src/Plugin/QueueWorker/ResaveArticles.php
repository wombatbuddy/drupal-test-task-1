<?php

declare(strict_types=1);

namespace Drupal\server_general\Plugin\QueueWorker;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines 'queue_uniqu/resave_articles' queue worker.
 *
 * @QueueWorker(
 *   id = "queue_uniqu/resave_articles",
 *   title = @Translation("Resave articles"),
 *   cron = {"time" = 60},
 * )
 */
final class ResaveArticles extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs a new ResaveArticles instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data): void {
    $node = $this->entityTypeManager->getStorage('node')->load($data['nid']);
    if ($node) {
      $node->save();
    }
  }

}
