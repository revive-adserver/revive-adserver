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
    function __construct()
    {
        parent::__construct();
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

        // Test creating a text ad. Ensure it is linked to zone 0 even though
        // zone 0 is not a text zone.
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-03 19:28:06';
        $doBanners->contenttype = 'txt';
        $doBanners->storagetype = 'txt';
        $bannerId = DataGenerator::generateOne($doBanners, true);
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_id = $bannerId;
        $doAdZoneAssoc->zone_id = 0;
        $this->assertTrue($doAdZoneAssoc->find());
        $this->assertTrue($doAdZoneAssoc->fetch());
    }

}

?>
