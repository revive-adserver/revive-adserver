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

require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once MAX_PATH . '/tests/testClasses/OATestData.php';

/**
 * A base class for generating test data using DataObjects.
 *
 * @package Test Classes
 * @todo more _insert methods
 */
class OA_Test_Data_DataObjects extends OA_Test_Data
{
    public $doAgency;
    public $doClients;
    public $doAffiliates;
    public $doCampaigns;
    public $doBanners;
    public $doZones;
    public $doAdZoneAssoc;

    public $doAcls;
    public $doAclsChannel;
    public $doCampaignsTrackers;
    public $doChannel;
    public $doTrackers;
    public $doVariables;


    /**
     * instantiate the dataobjects
     *
     * @return boolean
     */
    public function init()
    {
        if (!parent::init()) {
            return false;
        }
        $this->doAgency                     = OA_Dal::factoryDO('agency');
        $this->doPreferences                = OA_Dal::factoryDO('preferences');
        $this->doAccount_preference_assoc   = OA_Dal::factoryDO('account_preference_assoc');

        $this->doClients                    = OA_Dal::factoryDO('clients');
        $this->doAffiliates                 = OA_Dal::factoryDO('affiliates');
        $this->doCampaigns                  = OA_Dal::factoryDO('campaigns');
        $this->doBanners                    = OA_Dal::factoryDO('banners');
        $this->doZones                      = OA_Dal::factoryDO('zones');
        $this->doAdZoneAssoc                = OA_Dal::factoryDO('ad_zone_assoc');

        $this->doAcls                       = OA_Dal::factoryDO('acls');
        $this->doAclsChannel                = OA_Dal::factoryDO('acls_channel');
        $this->doCampaignsTrackers          = OA_Dal::factoryDO('campaigns_trackers');
        $this->doChannel                    = OA_Dal::factoryDO('channel');
        $this->doTrackers                   = OA_Dal::factoryDO('trackers');
        $this->doVariables                  = OA_Dal::factoryDO('variables');
        return true;
    }

    /**
     * demonstration / default
     *
     * A method to generate data for testing.
     * can be overriden by child clases
     *
     * insertion order is important
     *
     * agency
     * client
     * affiliate
     * campaign
     * banner
     * zone
     * ad_zone_assoc
     *
     * @access private
     */
    public function generateTestData($linkAdZone = false)
    {
        if (!parent::init()) {
            return false;
        }

        // Add an agency record
        $aAgency['name'] = 'Test Agency';
        $aAgency['contact'] = 'Test Contact';
        $aAgency['email'] = 'agency@example.com';
        $this->aIds['agency'][1] = $this->_insertAgency($aAgency);

        // Add a client record (advertiser)
        $aClient['agencyid'] = $this->aIds['agency'][1];
        $aClient['clientname'] = 'Test Client';
        $aClient['email'] = 'client@example.com';
        $this->aIds['clients'][1] = $this->_insertClients($aClient);

        // Add an affiliate (publisher) record
        $aAffiliate['agencyid'] = $this->aIds['agency'][1];
        $aAffiliate['name'] = 'Test Publisher';
        $aAffiliate['mnemonic'] = 'ABC';
        $aAffiliate['contact'] = 'Affiliate Contact';
        $aAffiliate['email'] = 'affiliate@example.com';
        $aAffiliate['website'] = 'www.example.com';
        $this->aIds['affiliates'][1] = $this->_insertAffiliates($aAffiliate);

        // Populate campaigns table
        $aCampaign['campaignname'] = 'Test Campaign';
        $aCampaign['clientid'] = $this->aIds['clients'][1];
        $aCampaign['views'] = 500;
        $aCampaign['clicks'] = 0;
        $aCampaign['conversions'] = 401;
        $this->aIds['campaigns'][1] = $this->_insertCampaigns($aCampaign);

        // Add a text banner
        $aBanners['campaignid'] = $this->aIds['campaigns'][1];
        $aBanners['contenttype'] = 'txt';
        $aBanners['storagetype'] = 'txt';
        $aBanners['width'] = 468;
        $aBanners['height'] = 60;
        $aBanners['url'] = 'http://www.example.com';
        $aBanners['alt'] = 'Test Campaign - Text Banner';
        $aBanners['compiledlimitation'] = 'phpAds_aclCheckDate(\'20050502\', \'!=\') and phpAds_aclCheckClientIP(\'2.22.22.2\', \'!=\') and phpAds_aclCheckLanguage(\'(sq)|(eu)|(fo)|(fi)\', \'!=\')';
        $this->aIds['banners'][1] = $this->_insertBanners($aBanners);

        //  Add a HTML banner
        $aBanners['campaignid'] = $this->aIds['campaigns'][1];
        $aBanners['storagetype'] = 'html';
        $aBanners['width'] = 468;
        $aBanners['height'] = 60;
        $aBanners['url'] = 'http://www.example.com';
        $aBanners['description'] = 'Test HTML Banner';
        $aBanners['htmltemplate'] = '<p>Hello OpenX!</p>';
        $aBanners['htmlcache'] = '<a href="{clickurl}" target="{target}"><h1>Hello OpenX!</h1></a>';
        $this->aIds['banners'][2] = $this->_insertBanners($aBanners);

        // Add zone record
        $aZone['affiliateid'] = $this->aIds['affiliates'][1];
        $aZone['zonename'] = 'Default Zone - Text';
        $aZone['description'] = '';
        $aZone['delivery'] = 3;
        $aZone['zonetype'] = 3;
        $aZone['category'] = '';
        $aZone['width'] = 468;
        $aZone['height'] = 60;
        $this->aIds['zones'][1] = $this->_insertZones($aZone);

        // Add zone record
        $aZone['affiliateid'] = $this->aIds['affiliates'][1];
        $aZone['zonename'] = 'Default Zone - Email/Newsletter';
        $aZone['description'] = '';
        $aZone['delivery'] = 4;
        $aZone['zonetype'] = 3;
        $aZone['category'] = '';
        $aZone['width'] = 468;
        $aZone['height'] = 60;
        $this->aIds['zones'][2] = $this->_insertZones($aZone);

        if ($linkAdZone) {
            $this->linkAdZone();
        }
        return true;
    }

