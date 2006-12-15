<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/core/Task.php';
require_once MAX_PATH . '/lib/max/core/Task/Runner.php';
require_once MAX_PATH . '/lib/simpletest/mock_objects.php';

/**
 * A class for testing the MAX_Core_Task_Runner class.
 *
 * @package    Max
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Demian Turner <demian@m3.net>
 */
class TestOfMAX_Core_Task_Runner extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function TestOfMAX_Core_Task_Runner()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the class constructor.
     */
    function testMAX_Core_Task_Runner()
    {
        $oTaskRunner = new MAX_Core_Task_Runner();
        $this->assertTrue(is_object($oTaskRunner));
        $this->assertTrue(is_a($oTaskRunner, 'MAX_Core_Task_Runner'));
    }

    /**
     * A method to test addition of tasks to the task runner.
     */
    function testAddTask()
    {
        // Generate a partial mock of the task class
        Mock::generatePartial('MAX_Core_Task', 'MockTask0', array('run'));
        $oTask0 = new MockTask0($this);
        Mock::generatePartial('MAX_Core_Task', 'MockTask1', array('run'));
        $oTask1 = new MockTask1($this);
        Mock::generatePartial('MAX_Core_Task', 'MockTask2', array('run'));
        $oTask2 = new MockTask2($this);

        // Create a task runner, and test addition of classes
        $oTaskRunner = new MAX_Core_Task_Runner();
        $this->assertEqual(count($oTaskRunner->aTasks), 0);

        $return = $oTaskRunner->addTask('foo');
        $this->assertFalse($return);
        $this->assertEqual(count($oTaskRunner->aTasks), 0);

        $return = $oTaskRunner->addTask($oTask0);
        $this->assertTrue($return);
        $this->assertEqual(count($oTaskRunner->aTasks), 1);
        $oTask = $oTaskRunner->aTasks[0];
        $this->assertTrue(is_a($oTask, 'MockTask0'));

        $return = $oTaskRunner->addTask($oTask1);
        $this->assertTrue($return);
        $this->assertEqual(count($oTaskRunner->aTasks), 2);
        $oTask = $oTaskRunner->aTasks[0];
        $this->assertTrue(is_a($oTask, 'MockTask0'));
        $oTask = $oTaskRunner->aTasks[1];
        $this->assertTrue(is_a($oTask, 'MockTask1'));

        $return = $oTaskRunner->addTask($oTask2, 'MockTask0');
        $this->assertTrue($return);
        $this->assertEqual(count($oTaskRunner->aTasks), 3);
        $oTask = $oTaskRunner->aTasks[0];
        $this->assertTrue(is_a($oTask, 'MockTask0'));
        $oTask = $oTaskRunner->aTasks[1];
        $this->assertTrue(is_a($oTask, 'MockTask2'));
        $oTask = $oTaskRunner->aTasks[2];
        $this->assertTrue(is_a($oTask, 'MockTask1'));
    }

}

?>
