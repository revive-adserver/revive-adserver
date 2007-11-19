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
$Id $
*/

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 *
 * @abstract A base class for generating Openads test data using DataObjects
 * @package Test Classes
 * @author Monique Szpak <monique.szpak@openads.org>
 * @todo more _insert methods
 *
 */
class OA_Test_Data
{

    var $oDbh;
    var $oNow;

    var $doAgency;
    var $doClients;
    var $doAffiliates;
    var $doCampaigns;
    var $doBanners;
    var $doZones;
    var $doAdZoneAssoc;

    var $doAcls;
    var $doAclsChannel;
    var $doCampaignsTrackers;
    var $doChannel;
    var $doTrackers;
    var $doPreference;
    var $doVariables;


    var $aIds = array(
                        'agency'=>array(),
                        'clients'=>array(),
                        'affiliates'=>array(),
                        'campaigns'=>array(),
                        'banners'=>array(),
                        'zones'=>array(),
                        'ad_zone_assoc'=>array(),
                        'acls'=>array(),
                        'acls_channel'=>array(),
                        'campaigns_trackers'=>array(),
                        'channel'=>array(),
                        'trackers'=>array(),
                        'variables'=>array(),
                        'preference'=>array(),
                      );


    /**
     * The constructor method.
     */
    function OA_Test_Data()
    {
        $this->init();
    }

    function init()
    {
        $this->oDbh =& OA_DB::singleton();

        $this->oNow = new Date();

        $this->doAgency             = OA_Dal::factoryDO('agency');
        $this->doClients            = OA_Dal::factoryDO('clients');
        $this->doAffiliates         = OA_Dal::factoryDO('affiliates');
        $this->doCampaigns          = OA_Dal::factoryDO('campaigns');
        $this->doBanners            = OA_Dal::factoryDO('banners');
        $this->doZones              = OA_Dal::factoryDO('zones');
        $this->doAdZoneAssoc        = OA_Dal::factoryDO('ad_zone_assoc');

        $this->doAcls               = OA_Dal::factoryDO('acls');
        $this->doAclsChannel        = OA_Dal::factoryDO('acls_channel');
        $this->doCampaignsTrackers  = OA_Dal::factoryDO('campaigns_trackers');
        $this->doChannel            = OA_Dal::factoryDO('channel');
        $this->doTrackers           = OA_Dal::factoryDO('trackers');
        $this->doPreference         = OA_Dal::factoryDO('preference');
        $this->doVariables          = OA_Dal::factoryDO('variables');

    }

    function _insertAgency($aData)
    {
        $this->doAgency->name = 'Test Agency';
        $this->doAgency->contact = 'Test Contact';
        $this->doAgency->email = 'agency@example.com';
        $this->doAgency->username = 'Agency User Name';
        $this->doAgency->password = 'password';
        $this->doAgency->permissions = 0;
        $this->doAgency->language = 'en_GB';
        $this->doAgency->logout_url= 'logout.php';
        $this->doAgency->active = 1;
        $this->doAgency->updated = $this->oNow->format('%Y-%m-%d %H:%M:%S');
        foreach ($aData AS $key => $val)
        {
            $this->doAgency->$key = $val;
        }
        $this->doAgency->agencyid = '';
        return $this->aIds['agency'][] = DataGenerator::generateOne($this->doAgency);
    }

    function _insertClients($aData)
    {
        $this->doClients->agencyid=0;
        $this->doClients->clientname='Test Advertiser';
        $this->doClients->contact='Test Contact';
        $this->doClients->email='test1@example.com';
        $this->doClients->clientusername='';
        $this->doClients->clientpassword='';
        $this->doClients->permissions=0;
        $this->doClients->language='';
        $this->doClients->report='t';
        $this->doClients->reportinterval=7;
        $this->doClients->reportlastdate='2004-11-26';
        $this->doClients->reportdeactivate='t';
        foreach ($aData AS $key => $val)
        {
            $this->doClients->$key = $val;
        }
        $this->doClients->clientid='';
        return $this->aIds['clients'][] = DataGenerator::generateOne($this->doClients);
    }

