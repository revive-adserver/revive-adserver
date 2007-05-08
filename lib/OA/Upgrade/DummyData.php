<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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

/**
 * class to insert dummy data into clean database
 * uses DataGenerator
 */

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once MAX_PATH . '/lib/max/Dal/Common.php';

class OA_Dummy_Data
{
    var $agencyId;
    var $clientId;
    var $campaignId;
    var $channelId;

    var $zoneId1;
    var $zoneId2;

    var $bannerId1;
    var $bannerId2;
    var $bannerId3;
    var $bannerId4;
    var $bannerId5;

    function OA_Dummy_Data()
    {

    }

    function insert()
    {
        $this->insertAgency();
        $this->insertAffiliate();
        $this->insertClient();
        $this->insertZone1();
        $this->insertZone2();
        $this->insertBanner1();
        $this->insertBanner2();
        $this->insertBanner3();
        $this->insertBanner4();
        $this->insertBanner5();
        $this->insertCampaign();
        $this->insertAdZoneAssoc();
    }

    function insertAgency()
    {
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name    = 'Dummy Agency';
        $doAgency->contact    = '';                         // string(255)
        $doAgency->email    = '';                           // string(64)  not_null
        $doAgency->username    = '';                        // string(64)
        $doAgency->password    = '';                        // string(64)
        $doAgency->permissions    = '';                     // int(9)
        $doAgency->language    = '';                        // string(64)
        $doAgency->logout_url    = '';                      // string(255)
        $doAgency->active    = 't';
        $doAgency->updated    = date('Y-m-d h:i:s');
        $this->agencyId = DataGenerator::generateOne($doAgency);
    }

    function insertClient()
    {
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname          = 'Dummy Client';
        $doClients->acencyid            = $this->agencyId;
        $doClients->contact             = 'dummy contact details';
        $doClients->email               = 'dummyclient@example.com';
        $doClients->clientusername      = '';                  // string(64)  not_null
        $doClients->clientpassword      = '';                  // string(64)  not_null
        $doClients->permissions         = 0;
        $doClients->language            = '';
        $doClients->report              = 'f';
        $doClients->reportinterval      = 7;
        $doClients->reportlastdate      = date('Y-m-d');
        $doClients->reportdeactivate    = 't';
        $doClients->comments            = '';                  // blob(65535)  blob
        $doClients->updated             = date('Y-m-d h:i:s');
        $doClients->lb_reporting        = 0;
        $this->clientId = DataGenerator::generateOne($doClients);
    }

    function insertAffiliate()
    {
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->agencyid    = $this->agencyId;
        $doAffiliate->name    = 'Dummy Publisher';
        $doAffiliate->mnemonic    = '';                        // string(5)  not_null
        $doAffiliate->comments    = '';                        // blob(65535)  blob
        $doAffiliate->contact    = 'pubby';
        $doAffiliate->email    = 'pubby@example.com';
        $doAffiliate->website    = 'http://www.example.com';
        $doAffiliate->username    = '';                        // string(64)
        $doAffiliate->password    = '';                        // string(64)
        $doAffiliate->permissions    = '';                     // int(9)
        $doAffiliate->language    = '';                        // string(64)
        $doAffiliate->publiczones    = 't';
        $doAffiliate->last_accepted_agency_agreement    = '';
        $doAffiliate->updated   = date('Y-m-d h:i:s');
        $this->affiliateId = DataGenerator::generateOne($doAffiliate);
    }

    function insertZone1()
    {
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonename      = 'Dummy Publisher Default Zone 1';
        $doZones->affiliateid      = $this->affiliateId;
        $doZones->zonetype      = 3;
        $doZones->width         = 0;
        $doZones->height        = 0;
        $doZones->forceappend   = 'f';
        $doZones->updated       = date('Y-m-d h:i:s');
        $doZones->description    = 'Dummy Publisher Text Zone 1';
        $doZones->delivery    = '3';
//        $doZones->zonetype    = '';                       // int(6)  not_null
//        $doZones->category    = '';                       // blob(65535)  not_null blob
//        $doZones->ad_selection    = '';                   // blob(65535)  not_null blob
//        $doZones->chain    = '';                          // blob(65535)  not_null blob
//        $doZones->prepend    = '';                        // blob(65535)  not_null blob
//        $doZones->append    = '';                         // blob(65535)  not_null blob
        $doZones->appendtype    = '0';
//        $doZones->inventory_forecast_type    = '';         // int(6)  not_null
//        $doZones->comments    = '';                        // blob(65535)  blob
//        $doZones->cost    = '';                            // unknown(12)
//        $doZones->cost_type    = '';                       // int(6)
//        $doZones->cost_variable_id    = '';                // string(255)
//        $doZones->technology_cost    = '';                 // unknown(12)
//        $doZones->technology_cost_type    = '';            // int(6)
//        $doZones->block    = '';                           // int(11)  not_null
//        $doZones->capping    = '';                         // int(11)  not_null
//        $doZones->session_capping    = '';                 // int(11)  not_null
//        $doZones->what    = '';                           // blob(65535)  not_null blob
        $this->zoneId1 = DataGenerator::generateOne($doZones);
    }

