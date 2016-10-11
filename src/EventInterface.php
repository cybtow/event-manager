<?php

namespace Cybtow\EventManager;

/**
 * Event Interface
 * 
 * @author cybtow
 */
interface EventInterface {

    /**
     * addEventListener
     * 
     * @param string $eventName
     * @param \Closure $callback
     * @param array $args
     */
    public function addEventListener($eventName, $callback, $args = null);

    /**
     * removeEventListener
     * 
     * @param string $eventName
     * @param \Closure $callback
     */
    public function removeEventListener($eventName, $callback);
}
