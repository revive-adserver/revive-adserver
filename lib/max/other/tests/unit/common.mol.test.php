<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
 * @package    MaxPlugin
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class CommonTest extends UnitTestCase
{
    function CommonTest()
    {
        $this->UnitTestCase();
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
        $_REQUEST['aaa'] = 'blah\'';
        $this->assertEqual('blah\\\'', MAX_commonGetValue('aaa'));
        $this->assertEqual('ccc', MAX_commonGetValue('ddd', 'ccc'));
        $this->assertNull(MAX_commonGetValue('ddd'));
    }
    
    
    function test_Max_commonGetValueUnslashed()
    {
        // Please let me know how to test such functionality in PHP if I can't change
        // the php configuration run-time? We need some facility for running some
        // tests in different configurations.
//        $_REQUEST['aaa'] = 'blah\\\'';
//        $this->assertEqual('blah\'', MAX_commonGetValueUnslashed('aaa'));
    }
    
    
    function test_MAX_addslashes()
    {
        $item = 'ab\'cd';
        MAX_addslashes($item);
        $this->assertEqual('ab\\\'cd', $item);
    }
}
?>