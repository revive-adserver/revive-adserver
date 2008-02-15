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

/**
 * class to insert test dummy data into clean database
 * uses DataGenerator
 */

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

class Memory_TestData
{
    var $agencyId;
    var $clientId;
    var $campaignId;
    var $channelId;

    var $zoneId1;

    var $bannerId1;

    function generate($cHowManyRecords, $cHowManyBanners)
    {
        $this->cleanUp();

        // Set default data value to empty string
        DataGenerator::defaultValueByType(MAX_DATAGENERATOR_DEFAULT_TYPE, '');

        for($c = 1; $c <= $cHowManyRecords; $c++) {
            $this->insertAgency($c);
            $this->insertAffiliate($c);
            $this->insertClient($c);
            $this->insertCampaign($c);
            $this->insertZone($c);
            $this->insertBanners($c, $cHowManyBanners);
            $this->insertAdZoneAssoc($c);
        }
    }

    function cleanUp()
    {
        $aCleanupTables = array(
            'agency',
            'clients',
            'campaigns',
            'affiliates',
            'zones',
            'ad_zone_assoc',
            'banners',
        );
        DataGenerator::cleanUp($aCleanupTables);
    }

    function insertAgency($index)
    {
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name         = 'Default Agency '.$index;
        $doAgency->contact      = 'Agency1';
        $doAgency->email        = 'agency@example.com';
        $doAgency->username     = '';
        $doAgency->password     = '';
        $doAgency->permissions  = '';
        $doAgency->language     = '';
        $doAgency->logout_url   = '';
        $doAgency->active       = 't';
        $doAgency->updated      = OA::getNow();
        $this->agencyId = DataGenerator::generateOne($doAgency);
    }

    function insertClient($index)
    {
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname          = 'Default Advertiser '.$index;
        $doClients->acencyid            = $this->agencyId;
        $doClients->contact             = 'Advertiser'.$index;
        $doClients->email               = 'advertiser'.$index.'@example.com';
        $doClients->clientusername      = '';
        $doClients->clientpassword      = '';
        $doClients->permissions         = 0;
        $doClients->language            = '';
        $doClients->report              = 'f';
        $doClients->reportinterval      = 7;
        $doClients->reportlastdate      = OA::getNow('Y-m-d');
        $doClients->reportdeactivate    = 't';
        $doClients->comments            = '';
        $doClients->updated             = OA::getNow();
        $doClients->lb_reporting        = 0;
        $this->clientId = DataGenerator::generateOne($doClients);
    }

