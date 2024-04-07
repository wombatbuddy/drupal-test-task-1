<?php

declare(strict_types=1);

namespace Drupal\server_general;

/**
 * Provides an interface defining an entity dumper.
 */
interface ServerGeneralEntityDumperInterface {

  /**
   * Render an entity dump.
   *
   * @param string $entityTypeId
   *   The ID of the type of the entity.
   * @param int|string $entityId
   *   The ID of the entity.
   *
   * @return mixed
   *   The dump of the entity or the error message.
   */
  public function dump(string $entityTypeId, int|string $entityId);

}
