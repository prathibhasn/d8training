<?php

namespace Drupal\d8_routing_demo\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Path\CurrentPathStack;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class KernelResponseSubscriber.
 */
class KernelResponseSubscriber implements EventSubscriberInterface {


  /**
   * Drupal\Core\Path\CurrentPathStack definition.
   *
   * @var \Drupal\Core\Path\CurrentPathStack
   */
  protected $pathCurrent;

  /**
   * Constructs a new TestSubscriber object.
   */
  public function __construct(CurrentPathStack $path_current) {
    $this->pathCurrent = $path_current;
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE] = ['addHeaderToResponse'];

    return $events;
  }

  /**
   * This method is called whenever the KernelEvents::RESPONSE event is
   * dispatched.
   *
   * @param GetResponseEvent $event
   */
  public function addHeaderToResponse(Event $event) {
    if(strpos( $this->pathCurrent->getPath(), 'node' )) {
      $response = $event->getResponse();
      $response->headers->set('access-control-allow-origin', '*');
    }
  }

}
