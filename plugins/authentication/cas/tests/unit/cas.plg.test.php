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

if (!isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['REQUEST_URI'] = '/test.php';
}

if (!isset($_SERVER['QUERY_STRING'])) {
    $_SERVER['QUERY_STRING'] = '';
}

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/plugins/authentication/cas/cas.plugin.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dll/User.php';

/**
 * A class for testing the Plugins_Authentication_Cas_Cas class.
 *
 * @package    OpenadsPlugin
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openads.org>
 */
class Test_Plugins_Authentication_Cas_Cas extends UnitTestCase
{
    /**
     * @var Plugins_Authentication_Cas_Cas
     */
    var $internal;

    function Test_Plugins_Authentication_Internal_Internal()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->internal = OA_Auth::staticGetAuthPlugin('cas');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testSuppliedCredentials()
    {
        $ret = $this->internal->suppliedCredentials();
        $this->assertFalse($ret);

        $_GET['ticket'] = 'boo';
        $ret = $this->internal->suppliedCredentials();
        $this->assertTrue($ret);

    }

    function testStorePhpCasSession()
    {
        // store data
        $data = array('boo');
        $_SESSION[OA_CAS_PLUGIN_PHP_CAS] = $data;
        $this->internal->storePhpCasSession();

        // now fetch stored data and test that it was saved
        phpAds_SessionDataFetch();
        global $session;
        $this->assertEqual($session[OA_CAS_PLUGIN_PHP_CAS], $data);

        // clean up
        unset($_SESSION[OA_CAS_PLUGIN_PHP_CAS]);
    }

    function testRestorePhpCasSession()
    {
        $data = array('boo');
        global $session;
        $session[OA_CAS_PLUGIN_PHP_CAS] = $data;
        $this->internal->restorePhpCasSession();
        $this->assertEqual($_SESSION[OA_CAS_PLUGIN_PHP_CAS], $data);
    }

    function testGetUser()
    {
        $username = 'boo';
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = $username;
        DataGenerator::generateOne($doUsers);

        $ret = $this->internal->getUser($username);
        $this->assertIsA($ret, 'DataObjects_Users');
        $this->assertEqual($ret->username, $username);

        $ret = $this->internal->getUser('foo');
        $this->assertNull($ret);
    }

    function testdllValidation()
    {
        Mock::generatePartial(
            'OA_Dll_User',
            'PartialMockOA_Dll_User',
            array('raiseError')
        );

        $dllUserMock = new PartialMockOA_Dll_User();
        $dllUserMock->setReturnValue('raiseError', true);
        $dllUserMock->expectCallCount('raiseError', 5);

        $oUserInfo = new OA_Dll_UserInfo();

        // Test with username set
        $oUserInfo->username = 'foobar';
        $this->assertFalse($this->internal->dllValidation($dllUserMock, $oUserInfo));

        // Test with password set
        unset($oUserInfo->username);
        $oUserInfo->password = 'pwd';
        $this->assertFalse($this->internal->dllValidation($dllUserMock, $oUserInfo));

        // Test with nothing set
        unset($oUserInfo->password);
        $this->assertFalse($this->internal->dllValidation($dllUserMock, $oUserInfo));

        // Test with email set
        $oUserInfo->emailAddress = 'test@example.com';
        $this->assertTrue($this->internal->dllValidation($dllUserMock, $oUserInfo));
        $this->assertTrue($oUserInfo->username);

        // Test edit with username set
        $oUserInfo = new OA_Dll_UserInfo();
        $oUserInfo->userId = 1;
        $oUserInfo->username = 'foobar';
        $this->assertFalse($this->internal->dllValidation($dllUserMock, $oUserInfo));

        // Test edit with password set
        unset($oUserInfo->username);
        $oUserInfo->password = 'pwd';
        $this->assertFalse($this->internal->dllValidation($dllUserMock, $oUserInfo));

        // Test edit with nothing set
        unset($oUserInfo->password);
        $this->assertTrue($this->internal->dllValidation($dllUserMock, $oUserInfo));

        $dllUserMock->tally();
    }
}

?>