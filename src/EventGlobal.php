<?php

namespace Cybtow\EventManager;

/**
 * EventGlobal class
 *
 * @author cybtow
 */
class EventGlobal {

    /**
     * @var array
     */
    private static $eventListeners = array();

    /**
     * addEventListener
     * 
     * @param string $eventName
     * @param \Closure $callback
     * @param array $args
     */
    public static function addEventListener($eventName, $callback, $args = null) {
        self::$eventListeners = EventInternal::addEventListener(self::$eventListeners, $eventName, $callback, $args);
    }

    /**
     * removeEventListener
     * 
     * @param string $eventName
     * @param \Closure $callback
     */
    public static function removeEventListener($eventName, $callback) {
        self::$eventListeners = EventInternal::removeEventListener(self::$eventListeners, $callback, $eventName, $callback);
    }

    /**
     * run
     * 
     * @param mixed $Sender
     * @param string $eventName
     * @param array $args
     */
    public static function run($Sender, $eventName, $args = null) {
        EventInternal::run(self::$eventListeners, $Sender, $eventName, $args);
    }

}
