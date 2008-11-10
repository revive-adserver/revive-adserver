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
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Banners.php';

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
        DataGenerator::cleanUp(array('ad_zone_assoc'));
    }

    function testDuplicate()
    {
        $GLOBALS['strCopyOf'] = 'Copy of ';
        $filename = 'test.gif';

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->filename = $filename;
        $doBanners->storagetype = 'sql';
        $doBanners->acls_updated = '2007-04-03 19:28:06';

        $id1 = DataGenerator::generateOne($doBanners, true);

        $doBanners = OA_Dal::staticGetDO('banners', $id1);

        Mock::generatePartial(
            'DataObjects_Banners',
            $mockBanners = 'DataObjects_Banners'.rand(),
            array('_imageDuplicate')
        );
        $doMockBanners = new $mockBanners($this);
        $doMockBanners->init();
        $doMockBanners->setFrom($doBanners);
        $doMockBanners->bannerid = $doBanners->bannerid; // setFrom() doesn't copy primary key
        $doMockBanners->setReturnValue('_imageDuplicate', $filename);
        // make sure image was duplicated as well
        $doMockBanners->expectOnce('_imageDuplicate');
        $id2 = $doMockBanners->duplicate(); // duplicate
        $doMockBanners->tally();

        $this->assertNotEmpty($id2);
        $this->assertNotEqual($id1, $id2);

        $doBanners1 = OA_Dal::staticGetDO('banners', $id1);
        $doBanners2 = OA_Dal::staticGetDO('banners', $id2);
        // assert they are equal (but without comparing primary key)
        $this->assertNotEqualDataObjects($this->stripKeys($doBanners1), $this->stripKeys($doBanners2));

        // Test that the only difference is their description
        $doBanners1->description = $doBanners2->description = null;
        $this->assertEqualDataObjects($this->stripKeys($doBanners1), $this->stripKeys($doBanners2));
    }

    function testInsert()
    {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-03 19:28:06';
        $bannerId = DataGenerator::generateOne($doBanners, true);
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_id = $bannerId;
        $doAdZoneAssoc->zone_id = 0;
        $this->assertTrue($doAdZoneAssoc->find());
        $this->assertTrue($doAdZoneAssoc->fetch());
    }

}

?>
