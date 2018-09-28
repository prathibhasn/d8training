<?php

namespace Drupal\d8_routing_demo\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Drupal\dblog\Logger\DbLog;
/**
 * Class DataEntryEventSubscriber.
 */
class DataEntryEventSubscriber implements EventSubscriberInterface {


  /**
   * Constructs a new DataEntryEventSubscriber object.
   */
  public function __construct() {

  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events['d8_routing_demo.data.insert'] = ['logFirstLastName'];

    return $events;
  }

  /**
   * This method is called whenever the d8_routing_demo.data.insert event is
   * dispatched.
   *
   * @param GetResponseEvent $event
   */
  public function logFirstLastName(Event $event) {
    \Drupal::logger('system')->info($event->firstName.' '.$event->lastName);
  }

}
