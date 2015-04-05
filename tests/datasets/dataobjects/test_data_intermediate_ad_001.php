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
 *
 * @abstract A class for generating/loading a dataset for delivery testing
 * @package Test Classes
 */

require_once MAX_PATH . '/tests/testClasses/OATestData_DataObjects.php';
class OA_Test_Data_data_intermediate_ad_001 extends OA_Test_Data_DataObjects
{

    /**
     * method for extending OA_Test_Data_DataObject
     */

    function generateTestData($linkAdZone=false)
    {
        if (!parent::init())
        {
            return false;
        }

        // Disable Auditing while loading the test data:
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = false;

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->reportlastdate = '2007-04-03 18:39:45';
        $this->aIds['clients'][] = DataGenerator::generateOne($doClients);

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->reportlastdate = '2007-04-03 18:39:45';
        $this->aIds['clients'][] = DataGenerator::generateOne($doClients);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $this->aIds['clients'][1];
        $this->aIds['campaigns'][] = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $doBanners->clientid = $this->aIds['clients'][0];
        $doBanners->campaignid = $this->aIds['campaigns'][0];
        $this->aIds['banners'][] = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $doBanners->clientid = $this->aIds['clients'][1];
        $doBanners->campaignid = $this->aIds['campaigns'][0];
        $this->aIds['banners'][] = DataGenerator::generateOne($doBanners);

        $impressions        = 123;
        $clicks             = 45;
        $conversions        = 67;
        $total_basket_value = 100.00;
        $total_num_items    = 100;
        $creative_id        = 4;
        $zone_id            = 5;
        $day                = '2007-04-04';
        $hour               = 17;
        $date_time          = sprintf('%s %02d:00:00', $day, $hour);
        $interval_start     = sprintf('%s %02d:00:00', $day, $hour);
        $interval_end       = sprintf('%s %02d:59:59', $day, $hour);

        $doDataIA = OA_Dal::factoryDO('data_intermediate_ad');
        $doDataIA->ad_id = $this->aIds['banners'][0];
        $doDataIA->impressions = $impressions;
        $doDataIA->clicks = $clicks;
        $doDataIA->conversions = $conversions;
        $doDataIA->total_basket_value = $total_basket_value;
        $doDataIA->total_num_items = $total_num_items;
        $doDataIA->creative_id = $creative_id;
        $doDataIA->zone_id = $zone_id;
        $doDataIA->day = $day;
        $doDataIA->date_time = $date_time;
        $doDataIA->interval_start = $interval_start;
        $doDataIA->interval_end = $interval_end;
        $this->aIds['dataIA'][] = DataGenerator::generateOne($doDataIA);

        $doDataIA = OA_Dal::factoryDO('data_intermediate_ad');
        $doDataIA->ad_id = $this->aIds['banners'][0];
        $doDataIA->impressions = $impressions;
        $doDataIA->clicks = $clicks;
        $doDataIA->conversions = $conversions;
        $doDataIA->total_basket_value = $total_basket_value;
        $doDataIA->total_num_items = $total_num_items;
        $doDataIA->creative_id = $creative_id;
        $doDataIA->zone_id = $zone_id;
        $doDataIA->day = $day;
        $doDataIA->date_time = $date_time;
        $doDataIA->interval_start = $interval_start;
        $doDataIA->interval_end = $interval_end;
        $this->aIds['dataIA'][] = DataGenerator::generateOne($doDataIA);

        $doDataIA = OA_Dal::factoryDO('data_intermediate_ad');
        $doDataIA->ad_id = 99;
        $doDataIA->impressions = $impressions;
        $doDataIA->clicks = $clicks;
        $doDataIA->conversions = $conversions;
        $doDataIA->total_basket_value = $total_basket_value;
        $doDataIA->total_num_items = $total_num_items;
        $doDataIA->creative_id = $creative_id;
        $doDataIA->zone_id = $zone_id;
        $doDataIA->day = $day;
        $doDataIA->date_time = $date_time;
        $doDataIA->interval_start = $interval_start;
        $doDataIA->interval_end = $interval_end;
        $this->aIds['dataIA'][] = DataGenerator::generateOne($doDataIA);

        return $this->aIds;
    }

}
?>

