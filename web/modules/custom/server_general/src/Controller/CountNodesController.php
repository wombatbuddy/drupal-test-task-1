<?php

declare(strict_types=1);

namespace Drupal\server_general\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Server General routes.
 */
final class CountNodesController extends ControllerBase {

  /**
   * The controller constructor.
   */
  public function __construct(
    private readonly Connection $connection,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('database'),
    );
  }

  /**
   * Provides a title callback.
   *
   * @param string $bundle
   *   The name of the bundle.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   The title.
   */
  public function title(string $bundle) {
    return $this->t('The number of published nodes of the @bundle content type', ['@bundle' => $bundle]);
  }

  /**
   * Render the number of nodes.
   *
   * @param string $bundle
   *   The name of the bundle.
   *
   * @return array
   *   A render array containing the number of nodes.
   */
  public function __invoke(string $bundle): array {
    $numberOfNodesEntityQuery = $this->getNodeCountEntityQuery($bundle);
    $numberOfNodesDatabase = $this->getNodeCountDatabase($bundle);

    $result = $this->t('<p>The number of nodes calculated using EntityQuery: @number</p>', [
      '@number' => $numberOfNodesEntityQuery,
    ]);

    $result .= $this->t('<p>The number of nodes calculated using Database: @number</p>', [
      '@number' => $numberOfNodesDatabase,
    ]);

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $result,
    ];

    $build['content']['#cache']['tags'][] = 'node_list:' . $bundle;

    return $build;
  }

  /**
   * Get a number of nodes using the EntityQuery class.
   *
   * @param string $bundle
   *   The name of the bundle.
   *
   * @return int
   *   A number of nodes.
   */
  public function getNodeCountEntityQuery(string $bundle): int {
    $query = $this->entityTypeManager()->getStorage('node')->getQuery();
    $numberOfNodes = $query
      ->accessCheck(FALSE)
      ->condition('type', $bundle)
      ->condition('status', 1)
      ->count()
      ->execute();

    return $numberOfNodes;
  }

  /**
   * Get a number of nodes using the Database class.
   *
   * @param string $bundle
   *   The name of the bundle.
   *
   * @return int
   *   A number of nodes.
   */
  public function getNodeCountDatabase(string $bundle): int {
    $numberOfNodes = $this->connection->select('node_field_data', 'nfd')
      ->condition('nfd.type', $bundle)
      ->condition('nfd.status', 1)
      ->countQuery()
      ->execute()
      ->fetchField();

    return intval($numberOfNodes);
  }

}
