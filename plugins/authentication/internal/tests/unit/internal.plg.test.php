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
$Id: GeoIP.plg.test.php 12393 2007-11-14 15:53:36Z andrew.hill@openads.org $
*/

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the Plugins_Authentication_Internal_Internal class.
 *
 * @package    OpenadsPlugin
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openads.org>
 */
class Test_Plugins_Authentication_Internal_Internal extends UnitTestCase
{
    /**
     * @var Plugins_Authentication_Internal_Internal
     */
    var $internal;
    
    function Test_Plugins_Authentication_Internal_Internal()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->internal =  OA_Auth::staticGetAuthPlugin('internal');
    }

    function testSuppliedCredentials()
    {
        $ret = $this->internal->suppliedCredentials();
        $this->assertFalse($ret);
        
        $_POST['username'] = 'boo';
        $_POST['password'] = 'foo';
        $ret = $this->internal->suppliedCredentials();
        $this->assertTrue($ret);
        
    }

    function testAuthenticateUser()
    {
        $username = 'boo';
        $password = 'foo';
        
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = $username;
        $doUsers->password = md5($password);
        DataGenerator::generateOne($doUsers);
        
        $_POST['username'] = $username;
        $_POST['password'] = $password;
        $_COOKIE['sessionID'] = $_POST['oa_cookiecheck'] = 'baz';
        $ret = $this->internal->authenticateUser();
        $this->assertIsA($ret, 'DataObjects_Users');
        $this->assertEqual($doUsers->username, $username);
        
        $_POST['password'] = $password.rand();
        $ret = $this->internal->authenticateUser();
        $this->assertFalse($ret);
    }
}

?>