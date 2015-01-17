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

require_once LIB_PATH.'/Plugin/ParserPlugin.php';

/**
 * A class for testing the ParserPackage class.
 *
 * @package Plugins
 * @subpackage TestSuite
 */
class Test_OX_ParserPlugin extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
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
            $this->assertEqual($aPlugin['version'], '0.0.1-test-RC1');

            $this->assertEqual(count($aPlugin['install']['contents']),2);
            $this->assertEqual($aPlugin['install']['contents'][1]['name'],'testPlugin1');
            $this->assertEqual($aPlugin['install']['contents'][2]['name'],'testPlugin2');

            $this->assertEqual(count($aPlugin['allfiles']),2);
            $this->assertEqual($aPlugin['allfiles'][0]['name'],'testParsePackage.xml');
            $this->assertEqual($aPlugin['allfiles'][0]['path'],OX_PLUGIN_PLUGINPATH);
            $this->assertEqual($aPlugin['allfiles'][1]['name'],'testParsePackage.readme.txt');
            $this->assertEqual($aPlugin['allfiles'][1]['path'],OX_PLUGIN_PLUGINPATH);
        }
    }

    function _assertStructure($aPlugin)
    {
        $this->assertTrue(array_key_exists('contents', $aPlugin['install']),'array key not found [install][contents]');
    }
}

?>
