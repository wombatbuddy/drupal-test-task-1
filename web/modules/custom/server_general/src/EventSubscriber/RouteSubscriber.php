<?php

declare(strict_types=1);

namespace Drupal\server_general\EventSubscriber;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Route subscriber.
 */
final class RouteSubscriber extends RouteSubscriberBase {

  /**
   * Allow access to the front page only for authenticated users.
   *
   * We did it with a custom access check service, but it also can be done
   * without it by setting '_role' requirement, like this:
   * $route->setRequirement('_role', 'authenticated');
   */
  protected function alterRoutes(RouteCollection $collection): void {
    if ($route = $collection->get('view.frontpage.page_1')) {
      // The alternative way to provide access only to authenticated users.
      // $route->setRequirement('_role', 'authenticated');.
      $route->setRequirement('_custom_access', 'access_check.front_page::access');
    }
  }

}
