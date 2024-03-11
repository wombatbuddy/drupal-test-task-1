<?php

declare(strict_types=1);

namespace Drupal\server_general\Controller;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Server General routes.
 */
final class DisplayCurrentDateController extends ControllerBase {

  /**
   * The controller constructor.
   */
  public function __construct(
    private readonly TimeInterface $time,
    private readonly DateFormatterInterface $dateFormatter,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('datetime.time'),
      $container->get('date.formatter'),
    );
  }

  /**
   * Render the current date and time.
   */
  public function __invoke(): array {
    $timestamp = $this->time->getRequestTime();
    $currentDate = $this->dateFormatter->format($timestamp, 'custom', 'd.m.Y H:i');

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $currentDate,
    ];

    return $build;
  }

}
