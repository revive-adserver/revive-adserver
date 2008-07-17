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

require_once MAX_PATH . '/lib/OA/Sync.php';

/**
 * A class for testing the OA_Sync class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
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
        $aVersions = array(
            'v2.3.32-beta-rc10' => 2332.110,
            '2.3.32-beta-rc11'  => 2332.111,
            'v2.3.32-beta'      => 2332.200,
            '2.3.33-beta-rc1'   => 2333.101,
            'v2.3.33-beta'      => 2333.200,
            '2.4.0-rc1'         => 2400.301,
            'v2.4.0-rc2'        => 2400.302,
            '2.4.0'             => 2400.400,
            'v2.4.0-stable'     => 2400.400,
            '2.5.0-dev'         => 2499.999,

            '2.5.99-dev-custom'     => 2598.999,
            '2.6.0-beta-rc2-custom' => 2600.102,
            '2.6.0-beta-custom'     => 2600.200,
            '2.6.0-rc57-custom'     => 2600.357,
            '2.6.0-custom'          => 2600.400,

            'foo'               => false
        );

        foreach ($aVersions as $version => $config_version) {
            $this->assertEqual($oSync->getConfigVersion($version), $config_version);
        }
    }

}

?>