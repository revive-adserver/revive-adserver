<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

    /**
     * test to ensure that special characters
     * are written and read correctly
     * IniCommented config class should quote all special chars
     * except backslash and single quote
     *
     * note: parse_ini_file() will break array on double quote
     *
     */
    function test_iniFile()
    {
        $min = 32;
        $max = 126;
        for ($i=$min;$i<=$max;$i++)
        {
            if (($i==34))
            {
                /*
                    // double quotes breaks the array
                    [test1]
                    34="test\""
                    [test2]
                    34="\"test"
                    [test3]
                    34="te\"st"

                    // single quotes returns backslash
                    [test1]
                    39="test\'"
                    [test2]
                    39="\'test"
                    [test3]
                    39="te\'st"

                    // backslash quotes returns two backslashes
                    [test1]
                    92="test\\"
                    [test2]
                    92="\\test"
                    [test3]
                    92="te\\st"
                */
                continue;
            }
            $aIni = array();
            $aIni['test1'][$i] = 'test'.chr($i);
            $aIni['test2'][$i] = chr($i).'test';
            $aIni['test3'][$i] = 'te'.chr($i).'st';
            $ini = MAX_PATH.'/var/test_'.$i.'.ini';
            $oConfig = new Config();
            $oConfig->parseConfig($aIni, 'phpArray');
            $this->assertTrue($oConfig->writeConfig($ini, 'IniCommented'));

            $aResult = @parse_ini_file($ini, true);
            $this->assertEqual($aResult['test1'][$i], $aIni['test1'][$i], 'ERROR:'.$i);
            $this->assertEqual($aResult['test2'][$i], $aIni['test2'][$i], 'ERROR:'.$i);
            $this->assertEqual($aResult['test3'][$i], $aIni['test3'][$i], 'ERROR:'.$i);
            @unlink($ini);
        }
    }


}

?>
