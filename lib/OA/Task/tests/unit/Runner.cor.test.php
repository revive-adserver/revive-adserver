<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/lib/OA/Task.php';
require_once MAX_PATH . '/lib/OA/Task/Runner.php';

/**
 * A class for testing the OA_Task_Runner class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Task_Runner extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Task_Runner()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the class constructor.
     */
    function testOA_Task_Runner()
    {
        $oTaskRunner = new OA_Task_Runner();
        $this->assertTrue(is_object($oTaskRunner));
        $this->assertTrue(is_a($oTaskRunner, 'OA_Task_Runner'));
    }

    /**
     * A method to test addition of tasks to the task runner.
     */
    function testAddTask()
    {
        // Generate a partial mock of the task class
        Mock::generatePartial('OA_Task', 'MockTask0', array('run'));
        $oTask0 = new MockTask0($this);
        Mock::generatePartial('OA_Task', 'MockTask1', array('run'));
        $oTask1 = new MockTask1($this);
        Mock::generatePartial('OA_Task', 'MockTask2', array('run'));
        $oTask2 = new MockTask2($this);
        Mock::generatePartial('OA_Task', 'MockTask3', array('run'));
        $oTask3 = new MockTask3($this);
        Mock::generatePartial('OA_Task', 'MockTask4', array('run'));
        $oTask4 = new MockTask4($this);

        // Create a task runner, and test addition of classes
        $oTaskRunner = new OA_Task_Runner();
        $this->assertEqual(count($oTaskRunner->aTasks), 0);

        $return = $oTaskRunner->addTask('foo');
        $this->assertFalse($return);
        $this->assertEqual(count($oTaskRunner->aTasks), 0);

        $return = $oTaskRunner->addTask($oTask0);
        $this->assertTrue($return);
        $this->assertEqual(count($oTaskRunner->aTasks), 1);
        $oTask = $oTaskRunner->aTasks[0];
        $this->assertIsA($oTask, 'MockTask0');

        $return = $oTaskRunner->addTask($oTask1);
        $this->assertTrue($return);
        $this->assertEqual(count($oTaskRunner->aTasks), 2);
        $oTask = $oTaskRunner->aTasks[0];
        $this->assertIsA($oTask, 'MockTask0');
        $oTask = $oTaskRunner->aTasks[1];
        $this->assertIsA($oTask, 'MockTask1');

        // Add after task
        $return = $oTaskRunner->addTask($oTask2, 'MockTask0', OA_Task_Runner::TASK_ORDER_AFTER);
        $this->assertTrue($return);
        $this->assertEqual(count($oTaskRunner->aTasks), 3);
        $oTask = $oTaskRunner->aTasks[0];
        $this->assertIsA($oTask, 'MockTask0');
        $oTask = $oTaskRunner->aTasks[1];
        $this->assertIsA($oTask, 'MockTask2');
        $oTask = $oTaskRunner->aTasks[2];
        $this->assertIsA($oTask, 'MockTask1');

        $return = $oTaskRunner->addTask($oTask2, 'InvalidClassName', OA_Task_Runner::TASK_ORDER_AFTER);
        $this->assertFalse($return);

        // Replace task
        $return = $oTaskRunner->addTask($oTask3, 'MockTask2', OA_Task_Runner::TASK_ORDER_REPLACE);
        $this->assertTrue($return);
        $this->assertEqual(count($oTaskRunner->aTasks), 3);
        $oTask = $oTaskRunner->aTasks[0];
        $this->assertIsA($oTask, 'MockTask0');
        $oTask = $oTaskRunner->aTasks[1];
        $this->assertIsA($oTask, 'MockTask3');
        $oTask = $oTaskRunner->aTasks[2];
        $this->assertIsA($oTask, 'MockTask1');

        $return = $oTaskRunner->addTask($oTask3, 'InvalidClassName', OA_Task_Runner::TASK_ORDER_REPLACE);
        $this->assertFalse($return);

        // Add before task
        $return = $oTaskRunner->addTask($oTask4, 'MockTask0', OA_Task_Runner::TASK_ORDER_BEFORE);
        $this->assertTrue($return);
        $this->assertEqual(count($oTaskRunner->aTasks), 4);
        $oTask = $oTaskRunner->aTasks[0];
        $this->assertIsA($oTask, 'MockTask4');
        $oTask = $oTaskRunner->aTasks[1];
        $this->assertIsA($oTask, 'MockTask0');
        $oTask = $oTaskRunner->aTasks[2];
        $this->assertIsA($oTask, 'MockTask3');
        $oTask = $oTaskRunner->aTasks[3];
        $this->assertIsA($oTask, 'MockTask1');

        $return = $oTaskRunner->addTask($oTask4, 'InvalidClassName', OA_Task_Runner::TASK_ORDER_BEFORE);
        $this->assertFalse($return);

    }

}

?>
