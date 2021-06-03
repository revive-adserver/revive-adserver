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

require_once MAX_PATH.'/lib/OX/Admin/UI/Event/EventDispatcher.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Event/EventContext.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Event/tests/unit/TestEventListener.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Event/tests/unit/ModifyingTestEventListener.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Event/tests/unit/TestDummyObject.php';

/**
 * A class for testing the OX_Admin_UI_Event_Dispatcher class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 */
class Test_OX_Admin_UI_Event_EventDispatcher
    extends UnitTestCase
{
    function setUp()
    {
    }


    function tearDown()
    {
    }


    function testSingleton()
    {
    	//nimm 2 ;-)
    	$instance1 = OX_Admin_UI_Event_EventDispatcher::getInstance();
    	$instance2 = OX_Admin_UI_Event_EventDispatcher::getInstance();
    	$this->assertReference($instance1, $instance2);
    	$this->assertIdentical($instance1, $instance2);
    }


    function testRegister()
    {
        $dispatcher = new OX_Admin_UI_Event_EventDispatcher();
        $listener = array(new Test_OX_Admin_UI_Event_TestEventListener(), 'onUpdate');
        $eventName =  "onFakeEvent";

        $result = $dispatcher->register($eventName, $listener);
        $this->assertTrue($result);
        $returnedListeners = $dispatcher->getRegisteredListeners($eventName);

        $this->assertEqual(1, count($returnedListeners));
        $this->checkIdenticalListeners($listener, $returnedListeners[0]);

        //anonymous function
        $listener2 = function(OX_Admin_UI_Event_EventContext $context) {
            $context->data["callcount"] = $context->data["callcount"]++;
            return $context;
        };

        $result = $dispatcher->register($eventName, $listener2);
        $this->assertTrue($result);
        $returnedListeners = $dispatcher->getRegisteredListeners($eventName);

        $this->assertEqual(2, count($returnedListeners));
        $this->checkIdenticalListeners($listener, $returnedListeners[0]);
        $this->checkIdenticalListeners($listener2, $returnedListeners[1]);


        //global function
        $listener3 = 'listener3';
        $result = $dispatcher->register($eventName, $listener3);
        $this->assertTrue($result);
        $returnedListeners = $dispatcher->getRegisteredListeners($eventName);

        $this->assertEqual(3, count($returnedListeners));
        $this->checkIdenticalListeners($listener, $returnedListeners[0]);
        $this->checkIdenticalListeners($listener2, $returnedListeners[1]);
        $this->checkIdenticalListeners($listener3, $returnedListeners[2]);
    }


    function testRegisterTwice()
    {
        $dispatcher = new OX_Admin_UI_Event_EventDispatcher();
        $listener = array(new Test_OX_Admin_UI_Event_TestEventListener(), 'onUpdate');
        $eventName =  "onFakeEvent";

        $result = $dispatcher->register($eventName, $listener);
        $this->assertTrue($result);
        $returnedListeners = $dispatcher->getRegisteredListeners($eventName);

        $this->assertEqual(1, count($returnedListeners));
        $this->checkIdenticalListeners($listener, $returnedListeners[0]);

        //register once more
        $result = $dispatcher->register($eventName, $listener);
        $this->assertFalse($result);
        $returnedListeners = $dispatcher->getRegisteredListeners($eventName);
        $this->assertEqual(1, count($returnedListeners));
        $this->checkIdenticalListeners($listener, $returnedListeners[0]);
    }


    function testRegisteredListeners()
    {
        $dispatcher = new OX_Admin_UI_Event_EventDispatcher();
        $listener = array(new Test_OX_Admin_UI_Event_TestEventListener(), 'onUpdate');
        $eventName =  "onFakeEvent";

        $dispatcher->register($eventName, $listener);
        $returnedListeners = $dispatcher->getRegisteredListeners($eventName);

        $this->assertEqual(1, count($returnedListeners));
        $this->checkIdenticalListeners($listener, $returnedListeners[0]);
    }


    function testTriggerEvent()
    {
        $dispatcher = new OX_Admin_UI_Event_EventDispatcher();
        $listener = array(new Test_OX_Admin_UI_Event_TestEventListener(), 'onUpdate');
        $listener2 = function (OX_Admin_UI_Event_EventContext $context) {
            if (isset($context->data["callcount"])) {
                $context->data["callcount"]++;
            } else {
                $context->data["callcount"] = 1;
            }

            return $context;
        };
        $listener3 = 'listener3';

        $eventName =  "onFakeEvent";
        $context1 = new OX_Admin_UI_Event_EventContext();
        $context1->data = array(1, "2", "three");
        $context2 = new OX_Admin_UI_Event_EventContext();
        $context2->data = array(2, "4", "four");

        $dispatcher->register($eventName, $listener);
        $dispatcher->register($eventName, $listener2);
        $dispatcher->register($eventName, $listener3);

        //invoke event
        $dispatcher->triggerEvent($eventName, $context1);
        $this->assertEqual(1, $listener[0]->aCallCount[$eventName]['count']);
        $this->assertEqual($context1, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertReference($context1, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertIdentical($context1, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertIdentical(3, $context1->data['callcount']);


        //invoke event once more
        $dispatcher->triggerEvent($eventName, $context2);
        $this->assertEqual(2, $listener[0]->aCallCount[$eventName]['count']);
        $this->assertEqual($context2, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertReference($context2, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertIdentical($context2, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertIdentical(3, $context2->data['callcount']);
    }


    function testTriggerEventByCall()
    {
        $dispatcher = new OX_Admin_UI_Event_EventDispatcher();
        $listener = array(new Test_OX_Admin_UI_Event_TestEventListener(), 'onUpdate');
        $eventName =  "onFakeEvent";
        $context1 = new OX_Admin_UI_Event_EventContext();
        $context1->data = array(1, "2", "three");
        $context2 = new OX_Admin_UI_Event_EventContext();
        $context2->data = array(2, "4", "four");

        $dispatcher->register($eventName, $listener);
        $dispatcher->$eventName($context1);

        //invoke event
        $this->assertEqual(1, $listener[0]->aCallCount[$eventName]['count']);
        $this->assertEqual($context1, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertReference($context1, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertIdentical($context1, $listener[0]->aCallCount[$eventName]['lastContext']);

        //invoke event once more
        $dispatcher->$eventName($context2);
        $this->assertEqual(2, $listener[0]->aCallCount[$eventName]['count']);
        $this->assertEqual($context2, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertReference($context2, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertIdentical($context2, $listener[0]->aCallCount[$eventName]['lastContext']);
    }


    function testTriggerEventWithModifyingContext()
    {
        $dispatcher = new OX_Admin_UI_Event_EventDispatcher();
        $listener = array(new Test_OX_Admin_UI_Event_ModifyingTestEventListener(), 'onUpdate');

        $eventName =  "onFakeEvent";
        $dummyObject = new TestDummyObject();
        $context = new OX_Admin_UI_Event_EventContext();
        $context->data = array(1, "2", "three", "dummy" => $dummyObject);

        $dispatcher->register($eventName, $listener);

        //invoke event
        $dispatcher->triggerEvent($eventName, $context);

        //check if listener was actually invoked
        $this->assertEqual(1, $listener[0]->aCallCount[$eventName]['count']);
        $this->assertEqual($context, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertReference($context, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertReference($dummyObject, $listener[0]->aCallCount[$eventName]['lastContext']->data['dummy']);

        //check if back modifications were passed on to the context
        $tmp = $context->$eventName;
        $this->assertEqual(1, $tmp['count']);
        $this->assertReference($dummyObject, $context->data['dummy']);
        $this->assertTrue(isset($dummyObject->id));
    }


    function testCallNonExistentEvent()
    {
        $dispatcher = new OX_Admin_UI_Event_EventDispatcher();
        $listener = array(new Test_OX_Admin_UI_Event_TestEventListener(), 'onUpdate');

        //invoke custom on method
        $eventName1 =  "onFakeEvent";
        $dispatcher->register($eventName1, $listener);
        $this->checkCustomEvent($eventName1, $dispatcher, $listener);

        //call another event
        $eventName2 =  "onFakeEvent2";
        $dispatcher->register($eventName2, $listener);
        $this->checkCustomEvent($eventName2, $dispatcher, $listener);
    }

    function testCallNonExistentEventWithModifyingContext()
    {
        $dispatcher = new OX_Admin_UI_Event_EventDispatcher();
        $listener = array(new Test_OX_Admin_UI_Event_ModifyingTestEventListener(), 'onUpdate');
        $eventName =  "onFakeEvent";
        $dummyObject = new TestDummyObject();
        $context = new OX_Admin_UI_Event_EventContext();
        $context->data = array(1, "2", "three", "dummy" => $dummyObject);

        $dispatcher->register($eventName, $listener);


        //invoke event by proxy
        $dispatcher->$eventName($context);

        //check if listener was actually invoked
        $this->assertEqual(1, $listener[0]->aCallCount[$eventName]['count']);
        $this->assertEqual($context, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertReference($dummyObject, $listener[0]->aCallCount[$eventName]['lastContext']->data['dummy']);

        //check if back modifications were passed on to the context
        $tmp = $context->$eventName;
        $this->assertEqual(1, $tmp['count']);
        $this->assertReference($dummyObject, $context->data['dummy']);
        $this->assertIdentical($dummyObject, $listener[0]->aCallCount[$eventName]['lastContext']->data['dummy']);
        $this->assertTrue(isset($dummyObject->id));
    }


    function checkCustomEvent($eventName, $dispatcher, $listener)
    {
        $context1 = new OX_Admin_UI_Event_EventContext();
        $context1->data = array(1, "2", "three");
        $context2 = new OX_Admin_UI_Event_EventContext();
        $context2->data = array(2, "4", "four");

        //invoke custom on method
        $dispatcher->$eventName($context1);

        $this->assertEqual(1, $listener[0]->aCallCount[$eventName]['count']);
        $this->assertEqual($context1, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertReference($context1, $listener[0]->aCallCount[$eventName]['lastContext']);

        //invoke event once more
        $dispatcher->$eventName($context2);
        $this->assertEqual(2, $listener[0]->aCallCount[$eventName]['count']);
        $this->assertEqual($context2, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertReference($context2, $listener[0]->aCallCount[$eventName]['lastContext']);

        //invoke normally
        $dispatcher->triggerEvent($eventName, $context1);
        $this->assertEqual(3, $listener[0]->aCallCount[$eventName]['count']);
        $this->assertEqual($context1, $listener[0]->aCallCount[$eventName]['lastContext']);
        $this->assertReference($context1, $listener[0]->aCallCount[$eventName]['lastContext']);
    }


    protected function checkIdenticalListeners($expected, $actual)
    {
        if (is_array($expected)) {
            $this->assertTrue(is_array($actual));
            if (is_object($expected[0])) {
                $this->assertReference($expected[0], $actual[0]);
            }
            $this->assertIdentical($expected[0], $actual[0]);
            $this->assertIdentical($expected[1], $actual[1]);
        }
        else {
            $this->assertIdentical($expected, $actual);
        }
    }

}

function listener3(OX_Admin_UI_Event_EventContext $context)
{
    if (isset($context->data["callcount"])) {
        $context->data["callcount"]++;
    }
    else {
        $context->data["callcount"] = 1;
    }

    return $context;
}

?>
