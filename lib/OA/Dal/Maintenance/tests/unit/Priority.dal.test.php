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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal_Maintenance_Priority extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * A method for testing the obtainPriorityLock and
     * releasePriorityLock methods.
     *
     * @TODO Complete testing using a separate client connection to
     *       ensure locking works.
     */
    function testLocking()
    {
        $oDbh = OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Priority();
        // Try to get the lock
        $result = $oDal->obtainPriorityLock();
        $this->assertTrue($result);
        // Try to get the lock again, with a brand new connection,
        // and ensure that the lock is NOT obtained

        // Release the lock
        $result = $oDal->releasePriorityLock();
        $this->assertTrue($result);
        // Try to get the lock again with the new connection, and
        // ensure the lock IS obtained

        // Release the lock from the new connection

    }

}

?>
