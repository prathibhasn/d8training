<?php

namespace Drupal\d8_routing_demo\Controller;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Drupal\d8_routing_demo\Event\DataEntryEvent;
class DataController implements ContainerInjectionInterface {

    protected $db;
    protected $dispatcher;

    public function __construct(Connection $db, ContainerAwareEventDispatcher $dispatcher) {
        $this->db = $db;
        $this->dispatcher = $dispatcher;
    }
    /**
     * 
     */
    public static function create(ContainerInterface $container) {
        return new static(
        $container->get('database'),
        $container->get('event_dispatcher')
        );
    }
    function insertToTable($first_name, $last_name) {
        $this->db->insert('d8_demo')
        ->fields([
            'first_name' => $first_name,
            'last_name' => $last_name
        ])->execute();
        $this->dispatcher->dispatch(
            DataEntryEvent::DATA_INSERT,
            new DataEntryEvent($first_name, $last_name)
        );
    }
    public function getLastEntry() {
        $results = $this->db->select('d8_demo', 'dd')
        ->fields('dd')
        ->orderBy('id', 'DESC')
        ->range(0,1)
        ->execute()
        ->fetchAll();
        $last_value = $results[0];
        return $last_value;
    }
}