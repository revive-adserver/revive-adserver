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

/**
 * A class for testing the OA_Auth class
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class Test_OA_Auth extends UnitTestCase
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Tests that default authentication plugin is correctly created
     *
     */
    function testStaticGetAuthPlugin()
    {
        $authInternal = OA_Auth::staticGetAuthPlugin('internal');
        $this->assertIsA($authInternal, 'Plugins_Authentication');
        $authInternal2 = OA_Auth::staticGetAuthPlugin('internal');
        $this->assertIdentical($authInternal, $authInternal2);

        $authDefault = OA_Auth::staticGetAuthPlugin();
        $this->assertIsA($authInternal, 'Plugins_Authentication');
    }
}

?>