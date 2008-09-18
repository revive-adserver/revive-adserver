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
$Id: Sync.cor.test.php 16124 2008-02-11 18:16:06Z andrew.hill@openads.org $
*/

require_once MAX_PATH . '/lib/OX/Translation.php';

/**
 * A class for testing the OX_Translation class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Chris Nutting <chris.nutting@openx.org>
 */
class Test_OX_Translation extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OX_Translation()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the core translation system using the strKey mechanism
     */
    function testCoreTranslateByKey()
    {
        $GLOBALS['strTestString'] = 'Test string';

        $oTrans = new OX_Translation();
        $source = 'TestString';
        $expected = 'Test string';
        $translation = $oTrans->translate($source);

        $this->assertEqual($expected, $translation);
    }

    /**
     * If no strKey exists, then the string should be returned unchanged
     *
     */
    function testCoreTranslateByPlainString()
    {
        unset($GLOBALS['strTestString']);

        $oTrans = new OX_Translation();
        $source = 'TestString';
        $expected = 'TestString';
        $translation = $oTrans->translate($source);

        $this->assertEqual($expected, $translation);
    }

    /**
     * If an array of substitution values is provided, they should be replaced in order
     *
     */
    function testCoreTranslateBySubstitutedString()
    {
        $GLOBALS['strTestString'] = 'Test %s string';

        $oTrans = new OX_Translation();
        $source = 'TestString';
        $aValues = array('test');
        $expected = 'Test test string';
        $translation = $oTrans->translate($source, $aValues);

        $this->assertEqual($expected, $translation);

        $GLOBALS['strTestString'] = 'Test %s string %d times';

        $oTrans = new OX_Translation();
        $source = 'TestString';
        $aValues = array('test', 10);
        $expected = 'Test test string 10 times';
        $translation = $oTrans->translate($source, $aValues);

        $this->assertEqual($expected, $translation);
    }

    function testPluginTranslationByPlainString()
    {
        $transPath = '/tests/data/_lang';
        $GLOBALS['_MAX']['PREF']['language'] = 'en';

        $oTrans = new OX_Translation($transPath);

        // Make sure the translation resource loaded correctly
        $this->assertNotNull($oTrans->zTrans);

        // Translation by "key"
        $result = $oTrans->translate('TestString');
        $expected = 'This is a test string';
        $this->assertEqual($expected, $result);

        // Translation by "string"
        $expected = 'This is the translation of "another string"';
        $result = $oTrans->translate('This is another test string');
        $this->assertEqual($expected, $result);

        // Translation of not-present "string/key"
        $expected = 'This string doesn\'t exist in the source po file';
        $result = $oTrans->translate('This string doesn\'t exist in the source po file');
        $this->assertEqual($expected, $result);

        // Translation of a translated string that contains substitutions
        $expected = 'This is a test frog with a 3 number in it';
        $result = $oTrans->translate('This is a test %s with a %d number in it', array('frog', 3));
        $this->assertEqual($expected, $result);

    }
}

?>