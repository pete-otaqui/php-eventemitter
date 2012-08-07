<?php

class EventEmitter
{

    private $listeners = array();
    public function on($event, $listener)
    {
        if  ( !array_key_exists($event, $this->listeners) ) {
            $this->listeners[$event] = array();
        }
        $this->listeners[$event][] = $listener;
    }
    public function emit($event, $arguments=NULL)
    {
        if  ( !array_key_exists($event, $this->listeners) ) {
            $this->listeners[$event] = array();
        }
        foreach ( $this->listeners[$event] as $listener ) {
            $listener($arguments);
        }
    }
    public function removeListener($event, $listener=NULL)
    {
        if  ( !array_key_exists($event, $this->listeners) ) {
            return FALSE;
            $this->listeners[$event] = array();
        }
        if ( $listener !== NULL ) {
            foreach ( $this->listeners[$event] as $key=>$eventListener ) {
                if ( $eventListener === $listener ) {
                    unset($this->listeners[$event][$key]);
                    return TRUE;
                }
            }
            return FALSE;
        } else {
            $this->listeners[$event] = array();
            return TRUE;
        }

    }
}
