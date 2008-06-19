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
$Id:$
*/

require_once MAX_PATH . '/lib/OA/Dal/Statistics/Zone.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/tests/util/DalStatisticsUnitTestCase.php';

/**
 * A class for testing DAL Statistic Zone methods
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */


class OA_Dal_Statistics_ZoneTest extends DalStatisticsUnitTestCase
{
    /**
     * Object for generate Zone Statistics.
     *
     * @var OA_Dal_Statistics_Zone $_dalZoneStatistics
     */
    var $_dalZoneStatistics;

    /**
     * The constructor method.
     */
    function OA_Dal_Statistics_ZoneTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->_dalZoneStatistics = new OA_Dal_Statistics_Zone();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * Test zone daily statistics.
     *
     */
    function testGetZoneDailyStatistics()
    {
        $doAgency    = OA_Dal::factoryDO('agency');
        $doPublisher = OA_Dal::factoryDO('affiliates');
        $doZone      = OA_Dal::factoryDO('zones');
        $this->generateZoneWithParents($doAgency, $doPublisher, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 121;
        $doDataSummaryAdHourly->requests      = 223;
        $doDataSummaryAdHourly->total_revenue = 433;
        $doDataSummaryAdHourly->clicks        = 9894;
        $doDataSummaryAdHourly->date_time     = '2006-06-06';
        $this->generateDataSummaryAdHourlyForZone($doDataSummaryAdHourly, $doZone);

        // 1. Get data existing range
        $rsZoneStatistics = $this->_dalZoneStatistics->getZoneDailyStatistics(
            $doZone->zoneid, new Date('2005-08-20'),  new Date('2007-08-20'));

        $rsZoneStatistics->find();
        $this->assertTrue($rsZoneStatistics->getRowCount() == 1,
            'Some records should be returned');

        $rsZoneStatistics->fetch();
        $aRow = $rsZoneStatistics->toArray();

        // 2. Check return fields names
        $this->assertFieldExists($aRow, 'day');
        $this->assertFieldExists($aRow, 'requests');
        $this->assertFieldExists($aRow, 'impressions');
        $this->assertFieldExists($aRow, 'clicks');
        $this->assertFieldExists($aRow, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow, 'impressions', 121);
        $this->assertFieldEqual($aRow, 'requests', 223);
        $this->assertFieldEqual($aRow, 'revenue', 433);
        $this->assertFieldEqual($aRow, 'clicks', 9894);
        $this->assertFieldEqual($aRow, 'day', '2006-06-06');

        // 4. Get data in not existing range
        $rsZoneStatistics = $this->_dalZoneStatistics->getZoneDailyStatistics(
            $doZone->zoneid,  new Date('2001-12-01'),  new Date('2006-01-19'));
        $rsZoneStatistics->find();
        $this->assertTrue($rsZoneStatistics->getRowCount() == 0,
            'Recordset should be empty');

    }

    /**
     * Test zone advertiser statistics.
     *
     */
    function testGetZoneAdvertiserStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign   = OA_Dal::factoryDO('campaigns');
        $doBanner1    = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner1);