    function insertCampaign($index)
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid      = $this->clientId;
        $doCampaigns->campaignname  = 'Default Campaign'.$index;
        $doCampaigns->views    = '-1';                           // int(11)
        $doCampaigns->clicks    = '-1';                          // int(11)
        $doCampaigns->conversions    = '-1';                     // int(11)
        $doCampaigns->expire    = OA_Dal::noDateString();
        $doCampaigns->activate  = OA_Dal::noDateString();
        $doCampaigns->status    = OA_ENTITY_STATUS_RUNNING;     // int(11)  not_null
        $doCampaigns->priority    = '-1';                        // int(11)  not_null
        $doCampaigns->weight    = '1';                          // int(4)  not_null
        $doCampaigns->target_impression    = '';               // int(11)  not_null
        $doCampaigns->target_click    = '';                    // int(11)  not_null
        $doCampaigns->target_conversion    = '';               // int(11)  not_null
        $doCampaigns->anonymous    = 'f';                    // string(1)  not_null enum
        $doCampaigns->companion    = 0;                       // int(1)
        $doCampaigns->comments    = '';                        // blob(65535)  blob
        $doCampaigns->revenue    = 0;                         // unknown(12)
        $doCampaigns->revenue_type    = '';                    // int(6)
        $doCampaigns->updated    = OA::getNow();
        $doCampaigns->block    = 0;                           // int(11)  not_null
        $doCampaigns->capping    = 0;                         // int(11)  not_null
        $doCampaigns->session_capping    = 0;                 // int(11)  not_null
        $this->campaignId = DataGenerator::generateOne($doCampaigns);
    }

    function insertAffiliate($index)
    {
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->agencyid      = $this->agencyId;
        $doAffiliate->name          = 'Default Publisher '.$index;
        $doAffiliate->mnemonic      = 'pub'.$index;
        $doAffiliate->comments      = '';
        $doAffiliate->contact       = 'publisher'.$index;
        $doAffiliate->email         = 'publisher'.$index.'@example.com';
        $doAffiliate->website       = 'http://www.example.com';
        $doAffiliate->username      = '';
        $doAffiliate->password      = '';
        $doAffiliate->permissions   = '';
        $doAffiliate->language      = '';
        $doAffiliate->publiczones   = 't';
        //$doAffiliate->last_accepted_agency_agreement = '';
        $doAffiliate->updated   = OA::getNow();
        $this->affiliateId = DataGenerator::generateOne($doAffiliate);
    }

    function insertZone($index)
    {
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonename      = 'Default Zone '.$index.' banner';
        $doZones->affiliateid   = $this->affiliateId;
        $doZones->zonetype      = 3;
        $doZones->width         = 468;
        $doZones->height        = 60;
        $doZones->forceappend   = 'f';
        $doZones->updated       = OA::getNow();
        $doZones->description   = 'Default Banner Zone'.$index;
        $doZones->delivery      = '0';
//        $doZones->zonetype    = '3';                       // int(6)  not_null
//        $doZones->category    = '';                       // blob(65535)  not_null blob
//        $doZones->ad_selection    = '';                   // blob(65535)  not_null blob
//        $doZones->chain    = '';                          // blob(65535)  not_null blob
        $doZones->prepend    = '';                        // blob(65535)  not_null blob
        $doZones->append    = '';                         // blob(65535)  not_null blob
        $doZones->appendtype    = '0';
//        $doZones->inventory_forecast_type    = '';         // int(6)  not_null
//        $doZones->comments    = '';                        // blob(65535)  blob
//        $doZones->cost    = '';                            // unknown(12)
//        $doZones->cost_type    = '';                       // int(6)
//        $doZones->cost_variable_id    = '';                // string(255)
//        $doZones->technology_cost    = '';                 // unknown(12)
//        $doZones->technology_cost_type    = '';            // int(6)
        $doZones->block    = 0;                           // int(11)  not_null
        $doZones->capping    = 0;                         // int(11)  not_null
        $doZones->session_capping    = 0;                 // int(11)  not_null
        $doZones->what    = '';                           // blob(65535)  not_null blob
        $this->zoneId1 = DataGenerator::generateOne($doZones);
    }

    function insertAdZoneAssoc($index)
    {
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_zone_assoc_id = $this->bannerId1;
        $doAdZoneAssoc->ad_id = $this->bannerId1;
        $doAdZoneAssoc->find();
        $doAdZoneAssoc->zone_id = $this->zoneId1;
        $doAdZoneAssoc->update();
    }

    function insertBanners($index, $c = 1)
    {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = OA::getNow();
        $doBanners->updated    = OA::getNow();
        $doBanners->campaignid      = $this->campaignId;
        $doBanners->status          = OA_ENTITY_STATUS_RUNNING;
        $doBanners->contenttype    = '';
        $doBanners->pluginversion    = '0';
        $doBanners->storagetype    = 'html';
        $doBanners->filename    = '';
        $doBanners->imageurl    = '';
        $doBanners->width    = '468';
        $doBanners->height    = '60';
        $doBanners->weight    = '1';
        $doBanners->seq    = '0';
        $doBanners->target    = '_blank';
        $doBanners->url    = '';
        $doBanners->alt    = '';
        $doBanners->statustext    = '';
        $doBanners->bannertext    = '';
        $doBanners->description    = 'Default banner 468*60 ('.$index.')';
        $doBanners->autohtml    = 't';
        $doBanners->adserver    = 'max';
        $doBanners->block    = '0';
        $doBanners->capping    = '0';
        $doBanners->session_capping    = '0';
        $doBanners->compiledlimitation    = '';
        $doBanners->acl_plugins    = '';
        $doBanners->append    = '';
        $doBanners->appendtype    = '0';
        $doBanners->bannertype    = '0';
        $doBanners->alt_filename    = '';
        $doBanners->alt_imageurl    = '';
        $doBanners->alt_contenttype    = 'gif';
        $doBanners->comments    = '';
        $doBanners->keyword    = '';
        $doBanners->transparent    = '';
        $doBanners->parameters    = '';

        $doBanners->htmltemplate    = "<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://ads.openx.org/delivery/ajs.php':'http://ads.openx.org/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write (\"<scr\"+\"ipt type='text/javascript' src='\"+m3_u);
   document.write (\"?zoneid=9\");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write (\"&amp;exclude=\" + document.MAX_used);
   document.write (\"&amp;loc=\" + escape(window.location));
   if (document.referrer) document.write (\"&amp;referer=\" + escape(document.referrer));
   if (document.context) document.write (\"&context=\" + escape(document.context));
   if (document.context) document.write (\"&context=\" + escape(document.context));
   if (document.mmm_fo) document.write (\"&amp;mmm_fo=1\");
   document.write (\"'><\\/scr\"+\"ipt>\");
//]]>--></script><noscript><a href='http://ads.openx.org/delivery/ck.php?n=abc986b1&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://ads.openx.org/delivery/avw.php?zoneid=9&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=abc986b1' border='0' alt='' /></a></noscript>";

        $doBanners->htmlcache    = "<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://ads.openx.org/delivery/ajs.php':'http://ads.openx.org/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write (\"<scr\"+\"ipt type='text/javascript' src='\"+m3_u);
   document.write (\"?zoneid=9\");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write (\"&amp;exclude=\" + document.MAX_used);
   document.write (\"&amp;loc=\" + escape(window.location));
   if (document.referrer) document.write (\"&amp;referer=\" + escape(document.referrer));
   if (document.context) document.write (\"&context=\" + escape(document.context));
   if (document.context) document.write (\"&context=\" + escape(document.context));
   if (document.mmm_fo) document.write (\"&amp;mmm_fo=1\");
   document.write (\"'><\\/scr\"+\"ipt>\");
//]]>--></script>";

        $this->bannerId1 = DataGenerator::generate($doBanners, $c);
    }

    function insertTracker($index)
    {
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->agencyid      = $this->agencyId;
        $doAffiliate->name          = 'Default Publisher '.$index;
        $doAffiliate->mnemonic      = 'pub'.$index;
        $doAffiliate->comments      = '';
        $doAffiliate->contact       = 'publisher'.$index;
        $doAffiliate->email         = 'publisher'.$index.'@example.com';
        $doAffiliate->website       = 'http://www.example.com';
        $doAffiliate->username      = '';
        $doAffiliate->password      = '';
        $doAffiliate->permissions   = '';
        $doAffiliate->language      = '';
        $doAffiliate->publiczones   = 't';
        //$doAffiliate->last_accepted_agency_agreement = '';
        $doAffiliate->updated   = OA::getNow();
        $this->affiliateId = DataGenerator::generateOne($doAffiliate);
    }

}

?>