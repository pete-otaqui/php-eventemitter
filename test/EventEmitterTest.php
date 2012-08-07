<?php

require_once('PHPUnit/Autoload.php');
require_once(__DIR__.'/../EventEmitter.php');

class EventEmitterTest extends PHPUnit_Framework_TestCase
{

    public function testListenerIsCalled()
    {
        $count = 0;
        $ee = new EventEmitter();
        $ee->on('load', function() use (&$count) {
            $count++;
        });
        $ee->emit('load');
        $this->assertEquals(1, $count);
    }

    public function testListenerIsCalledWithArgument()
    {
        $count = 0;
        $ee = new EventEmitter();
        $ee->on('load', function($n) use (&$count) {
            $count = $n;
        });
        $ee->emit('load', 10);
        $this->assertEquals(10, $count);
    }

    public function testListenersAreCalledMultipleTimes()
    {
        $count = 0;
        $ee = new EventEmitter();
        $ee->on('load', function() use (&$count) {
            $count++;
        });
        $ee->emit('load');
        $ee->emit('load');
        $this->assertEquals(2, $count);
    }

    public function testMultipleListenersAreCalled()
    {
        $count = 0;
        $ee = new EventEmitter();
        $ee->on('load', function() use (&$count) {
            $count++;
        });
        $ee->on('load', function() use (&$count) {
            $count++;
        });
        $ee->emit('load');
        $this->assertEquals(2, $count);
    }

    public function testSoleListenerIsRemoved()
    {
        $count = 0;
        $ee = new EventEmitter();
        $function = function() use (&$count) {
            $count++;
        };
        $ee->on('load', $function);
        $ee->removeListener('load', $function);
        $ee->emit('load');
        $this->assertEquals(0, $count);
    }

    public function testOneListenerIsRemoved()
    {
        $count = 0;
        $ee = new EventEmitter();
        $function = function() use (&$count) {
            $count++;
        };
        $ee->on('load', $function);
        $ee->on('save', $function);
        $ee->removeListener('load', $function);
        $ee->emit('load');
        $ee->emit('save');
        $this->assertEquals(1, $count);
    }

    public function testMultipleListenersAreRemoved()
    {
        $count = 0;
        $ee = new EventEmitter();
        $function = function() use (&$count) {
            $count++;
        };
        $ee->on('load', $function);
        $ee->on('save', $function);
        $ee->removeListener('load', $function);
        $ee->removeListener('save', $function);
        $ee->emit('load');
        $ee->emit('save');
        $this->assertEquals(0, $count);
    }

    public function testAllListenersAreRemoved()
    {
        $count = 0;
        $ee = new EventEmitter();
        $ee->on('load', function() use (&$count) {
            $count++;
        });
        $ee->on('load', function() use (&$count) {
            $count++;
        });
        $ee->removeListener('load');
        $ee->emit('load');
        $this->assertEquals(0, $count);
    }

}
