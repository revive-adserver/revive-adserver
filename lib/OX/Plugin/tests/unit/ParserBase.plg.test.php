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

require_once LIB_PATH.'/Plugin/ParserBase.php';

/**
 * A class for testing the OX_ParserBase class.
 *
 * @package Plugins
 * @author  Monique Szpak <monique.szpak@openx.org>
 * @subpackage TestSuite
 */
class Test_OX_ParserBase extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OX_ParserBase()
    {
        $this->UnitTestCase();
    }

    function test_ParseEmpty()
    {
        $file = LIB_PATH.'/Plugin/tests/data/testParseGroupEmpty.xml';
        $this->assertTrue(file_exists($file),'file not found '.$file);
        if (file_exists($file))
        {
            $oParser = new OX_ParserBase();
            $this->assertIsA($oParser,'OX_ParserBase');
            $result = $oParser->setInputFile($file);
            $this->assertFalse(PEAR::isError($result));
            $result = $oParser->parse();
            $this->assertFalse(PEAR::isError($result));
            $this->assertFalse(PEAR::isError($oParser->error));
            $this->assertTrue(is_array($oParser->aPlugin));

            $aPlugin = $oParser->aPlugin;

            $this->_assertStructure($aPlugin);

            $this->assertEqual($aPlugin['name'],'');
            $this->assertEqual($aPlugin['creationdate'],'');
            $this->assertEqual($aPlugin['author'],'');
            $this->assertEqual($aPlugin['authoremail'],'');
            $this->assertEqual($aPlugin['authorurl'],'');
            $this->assertEqual($aPlugin['license'],'');
            $this->assertEqual($aPlugin['description'],'');
            $this->assertEqual($aPlugin['version'],'');
            $this->assertEqual($aPlugin['extends'],'');

            $this->assertEqual(count($aPlugin['install']['syscheck']['depends']),0);
            $this->assertEqual(count($aPlugin['install']['syscheck']['php']),0);
            $this->assertEqual(count($aPlugin['install']['syscheck']['dbms']),0);
            $this->assertEqual(count($aPlugin['install']['files']),0);
            $this->assertEqual($aPlugin['install']['prescript'],'');
            $this->assertEqual($aPlugin['install']['postscript'],'');
            $this->assertEqual($aPlugin['uninstall']['prescript'],'');
            $this->assertEqual($aPlugin['uninstall']['postscript'],'');
        }
    }

    function test_ParsePartial()
    {
        $file = LIB_PATH.'/Plugin/tests/data/testParseGroupPartial.xml';
        $this->assertTrue(file_exists($file),'file not found '.$file);
        if (file_exists($file))
        {
            $oParser = new OX_ParserBase();
            $this->assertIsA($oParser,'OX_ParserBase');
            $result = $oParser->setInputFile($file);
            $this->assertFalse(PEAR::isError($result));
            $result = $oParser->parse();
            $this->assertFalse(PEAR::isError($result));
            $this->assertFalse(PEAR::isError($oParser->error));
            $this->assertTrue(is_array($oParser->aPlugin));

            $aPlugin = $oParser->aPlugin;

            $this->_assertStructure($aPlugin);

            $this->assertEqual($aPlugin['name'],'testParse');
            $this->assertEqual($aPlugin['creationdate'],'2008-04-01');
            $this->assertEqual($aPlugin['author'],'Test Author');
            $this->assertEqual($aPlugin['authoremail'],'test@example.org');
            $this->assertEqual($aPlugin['authorurl'],'http://www.openx.org');
            $this->assertEqual($aPlugin['license'],'license.txt');
            $this->assertEqual($aPlugin['description'],'Test Parse Partial');
            $this->assertEqual($aPlugin['version'],'0.0.1-test');
            $this->assertEqual($aPlugin['extends'],'admin');

            $this->assertEqual(count($aPlugin['install']['syscheck']['depends']),1);
            $this->assertEqual($aPlugin['install']['syscheck']['depends']['0']['name'],'testPlugin');
            $this->assertEqual($aPlugin['install']['syscheck']['depends']['0']['version'],'1.0');

            $this->assertEqual(count($aPlugin['install']['syscheck']['php']),0);

            $this->assertEqual(count($aPlugin['install']['files']),3);
            $this->assertEqual($aPlugin['install']['files'][0]['name'],'testFile1.html');
            $this->assertEqual($aPlugin['install']['files'][0]['path'],'{ADMINPATH}/templates/');
            $this->assertEqual($aPlugin['install']['files'][1]['name'],'testFile2.jpg');
            $this->assertEqual($aPlugin['install']['files'][1]['path'],'{ADMINPATH}/images/');
            $this->assertEqual($aPlugin['install']['files'][2]['name'],'testFile3.php');
            $this->assertEqual($aPlugin['install']['files'][2]['path'],'{ADMINPATH}/');

            $this->assertEqual(count($aPlugin['install']['syscheck']['dbms']),0);

            $this->assertEqual($aPlugin['install']['prescript'],'prescript_install_testParse.php');
            $this->assertEqual($aPlugin['install']['postscript'],'postscript_install_testParse.php');
        }
    }

    function test_ParseFull()
    {
        $file = LIB_PATH.'/Plugin/tests/data/testParseGroupFull.xml';
        $this->assertTrue(file_exists($file),'file not found '.$file);
        if (file_exists($file))
        {
            $oParser = new OX_ParserBase();
            $this->assertIsA($oParser,'OX_ParserBase');
            $result = $oParser->setInputFile($file);
            $this->assertFalse(PEAR::isError($result));
            $result = $oParser->parse();
            $this->assertFalse(PEAR::isError($result));
            $this->assertFalse(PEAR::isError($oParser->error));
            $this->assertTrue(is_array($oParser->aPlugin));

            $aPlugin = $oParser->aPlugin;

            $this->_assertStructure($aPlugin);

            $this->assertEqual($aPlugin['name'],'testParse');
            $this->assertEqual($aPlugin['creationdate'],'2008-04-01');
            $this->assertEqual($aPlugin['author'],'Test Author');
            $this->assertEqual($aPlugin['authoremail'],'test@example.org');
            $this->assertEqual($aPlugin['authorurl'],'http://www.openx.org');
            $this->assertEqual($aPlugin['license'],'license.txt');
            $this->assertEqual($aPlugin['description'],'Test Parse Full');
            $this->assertEqual($aPlugin['version'],'0.0.1-test');
            $this->assertEqual($aPlugin['extends'],'admin');
            $this->assertEqual($aPlugin['oxversion'],'2.7');

            $this->assertEqual(count($aPlugin['install']['syscheck']['depends']),1);
            $this->assertEqual($aPlugin['install']['syscheck']['depends']['0']['name'],'testPlugin');
            $this->assertEqual($aPlugin['install']['syscheck']['depends']['0']['version'],'1.0');

            $this->assertEqual(count($aPlugin['install']['syscheck']['php']),2);
            $this->assertEqual($aPlugin['install']['syscheck']['php'][0]['name'],'phpini1');
            $this->assertEqual($aPlugin['install']['syscheck']['php'][0]['value'],'phpval1');
            $this->assertEqual($aPlugin['install']['syscheck']['php'][1]['name'],'phpini2');
            $this->assertEqual($aPlugin['install']['syscheck']['php'][1]['value'],'phpval2');

            $this->assertEqual(count($aPlugin['install']['files']),3);
            $this->assertEqual($aPlugin['install']['files'][0]['name'],'testFile1.html');
            $this->assertEqual($aPlugin['install']['files'][0]['path'],'{ADMINPATH}/templates/');
            $this->assertEqual($aPlugin['install']['files'][1]['name'],'testFile2.jpg');
            $this->assertEqual($aPlugin['install']['files'][1]['path'],'{ADMINPATH}/images/');
            $this->assertEqual($aPlugin['install']['files'][2]['name'],'testFile3.php');
            $this->assertEqual($aPlugin['install']['files'][2]['path'],'{ADMINPATH}/');

            $this->assertEqual(count($aPlugin['install']['syscheck']['dbms']),2);
            $this->assertEqual($aPlugin['install']['syscheck']['dbms'][0]['name'],'mysql');
            $this->assertEqual($aPlugin['install']['syscheck']['dbms'][0]['supported'],1);

            $this->assertEqual($aPlugin['install']['syscheck']['dbms'][1]['name'],'pgsql');
            $this->assertEqual($aPlugin['install']['syscheck']['dbms'][1]['supported'],0);

            $this->assertEqual($aPlugin['install']['prescript'],'prescript_install_testParse.php');
            $this->assertEqual($aPlugin['install']['postscript'],'postscript_install_testParse.php');

            $this->assertEqual($aPlugin['uninstall']['prescript'],'prescript_uninstall_testParse.php');
            $this->assertEqual($aPlugin['uninstall']['postscript'],'postscript_uninstall_testParse.php');
        }
    }

    function _assertStructure($aPlugin)
    {
        $this->assertTrue(array_key_exists('name', $aPlugin),'array key not found [name]');
        $this->assertTrue(array_key_exists('creationdate', $aPlugin),'array key not found [creationdate]');
        $this->assertTrue(array_key_exists('author', $aPlugin),'array key not found [author]');
        $this->assertTrue(array_key_exists('authoremail', $aPlugin),'array key not found [authoremail]');
        $this->assertTrue(array_key_exists('authorurl', $aPlugin),'array key not found [authorurl]');
        $this->assertTrue(array_key_exists('license', $aPlugin),'array key not found [license]');
        $this->assertTrue(array_key_exists('description', $aPlugin),'array key not found [description]');
        $this->assertTrue(array_key_exists('version', $aPlugin),'array key not found [version]');
        $this->assertTrue(array_key_exists('oxversion', $aPlugin), 'array key not found [oxversion]');
        $this->assertTrue(array_key_exists('extends', $aPlugin),'array key not found [extends]');
        $this->assertTrue(array_key_exists('install', $aPlugin),'array key not found [install]');
        $this->assertTrue(array_key_exists('upgrade', $aPlugin), 'array key not found [upgrade]');
        $this->assertTrue(array_key_exists('uninstall', $aPlugin),'array key not found [uninstall]');
        $this->assertTrue(array_key_exists('syscheck', $aPlugin['install']),'array key not found [install][syscheck]');
        $this->assertTrue(array_key_exists('depends', $aPlugin['install']['syscheck']), 'array key not found [install][syscheck][depends]');
        $this->assertTrue(array_key_exists('php', $aPlugin['install']['syscheck']), 'array key not found [install][syscheck][php]');
        $this->assertTrue(array_key_exists('dbms', $aPlugin['install']['syscheck']), 'array key not found [install][syscheck][dbms]');
        $this->assertTrue(array_key_exists('conf', $aPlugin['install']),'array key not found [conf]');
        $this->assertTrue(array_key_exists('files', $aPlugin['install']),'array key not found [install][files]');

        $this->assertTrue(array_key_exists('prescript', $aPlugin['install']),'array key not found [install][prescript]');
        $this->assertTrue(array_key_exists('postscript', $aPlugin['install']),'array key not found [install][postscript]');

        $this->assertTrue(array_key_exists('prescript', $aPlugin['uninstall']),'array key not found [uninstall][prescript]');
        $this->assertTrue(array_key_exists('postscript', $aPlugin['uninstall']),'array key not found [uninstall][postscript]');

    }

}


?>
