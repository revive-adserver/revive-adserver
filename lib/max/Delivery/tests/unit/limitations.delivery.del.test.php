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

require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * A class for testing the limitations.delivery.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 */
class Test_DeliveryLimitations_Delivery extends UnitTestCase
{
    public function test_MAX_limitationsMatchArray()
    {
        $this->assertTrue(MAX_limitationsMatchArray('browser', 'IE', '==', ['browser' => 'IE']));
        $this->assertFalse(MAX_limitationsMatchArray('browser', 'IE,NS,FF', '==', ['browser' => 'IE']));
        $this->assertFalse(MAX_limitationsMatchArray('browser', '', '=~', ['browser' => 'IE']));
        $this->assertTrue(MAX_limitationsMatchArray('browser', 'IE,NS,FF', '=~', ['browser' => 'IE']));
        $this->assertTrue(MAX_limitationsMatchArray('browser', 'IE', '=~', ['browser' => 'IE']));
        $this->assertFalse(MAX_limitationsMatchArray('browser', 'IE,NS,FF', '!~', ['browser' => 'IE']));
        $this->assertTrue(MAX_limitationsMatchArray('browser', 'NS,FF', '!~', ['browser' => 'IE']));
        $this->assertTrue(MAX_limitationsMatchArray('browser', '', '!~', ['browser' => 'IE']));
        $this->assertTrue(MAX_limitationsMatchArray('browser', 'NS,FF', '!~', []));
        $GLOBALS['_MAX']['CLIENT']['browser'] = 'FF';
        $this->assertFalse(MAX_limitationsMatchArray('browser', 'NS,FF', '!~', []));
    }

    public function test_MAX_limitationsMatchString()
    {
        $this->assertTrue(MAX_limitationsMatchString('organisation', 'MS', '==', ['organisation' => 'MS']));
        $this->assertFalse(MAX_limitationsMatchString('organisation', 'Google', '==', ['organisation' => 'MS']));
        $this->assertFalse(MAX_limitationsMatchString('organisation', 'MSa', '==', ['organisation' => 'MS']));
        $this->assertTrue(MAX_limitationsMatchString('organisation', 'MSa', '!=', ['organisation' => 'MS']));
        $this->assertFalse(MAX_limitationsMatchString('organisation', 'MS', '!=', ['organisation' => 'MS']));
        $this->assertTrue(MAX_limitationsMatchString('organisation', 'MS', '=~', ['organisation' => 'yyMSyy']));
        $this->assertTrue(MAX_limitationsMatchString('organisation', 'MS', '=~', ['organisation' => 'MSyy']));
        $this->assertTrue(MAX_limitationsMatchString('organisation', 'MS', '=~', ['organisation' => 'yyMS']));
        $this->assertFalse(MAX_limitationsMatchString('organisation', 'MSee', '=~', ['organisation' => 'yyMSyy']));
        $this->assertFalse(MAX_limitationsMatchString('organisation', 'MS', '!~', ['organisation' => 'MSyy']));
        $this->assertTrue(MAX_limitationsMatchString('organisation', 'MSa', '!~', ['organisation' => 'MSyy']));
        $this->assertTrue(MAX_limitationsMatchString('organisation', '[a-z0-9]*pl', '=x', ['organisation' => 'pl']));
        $this->assertTrue(MAX_limitationsMatchString('organisation', '[a-z0-9]*pl', '=x', ['organisation' => 'blabla81234pl']));
        $this->assertFalse(MAX_limitationsMatchString('organisation', '[a-z0-9]*pl$', '=x', ['organisation' => 'blabla81234pldd']));
        $this->assertTrue(MAX_limitationsMatchString('organisation', '^A[a-z0-9]*pl$', '=x', ['organisation' => 'Ablabla81234pl']));
        $this->assertTrue(MAX_limitationsMatchString('organisation', '#', '=x', ['organisation' => 'blablah#blabblah']));
        $this->assertFalse(MAX_limitationsMatchString('organisation', '^A[a-z0-9]*pl$', '!x', ['organisation' => 'Ablabla81234pl']));

        $GLOBALS['_MAX']['CLIENT']['ua'] = 'mozilla/5.0 (x11; u; linux i686; en-us; rv:1.8.0.7) gecko/20060915 centos/1.5.0.7-0.1.el4.centos4 firefox/1.5.0.7 pango-text';
        $this->assertTrue(MAX_limitationsMatchString('ua', 'x11;', '=~'));
    }

    public function testMax_limitationsGetPreprocessedString()
    {
        $this->assertEqual('abcdefg', MAX_limitationsGetPreprocessedString('abcdefg'));
        $this->assertEqual('abcdefg', MAX_limitationsGetPreprocessedString('AbCdefg'));
        $this->assertEqual('abcdefg', MAX_limitationsGetPreprocessedString(' AbCdefg '));
        $this->assertEqual('abc\\d\'efg', MAX_limitationsGetPreprocessedString(' AbC\\d\'efg '));
    }

    public function testMax_limitationsGetAFromS()
    {
        $this->assertEqual(['ab', 'cd', 'ef'], MAX_limitationsGetAFromS('ab,cd,ef'));
        $this->assertEqual([], MAX_limitationsGetAFromS(''));
        $this->assertEqual([], MAX_limitationsGetAFromS(null));
    }

    public function testMax_limitationsGetSFromA()
    {
        $this->assertEqual('ab,cd,ef', MAX_limitationsGetSFromA(['ab', 'cd', 'ef']));
        $this->assertEqual('', MAX_limitationsGetSFromA([]));
        $this->assertEqual('', MAX_limitationsGetSFromA(null));
    }

    public function test_getSRegexpDelimited()
    {
        $this->assertEqual('#blablah#', _getSRegexpDelimited('blablah'));
        $this->assertEqual('#bla\\#blah#', _getSRegexpDelimited('bla#blah'));
    }
}
