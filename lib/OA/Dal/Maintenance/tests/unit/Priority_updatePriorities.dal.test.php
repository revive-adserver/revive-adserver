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
$Id$
*/

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the updatePriorities() method of the
 * non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_updatePriorities extends UnitTestCase
{
    var $aIds = array();

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_updatePriorities()
    {
        $this->UnitTestCase();
    }

    /**
     * Method to test the updatePriorities method.
     *
     * Test 1: Test with no Date registered in the service locator, ensure false returned.
     * Test 2: Test with no data in the database, ensure data is correctly stored.
     * Test 3: Test with previous test data in the database, ensure data is correctly stored.
     * Test 4: Test with an obscene number of items, and ensure that the packet size is
     *         not exceeded (no asserts, test suite will simply fail if unable to work).
     */
    function testUpdatePriorities()
    {
        /**
         * @TODO Locate where clean up doesn't happen before this test, and fix!
         */
        TestEnv::restoreEnv();

        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        // Insert the data into the ad_zone_assoc table, as an ad is linked to a zone
        $this->_generateTestData();

        // Test 1
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $aData =
            array(
                array(
                    'ads' => array(
                        array(
                            'ad_id'                      => $this->aIds['ad'],
                            'zone_id'                    => $this->aIds['zone'],
                            'required_impressions'       => '1000',
                            'requested_impressions'      => '1000',
                            'priority'                   => '0.45',
                            'priority_factor'            => null,
                            'priority_factor_limited'    => false,
                            'past_zone_traffic_fraction' => null
                        )
                    )
                )
            );
        $result = $oMaxDalMaintenance->updatePriorities($aData);
        $this->assertFalse($result);

        // Test 2
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result = $oMaxDalMaintenance->updatePriorities($aData);
        $this->assertTrue($result);
        $query = "
            SELECT
                ad_id,
                zone_id,
                priority
            FROM
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['ad_zone_assoc'],true)."
            WHERE
                ad_id = {$this->aIds['ad']} AND zone_id = {$this->aIds['zone']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['ad_id'], $this->aIds['ad']);
        $this->assertEqual($aRow['zone_id'], $this->aIds['zone']);
        $this->assertEqual($aRow['priority'], 0.45);
        $query = "
            SELECT
                operation_interval,
                operation_interval_id,
                interval_start,
                interval_end,
                ad_id,
                zone_id,
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                priority_factor_limited,
                past_zone_traffic_fraction,
                created,
                created_by,
                expired,
                expired_by
            FROM
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['data_summary_ad_zone_assoc'],true)."
            WHERE
                ad_id = {$this->aIds['ad']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $currentOperationIntervalID = OA_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], $currentOperationIntervalID);
        $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['ad_id'], $this->aIds['ad']);
        $this->assertEqual($aRow['zone_id'], $this->aIds['zone']);
        $this->assertEqual($aRow['required_impressions'], 1000);
        $this->assertEqual($aRow['requested_impressions'], 1000);
        $this->assertEqual($aRow['priority'], 0.45);
        $this->assertNull($aRow['priority_factor']);
        $this->assertFalse($aRow['priority_factor_limited']);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $this->assertEqual($aRow['created'], $oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['created_by'], 0);
        $this->assertNull($aRow['expired']);
        $this->assertNull($aRow['expired_by']);

        // Test 3
        $aData =
            array(
                array(
                    'ads' => array(
                        array(
                            'ad_id'                      => $this->aIds['ad'],
                            'zone_id'                    => $this->aIds['zone'],
                            'required_impressions'       => 2000,
                            'requested_impressions'      => 2000,
                            'priority'                   => 0.9,
                            'priority_factor'            => 0.1,
                            'priority_factor_limited'    => false,
                            'past_zone_traffic_fraction' => 0.99
                        ),
                        array(
                            'ad_id'                      => $this->aIds['ad']+1,
                            'zone_id'                    => $this->aIds['ad']+1,
                            'required_impressions'       => 500,
                            'requested_impressions'      => 500,
                            'priority'                   => 0.1,
                            'priority_factor'            => 0.2,
                            'priority_factor_limited'    => true,
                            'past_zone_traffic_fraction' => 0.45
                        )
                    )
                )
            );
        $oOldDate = new Date();
        $oOldDate->copy($oDate);
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result = $oMaxDalMaintenance->updatePriorities($aData);
        $this->assertTrue($result);
        $query = "
            SELECT
                ad_id,
                zone_id,
                priority
            FROM
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['ad_zone_assoc'],true)."
            WHERE
                ad_id = {$this->aIds['ad']} AND zone_id = {$this->aIds['zone']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['ad_id'], $this->aIds['ad']);
        $this->assertEqual($aRow['zone_id'], $this->aIds['zone']);
        $this->assertEqual($aRow['priority'], 0.9);
        $query = "
            SELECT
                operation_interval,
                operation_interval_id,
                interval_start,
                interval_end,
                ad_id,
                zone_id,
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                priority_factor_limited,
                past_zone_traffic_fraction,
                created,
                created_by,
                expired,
                expired_by
            FROM
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['data_summary_ad_zone_assoc'],true)."
            WHERE
                ad_id = {$this->aIds['ad']}
                AND expired IS NOT NULL";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $currentOperationIntervalID = OA_OperationInterval::convertDateToOperationIntervalID($oOldDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oOldDate);
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], $currentOperationIntervalID);
        $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['ad_id'], $this->aIds['ad']);
        $this->assertEqual($aRow['zone_id'], $this->aIds['ad']);
        $this->assertEqual($aRow['required_impressions'], 1000);
        $this->assertEqual($aRow['requested_impressions'], 1000);
        $this->assertEqual($aRow['priority'], 0.45);
        $this->assertNull($aRow['priority_factor']);
        $this->assertFalse($aRow['priority_factor_limited']);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $this->assertEqual($aRow['created'], $oOldDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['created_by'], 0);
        $this->assertEqual($aRow['expired'], $oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['expired_by'], 0);
        $query = "
            SELECT
                operation_interval,
                operation_interval_id,
                interval_start,
                interval_end,
                ad_id,
                zone_id,
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                priority_factor_limited,
                past_zone_traffic_fraction,
                created,
                created_by,
                expired,
                expired_by
            FROM
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['data_summary_ad_zone_assoc'],true)."
            WHERE
                ad_id = {$this->aIds['ad']}
                AND expired IS NULL";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $currentOperationIntervalID = OA_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], $currentOperationIntervalID);
        $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['ad_id'], $this->aIds['ad']);
        $this->assertEqual($aRow['zone_id'], $this->aIds['ad']);
        $this->assertEqual($aRow['required_impressions'], 2000);
        $this->assertEqual($aRow['requested_impressions'], 2000);
        $this->assertEqual($aRow['priority'], 0.9);
        $this->assertEqual($aRow['priority_factor'], 0.1);
        $this->assertFalse($aRow['priority_factor_limited']);
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($aRow['created'], $oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['created_by'], 0);
        $this->assertNull($aRow['expired']);
        $this->assertNull($aRow['expired_by']);
        $query = "
            SELECT
                operation_interval,
                operation_interval_id,
                interval_start,
                interval_end,
                ad_id,
                zone_id,
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                priority_factor_limited,
                past_zone_traffic_fraction,
                created,
                created_by,
                expired,
                expired_by
            FROM
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['data_summary_ad_zone_assoc'],true)."
            WHERE
                ad_id = ".($this->aIds['ad']+1);
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $currentOperationIntervalID = OA_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], $currentOperationIntervalID);
        $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['ad_id'], $this->aIds['ad']+1);
        $this->assertEqual($aRow['zone_id'], $this->aIds['ad']+1);
        $this->assertEqual($aRow['required_impressions'], 500);
        $this->assertEqual($aRow['requested_impressions'], 500);
        $this->assertEqual($aRow['priority'], 0.1);
        $this->assertEqual($aRow['priority_factor'], 0.2);
        $this->assertTrue($aRow['priority_factor_limited']);
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0.45);
        $this->assertEqual($aRow['created'], $oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['created_by'], 0);
        $this->assertNull($aRow['expired']);
        $this->assertNull($aRow['expired_by']);

        // Test 4
        $aData = array();
        for ($i = 1; $i < 5000; $i++) {
            $aData[$i] =
                array(
                    'ads' => array(
                        array(
                            'ad_id'                      => $i,
                            'zone_id'                    => $i,
                            'required_impressions'       => 2000,
                            'requested_impressions'      => 2000,
                            'priority'                   => 0.9,
                            'priority_factor'            => 0.1,
                            'priority_factor_limited'    => false,
                            'past_zone_traffic_fraction' => 0.99
                        )
                    )
                );
        }
        $oOldDate = new Date();
        $oOldDate->copy($oDate);
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result = $oMaxDalMaintenance->updatePriorities($aData);
        TestEnv::restoreEnv('dropTmpTables');
    }

    /**
     * A private method to generate data for testing.
     *
     * @access private
     */
    function _generateTestData()
    {
        $oNow = new Date();

        // Populate campaigns table
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Test Campaign';
        $doCampaigns->clientid = 1;
        $doCampaigns->views = 500;
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 401;
        $doCampaigns->expire = OA_Dal::noDateString();
        $doCampaigns->activate = OA_Dal::noDateString();
        $doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->priority = '4';
        $doCampaigns->weight = 2;
        $doCampaigns->target_impression = 0;
        $doCampaigns->anonymous = 'f';
        $doCampaigns->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $this->aIds['campaign'] = DataGenerator::generateOne($doCampaigns, true);

        // Add a banner
        $doBanners   = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$this->aIds['campaign'];
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $doBanners->contenttype = 'txt';
        $doBanners->pluginversion = 0;
        $doBanners->storagetype = 'txt';
        $doBanners->filename = '';
        $doBanners->imageurl = '';
        $doBanners->htmltemplate = '';
        $doBanners->htmlcache = '';
        $doBanners->width = 0;
        $doBanners->height = 0;
        $doBanners->weight = 1;
        $doBanners->seq = 0;
        $doBanners->target = '';
        $doBanners->url = 'http://www.example.com';
        $doBanners->alt = 'Test Campaign - Text Banner';
        $doBanners->statustext = '';
        $doBanners->bannerTEXT = '';
        $doBanners->description = '';
        $doBanners->autohtml = 'f';
        $doBanners->adserver = '';
        $doBanners->block = 0;
        $doBanners->capping = 0;
        $doBanners->session_capping = 0;
        $doBanners->compiledlimitation = 'phpAds_aclCheckDate(\'20050502\', \'!=\') and phpAds_aclCheckClientIP(\'2.22.22.2\', \'!=\') and phpAds_aclCheckLanguage(\'(sq)|(eu)|(fo)|(fi)\', \'!=\')';
        $doBanners->append = '';
        $doBanners->appendtype = 0;
        $doBanners->bannertype = 0;
        $doBanners->alt_filename = '';
        $doBanners->alt_imageurl = '';
        $doBanners->alt_contenttype = '';
        $doBanners->acls_updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $this->aIds['ad'] = DataGenerator::generateOne($doBanners);

        // Add an agency record
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Test Agency';
        $doAgency->contact = 'Test Contact';
        $doAgency->email = 'agency@example.com';
        $doAgency->username = 'Agency User Name';
        $doAgency->password = 'password';
        $doAgency->permissions = 0;
        $doAgency->language = 'en_GB';
        $doAgency->logout_url= 'logout.php';
        $doAgency->active = 1;
        $doAgency->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $this->aIds['agency'] = DataGenerator::generateOne($doAgency);

        // Add a client record (advertiser)
        $doClient = OA_Dal::factoryDO('clients');
        $doClient->agencyid = $this->aIds['agency'];
        $doClient->clientname = 'Test Client';
        $doClient->contact = 'yes';
        $doClient->email = 'client@example.com';
        $doClient->clientusername = 'Client User Name';
        $doClient->clientpassword = 'password';
        $doClient->permissions = 59;
        $doClient->language = '';
        $doClient->report = 't';
        $doClient->reportinterval = 7;
        $doClient->reportlastdate = '2005-03-21';
        $doClient->reportdeactivate = 't';
        $doClient->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $this->aIds['client'] = DataGenerator::generateOne($doClient);

        // Add an affiliate (publisher) record
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = $this->aIds['agency'];
        $doAffiliates->name = 'Test Publisher';
        $doAffiliates->mnemonic = 'ABC';
        $doAffiliates->contact = 'Affiliate Contact';
        $doAffiliates->email = 'affiliate@example.com';
        $doAffiliates->website = 'www.example.com';
        $doAffiliates->username = 'Affiliate User Name';
        $doAffiliates->password = 'password';
        $doAffiliates->permissions = null;
        $doAffiliates->language = null;
        $doAffiliates->publiczones = 'f';
        $doAffiliates->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $this->aIds['affiliate'] = DataGenerator::generateOne($doAffiliates);

        // Add zone record
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->affiliateid = $this->aIds['affiliate'];
        $doZones->zonename = 'Default Zone';
        $doZones->description = '';
        $doZones->delivery = 0;
        $doZones->zonetype =3;
        $doZones->category = '';
        $doZones->width = 728;
        $doZones->height = 90;
        $doZones->ad_selection = '';
        $doZones->chain = '';
        $doZones->prepend = '';
        $doZones->append = '';
        $doZones->appendtype = 0;
        $doZones->forceappend = 'f';
        $doZones->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $this->aIds['zone'] = DataGenerator::generateOne($doZones);

        // Add ad_zone_assoc record
        $doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZone->ad_id = $this->aIds['ad'];
        $doAdZone->zone_id = $this->aIds['zone'];
        $doAdZone->priority = 0;
        $doAdZone->link_type = 1;
        $doAdZone->priority_factor = 1;
        $doAdZone->to_be_delivered = 1;
        $this->aIds['ad_zone'] = DataGenerator::generateOne($doAdZone);
    }

}

?>