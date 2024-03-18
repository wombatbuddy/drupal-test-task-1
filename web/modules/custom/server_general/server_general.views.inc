<?php

/**
 * @file
 * Provide views data for server_general.module.
 */

declare(strict_types=1);

/**
 * @file
 * Views hooks for the Server general module.
 */

/**
 * Implements hook_views_data().
 */
function server_general_views_data() {
  $data = [];
  $data['server_general_editors_notes'] = [];
  $data['server_general_editors_notes']['table'] = [];
  $data['server_general_editors_notes']['table']['group'] = t("Editors' notes");
  $data['server_general_editors_notes']['table']['wizard_id'] = 'server_general_editors_notes';

  $data['server_general_editors_notes']['table']['base'] = [
    // Identifier (primary) field in this table for Views.
    'field' => 'id',
    'title' => t("Editors' notes"),
    'help' => t("Editors' notes for nodes."),
    'weight' => -10,
  ];

  $data['server_general_editors_notes']['table']['join'] = [
    'node_field_data' => [
      'left_field' => 'nid',
      'field' => 'nid',
    ],
  ];

  $data['server_general_editors_notes']['nid'] = [
    'title' => t('Node ID'),
    'help' => t("Relate editor's notes to the node content."),
    'relationship' => [
      'base' => 'node_field_data',
      'base field' => 'nid',
      'id' => 'standard',
      'label' => t("Editors' notes"),
    ],

    'field' => [
      'id' => 'numeric',
    ],

    'sort' => [
      'id' => 'standard',
    ],

    'filter' => [
      'id' => 'numeric',
    ],

    'argument' => [
      'id' => 'numeric',
    ],
  ];

  $data['server_general_editors_notes']['id'] = [
    'title' => t('Notes ID'),
    'help' => t('Notes ID for a specific node.'),

    'field' => [
      'id' => 'numeric',
    ],

    'sort' => [
      'id' => 'standard',
    ],

    'filter' => [
      'id' => 'numeric',
    ],

    'argument' => [
      'id' => 'numeric',
    ],
  ];

  $data['server_general_editors_notes']['status'] = [
    'title' => t('Status of notes'),
    'help' => t('Status of notes.'),

    'field' => [
      'id' => 'numeric',
    ],

    'sort' => [
      'id' => 'standard',
    ],

    'filter' => [
      'id' => 'numeric',
    ],

    'argument' => [
      'id' => 'numeric',
    ],
  ];

  $data['server_general_editors_notes']['data'] = [
    'title' => t("Editors' notes"),
    'help' => t("Editors' notes for a specific node."),

    'field' => [
      'id' => 'editors_notes',
    ],

    'sort' => [
      'id' => 'string',
    ],

    'filter' => [
      'id' => 'string',
    ],
  ];

  return $data;
}
