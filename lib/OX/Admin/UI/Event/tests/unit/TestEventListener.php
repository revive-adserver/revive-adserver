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

class Test_OX_Admin_UI_Event_TestEventListener 
{
    public $aCallCount;
    
    function __construct()
    {
        $this->aCallCount = array();
    }
    
    
    function onUpdate(OX_Admin_UI_Event_EventContext $context)
    {
        $eventName = $context->eventName;
        unset($context->eventName);
        
        if (isset($context->data["callcount"])) {
            $context->data["callcount"]++;
        }
        else {
            $context->data["callcount"] = 1;
        }

        if (isset($this->aCallCount[$eventName]['count'])) {
            ++$this->aCallCount[$eventName]['count'];
        } else {
            $this->aCallCount[$eventName]['count'] = 1;
        }

        $this->aCallCount[$eventName]['lastContext'] = $context;
    }
}

?>
