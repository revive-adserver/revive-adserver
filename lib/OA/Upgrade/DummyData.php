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

class OA_Dummy_Data
{
    var $clientId;
    var $campaignId;
    var $channelId;
    var $zoneId;
    var $bannerId;
    var $agencyId = 0;

    function OA_Dummy_Data()
    {

    }

    function insert()
    {
        $this->insertClient();
        $this->insertZone();
        $this->insertBanner();
        $this->insertCampaign();
        $this->insertAdZoneAssoc();
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
        $doClients->permissions         = 0;                   // int(9)
        $doClients->language            = '';                  // string(64)
        $doClients->report              = 'f';                 // string(1)  not_null enum
        $doClients->reportinterval      = 7;                   // int(9)  not_null
        $doClients->reportlastdate      = date('Y-m-d');       // date(10)  not_null binary
        $doClients->reportdeactivate    = 't';                 // string(1)  not_null enum
        $doClients->comments            = '';                  // blob(65535)  blob
        $doClients->updated             = date('Y-m-d h:i:s'); // datetime(19)  not_null binary
        $doClients->lb_reporting        = 0;                   // int(1)  not_null
        $this->clientId = DataGenerator::generateOne($doClients);
    }

    function insertZone()
    {
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonename      = 'Dummy Zone';
        $doZones->zonetype      = 3;
        $doZones->width         = 468;
        $doZones->height        = 60;
        $doZones->forceappend   = 'f';
        $doZones->updated       = date('Y-m-d h:i:s');
//        $doZones->affiliateid    = '';                     // int(9)  multiple_key
//        $doZones->description    = '';                     // string(255)  not_null
//        $doZones->delivery    = '';                        // int(6)  not_null
//        $doZones->zonetype    = '';                        // int(6)  not_null
//        $doZones->category    = '';                        // blob(65535)  not_null blob
//        $doZones->ad_selection    = '';                    // blob(65535)  not_null blob
//        $doZones->chain    = '';                           // blob(65535)  not_null blob
//        $doZones->prepend    = '';                         // blob(65535)  not_null blob
//        $doZones->append    = '';                          // blob(65535)  not_null blob
//        $doZones->appendtype    = '';                      // int(4)  not_null
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
//        $doZones->what    = '';                            // blob(65535)  not_null blob
        $this->zoneId = DataGenerator::generateOne($doZones);
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
//        $doCampaigns->active    = '';                          // string(1)  not_null enum
//        $doCampaigns->priority    = '';                        // int(11)  not_null
//        $doCampaigns->weight    = '';                          // int(4)  not_null
//        $doCampaigns->target_impression    = '';               // int(11)  not_null
//        $doCampaigns->target_click    = '';                    // int(11)  not_null
//        $doCampaigns->target_conversion    = '';               // int(11)  not_null
//        $doCampaigns->anonymous    = '';                       // string(1)  not_null enum
//        $doCampaigns->companion    = '';                       // int(1)
//        $doCampaigns->comments    = '';                        // blob(65535)  blob
//        $doCampaigns->revenue    = '';                         // unknown(12)
//        $doCampaigns->revenue_type    = '';                    // int(6)
//        $doCampaigns->updated    = '';                         // datetime(19)  not_null binary
//        $doCampaigns->block    = '';                           // int(11)  not_null
//        $doCampaigns->capping    = '';                         // int(11)  not_null
//        $doCampaigns->session_capping    = '';                 // int(11)  not_null

        $this->campaignId = DataGenerator::generateOne($doCampaigns);
    }

    function insertBanner()
    {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = date('Y-m-d h:i:s');
        $doBanners->campaignid      = $this->campaignId;
        $doBanners->active          = 't';                          // string(1)  not_null enum
//        $doBanners->contenttype    = '';                     // string(4)  not_null enum
//        $doBanners->pluginversion    = '';                   // int(9)  not_null
//        $doBanners->storagetype    = '';                     // string(7)  not_null enum
//        $doBanners->filename    = '';                        // string(255)  not_null
//        $doBanners->imageurl    = '';                        // string(255)  not_null
//        $doBanners->htmltemplate    = '';                    // blob(65535)  not_null blob
//        $doBanners->htmlcache    = '';                       // blob(65535)  not_null blob
//        $doBanners->width    = '';                           // int(6)  not_null
//        $doBanners->height    = '';                          // int(6)  not_null
//        $doBanners->weight    = '';                          // int(4)  not_null
//        $doBanners->seq    = '';                             // int(4)  not_null
//        $doBanners->target    = '';                          // string(16)  not_null
//        $doBanners->url    = '';                             // blob(65535)  not_null blob
//        $doBanners->alt    = '';                             // string(255)  not_null
//        $doBanners->status    = '';                          // string(255)  not_null
//        $doBanners->bannertext    = '';                      // blob(65535)  not_null blob
//        $doBanners->description    = '';                     // string(255)  not_null
//        $doBanners->autohtml    = '';                        // string(1)  not_null enum
//        $doBanners->adserver    = '';                        // string(50)  not_null
//        $doBanners->block    = '';                           // int(11)  not_null
//        $doBanners->capping    = '';                         // int(11)  not_null
//        $doBanners->session_capping    = '';                 // int(11)  not_null
//        $doBanners->compiledlimitation    = '';              // blob(65535)  not_null blob
//        $doBanners->acl_plugins    = '';                     // blob(65535)  blob
//        $doBanners->append    = '';                          // blob(65535)  not_null blob
//        $doBanners->appendtype    = '';                      // int(4)  not_null
//        $doBanners->bannertype    = '';                      // int(4)  not_null
//        $doBanners->alt_filename    = '';                    // string(255)  not_null
//        $doBanners->alt_imageurl    = '';                    // string(255)  not_null
//        $doBanners->alt_contenttype    = '';                 // string(4)  not_null enum
//        $doBanners->comments    = '';                        // blob(65535)  blob
//        $doBanners->updated    = '';                         // datetime(19)  not_null binary
//        $doBanners->acls_updated    = '';                    // datetime(19)  not_null binary
//        $doBanners->keyword    = '';                         // string(255)  not_null
//        $doBanners->transparent    = '';                     // int(1)  not_null
//        $doBanners->parameters    = '';                      // blob(65535)  blob
        $this->bannerId = DataGenerator::generateOne($doBanners);
    }

    function insertAdZoneAssoc()
    {
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_id = $this->bannerId;
        $doAdZoneAssoc->zone_id = $this->zoneId;
    }

}

?>