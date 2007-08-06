<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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

require_once MAX_PATH . '/lib/OA/Sync.php';

/**
 * A class for testing the OA_Sync class.
 *
 * @package    Openads
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Sync extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Sync()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the getConfigVersion() method.
     */
    function testGetConfigVersion()
    {
        $oSync = new OA_Sync();

        // Prepare sample ascending versions
        $version1 = 'v2.3.32-beta-rc10';
        $version2 = '2.3.32-beta-rc11';
        $version3 = 'v2.3.32-beta';
        $version4 = '2.3.33-beta-rc1';
        $version5 = 'v2.3.33-beta';
        $version6 = '2.4.0-rc1';
        $version6 = 'v2.4.0-rc2';
        $version7 = '2.4.0';

        // Prepare config version numbers
        $phpVersion1 = $oSync->getConfigVersion($version1);
        $phpVersion2 = $oSync->getConfigVersion($version2);
        $phpVersion3 = $oSync->getConfigVersion($version3);
        $phpVersion4 = $oSync->getConfigVersion($version4);
        $phpVersion5 = $oSync->getConfigVersion($version5);
        $phpVersion6 = $oSync->getConfigVersion($version6);
        $phpVersion7 = $oSync->getConfigVersion($version7);

        // Ensure that versions are in correct order
        $this->assertTrue($phpVersion1 < $phpVersion2);
        $this->assertTrue($phpVersion2 < $phpVersion3);
        $this->assertTrue($phpVersion3 < $phpVersion4);
        $this->assertTrue($phpVersion4 < $phpVersion5);
        $this->assertTrue($phpVersion5 < $phpVersion6);
        $this->assertTrue($phpVersion6 < $phpVersion7);
    }

}

?>