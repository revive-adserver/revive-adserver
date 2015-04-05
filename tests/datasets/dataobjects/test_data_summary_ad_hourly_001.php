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
class OA_Test_Data_data_summary_ad_hourly_001 extends OA_Test_Data_DataObjects
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

        parent::generateTestData();

        for ($hour = 0; $hour < 24; $hour ++)
        {
            $doDSAH = OA_Dal::factoryDO('data_summary_ad_hourly');
            $doDSAH->date_time = sprintf('%s %02d:00:00', substr(OA::getNow(), 0, 10), $hour);
            $doDSAH->ad_id = $this->aIds['banners'][1];
            $doDSAH->creative_id = rand(1, 999);
            $doDSAH->zone_id = $this->aIds['zones'][1];
            $doDSAH->requests = rand(1, 999);
            $doDSAH->impressions = rand(1, 999);
            $doDSAH->clicks = rand(1, 999);
            $doDSAH->conversions = rand(1, 999);
            $doDSAH->total_basket_value = 0;
            $this->aIds['DSAH'][] = DataGenerator::generateOne($doDSAH);
        }
        return $this->aIds;
    }

}
?>

