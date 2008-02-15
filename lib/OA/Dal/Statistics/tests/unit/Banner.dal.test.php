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

require_once MAX_PATH . '/lib/OA/Dal/Statistics/Banner.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/tests/util/DalStatisticsUnitTestCase.php';

/**
 * A class for testing DAL Statistic Banner methods
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */


class OA_Dal_Statistics_BannerTest extends DalStatisticsUnitTestCase
{
    /**
     * Object for generate Banner Statistics.
     *
     * @var OA_Dal_Statistics_Agency $_dalAdvertiseryStatistics
     */
    var $_dalBannerStatistics;

    /**
     * The constructor method.
     */
    function OA_Dal_Statistics_bannerTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->_dalBannerStatistics = new OA_Dal_Statistics_Banner();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * Test banner daily statistics.
     *
     */
    function testGetBannerDailyStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign   = OA_Dal::factoryDO('campaigns');
        $doBanner     = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->requests      = 7;
        $doDataSummaryAdHourly->impressions   = 8;
        $doDataSummaryAdHourly->clicks        = 9;
        $doDataSummaryAdHourly->total_revenue = 10.0000;
        $doDataSummaryAdHourly->date_time     = '2007-08-20';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner);

        // 1. Get data existing range
        $rsDailyStatistics = $this->_dalBannerStatistics->getBannerDailyStatistics(
            $doBanner->bannerid, new Date('2001-12-01'),  new Date('2007-09-19'));

        $rsDailyStatistics->find();
        $this->assertTrue($rsDailyStatistics->getRowCount() == 1,
            'Some records should be returned');

        $rsDailyStatistics->fetch();

        $aRow = $rsDailyStatistics->toArray();

        // 2. Check return fields names
        $this->assertFieldExists($aRow, 'day');
        $this->assertFieldExists($aRow, 'requests');
        $this->assertFieldExists($aRow, 'impressions');
        $this->assertFieldExists($aRow, 'clicks');
        $this->assertFieldExists($aRow, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow, 'requests', 7);
        $this->assertFieldEqual($aRow, 'impressions', 8);
        $this->assertFieldEqual($aRow, 'clicks', 9);
        $this->assertFieldEqual($aRow, 'revenue', 10.0000);

        // 4. Get data in not existing range
        $rsDailyStatistics = $this->_dalBannerStatistics->getBannerDailyStatistics(
            $doBanner->bannerid,  new Date('2001-12-01'),  new Date('2006-09-19'));

        $rsDailyStatistics->find();

        $this->assertTrue($rsDailyStatistics->getRowCount() == 0,
            'Recordset should be empty');
    }

    /**
     * Test banner publisher statistics.
     *
     */
    function testGetBannerPublisherStatistics() {
        $doAgency      = OA_Dal::factoryDO('agency');
        $doAdvertiser  = OA_Dal::factoryDO('clients');
        $doCampaign    = OA_Dal::factoryDO('campaigns');
        $doBanner     = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner);

        $doAgency           = OA_Dal::factoryDO('agency');
        $doPublisher1       = OA_Dal::factoryDO('affiliates');
        $doPublisher1->name = 'test publisher name';
        $doZone1            = OA_Dal::factoryDO('zones');
        $this->generateZoneWithParents($doAgency, $doPublisher1, $doZone1);

        $doZone2 = OA_Dal::factoryDO('zones');
        $this->generateZoneForPublisher($doPublisher1, $doZone2);

        $doAgency      = OA_Dal::factoryDO('agency');
        $doPublisher2  = OA_Dal::factoryDO('affiliates');
        $doZone3       = OA_Dal::factoryDO('zones');
        $this->generateZoneWithParents($doAgency, $doPublisher2, $doZone3);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 1;
        $doDataSummaryAdHourly->requests      = 2;
        $doDataSummaryAdHourly->total_revenue = 3;
        $doDataSummaryAdHourly->clicks        = 4;
        $doDataSummaryAdHourly->date_time     = '1984-03-08';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner, $doZone1);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 11;
        $doDataSummaryAdHourly->requests      = 12;
        $doDataSummaryAdHourly->total_revenue = 13;
        $doDataSummaryAdHourly->clicks        = 14;
        $doDataSummaryAdHourly->date_time     = '1984-04-08';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner, $doZone2);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 10;
        $doDataSummaryAdHourly->requests      = 20;
        $doDataSummaryAdHourly->total_revenue = 30;
        $doDataSummaryAdHourly->clicks        = 40;
        $doDataSummaryAdHourly->date_time     = '2007-09-13';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner, $doZone3);

        // 1. Get data existing range
        $rsBannerStatistics = $this->_dalBannerStatistics->getBannerPublisherStatistics(
            $doBanner->bannerid, new Date('1984-01-01'),  new Date('2007-09-13'));

        $rsBannerStatistics->find();
        $this->assertTrue($rsBannerStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsBannerStatistics->fetch();
        $aRow1 = $rsBannerStatistics->toArray();

        $rsBannerStatistics->fetch();
        $aRow2 = $rsBannerStatistics->toArray();

        $this->ensureRowSequence($aRow1, $aRow2, 'publisherid', $doPublisher1->affiliateid);

        // 2. Check return fields names
        $this->assertFieldExists($aRow1, 'publisherid');
        $this->assertFieldExists($aRow1, 'publishername');
        $this->assertFieldExists($aRow1, 'requests');
        $this->assertFieldExists($aRow1, 'impressions');
        $this->assertFieldExists($aRow1, 'clicks');
        $this->assertFieldExists($aRow1, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow1, 'publishername', $doPublisher1->name);
        $this->assertFieldEqual($aRow1, 'impressions', 12);
        $this->assertFieldEqual($aRow1, 'requests', 14);
        $this->assertFieldEqual($aRow1, 'revenue', 16);
        $this->assertFieldEqual($aRow1, 'clicks', 18);
        $this->assertFieldEqual($aRow2, 'impressions', 10);
        $this->assertFieldEqual($aRow2, 'requests', 20);
        $this->assertFieldEqual($aRow2, 'revenue', 30);
        $this->assertFieldEqual($aRow2, 'clicks', 40);

        // 4. Get data in not existing range
        $rsBannerStatistics = $this->_dalBannerStatistics->getBannerPublisherStatistics(
            $doBanner->bannerid,  new Date('2007-09-21'),  new Date('2007-09-21'));
        $rsBannerStatistics->find();
        $this->assertTrue($rsBannerStatistics->getRowCount() == 0,
            'Recordset should be empty');

        // 5. Get 1 row
        $rsBannerStatistics = $this->_dalBannerStatistics->getBannerPublisherStatistics(
            $doBanner->bannerid, new Date('1984-01-01'),  new Date('1984-03-09'));
        $rsBannerStatistics->find();
        $this->assertTrue($rsBannerStatistics->getRowCount() == 1,
            'Some records should be returned');

    }


    /**
     * Test banner zone statistics.
     *
     */
    function testGetBannerZoneStatistics() {
        $doAgency      = OA_Dal::factoryDO('agency');
        $doAdvertiser  = OA_Dal::factoryDO('clients');
        $doCampaign    = OA_Dal::factoryDO('campaigns');
        $doBanner     = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner);

        $doAgency           = OA_Dal::factoryDO('agency');
        $doPublisher       = OA_Dal::factoryDO('affiliates');
        $doPublisher->name = 'test publisher name';
        $doZone1            = OA_Dal::factoryDO('zones');
        $doZone1->zonename  = 'test zone name';
        $this->generateZoneWithParents($doAgency, $doPublisher, $doZone1);

        $doZone2 = OA_Dal::factoryDO('zones');
        $this->generateZoneForPublisher($doPublisher, $doZone2);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 1;
        $doDataSummaryAdHourly->requests      = 2;
        $doDataSummaryAdHourly->total_revenue = 3;
        $doDataSummaryAdHourly->clicks        = 4;
        $doDataSummaryAdHourly->date_time     = '1984-03-08';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner, $doZone1);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 11;
        $doDataSummaryAdHourly->requests      = 12;
        $doDataSummaryAdHourly->total_revenue = 13;
        $doDataSummaryAdHourly->clicks        = 14;
        $doDataSummaryAdHourly->date_time     = '1984-04-08';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner, $doZone1);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 10;
        $doDataSummaryAdHourly->requests      = 20;
        $doDataSummaryAdHourly->total_revenue = 30;
        $doDataSummaryAdHourly->clicks        = 40;
        $doDataSummaryAdHourly->date_time     = '2007-09-13';
        $this->generateDataSummaryAdHourlyForBannerAndZone($doDataSummaryAdHourly, $doBanner, $doZone2);

        // 1. Get data existing range
        $rsBannerStatistics = $this->_dalBannerStatistics->getBannerZoneStatistics(
            $doBanner->bannerid, new Date('1984-01-01'),  new Date('2007-09-13'));

        $rsBannerStatistics->find();
        $this->assertTrue($rsBannerStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsBannerStatistics->fetch();
        $aRow1 = $rsBannerStatistics->toArray();

        $rsBannerStatistics->fetch();
        $aRow2 = $rsBannerStatistics->toArray();

        $this->ensureRowSequence($aRow1, $aRow2, 'zoneid', $doZone1->zoneid);

        // 2. Check return fields names
        $this->assertFieldExists($aRow1, 'publisherid');
        $this->assertFieldExists($aRow1, 'publishername');
        $this->assertFieldExists($aRow1, 'zoneid');
        $this->assertFieldExists($aRow1, 'zonename');
        $this->assertFieldExists($aRow1, 'requests');
        $this->assertFieldExists($aRow1, 'impressions');
        $this->assertFieldExists($aRow1, 'clicks');
        $this->assertFieldExists($aRow1, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow1, 'publishername', $doPublisher->name);
        $this->assertFieldEqual($aRow1, 'zonename', $doZone1->zonename);
        $this->assertFieldEqual($aRow1, 'impressions', 12);
        $this->assertFieldEqual($aRow1, 'requests', 14);
        $this->assertFieldEqual($aRow1, 'revenue', 16);
        $this->assertFieldEqual($aRow1, 'clicks', 18);
        $this->assertFieldEqual($aRow2, 'impressions', 10);
        $this->assertFieldEqual($aRow2, 'requests', 20);
        $this->assertFieldEqual($aRow2, 'revenue', 30);
        $this->assertFieldEqual($aRow2, 'clicks', 40);

        // 4. Get data in not existing range
        $rsBannerStatistics = $this->_dalBannerStatistics->getBannerZoneStatistics(
            $doBanner->bannerid,  new Date('2007-09-21'),  new Date('2007-09-21'));
        $rsBannerStatistics->find();
        $this->assertTrue($rsBannerStatistics->getRowCount() == 0,
            'Recordset should be empty');

        // 5. Get 1 row
        $rsBannerStatistics = $this->_dalBannerStatistics->getBannerZoneStatistics(
            $doBanner->bannerid, new Date('1984-01-01'),  new Date('1984-03-09'));
        $rsBannerStatistics->find();
        $this->assertTrue($rsBannerStatistics->getRowCount() == 1,
            'Some records should be returned');
    }


}

?>