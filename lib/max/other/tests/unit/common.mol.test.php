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
    function __construct()
    {
        parent::__construct();
    }

    function test_MAX_isAnonymous()
    {
        $this->assertTrue(MAX_isAnonymous(true));
        $this->assertTrue(MAX_isAnonymous('t'));
        $this->assertFalse(MAX_isAnonymous(false));
        $this->assertFalse(MAX_isAnonymous('f'));
    }

	function test_MAX_commonSlashArray()
	{
		$this->sendMessage('test_MAX_commonSlashArray');
		$strIn0	= "Mr O\'Reilly";
		$strIn1	= '"Mr Reilly"\n';
		$strRe0 = addslashes($strIn0);
		$strRe1 = addslashes($strIn1);

		$aIn	= array(0 => $strIn0,
						1 => array(0 => $strIn1),
						);
		$aRet 	= MAX_commonSlashArray($aIn);

        $this->assertEqual($aRet[0], $strRe0);
        $this->assertEqual($aRet[1][0], $strRe1);
	}


    function test_MAX_commonUnslashArray()
    {
        $sValue = 'abcd';
        $this->assertEqual('abcd', MAX_commonUnslashArray($sValue));
        $sValue = 'ab\\cd';
        $this->assertEqual('abcd', MAX_commonUnslashArray($sValue));
        $sValue = 'ab\\\\cd';
        $this->assertEqual('ab\\cd', MAX_commonUnslashArray($sValue));
        $aValue = array('abcd', 'ab\\cd', 'ab\\\\cd');
        $this->assertEqual(array('abcd', 'abcd', 'ab\\cd'), MAX_commonUnslashArray($aValue));
        $aValue = array('abcd', 'ab\\cd', 'ab\\\\cd', array('abcd', 'ab\\\\cd'));
        $this->assertEqual(array('abcd', 'abcd', 'ab\\cd', array('abcd', 'ab\\cd')), MAX_commonUnslashArray($aValue));
    }


    function test_Max_commonGetValueSlashed()
    {
        // Please see the description below
//        $_REQUEST['aaa'] = 'blah\'';
//        $this->assertEqual('blah\\\'', MAX_commonGetValue('aaa'));
//        $this->assertEqual('ccc', MAX_commonGetValue('ddd', 'ccc'));
//        $this->assertNull(MAX_commonGetValue('ddd'));
    }


    function test_Max_commonGetValueUnslashed()
    {
        // Please let me know how to test such functionality in PHP if I can't change
        // the php configuration run-time? We need some facility for running some
        // tests in different configurations.
//        $_REQUEST['aaa'] = 'blah\\\'';
//        $this->assertEqual('blah\'', MAX_commonGetValueUnslashed('aaa'));
    }


    function test_MAX_commonGetPostValueUnslashed()
    {
        // We can't really test slashed/unslashed
        $_POST['aaa'] = 'bbb';
        $this->assertEqual('bbb', MAX_commonGetPostValueUnslashed('aaa'));
        $this->assertNull(MAX_commonGetPostValueUnslashed('aab'));
    }


    function test_MAX_addslashes()
    {
        $item = 'ab\'cd';
        MAX_addslashes($item);
        $this->assertEqual('ab\\\'cd', $item);
    }
}
?>