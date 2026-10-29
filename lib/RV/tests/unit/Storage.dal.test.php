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

use League\Flysystem\Config;
use League\Flysystem\Filesystem;
use League\Flysystem\UnableToCopyFile;
use League\Flysystem\UnableToReadFile;
use RV\Bridge\Flysystem\SqlStoredBannerAdapter;

require_once MAX_PATH . '/www/admin/lib-storage.inc.php';

class Test_RV_Storage extends UnitTestCase
{
    private array $filenames = ['flysystem-test.png', 'flysystem-copy.png', 'flysystem-moved.png'];

    public function tearDown()
    {
        $filesystem = new Filesystem(new SqlStoredBannerAdapter());
        foreach ($this->filenames as $filename) {
            $filesystem->delete($filename);
        }
    }

    public function testSqlImageLifecycle()
    {
        $contents = "image\0bytes\xff";
        $name = phpAds_ImageStore('sql', $this->filenames[0], $contents);
        $this->assertEqual($name, $this->filenames[0]);
        $this->assertEqual(phpAds_ImageRetrieve('sql', $name), $contents);
        $this->assertEqual(phpAds_ImageSize('sql', $name), strlen($contents));

        $duplicate = phpAds_ImageDuplicate('sql', $name);
        $this->assertTrue(is_string($duplicate));
        if (is_string($duplicate)) {
            $this->filenames[] = $duplicate;
            $this->assertNotEqual($duplicate, $name);
            $this->assertEqual(phpAds_ImageRetrieve('sql', $duplicate), $contents);
        }

        $this->assertEqual(phpAds_ImageStore('sql', $name, 'replacement', true), $name);
        $this->assertEqual(phpAds_ImageRetrieve('sql', $name), 'replacement');
        $this->assertTrue(phpAds_ImageDelete('sql', $name));
        $this->assertFalse(phpAds_ImageDelete('sql', $name));
        $this->assertIdentical(phpAds_ImageRetrieve('sql', $name), false);
        $this->assertIdentical(phpAds_ImageSize('sql', $name), false);
        $this->assertIdentical(phpAds_ImageDuplicate('sql', $name), false);
    }

    public function testSqlCopyAndMoveOverwriteDestination()
    {
        $filesystem = new Filesystem(new SqlStoredBannerAdapter());
        $filesystem->write($this->filenames[0], 'source');
        $filesystem->write($this->filenames[1], 'old destination');
        $filesystem->copy($this->filenames[0], $this->filenames[1]);
        $this->assertEqual($filesystem->read($this->filenames[1]), 'source');
        $filesystem->write($this->filenames[2], 'old destination');
        $filesystem->move($this->filenames[1], $this->filenames[2]);
        $this->assertFalse($filesystem->fileExists($this->filenames[1]));
        $this->assertEqual($filesystem->read($this->filenames[2]), 'source');
        $filesystem->write($this->filenames[2], 'source');
        $this->assertEqual($filesystem->read($this->filenames[2]), 'source');
    }

    public function testMissingSqlFilesThrowFlysystemExceptions()
    {
        $adapter = new SqlStoredBannerAdapter();
        $this->expectException(UnableToReadFile::class);
        $adapter->read('flysystem-missing.png');
    }

    public function testMissingSqlCopyDoesNotCreateDestination()
    {
        $adapter = new SqlStoredBannerAdapter();
        try {
            $adapter->copy('flysystem-missing.png', $this->filenames[1], new Config());
            $this->fail('Copying a missing image must fail.');
        } catch (UnableToCopyFile) {
            $this->assertFalse($adapter->fileExists($this->filenames[1]));
        }
    }
}
