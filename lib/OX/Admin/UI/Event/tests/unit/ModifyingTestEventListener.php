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

class Test_OX_Admin_UI_Event_ModifyingTestEventListener
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

        //modify it
        $tmp = &$context->$eventName;
        $tmp['count'] = isset($tmp['count']) ? $tmp['count'] + 1 : 1;
        $dummyObject = $context->data['dummy'];
        $dummyObject->id = $eventName;

        //store it for test comparisons
        if (isset($this->aCallCount[$eventName]['count'])) {
            ++$this->aCallCount[$eventName]['count'];
        } else {
            $this->aCallCount[$eventName]['count'] = 1;
        }

        $this->aCallCount[$eventName]['lastContext'] = $context;

    }
}

?>
