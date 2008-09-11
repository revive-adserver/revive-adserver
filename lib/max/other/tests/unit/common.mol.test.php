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

require_once MAX_PATH . '/lib/max/other/common.php';

/*
 * A class for testing the lib-geometry.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class CommonTest extends UnitTestCase
{
    function CommonTest()
    {
        $this->UnitTestCase();
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