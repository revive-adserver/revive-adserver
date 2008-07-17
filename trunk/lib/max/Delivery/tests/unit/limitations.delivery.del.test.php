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

// require_once MAX_PATH . '/lib/max/Delivery/common.php';
require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * A class for testing the limitations.delivery.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 *
 */
class DeliveryLimitationsTest extends UnitTestCase
{
    function DeliveryLimitationsTest()
    {
        $this->UnitTestCase();
    }

    function test_MAX_limitationsMatchArray()
    {
        $this->assertTrue(MAX_limitationsMatchArray('browser', 'IE', '==', array('browser' => 'IE')));
        $this->assertFalse(MAX_limitationsMatchArray('browser', 'IE,NS,FF', '==', array('browser' => 'IE')));
        $this->assertTrue(MAX_limitationsMatchArray('browser', '', '=~', array('browser' => 'IE')));
        $this->assertTrue(MAX_limitationsMatchArray('browser', 'IE,NS,FF', '=~', array('browser' => 'IE')));
        $this->assertTrue(MAX_limitationsMatchArray('browser', 'IE', '=~', array('browser' => 'IE')));
        $this->assertFalse(MAX_limitationsMatchArray('browser', 'IE,NS,FF', '!~', array('browser' => 'IE')));
        $this->assertTrue(MAX_limitationsMatchArray('browser', 'NS,FF', '!~', array('browser' => 'IE')));
        $this->assertTrue(MAX_limitationsMatchArray('browser', 'NS,FF', '!~', array()));
        $GLOBALS['_MAX']['CLIENT']['browser'] = 'FF';
        $this->assertFalse(MAX_limitationsMatchArray('browser', 'NS,FF', '!~', array()));
    }

    function test_MAX_limitationsMatchString()
    {
        $this->assertTrue(MAX_limitationsMatchString('organisation', 'MS', '==', array('organisation' => 'MS')));
        $this->assertFalse(MAX_limitationsMatchString('organisation', 'Google', '==', array('organisation' => 'MS')));
        $this->assertFalse(MAX_limitationsMatchString('organisation', 'MSa', '==', array('organisation' => 'MS')));
        $this->assertTrue(MAX_limitationsMatchString('organisation', 'MSa', '!=', array('organisation' => 'MS')));
        $this->assertFalse(MAX_limitationsMatchString('organisation', 'MS', '!=', array('organisation' => 'MS')));
        $this->assertTrue(MAX_limitationsMatchString('organisation', 'MS', '=~', array('organisation' => 'yyMSyy')));
        $this->assertTrue(MAX_limitationsMatchString('organisation', 'MS', '=~', array('organisation' => 'MSyy')));
        $this->assertTrue(MAX_limitationsMatchString('organisation', 'MS', '=~', array('organisation' => 'yyMS')));
        $this->assertFalse(MAX_limitationsMatchString('organisation', 'MSee', '=~', array('organisation' => 'yyMSyy')));
        $this->assertFalse(MAX_limitationsMatchString('organisation', 'MS', '!~', array('organisation' => 'MSyy')));
        $this->assertTrue(MAX_limitationsMatchString('organisation', 'MSa', '!~', array('organisation' => 'MSyy')));
        $this->assertTrue(MAX_limitationsMatchString('organisation', '[a-z0-9]*pl', '=x', array('organisation' => 'pl')));
        $this->assertTrue(MAX_limitationsMatchString('organisation', '[a-z0-9]*pl', '=x', array('organisation' => 'blabla81234pl')));
        $this->assertFalse(MAX_limitationsMatchString('organisation', '[a-z0-9]*pl$', '=x', array('organisation' => 'blabla81234pldd')));
        $this->assertTrue(MAX_limitationsMatchString('organisation', '^A[a-z0-9]*pl$', '=x', array('organisation' => 'Ablabla81234pl')));
        $this->assertTrue(MAX_limitationsMatchString('organisation', '#', '=x', array('organisation' => 'blablah#blabblah')));
        $this->assertFalse(MAX_limitationsMatchString('organisation', '^A[a-z0-9]*pl$', '!x', array('organisation' => 'Ablabla81234pl')));

        $GLOBALS['_MAX']['CLIENT']['ua'] = 'mozilla/5.0 (x11; u; linux i686; en-us; rv:1.8.0.7) gecko/20060915 centos/1.5.0.7-0.1.el4.centos4 firefox/1.5.0.7 pango-text';
        $this->assertTrue(MAX_limitationsMatchString('ua', 'x11;', '=~'));
    }

