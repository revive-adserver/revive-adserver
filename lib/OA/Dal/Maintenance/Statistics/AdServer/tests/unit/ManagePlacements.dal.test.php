<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Factory.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Email.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_* classes.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Dal_Maintenance_Statistics_AdServer_ManagePlacements extends UnitTestCase
{
    var $doCampaigns = null;
    var $doBanners = null;
    var $doDIA = null;
    var $doClients = null;
    var $oDbh = null;
    var $tblCampaigns;

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_AdServer_ManagePlacements()
    {
        $this->UnitTestCase();
        $this->doCampaigns = OA_Dal::factoryDO('campaigns');
        $this->doClients = OA_Dal::factoryDO('clients');
        $this->doBanners   = OA_Dal::factoryDO('banners');
        $this->doDIA = OA_Dal::factoryDO('data_intermediate_ad');
        $this->oDbh =& OA_DB::singleton();
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;
        $this->tblCampaigns = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true);
    }

    function _insertPlacement($aData)
    {
        $this->doCampaigns->campaignname = 'Test Placement';
        $this->doCampaigns->clientid = 1;
        $this->doCampaigns->weight = 1;
        $this->doCampaigns->priority = -1;
        $this->doCampaigns->views = -1;
        $this->doCampaigns->clicks = -1;
        $this->doCampaigns->conversions = -1;
        $this->doCampaigns->target_impression = -1;
        $this->doCampaigns->target_click = -1;
        $this->doCampaigns->target_conversion = -1;
        $this->doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $this->doCampaigns->updated = null;
        $this->doCampaigns->expire = OA_Dal::noDateValue();
        $this->doCampaigns->activate = OA_Dal::noDateValue();
        foreach ($aData AS $key => $val)
        {
            $this->doCampaigns->$key = $val;
        }
        return DataGenerator::generateOne($this->doCampaigns);
    }

    /**
     * A private method to create advertisers for testing.
     *
     * @param array $aData An array of data required to create an advertiser.
     * @return integer The created advertiser ID.
     */
    function _insertAdvertiser($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doClients->$key = $val;
        }
        return DataGenerator::generateOne($this->doClients);
    }

    function _insertAd($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doBanners->$key = $val;
        }
        return DataGenerator::generateOne($this->doBanners);
    }

    function _insertDataIntermediateAd($aData)
    {
        $this->doDIA->operation_interval = 60;
        $this->doDIA->operation_interval_id = 17;
        $this->doDIA->creative_id = 0;
        $this->doDIA->zone_id = 0;
        $this->doDIA->hour = 17;
        foreach ($aData AS $key => $val)
        {
            $this->doDIA->$key = $val;
        }
        return DataGenerator::generateOne($this->doDIA);
    }

    function _getCampaignByCampaignId($idCampaign)
    {
        $query = "
            SELECT
                *
            FROM
                {$this->tblCampaigns}
            WHERE
                campaignid = ".$idCampaign;
        return $this->oDbh->queryRow($query);
    }

    /**
     * A method to test the managePlacements() method.
     */
    function testManagePlacements()
    {
        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        $oDate = new Date();

        // Insert the base test data

        $aData = array(
                       'contact'=>'Test Contact',
                       'email'=>'postmaster@localhost'
                       );
        $idClient1 = $this->_insertAdvertiser($aData);

        $aData = array(
            'campaignname'=>'Test Campaign 1',
        );
        $idCampaign1 = $this->_insertPlacement($aData);
        $aData = array(
            'campaignname'=>'Test Campaign 2',
            'clientid'=>$idClient1,
            'views'=>10,
        );
        $idCampaign2 = $this->_insertPlacement($aData);

        $aData = array(
            'campaignname'=>'Test Campaign 3',
            'clientid'=>$idClient1,
            'clicks'=>10,
        );
        $idCampaign3 = $this->_insertPlacement($aData);

        $aData = array(
            'campaignname'=>'Test Campaign 4',
            'clientid'=>$idClient1,
            'conversions'=>10,
        );
        $idCampaign4 = $this->_insertPlacement($aData);

        $aData = array(
            'campaignname'=>'Test Campaign 5',
            'clientid'=>$idClient1,
            'views'=>10,
            'clicks'=>10,
            'conversions'=>10
        );
        $idCampaign5 = $this->_insertPlacement($aData);

        $aData = array(
            'campaignname'=>'Test Campaign 6',
            'clientid'=>$idClient1,
            'views'=>-1,
            'expire'=>'2004-06-06',
        );
        $idCampaign6 = $this->_insertPlacement($aData);

        $aData = array(
            'campaignname'=>'Test Campaign 7',
            'clientid'=>$idClient1,
            'activate'=>'2004-06-06',
            'status'=>OA_ENTITY_STATUS_AWAITING
        );
        $idCampaign7 = $this->_insertPlacement($aData);

        $aData = array(
                        'campaignid'=>$idCampaign1,
                      );
        $idBanner1 = $this->_insertAd($aData);

        $aData = array(
                        'campaignid'=>$idCampaign2,
                      );
        $idBanner2 = $this->_insertAd($aData);

        $aData = array(
                        'campaignid'=>$idCampaign2,
                      );
        $idBanner3 = $this->_insertAd($aData);

        $aData = array(
                        'campaignid'=>$idCampaign2,
                      );
        $idBanner4 = $this->_insertAd($aData);

        $aData = array(
                        'campaignid'=>$idCampaign3,
                      );
        $idBanner5 = $this->_insertAd($aData);

        $aData = array(
                        'campaignid'=>$idCampaign4,
                      );
        $idBanner6 = $this->_insertAd($aData);

        $aData = array(
                        'campaignid'=>$idCampaign5,
                      );
        $idBanner7 = $this->_insertAd($aData);

        $aData = array(
                        'campaignid'=>$idCampaign6,
                      );
        $idBanner8 = $this->_insertAd($aData);

        $aData = array(
                        'campaignid'=>$idCampaign7,
                      );
        $idBanner9 = $this->_insertAd($aData);

        // Test with no summarised data
        $report = $dsa->managePlacements($oDate);

        $aRow = $this->_getCampaignByCampaignId($idCampaign1);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_RUNNING);

        $aRow = $this->_getCampaignByCampaignId($idCampaign2);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_RUNNING);

        $aRow = $this->_getCampaignByCampaignId($idCampaign3);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_RUNNING);

        $aRow = $this->_getCampaignByCampaignId($idCampaign4);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_RUNNING);

        $aRow = $this->_getCampaignByCampaignId($idCampaign5);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_RUNNING);

        $aRow = $this->_getCampaignByCampaignId($idCampaign6);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2004-06-06');
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_EXPIRED);

        $aRow = $this->_getCampaignByCampaignId($idCampaign7);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], '2004-06-06');
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_RUNNING);

        // Insert the summary test data - Part 1

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner1,
                        'impressions'=>1,
                        'clicks'=>1,
                        'conversions'=>1
                      );
        $idDIA1 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner2,
                        'impressions'=>1,
                        'clicks'=>1,
                        'conversions'=>1
                      );
        $idDIA2 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner3,
                        'impressions'=>1,
                        'clicks'=>0,
                        'conversions'=>0
                      );
        $idDIA3 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner4,
                        'impressions'=>8,
                        'clicks'=>0,
                        'conversions'=>0
                      );
        $idDIA4 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner5,
                        'impressions'=>1000,
                        'clicks'=>5,
                        'conversions'=>1000
                      );
        $idDIA5 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner6,
                        'impressions'=>1000,
                        'clicks'=>1000,
                        'conversions'=>1000
                      );
        $idDIA6 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner7,
                        'impressions'=>0,
                        'clicks'=>4,
                        'conversions'=>6
                      );
        $idDIA7 = $this->_insertDataIntermediateAd($aData);

        $aData = array(
                        'interval_start'=>'2004-06-06 17:00:00',
                        'interval_end'=>'2004-06-06 17:59:59',
                        'ad_id'=>$idBanner8,
                        'impressions'=>0,
                        'clicks'=>4,
                        'conversions'=>6
                      );
        $idDIA8 = $this->_insertDataIntermediateAd($aData);

        // Test with summarised data
        $report = $dsa->managePlacements($oDate);

        $aRow = $this->_getCampaignByCampaignId($idCampaign1);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_RUNNING);

        $aRow = $this->_getCampaignByCampaignId($idCampaign2);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_EXPIRED);

        $aRow = $this->_getCampaignByCampaignId($idCampaign3);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_RUNNING);

        $aRow = $this->_getCampaignByCampaignId($idCampaign4);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_EXPIRED);

        $aRow = $this->_getCampaignByCampaignId($idCampaign5);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_RUNNING);

        $aRow = $this->_getCampaignByCampaignId($idCampaign6);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2004-06-06');
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_EXPIRED);

        $aRow = $this->_getCampaignByCampaignId($idCampaign7);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], '2004-06-06');
        $this->assertEqual($aRow['astatus'], OA_ENTITY_STATUS_RUNNING);
        DataGenerator::cleanUp();

        // Final test to ensure that placements expired as a result of limitations met are
        // not re-activated in the event that their expiration date has not yet been reached

        $aData = array(
                        'campaignname'=>'Test Campaign 1',
                        'clientid'=>1,
                        'views'=>10,
                        'clicks'=>-1,
                        'conversions'=>-1,
                        'expire'=>'2005-12-09',
                        'activate'=>'2005-12-07',
                        'status'=>OA_ENTITY_STATUS_EXIPRED
                      );
        $idCampaign1 = $this->_insertPlacement($aData);

        $aData = array(
                       'contact'=>'Test Contact',
                       'email'=>'postmaster@localhost'
                       );
        $idClient1 = $this->_insertAdvertiser($aData);

        $aData = array(
                        'campaignid'=>1,
                      );
        $idBanner1 = $this->_insertAd($aData);

        $aData = array(
                        'operation_interval_id'=>25,
                        'interval_start'=>'2005-12-08 00:00:00',
                        'interval_end'=>'2004-12-08 00:59:59',
                        'hour'=>0,
                        'ad_id'=>1,
                        'impressions'=>100,
                        'clicks'=>1,
                        'conversions'=>0
                      );
        $idDIA1 = $this->_insertDataIntermediateAd($aData);

        $oDate = new Date('2005-12-08 01:00:01');
        $report = $dsa->managePlacements($oDate);

        $aRow = $this->_getCampaignByCampaignId($idCampaign1);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2005-12-09');
        $this->assertEqual($aRow['activate'], '2005-12-07');
        $this->assertEqual($aRow['status'], OA_ENTITY_STATUS_EXPIRED);
        DataGenerator::cleanUp();
        TestEnv::restoreConfig();
    }

    /**
     * A method to test the sending of emails from the
     * managePlacements() method - tests the sending of
     * the "placement activated" emails.
     */
    function testManagePlacementsEmailsPlacementActivated()
    {
        // Prepare a single placement that is inactive, and has an old
        // activation date (so that it will need to be activated)

        $aData = array(
           'contact' => 'Test Placement Activated Contact',
           'email'   => 'postmaster@placement.activated'
        );
        $advertiserId = $this->_insertAdvertiser($aData);

        $oDate = new Date();
        $oDateStart = new Date();
        $oDateStart->copy($oDate);
        $oDateStart->subtractSeconds(SECONDS_PER_HOUR + 1);
        $aData = array(
            'status' => OA_ENTITY_STATUS_AWAITING,
            'activate'   => $oDateStart->format('%Y-%m-%d')
        );
        $campaignId = $this->_insertPlacement($aData);

        $aData = array(
            'campaignid' => $campaignId
        );
        $adId = $this->_insertAd($aData);

        // Create an instance of the mocked OA_Email class, and set
        // expectations on how the class' methods should be called
        // based on the above
        Mock::generate('OA_Email');
        $oEmailMock = new MockOA_Email($this);
        $oEmailMock->expectOnce('preparePlacementActivatedDeactivatedEmail', array("$campaignId"));

        // Register the mocked OA_Email class in the service locator
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Email', $oEmailMock);

        // Run the managePlacements() method and ensure that the correct
        // calls to OA_Email were made
        $oDate = new Date();
        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $oDsa = $oMDMSF->factory("AdServer");
        $report = $oDsa->managePlacements($oDate);
        $oEmailMock->tally();

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the sending of emails from the
     * managePlacements() method - tests the sending of
     * the "placement deactivated" emails.
     */
    function testManagePlacementsEmailsPlacementDeactivated()
    {
        // Prepare a single placement that is active, and has a lifetime
        // impression target that has been met (so that it will need to
        // be deactivated)

        $aData = array(
           'contact' => 'Test Placement Deactivated Contact',
           'email'   => 'postmaster@placement.deactivated'
        );
        $advertiserId = $this->_insertAdvertiser($aData);

        $aData = array(
            'status' => OA_ENTITY_STATUS_RUNNING,
            'views'  => '100'
        );
        $campaignId = $this->_insertPlacement($aData);

        $aData = array(
            'campaignid' => $campaignId
        );
        $adId = $this->_insertAd($aData);

        $aData = array(
            'operation_interval_id' => 25,
            'interval_start'        => '2005-12-08 00:00:00',
            'interval_end'          => '2004-12-08 00:59:59',
            'hour'                  => 0,
            'ad_id'                 => 1,
            'impressions'           => 101
        );
        $this->_insertDataIntermediateAd($aData);

        // Create an instance of the mocked OA_Email class, and set
        // expectations on how the class' methods should be called
        // based on the above
        Mock::generate('OA_Email');
        $oEmailMock = new MockOA_Email($this);
        $oEmailMock->expectOnce('preparePlacementActivatedDeactivatedEmail', array("$campaignId", 2));

        // Register the mocked OA_Email class in the service locator
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Email', $oEmailMock);

        // Run the managePlacements() method and ensure that the correct
        // calls to OA_Email were made
        $oDate = new Date();
        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $oDsa = $oMDMSF->factory("AdServer");
        $report = $oDsa->managePlacements($oDate);
        $oEmailMock->tally();

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the sending of emails from the
     * managePlacements() method - tests the sending of
     * the "placement about to expire" emails.
     */
    function testManagePlacementsEmailsPlacementToExpire()
    {
        // Set the date format
        global $date_format;
        $date_format = '%Y-%m-%d';

        // Insert the required preference values for dealing with email warnings
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_admin';
        $doPreferences->account_type    = OA_ACCOUNT_ADMIN;
        $warnEmailAdminPreferenceId = DataGenerator::generateOne($doPreferences);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_admin_impression_limit';
        $doPreferences->account_type    = OA_ACCOUNT_ADMIN;
        $warnEmailAdminPreferenceImpressionLimitId = DataGenerator::generateOne($doPreferences);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_admin_day_limit';
        $doPreferences->account_type    = OA_ACCOUNT_ADMIN;
        $warnEmailAdminPreferenceDayLimitId = DataGenerator::generateOne($doPreferences);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_manager';
        $doPreferences->account_type    = OA_ACCOUNT_MANAGER;
        DataGenerator::generateOne($doPreferences);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_manager_impression_limit';
        $doPreferences->account_type    = OA_ACCOUNT_MANAGER;
        DataGenerator::generateOne($doPreferences);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_manager_day_limit';
        $doPreferences->account_type    = OA_ACCOUNT_MANAGER;
        DataGenerator::generateOne($doPreferences);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_advertiser';
        $doPreferences->account_type    = OA_ACCOUNT_ADVERTISER;
        DataGenerator::generateOne($doPreferences);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_advertiser_impression_limit';
        $doPreferences->account_type    = OA_ACCOUNT_ADVERTISER;
        DataGenerator::generateOne($doPreferences);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_advertiser_day_limit';
        $doPreferences->account_type    = OA_ACCOUNT_ADVERTISER;
        DataGenerator::generateOne($doPreferences);

        // Create the admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'Administrator Account';
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);

        // Create a user
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->contact_name = 'Andrew Hill';
        $doUsers->email_address = 'andrew.hill@openads.org';
        $doUsers->username = 'admin';
        $doUsers->password = md5('password');
        $doUsers->default_account_id = $adminAccountId;
        $userId = DataGenerator::generateOne($doUsers);

        // Create a manager "agency" and account
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Manager Account';
        $doAgency->contact = 'Andrew Hill';
        $doAgency->email = 'andrew.hill@openads.org';
        $managerAgencyId = DataGenerator::generateOne($doAgency);

        // Get the account ID for the manager "agency"
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->agency_id = $managerAgencyId;
        $doAgency->find();
        $doAgency->fetch();
        $aAgency = $doAgency->toArray();
        $managerAccountId = $aAgency['account_id'];

        // Create an advertiser "client" and account, owned by the manager
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->name = 'Advertiser Account';
        $doClients->contact = 'Andrew Hill';
        $doClients->email = 'andrew.hill@openads.org';
        $doClients->agencyid = $managerAgencyId;
        $advertiserClientId = DataGenerator::generateOne($doClients);

        // Get the account ID for the advertiser "client"
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientid = $advertiserClientId;
        $doClients->find();
        $doClients->fetch();
        $aAdvertiser = $doClients->toArray();
        $advertiserAccountId = $aAdvertiser['account_id'];

        // Create a currently running placement with 100 impressions
        // remaining and set to expire on 2008-01-13
        $aData = array(
            'clientid' => $advertiserClientId,
            'status'   => OA_ENTITY_STATUS_RUNNING,
            'views'    => '100',
            'expire'   => '2008-01-13'
        );
        $campaignId = $this->_insertPlacement($aData);

        // Insert a banner for the placement
        $aData = array(
            'campaignid' => $campaignId
        );
        $adId = $this->_insertAd($aData);

        // Create an instance of the mocked OA_Email class, and set
        // expectations on how the class' methods should be called
        // based on the above
        Mock::generate('OA_Email');
        $oEmailMock = new MockOA_Email($this);
        $oEmailMock->expectNever('preparePlacementImpendingExpiryEmail');

        // Register the mocked OA_Email class in the service locator
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Email', $oEmailMock);

        // Run the managePlacements() method and ensure that the correct
        // calls to OA_Email were made
        $oDate = new Date('2008-01-11 23:00:01');
        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $oDsa = $oMDMSF->factory("AdServer");
        $report = $oDsa->managePlacements($oDate);
        $oEmailMock->tally();

        // Now set the preference that states that the admin account
        // wants to get email warnings
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $adminAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailAdminPreferenceId;
        $doAccount_Preference_Assoc->value = 'true';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Create a new instance of the mocked OA_Email class, and set
        // expectations on how the class' methods should be called
        // based on the above
        $oEmailMock = new MockOA_Email($this);
        $oEmailMock->expectNever('preparePlacementImpendingExpiryEmail');

        // Register the mocked OA_Email class in the service locator
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Email', $oEmailMock);

        // Run the managePlacements() method and ensure that the correct
        // calls to OA_Email were made
        $oDate = new Date('2008-01-11 23:00:01');
        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $oDsa = $oMDMSF->factory("AdServer");
        $report = $oDsa->managePlacements($oDate);
        $oEmailMock->tally();

        // Now set the preference that states that the admin account
        // wants to get email warnings if there are less than 50
        // impressions remaining
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $adminAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailAdminPreferenceImpressionLimitId;
        $doAccount_Preference_Assoc->value = '50';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Create a new instance of the mocked OA_Email class, and set
        // expectations on how the class' methods should be called
        // based on the above
        $oEmailMock = new MockOA_Email($this);
        $oEmailMock->expectNever('preparePlacementImpendingExpiryEmail');

        // Register the mocked OA_Email class in the service locator
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Email', $oEmailMock);

        // Run the managePlacements() method and ensure that the correct
        // calls to OA_Email were made
        $oDate = new Date('2008-01-11 23:00:01');
        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $oDsa = $oMDMSF->factory("AdServer");
        $report = $oDsa->managePlacements($oDate);
        $oEmailMock->tally();

        // Delivery 60 impressions out of the 100, so that only 40 remain
        // (i.e. less than the 50 limit set above)
        $aData = array(
            'operation_interval_id' => 25,
            'interval_start'        => '2008-01-11 22:00:00',
            'interval_end'          => '2008-01-11 22:59:59',
            'hour'                  => 0,
            'ad_id'                 => $adId,
            'impressions'           => 60
        );
        $this->_insertDataIntermediateAd($aData);

        // Create a new instance of the mocked OA_Email class, and set
        // expectations on how the class' methods should be called
        // based on the above
        $oEmailMock = new MockOA_Email($this);
        $oEmailMock->expectOnce('preparePlacementImpendingExpiryEmail', array("$advertiserClientId", "$campaignId", 'impressions', '50'));

        // Register the mocked OA_Email class in the service locator
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Email', $oEmailMock);

        // Run the managePlacements() method and ensure that the correct
        // calls to OA_Email were made
        $oDate = new Date('2008-01-11 23:00:01');
        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $oDsa = $oMDMSF->factory("AdServer");
        $report = $oDsa->managePlacements($oDate);
        $oEmailMock->tally();

        // Now set the preference that states that the admin account
        // wants to get email warnings if there is 1 day remaining
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $adminAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailAdminPreferenceDayLimitId;
        $doAccount_Preference_Assoc->value = '1';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Create a new instance of the mocked OA_Email class, and set
        // expectations on how the class' methods should be called
        // based on the above
        $oEmailMock = new MockOA_Email($this);
        $oEmailMock->expectOnce('preparePlacementImpendingExpiryEmail', array("$advertiserClientId", "$campaignId", 'impressions', '50'));

        // Register the mocked OA_Email class in the service locator
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Email', $oEmailMock);

        // Run the managePlacements() method and ensure that the correct
        // calls to OA_Email were made
        $oDate = new Date('2008-01-11 23:00:01');
        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $oDsa = $oMDMSF->factory("AdServer");
        $report = $oDsa->managePlacements($oDate);
        $oEmailMock->tally();

        // Create a new instance of the mocked OA_Email class, and set
        // expectations on how the class' methods should be called
        // based on the above
        $oEmailMock = new MockOA_Email($this);
        $oEmailMock->expectOnce('preparePlacementImpendingExpiryEmail', array("$advertiserClientId", "$campaignId", 'date', '2008-01-13'));

        // Register the mocked OA_Email class in the service locator
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Email', $oEmailMock);

        // Run the managePlacements() method and ensure that the correct
        // calls to OA_Email were made
        $oDate = new Date('2008-01-12 00:00:01');
        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $oDsa = $oMDMSF->factory("AdServer");
        $report = $oDsa->managePlacements($oDate);
        $oEmailMock->tally();

        // Clean up
        DataGenerator::cleanUp();

    }




/*
        // Get the admin account ID
        $adminAccountId = OA_Dal_ApplicationVariables::get('admin_account_id');

        // Insert preferences regarding the above
        $doAccount_preference_assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_preference_assoc->account_id    = $adminAccountId;
        $doAccount_preference_assoc->preference_id = $warnEmailAdminPreferenceId;
        $doAccount_preference_assoc->value         = 'true';
        DataGenerator::generateOne($doAccount_preference_assoc);
        */







}

?>
