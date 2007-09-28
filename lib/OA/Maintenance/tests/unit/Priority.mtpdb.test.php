<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';

/**
 * @package    OpenadsMaintenance
 * @subpackage TestSuite
 * @author     Alexander J. Tarachanowicz <aj.tarachanowicz@openads.org>
 */
class Test_OA_Maintenance_Priority extends UnitTestCase
{

    function testRun()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $result = OA_Maintenance_Priority::run();
        $this->assertTrue($result);

        $phpPath    = $aConf['test']['phpPath'] .' -f';
        $testPath   = MAX_PATH .'/lib/OA/Maintenance/tests/unit/PriorityFork.php';
        $host       = $_SERVER['SERVER_NAME'];
        system("$phpPath $testPath $host", $result);

        // 0 means it executed successfully, meaning the test was successful
        $this->assertEqual($result, 0);
    }

}

?>