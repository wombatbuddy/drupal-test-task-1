<?php

declare(strict_types=1);

namespace Drupal\server_general\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Server General routes.
 */
final class CreateNodeController extends ControllerBase {

  /**
   * Create a node of the Page content type and redirect a user to it.
   */
  public function __invoke() {
    $nodeStorage = $this->entityTypeManager()->getStorage('node');
    /** @var \Drupal\node\NodeInterface $node */
    $node = $nodeStorage->create([
      'type' => 'page',
      'title' => $this->t('Basic page created programmatically'),
    ]);
    $node->save();
    $nid = $node->id();

    // Store the nid of the created node, so we can recognize it
    // and attach the JS library to this node in the hook_preprocess_node().
    /** @var \Drupal\node\NodeTypeInterface $nodeType */
    $nodeType = $this->entityTypeManager()->getStorage('node_type')->load('page');
    $nids = $nodeType->getThirdPartySetting('server_general', 'nids_with_attached_js');
    $nids[] = $nid;
    $nodeType->setThirdPartySetting('server_general', 'nids_with_attached_js', $nids);
    $nodeType->save();

    return $this->redirect('entity.node.canonical', ['node' => $nid]);
  }

}
