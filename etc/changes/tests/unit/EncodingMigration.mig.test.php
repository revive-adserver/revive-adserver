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

require_once MAX_PATH . '/etc/changes/EncodingMigration.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * Test for EncodingMigration class.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Chris Nutting <chris.nutting@openx.org>
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class EncodingMigrationTest extends MigrationTest
{
    /**
     * Strings in the original encoding, in hex to ensure portability
     *
     * @var array
     */
    var $aOriginalStrings = array(
        'big5'          => "\xAB\x4F\xA6\x73\xA7\xF3\xA7\xEF",
        'gb2312'        => "\xB1\xA3\xB4\xE6\xB8\xFC\xB8\xC4",
        'iso-8859-2'    => "\x50\xF8\x69\x68\x6C\x61\xB9\x6F\x76\x61\x63\xED\x20\xFA\x64\x61\x6A\x65",
        'iso-8859-15'   => "\x50\x72\xE9\x66\xE9\x72\x65\x6E\x63\x65\x73\x20\xA4",
        'windows-1255'  => "\xF7\xE3\xE9\xEE\xE5\xE9\xE5\xFA",
        'EUC-KR'        => "\xB9\xD9\xB7\xCE\xB0\xA1\xB1\xE2",
        'windows-1251'  => "\xC2\xE5\xF0\xEE\xFF\xF2\xED\xEE\xF1\xF2\xFC",
        'koi8-r'        => "\xF7\xC5\xD2\xCF\xD1\xD4\xCE\xCF\xD3\xD4\xD8",
    );

    var $oEncodingMigration;


    function setUp()
    {

        Mock::generatePartial(
            'EncodingMigration',
            $mockMigration = 'EncodingMigration'.rand(),
            array('_setEncodingExtension', '_log')
        );
        $this->oEncodingMigration = new $mockMigration($this);

        //$this->oEncodingMigration->setReturnValue('_setEncodingExtension', true);
        //$this->oEncodingMigration->setReturnValue('_log', true);

    }

    /**
     * A method to return an hex escaped string so that this file is encoding safe
     *
     * @param string $str
     * @return string
     */
    function _toHexString($str)
    {
        $len = strlen($str);
        $buf = '';
        for ($i=0; $i<$len;$i++) {
            $buf .= sprintf('\\x%02X', ord(substr($str, $i, 1)));
        }

        return $buf;
    }

    function test_setEncodingExtension()
    {
        $this->oEncodingMigration->setReturnValue('_setEncodingExtension', true);
        $this->oEncodingMigration->_setEncodingExtension();
        if (function_exists('mb_convert_encoding'))
        {
            $this->extension = 'mbstring';
        }
        else if (function_exists('iconv'))
        {
            $this->extension = 'iconv';
        }
        else if (function_exists('utf8_encode'))
        {
            $this->extension = 'xml';
        }
        return $this->extension;
    }



    /**
     * A function to test the iconv conversion mechanism
     * NOTE: The this test is only executed if the iconv extension is loaded
     * and will not be tested otherwise
     */
    function testIconv()
    {
        if (extension_loaded('iconv')) {
            $this->oEncodingMigration->extension = 'iconv';
            $this->_testConvertStrings('iconv', array(
                'big5'          => "\xE4\xBF\x9D\xE5\xAD\x98\xE6\x9B\xB4\xE6\x94\xB9",
                'gb2312'        => "\xE4\xBF\x9D\xE5\xAD\x98\xE6\x9B\xB4\xE6\x94\xB9",
                'iso-8859-2'    => "\x50\xC5\x99\x69\x68\x6C\x61\xC5\xA1\x6F\x76\x61\x63\xC3\xAD\x20\xC3\xBA\x64\x61\x6A\x65",
                'iso-8859-15'   => "\x50\x72\xC3\xA9\x66\xC3\xA9\x72\x65\x6E\x63\x65\x73\x20\xE2\x82\xAC",
                'windows-1255'  => "\xD7\xA7\xD7\x93\xD7\x99\xD7\x9E\xD7\x95\xD7\x99\xD7\x95\xD7\xAA",
                'EUC-KR'        => "\xEB\xB0\x94\xEB\xA1\x9C\xEA\xB0\x80\xEA\xB8\xB0",
                'windows-1251'  => "\xD0\x92\xD0\xB5\xD1\x80\xD0\xBE\xD1\x8F\xD1\x82\xD0\xBD\xD0\xBE\xD1\x81\xD1\x82\xD1\x8C",
                'koi8-r'        => "\xD0\x92\xD0\xB5\xD1\x80\xD0\xBE\xD1\x8F\xD1\x82\xD0\xBD\xD0\xBE\xD1\x81\xD1\x82\xD1\x8C",
            ));
        }
    }

    function testMbstring()
    {
        if ($this->assertTrue(extension_loaded('mbstring'))) {
            $this->oEncodingMigration->extension = 'mbstring';
            $this->_testConvertStrings('mbstring', array(
                'big5'          => "\xE4\xBF\x9D\xE5\xAD\x98\xE6\x9B\xB4\xE6\x94\xB9",
                'gb2312'        => "\xE4\xBF\x9D\xE5\xAD\x98\xE6\x9B\xB4\xE6\x94\xB9",
                'iso-8859-2'    => "\x50\xC5\x99\x69\x68\x6C\x61\xC5\xA1\x6F\x76\x61\x63\xC3\xAD\x20\xC3\xBA\x64\x61\x6A\x65",
                'iso-8859-15'   => "\x50\x72\xC3\xA9\x66\xC3\xA9\x72\x65\x6E\x63\x65\x73\x20\xE2\x82\xAC",
                'windows-1255'  => "\xD7\xA7\xD7\x93\xD7\x99\xD7\x9E\xD7\x95\xD7\x99\xD7\x95\xD7\xAA",
                'EUC-KR'        => "\xEB\xB0\x94\xEB\xA1\x9C\xEA\xB0\x80\xEA\xB8\xB0",
                'windows-1251'  => "\xD0\x92\xD0\xB5\xD1\x80\xD0\xBE\xD1\x8F\xD1\x82\xD0\xBD\xD0\xBE\xD1\x81\xD1\x82\xD1\x8C",
                'koi8-r'        => "\xD0\x92\xD0\xB5\xD1\x80\xD0\xBE\xD1\x8F\xD1\x82\xD0\xBD\xD0\xBE\xD1\x81\xD1\x82\xD1\x8C",
            ));
        }
    }

   function testXml()
   {
        if ($this->assertTrue(extension_loaded('xml'))) {
            $this->oEncodingMigration->extension = 'xml';
            $this->_testConvertStrings('xml', array(
                'big5'          => "\xAB\x4F\xA6\x73\xA7\xF3\xA7\xEF",
                'gb2312'        => "\xB1\xA3\xB4\xE6\xB8\xFC\xB8\xC4",
                'iso-8859-2'    => "\x50\xF8\x69\x68\x6C\x61\xB9\x6F\x76\x61\x63\xED\x20\xFA\x64\x61\x6A\x65",
                'iso-8859-15'   => "\x50\x72\xC3\xA9\x66\xC3\xA9\x72\x65\x6E\x63\x65\x73\x20\xC2\xA4",
                'windows-1255'  => "\xF7\xE3\xE9\xEE\xE5\xE9\xE5\xFA",
                'EUC-KR'        => "\xB9\xD9\xB7\xCE\xB0\xA1\xB1\xE2",
                'windows-1251'  => "\xC2\xE5\xF0\xEE\xFF\xF2\xED\xEE\xF1\xF2\xFC",
                'koi8-r'        => "\xF7\xC5\xD2\xCF\xD1\xD4\xCE\xCF\xD3\xD4\xD8",
            ));
        }
   }

    function _testConvertStrings($extension, $aStringsInUTF8)
    {
        // I used the following to create the base64 encoded strings
        // base64_encode($oEncodingMigration->_convertString($aStringsInUTF8['windows-1255'], 'windows-1255', 'UTF-8'))

        // Test that the converting of relevant encoded strings is working as expected
        foreach ($this->aOriginalStrings as $encoding => $origString) {
            $converted = $this->oEncodingMigration->_convertString($origString, 'UTF-8', $encoding, $extension);
            $this->assertEqual($converted, $aStringsInUTF8[$encoding], $encoding . ' string didn\'t convert correctly using ' . $extension. ':
                expected "'.$this->_toHexString($aStringsInUTF8[$encoding]).'", got "'.$this->_toHexString($converted).'"
            ');
        }
    }
}

?>