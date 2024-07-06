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

/**
 * @package    Max
 * @subpackage TestSuite
 */

require_once MAX_PATH . '/lib/max/FileScanner.php';

define('MAX_FILE_TEST_DIR', MAX_PATH . '/lib/max/Plugins/tests/testdir');

class TestOfFileScanner extends UnitTestCase
{
    public function __construct()
    {
        parent::__construct('FileScanner test');
    }

    public function testFileScanner()
    {
        $fs = new MAX_FileScanner();

        $this->assertIdentical($fs->getFileExtension('test.php'), 'php');

        $fs->addFileTypes(['php', 'inc']);
        $this->assertIdentical($fs->isAllowedFile('test.php'), true);
        $this->assertIdentical($fs->isAllowedFile('test.inc'), true);

        $this->assertIdentical($fs->getAllFiles(), []);
        $fs->addFile('test.php');
        $this->assertIdentical($fs->getAllFiles(), ['test.php']);
        $fs->addFile('test2.plugin.php');
        $this->assertIdentical($fs->getAllFiles(), ['test.php', 'test2.plugin.php']);
        $fs->addFile('test.inc');
        $this->assertIdentical($fs->getAllFiles(), ['test.inc', 'test.php', 'test2.plugin.php']);
        $fs->addFile('test.gif');
        $this->assertIdentical($fs->getAllFiles(), ['test.inc', 'test.php', 'test2.plugin.php']);
    }

    public function testAddDir()
    {
        $fs = new MAX_FileScanner();
        $fs->addFileTypes(['php', 'inc']);
        $fs->addDir(MAX_FILE_TEST_DIR);
        $this->assertIdentical(
            $fs->getAllFiles(),
            [
                MAX_FILE_TEST_DIR . '/test.inc',
                MAX_FILE_TEST_DIR . '/test.plugin.php',
                MAX_FILE_TEST_DIR . '/translation.php',
            ],
        );

        $fs->reset();
        $fs->addDir(MAX_FILE_TEST_DIR, $recursive = true);
        $this->assertIdentical(
            $fs->getAllFiles(),
            [
                MAX_FILE_TEST_DIR . '/subdir/test2.plugin.php',
                MAX_FILE_TEST_DIR . '/test.inc',
                MAX_FILE_TEST_DIR . '/test.plugin.php',
                MAX_FILE_TEST_DIR . '/translation.php',
            ],
        );
    }

    public function testFileMaskAndSubdir()
    {
        $fs = new MAX_FileScanner();
        $fs->addFileTypes(['php', 'inc']);
        $fs->setFileMask('#^.*/([a-zA-Z0-9\-_]*)\.plugin\.php$#');
        $fs->addDir(MAX_FILE_TEST_DIR);
        $this->assertIdentical($fs->getAllFiles(), [MAX_FILE_TEST_DIR . '/test.plugin.php']);
    }
}
