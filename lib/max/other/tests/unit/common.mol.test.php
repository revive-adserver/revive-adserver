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

require_once MAX_PATH . '/lib/max/other/common.php';

/*
 * A class for testing the lib-geometry.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class CommonTest extends UnitTestCase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function test_MAX_isAnonymous()
    {
        $this->assertTrue(MAX_isAnonymous(true));
        $this->assertTrue(MAX_isAnonymous('t'));
        $this->assertFalse(MAX_isAnonymous(false));
        $this->assertFalse(MAX_isAnonymous('f'));
    }

    public function test_MAX_commonSlashArray()
    {
        $this->sendMessage('test_MAX_commonSlashArray');
        $strIn0 = "Mr O\'Reilly";
        $strIn1 = '"Mr Reilly"\n';
        $strRe0 = addslashes($strIn0);
        $strRe1 = addslashes($strIn1);

        $aIn = [0 => $strIn0,
            1 => [0 => $strIn1],
        ];
        $aRet = MAX_commonSlashArray($aIn);

        $this->assertEqual($aRet[0], $strRe0);
        $this->assertEqual($aRet[1][0], $strRe1);
    }


    public function test_MAX_commonUnslashArray()
    {
        $sValue = 'abcd';
        $this->assertEqual('abcd', MAX_commonUnslashArray($sValue));
        $sValue = 'ab\\cd';
        $this->assertEqual('abcd', MAX_commonUnslashArray($sValue));
        $sValue = 'ab\\\\cd';
        $this->assertEqual('ab\\cd', MAX_commonUnslashArray($sValue));
        $aValue = ['abcd', 'ab\\cd', 'ab\\\\cd'];
        $this->assertEqual(['abcd', 'abcd', 'ab\\cd'], MAX_commonUnslashArray($aValue));
        $aValue = ['abcd', 'ab\\cd', 'ab\\\\cd', ['abcd', 'ab\\\\cd']];
        $this->assertEqual(['abcd', 'abcd', 'ab\\cd', ['abcd', 'ab\\cd']], MAX_commonUnslashArray($aValue));
    }


    public function test_Max_commonGetValueSlashed()
    {
        // Please see the description below
        //        $_REQUEST['aaa'] = 'blah\'';
        //        $this->assertEqual('blah\\\'', MAX_commonGetValue('aaa'));
        //        $this->assertEqual('ccc', MAX_commonGetValue('ddd', 'ccc'));
        //        $this->assertNull(MAX_commonGetValue('ddd'));
    }


    public function test_Max_commonGetValueUnslashed()
    {
        // Please let me know how to test such functionality in PHP if I can't change
        // the php configuration run-time? We need some facility for running some
        // tests in different configurations.
        //        $_REQUEST['aaa'] = 'blah\\\'';
        //        $this->assertEqual('blah\'', MAX_commonGetValueUnslashed('aaa'));
    }


    public function test_MAX_commonGetPostValueUnslashed()
    {
        $post = $_POST;
        $get = $_GET;
        $cookie = $_COOKIE;
        $request = $_REQUEST;
        $_POST = [];
        $_GET = [];
        $_COOKIE = $_REQUEST = ['legacy' => 'cookie'];

        $this->assertNull(MAX_commonGetPostValueUnslashed('legacy'));
        $this->assertIdentical(MAX_commonGetPostValueUnslashed('legacy', ' default '), 'default');
        $_GET['legacy'] = ' get ';
        $this->assertIdentical(MAX_commonGetPostValueUnslashed('legacy'), 'get');
        $_POST['legacy'] = ' post ';
        $this->assertIdentical(MAX_commonGetPostValueUnslashed('legacy'), 'post');
        $_POST['legacy'] = '';
        $this->assertIdentical(MAX_commonGetPostValueUnslashed('legacy'), '');
        $_POST['legacy'] = '0';
        $this->assertIdentical(MAX_commonGetPostValueUnslashed('legacy'), '0');
        $_POST['legacy'] = '   ';
        $this->assertIdentical(MAX_commonGetPostValueUnslashed('legacy'), '');
        $_POST['legacy'] = null;
        $this->assertIdentical(MAX_commonGetPostValueUnslashed('legacy'), 'get');
        $_GET['legacy'] = null;
        $this->assertNull(MAX_commonGetPostValueUnslashed('legacy'));
        $this->assertIdentical(MAX_commonGetPostValueUnslashed('legacy', ' default '), 'default');

        $_POST = $post;
        $_GET = $get;
        $_COOKIE = $cookie;
        $_REQUEST = $request;
    }

    public function test_commonGetValueUnslashed()
    {
        $this->assertIdentical(_commonGetValueUnslashed(['legacy' => ' value '], 'legacy'), ' value ');
        $this->assertIdentical(_commonGetValueUnslashed(['legacy' => ''], 'legacy', 'default'), '');
        $this->assertIdentical(_commonGetValueUnslashed(['legacy' => 0], 'legacy', 'default'), 0);
        $this->assertIdentical(_commonGetValueUnslashed(['legacy' => null], 'legacy', 'default'), 'default');
        $this->assertIdentical(_commonGetValueUnslashed([], 'legacy', 'default'), 'default');
        $this->assertNull(_commonGetValueUnslashed([], 'legacy'));
    }

    public function test_MAX_addslashes()
    {
        $item = 'ab\'cd';
        MAX_addslashes($item);
        $this->assertEqual('ab\\\'cd', $item);
    }
}
