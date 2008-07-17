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

require_once MAX_PATH . '/lib/OA/Dal/Statistics/Advertiser.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/tests/util/DalStatisticsUnitTestCase.php';

/**
 * A class for testing DAL Statistic Advertiser methods
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */


class OA_Dal_Statistics_AdvertiserTest extends DalStatisticsUnitTestCase
{
    /**
     * Object for generate Advertiser Statistics.
     *
     * @var OA_Dal_Statistics_Advertiser $_dalAdvertiseryStatistics
     */
    var $_dalAdvertiserStatistics;

    /**
     * The constructor method.
     */
    function OA_Dal_Statistics_AdvertiserTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->_dalAdvertiserStatistics = new OA_Dal_Statistics_Advertiser();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * Test advertiser daily statistics.
     *
     */
    function testGetAdvertiserDailyStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign   = OA_Dal::factoryDO('campaigns');
        $doBanner     = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner);

        $doDataSummaryAdHourly            = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->requests  = 20;
        $doDataSummaryAdHourly->date_time = '2007-08-20';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner);

        // 1. Get data existing range
        $rsAdvertiserDailyStatistics = $this->_dalAdvertiserStatistics->getAdvertiserDailyStatistics(
            $doAdvertiser->clientid, new Date('2001-12-01'),  new Date('2007-09-19'));

        $rsAdvertiserDailyStatistics->find();
        $this->assertTrue($rsAdvertiserDailyStatistics->getRowCount() == 1,
            'Some records should be returned');

        $rsAdvertiserDailyStatistics->fetch();

        $aRow = $rsAdvertiserDailyStatistics->toArray();

        // 2. Check return fields names
        $this->assertFieldExists($aRow, 'day');
        $this->assertFieldExists($aRow, 'requests');
        $this->assertFieldExists($aRow, 'impressions');
        $this->assertFieldExists($aRow, 'clicks');
        $this->assertFieldExists($aRow, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow, 'requests', 20);

        // 4. Get data in not existing range
        $rsAdvertiserDailyStatistics = $this->_dalAdvertiserStatistics->getAdvertiserDailyStatistics(
            $doAdvertiser->clientid,  new Date('2001-12-01'),  new Date('2006-09-19'));

        $rsAdvertiserDailyStatistics->find();

        $this->assertTrue($rsAdvertiserDailyStatistics->getRowCount() == 0,
            'Recordset should be empty');

    }

    /**
     * Test advertiser campaign statistics.
     *
     */
    function testGetAdvertiserCampaignStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign1   = OA_Dal::factoryDO('campaigns');
        $doBanner1     = OA_Dal::factoryDO('banners');
        $doCampaign1->campaignname = 'Test name 1';
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign1, $doBanner1);

        $doCampaign2   = OA_Dal::factoryDO('campaigns');
        $doBanner2     = OA_Dal::factoryDO('banners');
        $doCampaign2->campaignname = 'Test name 2';
        $this->generateBannerAndCampaignForAdvertiser($doAdvertiser, $doCampaign2, $doBanner2);

        $doBanner3     = OA_Dal::factoryDO('banners');
        $this->generateBannerForCampaign($doCampaign2,$doBanner3);

        $doDataSummaryAdHourly                 = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->requests       = 2;
        $doDataSummaryAdHourly->total_revenue  = 5;
        $doDataSummaryAdHourly->clicks         = 0;
        $doDataSummaryAdHourly->date_time      = '2007-09-01';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner1);

        $doDataSummaryAdHourly->requests       = 4;
        $doDataSummaryAdHourly->total_revenue  = 6;
        $doDataSummaryAdHourly->clicks         = 7;
        $doDataSummaryAdHourly->date_time      = '2007-08-29';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner2);

        $doDataSummaryAdHourly->requests       = 4;
        $doDataSummaryAdHourly->total_revenue  = 8;
        $doDataSummaryAdHourly->clicks         = 6;
        $doDataSummaryAdHourly;
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner3);

        // 1. Get data existing range
        $rsAdvertiserDailyStatistics = $this->_dalAdvertiserStatistics->getAdvertiserCampaignStatistics(
            $doAdvertiser->clientid, new Date('2007-07-07'),  new Date('2007-09-12'));

        $rsAdvertiserDailyStatistics->find();

        $this->assertTrue($rsAdvertiserDailyStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsAdvertiserDailyStatistics->fetch();
        $aRow1 = $rsAdvertiserDailyStatistics->toArray();

        $rsAdvertiserDailyStatistics->fetch();
        $aRow2 = $rsAdvertiserDailyStatistics->toArray();

        $this->ensureRowSequence($aRow1, $aRow2, 'campaignid', $doCampaign1->campaignid);

        // 2. Check return fields names
        $this->assertFieldExists($aRow1, 'campaignid');
        $this->assertFieldExists($aRow1, 'campaignname');
        $this->assertFieldExists($aRow1, 'requests');
        $this->assertFieldExists($aRow1, 'impressions');
        $this->assertFieldExists($aRow1, 'clicks');
        $this->assertFieldExists($aRow1, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow1, 'requests', 2);
        $this->assertFieldEqual($aRow1, 'revenue', 5.0000);
        $this->assertFieldEqual($aRow1, 'campaignname', $doCampaign1->campaignname);
        $this->assertFieldEqual($aRow2, 'requests', 8);
        $this->assertFieldEqual($aRow2, 'revenue', 14.0000);
        $this->assertFieldEqual($aRow2, 'clicks', 13);
        $this->assertFieldEqual($aRow2, 'campaignname', $doCampaign2->campaignname);

        // 4. Get data in not existing range
        $rsAdvertiserCampaignStatistics = $this->_dalAdvertiserStatistics->getAdvertiserCampaignStatistics(
            $doAdvertiser->clientid,  new Date('2001-12-01'),  new Date('2006-09-19'));

        $rsAdvertiserCampaignStatistics->find();

        $this->assertTrue($rsAdvertiserCampaignStatistics->getRowCount() == 0,
            'Recordset should be empty');
    }

    /**
     * Test advertiser banner statistics.
     *
     */
    function testGetAdvertiserBannerStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign   = OA_Dal::factoryDO('campaigns');
        $doBanner1    = OA_Dal::factoryDO('banners');
        $doBanner2    = OA_Dal::factoryDO('banners');

        $doAdvertiser->clientname = "Advertiser name";
        $doCampaign->campaignname = "Campaign Name";
        $doBanner1->description = "Banner Name 1";
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner1);

        $doBanner2->description = "Banner name 2";
        $this->generateBannerForCampaign($doCampaign, $doBanner2);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 1;
        $doDataSummaryAdHourly->requests      = 0;
        $doDataSummaryAdHourly->total_revenue = 0;
        $doDataSummaryAdHourly->clicks        = 0;
        $doDataSummaryAdHourly->date_time     = '2007-01-01';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner1);

        $doDataSummaryAdHourly->impressions   = 0;
        $doDataSummaryAdHourly->requests      = 4;
        $doDataSummaryAdHourly->total_revenue = 6;
        $doDataSummaryAdHourly->clicks        = 7;
        $doDataSummaryAdHourly->date_time     = '2007-02-01';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner2);

        $doDataSummaryAdHourly->impressions   = 0;
        $doDataSummaryAdHourly->requests      = 16;
        $doDataSummaryAdHourly->total_revenue = 4;
        $doDataSummaryAdHourly->clicks        = 33;
        $doDataSummaryAdHourly->date_time     = '2007-04-01';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner2);

        // 1. Get data existing range
        $rsAdvertiserDailyStatistics = $this->_dalAdvertiserStatistics->getAdvertiserBannerStatistics(
            $doAdvertiser->clientid, new Date('2006-07-07'),  new Date('2007-09-12'));

        $rsAdvertiserDailyStatistics->find();
        $this->assertTrue($rsAdvertiserDailyStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsAdvertiserDailyStatistics->fetch();
        $aRow1 = $rsAdvertiserDailyStatistics->toArray();

        $rsAdvertiserDailyStatistics->fetch();
        $aRow2 = $rsAdvertiserDailyStatistics->toArray();

        $this->ensureRowSequence($aRow1, $aRow2, 'bannerid', $doBanner1->bannerid);

        // 2. Check return fields names
        $this->assertFieldExists($aRow1, 'campaignid');
        $this->assertFieldExists($aRow1, 'campaignname');
        $this->assertFieldExists($aRow1, 'bannerid');
        $this->assertFieldExists($aRow1, 'bannername');
        $this->assertFieldExists($aRow1, 'requests');
        $this->assertFieldExists($aRow1, 'impressions');
        $this->assertFieldExists($aRow1, 'clicks');
        $this->assertFieldExists($aRow1, 'revenue');

        $this->assertFieldExists($aRow2, 'campaignid');
        $this->assertFieldExists($aRow2, 'campaignname');
        $this->assertFieldExists($aRow2, 'bannerid');
        $this->assertFieldExists($aRow2, 'bannername');
        $this->assertFieldExists($aRow2, 'requests');
        $this->assertFieldExists($aRow2, 'impressions');
        $this->assertFieldExists($aRow2, 'clicks');
        $this->assertFieldExists($aRow2, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow1, 'impressions', 1);
        $this->assertFieldEqual($aRow1, 'requests', 0);
        $this->assertFieldEqual($aRow1, 'revenue', 0.0000);
        $this->assertFieldEqual($aRow1, 'clicks', 0);
        $this->assertFieldEqual($aRow1, 'campaignname', $doCampaign->campaignname);
        $this->assertFieldEqual($aRow1, 'bannername', $doBanner1->description);

        $this->assertFieldEqual($aRow2, 'impressions', 0);
        $this->assertFieldEqual($aRow2, 'requests', 20);
        $this->assertFieldEqual($aRow2, 'revenue', 10.0000);
        $this->assertFieldEqual($aRow2, 'clicks', 40);
        $this->assertFieldEqual($aRow2, 'campaignname', $doCampaign->campaignname);
        $this->assertFieldEqual($aRow2, 'bannername', $doBanner2->description);

        // 4. Get data in not existing range
        $rsAdvertiserBannerStatistics = $this->_dalAdvertiserStatistics->getAdvertiserBannerStatistics(
            $doAdvertiser->clientid,  new Date('2001-12-01'),  new Date('2006-09-19'));

        $rsAdvertiserBannerStatistics->find();

        $this->assertTrue($rsAdvertiserBannerStatistics->getRowCount() == 0,
            'Recordset should be empty');
    }

    /**
     * Test advertiser publisher statistics.
     *
     */
    function testGetAdvertiserPublisherStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign   = OA_Dal::factoryDO('campaigns');
        $doBanner1     = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner1);

        $doBanner2     = OA_Dal::factoryDO('banners');
        $this->generateBannerForCampaign($doCampaign, $doBanner2);

        $doAgency    = OA_Dal::factoryDO('agency');
        $doPublisher = OA_Dal::factoryDO('affiliates');
        $doZone      = OA_Dal::factoryDO('zones');

        $doPublisher->name = "Test publisher name 1";

        $this->generateZoneWithParents($doAgency, $doPublisher, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 11;
        $doDataSummaryAdHourly->requests      = 22;
        $doDataSummaryAdHourly->total_revenue = 33;
        $doDataSummaryAdHourly->clicks        = 44;
        $doDataSummaryAdHourly->date_time     = '1986-04-08';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner1, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 10;
        $doDataSummaryAdHourly->requests      = 20;
        $doDataSummaryAdHourly->total_revenue = 30;
        $doDataSummaryAdHourly->clicks        = 40;
        $doDataSummaryAdHourly->date_time     = '2007-09-13';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner2, $doZone);

        // 1. Get data existing range
        $rsAdvertiserStatistics = $this->_dalAdvertiserStatistics->getAdvertiserPublisherStatistics(
            $doAdvertiser->clientid, new Date('1984-01-01'),  new Date('2007-09-18'));

        $rsAdvertiserStatistics->find();
        $this->assertTrue($rsAdvertiserStatistics->getRowCount() == 1,
            'Some records should be returned');

        $rsAdvertiserStatistics->fetch();
        $aRow = $rsAdvertiserStatistics->toArray();

        // 2. Check return fields names
        $this->assertFieldExists($aRow, 'publisherid');
        $this->assertFieldExists($aRow, 'publishername');
        $this->assertFieldExists($aRow, 'requests');
        $this->assertFieldExists($aRow, 'impressions');
        $this->assertFieldExists($aRow, 'clicks');
        $this->assertFieldExists($aRow, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow, 'impressions', 21);
        $this->assertFieldEqual($aRow, 'requests', 42);
        $this->assertFieldEqual($aRow, 'revenue', 63);
        $this->assertFieldEqual($aRow, 'clicks', 84);
        $this->assertFieldEqual($aRow, 'publishername', $doPublisher->name);

        // 4. Get data in not existing range
        $rsAdvertiserStatistics = $this->_dalAdvertiserStatistics->getAdvertiserPublisherStatistics(
            $doAdvertiser->clientid,  new Date('2007-09-21'),  new Date('2007-09-21'));
        $rsAdvertiserStatistics->find();
        $this->assertTrue($rsAdvertiserStatistics->getRowCount() == 0,
            'Recordset should be empty');

        // 5. Get data from only 1 advertiser
        $rsAdvertiserStatistics = $this->_dalAdvertiserStatistics->getAdvertiserPublisherStatistics(
            $doAdvertiser->clientid, new Date('1986-01-01'),  new Date('1986-04-09'));
        $rsAdvertiserStatistics->find();
        $this->assertTrue($rsAdvertiserStatistics->getRowCount() == 1,
            'Some records should be returned');

        $rsAdvertiserStatistics->fetch();
        $aRow = $rsAdvertiserStatistics->toArray();
        $this->assertFieldEqual($aRow, 'impressions', 11);

    }



    /**
     * Test advertiser zone statistics.
     *
     */
    function testGetAdvertiserZoneStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign   = OA_Dal::factoryDO('campaigns');
        $doBanner1     = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner1);

        $doBanner2     = OA_Dal::factoryDO('banners');
        $this->generateBannerForCampaign($doCampaign, $doBanner2);

        $doAgency    = OA_Dal::factoryDO('agency');
        $doPublisher = OA_Dal::factoryDO('affiliates');
        $doZone      = OA_Dal::factoryDO('zones');

        $doPublisher->name = "Test publisher name 1";
        $doZone->zonename  = "Test zone name 1";

        $this->generateZoneWithParents($doAgency, $doPublisher, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 11;
        $doDataSummaryAdHourly->requests      = 22;
        $doDataSummaryAdHourly->total_revenue = 33;
        $doDataSummaryAdHourly->clicks        = 44;
        $doDataSummaryAdHourly->date_time     = '1983-08-14';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner1, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 1;
        $doDataSummaryAdHourly->requests      = 2;
        $doDataSummaryAdHourly->total_revenue = 3;
        $doDataSummaryAdHourly->clicks        = 4;
        $doDataSummaryAdHourly->date_time     = '2007-09-13';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner2, $doZone);

        // 1. Get data existing range
        $rsAdvertiserStatistics = $this->_dalAdvertiserStatistics->getAdvertiserZoneStatistics(
            $doAdvertiser->clientid, new Date('1983-01-01'),  new Date('2007-09-18'));

        $rsAdvertiserStatistics->find();
        $this->assertTrue($rsAdvertiserStatistics->getRowCount() == 1,
            'Some records should be returned');

        $rsAdvertiserStatistics->fetch();
        $aRow = $rsAdvertiserStatistics->toArray();

        // 2. Check return fields names
        $this->assertFieldExists($aRow, 'publisherid');
        $this->assertFieldExists($aRow, 'publishername');
        $this->assertFieldExists($aRow, 'zoneid');
        $this->assertFieldExists($aRow, 'zonename');
        $this->assertFieldExists($aRow, 'requests');
        $this->assertFieldExists($aRow, 'impressions');
        $this->assertFieldExists($aRow, 'clicks');
        $this->assertFieldExists($aRow, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow, 'impressions', 12);
        $this->assertFieldEqual($aRow, 'requests', 24);
        $this->assertFieldEqual($aRow, 'revenue', 36);
        $this->assertFieldEqual($aRow, 'clicks', 48);
        $this->assertFieldEqual($aRow, 'publishername', $doPublisher->name);
        $this->assertFieldEqual($aRow, 'zonename', $doZone->zonename);

        // 4. Get data in not existing range
        $rsAdvertiserStatistics = $this->_dalAdvertiserStatistics->getAdvertiserZoneStatistics(
            $doAdvertiser->clientid,  new Date('2007-09-21'),  new Date('2007-09-21'));
        $rsAdvertiserStatistics->find();
        $this->assertTrue($rsAdvertiserStatistics->getRowCount() == 0,
            'Recordset should be empty');

        // 5. Get data from only 1 advertiser
        $rsAdvertiserStatistics = $this->_dalAdvertiserStatistics->getAdvertiserZoneStatistics(
            $doAdvertiser->clientid, new Date('1983-01-01'),  new Date('1983-09-01'));
        $rsAdvertiserStatistics->find();
        $this->assertTrue($rsAdvertiserStatistics->getRowCount() == 1,
            'Some records should be returned');

        $rsAdvertiserStatistics->fetch();
        $aRow = $rsAdvertiserStatistics->toArray();
        $this->assertFieldEqual($aRow, 'impressions', 11);
    }

}

?>