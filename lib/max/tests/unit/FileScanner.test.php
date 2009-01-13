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

/**
 * @package    Max
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@m3.net>
 */

    require_once MAX_PATH . '/lib/max/FileScanner.php';

    define('MAX_FILE_TEST_DIR', MAX_PATH.'/lib/max/Plugins/tests/testdir');

    class TestOfFileScanner extends UnitTestCase {
        
        function TestOfFileScanner() {
            $this->UnitTestCase('FileScanner test');
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
            $fs->setFileMask('^.*/([a-zA-Z0-9\-_]*)\.plugin\.php$');
            $fs->addDir(MAX_FILE_TEST_DIR);
            $this->assertIdentical($fs->getAllFiles(), array(MAX_FILE_TEST_DIR.'/test.plugin.php'));
        }

    }

?>