    function _insertAffiliates($aData)
    {
        $this->doAffiliates->name = 'Test Publisher';
        $this->doAffiliates->mnemonic = 'ABC';
        $this->doAffiliates->contact = 'Affiliate Contact';
        $this->doAffiliates->email = 'affiliate@example.com';
        $this->doAffiliates->website = 'www.example.com';
        $this->doAffiliates->username = 'Affiliate User Name';
        $this->doAffiliates->password = 'password';
        $this->doAffiliates->permissions = null;
        $this->doAffiliates->language = null;
        $this->doAffiliates->publiczones = 'f';
        $this->doAffiliates->updated = $this->oNow->format('%Y-%m-%d %H:%M:%S');
        foreach ($aData AS $key => $val)
        {
            $this->doAffiliates->$key = $val;
        }
        $this->doAffiliates->affiliateid = '';
        return $this->aIds['affiliate'][] = DataGenerator::generateOne($this->doAffiliates);

    }

    function _insertCampaigns($aData)
    {
        $this->doCampaigns->campaignname = 'Test Advertiser - Default Campaign';
        $this->doCampaigns->views = -1;
        $this->doCampaigns->clicks = -1;
        $this->doCampaigns->conversions = -1;
        $this->doCampaigns->expire = OA_Dal::noDateValue();
        $this->doCampaigns->activate = OA_Dal::noDateValue();
        $this->doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $this->doCampaigns->priority = 'l';
        $this->doCampaigns->weight = 1;
        $this->doCampaigns->target_impression = 1;
        $this->doCampaigns->target_click = 0;
        $this->doCampaigns->target_conversion = 0;
        $this->doCampaigns->anonymous = 'f';
        $this->doCampaigns->companion = 0;
        $this->doCampaigns->updated = null;
        foreach ($aData AS $key => $val)
        {
            $this->doCampaigns->$key = $val;
        }
        $this->doCampaigns->campaignid = '';
        return $this->aIds['campaigns'][] = DataGenerator::generateOne($this->doCampaigns);
    }

    function _insertBanners($aData)
    {
        $this->doBanners->status=OA_ENTITY_STATUS_RUNNING;
        $this->doBanners->contenttype='';
        $this->doBanners->pluginversion=0;
        $this->doBanners->storagetype='html';
        $this->doBanners->filename='';
        $this->doBanners->imageurl='';
        $this->doBanners->htmltemplate='<h3>Test Banner</h3>';
        $this->doBanners->htmlcache='<h3>Test Banner</h3>';
        $this->doBanners->width=0;
        $this->doBanners->height=0;
        $this->doBanners->weight=1;
        $this->doBanners->seq=0;
        $this->doBanners->target='';
        $this->doBanners->url='http://example.com/';
        $this->doBanners->alt='';
        $this->doBanners->statustext='';
        $this->doBanners->bannertext='';
        $this->doBanners->description='Banner';
        $this->doBanners->autohtml='t';
        $this->doBanners->adserver='';
        $this->doBanners->block=0;
        $this->doBanners->capping=0;
        $this->doBanners->session_capping=0;
        $this->doBanners->compiledlimitation='';
        $this->doBanners->append='';
        $this->doBanners->appendtype=0;
        $this->doBanners->bannertype=0;
        $this->doBanners->alt_filename='';
        $this->doBanners->alt_imageurl='';
        $this->doBanners->alt_contenttype='';
        $this->doBanners->bannerid='t';
        foreach ($aData AS $key => $val)
        {
            $this->doBanners->$key = $val;
        }
        return $this->aIds['banners'][] = DataGenerator::generateOne($this->doBanners);
    }

    function _insertZones($aData)
    {
        $this->doZones->description='';
        $this->doZones->delivery=0;
        $this->doZones->zonetype=3;
        $this->doZones->category='';
        $this->doZones->width=-1;
        $this->doZones->height=-1;
        $this->doZones->ad_selection='';
        $this->doZones->chain='';
        $this->doZones->prepend='';
        $this->doZones->append='';
        $this->doZones->appendtype=0;
        $this->doZones->inventory_forecast_type=0;
        $this->doZones->what='';
        foreach ($aData AS $key => $val)
        {
            $this->doZones->$key = $val;
        }
        $this->doZones->zoneid='';
        return $this->aIds['zones'][] = DataGenerator::generateOne($this->doZones);
    }

    function _insertAdZoneAssoc($aData)
    {
        $this->doAdZoneAssoc->priority = 0;
        $this->doAdZoneAssoc->link_type = 1;
        $this->doAdZoneAssoc->priority_factor = 1;
        $this->doAdZoneAssoc->to_be_delivered = 1;
        foreach ($aData AS $key => $val)
        {
            $this->doAdZoneAssoc->$key = $val;
        }
        $this->doAdZoneAssoc->ad_zone_assoc_id = 0;
        return $this->aIds['ad_zone'][] = DataGenerator::generateOne($this->doAdZoneAssoc);
    }

