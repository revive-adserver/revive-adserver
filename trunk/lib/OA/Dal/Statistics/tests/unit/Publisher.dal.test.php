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

require_once MAX_PATH . '/lib/OA/Dal/Statistics/Publisher.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/tests/util/DalStatisticsUnitTestCase.php';

/**
 * A class for testing DAL Statistic Publisher methods
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */


class OA_Dal_Statistics_PublisherTest extends DalStatisticsUnitTestCase
{
    /**
     * Object for generate Publisher Statistics.
     *
     * @var OA_Dal_Statistics_Publisher $_dalPublisherStatistics
     */
    var $_dalPublisherStatistics;

    /**
     * The constructor method.
     */
    function OA_Dal_Statistics_PublisherTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->_dalPublisherStatistics = new OA_Dal_Statistics_Publisher();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * Test publisher daily statistics.
     *
     */
    function testGetPublisherDailyStatistics()
    {
        $doAgency    = OA_Dal::factoryDO('agency');
        $doPublisher = OA_Dal::factoryDO('affiliates');
        $doZone      = OA_Dal::factoryDO('zones');
        $this->generateZoneWithParents($doAgency, $doPublisher, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 1;
        $doDataSummaryAdHourly->requests      = 2;
        $doDataSummaryAdHourly->total_revenue = 3;
        $doDataSummaryAdHourly->clicks        = 4;
        $doDataSummaryAdHourly->date_time     = '2007-08-20';
        $this->generateDataSummaryAdHourlyForZone($doDataSummaryAdHourly, $doZone);

        // 1. Get data existing range
        $rsPublisherStatistics = $this->_dalPublisherStatistics->getPublisherDailyStatistics(
            $doPublisher->affiliateid, new Date('2007-08-20'),  new Date('2007-08-20'));

        $rsPublisherStatistics->find();
        $this->assertTrue($rsPublisherStatistics->getRowCount() == 1,
            'Some records should be returned');

        $rsPublisherStatistics->fetch();
        $aRow = $rsPublisherStatistics->toArray();

        // 2. Check return fields names
        $this->assertFieldExists($aRow, 'day');
        $this->assertFieldExists($aRow, 'requests');
        $this->assertFieldExists($aRow, 'impressions');
        $this->assertFieldExists($aRow, 'clicks');
        $this->assertFieldExists($aRow, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow, 'impressions', 1);
        $this->assertFieldEqual($aRow, 'requests', 2);
        $this->assertFieldEqual($aRow, 'revenue', 3);
        $this->assertFieldEqual($aRow, 'clicks', 4);
        $this->assertFieldEqual($aRow, 'day', '2007-08-20');

        // 4. Get data in not existing range
        $rsPublisherStatistics = $this->_dalPublisherStatistics->getPublisherDailyStatistics(
            $doPublisher->affiliateid,  new Date('2001-12-01'),  new Date('2006-09-19'));
        $rsPublisherStatistics->find();
        $this->assertTrue($rsPublisherStatistics->getRowCount() == 0,
            'Recordset should be empty');

    }

    /**
     * Test publisher zone statistics.
     *
     */
    function testGetPublisheryZoneStatistics()
    {
        $doAgency          = OA_Dal::factoryDO('agency');
        $doPublisher       = OA_Dal::factoryDO('affiliates');
        $doPublisher->name = 'test publisher';
        $doZone1           = OA_Dal::factoryDO('zones');
        $doZone1->zonename = 'test zone';

        $this->generateZoneWithParents($doAgency, $doPublisher, $doZone1);

        $doZone2     = OA_Dal::factoryDO('zones');
        $this->generateZoneForPublisher($doPublisher, $doZone2);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 1;
        $doDataSummaryAdHourly->requests      = 3;
        $doDataSummaryAdHourly->total_revenue = 5;
        $doDataSummaryAdHourly->clicks        = 6;
        $doDataSummaryAdHourly->date_time     = '2007-03-01';
        $this->generateDataSummaryAdHourlyForZone($doDataSummaryAdHourly, $doZone1);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 1;
        $doDataSummaryAdHourly->requests      = 3;
        $doDataSummaryAdHourly->total_revenue = 5;
        $doDataSummaryAdHourly->clicks        = 6;
        $doDataSummaryAdHourly->date_time     = '2007-03-02';
        $this->generateDataSummaryAdHourlyForZone($doDataSummaryAdHourly, $doZone1);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 0;
        $doDataSummaryAdHourly->requests      = 0;
        $doDataSummaryAdHourly->total_revenue = 0;
        $doDataSummaryAdHourly->clicks        = 1;
        $doDataSummaryAdHourly->date_time     = '2007-02-02';
        $this->generateDataSummaryAdHourlyForZone($doDataSummaryAdHourly, $doZone2);

        // 1. Get data existing range
        $rsPublisherStatistics = $this->_dalPublisherStatistics->getPublisherZoneStatistics(
            $doPublisher->affiliateid, new Date('2007-01-01'), new Date('2007-03-02'));

        $rsPublisherStatistics->find();

        $this->assertTrue($rsPublisherStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsPublisherStatistics->fetch();
        $aRow1 = $rsPublisherStatistics->toArray();

        $rsPublisherStatistics->fetch();
        $aRow2 = $rsPublisherStatistics->toArray();

        $this->ensureRowSequence($aRow1, $aRow2, 'zoneid', $doZone1->zoneid);

        // 2. Check return fields names
        $this->assertFieldExists($aRow2, 'zoneid');
        $this->assertFieldExists($aRow2, 'zonename');
        $this->assertFieldExists($aRow2, 'requests');
        $this->assertFieldExists($aRow2, 'impressions');
        $this->assertFieldExists($aRow2, 'clicks');
        $this->assertFieldExists($aRow2, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow1, 'zoneid', $doZone1->zoneid);
        $this->assertFieldEqual($aRow1, 'zonename', $doZone1->zonename);

        $this->assertFieldEqual($aRow1, 'impressions', 2);
        $this->assertFieldEqual($aRow1, 'requests', 6);
        $this->assertFieldEqual($aRow1, 'revenue', 10);
        $this->assertFieldEqual($aRow1, 'clicks', 12);
        $this->assertFieldEqual($aRow2, 'impressions', 0);
        $this->assertFieldEqual($aRow2, 'requests', 0);
        $this->assertFieldEqual($aRow2, 'revenue', 0);
        $this->assertFieldEqual($aRow2, 'clicks', 1);

        // 4. Get data in not existing range
        $rsPublisherStatistics = $this->_dalPublisherStatistics->getPublisherZoneStatistics(
            $doPublisher->affiliateid, new Date('2007-05-01'), new Date('2007-05-02'));
        $rsPublisherStatistics->find();
        $this->assertTrue($rsPublisherStatistics->getRowCount() == 0,
            'Recordset should be empty');

    }


    /**
     * Test publisher advertiser statistics.
     *
     */
    function testGetPublisherAdvertiserStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign   = OA_Dal::factoryDO('campaigns');
        $doBanner1    = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner1);

        $doBanner2     = OA_Dal::factoryDO('banners');
        $this->generateBannerForCampaign($doCampaign, $doBanner2);

        $doAgency    = OA_Dal::factoryDO('agency');
        $doPublisher = OA_Dal::factoryDO('affiliates');
        $doZone      = OA_Dal::factoryDO('zones');

        $this->generateZoneWithParents($doAgency, $doPublisher, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 1;
        $doDataSummaryAdHourly->requests      = 2;
        $doDataSummaryAdHourly->total_revenue = 3;
        $doDataSummaryAdHourly->clicks        = 4;
        $doDataSummaryAdHourly->date_time     = '1984-03-08';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner1, $doZone);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 10;
        $doDataSummaryAdHourly->requests      = 20;
        $doDataSummaryAdHourly->total_revenue = 30;
        $doDataSummaryAdHourly->clicks        = 40;
        $doDataSummaryAdHourly->date_time     = '2007-09-13';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner2, $doZone);

