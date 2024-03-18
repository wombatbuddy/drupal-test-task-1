<?php

declare(strict_types=1);

namespace Drupal\server_general\Plugin\views\field;

use Drupal\Component\Render\MarkupInterface;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides Title and Date field handler.
 *
 * @ViewsField("title_and_date")
 *
 * @DCG
 * The plugin needs to be assigned to a specific table column through
 * hook_views_data() or hook_views_data_alter().
 * Put the following code to server_general.views.inc file.
 * @code
 * function foo_views_data_alter(array &$data): void {
 *   $data['node']['foo_example']['field'] = [
 *     'title' => t('Example'),
 *     'help' => t('Custom example field.'),
 *     'id' => 'foo_example',
 *   ];
 * }
 * @endcode
 */
final class TitleAndDate extends FieldPluginBase {

  /**
   * Constructs a new TitleAndDate instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly DateFormatterInterface $dateFormatter,
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
      $container->get('date.formatter'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function query(): void {
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values): string|MarkupInterface {
    /** @var \Drupal\node\NodeInterface $node */
    $node = $this->getEntity($values);
    $timestamp = $node->getCreatedTime();
    $date = $this->dateFormatter->format($timestamp, 'custom', 'd.m.Y');

    return $node->getTitle() . ' ' . $date;
  }

}