    function test_MAX_limitationsGetSqlForArray()
    {
        $this->assertFalse(MAX_limitationsGetSqlForArray('==', null, 'os'));
        $this->assertFalse(MAX_limitationsGetSqlForArray('==', '', 'os'));
        $this->assertFalse(MAX_limitationsGetSqlForArray('==', array(), 'os'));
        $this->assertEqual("LOWER(os) IN ('xp')",
            MAX_limitationsGetSqlForArray('==', array('xp'), 'os'));
        $this->assertFalse(
            MAX_limitationsGetSqlForArray('==', array('xp', 'nt'), 'os'));

        $this->assertTrue(MAX_limitationsGetSqlForArray('!=', null, 'os'));
        $this->assertTrue(MAX_limitationsGetSqlForArray('!=', '', 'os'));
        $this->assertTrue(MAX_limitationsGetSqlForArray('!=', array(), 'os'));
        $this->assertEqual("LOWER(os) NOT IN ('xp')",
            MAX_limitationsGetSqlForArray('!=', array('xp'), 'os'));
        $this->assertEqual("LOWER(os) NOT IN ('xp','nt')",
            MAX_limitationsGetSqlForArray('!=', array('xp','nt'), 'os'));

        $this->assertFalse(MAX_limitationsGetSqlForArray('=~', null, 'os'));
        $this->assertFalse(MAX_limitationsGetSqlForArray('=~', '', 'os'));
        $this->assertFalse(MAX_limitationsGetSqlForArray('=~', array(), 'os'));
        $this->assertEqual("LOWER(os) IN ('xp')",
            MAX_limitationsGetSqlForArray('=~', array('xp'), 'os'));
        $this->assertEqual("LOWER(os) IN ('xp','nt')",
            MAX_limitationsGetSqlForArray('=~', array('xp','nt'), 'os'));

        $this->assertTrue(MAX_limitationsGetSqlForArray('!~', null, 'os'));
        $this->assertTrue(MAX_limitationsGetSqlForArray('!~', '', 'os'));
        $this->assertTrue(MAX_limitationsGetSqlForArray('!~', array(), 'os'));
        $this->assertEqual("LOWER(os) NOT IN ('xp')",
            MAX_limitationsGetSqlForArray('!~', array('xp'), 'os'));
        $this->assertEqual("LOWER(os) NOT IN ('xp','nt')",
            MAX_limitationsGetSqlForArray('!~', array('xp','nt'), 'os'));
    }

    function test_MAX_limitationsGetSqlForString()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $this->assertFalse(MAX_limitationsGetSqlForString('==', null, 'os'));
        $this->assertFalse(MAX_limitationsGetSqlForString('==', '', 'os'));
        $this->assertEqual("LOWER(os) = ('xp')",
            MAX_limitationsGetSqlForString('==', 'xp', 'os'));

        $this->assertTrue(MAX_limitationsGetSqlForString('!=', null, 'os'));
        $this->assertTrue(MAX_limitationsGetSqlForString('!=', '', 'os'));
        $this->assertEqual("LOWER(os) != ('xp')",
            MAX_limitationsGetSqlForString('!=', 'xp', 'os'));

        $this->assertFalse(MAX_limitationsGetSqlForString('=~', null, 'os'));
        $this->assertFalse(MAX_limitationsGetSqlForString('=~', '', 'os'));
        $this->assertEqual("LOWER(os) LIKE ('%xp%')",
            MAX_limitationsGetSqlForString('=~', 'xp', 'os'));

        $this->assertTrue(MAX_limitationsGetSqlForString('!~', null, 'os'));
        $this->assertTrue(MAX_limitationsGetSqlForString('!~', '', 'os'));
        $this->assertEqual("LOWER(os) NOT LIKE ('%xp%')",
            MAX_limitationsGetSqlForString('!~', 'xp', 'os'));

