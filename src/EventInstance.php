<?php

namespace Cybtow\EventManager;

/**
 * EventInstance class
 *
 * @author cybtow
 */
class EventInstance {

    /**
     * @var mixed 
     */
    private $Sender;

    /**
     * @var string
     */
    private $eventName;

    /**
     * @var array
     */
    private $argsIn;

    /**
     * @var array
     */
    private $argsResult;

    /**
     * @return mixed
     */
    public function getSender() {
        return $this->Sender;
    }

    /**
     * @return string
     */
    public function getEventName() {
        return $this->eventName;
    }

    /**
     * @return array
     */
    public function getArgsIn() {
        return $this->argsIn;
    }

    /**
     * @return array
     */
    public function getArgsResult() {
        return $this->argsResult;
    }

    /**
     * @param mixed $Sender
     */
    public function setSender($Sender) {
        $this->Sender = $Sender;
    }

    /**
     * @param string $eventName
     */
    public function setEventName($eventName) {
        $this->eventName = $eventName;
    }

    /**
     * @param array $argsIn
     */
    public function setArgsIn($argsIn) {
        if (is_array($argsIn)) {
            $this->argsIn = $argsIn;
        } else {
            $this->argsIn = array('in' => $argsIn);
        }
    }

    /**
     * @param array $argsResult
     */
    public function setArgsResult($argsResult) {
        if (is_array($argsResult)) {
            $this->argsResult = $argsResult;
        } else {
            $this->argsResult = array('result' => $argsResult);
        }
    }

}
