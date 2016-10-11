<?php


namespace Cybtow\EventManager;

/**
 * Event Trait
 *
 * @author cybtow
 */
trait EventTrait {
    
    /**
     * @var array
     */
    private $eventListeners = array();

    /**
     * addEventListener
     * 
     * @param string $eventName
     * @param \Closure $callback
     * @param array $args
     */
    public function addEventListener($eventName, $callback, $args = null) {
        $this->eventListeners = EventInternal::addEventListener($this->eventListeners, $eventName, $callback, $args);
    }

    /**
     * removeEventListener
     * 
     * @param string $eventName
     * @param \Closure $callback
     */
    public function removeEventListener($eventName, $callback) {
        $this->eventListeners = EventInternal::removeEventListener($this->eventListeners, $eventName, $callback);
    }

    /**
     * run
     * 
     * @param string $eventName
     * @param array $args
     */
    public function run($eventName, $args = null) {
        EventInternal::run($this->eventListeners, $this, $eventName, $args);
    }
    
}
