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
require_once MAX_PATH . '/lib/max/Dal/Admin/Acls.php';

/**
 * A class for testing DAL Acls methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_Data_intermediate_adTest extends DalUnitTestCase
{
    var $dalData_intermediate_ad;

    /**
     * The constructor method.
     */
    function MAX_Dal_Admin_Data_intermediate_adTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->dalData_intermediate_ad = OA_Dal::factoryDAL('data_intermediate_ad');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testGetDeliveredByCampaign()
    {
        // Check it's empty if no data
        $rsDal = $this->dalData_intermediate_ad->getDeliveredByCampaign(123);
        $aDelievered = $rsDal->toArray();
        foreach ($aDelievered as $delivered) {
            $this->assertNull($delivered);
        }

        // Add some test data
        DataGenerator::generateOne('banners', $addParents = true); // generate some reduntand data
        $bannerId = DataGenerator::generateOne('banners', $addParents = true);
        $campaignId = DataGenerator::getReferenceId('campaigns');
        $data = array(
            // two banners $bannerId
            'ad_id' => array($bannerId, $bannerId, 3),
            'impressions' => array($impressions = 123),
            'clicks' => array($clicks = 45),
            'conversions' => array($conversions = 67),
        );
        $dg = new DataGenerator();
        $dg->setData('data_intermediate_ad', $data);
        $dg->generate('data_intermediate_ad', 3);

        // Test
        $rsDal = $this->dalData_intermediate_ad->getDeliveredByCampaign($campaignId);
        $aDelievered = $rsDal->toArray();
        $howMany = 2; // two banners $bannerId
        $this->assertEqual($aDelievered['impressions_delivered'], $howMany * $impressions);
        $this->assertEqual($aDelievered['clicks_delivered'], $howMany * $clicks);
        $this->assertEqual($aDelievered['conversions_delivered'], $howMany * $conversions);
    }

    function testAddConversion()
    {
        // Add test data
        DataGenerator::generateOne('banners', $addParents = true); // generate some reduntand data
        $bannerId = DataGenerator::generateOne('banners', $addParents = true);
        $campaignId = DataGenerator::getReferenceId('campaigns');
        $data = array(
            // two banners $bannerId
            'ad_id' => array($bannerId, $bannerId, $bannerId + 4),
            'conversions' => array($conversions = 67),
            'total_basket_value' => array($total_basket_value = 100.00),
            'total_num_items' => array($total_num_items = 100),
            'creative_id' => array($creative_id = 4),
            'zone_id' => array($zone_id = 5),
            'day' => array($day = '2007-01-01'),
            'hour' => array($hour = 5),
        );
        $dg = new DataGenerator();
        $dg->setData('data_intermediate_ad', $data);
        $data_intermediate_ad_id = $dg->generateOne('data_intermediate_ad');

        $this->dalData_intermediate_ad->addConversion('+', $basketValue = 12,
                $numItems = 4, $bannerId, $creative_id, $zone_id, $day, $hour);

	    $doData_intermediate_ad = OA_Dal::staticGetDO('data_intermediate_ad', $data_intermediate_ad_id);

	    $this->assertEqual($doData_intermediate_ad->total_basket_value, $data['total_basket_value'][0]+$basketValue);
    }

}
?>