    public function linkAdZone()
    {
        // Add ad_zone_assoc record
        $aAdZone['ad_id'] = $this->aIds['banners'][1];
        $aAdZone['zone_id'] = $this->aIds['zones'][1];
        $this->aIds['ad_zone_assoc'][1] = $this->_insertAdZoneAssoc($aAdZone);
    }

    public function _insertAgency($aData)
    {
        $this->doAgency->name = 'Test Agency';
        $this->doAgency->contact = 'Test Contact';
        $this->doAgency->email = 'agency@example.com';
        $this->doAgency->permissions = 0;
        $this->doAgency->agencyid = '';
        $this->doAgency->updated = $this->oNow->format('%Y-%m-%d %H:%M:%S');
        $this->doAgency->setFrom($aData);
        return DataGenerator::generateOne($this->doAgency);
    }

    public function _insertPreference($aData)
    {
        $this->doPreferences->preference_name = 'Test Preference';
        $this->doPreferences->account_type = 'ADMIN';
        $this->doPreferences->setFrom($aData);

        return DataGenerator::generateOne($this->doPreferences);
    }

    public function _insertAccountPreferenceAssoc($aData)
    {
        $this->doAccount_preference_assoc->value = 'value';
        $this->doAccount_preference_assoc->setFrom($aData);
        // setFrom will not overwrite fields which are defined as "keys"
        if (!empty($aData['account_id'])) {
            $this->doAccount_preference_assoc->account_id = $aData['account_id'];
        }
        if (!empty($aData['preference_id'])) {
            $this->doAccount_preference_assoc->preference_id = $aData['preference_id'];
        }

        return DataGenerator::generateOne($this->doAccount_preference_assoc);
    }

    public function _insertClients($aData)
    {
        $this->doClients->agencyid = 0;
        $this->doClients->clientname = 'Test Advertiser';
        $this->doClients->contact = 'Test Contact';
        $this->doClients->email = 'test1@example.com';
        $this->doClients->report = 't';
        $this->doClients->reportinterval = 7;
        $this->doClients->reportlastdate = '2004-11-26';
        $this->doClients->reportdeactivate = 't';
        $this->doClients->clientid = '';
        $this->doClients->updated = $this->oNow->format('%Y-%m-%d %H:%M:%S');
        $this->doClients->setFrom($aData);
        return DataGenerator::generateOne($this->doClients);
    }

    public function _insertAffiliates($aData)
    {
        $this->doAffiliates->name = 'Test Publisher';
        $this->doAffiliates->mnemonic = 'ABC';
        $this->doAffiliates->contact = 'Affiliate Contact';
        $this->doAffiliates->email = 'affiliate@example.com';
        $this->doAffiliates->website = 'www.example.com';
        $this->doAffiliates->updated = $this->oNow->format('%Y-%m-%d %H:%M:%S');
        $this->doAffiliates->setFrom($aData);
        return DataGenerator::generateOne($this->doAffiliates);
    }

