<?php

namespace Drupal\d8_routing_demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Routing\CurrentRouteMatch;

/**
 * Provides a 'CurrentUserArticle' block.
 *
 * @Block(
 *  id = "current_user_article",
 *  admin_label = @Translation("Current user article"),
 * )
 */
class CurrentUserArticle extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;
  /**
   * Constructs a new CurrentUserArticle object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    AccountProxyInterface $current_user,
    CurrentRouteMatch $current_route
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $current_user;
    $this->currentRoute = $current_route;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('current_route_match')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $node_title = $this->currentRoute->getParameter('node')->getTitle();
    $build = [];
    $build['current_user_article']['#markup'] = 'Hello '.$this->currentUser->getAccountName();
    $build['current_user_article']['#markup'] .= 'You are viewing '.$node_title;
    $build['#cache'] =  [
      'contexts' => [
        'route',
      ]
    ];
    return $build;
  }

}