    function insertZone2()
    {
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonename      = 'Dummy Publisher Default Zone 2';
        $doZones->affiliateid      = $this->affiliateId;
        $doZones->zonetype      = 3;
        $doZones->width         = 0;
        $doZones->height        = 0;
        $doZones->forceappend   = 'f';
        $doZones->updated       = date('Y-m-d h:i:s');
        $doZones->description    = 'Dummy Publisher Text Zone 2';
        $doZones->delivery    = '3';
//        $doZones->zonetype    = '';                       // int(6)  not_null
//        $doZones->category    = '';                       // blob(65535)  not_null blob
//        $doZones->ad_selection    = '';                   // blob(65535)  not_null blob
//        $doZones->chain    = '';                          // blob(65535)  not_null blob
//        $doZones->prepend    = '';                        // blob(65535)  not_null blob
//        $doZones->append    = '';                         // blob(65535)  not_null blob
        $doZones->appendtype    = '0';
//        $doZones->inventory_forecast_type    = '';         // int(6)  not_null
//        $doZones->comments    = '';                        // blob(65535)  blob
//        $doZones->cost    = '';                            // unknown(12)
//        $doZones->cost_type    = '';                       // int(6)
//        $doZones->cost_variable_id    = '';                // string(255)
//        $doZones->technology_cost    = '';                 // unknown(12)
//        $doZones->technology_cost_type    = '';            // int(6)
//        $doZones->block    = '';                           // int(11)  not_null
//        $doZones->capping    = '';                         // int(11)  not_null
//        $doZones->session_capping    = '';                 // int(11)  not_null
//        $doZones->what    = '';                           // blob(65535)  not_null blob
        $this->zoneId2 = DataGenerator::generateOne($doZones);
    }


    function insertCampaign()
    {
//        $doChannel = OA_Dal::factoryDO('channel');
//        $doChannel->acls_updated = date('Y-m-d h:i:s');
//        $this->channelId = DataGenerator::generateOne($doChannel);
//
//        $doTrackers = OA_Dal::factoryDO('trackers');
//        $doTrackers->clientid = $this->clientId;
//        $doTrackers->linkcampaigns = 't';
//        $aTrackerId = DataGenerator::generate($doTrackers, $numTrackers = 2);

//        $doTrackers = OA_Dal::factoryDO('trackers');
//        $doTrackers->linkcampaigns = 'f';
//        DataGenerator::generateOne($doTrackers); // redundant one

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid      = $this->clientId;
        $doCampaigns->campaignname  = 'Dummy Campaign';
//        $doCampaigns->views    = '';                           // int(11)
//        $doCampaigns->clicks    = '';                          // int(11)
//        $doCampaigns->conversions    = '';                     // int(11)
//        $doCampaigns->expire    = '';                          // date(10)  binary
//        $doCampaigns->activate    = '';                        // date(10)  binary
//        $doCampaigns->active    = '';                       // string(1)  not_null enum
//        $doCampaigns->priority    = '';                        // int(11)  not_null
//        $doCampaigns->weight    = '';                          // int(4)  not_null
//        $doCampaigns->target_impression    = '';               // int(11)  not_null
//        $doCampaigns->target_click    = '';                    // int(11)  not_null
//        $doCampaigns->target_conversion    = '';               // int(11)  not_null
//        $doCampaigns->anonymous    = '';                    // string(1)  not_null enum
//        $doCampaigns->companion    = '';                       // int(1)
//        $doCampaigns->comments    = '';                        // blob(65535)  blob
//        $doCampaigns->revenue    = '';                         // unknown(12)
//        $doCampaigns->revenue_type    = '';                    // int(6)
        $doCampaigns->updated    = date('Y-m-d h:i:s');
//        $doCampaigns->block    = '';                           // int(11)  not_null
//        $doCampaigns->capping    = '';                         // int(11)  not_null
//        $doCampaigns->session_capping    = '';                 // int(11)  not_null
        $this->campaignId = DataGenerator::generateOne($doCampaigns);
    }

