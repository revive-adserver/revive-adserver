<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

}
?>