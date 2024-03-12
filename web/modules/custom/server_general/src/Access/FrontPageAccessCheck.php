<?php

declare(strict_types=1);

namespace Drupal\server_general\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Checks if passed parameter matches the route configuration.
 *
 * Usage example:
 * @code
 * foo.example:
 *   path: '/example/{parameter}'
 *   defaults:
 *     _title: 'Example'
 *     _controller: '\Drupal\server_general\Controller\ServerGeneralController'
 *   requirements:
 *     _foo: 'some value'
 * @endcode
 */
final class FrontPageAccessCheck implements AccessInterface {

  /**
   * Allows access to authenticated users.
   *
   * @DCG
   * Drupal does some magic when resolving arguments for this callback. Make
   * sure the parameter name matches the name of the placeholder defined in the
   * route, and it is of the same type.
   * The following additional parameters are resolved automatically.
   *   - \Drupal\Core\Routing\RouteMatchInterface
   *   - \Drupal\Core\Session\AccountInterface
   *   - \Symfony\Component\HttpFoundation\Request
   *   - \Symfony\Component\Routing\Route
   */
  public function access(AccountInterface $account): AccessResult {
    return AccessResult::allowedIf($account->isAuthenticated());
  }

}
