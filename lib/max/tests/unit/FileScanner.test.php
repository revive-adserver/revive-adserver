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

    define('MAX_FILE_TEST_DIR', MAX_PATH.'/lib/max/Plugins/tests/testdir');

    class TestOfFileScanner extends UnitTestCase {

        function __construct() {
            parent::__construct('FileScanner test');
        }

        function testFileScanner() {
            $fs = new MAX_FileScanner();

            $this->assertIdentical($fs->getFileExtension('test.php'), 'php');

            $fs->addFileTypes(array('php','inc'));
            $this->assertIdentical($fs->isAllowedFile('test.php'), TRUE);
            $this->assertIdentical($fs->isAllowedFile('test.inc'), TRUE);

            $this->assertIdentical($fs->getAllFiles(), array());
            $fs->addFile('test.php');
            $this->assertIdentical($fs->getAllFiles(), array('test.php'));
            $fs->addFile('test2.plugin.php');
            $this->assertIdentical($fs->getAllFiles(), array('test.php','test2.plugin.php'));
            $fs->addFile('test.inc');
            $this->assertIdentical($fs->getAllFiles(), array('test.inc','test.php','test2.plugin.php'));
            $fs->addFile('test.gif');
            $this->assertIdentical($fs->getAllFiles(), array('test.inc','test.php','test2.plugin.php'));
        }

        function testAddDir() {
            $fs = new MAX_FileScanner();
            $fs->addFileTypes(array('php','inc'));
            $fs->addDir(MAX_FILE_TEST_DIR);
            $this->assertIdentical($fs->getAllFiles(),
                    array(
                        MAX_FILE_TEST_DIR.'/test.inc',
                        MAX_FILE_TEST_DIR.'/test.plugin.php',
                        MAX_FILE_TEST_DIR.'/translation.php',
                    )
                );

            $fs->reset();
            $fs->addDir(MAX_FILE_TEST_DIR, $recursive = true);
            $this->assertIdentical($fs->getAllFiles(),
                    array(
                        MAX_FILE_TEST_DIR.'/subdir/test2.plugin.php',
                        MAX_FILE_TEST_DIR.'/test.inc',
                        MAX_FILE_TEST_DIR.'/test.plugin.php',
                        MAX_FILE_TEST_DIR.'/translation.php',
                    )
                );
        }

        function testFileMaskAndSubdir() {
            $fs = new MAX_FileScanner();
            $fs->addFileTypes(array('php', 'inc'));
            $fs->setFileMask('#^.*/([a-zA-Z0-9\-_]*)\.plugin\.php$#');
            $fs->addDir(MAX_FILE_TEST_DIR);
            $this->assertIdentical($fs->getAllFiles(), array(MAX_FILE_TEST_DIR.'/test.plugin.php'));
        }

    }

?>