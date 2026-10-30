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

require_once MAX_PATH . '/lib/OA/Dashboard/Widgets/GraphOAP.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/tests/util/DalStatisticsUnitTestCase.php';

/**
 * Skips the parent constructor, which prepares the template and loads the stats.
 */
class Test_OA_Dashboard_Widget_GraphOAP extends OA_Dashboard_Widget_GraphOAP
{
    public function __construct() {}
}

/**
 * A class for testing the OA_Dashboard_Widget_GraphOAP class.
 *
 * @package    OpenXDashboard
 * @subpackage TestSuite
 */
class Test_OA_Dashboard_Widget_GraphOAPTest extends DalStatisticsUnitTestCase
{
    public function tearDown()
    {
        unset($GLOBALS['session']['user']);
        DataGenerator::cleanUp();
    }

    public function testGetStats()
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $day = date('D', strtotime($yesterday));

        $doAgency1 = OA_Dal::factoryDO('agency');
        $doAdvertiser1 = OA_Dal::factoryDO('clients');
        $doCampaign1 = OA_Dal::factoryDO('campaigns');
        $doBanner1 = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency1, $doAdvertiser1, $doCampaign1, $doBanner1);

        $doAgency2 = OA_Dal::factoryDO('agency');
        $doAdvertiser2 = OA_Dal::factoryDO('clients');
        $doCampaign2 = OA_Dal::factoryDO('campaigns');
        $doBanner2 = OA_Dal::factoryDO('banners');
        $this->generateBannerWithParents($doAgency2, $doAdvertiser2, $doCampaign2, $doBanner2);

        $doAgency3 = OA_Dal::factoryDO('agency');
        $agencyId3 = DataGenerator::generateOne($doAgency3);

        $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDsah->date_time = "{$yesterday} 12:00:00";
        $doDsah->impressions = 100;
        $doDsah->clicks = 10;
        $this->generateDataSummaryAdHourlyForBanner($doDsah, $doBanner1);

        $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDsah->date_time = "{$yesterday} 12:00:00";
        $doDsah->impressions = 1000;
        $doDsah->clicks = 100;
        $this->generateDataSummaryAdHourlyForBanner($doDsah, $doBanner2);

        // Outside of the 7 days range
        $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDsah->date_time = date('Y-m-d', strtotime('-30 days')) . ' 12:00:00';
        $doDsah->impressions = 5;
        $doDsah->clicks = 1;
        $this->generateDataSummaryAdHourlyForBanner($doDsah, $doBanner1);

        $oWidget = new Test_OA_Dashboard_Widget_GraphOAP();

        // 1. The manager only sees the stats of their own agency
        $this->_logIn(OA_ACCOUNT_MANAGER, $doAgency1->agencyid);
        $aStats = $oWidget->getStats();
        $this->assertEqual($aStats, [[$day => 100], [$day => 10]]);

        // 2. A manager without banners gets no stats
        $this->_logIn(OA_ACCOUNT_MANAGER, $agencyId3);
        $this->assertEqual($oWidget->getStats(), []);

        // 3. The admin sees the stats of all agencies
        $this->_logIn(OA_ACCOUNT_ADMIN, 0);
        $aStats = $oWidget->getStats();
        $this->assertEqual($aStats, [[$day => 1100], [$day => 110]]);
    }

    private function _logIn($accountType, $entityId)
    {
        $oUser = new OA_Permission_User(OA_Dal::factoryDO('users'), true);
        $oUser->aAccount = [
            'account_id' => 0,
            'account_type' => $accountType,
            'entity_id' => $entityId,
        ];
        $GLOBALS['session']['user'] = $oUser;
    }
}
