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

require_once MAX_PATH . '/init-delivery-parse.php';

/**
 * A class for testing the OA_Sync class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_ConfParse extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_ConfParse()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the getConfigVersion() method.
     */
    function test_parseDeliveryIniFile()
    {
        $host = getHostName();

        copy(MAX_PATH.'/lib/OA/tests/data/test.demo.conf.php',MAX_PATH.'/var/'.$host.'.test.demo.conf.php');
        copy(MAX_PATH.'/lib/OA/tests/data/test.real.conf.php',MAX_PATH.'/var/test.real.conf.php');

        $result = parseDeliveryIniFile('','test.demo');

        $this->assertIsA($result,'array');
        $this->assertTrue(isset($result['database']));
        $this->assertEqual($result['database']['username'],'demo_user');
        $this->assertEqual($result['database']['password'],'demo_pass');
        $this->assertEqual($result['database']['name'],'demo_name');
        $this->assertTrue(isset($result['real']));
        $this->assertEqual($result['real']['key1'],'val1');
        $this->assertEqual($result['real']['key2'],'val2');

        @unlink(MAX_PATH.'/var/'.$host.'.test.demo.conf.php');
        @unlink(MAX_PATH.'/var/test.real.conf.php');
    }

}

?>