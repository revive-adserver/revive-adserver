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

    function test_getSRegexpDelimited()
    {
        $this->assertEqual('#blablah#', _getSRegexpDelimited('blablah'));
        $this->assertEqual('#bla\\#blah#', _getSRegexpDelimited('bla#blah'));
    }

}

?>