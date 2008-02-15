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

}

?>