    function insertAdZoneAssoc()
    {
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_id = $this->bannerId1;
        $doAdZoneAssoc->zone_id = $this->zoneId1;

        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_id = $this->bannerId2;
        $doAdZoneAssoc->zone_id = $this->zoneId1;
    }

    function insertBanner1()
    {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = date('Y-m-d h:i:s');
        $doBanners->updated    = date('Y-m-d h:i:s');
        $doBanners->campaignid      = $this->campaignId;
        $doBanners->active          = 't';
        $doBanners->contenttype    = 'txt';
        $doBanners->pluginversion    = '0';                   // int(9)  not_null
        $doBanners->storagetype    = 'txt';
//        $doBanners->filename    = '';                        // string(255)  not_null
//        $doBanners->imageurl    = '';                        // string(255)  not_null
//        $doBanners->htmltemplate    = '';                 // blob(65535)  not_null blob
//        $doBanners->htmlcache    = '';                    // blob(65535)  not_null blob
//        $doBanners->width    = '';                           // int(6)  not_null
//        $doBanners->height    = '';                          // int(6)  not_null
//        $doBanners->weight    = '';                          // int(4)  not_null
//        $doBanners->seq    = '';                             // int(4)  not_null
        $doBanners->target    = '_blank';
        $doBanners->url    = 'http://destination.example.com';
        $doBanners->alt    = 'Dummy Alt Text';
//        $doBanners->status    = '';                          // string(255)  not_null
        $doBanners->bannertext    = 'Dummy Text Ad';
        $doBanners->description    = 'Dummy Banner Text Ad';
//        $doBanners->autohtml    = '';                       // string(1)  not_null enum
//        $doBanners->adserver    = '';                        // string(50)  not_null
//        $doBanners->block    = '';                           // int(11)  not_null
//        $doBanners->capping    = '';                         // int(11)  not_null
//        $doBanners->session_capping    = '';                 // int(11)  not_null
//        $doBanners->compiledlimitation    = '';           // blob(65535)  not_null blob
//        $doBanners->acl_plugins    = '';                     // blob(65535)  blob
//        $doBanners->append    = '';                      // blob(65535)  not_null blob
//        $doBanners->appendtype    = '';                      // int(4)  not_null
//        $doBanners->bannertype    = '';                      // int(4)  not_null
//        $doBanners->alt_filename    = '';                    // string(255)  not_null
//        $doBanners->alt_imageurl    = '';                    // string(255)  not_null
//        $doBanners->alt_contenttype    = '';                // string(4)  not_null enum
//        $doBanners->comments    = '';                        // blob(65535)  blob
//        $doBanners->keyword    = '';                         // string(255)  not_null
//        $doBanners->transparent    = '';                     // int(1)  not_null
//        $doBanners->parameters    = '';                      // blob(65535)  blob
        $this->bannerId1 = DataGenerator::generateOne($doBanners);
    }

