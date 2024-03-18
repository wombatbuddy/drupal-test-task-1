<?php

namespace Drupal\server_general\Plugin\views\wizard;

use Drupal\views\Plugin\views\wizard\WizardPluginBase;

/**
 * Provides Views creation wizard for Editors' Notes.
 *
 * @ViewsWizard(
 *   id = "server_general_editors_notes",
 *   module = "server_general",
 *   base_table = "server_general_editors_notes",
 *   title = @Translation("Editors' Notes")
 * )
 */
class EditorsNotes extends WizardPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function defaultDisplayOptions() {
    $display_options = parent::defaultDisplayOptions();

    // Add permission-based access control.
    $display_options['access']['type'] = 'perm';
    $display_options['access']['options']['perm'] = 'access editors notes';

    return $display_options;
  }

}