        $advertiserId1 = $doAdvertiser->clientid;

        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign   = OA_Dal::factoryDO('campaigns');
        $doBanner2    = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner2);

        $doAgency    = OA_Dal::factoryDO('agency');
        $doPublisher = OA_Dal::factoryDO('affiliates');
        $doZone      = OA_Dal::factoryDO('zones');
        $this->generateZoneWithParents($doAgency, $doPublisher, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 31;
        $doDataSummaryAdHourly->requests      = 32;
        $doDataSummaryAdHourly->total_revenue = 33;
        $doDataSummaryAdHourly->clicks        = 34;
        $doDataSummaryAdHourly->date_time     = '1984-03-04';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner1, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 10;
        $doDataSummaryAdHourly->requests      = 20;
        $doDataSummaryAdHourly->total_revenue = 30;
        $doDataSummaryAdHourly->clicks        = 40;
        $doDataSummaryAdHourly->date_time     = '2007-04-14';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner1, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 10;
        $doDataSummaryAdHourly->requests      = 20;
        $doDataSummaryAdHourly->total_revenue = 30;
        $doDataSummaryAdHourly->clicks        = 40;
        $doDataSummaryAdHourly->date_time     = '2000-04-14';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner2, $doZone);

        // 1. Get data existing range
        $rsZoneStatistics = $this->_dalZoneStatistics->getZoneAdvertiserStatistics(
            $doZone->zoneid, new Date('1984-01-01'),  new Date('2007-10-18'));

        $rsZoneStatistics->find();
        $this->assertTrue($rsZoneStatistics->getRowCount() == 2,
            'Some records should be returned');

        $rsZoneStatistics->fetch();
        $aRow1 = $rsZoneStatistics->toArray();

        $rsZoneStatistics->fetch();
        $aRow2 = $rsZoneStatistics->toArray();

        $this->ensureRowSequence($aRow1, $aRow2, 'advertiserid', $advertiserId1);

        // 2. Check return fields names
        $this->assertFieldExists($aRow1, 'advertiserid');
        $this->assertFieldExists($aRow1, 'advertisername');
        $this->assertFieldExists($aRow1, 'requests');
        $this->assertFieldExists($aRow1, 'impressions');
        $this->assertFieldExists($aRow1, 'clicks');
        $this->assertFieldExists($aRow1, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow1, 'impressions', 41);
        $this->assertFieldEqual($aRow1, 'requests', 52);
        $this->assertFieldEqual($aRow1, 'revenue', 63);
        $this->assertFieldEqual($aRow1, 'clicks', 74);
        $this->assertFieldEqual($aRow2, 'impressions', 10);
        $this->assertFieldEqual($aRow2, 'requests', 20);
        $this->assertFieldEqual($aRow2, 'revenue', 30);
        $this->assertFieldEqual($aRow2, 'clicks', 40);

        // 4. Get data in not existing range
        $rsZoneStatistics = $this->_dalZoneStatistics->getZoneAdvertiserStatistics(
            $doZone->zoneid,  new Date('2007-09-21'),  new Date('2007-09-21'));
        $rsZoneStatistics->find();
        $this->assertTrue($rsZoneStatistics->getRowCount() == 0,
            'Recordset should be empty');

        // 5. Get data from only 1 advertiser
        $rsZoneStatistics = $this->_dalZoneStatistics->getZoneAdvertiserStatistics(
            $doZone->zoneid,  new Date('1984-01-01'),  new Date('1985-03-09'));
        $rsZoneStatistics->find();
        $this->assertTrue($rsZoneStatistics->getRowCount() == 1,
            'Some records should be returned');

        $rsZoneStatistics->fetch();
        $aRow = $rsZoneStatistics->toArray();
        $this->assertFieldEqual($aRow, 'impressions', 31);
    }

    /**
     * Test publisher campaign statistics.
     *
     */
    function testGetZoneCampaignStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign1  = OA_Dal::factoryDO('campaigns');
        $doBanner1    = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign1, $doBanner1);

        $doBanner2     = OA_Dal::factoryDO('banners');
        $this->generateBannerForCampaign($doCampaign1, $doBanner2);

        $doCampaign2   = OA_Dal::factoryDO('campaigns');
        $doBanner3     = OA_Dal::factoryDO('banners');
        $this->generateBannerAndCampaignForAdvertiser($doAdvertiser, $doCampaign2, $doBanner3);

        $doAgency    = OA_Dal::factoryDO('agency');
        $doPublisher = OA_Dal::factoryDO('affiliates');
        $doZone      = OA_Dal::factoryDO('zones');
        $this->generateZoneWithParents($doAgency, $doPublisher, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 1;
        $doDataSummaryAdHourly->requests      = 2;
        $doDataSummaryAdHourly->total_revenue = 3;
        $doDataSummaryAdHourly->clicks        = 4;
        $doDataSummaryAdHourly->date_time     = '2007-08-08';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner1, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 0;
        $doDataSummaryAdHourly->requests      = 1;
        $doDataSummaryAdHourly->total_revenue = 2;
        $doDataSummaryAdHourly->clicks        = 3;
        $doDataSummaryAdHourly->date_time     = '2007-09-08';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner2, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 10;
        $doDataSummaryAdHourly->requests      = 10;
        $doDataSummaryAdHourly->total_revenue = 10;
        $doDataSummaryAdHourly->clicks        = 10;
        $doDataSummaryAdHourly->date_time     = '2007-09-09';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner3, $doZone);

        // 1. Get data existing range
        $rsZoneStatistics = $this->_dalZoneStatistics->getZoneCampaignStatistics(
            $doZone->zoneid, new Date('2007-06-06'),  new Date('2007-09-18'));

        $rsZoneStatistics->find();
        $this->assertTrue($rsZoneStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsZoneStatistics->fetch();
        $aRow1 = $rsZoneStatistics->toArray();

        $rsZoneStatistics->fetch();
        $aRow2 = $rsZoneStatistics->toArray();

        $this->ensureRowSequence($aRow1, $aRow2, 'campaignid', $doCampaign1->campaignid);

        // 2. Check return fields names
        $this->assertFieldExists($aRow1, 'advertiserid');
        $this->assertFieldExists($aRow1, 'advertisername');
        $this->assertFieldExists($aRow1, 'campaignid');
        $this->assertFieldExists($aRow1, 'campaignname');
        $this->assertFieldExists($aRow1, 'requests');
        $this->assertFieldExists($aRow1, 'impressions');
        $this->assertFieldExists($aRow1, 'clicks');
        $this->assertFieldExists($aRow1, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow1, 'impressions', 1);
        $this->assertFieldEqual($aRow1, 'requests', 3);
        $this->assertFieldEqual($aRow2, 'revenue', 10);
        $this->assertFieldEqual($aRow2, 'clicks', 10);

        // 4. Get data in not existing range
        $rsZoneStatistics = $this->_dalZoneStatistics->getZoneCampaignStatistics(
            $doZone->affiliateid,  new Date('2007-09-21'),  new Date('2007-09-21'));
        $rsZoneStatistics->find();
        $this->assertTrue($rsZoneStatistics->getRowCount() == 0,
            'Recordset should be empty');

        // 5. Get data from only 1 row
        $rsZoneStatistics = $this->_dalZoneStatistics->getZoneCampaignStatistics(
            $doZone->zoneid, new Date('2007-06-06'),  new Date('2007-09-08'));
        $rsZoneStatistics->find();
        $this->assertTrue($rsZoneStatistics->getRowCount() == 1,
            'Some records should be returned');

    }


    /**
     * Test zone banner statistics.
     *
     */
    function testGetZoneBannerStatistics()
    {
        $doAgency                 = OA_Dal::factoryDO('agency');
        $doAdvertiser             = OA_Dal::factoryDO('clients');
        $doAdvertiser->clientname = 'advertiser name';
        $doCampaign               = OA_Dal::factoryDO('campaigns');
        $doCampaign->campaignname = 'campaign name';
        $doBanner1                = OA_Dal::factoryDO('banners');
        $doBanner1->description   = 'banner descrition';
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner1);

        $doBanner2 = OA_Dal::factoryDO('banners');
        $this->generateBannerForCampaign($doCampaign, $doBanner2);

        $doAgency    = OA_Dal::factoryDO('agency');
        $doPublisher = OA_Dal::factoryDO('affiliates');
        $doZone      = OA_Dal::factoryDO('zones');
        $this->generateZoneWithParents($doAgency, $doPublisher, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 111;
        $doDataSummaryAdHourly->requests      = 211;
        $doDataSummaryAdHourly->total_revenue = 311;
        $doDataSummaryAdHourly->clicks        = 411;
        $doDataSummaryAdHourly->date_time     = '2007-04-04';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner1, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 10;
        $doDataSummaryAdHourly->requests      = 11;
        $doDataSummaryAdHourly->total_revenue = 12;
        $doDataSummaryAdHourly->clicks        = 13;
        $doDataSummaryAdHourly->date_time     = '2007-10-08';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner1, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 0;
        $doDataSummaryAdHourly->requests      = 1;
        $doDataSummaryAdHourly->total_revenue = 22;
        $doDataSummaryAdHourly->clicks        = 777;
        $doDataSummaryAdHourly->date_time     = '2007-09-09';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner2, $doZone);

        // 1. Get data existing range
        $rsZoneStatistics = $this->_dalZoneStatistics->getZoneBannerStatistics(
            $doZone->affiliateid, new Date('2007-01-06'),  new Date('2007-11-18'));

        $rsZoneStatistics->find();
        $this->assertTrue($rsZoneStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsZoneStatistics->fetch();
        $aRow1 = $rsZoneStatistics->toArray();

        $rsZoneStatistics->fetch();
        $aRow2 = $rsZoneStatistics->toArray();

        $this->ensureRowSequence($aRow1, $aRow2, 'bannerid', $doBanner1->bannerid);

        // 2. Check return fields names
        $this->assertFieldExists($aRow1, 'advertiserid');
        $this->assertFieldExists($aRow1, 'advertisername');
        $this->assertFieldExists($aRow1, 'campaignid');
        $this->assertFieldExists($aRow1, 'campaignname');
        $this->assertFieldExists($aRow1, 'bannerid');
        $this->assertFieldExists($aRow1, 'bannername');
        $this->assertFieldExists($aRow1, 'requests');
        $this->assertFieldExists($aRow1, 'impressions');
        $this->assertFieldExists($aRow1, 'clicks');
        $this->assertFieldExists($aRow1, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow1, 'advertisername', $doAdvertiser->clientname);
        $this->assertFieldEqual($aRow1, 'campaignname', $doCampaign->campaignname);
        $this->assertFieldEqual($aRow1, 'bannername', $doBanner1->description);
        $this->assertFieldEqual($aRow1, 'impressions', 121);
        $this->assertFieldEqual($aRow1, 'requests', 222);
        $this->assertFieldEqual($aRow2, 'revenue', 22);
        $this->assertFieldEqual($aRow2, 'clicks', 777);

        // 4. Get data in not existing range
        $rsZoneStatistics = $this->_dalZoneStatistics->getZoneBannerStatistics(
            $doZone->affiliateid,  new Date('2007-12-21'),  new Date('2008-09-21'));
        $rsZoneStatistics->find();
        $this->assertTrue($rsZoneStatistics->getRowCount() == 0,
            'Recordset should be empty');

    }
    
    /**
     * Test zones performance statistics.
     *
     */
    function testGetZonesPerformanceStatistics()
    {
        $doCampaign1               = null;
        $doCampaign2               = null;
        $doZone1                   = null;
        $doZone2                   = null;
        $doDataSummaryAdHourly1    = null;
        $doDataSummaryAdHourly2    = null;
        $doDataSummaryAdHourly3    = null;
        
        $this->_generateDataForPerformanceStatisticsTests(
                    $doCampaign1, $doCampaign2, 
                    $doZone1, $doZone2, 
                    $doDataSummaryAdHourly1, $doDataSummaryAdHourly2, $doDataSummaryAdHourly3);
        
        // Get statistics for 2 zones 
        $aZonesStatistics = $this->_dalZoneStatistics->getZonesPerformanceStatistics(
            array( $doZone1->zoneid, $doZone2->zoneid ) , null, new Date('2008-04-27'),  new Date('2008-05-27'));
            
        $this->assertTrue(count($aZonesStatistics) == 2,
            '2 rows should be returned');

        $expectedCTR = round( (
                        ($doDataSummaryAdHourly1->clicks+$doDataSummaryAdHourly2->clicks) /
                        ($doDataSummaryAdHourly1->impressions+$doDataSummaryAdHourly2->impressions)
                       ), 4);
        $this->assertEqual($aZonesStatistics[$doZone1->zoneid]['CTR'], $expectedCTR);
        $this->assertEqual($aZonesStatistics[$doZone2->zoneid]['CTR'], round( ($doDataSummaryAdHourly3->clicks/$doDataSummaryAdHourly3->impressions), 4 ));
        
        $expectedECPM = round( (
                          ($doDataSummaryAdHourly1->total_revenue+$doDataSummaryAdHourly2->total_revenue)*1000 / 
                          ($doDataSummaryAdHourly1->impressions+$doDataSummaryAdHourly2->impressions)
                        ), 4 );
        $this->assertEqual($aZonesStatistics[$doZone1->zoneid]['eCPM'], $expectedECPM);
        $this->assertEqual($aZonesStatistics[$doZone2->zoneid]['eCPM'], round( ($doDataSummaryAdHourly3->total_revenue*1000/$doDataSummaryAdHourly3->impressions), 4 ));
        
        $this->assertEqual($aZonesStatistics[$doZone1->zoneid]['CR'], round( ($doDataSummaryAdHourly1->conversions/$doDataSummaryAdHourly1->impressions), 4 ));
        $this->assertEqual($aZonesStatistics[$doZone2->zoneid]['CR'], round( ($doDataSummaryAdHourly3->conversions/$doDataSummaryAdHourly3->impressions), 4 ));
        
        // Get statistics for 2 zones - increase impressions threshold to 100000 (only one zone meets requirements)
        $aZonesStatistics = $this->_dalZoneStatistics->getZonesPerformanceStatistics(
            array( $doZone1->zoneid, $doZone2->zoneid ), null, new Date('2008-04-27'),  new Date('2008-05-27'), 100000);

        $this->assertTrue(count($aZonesStatistics) == 2,
            '2 rows should be returned');
        
        $this->assertTrue(count($aZonesStatistics[$doZone1->zoneid]) == 3);
        $this->assertNull($aZonesStatistics[$doZone1->zoneid]['CTR']);
        $this->assertEqual($aZonesStatistics[$doZone2->zoneid]['CTR'], round( ($doDataSummaryAdHourly3->clicks/$doDataSummaryAdHourly3->impressions), 4 ));
        $this->assertNull($aZonesStatistics[$doZone1->zoneid]['eCPM']);
        $this->assertEqual($aZonesStatistics[$doZone2->zoneid]['eCPM'], round( ($doDataSummaryAdHourly3->total_revenue*1000/$doDataSummaryAdHourly3->impressions), 4 ));
        $this->assertNull($aZonesStatistics[$doZone1->zoneid]['CR']);
        $this->assertEqual($aZonesStatistics[$doZone2->zoneid]['CR'], round( ($doDataSummaryAdHourly3->conversions/$doDataSummaryAdHourly3->impressions), 4 ));
        
        // Get statistics - time span <30 days, one zone
        $aZonesStatistics = $this->_dalZoneStatistics->getZonesPerformanceStatistics(
            array( $doZone1->zoneid ), null, new Date('2008-05-01'),  new Date('2008-05-27'));
            
        $this->assertTrue(count($aZonesStatistics) == 1,
            '1 row should be returned');
        $this->assertTrue(count($aZonesStatistics[$doZone1->zoneid]) == 3);
        $this->assertNull($aZonesStatistics[$doZone1->zoneid]['CTR']);
        $this->assertNull($aZonesStatistics[$doZone1->zoneid]['eCPM']);
        $this->assertNull($aZonesStatistics[$doZone1->zoneid]['CR']);
    }
    
    /**
     * Test zones CR statistics.
     *
     */
    function testGetZonesConversionRateStatistics()
    {
        $doCampaign1               = null;
        $doCampaign2               = null;
        $doZone1                   = null;
        $doZone2                   = null;
        $doDataSummaryAdHourly1    = null;
        $doDataSummaryAdHourly2    = null;
        $doDataSummaryAdHourly3    = null;
        
        $this->_generateDataForPerformanceStatisticsTests(
                    $doCampaign1, $doCampaign2, 
                    $doZone1, $doZone2, 
                    $doDataSummaryAdHourly1, $doDataSummaryAdHourly2, $doDataSummaryAdHourly3);

        // Get statistics for 2 zones 
        $rsZonesStatistics = $this->_dalZoneStatistics->getZonesConversionRateStatistics(
            array( $doZone1->zoneid, $doZone2->zoneid ) , new Date('2008-04-27'),  new Date('2008-05-27'));
        $rsZonesStatistics->find();
        $this->assertTrue($rsZonesStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsZonesStatistics->fetch();
        $aRow1 = $rsZonesStatistics->toArray();
        $rsZonesStatistics->fetch();
        $aRow2 = $rsZonesStatistics->toArray();
        
        $this->ensureRowSequence($aRow1, $aRow2, 'zone_id', $doZone1->zoneid);
        
        $this->assertFieldExists($aRow1, 'zone_id');
        $this->assertFieldExists($aRow1, 'conversions');
        $this->assertFieldExists($aRow1, 'impressions');
        $this->assertFieldExists($aRow2, 'zone_id');
        $this->assertFieldExists($aRow2, 'conversions');
        $this->assertFieldExists($aRow2, 'impressions');
        
        $this->assertFieldEqual($aRow1, 'conversions', $doDataSummaryAdHourly1->conversions);
        $this->assertFieldEqual($aRow1, 'impressions', $doDataSummaryAdHourly1->impressions);
        $this->assertFieldEqual($aRow2, 'conversions', $doDataSummaryAdHourly3->conversions);
        $this->assertFieldEqual($aRow2, 'impressions', $doDataSummaryAdHourly3->impressions);
        
        // Get statistics for 2 zones and campaign 2 (CPM)
        $rsZonesStatistics = $this->_dalZoneStatistics->getZonesConversionRateStatistics(
            array( $doZone1->zoneid, $doZone2->zoneid ) , new Date('2008-04-27'),  new Date('2008-05-27'), $doCampaign2->campaignid);
        $rsZonesStatistics->find();
        $this->assertTrue($rsZonesStatistics->getRowCount() == 0,
            'Recordset should be empty');
        
        // Get statistics for zone 2 and set start date that it didn't catch any stats for this zone
        $rsZonesStatistics = $this->_dalZoneStatistics->getZonesConversionRateStatistics(
            array( $doZone2->zoneid ) , new Date('2008-05-16'),  new Date('2008-06-16'));
        $rsZonesStatistics->find();
        $this->assertTrue($rsZonesStatistics->getRowCount() == 0,
            'Recordset should be empty');
    }
    
    /**
     * Test zones eCPM statistics.
     *
     */
    function testGetZonesEcpmStatistics()
    {
        $doCampaign1               = null;
        $doCampaign2               = OA_Dal::factoryDO('campaigns');
        $doCampaign2->campaignname = 'campaign name';
        $doCampaign2->revenue_type = MAX_FINANCE_MT;
        $doZone1                   = null;
        $doZone2                   = null;
        $doDataSummaryAdHourly1    = null;
        $doDataSummaryAdHourly2    = null;
        $doDataSummaryAdHourly3    = null;
        
        $this->_generateDataForPerformanceStatisticsTests(
            $doCampaign1, $doCampaign2, 
            $doZone1, $doZone2, 
            $doDataSummaryAdHourly1, $doDataSummaryAdHourly2, $doDataSummaryAdHourly3);

        // Get statistics for 2 zones 
        $rsZonesStatistics = $this->_dalZoneStatistics->getZonesEcpmStatistics(
            array( $doZone1->zoneid, $doZone2->zoneid ) , new Date('2008-04-27'),  new Date('2008-05-27'));
        $rsZonesStatistics->find();
        $this->assertTrue($rsZonesStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsZonesStatistics->fetch();
        $aRow1 = $rsZonesStatistics->toArray();
        $rsZonesStatistics->fetch();
        $aRow2 = $rsZonesStatistics->toArray();
        
        $this->ensureRowSequence($aRow1, $aRow2, 'zone_id', $doZone1->zoneid);
        
        $this->assertFieldExists($aRow1, 'zone_id');
        $this->assertFieldExists($aRow1, 'total_revenue');
        $this->assertFieldExists($aRow1, 'impressions');
        $this->assertFieldExists($aRow2, 'zone_id');
        $this->assertFieldExists($aRow2, 'total_revenue');
        $this->assertFieldExists($aRow2, 'impressions');
        
        $this->assertFieldEqual($aRow1, 'total_revenue', $doDataSummaryAdHourly1->total_revenue);
        $this->assertFieldEqual($aRow1, 'impressions', $doDataSummaryAdHourly1->impressions);
        $this->assertFieldEqual($aRow2, 'total_revenue', $doDataSummaryAdHourly3->total_revenue);
        $this->assertFieldEqual($aRow2, 'impressions', $doDataSummaryAdHourly3->impressions);
        
        // Get statistics for 2 zones and campaign 2 (MT)
        $rsZonesStatistics = $this->_dalZoneStatistics->getZonesEcpmStatistics(
            array( $doZone1->zoneid, $doZone2->zoneid ) , new Date('2008-04-27'),  new Date('2008-05-27'), $doCampaign2->campaignid);
        $rsZonesStatistics->find();
        $this->assertTrue($rsZonesStatistics->getRowCount() == 0,
            'Recordset should be empty');
        
        // Get statistics for zone 2 and set start date that it didn't catch any stats for this zone
        $rsZonesStatistics = $this->_dalZoneStatistics->getZonesEcpmStatistics(
            array( $doZone2->zoneid ) , new Date('2008-05-16'),  new Date('2008-06-16'));
        $rsZonesStatistics->find();
        $this->assertTrue($rsZonesStatistics->getRowCount() == 0,
            'Recordset should be empty');
    }

    /**
     * Test zones CTR statistics.
     *
     */
    function testGetZonesCtrStatistics()
    {
        $doCampaign1                           = null;
        $doCampaign2                           = null;
        $doZone1                               = null;
        $doZone2                               = null;
        
        $doDataSummaryAdHourly1                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly1->impressions   = 9000;
        $doDataSummaryAdHourly1->requests      = 20000;
        $doDataSummaryAdHourly1->total_revenue = 100;
        $doDataSummaryAdHourly1->clicks        = 2000;
        $doDataSummaryAdHourly1->conversions   = 50;
        $doDataSummaryAdHourly1->date_time     = '2008-05-27';

        $doDataSummaryAdHourly2                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly2->impressions   = 1000;
        $doDataSummaryAdHourly2->requests      = 1500;
        $doDataSummaryAdHourly2->total_revenue = 100;
        $doDataSummaryAdHourly2->clicks        = 50;
        $doDataSummaryAdHourly2->conversions   = 0;
        $doDataSummaryAdHourly2->date_time     = '2008-05-20';
        
        $doDataSummaryAdHourly3                = null;
        
        $this->_generateDataForPerformanceStatisticsTests(
            $doCampaign1, $doCampaign2, 
            $doZone1, $doZone2, 
            $doDataSummaryAdHourly1, $doDataSummaryAdHourly2, $doDataSummaryAdHourly3);

        // Get statistics for 2 zones 
        $rsZonesStatistics = $this->_dalZoneStatistics->getZonesCtrStatistics(
            array( $doZone1->zoneid, $doZone2->zoneid ) , new Date('2008-04-27'),  new Date('2008-05-27'));
        $rsZonesStatistics->find();
        $this->assertTrue($rsZonesStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsZonesStatistics->fetch();
        $aRow1 = $rsZonesStatistics->toArray();
        $rsZonesStatistics->fetch();
        $aRow2 = $rsZonesStatistics->toArray();
        
        $this->ensureRowSequence($aRow1, $aRow2, 'zone_id', $doZone1->zoneid);

        $this->assertFieldExists($aRow1, 'zone_id');
        $this->assertFieldExists($aRow1, 'clicks');
        $this->assertFieldExists($aRow1, 'impressions');
        $this->assertFieldExists($aRow2, 'zone_id');
        $this->assertFieldExists($aRow2, 'clicks');
        $this->assertFieldExists($aRow2, 'impressions');
        
        $clicksZone1 = $doDataSummaryAdHourly1->clicks+$doDataSummaryAdHourly2->clicks;
        $impressionsZone1 = $doDataSummaryAdHourly1->impressions+$doDataSummaryAdHourly2->impressions;
        $this->assertFieldEqual($aRow1, 'clicks', $clicksZone1);
        $this->assertFieldEqual($aRow1, 'impressions', $impressionsZone1);
        $this->assertFieldEqual($aRow2, 'clicks', $doDataSummaryAdHourly3->clicks);
        $this->assertFieldEqual($aRow2, 'impressions', $doDataSummaryAdHourly3->impressions);
                
        // Get statistics for 2 zones for capmaign 1
        $rsZonesStatistics = $this->_dalZoneStatistics->getZonesCtrStatistics(
            array( $doZone1->zoneid, $doZone2->zoneid ) , new Date('2008-04-27'),  new Date('2008-05-27'), $doCampaign1->campaignid );
        $rsZonesStatistics->find();
        $this->assertTrue($rsZonesStatistics->getRowCount() == 1,
            '1 record should be returned');

        $rsZonesStatistics->fetch();
        $aRow1 = $rsZonesStatistics->toArray();
        
        $this->assertFieldEqual($aRow1, 'clicks', $doDataSummaryAdHourly3->clicks);
        $this->assertFieldEqual($aRow1, 'impressions', $doDataSummaryAdHourly3->impressions);
        
        // Get statistics for 2 zones for capmaign 2 
        $rsZonesStatistics = $this->_dalZoneStatistics->getZonesCtrStatistics(
            array( $doZone1->zoneid, $doZone2->zoneid ) , new Date('2008-04-27'),  new Date('2008-05-27'), $doCampaign2->campaignid );
        $rsZonesStatistics->find();
        $this->assertTrue($rsZonesStatistics->getRowCount() == 0,
            'Recordset should be empty');

        // Get statistics for 2 zones for capmaign 2 when impression threshold is set to 100
        $rsZonesStatistics = $this->_dalZoneStatistics->getZonesCtrStatistics(
            array( $doZone1->zoneid, $doZone2->zoneid ) , new Date('2008-04-27'),  new Date('2008-05-27'), $doCampaign2->campaignid, 100);
        $rsZonesStatistics->find();
        
        $this->assertTrue($rsZonesStatistics->getRowCount() == 1,
            '1 record should be returned');
        
        $rsZonesStatistics->fetch();
        $aRow1 = $rsZonesStatistics->toArray();
        
        $this->assertFieldEqual($aRow1, 'clicks', $doDataSummaryAdHourly2->clicks);
        $this->assertFieldEqual($aRow1, 'impressions', $doDataSummaryAdHourly2->impressions);
        
        // Get statistics for zone 2, but start date didn't catch any stats for this zone 
        $rsZonesStatistics = $this->_dalZoneStatistics->getZonesCtrStatistics(
            array( $doZone2->zoneid ) , new Date('2008-05-16'),  new Date('2008-06-20'));
        $rsZonesStatistics->find();
        $this->assertTrue($rsZonesStatistics->getRowCount() == 0,
            'Recordset should be empty');
        
        // Try to get statistics for zones when time span is less than 30 days 
        $rsZonesStatistics = $this->_dalZoneStatistics->getZonesCtrStatistics(
            array( $doZone1->zoneid, $doZone2->zoneid ) , new Date('2008-05-01'),  new Date('2008-05-30'));
        $rsZonesStatistics->find();
        $this->assertTrue($rsZonesStatistics->getRowCount() == 0,
            'Recordset should be empty');

    }
    
    /**
     * Method to generate sample data to statistics
     * It by default generate 2 zones, 2 campaigns (with revene type MAX_FINANCE_CPA and MAX_FINANCE_CPC)
     * and 3 statistics object
     * 
     * To change default values pass object with this values to this function.
     *
     * @param DataObjects_Campaigns $doCampaign1 campaign object
     * @param DataObjects_Campaigns $doCampaign2 campaign object
     * @param DataObjects_Zones &$doZone1 zone object
     * @param DataObjects_Zones &$doZone2 zone object
     * @param DataObjects_Data_summary_ad_hourly &$doDataSummaryAdHourly1 statistics object
     * @param DataObjects_Data_summary_ad_hourly &$doDataSummaryAdHourly2 statistics object
     * @param DataObjects_Data_summary_ad_hourly &$doDataSummaryAdHourly3 statistics object
     */
    function _generateDataForPerformanceStatisticsTests(
                     &$doCampaign1, &$doCampaign2,
                     &$doZone1, &$doZone2,
                     &$doDataSummaryAdHourly1, &$doDataSummaryAdHourly2, &$doDataSummaryAdHourly3) 
    {
        $doAgency                  = OA_Dal::factoryDO('agency');
        $doAdvertiser              = OA_Dal::factoryDO('clients');
        if (!isset($doCampaign1)) {
            $doCampaign1               = OA_Dal::factoryDO('campaigns');
            $doCampaign1->revenue_type = MAX_FINANCE_CPA;
        }
        $doBanner1                 = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign1, $doBanner1);       
        
        $doBanner2 = OA_Dal::factoryDO('banners');
        $this->generateBannerForCampaign($doCampaign1, $doBanner2);

        if (!isset($doCampaign2)) {
            $doCampaign2               = OA_Dal::factoryDO('campaigns');
            $doCampaign2->campaignname = 'campaign name';
            $doCampaign2->revenue_type = MAX_FINANCE_CPC;
        }
        $doBanner3 = OA_Dal::factoryDO('banners');
        $this->generateBannerAndCampaignForAdvertiser($doAdvertiser, $doCampaign2, $doBanner3);
        
        $doAgency    = OA_Dal::factoryDO('agency');
        $doPublisher = OA_Dal::factoryDO('affiliates');
        if (!isset($doZone1)) {
            $doZone1      = OA_Dal::factoryDO('zones');
        }
        $this->generateZoneWithParents($doAgency, $doPublisher, $doZone1);
        
        if (!isset($doZone2)) {
            $doZone2     = OA_Dal::factoryDO('zones');
        }
        $this->generateZoneForPublisher($doPublisher, $doZone2);

        if (!isset($doDataSummaryAdHourly1)) {
            $doDataSummaryAdHourly1                = OA_Dal::factoryDO('data_summary_ad_hourly');
            $doDataSummaryAdHourly1->impressions   = 10000;
            $doDataSummaryAdHourly1->requests      = 20000;
            $doDataSummaryAdHourly1->total_revenue = 100;
            $doDataSummaryAdHourly1->clicks        = 2000;
            $doDataSummaryAdHourly1->conversions   = 50;
            $doDataSummaryAdHourly1->date_time     = '2008-05-27';
        }
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly1, $doBanner1, $doZone1);

        if (!isset($doDataSummaryAdHourly2)) {
            $doDataSummaryAdHourly2                = OA_Dal::factoryDO('data_summary_ad_hourly');
            $doDataSummaryAdHourly2->impressions   = 10000;
            $doDataSummaryAdHourly2->requests      = 15000;
            $doDataSummaryAdHourly2->total_revenue = 50;
            $doDataSummaryAdHourly2->clicks        = 5000;
            $doDataSummaryAdHourly2->conversions   = 0;
            $doDataSummaryAdHourly2->date_time     = '2008-05-20';
        }
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly2, $doBanner3, $doZone1);

        if (!isset($doDataSummaryAdHourly3)) {
            $doDataSummaryAdHourly3                = OA_Dal::factoryDO('data_summary_ad_hourly');
            $doDataSummaryAdHourly3->impressions   = 100000;
            $doDataSummaryAdHourly3->requests      = 102300;
            $doDataSummaryAdHourly3->total_revenue = 40;
            $doDataSummaryAdHourly3->clicks        = 5000;
            $doDataSummaryAdHourly3->conversions   = 20;
            $doDataSummaryAdHourly3->date_time     = '2008-05-15';
        }
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly3, $doBanner2, $doZone2);
    }
    /**
     * Test settings default impressions Threshold
     *
     */
    function test_setImpressionsThreshold()
    {
        $result = $this->_dalZoneStatistics->_setImpressionsThreshold();
        $this->assertEqual($result, $GLOBALS['_MAX']['CONF']['performanceStatistics']['defaultImpressionsThreshold']);
        $result = $this->_dalZoneStatistics->_setImpressionsThreshold("not a number");
        $this->assertEqual($result, $GLOBALS['_MAX']['CONF']['performanceStatistics']['defaultImpressionsThreshold']);
        $result = $this->_dalZoneStatistics->_setImpressionsThreshold(1212);
        $this->assertEqual($result, 1212);
    }
    
    /**
     * Test checking date span
     *
     */
    function test_checkDaysIntervalThreshold()
    {
        // Test 30 full days 
        $this->assertTrue($this->_dalZoneStatistics->_checkDaysIntervalThreshold( new Date('2008-05-01'),  new Date('2008-05-31') ));
        // Test almost 30 days
        $this->assertFalse($this->_dalZoneStatistics->_checkDaysIntervalThreshold( new Date('2008-05-01 00:00:01'),  new Date('2008-05-31') ));
        // Test 29 and 1/2 days and 29 days interval
        $this->assertTrue($this->_dalZoneStatistics->_checkDaysIntervalThreshold( new Date('2008-05-01 12:00:00'),  new Date('2008-05-31'), 29));
    }
    
    /**
     * Test generating empty RecordSet 
     *
     */
    function test_emptyRecordSet() 
    {
        $rsEmpty = $this->_dalZoneStatistics->_emptyRecordSet();
        $this->assertIsA($rsEmpty, "MDB2RecordSet");
        $rsEmpty->find();
        $this->assertTrue($rsEmpty->getRowCount() == 0);
    }
    
}

?>