        // 1. Get data existing range
        $rsPublisherStatistics = $this->_dalPublisherStatistics->getPublisherAdvertiserStatistics(
            $doPublisher->affiliateid, new Date('1984-01-01'),  new Date('2007-09-18'));

        $rsPublisherStatistics->find();
        $this->assertTrue($rsPublisherStatistics->getRowCount() == 1,
            'Some records should be returned');

        $rsPublisherStatistics->fetch();
        $aRow = $rsPublisherStatistics->toArray();

        // 2. Check return fields names
        $this->assertFieldExists($aRow, 'advertiserid');
        $this->assertFieldExists($aRow, 'advertisername');
        $this->assertFieldExists($aRow, 'requests');
        $this->assertFieldExists($aRow, 'impressions');
        $this->assertFieldExists($aRow, 'clicks');
        $this->assertFieldExists($aRow, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow, 'impressions', 11);
        $this->assertFieldEqual($aRow, 'requests', 22);
        $this->assertFieldEqual($aRow, 'revenue', 33);
        $this->assertFieldEqual($aRow, 'clicks', 44);

        // 4. Get data in not existing range
        $rsPublisherStatistics = $this->_dalPublisherStatistics->getPublisherAdvertiserStatistics(
            $doPublisher->affiliateid,  new Date('2007-09-21'),  new Date('2007-09-21'));
        $rsPublisherStatistics->find();
        $this->assertTrue($rsPublisherStatistics->getRowCount() == 0,
            'Recordset should be empty');

