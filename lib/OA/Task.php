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
 * A abstract class, defining an interface for Task objects, to be collected
 * and run using the OA_Task_Runner calss.
 *
 * @abstract
 * @package    OpenX
 * @subpackage Tasks
 */
class OA_Task
{
    /**
     * A abstract method that needs to be implemented in child Task classes,
     * which will be called when the task needs to be performed.
     *
     * @abstract
     * @todo This method should really return a boolean.
     */
    public function run()
    {
        return;
    }
}
