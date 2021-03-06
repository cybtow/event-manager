<?php

namespace Cybtow\EventManager;

/**
 * EventInternal class
 *
 * @author cybtow
 */
class EventInternal {

    /**
     * addEventListener
     * 
     * @param \Closure[] $aClosures
     * @param string $eventName
     * @param \Closure $callback
     * @param array $args
     * @return \Closure[]
     */
    public static function addEventListener(array $aClosures, $eventName, $callback, $args = null) {
        $key = "_event_$eventName";

        if (!isset($aClosures[$key])) {
            $aClosures[$key] = array();
        }
        if (!is_array($args)) {
            $argumento = array('in' => $args);
        } else {
            $argumento = $args;
        }
        $aClosures[$key][] = array(
            'f' => $callback,
            'a' => $argumento
        );
        return $aClosures;
    }

    /**
     * removeEventListener
     * 
     * @param \Closure[] $aClosures
     * @param string $eventName
     * @param \Closure $callback
     * @return \Closure[]
     */
    public static function removeEventListener(array $aClosures, $eventName, $callback) {
        $key = "_event_$eventName";
        if (isset($aClosures[$key])) {
            $aClosures[$key] = array_filter($aClosures[$key], function($element) use ($callback) {
                return ($callback !== $element['f']);
            });
        }
        return $aClosures;
    }

    /**
     * run
     * 
     * @param \Closure[] $aClosures 
     * @param mixed $Sender
     * @param string $eventName
     * @param array $args
     */
    public static function run(array $aClosures, $Sender, $eventName, $args = null) {
        $key = "_event_$eventName";
        if (isset($aClosures[$key])) {
            foreach ($aClosures[$key] as $callback) {
                if (is_callable($callback['f'])) {
                    $Event = new EventInstance();
                    $Event->setSender($Sender);
                    $Event->setEventName($eventName);
                    $Event->setArgsIn($callback['a']);
                    $Event->setArgsResult($args);

                    call_user_func($callback['f'], $Event);
                }
            }
        }
    }

}