        // 5. Get data from only 1 advertiser
        $rsPublisherStatistics = $this->_dalPublisherStatistics->getPublisherAdvertiserStatistics(
            $doPublisher->affiliateid, new Date('1984-01-01'),  new Date('1984-03-09'));
        $rsPublisherStatistics->find();
        $this->assertTrue($rsPublisherStatistics->getRowCount() == 1,
            'Some records should be returned');

        $rsPublisherStatistics->fetch();
        $aRow = $rsPublisherStatistics->toArray();
        $this->assertFieldEqual($aRow, 'impressions', 1);
    }

    /**
     * Test publisher campaign statistics.
     *
     */
    function testGetPublisherCampaignStatistics()
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
        $rsPublisherStatistics = $this->_dalPublisherStatistics->getPublisherCampaignStatistics(
            $doPublisher->affiliateid, new Date('2007-06-06'),  new Date('2007-09-18'));

        $rsPublisherStatistics->find();
        $this->assertTrue($rsPublisherStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsPublisherStatistics->fetch();
        $aRow1 = $rsPublisherStatistics->toArray();

        $rsPublisherStatistics->fetch();
        $aRow2 = $rsPublisherStatistics->toArray();

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
        $rsPublisherStatistics = $this->_dalPublisherStatistics->getPublisherCampaignStatistics(
            $doPublisher->affiliateid,  new Date('2007-09-21'),  new Date('2007-09-21'));
        $rsPublisherStatistics->find();
        $this->assertTrue($rsPublisherStatistics->getRowCount() == 0,
            'Recordset should be empty');

        // 5. Get data from only 1 row
        $rsPublisherStatistics = $this->_dalPublisherStatistics->getPublisherCampaignStatistics(
            $doPublisher->affiliateid, new Date('2007-06-06'),  new Date('2007-09-08'));
        $rsPublisherStatistics->find();
        $this->assertTrue($rsPublisherStatistics->getRowCount() == 1,
            'Some records should be returned');

    }


    /**
     * Test publisher banner statistics.
     *
     */
    function testGetPublisherBannerStatistics()
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
        $rsPublisherStatistics = $this->_dalPublisherStatistics->getPublisherBannerStatistics(
            $doPublisher->affiliateid, new Date('2007-01-06'),  new Date('2007-11-18'));

        $rsPublisherStatistics->find();
        $this->assertTrue($rsPublisherStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsPublisherStatistics->fetch();
        $aRow1 = $rsPublisherStatistics->toArray();

        $rsPublisherStatistics->fetch();
        $aRow2 = $rsPublisherStatistics->toArray();

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
        $rsPublisherStatistics = $this->_dalPublisherStatistics->getPublisherBannerStatistics(
            $doPublisher->affiliateid,  new Date('2007-12-21'),  new Date('2008-09-21'));
        $rsPublisherStatistics->find();
        $this->assertTrue($rsPublisherStatistics->getRowCount() == 0,
            'Recordset should be empty');

    }

}

?>