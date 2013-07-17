<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * Global event dispatcher and listener manager.
 * Until we have ability to register listeners directly on the subject objects,
 * listeners should use this object to register themselves for specific events.
 * Correspondingly, event generator should notify dispatcher of the event so that
 * it could pass on the event to interested parties.
 * 
 * At the moment event is defined by a name and a context. Context is an object wrapping an array
 * of event specific attributes.
 * 
 * Events may be invoked using two methods:
 * <ul>
 *  <li>directly - using dispatcher's triggerEvent() method</li>
 *  <li>proxied - invoking on dispatcher any method starting with "on"</li> 
 * </ul>
 * 
 * Thus, either:
 * 
 * $dispatcher->triggerEvent("onBeforeForm", $context);
 * 
 * or
 * 
 * $dispatcher->onBeforeForm($context);
 * 
 * will result in all listeners registered for "onBeforeForm" event being notified.
 */
class OX_Admin_UI_Event_EventDispatcher
{
    private static $instance;
    
    private $aListeners;
    
    function __construct()
    {
        $this->aListeners = array();
    }

    
    /**
     * Returns the instance of the event dispatcher. 
     *
     * @return OX_Admin_UI_Event_EventDispatcher
     */
    public function getInstance()
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }        
    
    
    /**
     * Registers a given listener for a event with a given name. Subseqent attempts 
     * to register the same listener fo the same event do not add this listener
     * to the listeners list (false will be returned). 
     * In other words listener will be registered once for a given event type.
     *
     * @param string $eventName
     * @param PHP callback $callback
     * @return boolean true if listener was successfully registered, false if 
     * it is already registered
     */
    public function register($eventName, $callback)
    {
        if (!isset($this->aListeners[$eventName])) {
            $this->aListeners[$eventName] = array();
        }
        
        $key = $this->getKey($callback);
        
        //register only if was not registered already
        if (isset($this->aListeners[$eventName][$key])) {
            return false;    
        }
        
        $this->aListeners[$eventName][$key] = $callback;
        return true;
    }
    
    
    
    /**
     * Returns registered listeners for a given eventName. If no listeners were
     * registered returns an empty array;
     *
     * @param string $eventName
     * @return an array of registered listeners for a given event
     */
    public function getRegisteredListeners($eventName)
    {
        if (!isset($this->aListeners[$eventName])) {
            $this->aListeners[$eventName] = array();
        }
        return array_values($this->aListeners[$eventName]); 
    }
    
    
    /**
     * Notifies registered listeners (@see OX_Admin_UI_Event_IEventListener)
     * about event occurence. Listeners are invoked in the order they were registered.
     *
     * @param string $eventName
     * @param array $context
     * @see OX_Admin_UI_Event_IEventListener
     */
    public function triggerEvent($eventName, OX_Admin_UI_Event_EventContext $context)
    {
        $aCallbacks = $this->getRegisteredListeners($eventName);
        
        //enhance context with event name
        $context->eventName = $eventName;  
        
        $result = array();
        //invoke event on listener and collect results 
        foreach ($aCallbacks as $callback) {
            $result[] = call_user_func($callback, $context);
        }
        
        return $result;
    }
    
    
    /**
     * An utility to get key that can be used for a callback
     *
     * @param callback $callback
     */
    protected function getKey($callback)
    {
        $key = null;
        
        if (is_array($callback)) {
            if (is_object($callback[0])) {
                //build key from object class name and method
                $key = get_class($callback[0]).'::'.$callback[1];
            } 
            else {
                //build key from object class name and method
                $key = $callback[0].'::'.$callback[1];
            }
        } 
        else {
            //anonymous callback or even closure, no easy key, use callback itself
            $key = $callback;
        }

        return $key;
    }
    
    
    /**
     * Allow calls on non existent methods which will be forwarded to 
     * triggerEvent method with proper event name and parameters.
     * 
     * The constraints for the serviced method are:
     * <ul>
     *  <li>Invoked method name must start with "on"</li>
     *  <li>parameters must contain single element: an OX_Admin_UI_Event_EventContext
     *  object representing a context for the event</li>
     * </ul> 
     * 
     * @see OX_Admin_UI_Event_EventDispatcher::triggerEvent()
     * @see OX_Admin_UI_Event_EventContext
     * @param string $methodName
     * @param array $parameters
     * @return unknown
     */
    public function __call($methodName, $parameters)
    {
        $pos = strpos($methodName, "on"); 
        
        if ($pos === false) {
            throw new Exception("Tried to call unsupported method: ".$methodName.
                " Proxied calls allow only onX methods for event notifications");
        }
        
        if (count($parameters) != 1 || !($parameters[0] instanceof OX_Admin_UI_Event_EventContext)) {
            throw new Exception("Tried to call an event method ".$methodName." 
                with bad parameters: ".$parameters." Expected 1 parameter of OX_Admin_UI_Event_EventContext type");
        }
        $result =  $this->triggerEvent($methodName, $parameters[0]);
        
        return $result;
    }    
}

?>
