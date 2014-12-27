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

require_once MAX_PATH . '/lib/util/file/file.php';

/**
 * A class for testing the filesystem utilities. It requires the permission
 * to write to the filesystem to run properly!
 *
 * @package    Util
 * @subpackage File
 */
class Test_OA_Dal extends UnitTestCase
{
    function testUtil_File_remove()
    {
        $testDirectoryPath = MAX_PATH . '/var/tests';
        mkdir($testDirectoryPath);
        mkdir($testDirectoryPath . '/subdir1');
        mkdir($testDirectoryPath . '/subdir2');
        touch($testDirectoryPath . '/normalfile.txt');
        touch($testDirectoryPath . '/.hiddenfile.txt');
        touch($testDirectoryPath . '/subdir1/normalfile.txt');
        touch($testDirectoryPath . '/subdir1/.hiddenfile.txt');

        $this->assertTrue(Util_File_remove($testDirectoryPath));

        $this->assertFalse(file_exists($testDirectoryPath));
    }
}
?>