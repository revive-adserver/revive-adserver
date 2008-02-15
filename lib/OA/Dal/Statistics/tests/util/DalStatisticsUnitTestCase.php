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

require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A base class for DAL Statistic test class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */


class DalStatisticsUnitTestCase extends DalUnitTestCase
{
    /**
     * Added to database Banner, Campaign, Advertiser, Agency.
     *
     * @param DataObjects_Agency &$doAgency       agency object
     * @param DataObjects_Clients &$doAdvertiser  advertiser object
     * @param DataObjects_Campaigns &$doCampaign  campaign object
     * @param DataObjects_Bannerts &$doBanner     banner object
     */
    function generateBannerWithParents(&$doAgency, &$doAdvertiser, &$doCampaign, &$doBanner)
    {
        $doAgency->agencyid = DataGenerator::generateOne($doAgency);

        $doAdvertiser->agencyid = $doAgency->agencyid;
        $doAdvertiser->clientid = DataGenerator::generateOne($doAdvertiser);

        $doCampaign->clientid   = $doAdvertiser->clientid;
        $doCampaign->campaignid = DataGenerator::generateOne($doCampaign);

        $doBanner->campaignid = $doCampaign->campaignid;
        $doBanner->bannerid   = DataGenerator::generateOne($doBanner);
    }

    /**
     * Added to database Banner for Campaign.
     *
     * @param DataObjects_Campaigns &$doCampaign  campaign object
     * @param DataObjects_Bannerts &$doBanner     banner object
     */
    function generateBannerForCampaign(&$doCampaign, &$doBanner)
    {
        $doBanner->campaignid = $doCampaign->campaignid;
        $doBanner->bannerid   = DataGenerator::generateOne($doBanner);
    }

    /**
     * Added to database Banner and Campaign for Advertiser.
     *
     * @param DataObjects_Clients &$doAdvertiser  advertiser object
     * @param DataObjects_Campaigns &$doCampaign  campaign object
     * @param DataObjects_Bannerts &$doBanner     banner object
     */
    function generateBannerAndCampaignForAdvertiser(&$doAdvertiser, &$doCampaign, &$doBanner)
    {
        $doCampaign->clientid   = $doAdvertiser->clientid;
        $doCampaign->campaignid = DataGenerator::generateOne($doCampaign);

        $doBanner->campaignid = $doCampaign->campaignid;
        $doBanner->bannerid   = DataGenerator::generateOne($doBanner);
    }

    /**
     * Added to database Zone, Publisher, Agency.
     *
     * @param DataObjects_Agency &$doAgency        agency object
     * @param DataObjects_Affiliates &$doPublisher publisher object
     * @param DataObjects_Zones &$doZone           zone object
     */
    function generateZoneWithParents(&$doAgency, &$doPublisher, &$doZone)
    {
        $doAgency->agencyid = DataGenerator::generateOne($doAgency);

        $doPublisher->agencyid    = $doAgency->agencyid;
        $doPublisher->affiliateid = DataGenerator::generateOne($doPublisher);

        $doZone->affiliateid = $doPublisher->affiliateid;
        $doZone->zoneid      = DataGenerator::generateOne($doZone);
    }

    /**
     * Added to database Zone, Publisher.
     *
     * @param DataObjects_Agency &$doAgency        agency object
     * @param DataObjects_Affiliates &$doPublisher publisher object
     * @param DataObjects_Zones &$doZone           zone object
     */
    function generateZoneAndPublisherForAgency(&$doAgency, &$doPublisher, &$doZone)
    {
        $doPublisher->agencyid    = $doAgency->agencyid;
        $doPublisher->affiliateid = DataGenerator::generateOne($doPublisher);

        $doZone->affiliateid = $doPublisher->affiliateid;
        $doZone->zoneid      = DataGenerator::generateOne($doZone);
    }

    /**
     * Added to database Zone.
     *
     * @param DataObjects_Affiliates &$doPublisher publisher object
     * @param DataObjects_Zones &$doZone           zone object
     */
    function generateZoneForPublisher(&$doPublisher, &$doZone)
    {
        $doZone->affiliateid = $doPublisher->affiliateid;
        $doZone->zoneid      = DataGenerator::generateOne($doZone);
    }

    /**
     * Added data to main statistics tables into database (data_summary_ad_hourly). For bannerid.
     *
     * @param DataObjects_Data_summary_ad_hourly &$doDataSummaryAdHourly  statistics object
     * @param DataObjects_Banners                &$doBanner               banner object
     */
    function generateDataSummaryAdHourlyForBanner(&$doDataSummaryAdHourly, &$doBanner)
    {
        $doDataSummaryAdHourly->ad_id = $doBanner->bannerid;
        DataGenerator::generateOne($doDataSummaryAdHourly);
    }

    /**
     * Added data to main statistics tables into database (data_summary_ad_hourly). For zoneid.
     *
     * @param DataObjects_Data_summary_ad_hourly &$doDataSummaryAdHourly  statistics object
     * @param DataObjects_Zones                 &$doZone                  zone object
     */
    function generateDataSummaryAdHourlyForZone(&$doDataSummaryAdHourly, &$doZone)
    {
        $doDataSummaryAdHourly->zone_id = $doZone->zoneid;
        DataGenerator::generateOne($doDataSummaryAdHourly);
    }

    /**
     * Added data to main statistics tables into database (data_summary_ad_hourly). For bannerid and zoneid.
     *
     * @param DataObjects_Data_summary_ad_hourly &$doDataSummaryAdHourly
     * @param DataObjects_Banners                &$doBanner
     * @param DataObjects_Zones                  &$doZone
     */
    function generateDataSummaryAdHourlyForBannerAndZone(&$doDataSummaryAdHourly, &$doBanner, &$doZone)
    {
        $doDataSummaryAdHourly->zone_id = $doZone->zoneid;
        $doDataSummaryAdHourly->ad_id   = $doBanner->bannerid;
        DataGenerator::generateOne($doDataSummaryAdHourly);
    }

    /**
     * Check if field isset in result array.
     *
     * @param array $aRow  result array from statistics
     * @param string $fieldName  field name
     */
    function assertFieldExists($aRow, $fieldName)
    {
        $this->assertTrue(array_key_exists($fieldName, $aRow), 'Field \''.$fieldName.'\' is missing');
    }

    /**
     * Check if field equal value.
     *
     * @param array $aRow  result array from statistics
     * @param string $fieldName  field name
     * @param string $fieldValue  field value
     */
    function assertFieldEqual($aRow, $fieldName, $fieldValue)
    {
        $this->assertEqual($aRow[$fieldName], $fieldValue, 'Field \''.$fieldName.'\' value is incorrect');
    }

    /**
     * Ensure row sequence.
     *
     * @param array $aRow1
     * @param array $aRow2
     * @param string $fieldName  field name
     * @param string $fieldValue  field value for 1 argument
     */
    function ensureRowSequence(&$aRow1, &$aRow2, $fieldName, $fieldValue)
    {
        if ($aRow1[$fieldName] != $fieldValue) {
            $aRowD = $aRow1;
            $aRow1 = $aRow2;
            $aRow2 = $aRowD;
        }
    }

}

?>