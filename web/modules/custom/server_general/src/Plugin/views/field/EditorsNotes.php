<?php

declare(strict_types=1);

namespace Drupal\server_general\Plugin\views\field;

use Drupal\views\Plugin\views\field\Serialized;
use Drupal\views\ResultRow;

/**
 * Provides Editors' notes field handler.
 *
 * @ViewsField("editors_notes")
 *
 * @DCG
 * The plugin needs to be assigned to a specific table column through
 * hook_views_data() or hook_views_data_alter().
 * Put the following code to my_module.views.inc file.
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
final class EditorsNotes extends Serialized {

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $value = $values->{$this->field_alias};

    if ($this->options['format'] === 'key' && !empty($this->options['key'])) {
      $value = (array) unserialize($value, ['allowed_classes' => FALSE]);
      return $this->sanitizeValue($value[$this->options['key']]);
    }
    elseif ($this->options['format'] === 'unserialized' && $value) {
      $notes = unserialize($value, ['allowed_classes' => FALSE]);
      $result = '';
      foreach ($notes as $note) {
        $result .= $this->t('<p>Editor ID: @id</p>', ['@id' => $note['editor_id']]);
        $result .= $this->t('<p>Note: @note</p>', ['@note' => $note['note']]);
      }
      return [
        '#markup' => $result,
      ];
    }

    return $value;
  }

}
