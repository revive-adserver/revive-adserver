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

        $rsDal = $this->dalData_intermediate_ad->getDeliveredByCampaign(123);
        $aDelivered = $rsDal->toArray();
        foreach ($aDelivered as $delivered) {
            $this->assertNull($delivered);
        }
        $this->aIds = TestEnv::loadData('data_intermediate_ad_001');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testGetDeliveredByCampaign()
    {
        $impressions    = 123;
        $clicks         = 45;
        $conversions    = 67;
        $campaignId     = $this->aIds['campaigns'][0];

        $rsDal = $this->dalData_intermediate_ad->getDeliveredByCampaign($campaignId);
        $aDelivered = $rsDal->toArray();
        $howMany = 2;
        $this->assertEqual($aDelivered['impressions_delivered'], $howMany * $impressions);
        $this->assertEqual($aDelivered['clicks_delivered'], $howMany * $clicks);
        $this->assertEqual($aDelivered['conversions_delivered'], $howMany * $conversions);
    }

    function testAddConversion()
    {
        $day                    = '2007-04-04';
        $hour                   = 17;
        $total_basket_value     = 100.00;
        $creative_id            = 4;
        $zone_id                = 5;
        $bannerId               = $this->aIds['banners'][0];
        $dataIntermediateAdId   = $this->aIds['dataIA'][0];

        $result = $this->dalData_intermediate_ad->addConversion(
                                                        '+',
                                                        $basketValue = 12,
                                                        $numItems = 4,
                                                        $bannerId,
                                                        $creative_id,
                                                        $zone_id,
                                                        $day,
                                                        $hour
                                                    );

	    $doData_intermediate_ad = OA_Dal::staticGetDO('data_intermediate_ad', $dataIntermediateAdId);

	    $this->assertEqual($doData_intermediate_ad->total_basket_value, $total_basket_value+$basketValue);
    }

/*
    function testGetDeliveredByCampaign()
    {
        // Ensure that there is no data in the data_intermediate_ad to begin with
        $rsDal = $this->dalData_intermediate_ad->getDeliveredByCampaign(123);
        $aDelievered = $rsDal->toArray();
        foreach ($aDelievered as $delivered) {
            $this->assertNull($delivered);
        }

        // Add a banner that will not have any intermediate data
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $aBannerIds = $dg->generate($doBanners, 1, true);

        // Add the test banner that will have intermediate data
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );

        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $aBannerIds = $dg->generate($doBanners, 1, true);
        $campaignId = DataGenerator::getReferenceId('campaigns');

        // Prepare the data for the data_intermediate_ad table,
        // there are 3 records being inserted.
        $aData = array(
            // Use the second banners' $bannerId value for the
            // first two records, and ID 3 (a fake ID) for the
            // third value
            'ad_id'          => array($aBannerIds[0], $aBannerIds[0], 3),
            // Use the same values for all records from here on
            'impressions'    => array($impressions = 123),
            'clicks'         => array($clicks = 45),
            'conversions'    => array($conversions = 67),
            'day'            => array('2007-04-04'),
            'interval_start' => array('2007-04-04 17:00:00'),
            'interval_end'   => array('2007-04-04 17:59:59')
        );

        $dg = new DataGenerator();
        $dg->setData('data_intermediate_ad', $aData);
        $dg->generate('data_intermediate_ad', 3);

        // Test
        $rsDal = $this->dalData_intermediate_ad->getDeliveredByCampaign($campaignId);
        $aDelievered = $rsDal->toArray();
        $howMany = 2;
        $this->assertEqual($aDelievered['impressions_delivered'], $howMany * $impressions);
        $this->assertEqual($aDelievered['clicks_delivered'], $howMany * $clicks);
        $this->assertEqual($aDelievered['conversions_delivered'], $howMany * $conversions);
    }

    function testAddConversion()
    {
        // Ensure that there is no data in the data_intermediate_ad to begin with
        $rsDal = $this->dalData_intermediate_ad->getDeliveredByCampaign(123);
        $aDelievered = $rsDal->toArray();
        foreach ($aDelievered as $delivered) {
            $this->assertNull($delivered);
        }

        // Add a banner that will not have any intermediate data
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $aBannerIds = $dg->generate($doBanners, 1, true);

        // Add the test banner that will have intermediate data
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $aBannerIds = $dg->generate($doBanners, 1, true);
        $bannerId = $aBannerIds[0];
        $campaignId = DataGenerator::getReferenceId('campaigns');

        // Prepare the data for the data_intermediate_ad table,
        // there is one record being inserted.
        $day  = '2007-04-04';
        $hour = 17;
        $aData = array(
            'ad_id'              => array($bannerId),
            'conversions'        => array($conversions = 67),
            'total_basket_value' => array($total_basket_value = 100.00),
            'total_num_items'    => array($total_num_items = 100),
            'creative_id'        => array($creative_id = 4),
            'zone_id'            => array($zone_id = 5),
            'date_time'          => array(sprintf('%s %02d:00:00', $day, $hour)),
            'interval_start'     => array(sprintf('%s %02d:00:00', $day, $hour)),
            'interval_end'       => array(sprintf('%s %02d:59:59', $day, $hour))
        );
        $dg = new DataGenerator();
        $dg->setData('data_intermediate_ad', $aData);
        $dataIntermediateAdId = $dg->generateOne('data_intermediate_ad');

        $this->dalData_intermediate_ad->addConversion(
            '+',
            $basketValue = 12,
            $numItems = 4,
            $bannerId,
            $creative_id,
            $zone_id,
            $day,
            $hour
        );

	    $doData_intermediate_ad = OA_Dal::staticGetDO('data_intermediate_ad', $dataIntermediateAdId);

	    $this->assertEqual($doData_intermediate_ad->total_basket_value, $total_basket_value+$basketValue);
    }
*/
}

?>