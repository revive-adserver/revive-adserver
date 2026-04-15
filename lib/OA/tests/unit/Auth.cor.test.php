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
require_once MAX_PATH . '/lib/OA/Auth.php';

use RV\Auth\AuthContext;

/**
 * A class for testing the OA_Auth class
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class Test_OA_Auth extends UnitTestCase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Tests that default authentication plugin is correctly created
     *
     */
    public function testStaticGetAuthPlugin()
    {
        $authInternal = OA_Auth::staticGetAuthPlugin('internal');
        $this->assertIsA($authInternal, 'Plugins_Authentication');
        $authInternal2 = OA_Auth::staticGetAuthPlugin('internal');
        $this->assertIdentical($authInternal, $authInternal2);

        $authDefault = OA_Auth::staticGetAuthPlugin();
        $this->assertIsA($authInternal, 'Plugins_Authentication');
    }

    public function testIsLoggedIn(): void
    {
        global $session;

        /** @var DataObjects_Users $doUser */
        $doUser = OA_Dal::factoryDO('users');

        // Not logged in
        $session['user'] = false;
        $this->assertFalse(OA_Auth::isLoggedIn());

        // Logged into the UI
        $session['user'] = new OA_Permission_User($doUser, true);
        $this->assertTrue(OA_Auth::isLoggedIn());
        $this->assertFalse(OA_Auth::isLoggedIn(AuthContext::API));

        // Logged into the API
        $session['user'] = new OA_Permission_User($doUser, true, AuthContext::API);
        $this->assertFalse(OA_Auth::isLoggedIn());
        $this->assertTrue(OA_Auth::isLoggedIn(AuthContext::API));
    }
}