        $this->assertFalse(MAX_limitationsGetSqlForString('=x', null, 'os'));
        $this->assertFalse(MAX_limitationsGetSqlForString('=x', '', 'os'));

        if (strcasecmp($aConf['database']['type'], 'pgsql') === 0) {
            $regexp = '~';
            $not_regexp = '!~';
        } else {
            $regexp = 'REGEXP';
            $not_regexp = 'NOT REGEXP';
        }

        $this->assertEqual("LOWER(os) {$regexp} ('xp')",
            MAX_limitationsGetSqlForString('=x', 'xp', 'os'));
        $this->assertEqual("LOWER(os) {$regexp} ('x#p')",
            MAX_limitationsGetSqlForString('=x', 'x#p', 'os'));

        $this->assertTrue(MAX_limitationsGetSqlForString('!x', null, 'os'));
        $this->assertTrue(MAX_limitationsGetSqlForString('!x', '', 'os'));
        $this->assertEqual("LOWER(os) {$not_regexp} ('xp')",
            MAX_limitationsGetSqlForString('!x', 'xp', 'os'));
        $this->assertEqual("LOWER(os) {$not_regexp} ('x#p')",
            MAX_limitationsGetSqlForString('!x', 'x#p', 'os'));
    }

    function testMax_limitationsGetOverlapForStrings()
    {
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '==', 'Value1', '==', 'Value1'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '==', 'Value2', '==', 'Value1'));

        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '==', 'Value2', '!=', 'Value1'));
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '!=', 'Value1', '==', 'Value2'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '==', 'Value2', '!=', 'Value2'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '!=', 'Value2', '==', 'Value2'));

        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '==', 'abcdefgh', '=~', 'ab'));
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '=~', 'abcd', '==', 'abcdefgh'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '==', 'arbcdefgh', '=~', 'ab'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '=~', 'ab', '==', 'blalblalbla'));

        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '==', 'abcdefgh', '=x', 'ab.*'));
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '=x', '[a-z]+', '==', 'abcdefgh'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '==', 'arbuz', '=x', 'ab.*'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '=x', 'bababa', '==', 'la'));

        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '==', 'abcdefgh', '!x', 'ab.*'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '!x', '[a-z]+', '==', 'abcdefgh'));
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '==', 'arbuz', '!x', 'ab.*'));
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '!x', 'bababa', '==', 'la'));

        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '!=', 'Value1', '=~', 'Value1'));
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '!=', 'Value2', '=~', 'Value1'));
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '!=', 'Value1', '!~', 'Value1'));
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '!=', 'Value2', '!~', 'Value1'));

        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '!=', 'abcd', '=x', '/ab.*/'));
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '=x', '[a-z]+', '!=', 'abcdefgh'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '!=', 'abcd', '=x', '^abcd$'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '=x',  '^abcd$', '!=','abcd'));


        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '=~', 'abcdefgh', '=~', 'ab'));
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '=~', 'abcd', '=~', 'abcdefgh'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '=~', 'arbcdefgh', '=~', 'ab'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '=~', 'ab', '=~', 'blalblalbla'));

        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '=~', 'ab', '!~', 'ab'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '=~', 'abcdefgh', '!~', 'ab'));
        $this->assertFalse(MAX_limitationsGetOverlapForStrings(
            '!~', 'abcd', '=~', 'abcdefgh'));
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '=~', 'arbcdefgh', '!~', 'ab'));
        $this->assertTrue(MAX_limitationsGetOverlapForStrings(
            '!~', 'ab', '=~', 'blalblalbla'));
    }

    function testMax_limitationsGetPreprocessedString()
    {
        $this->assertEqual('abcdefg', MAX_limitationsGetPreprocessedString('abcdefg'));
        $this->assertEqual('abcdefg', MAX_limitationsGetPreprocessedString('AbCdefg'));
        $this->assertEqual('abcdefg', MAX_limitationsGetPreprocessedString(' AbCdefg '));
        set_magic_quotes_runtime(1);
        $this->assertEqual('abc\\d\'efg', MAX_limitationsGetPreprocessedString(' AbC\\d\'efg '));
        set_magic_quotes_runtime(0);
        $this->assertEqual('abc\\\\d\\\'efg', MAX_limitationsGetPreprocessedString(' AbC\\d\'efg '));
    }


    function testMax_limitationsGetAFromS()
    {
        $this->assertEqual(array('ab', 'cd', 'ef'), MAX_limitationsGetAFromS('ab,cd,ef'));
        $this->assertEqual(array(), MAX_limitationsGetAFromS(''));
        $this->assertEqual(array(), MAX_limitationsGetAFromS(null));
    }


    function testMax_limitationsGetSFromA()
    {
        $this->assertEqual('ab,cd,ef', MAX_limitationsGetSFromA(array('ab', 'cd', 'ef')));
        $this->assertEqual('', MAX_limitationsGetSFromA(array()));
        $this->assertEqual('', MAX_limitationsGetSFromA(null));
    }


    function testMAX_limitationsGetAUpgradeForString()
    {
        $this->checkUpgradeForString('==', 'blabla', '==', 'blabla');
        $this->checkUpgradeForString('=x', '^.*$', '==', '*');
        $this->checkUpgradeForString('!=', 'blabla', '!=', 'blabla');
        $this->checkUpgradeForString('=x', '^.*blabla$', '==', '*blabla');
        $this->checkUpgradeForString('=x', '^blabla.*$', '==', 'blabla*');
        $this->checkUpgradeForString('=~', 'blabla', '==', '*blabla*');
        $this->checkUpgradeForString('=~', 'blabla', '==', '*blabla****');
        $this->checkUpgradeForString('!~', 'blabla', '!=', '*blabla*');
        $this->checkUpgradeForString('=x', '^bla.*bla$', '==', 'bla*bla');
        $this->checkUpgradeForString('=x', '^.*bla.*bla.*$', '==', '*bla*bla*');
        $this->checkUpgradeForString('=x', '^bl.*ab.*la$', '==', 'bl*ab*la');
        $this->checkUpgradeForString('=x', '^bl.*ab.*la$', '==', 'bl*ab**la');
        $this->checkUpgradeForString('=x', '^bl.*ab.*la$', '==', 'bl*ab*****la');
        $this->checkUpgradeForString('!x', '^bl.*ab.*la$', '!=', 'bl*ab*la');
        $this->checkUpgradeForString('=x', '^bl.*a\\(b.*\\.l\\)a$', '==', 'bl*a(b*.l)a');
        $this->checkUpgradeForString('=~', 'blabla', '=~', 'blabla');
        $this->checkUpgradeForString('!~', 'blabla', '!~', 'blabla');
        $this->checkUpgradeForString('=x', '^http://victory\.com/index/blady/.*#strach$', '==', 'http://victory.com/index/blady/*#strach');
        $this->checkUpgradeForString('=x', '^\\(other\\)/business\\.scotsman\\.com/axappp.*$', '==', '(other)/business.scotsman.com/axappp*');
    }


    function testMAX_limitationsGetAUpgradeForArray()
    {
        $sData = 'blabla,a';
        $aResult = MAX_limitationsGetAUpgradeForArray('==', $sData);
        $this->assertEqual('=~', $aResult['op']);
        $this->assertEqual($sData, $aResult['data']);
        $aResult = MAX_limitationsGetAUpgradeForArray('!=', $sData);
        $this->assertEqual('!~', $aResult['op']);
        $this->assertEqual($sData, $aResult['data']);
        $aResult = MAX_limitationsGetAUpgradeForArray('=~', $sData);
        $this->assertEqual('=~', $aResult['op']);
        $this->assertEqual($sData, $aResult['data']);
    }


    function testMAX_limitationsGetAUpgradeForLanguage()
    {
        $this->checkUpgradeForLanguage('=~', 'pl', '==', '(pl)');
        $this->checkUpgradeForLanguage('=~', 'pl,en,fr', '==', '(pl)|(en)|(fr)');
        $this->checkUpgradeForLanguage('!~', 'pl,en,fr', '!=', '(pl)|(en)|(fr)');
    }


    function testMAX_limitationsGetAUpgradeForVariable()
    {
        $this->checkUpgradeForVariable('==', 'name,value', '==', 'name,value');
        $this->checkUpgradeForVariable('=~', 'name,value', '==', 'name,*value*');
        $this->checkUpgradeForVariable('=x', 'name,^value.*$', '==', 'name,value*');
    }


    function checkUpgradeForVariable($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetAUpgradeForVariable', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }


    function checkUpgradeForLanguage($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetAUpgradeForLanguage', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }


    function checkUpgradeForString($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetAUpgradeForString', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }

    function checkUpgrade($function, $opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $aResult = $function($opOriginal, $sDataOriginal);
        $opActual = $aResult['op'];
        $sDataActual = $aResult['data'];
        $this->assertEqual($opExpected, $opActual, "The value of operator for: '$opOriginal|$sDataOriginal' is $opActual.");
        $this->assertEqual($sDataExpected, $sDataActual, "The value of data for: '$opOriginal|$sDataOriginal' is $sDataActual instead of: $sDataExpected.");
    }


    function testMAX_limitationsGetADowngradeForString()
    {
        $this->checkDowngradeForString('==', 'blabla', '==', 'blabla');
        $this->checkDowngradeForString('==', '*', '=x', '^.*$');
        $this->checkDowngradeForString('!=', 'blabla', '!=', 'blabla');
        $this->checkDowngradeForString('==', '*blabla', '=x', '^.*blabla$');
        $this->checkDowngradeForString('==', 'blabla*', '=x', '^blabla.*$');
        $this->checkDowngradeForString('==', '*blabla*', '=~', 'blabla');
        $this->checkDowngradeForString('!=', '*blabla*', '!~', 'blabla');
        $this->checkDowngradeForString('==', 'bla*bla', '=x', '^bla.*bla$');
        $this->checkDowngradeForString('==', '*bla*bla*', '=x', '^.*bla.*bla.*$');
        $this->checkDowngradeForString('==', 'bl*ab*la', '=x', '^bl.*ab.*la$');
        $this->checkDowngradeForString('!=', 'bl*ab*la', '!x', '^bl.*ab.*la$');
        $this->checkDowngradeForString('==', 'bl*a(b*.l)a', '=x', '^bl.*a\\(b.*\\.l\\)a$');
        $this->checkDowngradeForString('==', '*blabla*', '=~', 'blabla');
        $this->checkDowngradeForString('!=', '*blabla*', '!~', 'blabla');
        $this->checkDowngradeForString('==', 'http://victory.com/index/blady/*#strach', '=x', '^http://victory\.com/index/blady/.*#strach$');
        $this->checkDowngradeForString('==', '(other)/business.scotsman.com/axappp*', '=x', '^\\(other\\)/business\\.scotsman\\.com/axappp.*$');
    }


    function testMAX_limitationsGetADowngradeForArray()
    {
        $sData = 'blabla,a';
        $this->checkDowngradeForArray('==', $sData, '=~', $sData);
        $this->checkDowngradeForArray('!=', $sData, '!~', $sData);
    }


    function testMAX_limitationsGetADowngradeForLanguage()
    {
        $this->checkDowngradeForLanguage('==', '(pl)', '=~', 'pl');
        $this->checkDowngradeForLanguage('==', '(pl)|(en)|(fr)', '=~', 'pl,en,fr');
        $this->checkDowngradeForLanguage('!=', '(pl)|(en)|(fr)', '!~', 'pl,en,fr');
    }


    function testMAX_limitationsGetADowngradeForVariable()
    {
        $this->checkDowngradeForVariable('==', 'name,value', '==', 'name,value');
        $this->checkDowngradeForVariable('==', 'name,*value*', '=~', 'name,value');
        $this->checkDowngradeForVariable('==', 'name,value*', '=x', 'name,^value.*$');
    }


    function checkDowngradeForArray($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetADowngradeForArray', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }


    function checkDowngradeForVariable($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetADowngradeForVariable', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }


    function checkDowngradeForLanguage($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetADowngradeForLanguage', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }


    function checkDowngradeForString($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetADowngradeForString', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }


    function test_getSRegexpDelimited()
    {
        $this->assertEqual('#blablah#', _getSRegexpDelimited('blablah'));
        $this->assertEqual('#bla\\#blah#', _getSRegexpDelimited('bla#blah'));
    }
}

?>