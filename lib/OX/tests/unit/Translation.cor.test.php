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

require_once MAX_PATH . '/lib/OX/Translation.php';

/**
 * A class for testing the OX_Translation class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class Test_OX_Translation extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
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