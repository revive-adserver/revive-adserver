<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
// $Id$
*/

require_once LIB_PATH.'/Plugin/ParserPlugin.php';

/**
 * A class for testing the ParserPackage class.
 *
 * @package Plugins
 * @author  Monique Szpak <monique.szpak@openx.org>
 * @subpackage TestSuite
 */
class Test_OX_ParserPlugin extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OX_ParserPlugin()
    {
        $this->UnitTestCase();
    }

    function test_ParseEmpty()
    {
        $file = LIB_PATH.'/Plugin/tests/data/testParsePluginEmpty.xml';
        $this->assertTrue(file_exists($file),'file not found '.$file);
        if (file_exists($file))
        {
            $oParser = new OX_ParserPlugin();
            $this->assertIsA($oParser,'OX_ParserPlugin');
            $result = $oParser->setInputFile($file);
            $this->assertFalse(PEAR::isError($result));
            $result = $oParser->parse();
            $this->assertFalse(PEAR::isError($result));
            $this->assertFalse(PEAR::isError($oParser->error));
            $this->assertTrue(is_array($oParser->aPlugin));

            $aPlugin = $oParser->aPlugin;

            $this->_assertStructure($aPlugin);

            $this->assertEqual(count($aPlugin['install']['contents']),0);
        }
    }

    function test_ParseFull()
    {
        $file = LIB_PATH.'/Plugin/tests/data/testParsePluginFull.xml';
        $this->assertTrue(file_exists($file),'file not found '.$file);
        if (file_exists($file))
        {
            $oParser = new OX_ParserPlugin();
            $this->assertIsA($oParser,'OX_ParserPlugin');
            $result = $oParser->setInputFile($file);
            $this->assertFalse(PEAR::isError($result));
            $result = $oParser->parse();
            $this->assertFalse(PEAR::isError($result));
            $this->assertFalse(PEAR::isError($oParser->error));
            $this->assertTrue(is_array($oParser->aPlugin));

            $aPlugin = $oParser->aPlugin;

            $this->_assertStructure($aPlugin);

            $this->assertEqual(count($aPlugin['install']['contents']),2);
            $this->assertEqual($aPlugin['install']['contents'][1]['name'],'testPlugin1');
            $this->assertEqual($aPlugin['install']['contents'][2]['name'],'testPlugin2');


        }
    }

    function _assertStructure($aPlugin)
    {
        $this->assertTrue(array_key_exists('contents', $aPlugin['install']),'array key not found [install][contents]');
    }
}

?>
