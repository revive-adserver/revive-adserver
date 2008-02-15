<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Dal_Maintenance_Priority extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority()
    {
        $this->UnitTestCase();
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
        $oDbh =& OA_DB::singleton();
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
