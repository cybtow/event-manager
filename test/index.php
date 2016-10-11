<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Cybtow\EventManager\Event;
use Cybtow\EventManager\EventTrait;
use Cybtow\EventManager\EventInterface;
use Cybtow\EventManager\EventGlobal;
use Cybtow\EventManager\EventInstance;

// **********************************************
// Example using method: Extending Event class.
// **********************************************

class A extends Event {

    const EVENT_HELLO = 'a.hello';

    public function hello($name) {
        echo "Hello! $name<br/>" . PHP_EOL;
        $this->run(self::EVENT_HELLO, array('name' => $name));
    }

}

class Z {
    
    public function listener(EventInstance $Event) {
        echo \sprintf('Event Listener with method - Sender: (%s) - EventName: (%s) - Arguments: (%s)<br/>' . PHP_EOL, get_class($Event->getSender()), $Event->getEventName(), serialize(array_merge($Event->getArgsIn(), $Event->getArgsResult())));
    }
    
}

$callback = function(EventInstance $Event) {
    echo \sprintf('Event Listener with anonymous function - Sender: (%s) - EventName: (%s) - Arguments: (%s)<br/>' . PHP_EOL, get_class($Event->getSender()), $Event->getEventName(), serialize(array_merge($Event->getArgsIn(), $Event->getArgsResult())));
};

function testListener(EventInstance $Event) {
    echo \sprintf('Event Listener with normal function - Sender: (%s) - EventName: (%s) - Arguments: (%s)<br/>' . PHP_EOL, get_class($Event->getSender()), $Event->getEventName(), serialize(array_merge($Event->getArgsIn(), $Event->getArgsResult())));
}


echo 'Starting test...<br/>' . PHP_EOL;

$A = new \A();

$A->addEventListener(\A::EVENT_HELLO, function(EventInstance $Event) {
    echo \sprintf('Event Listener with Closure - Sender: (%s) - EventName: (%s) - Arguments: (%s)<br/>' . PHP_EOL, get_class($Event->getSender()), $Event->getEventName(), serialize(array_merge($Event->getArgsIn(), $Event->getArgsResult())));
}, array('in' => 'closure example in class extending from Event'));
$A->addEventListener(\A::EVENT_HELLO, $callback, array('in' => 'anonymous function in class extending from Event'));
$A->addEventListener(\A::EVENT_HELLO, 'testListener', array('in' => 'normal function in class extending from Event'));
$A->addEventListener(\A::EVENT_HELLO, array(new \Z(), 'listener'), array('in' => 'class->method example in class extending from Event'));

$A->hello('John');
$A->hello('Mary');

$A->removeEventListener(\A::EVENT_HELLO, $callback);

$A->hello('Bianca');


// Output:
// Starting test...
// Hello! John
// Event Listener with Closure - Sender: (A) - EventName: (a.hello) - Arguments: (a:2:{s:2:"in";s:45:"closure example in class extending from Event";s:4:"name";s:4:"John";})
// Event Listener with anonymous function - Sender: (A) - EventName: (a.hello) - Arguments: (a:2:{s:2:"in";s:48:"anonymous function in class extending from Event";s:4:"name";s:4:"John";})
// Event Listener with normal function - Sender: (A) - EventName: (a.hello) - Arguments: (a:2:{s:2:"in";s:45:"normal function in class extending from Event";s:4:"name";s:4:"John";})
// Event Listener with method - Sender: (A) - EventName: (a.hello) - Arguments: (a:2:{s:2:"in";s:51:"class->method example in class extending from Event";s:4:"name";s:4:"John";})
// Hello! Mary
// Event Listener with Closure - Sender: (A) - EventName: (a.hello) - Arguments: (a:2:{s:2:"in";s:45:"closure example in class extending from Event";s:4:"name";s:4:"Mary";})
// Event Listener with anonymous function - Sender: (A) - EventName: (a.hello) - Arguments: (a:2:{s:2:"in";s:48:"anonymous function in class extending from Event";s:4:"name";s:4:"Mary";})
// Event Listener with normal function - Sender: (A) - EventName: (a.hello) - Arguments: (a:2:{s:2:"in";s:45:"normal function in class extending from Event";s:4:"name";s:4:"Mary";})
// Event Listener with method - Sender: (A) - EventName: (a.hello) - Arguments: (a:2:{s:2:"in";s:51:"class->method example in class extending from Event";s:4:"name";s:4:"Mary";})
// Hello! Bianca
// Event Listener with Closure - Sender: (A) - EventName: (a.hello) - Arguments: (a:2:{s:2:"in";s:45:"closure example in class extending from Event";s:4:"name";s:6:"Bianca";})
// Event Listener with normal function - Sender: (A) - EventName: (a.hello) - Arguments: (a:2:{s:2:"in";s:45:"normal function in class extending from Event";s:4:"name";s:6:"Bianca";})
// Event Listener with method - Sender: (A) - EventName: (a.hello) - Arguments: (a:2:{s:2:"in";s:51:"class->method example in class extending from Event";s:4:"name";s:6:"Bianca";})


// **********************************************
// Example using method: Using EventTrait class.
// **********************************************

class B {

    public function hello($name) {
        echo "Hello! $name<br/>" . PHP_EOL;
    }

}

class C extends \B implements EventInterface {
    use EventTrait;

    const EVENT_HELLO = 'c.hello';

    public function hello($name) {
        parent::hello($name);
        $this->run(self::EVENT_HELLO, array('name' => $name));
    }

}

$C = new \C();
$C->addEventListener(\C::EVENT_HELLO, function(EventInstance $Event) {
    echo \sprintf('Event Listener with Closure - Sender: (%s) - EventName: (%s) - Arguments: (%s)<br/>' . PHP_EOL, get_class($Event->getSender()), $Event->getEventName(), serialize(array_merge($Event->getArgsIn(), $Event->getArgsResult())));
}, array('in' => 'closure example in class using EventTreat'));
$C->hello('Peter');

// Output:
// Hello! Peter
// Event Listener with Closure - Sender: (C) - EventName: (c.hello) - Arguments: (a:2:{s:2:"in";s:41:"closure example in class using EventTreat";s:4:"name";s:5:"Peter";})


// **********************************************
// Example using method: Event Global Manager.
// **********************************************

class D {

    const EVENT_HELLO = 'd.hello';

    public function hello($name) {
        echo "Hello! $name<br/>" . PHP_EOL;
        EventGlobal::run($this, self::EVENT_HELLO, array('name' => $name));
    }

}

EventGlobal::addEventListener(\D::EVENT_HELLO, function(EventInstance $Event) {
    echo \sprintf('Event Listener with Closure - Sender: (%s) - EventName: (%s) - Arguments: (%s)<br/>' . PHP_EOL, get_class($Event->getSender()), $Event->getEventName(), serialize(array_merge($Event->getArgsIn(), $Event->getArgsResult())));
}, array('in' => 'closure example in class using EventGlobal manager'));

$D = new \D();
$D->hello('Ann');

// Output:
// Hello! Ann
// Event Listener with Closure - Sender: (D) - EventName: (d.hello) - Arguments: (a:2:{s:2:"in";s:50:"closure example in class using EventGlobal manager";s:4:"name";s:3:"Ann";})
