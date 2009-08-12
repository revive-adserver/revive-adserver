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
$Id:$
*/

require_once MAX_PATH . '/lib/OA/Dal/Statistics/Agency.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/tests/util/DalStatisticsUnitTestCase.php';

/**
 * A class for testing DAL Statistic Agency methods
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */


class OA_Dal_Statistics_AgencyTest extends DalStatisticsUnitTestCase
{
    /**
     * Object for generate Agency Statistics.
     *
     * @var OA_Dal_Statistics_Agency $_dalAgencyStatistics
     */
    var $_dalAgencyStatistics;

    /**
     * The constructor method.
     */
    function OA_Dal_Statistics_AgencyTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->_dalAgencyStatistics = new OA_Dal_Statistics_Agency();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * Test agency daily statistics.
     *
     */
    function testGetAgencyDailyStatistics()
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
        $aData = $this->_dalAgencyStatistics->getAgencyDailyStatistics(
            $doAgency->agencyid, new Date('2001-12-01'),  new Date('2007-09-19'));

        $this->assertEqual(count($aData), 1, 'Some records should be returned');
        $aRow = current($aData);

        // 2. Check return fields names
        $this->assertFieldExists($aRow, 'day');
        $this->assertFieldExists($aRow, 'requests');
        $this->assertFieldExists($aRow, 'impressions');
        $this->assertFieldExists($aRow, 'clicks');
        $this->assertFieldExists($aRow, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow, 'requests', 20);

        // 4. Get data in not existing range
        $aData = $this->_dalAgencyStatistics->getAgencyDailyStatistics(
            $doAgency->agencyid,  new Date('2001-12-01'),  new Date('2006-09-19'));

