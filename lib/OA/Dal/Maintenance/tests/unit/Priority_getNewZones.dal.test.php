<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the getNewZones() method of the non-DB specific
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_getNewZones extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getNewZones()
    {
        $this->UnitTestCase();
    }

    /**
     * The method to test the getNewZones() method.
     */
    function testGetNewZones()
    {
        $oDal = new OA_Dal_Maintenance_Priority();

        // Test with bad input
        $aZoneIds = 'foo';
        $aResult = $oDal->getNewZones($aZoneIds);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aZoneIds = array();
        $aResult = $oDal->getNewZones($aZoneIds);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aZoneIds = array();
        $aZoneIds[] = 'foo';
        $aResult = $oDal->getNewZones($aZoneIds);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with no zones in the system, all set zone
        // IDs should be returned as having no data
        $aZoneIds = array();
        $aZoneIds[] = 1;
        $aZoneIds[] = 2;
        $aZoneIds[] = 3;

        $aResult = $oDal->getNewZones($aZoneIds);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
        $this->assertTrue(in_array(1, $aResult));
        $this->assertTrue(in_array(2, $aResult));
        $this->assertTrue(in_array(3, $aResult));
 
        // Add campaigns
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Active Campaign';
        $doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $idCampaign = DataGenerator::generateOne($doCampaigns);

        // Add banner to campaign
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->weight = 1;
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $doBanners->campaignid = $idCampaign;
        $idBanner = DataGenerator::generateOne($doBanners);

        // Add zone
        $idZone = DataGenerator::generateOne('zones', true);

        // Connect zones with banners (ad_zone_assoc)
        $doAd_zone_assoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAd_zone_assoc->ad_id = $idBanner;
        $doAd_zone_assoc->zone_id = $idZone;
        DataGenerator::generateOne($doAd_zone_assoc);


        // Add a ZIF item to the data_summary_zone_impression_history
        // table and ensure that the corresponding zone ID is no
        // longer returned
        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = 0;
        $doData_summary_zone_impression_history->interval_start = '2007-09-23 00:00:00';
        $doData_summary_zone_impression_history->interval_end = '2007-09-23 00:59:59';
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->forecast_impressions = 37;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);
        
        $aResult = $oDal->getNewZones($aZoneIds);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertTrue(in_array(2, $aResult));
        $this->assertTrue(in_array(3, $aResult));

        DataGenerator::cleanUp();
    }

}

?>