    function _insertCampaignsTracker($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doCampaignsTrackers->$key = $val;
        }
        return $this->aIds['campaigns_trackers'][] = DataGenerator::generateOne($this->doCampaignsTrackers);
    }

    function _insertAcls($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doAcls->$key = $val;
        }
        return $this->aIds['acls'][] = DataGenerator::generateOne($this->doAcls);
    }

    function _insertChannel($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doChannel->$key = $val;
        }
        return $this->aIds['channel'][] = DataGenerator::generateOne($this->doChannel);
    }

    function _insertAclsChannel($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doAclsChannel->$key = $val;
        }
        return $this->aIds['acls_channel'][] = DataGenerator::generateOne($this->doAclsChannel);
    }

    function _insertTrackers($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doTrackers->$key = $val;
        }
        return $this->aIds['trackers'][] = DataGenerator::generateOne($this->doTrackers);
    }

    function _insertVariables($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doVariables->$key = $val;
        }
        return $this->aIds['variables'][] = DataGenerator::generateOne($this->doVariables);
    }

    function _insertPreference($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doPreference->$key = $val;
        }
        return $this->aIds['preference'][] = DataGenerator::generateOne($this->doPreference);
    }

    /**
     * A method to generate data for testing.
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
    function generateTestData()
    {
        // Add an agency record
        $aAgency['name'] = 'Test Agency';
        $aAgency['contact'] = 'Test Contact';
        $aAgency['email'] = 'agency@example.com';
        $aAgency['username'] = 'Agency User Name';
        $aAgency['password'] = 'password';
        $aAgency['permissions'] = 0;
        $aAgency['language'] = 'en_GB';
        $aAgency['logout_url']= 'logout.php';
        $aAgency['active'] = 1;
        $idAgency = $this->_insertAgency($aAgency);


        // Add a client record (advertiser)
        $aClient['agencyid'] = $idAgency;
        $aClient['clientname'] = 'Test Client';
        $aClient['email'] = 'client@example.com';
        $aClient['clientusername'] = 'Client User Name';
        $idClient = $this->_insertClients($aClient);

        // Add an affiliate (publisher) record
        $aAffiliate['agencyid'] = $idAgency;
        $aAffiliate['name'] = 'Test Publisher';
        $aAffiliate['mnemonic'] = 'ABC';
        $aAffiliate['contact'] = 'Affiliate Contact';
        $aAffiliate['email'] = 'affiliate@example.com';
        $aAffiliate['website'] = 'www.example.com';
        $aAffiliate['username'] = 'Affiliate User Name';
        $idAffiliate = $this->_insertAffiliate($aAffiliate);


        // Populate campaigns table
        $aCampaign['campaignname'] = 'Test Campaign';
        $aCampaign['clientid'] = $idClient;
        $aCampaign['views'] = 500;
        $aCampaign['clicks'] = 0;
        $aCampaign['conversions'] = 401;
        $idCampaign = $this->_insertCampaign($aCampaign);

        // Add a banner
        $aBanners['campaignid'] = $idCampaign;
        $aBanners['contenttype'] = 'txt';
        $aBanners['storagetype'] = 'txt';
        $aBanners['url'] = 'http://www.example.com';
        $aBanners['alt'] = 'Test Campaign - Text Banner';
        $aBanners['compiledlimitation'] = 'phpAds_aclCheckDate(\'20050502\', \'!=\') and phpAds_aclCheckClientIP(\'2.22.22.2\', \'!=\') and phpAds_aclCheckLanguage(\'(sq)|(eu)|(fo)|(fi)\', \'!=\')';
        $idBanner = $this->_insertBanner($aBanners);

        // Add zone record
        $aZone['affiliateid'] = $idAffiliate;
        $aZone['zonename'] = 'Default Zone';
        $aZone['description'] = '';
        $aZone['delivery'] = 0;
        $aZone['zonetype'] =3;
        $aZone['category'] = '';
        $aZone['width'] = 728;
        $aZone['height'] = 90;
        $idZone = $this->_insertZone($aZone);

        // Add ad_zone_assoc record
        $aAdZone['ad_id'] = $idBanner;
        $aAdZone['zone_id'] = $idZone;
        $idAdZone = $this->_insertAdZoneAssoc($aAdZone);
    }
}

?>
