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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing non standard DataObjects_Images methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataObjects_ImagesTest extends DalUnitTestCase
{
    /**
     * The constructor method.
     */
    function DataObjects_ImagesTest()
    {
        $this->UnitTestCase();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testGetUniqueFileNameForDuplication()
    {
        // Insert an image
        $doImages = OA_Dal::factoryDO('images');
        $doImages->filename = 'foo.jpg';
        $doImages->contents = '';
        DataGenerator::generateOne($doImages);

        // Get the image out of the DB
        $doImages = OA_Dal::staticGetDO('images', 'filename', 'foo.jpg');

        // Check it
        $expected = 'foo_2.jpg';
        $this->assertEqual($doImages->getUniqueFileNameForDuplication(), $expected);
    }
    
    /**
     * Tests the timestamps are updated correctly.
     * 
     * Test 1: Tests the current timestamp is inserted for a new image.
     * Test 2: Tests the timestamp is updated when an image is updated.
     *
     */
    function testUpdate()
    {
        // Test 1
        // Get the start time of the test
        $start = time();
        sleep(1);
        
        // Insert an image
        $doImages = OA_Dal::factoryDO('images');
        $doImages->filename = 'foo.jpg';
        $doImages->contents = '';
        DataGenerator::generateOne($doImages);
        
         // Get the image out of the DB
        $doImages = OA_Dal::staticGetDO('images', 'filename', 'foo.jpg');
        
        // Check the timestamp is > time at start of test and <= current time 
        // Deal with MySQL 4.0 timestamps
        if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)(\d\d)(\d\d)(\d\d)$/', $doImages->t_stamp, $m)) {
            $doImages->t_stamp = "{$m[1]}-{$m[2]}-{$m[3]} {$m[4]}:{$m[5]}:{$m[6]}";
        }
        $actual = strtotime($doImages->t_stamp);
        $this->assertTrue($actual > $start && $actual <= time());
        
        // Test 2       
        // Update the image
        $doImages->contents = '1';
        sleep(1);
        $doImages->update();
        
        // Get the image out of the DB
        $doImages = OA_Dal::staticGetDO('images', 'filename', 'foo.jpg');
        
        $oldTime = $actual;
        // Deal with MySQL 4.0 timestamps
        if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)(\d\d)(\d\d)(\d\d)$/', $doImages->t_stamp, $m)) {
            $doImages->t_stamp = "{$m[1]}-{$m[2]}-{$m[3]} {$m[4]}:{$m[5]}:{$m[6]}";
        }
        $actual = strtotime($doImages->t_stamp);
        $this->assertTrue($actual > $oldTime && $actual <= time());
    }

}
?>