    function insertBanner2()
    {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = date('Y-m-d h:i:s');
        $doBanners->updated    = date('Y-m-d h:i:s');
        $doBanners->campaignid      = $this->campaignId;
        $doBanners->active          = 't';
        $doBanners->contenttype    = 'txt';
        $doBanners->pluginversion    = '0';                   // int(9)  not_null
        $doBanners->storagetype    = 'txt';
//        $doBanners->filename    = '';                        // string(255)  not_null
//        $doBanners->imageurl    = '';                        // string(255)  not_null
//        $doBanners->htmltemplate    = '';                 // blob(65535)  not_null blob
//        $doBanners->htmlcache    = '';                    // blob(65535)  not_null blob
//        $doBanners->width    = '';                           // int(6)  not_null
//        $doBanners->height    = '';                          // int(6)  not_null
//        $doBanners->weight    = '';                          // int(4)  not_null
//        $doBanners->seq    = '';                             // int(4)  not_null
        $doBanners->target    = '_blank';
        $doBanners->url    = 'http://destination.example.com';
        $doBanners->alt    = 'Dummy Alt Text';
//        $doBanners->status    = '';                          // string(255)  not_null
        $doBanners->bannertext    = 'Dummy Text Ad';
        $doBanners->description    = 'Dummy Banner Text Ad';
//        $doBanners->autohtml    = '';                       // string(1)  not_null enum
//        $doBanners->adserver    = '';                        // string(50)  not_null
//        $doBanners->block    = '';                           // int(11)  not_null
//        $doBanners->capping    = '';                         // int(11)  not_null
//        $doBanners->session_capping    = '';                 // int(11)  not_null
//        $doBanners->compiledlimitation    = '';           // blob(65535)  not_null blob
//        $doBanners->acl_plugins    = '';                     // blob(65535)  blob
//        $doBanners->append    = '';                      // blob(65535)  not_null blob
//        $doBanners->appendtype    = '';                      // int(4)  not_null
//        $doBanners->bannertype    = '';                      // int(4)  not_null
//        $doBanners->alt_filename    = '';                    // string(255)  not_null
//        $doBanners->alt_imageurl    = '';                    // string(255)  not_null
//        $doBanners->alt_contenttype    = '';                // string(4)  not_null enum
//        $doBanners->comments    = '';                        // blob(65535)  blob
//        $doBanners->keyword    = '';                         // string(255)  not_null
//        $doBanners->transparent    = '';                     // int(1)  not_null
//        $doBanners->parameters    = '';                      // blob(65535)  blob
        $this->bannerId2 = DataGenerator::generateOne($doBanners);
    }

}    function insertBanner3()
    {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = date('Y-m-d h:i:s');
        $doBanners->updated    = date('Y-m-d h:i:s');
        $doBanners->campaignid      = $this->campaignId;
        $doBanners->active          = 't';
        $doBanners->contenttype    = 'txt';
        $doBanners->pluginversion    = '0';                   // int(9)  not_null
        $doBanners->storagetype    = 'txt';
//        $doBanners->filename    = '';                        // string(255)  not_null
//        $doBanners->imageurl    = '';                        // string(255)  not_null
//        $doBanners->htmltemplate    = '';                 // blob(65535)  not_null blob
//        $doBanners->htmlcache    = '';                    // blob(65535)  not_null blob
//        $doBanners->width    = '';                           // int(6)  not_null
//        $doBanners->height    = '';                          // int(6)  not_null
//        $doBanners->weight    = '';                          // int(4)  not_null
//        $doBanners->seq    = '';                             // int(4)  not_null
        $doBanners->target    = '_blank';
        $doBanners->url    = 'http://destination.example.com';
        $doBanners->alt    = 'Dummy Alt Text';
//        $doBanners->status    = '';                          // string(255)  not_null
        $doBanners->bannertext    = 'Dummy Text Ad';
        $doBanners->description    = 'Dummy Banner Text Ad';
//        $doBanners->autohtml    = '';                       // string(1)  not_null enum
//        $doBanners->adserver    = '';                        // string(50)  not_null
//        $doBanners->block    = '';                           // int(11)  not_null
//        $doBanners->capping    = '';                         // int(11)  not_null
//        $doBanners->session_capping    = '';                 // int(11)  not_null
//        $doBanners->compiledlimitation    = '';           // blob(65535)  not_null blob
//        $doBanners->acl_plugins    = '';                     // blob(65535)  blob
//        $doBanners->append    = '';                      // blob(65535)  not_null blob
//        $doBanners->appendtype    = '';                      // int(4)  not_null
//        $doBanners->bannertype    = '';                      // int(4)  not_null
//        $doBanners->alt_filename    = '';                    // string(255)  not_null
//        $doBanners->alt_imageurl    = '';                    // string(255)  not_null
//        $doBanners->alt_contenttype    = '';                // string(4)  not_null enum
//        $doBanners->comments    = '';                        // blob(65535)  blob
//        $doBanners->keyword    = '';                         // string(255)  not_null
//        $doBanners->transparent    = '';                     // int(1)  not_null
//        $doBanners->parameters    = '';                      // blob(65535)  blob
        $this->bannerId3 = DataGenerator::generateOne($doBanners);
    }
    function insertBanner4()
    {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = date('Y-m-d h:i:s');
        $doBanners->updated    = date('Y-m-d h:i:s');
        $doBanners->campaignid      = $this->campaignId;
        $doBanners->active          = 't';
        $doBanners->contenttype    = 'txt';
        $doBanners->pluginversion    = '0';                   // int(9)  not_null
        $doBanners->storagetype    = 'txt';
//        $doBanners->filename    = '';                        // string(255)  not_null
//        $doBanners->imageurl    = '';                        // string(255)  not_null
//        $doBanners->htmltemplate    = '';                 // blob(65535)  not_null blob
//        $doBanners->htmlcache    = '';                    // blob(65535)  not_null blob
//        $doBanners->width    = '';                           // int(6)  not_null
//        $doBanners->height    = '';                          // int(6)  not_null
//        $doBanners->weight    = '';                          // int(4)  not_null
//        $doBanners->seq    = '';                             // int(4)  not_null
        $doBanners->target    = '_blank';
        $doBanners->url    = 'http://destination.example.com';
        $doBanners->alt    = 'Dummy Alt Text';
//        $doBanners->status    = '';                          // string(255)  not_null
        $doBanners->bannertext    = 'Dummy Text Ad';
        $doBanners->description    = 'Dummy Banner Text Ad';
//        $doBanners->autohtml    = '';                       // string(1)  not_null enum
//        $doBanners->adserver    = '';                        // string(50)  not_null
//        $doBanners->block    = '';                           // int(11)  not_null
//        $doBanners->capping    = '';                         // int(11)  not_null
//        $doBanners->session_capping    = '';                 // int(11)  not_null
//        $doBanners->compiledlimitation    = '';           // blob(65535)  not_null blob
//        $doBanners->acl_plugins    = '';                     // blob(65535)  blob
//        $doBanners->append    = '';                      // blob(65535)  not_null blob
//        $doBanners->appendtype    = '';                      // int(4)  not_null
//        $doBanners->bannertype    = '';                      // int(4)  not_null
//        $doBanners->alt_filename    = '';                    // string(255)  not_null
//        $doBanners->alt_imageurl    = '';                    // string(255)  not_null
//        $doBanners->alt_contenttype    = '';                // string(4)  not_null enum
//        $doBanners->comments    = '';                        // blob(65535)  blob
//        $doBanners->keyword    = '';                         // string(255)  not_null
//        $doBanners->transparent    = '';                     // int(1)  not_null
//        $doBanners->parameters    = '';                      // blob(65535)  blob
        $this->bannerId4 = DataGenerator::generateOne($doBanners);
    }
    function insertBanner5()
    {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = date('Y-m-d h:i:s');
        $doBanners->updated    = date('Y-m-d h:i:s');
        $doBanners->campaignid      = $this->campaignId;
        $doBanners->active          = 't';
        $doBanners->contenttype    = 'txt';
        $doBanners->pluginversion    = '0';                   // int(9)  not_null
        $doBanners->storagetype    = 'txt';
//        $doBanners->filename    = '';                        // string(255)  not_null
//        $doBanners->imageurl    = '';                        // string(255)  not_null
//        $doBanners->htmltemplate    = '';                 // blob(65535)  not_null blob
//        $doBanners->htmlcache    = '';                    // blob(65535)  not_null blob
//        $doBanners->width    = '';                           // int(6)  not_null
//        $doBanners->height    = '';                          // int(6)  not_null
//        $doBanners->weight    = '';                          // int(4)  not_null
//        $doBanners->seq    = '';                             // int(4)  not_null
        $doBanners->target    = '_blank';
        $doBanners->url    = 'http://destination.example.com';
        $doBanners->alt    = 'Dummy Alt Text';
//        $doBanners->status    = '';                          // string(255)  not_null
        $doBanners->bannertext    = 'Dummy Text Ad';
        $doBanners->description    = 'Dummy Banner Text Ad';
//        $doBanners->autohtml    = '';                       // string(1)  not_null enum
//        $doBanners->adserver    = '';                        // string(50)  not_null
//        $doBanners->block    = '';                           // int(11)  not_null
//        $doBanners->capping    = '';                         // int(11)  not_null
//        $doBanners->session_capping    = '';                 // int(11)  not_null
//        $doBanners->compiledlimitation    = '';           // blob(65535)  not_null blob
//        $doBanners->acl_plugins    = '';                     // blob(65535)  blob
//        $doBanners->append    = '';                      // blob(65535)  not_null blob
//        $doBanners->appendtype    = '';                      // int(4)  not_null
//        $doBanners->bannertype    = '';                      // int(4)  not_null
//        $doBanners->alt_filename    = '';                    // string(255)  not_null
//        $doBanners->alt_imageurl    = '';                    // string(255)  not_null
//        $doBanners->alt_contenttype    = '';                // string(4)  not_null enum
//        $doBanners->comments    = '';                        // blob(65535)  blob
//        $doBanners->keyword    = '';                         // string(255)  not_null
//        $doBanners->transparent    = '';                     // int(1)  not_null
//        $doBanners->parameters    = '';                      // blob(65535)  blob
        $this->bannerId5 = DataGenerator::generateOne($doBanners);
    }


?>