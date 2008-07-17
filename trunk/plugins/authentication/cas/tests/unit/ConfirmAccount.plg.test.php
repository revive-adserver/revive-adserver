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

if (!isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['REQUEST_URI'] = '/test.php';
}

if (!isset($_SERVER['QUERY_STRING'])) {
    $_SERVER['QUERY_STRING'] = '';
}

require_once MAX_PATH . '/plugins/authentication/cas/Controller/ConfirmAccount.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dll/User.php';

/**
 * A class for testing the Plugins_Authentication_Cas_Cas class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class Test_ConfirmAccount extends UnitTestCase
{
    function Test_ConfirmAccount()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
    }

    function tearDown()
    {
    }

    function testCheckIfSsoUserExists()
    {
        // generate one users to ensure his ID is != 1
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'boo' . 1;
        DataGenerator::generate('users');
        
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'boo' . 2;
        $doUsers->sso_user_id = $ssoUserId = 123;
        $userId = DataGenerator::generateOne($doUsers);
        
        $ret = OA_Controller_SSO_ConfirmAccount::checkIfSsoUserExists($ssoUserId);
        $this->assertEqual($ret, $userId);
        
        $ret = OA_Controller_SSO_ConfirmAccount::checkIfSsoUserExists(12345);
        $this->assertFalse($ret);
    }
}

?>