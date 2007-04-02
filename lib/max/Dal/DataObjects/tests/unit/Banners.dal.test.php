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

require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing non standard DataObjects_Banners methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataObjects_BannersTest extends DalUnitTestCase
{
    /**
     * The constructor method.
     */
    function DataObjects_BannersTest()
    {
        $this->UnitTestCase();
    }
    
    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testDuplicate()
    {
        $filename = 'test.gif';
        
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->filename = $filename;
        $doBanners->storagetype = 'sql';
        
        $id1 = DataGenerator::generateOne($doBanners);

        $doBanners = MAX_DB::staticGetDO('banners', $id1);

        Mock::generatePartial(
            'DataObjects_Banners',
            $mockBanners = 'DataObjects_Banners'.rand(),
            array('_imageDuplicate')
        );
        $doMockBanners = new $mockBanners($this);
        $doMockBanners->setFrom($doBanners);
        $doMockBanners->setReturnValue('_imageDuplicate', $filename);
        // make sure image was duplicated as well
        $doMockBanners->expectOnce('_imageDuplicate');
        $id2 = $doMockBanners->duplicate(); // duplicate
        $doMockBanners->tally();
        
        $this->assertNotEmpty($id2);
        $this->assertNotEqual($id1, $id2);

        $doBanners1 = MAX_DB::staticGetDO('banners', $id1);
        $doBanners2 = MAX_DB::staticGetDO('banners', $id2);
        // assert they are equal (but without comparing primary key)
        $this->assertNotEqualDataObjects($this->stripKeys($doBanners1), $this->stripKeys($doBanners2));
        
        // Test that the only difference is their description
        $doBanners1->description = $doBanners2->description = null;
        $this->assertEqualDataObjects($this->stripKeys($doBanners1), $this->stripKeys($doBanners2));
    }
    
    
    function testInsert()
    {
        $doBanners = MAX_DB::factoryDO('banners');
        $bannerId = $doBanners->insert();
        $doAdZoneAssoc = MAX_DB::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_id = $bannerId;
        $doAdZoneAssoc->zone_id = 0;
        $this->assertTrue($doAdZoneAssoc->find());
        $this->assertTrue($doAdZoneAssoc->fetch());
    }
}
?>