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

require_once MAX_PATH . '/lib/Max.php';

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Common.php';
require_once 'Date.php';

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_Common class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Dal_Maintenance_Statistics_Common extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_Common()
    {
        $this->UnitTestCase();
    }

    /**
     * Tests the constructor method.
     */
    function testConstructor()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dsc = new OA_Dal_Maintenance_Statistics_Common();
        // Only test the constructor code specific to the OA_Dal_Maintenance_Statistics_Common class
        $this->assertEqual(strtolower(get_class($dsc->tables)), strtolower('OA_DB_Table_Core'));
        $this->assertEqual(strtolower(get_class($dsc->tempTables)), strtolower('OA_DB_Table_Statistics'));
    }

}

?>
