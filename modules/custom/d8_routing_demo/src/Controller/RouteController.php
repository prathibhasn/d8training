<?php

/**
 * 
 */
namespace Drupal\d8_routing_demo\Controller;
use Drupal\user\UserInterface;
use Drupal\node\NodeInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
class RouteController {
    public function hello_world() {
        return [
            '#type' => '#markup',
            '#markup' => 'Hello World'
        ];
    }
    public function helloDynamic($name) {
        return [
            '#type' => '#markup',
            '#markup' => 'Hello '.$name
        ];
    }
    public function helloDynamicTitleCallback($name) {
        return [
            '#type' => '#markup',
            '#markup' => 'Hello title '.$name
        ];
    }
    public function helloDynamicEntity(UserInterface $user) {
        ksm($user);
        return [
            '#type' => '#markup',
            '#markup' => 'Hello '.$user->getUserName().' !'
        ];
    }
    public function loadDynamicEntityTitleCallback(UserInterface $user) {
        return [
            '#type' => '#markup',
            '#markup' => 'Hello '.$user->getUserName()
        ];
    }
    public function listNode(NodeInterface $node) {
        $owner = $node->getOwner()->getAccountName();
        return [
        '#type' => '#markup',
        '#markup' => $node->getTitle() . '|' . $owner,
        ];
    }
    public function listNodeAccess(NodeInterface $node, AccountInterface $account) {
        return AccessResult::allowedIf(
            $node->getOwnerId() === $account->id()
        );
    }
}