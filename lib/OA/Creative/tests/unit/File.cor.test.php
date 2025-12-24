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

require_once MAX_PATH . '/lib/OA/Creative/File.php';

/**
 * A class for testing the OA_Creative_File class
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class Test_OA_Creative_File extends UnitTestCase
{
    public $imgGif;
    public $imgPng;
    public $imgJpeg;
    private $imgWebp;
    private $imgAvif;
    public $tempFiles;

    public function __construct()
    {
        $this->imgGif = "GIF89a\001\0\001\0\200\0\0\377\377\377\0\0\0!\371\004\0\0\0\0\0,\0\0\0\0\001\0\001\0\0\002\002D\001\0;";
        $this->imgPng = "\211PNG\r\n\032\n\0\0\0\rIHDR\0\0\0\001\0\0\0\001\\b\003\0\0\001_\314\004-\0\0\0\031tEXtSoftware\0Adobe ImageReadyq\311e<\0\0\0\006PLTE\377\377\377\0\0\0U\302\323~\0\0\0\001tRNS\0@\346\330f\0\0\0\nIDATx\332c`\0\0\0\002\0\001\345'\336\374\0\0\0\0IEND\256B`\202";
        $this->imgJpeg = "\xFF\xD8\xFF\xE0\x00\x10\x4A\x46\x49\x46\x00\x01\x02\x00\x00\x64\x00\x64\x00\x00\xFF\xEC\x00\x11\x44\x75\x63\x6B\x79\x00\x01\x00\x04\x00\x00\x00\x0A\x00\x00\xFF\xEE\x00\x0E\x41\x64\x6F\x62\x65\x00\x64\xC0\x00\x00\x00\x01\xFF\xDB\x00\x84\x00\x14\x10\x10\x19\x12\x19\x27\x17\x17\x27\x32\x26\x1F\x26\x32\x2E\x26\x26\x26\x26\x2E\x3E\x35\x35\x35\x35\x35\x3E\x44\x41\x41\x41\x41\x41\x41\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x01\x15\x19\x19\x20\x1C\x20\x26\x18\x18\x26\x36\x26\x20\x26\x36\x44\x36\x2B\x2B\x36\x44\x44\x44\x42\x35\x42\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\x44\xFF\xC0\x00\x11\x08\x00\x01\x00\x01\x03\x01\x22\x00\x02\x11\x01\x03\x11\x01\xFF\xC4\x00\x4B\x00\x01\x01\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x06\x01\x01\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x10\x01\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x11\x01\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\xFF\xDA\x00\x0C\x03\x01\x00\x02\x11\x03\x11\x00\x3F\x00\xB3\x00\x1F\xFF\xD9";
        $this->imgWebp = "RIFF\x1A\0\0\0WEBPVP8L\x0D\0\0\0\x2F\0\0\0\x10\x07\x10\x11\x11\x88\x88\xFE\x07\0";
        $this->imgAvif = base64_decode('AAAAHGZ0eXBhdmlmAAAAAGF2aWZtaWYxbWlhZgAAAOptZXRhAAAAAAAAACFoZGxyAAAAAAAAAABwaWN0AAAAAAAAAAAAAAAAAAAAAA5waXRtAAAAAAABAAAAImlsb2MAAAAAREAAAQABAAAAAAEOAAEAAAAAAAAAEgAAACNpaW5mAAAAAAABAAAAFWluZmUCAAAAAAEAAGF2MDEAAAAAamlwcnAAAABLaXBjbwAAABNjb2xybmNseAABAA0ABoAAAAAMYXYxQ4EgAgAAAAAUaXNwZQAAAAAAAAABAAAAAQAAABBwaXhpAAAAAAMICAgAAAAXaXBtYQAAAAAAAAABAAEEAYIDBAAAABptZGF0EgAKBzgABhAQ0GkyBRAAAAtA');

        $this->tempFiles = [];

        parent::__construct();
    }

    public function TearDown()
    {
        foreach ($this->tempFiles as $f) {
            $this->assertTrue(unlink($f));
        }
        $this->tempFiles = [];
    }

    public function testFactory()
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

        $oCreative = OA_Creative_File::factory($fileName, 'foo.png');
        $this->assertIsA($oCreative, 'OA_Creative_File');
        $this->assertEqual($oCreative->fileName, 'foo.png');
        $this->assertEqual($oCreative->contentType, 'png');
        $this->assertEqual($oCreative->content, $this->imgPng);
        $this->assertEqual($oCreative->width, 1);
        $this->assertEqual($oCreative->height, 1);

        $fileName = $this->writeTempFile($this->imgJpeg);

        $oCreative = OA_Creative_File::factory($fileName, 'foo.jpg');
        $this->assertIsA($oCreative, 'OA_Creative_File');
        $this->assertEqual($oCreative->fileName, 'foo.jpg');
        $this->assertEqual($oCreative->contentType, 'jpeg');
        $this->assertEqual($oCreative->content, $this->imgJpeg);
        $this->assertEqual($oCreative->width, 1);
        $this->assertEqual($oCreative->height, 1);

        $fileName = $this->writeTempFile($this->imgWebp);

        $oCreative = OA_Creative_File::factory($fileName, 'foo.webp');
        $this->assertIsA($oCreative, 'OA_Creative_File');
        $this->assertEqual($oCreative->fileName, 'foo.webp');
        $this->assertEqual($oCreative->contentType, 'webp');
        $this->assertEqual($oCreative->content, $this->imgWebp);
        $this->assertEqual($oCreative->width, 1);
        $this->assertEqual($oCreative->height, 1);

        $fileName = $this->writeTempFile($this->imgAvif);

        $oCreative = OA_Creative_File::factory($fileName, 'foo.avif');

        if (PHP_VERSION_ID < 80200) {
            $this->assertIsA($oCreative, 'PEAR_Error');
        } else {
            $this->assertIsA($oCreative, 'OA_Creative_File');
            $this->assertEqual($oCreative->fileName, 'foo.avif');
            $this->assertEqual($oCreative->contentType, 'avif');
            $this->assertEqual($oCreative->content, $this->imgAvif);
            $this->assertEqual($oCreative->width, 1);
            $this->assertEqual($oCreative->height, 1);
        }

        $oCreative = OA_Creative_File::factory('non-existing');
        $this->assertIsA($oCreative, 'PEAR_Error');
    }

    public function testFactoryString()
    {
        $oCreative = OA_Creative_File::factoryString('foo.gif', $this->imgGif);
        $this->assertIsA($oCreative, 'OA_Creative_File');
        $this->assertEqual($oCreative->fileName, 'foo.gif');
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
    public function testFactoryUploadedFile() {}

    public function testStaticGetContentTypeByExtension()
    {
        $this->assertEqual(
            'jpeg',
            OA_Creative_File::staticGetContentTypeByExtension('file1.jpg'),
        );
        $this->assertEqual(
            'webp',
            OA_Creative_File::staticGetContentTypeByExtension('file1.webp'),
        );
        $this->assertEqual(
            'png',
            OA_Creative_File::staticGetContentTypeByExtension(
                'http://www.example.com/files/banner.png',
            ),
        );
        $file = new OA_Creative_File('file1.jpg');
        $this->assertEqual('jpeg', $file->getContentTypeByExtension());
    }

    public function testRichMedia()
    {
        // Allow supported richmedia by extension, no matter what the content is
        $oCreative = OA_Creative_File::factoryString('foo.dcr', 'xxx');
        $this->assertIsA($oCreative, 'OA_Creative_File_RichMedia');
        $oCreative = OA_Creative_File::factoryString('foo.mov', 'xxx');
        $this->assertIsA($oCreative, 'OA_Creative_File_RichMedia');
        $oCreative = OA_Creative_File::factoryString('foo.rpm', 'xxx');
        $this->assertIsA($oCreative, 'OA_Creative_File_RichMedia');
    }

    public function writeTempFile($content)
    {
        $fileName = tempnam(MAX_PATH . '/var', 'test_creative_file_');
        $oldFilename = $fileName;
        $fileName = $oldFilename . '.png';
        rename($oldFilename, $fileName);
        $this->assertTrue($fp = fopen($fileName, 'w'), 'Cannot open file: ' . $fileName);
        $this->assertTrue(fwrite($fp, $content), 'Cannot write to file: ' . $fileName);
        $this->assertTrue(fclose($fp), 'Cannot close file: ' . $fileName);

        $this->tempFiles[] = $fileName;

        return $fileName;
    }
}