        $this->assertEqual(count($aData), 0, 'Recordset should be empty');
    }

    /**
     * Test agency advertiser statistics.
     *
     */
    function testGetAgencyAdvertiserStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign   = OA_Dal::factoryDO('campaigns');
        $doBanner1    = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner1);

        $doBanner2     = OA_Dal::factoryDO('banners');
        $this->generateBannerForCampaign($doCampaign,$doBanner2);

        $doDataSummaryAdHourly                 = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->requests       = 20;
        $doDataSummaryAdHourly->total_revenue  = 4;
        $doDataSummaryAdHourly->date_time      = '2007-08-20';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner1);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->requests      = 1;
        $doDataSummaryAdHourly->total_revenue = 6;
        $doDataSummaryAdHourly->date_time      = '2007-08-08';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner2);

        // 1. Get data existing range
        $rsAgencyStatistics = $this->_dalAgencyStatistics->getAgencyAdvertiserStatistics(
            $doAgency->agencyid, new Date('2001-12-01'),  new Date('2007-09-19'));

        $rsAgencyStatistics->find();
        $this->assertTrue($rsAgencyStatistics->getRowCount() == 1,
            'Some records should be returned');

        $rsAgencyStatistics->fetch();

        $aRow = $rsAgencyStatistics->toArray();

        // 2. Check return fields names
        $this->assertFieldExists($aRow, 'advertiserid');
        $this->assertFieldExists($aRow, 'advertisername');
        $this->assertFieldExists($aRow, 'requests');
        $this->assertFieldExists($aRow, 'impressions');
        $this->assertFieldExists($aRow, 'clicks');
        $this->assertFieldExists($aRow, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow, 'requests', 21);
        $this->assertFieldEqual($aRow, 'revenue', 10);

        // 4. Get data in not existing range
        $rsAgencyStatistics = $this->_dalAgencyStatistics->getAgencyAdvertiserStatistics(
            $doAgency->agencyid,  new Date('2001-12-01'),  new Date('2006-09-19'));
        $rsAgencyStatistics->find();
        $this->assertTrue($rsAgencyStatistics->getRowCount() == 0,
            'Recordset should be empty');
    }

    /**
     * Test agency campaign statistics.
     *
     */
    function testGetAgencyCampaignStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign1  = OA_Dal::factoryDO('campaigns');
        $doBanner1    = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign1, $doBanner1);

        $doCampaign2 = OA_Dal::factoryDO('campaigns');
        $doBanner2   = OA_Dal::factoryDO('banners');
        $this->generateBannerAndCampaignForAdvertiser($doAdvertiser, $doCampaign2, $doBanner2);

        $doBanner3 = OA_Dal::factoryDO('banners');
        $this->generateBannerForCampaign($doCampaign2,$doBanner3);

        $doDataSummaryAdHourly                 = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->requests       = 2;
        $doDataSummaryAdHourly->total_revenue  = 5;
        $doDataSummaryAdHourly->date_time      = '2007-09-01';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner1);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->requests      = 4;
        $doDataSummaryAdHourly->total_revenue = 6;
        $doDataSummaryAdHourly->clicks        = 7;
        $doDataSummaryAdHourly->date_time     = '2007-08-29';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner2);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->requests      = 0;
        $doDataSummaryAdHourly->total_revenue = 8;
        $doDataSummaryAdHourly->clicks        = 6;
        $doDataSummaryAdHourly->date_time     = '2007-09-10';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner3);

        // 1. Get data existing range
        $rsAgencyStatistics = $this->_dalAgencyStatistics->getAgencyCampaignStatistics(
            $doAgency->agencyid, new Date('2007-07-07'),  new Date('2007-09-12'));

        $rsAgencyStatistics->find();
        $this->assertTrue($rsAgencyStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsAgencyStatistics->fetch();
        $aRow1 = $rsAgencyStatistics->toArray();

        $rsAgencyStatistics->fetch();
        $aRow2 = $rsAgencyStatistics->toArray();

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
        $this->assertFieldEqual($aRow1, 'requests', 2);
        $this->assertFieldEqual($aRow1, 'revenue', 5);
        $this->assertFieldEqual($aRow2, 'requests', 4);
        $this->assertFieldEqual($aRow2, 'revenue', 14);
        $this->assertFieldEqual($aRow2, 'clicks', 13);

        // 4. Get data in not existing range
        $rsAgencyStatistics = $this->_dalAgencyStatistics->getAgencyCampaignStatistics(
            $doAgency->agencyid,  new Date('2001-12-01'),  new Date('2006-09-19'));
        $rsAgencyStatistics->find();
        $this->assertTrue($rsAgencyStatistics->getRowCount() == 0,
            'Recordset should be empty');
    }

    /**
     * Test agency banner statistics.
     *
     */
    function testGetAgencyBannerStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doAdvertiser = OA_Dal::factoryDO('clients');
        $doCampaign   = OA_Dal::factoryDO('campaigns');
        $doBanner1    = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency, $doAdvertiser, $doCampaign, $doBanner1);

        $doBanner2     = OA_Dal::factoryDO('banners');
        $this->generateBannerForCampaign($doCampaign,$doBanner2);

        $doDataSummaryAdHourly              = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions = 1;
        $doDataSummaryAdHourly->date_time = '2007-01-01';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner1);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 0;
        $doDataSummaryAdHourly->requests      = 4;
        $doDataSummaryAdHourly->total_revenue = 6;
        $doDataSummaryAdHourly->clicks        = 7;
        $doDataSummaryAdHourly->date_time     = '2007-02-01';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner2);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 0;
        $doDataSummaryAdHourly->requests      = 4;
        $doDataSummaryAdHourly->total_revenue = 6;
        $doDataSummaryAdHourly->clicks        = 7;
        $doDataSummaryAdHourly->date_time     = '2007-04-01';
        $this->generateDataSummaryAdHourlyForBanner($doDataSummaryAdHourly, $doBanner2);

        // 1. Get data existing range
        $rsAgencyStatistics = $this->_dalAgencyStatistics->getAgencyBannerStatistics(
            $doAgency->agencyid, new Date('2006-07-07'),  new Date('2007-09-12'));

        $rsAgencyStatistics->find();
        $this->assertTrue($rsAgencyStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsAgencyStatistics->fetch();
        $aRow1 = $rsAgencyStatistics->toArray();

        $rsAgencyStatistics->fetch();
        $aRow2 = $rsAgencyStatistics->toArray();

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
        $this->assertFieldEqual($aRow1, 'impressions', 1);
        $this->assertFieldEqual($aRow2, 'impressions', 0);
        $this->assertFieldEqual($aRow2, 'requests', 8);
        $this->assertFieldEqual($aRow2, 'revenue', 12);
        $this->assertFieldEqual($aRow2, 'clicks', 14);

        // 4. Get data in not existing range
        $rsAgencyStatistics = $this->_dalAgencyStatistics->getAgencyBannerStatistics(
            $doAgency->agencyid,  new Date('2001-12-01'),  new Date('2006-09-19'));
        $rsAgencyStatistics->find();
        $this->assertTrue($rsAgencyStatistics->getRowCount() == 0,
            'Recordset should be empty');
    }

    /**
     * Test agency publisher statistics.
     *
     */
    function testGetAgencyPublisherStatistics()
    {
        $doAgency     = OA_Dal::factoryDO('agency');
        $doPublisher1 = OA_Dal::factoryDO('affiliates');
        $doZone1      = OA_Dal::factoryDO('zones');
        $this->generateZoneWithParents($doAgency, $doPublisher1, $doZone1);

        $doPublisher2 = OA_Dal::factoryDO('affiliates');
        $doZone2     = OA_Dal::factoryDO('zones');
        $this->generateZoneAndPublisherForAgency($doAgency, $doPublisher2, $doZone2);

        $doZone3      = OA_Dal::factoryDO('zones');
        $this->generateZoneForPublisher($doPublisher2, $doZone3);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 100;
        $doDataSummaryAdHourly->requests      = 0;
        $doDataSummaryAdHourly->total_revenue = 0;
        $doDataSummaryAdHourly->clicks        = 7;
        $doDataSummaryAdHourly->date_time     = '2006-02-02';
        $this->generateDataSummaryAdHourlyForZone($doDataSummaryAdHourly, $doZone1);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 12;
        $doDataSummaryAdHourly->requests      = 411;
        $doDataSummaryAdHourly->total_revenue = 116;
        $doDataSummaryAdHourly->clicks        = 723;
        $doDataSummaryAdHourly->date_time     = '2007-02-01';
        $this->generateDataSummaryAdHourlyForZone($doDataSummaryAdHourly, $doZone2);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 12;
        $doDataSummaryAdHourly->requests      = 411;
        $doDataSummaryAdHourly->total_revenue = 116;
        $doDataSummaryAdHourly->clicks        = 723;
        $doDataSummaryAdHourly->date_time     = '2007-04-01';
        $this->generateDataSummaryAdHourlyForZone($doDataSummaryAdHourly, $doZone3);

        // 1. Get data existing range
        $rsAgencyStatistics = $this->_dalAgencyStatistics->getAgencyPublisherStatistics(
            $doAgency->agencyid, new Date('2005-07-07'),  new Date('2007-09-12'));

        $rsAgencyStatistics->find();

        $this->assertTrue($rsAgencyStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsAgencyStatistics->fetch();
        $aRow1 = $rsAgencyStatistics->toArray();

        $rsAgencyStatistics->fetch();
        $aRow2 = $rsAgencyStatistics->toArray();

        $this->ensureRowSequence($aRow1, $aRow2, 'publisherid', $doPublisher1->affiliateid);

        // 2. Check return fields names
        $this->assertFieldExists($aRow2, 'publisherid');
        $this->assertFieldExists($aRow2, 'publishername');
        $this->assertFieldExists($aRow2, 'requests');
        $this->assertFieldExists($aRow2, 'impressions');
        $this->assertFieldExists($aRow2, 'clicks');
        $this->assertFieldExists($aRow2, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow1, 'impressions', 100);
        $this->assertFieldEqual($aRow1, 'requests', 0);
        $this->assertFieldEqual($aRow1, 'revenue', 0);
        $this->assertFieldEqual($aRow1, 'clicks', 7);
        $this->assertFieldEqual($aRow2, 'impressions', 24);
        $this->assertFieldEqual($aRow2, 'requests', 822);
        $this->assertFieldEqual($aRow2, 'revenue', 232);
        $this->assertFieldEqual($aRow2, 'clicks', 1446);

        // 4. Get data in not existing range
        $rsAgencyStatistics = $this->_dalAgencyStatistics->getAgencyPublisherStatistics(
            $doAgency->agencyid,  new Date('2001-12-01'),  new Date('2004-09-19'));
        $rsAgencyStatistics->find();
        $this->assertTrue($rsAgencyStatistics->getRowCount() == 0,
            'Recordset should be empty');
    }

    /**
     * Test agency zone statistics.
     *
     */
    function testGetAgencyZoneStatistics()
    {
        $doAgency          = OA_Dal::factoryDO('agency');
        $doPublisher       = OA_Dal::factoryDO('affiliates');
        $doZone1           = OA_Dal::factoryDO('zones');
        $doPublisher->name = 'test publisher name';
        $doZone1->zonename = 'test zone name';
        $this->generateZoneWithParents($doAgency, $doPublisher, $doZone1);

        $doZone2     = OA_Dal::factoryDO('zones');
        $this->generateZoneForPublisher($doPublisher, $doZone2);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 0;
        $doDataSummaryAdHourly->requests      = 0;
        $doDataSummaryAdHourly->total_revenue = 0;
        $doDataSummaryAdHourly->clicks        = 2;
        $doDataSummaryAdHourly->date_time     = '2007-01-01';
        $this->generateDataSummaryAdHourlyForZone($doDataSummaryAdHourly, $doZone1);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 1;
        $doDataSummaryAdHourly->requests      = 2;
        $doDataSummaryAdHourly->total_revenue = 3;
        $doDataSummaryAdHourly->clicks        = 4;
        $doDataSummaryAdHourly->date_time     = '2007-02-01';
        $this->generateDataSummaryAdHourlyForZone($doDataSummaryAdHourly, $doZone2);

        $doDataSummaryAdHourly                = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->impressions   = 1;
        $doDataSummaryAdHourly->requests      = 2;
        $doDataSummaryAdHourly->total_revenue = 3;
        $doDataSummaryAdHourly->clicks        = 4;
        $doDataSummaryAdHourly->date_time     = '2007-03-01';
        $this->generateDataSummaryAdHourlyForZone($doDataSummaryAdHourly, $doZone2);

        // 1. Get data existing range
        $rsAgencyStatistics = $this->_dalAgencyStatistics->getAgencyZoneStatistics(
            $doAgency->agencyid, new Date('2007-01-01'), new Date('2007-03-01'));

        $rsAgencyStatistics->find();

        $this->assertTrue($rsAgencyStatistics->getRowCount() == 2,
            '2 records should be returned');

        $rsAgencyStatistics->fetch();
        $aRow1 = $rsAgencyStatistics->toArray();

        $rsAgencyStatistics->fetch();
        $aRow2 = $rsAgencyStatistics->toArray();

        $this->ensureRowSequence($aRow1, $aRow2, 'zoneid', $doZone1->zoneid);

        // 2. Check return fields names
        $this->assertFieldExists($aRow2, 'publisherid');
        $this->assertFieldExists($aRow2, 'publishername');
        $this->assertFieldExists($aRow2, 'zoneid');
        $this->assertFieldExists($aRow2, 'zonename');
        $this->assertFieldExists($aRow2, 'requests');
        $this->assertFieldExists($aRow2, 'impressions');
        $this->assertFieldExists($aRow2, 'clicks');
        $this->assertFieldExists($aRow2, 'revenue');

        // 3. Check return fields value
        $this->assertFieldEqual($aRow1, 'publisherid', $doPublisher->affiliateid);
        $this->assertFieldEqual($aRow1, 'publishername', $doPublisher->name);
        $this->assertFieldEqual($aRow1, 'zoneid', $doZone1->zoneid);
        $this->assertFieldEqual($aRow1, 'zonename', $doZone1->zonename);

        $this->assertFieldEqual($aRow1, 'impressions', 0);
        $this->assertFieldEqual($aRow1, 'requests', 0);
        $this->assertFieldEqual($aRow1, 'revenue', 0);
        $this->assertFieldEqual($aRow1, 'clicks', 2);
        $this->assertFieldEqual($aRow2, 'impressions', 2);
        $this->assertFieldEqual($aRow2, 'requests', 4);
        $this->assertFieldEqual($aRow2, 'revenue', 6);
        $this->assertFieldEqual($aRow2, 'clicks', 8);

        // 4. Get data in not existing range
        $rsAgencyStatistics = $this->_dalAgencyStatistics->getAgencyZoneStatistics(
            $doAgency->agencyid, new Date('2007-05-01'), new Date('2007-05-02'));
        $rsAgencyStatistics->find();
        $this->assertTrue($rsAgencyStatistics->getRowCount() == 0,
            'Recordset should be empty');

        // 5. Get 1 rows
        $rsAgencyStatistics = $this->_dalAgencyStatistics->getAgencyZoneStatistics(
            $doAgency->agencyid, new Date('2007-01-02'),  new Date('2007-03-01'));
        $rsAgencyStatistics->find();

        $this->assertTrue($rsAgencyStatistics->getRowCount() == 1,
            '1 records should be returned');

    }

}

?>