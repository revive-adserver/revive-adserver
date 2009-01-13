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

require_once MAX_PATH . '/lib/OA/Creative/File.php';

/**
 * A class for testing the OA_Creative_File class
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Test_OA_Creative_File extends UnitTestCase
{
    var $imgGif;
    var $imgPng;
    var $imgJpeg;
    var $imgSwf;
    var $tempFiles;

    function Test_OA_Creative_File()
    {
        $this->imgGif  = "GIF89a\001\0\001\0\200\0\0\377\377\377\0\0\0!\371\004\0\0\0\0\0,\0\0\0\0\001\0\001\0\0\002\002D\001\0;";
        $this->imgPng  = "\211PNG\r\n\032\n\0\0\0\rIHDR\0\0\0\001\0\0\0\001\\b\003\0\0\001_\314\004-\0\0\0\031tEXtSoftware\0Adobe ImageReadyq\311e<\0\0\0\006PLTE\377\377\377\0\0\0U\302\323~\0\0\0\001tRNS\0@\346\330f\0\0\0\nIDATx\332c`\0\0\0\002\0\001\345'\336\374\0\0\0\0IEND\256B`\202";
        $this->imgJpeg = "\xFF\xD8\xFF\xE0\x00\x10\x4A\x46\x49\x46\x00\x01\x02\x00\x00\x64\x00\x64\x00\x00\xFF\xEC\x00\x11\x44\x75\x63\x6B\x79\x00\x01\x00\x04\x00\x00\x00\x0A\x00\x00\xFF\xEE\x00\x0E\x41\x64\x6F\x62\x65\x00\x64\xC0\x00\x00\x00\x01\xFF\xDB\x00\x84\x00\x14\x10\x10\x19\x12\x19\x27\x17\x17\x27\x32\x26\x1F\x26\x32\x2E\x26\x26\x26\x26\x2E\x3E\x35\x35\x35\x35\x35\x3E\x44\x41\x41\x41\x41\x41\x41\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x01\x15\x19\x19\x20\x1C\x20\x26\x18\x18\x26\x36\x26\x20\x26\x36\x44\x36\x2B\x2B\x36\x44\x44\x44\x42\x35\x42\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\xFF\xC0\x00\x11\x08\x00\x01\x00\x01\x03\x01\x22\x00\x02\x11\x01\x03\x11\x01\xFF\xC4\x00\x4B\x00\x01\x01\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x06\x01\x01\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x10\x01\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x11\x01\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\xFF\xDA\x00\x0C\x03\x01\x00\x02\x11\x03\x11\x00\x3F\x00\xB3\x00\x1F\xFF\xD9";

        $this->imgSwf = glob(MAX_PATH . '/lib/OA/Creative/tests/data/swf-*');

        $this->tempFiles = array();

        $this->UnitTestCase();
    }

    function TearDown()
    {
        foreach ($this->tempFiles as $f) {
            $this->assertTrue(unlink($f));
        }
        $this->tempFiles = array();
    }

    function testFactory()
    {
        $fileName = $this->writeTempFile($this->imgGif);

        $oCreative = OA_Creative_File::factory($fileName);
        $this->assertIsA($oCreative, 'OA_Creative_File');
        $this->assertEqual($oCreative->fileName, basename($fileName));
        $this->assertEqual($oCreative->contentType, 'gif');
        $this->assertEqual($oCreative->content, $this->imgGif);
        $this->assertEqual($oCreative->width, 1);
        $this->assertEqual($oCreative->height, 1);

        $fileName = $this->writeTempFile($this->imgPng);

        $oCreative = OA_Creative_File::factory($fileName, 'foo');
        $this->assertIsA($oCreative, 'OA_Creative_File');
        $this->assertEqual($oCreative->fileName, 'foo');
        $this->assertEqual($oCreative->contentType, 'png');
        $this->assertEqual($oCreative->content, $this->imgPng);
        $this->assertEqual($oCreative->width, 1);
        $this->assertEqual($oCreative->height, 1);

        $fileName = $this->writeTempFile($this->imgJpeg);

        $oCreative = OA_Creative_File::factory($fileName, 'foo');
        $this->assertIsA($oCreative, 'OA_Creative_File');
        $this->assertEqual($oCreative->fileName, 'foo');
        $this->assertEqual($oCreative->contentType, 'jpeg');
        $this->assertEqual($oCreative->content, $this->imgJpeg);
        $this->assertEqual($oCreative->width, 1);
        $this->assertEqual($oCreative->height, 1);

        $oCreative = OA_Creative_File::factory('non-existing');
        $this->assertIsA($oCreative, 'PEAR_Error');
    }

    function testFactoryString()
    {
        $oCreative = OA_Creative_File::factoryString('foo', $this->imgGif);
        $this->assertIsA($oCreative, 'OA_Creative_File');
        $this->assertEqual($oCreative->fileName, 'foo');
        $this->assertEqual($oCreative->contentType, 'gif');
        $this->assertEqual($oCreative->content, $this->imgGif);
        $this->assertEqual($oCreative->width, 1);
        $this->assertEqual($oCreative->height, 1);

        // Fail with non recognised content or extension
        $oCreative = OA_Creative_File::factoryString('foo.someext', 'bar');
        $this->assertIsA($oCreative, 'PEAR_Error');

        // Fail with non recognised content and image extension
        $oCreative = OA_Creative_File::factoryString('foo.gif', 'bar');
        $this->assertIsA($oCreative, 'PEAR_Error');
    }

    /**
     * @todo: find a way to unit/integration test HTTP uploads
     *
     */
    function testFactoryUploadedFile()
    {

    }

    function testSwf()
    {
        foreach ($this->imgSwf as $fullPath) {
            $oCreative = OA_Creative_File::factory($fullPath);
            $this->assertIsA($oCreative, 'OA_Creative_File_Swf');
            $this->assertEqual($oCreative->contentType, 'swf');
            $this->assertEqual($oCreative->width, 468);
            $this->assertEqual($oCreative->height, 60);
            $aDetails = $oCreative->getFileDetails();

            // Test hardcodedlinks
            $hasLink = strpos($fullPath, '-link') !== false;
            $this->assertTrue($aDetails['editswf'] == $hasLink, "File {$fullPath} hardcoded link detection failed");

            // Clicktag
            if (strpos($fullPath, '-clicktag') !== false) {
                $buffer = $oCreative->content;
                if (phpAds_SWFCompressed($buffer)) {
                    $buffer = phpAds_SWFDecompress($buffer);
                }
                $this->assertTrue(strpos($buffer, 'clickTAG') !== false);
            }
        }

        // Fail with non recognised content and swf extension
        $oCreative = OA_Creative_File::factoryString('foo.swf', 'bar');
        $this->assertIsA($oCreative, 'PEAR_Error');
    }

    function testStaticGetContentTypeByExtension()
    {
        $this->assertEqual('jpeg',
            OA_Creative_File::staticGetContentTypeByExtension('file1.jpg'));
        $this->assertEqual('png',
            OA_Creative_File::staticGetContentTypeByExtension(
                'http://www.example.com/files/banner.png'));
        $file = new OA_Creative_File('file1.jpg');
        $this->assertEqual('jpeg', $file->getContentTypeByExtension());
    }

    function testRichMedia()
    {
        // Allow supported richmedia by extension, no matter what the content is
        $oCreative = OA_Creative_File::factoryString('foo.dcr', 'xxx');
        $this->assertIsA($oCreative, 'OA_Creative_File_RichMedia');
        $oCreative = OA_Creative_File::factoryString('foo.mov', 'xxx');
        $this->assertIsA($oCreative, 'OA_Creative_File_RichMedia');
        $oCreative = OA_Creative_File::factoryString('foo.rpm', 'xxx');
        $this->assertIsA($oCreative, 'OA_Creative_File_RichMedia');
    }

    function writeTempFile($content)
    {
        $fileName = tempnam(MAX_PATH . '/var', 'test_creative_file_');
        $this->assertTrue($fp = fopen($fileName, 'w'), 'Cannot open file: '.$fileName);
        $this->assertTrue(fwrite($fp, $content), 'Cannot write to file: '.$fileName);
        $this->assertTrue(fclose($fp), 'Cannot close file: '.$fileName);

        $this->tempFiles[] = $fileName;

        return $fileName;
    }
}

?>