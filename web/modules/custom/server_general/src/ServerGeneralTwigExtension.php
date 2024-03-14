<?php

declare(strict_types=1);

namespace Drupal\server_general;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Twig extension.
 */
final class ServerGeneralTwigExtension extends AbstractExtension {

  /**
   * Constructs the extension object.
   */
  public function __construct(
    private readonly ConfigFactoryInterface $configFactory,
    private readonly TimeInterface $time,
    private readonly DateFormatterInterface $dateFormatter,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getFunctions(): array {
    return [
      new TwigFunction('site_name_date_time', [$this, 'siteNameDateTime']),
    ];
  }

  /**
   * Return a string consisting of the site name, current date and time.
   */
  public function siteNameDateTime(): string {
    $siteName = $this->configFactory->get('system.site')->get('name');
    $timestamp = $this->time->getRequestTime();
    $currentDateTime = $this->dateFormatter->format($timestamp, 'custom', 'd.m.Y H:i');
    return $siteName . ' ' . $currentDateTime;
  }

}