    public function _insertCampaigns($aData)
    {
        $this->doCampaigns->campaignname = 'Test Advertiser - Default Campaign';
        $this->doCampaigns->views = -1;
        $this->doCampaigns->clicks = -1;
        $this->doCampaigns->conversions = -1;
        $this->doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $this->doCampaigns->priority = 'l';
        $this->doCampaigns->weight = 1;
        $this->doCampaigns->target_impression = 1;
        $this->doCampaigns->target_click = 0;
        $this->doCampaigns->target_conversion = 0;
        $this->doCampaigns->anonymous = 'f';
        $this->doCampaigns->companion = 0;
        $this->doCampaigns->updated = $this->oNow->format('%Y-%m-%d %H:%M:%S');
        $this->doCampaigns->setFrom($aData);
        return DataGenerator::generateOne($this->doCampaigns);
    }

    public function _insertBanners($aData)
    {
        $this->doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $this->doBanners->contenttype = '';
        $this->doBanners->pluginversion = 0;
        $this->doBanners->storagetype = 'html';
        $this->doBanners->filename = '';
        $this->doBanners->imageurl = '';
        $this->doBanners->htmltemplate = '<h3>Test Banner</h3>';
        $this->doBanners->htmlcache = '<h3>Test Banner</h3>';
        $this->doBanners->width = 0;
        $this->doBanners->height = 0;
        $this->doBanners->weight = 1;
        $this->doBanners->seq = 0;
        $this->doBanners->target = '';
        $this->doBanners->url = 'http://example.com/';
        $this->doBanners->alt = '';
        $this->doBanners->statustext = '';
        $this->doBanners->bannertext = '';
        $this->doBanners->description = 'Banner';
        $this->doBanners->adserver = '';
        $this->doBanners->block = 0;
        $this->doBanners->capping = 0;
        $this->doBanners->session_capping = 0;
        $this->doBanners->compiledlimitation = '';
        $this->doBanners->append = '';
        $this->doBanners->appendtype = 0;
        $this->doBanners->bannertype = 0;
        $this->doBanners->alt_filename = '';
        $this->doBanners->alt_imageurl = '';
        $this->doBanners->alt_contenttype = '';
        $this->doBanners->bannerid = 't';
        $this->doBanners->updated = $this->oNow->format('%Y-%m-%d %H:%M:%S');
        $this->doBanners->setFrom($aData);
        if (empty($this->doBanners->acls_updated)) {
            $this->doBanners->acls_updated = $this->oNow->format('%Y-%m-%d %H:%M:%S');
        }
        return DataGenerator::generateOne($this->doBanners);
    }

    public function _insertZones($aData)
    {
        $this->doZones->description = '';
        $this->doZones->delivery = 0;
        $this->doZones->zonetype = 3;
        $this->doZones->category = '';
        $this->doZones->width = -1;
        $this->doZones->height = -1;
        $this->doZones->ad_selection = '';
        $this->doZones->chain = '';
        $this->doZones->prepend = '';
        $this->doZones->append = '';
        $this->doZones->appendtype = 0;
        $this->doZones->inventory_forecast_type = 0;
        $this->doZones->what = '';
        $this->doZones->updated = $this->oNow->format('%Y-%m-%d %H:%M:%S');
        $this->doZones->setFrom($aData);
        return DataGenerator::generateOne($this->doZones);
    }

    public function _insertAdZoneAssoc($aData)
    {
        $this->doAdZoneAssoc->priority = 0;
        $this->doAdZoneAssoc->link_type = 1;
        $this->doAdZoneAssoc->priority_factor = 1;
        $this->doAdZoneAssoc->to_be_delivered = 1;
        $this->doAdZoneAssoc->setFrom($aData);
        return DataGenerator::generateOne($this->doAdZoneAssoc);
    }

    public function _insertCampaignsTracker($aData)
    {
        $this->doCampaignsTrackers->setFrom($aData);
        return DataGenerator::generateOne($this->doCampaignsTrackers);
    }

    public function _insertAcls($aData)
    {
        $this->doAcls->setFrom($aData);
        return DataGenerator::generateOne($this->doAcls);
    }

    public function _insertChannel($aData)
    {
        $this->doChannel->acls_updated = $this->oNow->format('%Y-%m-%d %H:%M:%S');
        $this->doChannel->setFrom($aData);
        return DataGenerator::generateOne($this->doChannel);
    }

    public function _insertAclsChannel($aData)
    {
        $this->doAclsChannel->setFrom($aData);
        return DataGenerator::generateOne($this->doAclsChannel);
    }

    public function _insertTrackers($aData)
    {
        $this->doTrackers->setFrom($aData);
        return DataGenerator::generateOne($this->doTrackers);
    }

    public function _insertVariables($aData)
    {
        $this->doVariables->setFrom($aData);
        return DataGenerator::generateOne($this->doVariables);
    }
}
