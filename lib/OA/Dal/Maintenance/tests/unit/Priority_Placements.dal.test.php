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

require_once MAX_PATH . '/lib/max/Entity/Ad.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/Entities.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Priority.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once 'DB/QueryTool.php';

// pgsql execution time before refactor: 132.40s
// pgsql execution time after refactor: 22.053s

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Dal_Maintenance_Priority_Placements extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_Placements()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the getPlacements method.
     */
    function testGetPlacements()
    {
        $da = new OA_Dal_Maintenance_Priority();
        $this->_generateStatsOne();

        // Test 1 getPlacements method.
        $ret = $da->getPlacements();
        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 5);
        $campaign = $ret[0];
        $this->assertTrue(array_key_exists('campaignid', $campaign));
        $this->assertTrue(array_key_exists('views', $campaign));
        $this->assertTrue(array_key_exists('clicks', $campaign));
        $this->assertTrue(array_key_exists('conversions', $campaign));
        $this->assertTrue(array_key_exists('activate', $campaign));
        $this->assertTrue(array_key_exists('expire', $campaign));
        $this->assertTrue(array_key_exists('target_impression', $campaign));
        $this->assertTrue(array_key_exists('target_click', $campaign));
        $this->assertTrue(array_key_exists('target_conversion', $campaign));
        $this->assertTrue(array_key_exists('priority', $campaign));

        // Test 2 getPlacementData method.
        $ret = $da->getPlacementData(1);
        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 1);
        $campaign = $ret[0];
        $this->assertTrue(array_key_exists('advertiser_id', $campaign));
        $this->assertTrue(array_key_exists('placement_id', $campaign));
        $this->assertTrue(array_key_exists('name', $campaign));
        $this->assertTrue(array_key_exists('active', $campaign));
        $this->assertTrue(array_key_exists('num_children', $campaign));

        // Test 3 getPlacementStats method.
        $ret = $da->getPlacementStats(1);
        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 9);
        $this->assertTrue(array_key_exists('advertiser_id', $ret));
        $this->assertTrue(array_key_exists('placement_id', $ret));
        $this->assertTrue(array_key_exists('name', $ret));
        $this->assertTrue(array_key_exists('active', $ret));
        $this->assertTrue(array_key_exists('num_children', $ret));
        $this->assertTrue(array_key_exists('sum_requests', $ret));
        $this->assertTrue(array_key_exists('sum_views', $ret));
        $this->assertTrue(array_key_exists('sum_clicks', $ret));
        $this->assertTrue(array_key_exists('sum_conversions', $ret));

        DataGenerator::cleanUp();
    }

    /**
     * A method to test the getActiveZones method.
     */
    function testGetActiveZones()
    {
        $da = new OA_Dal_Maintenance_Priority();
        $oNow = new Date();

        // Add zone record
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonename = 'Default Zone';
        $doZones->zonetype = 3;
        $doZones->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idZone = DataGenerator::generateOne($doZones);

        // Add a banner
        $doBanners   = OA_Dal::factoryDO('banners');
        $doBanners->active = 't';
        $doBanners->acls_updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idBanner = DataGenerator::generateOne($doBanners);

        // Add ad_zone_assoc record
        $doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZone->ad_id = $idBanner;
        $doAdZone->zone_id = $idZone;
        $doAdZone->priority = 0;
        $doAdZone->link_type = 1;
        $doAdZone->priority_factor = 1;
        $doAdZone->to_be_delivered = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $ret = $da->getActiveZones();

        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 1);
        $zone = $ret[0];

        $this->assertTrue(array_key_exists('zoneid'  , $zone));
        $this->assertTrue(array_key_exists('zonename', $zone));
        $this->assertTrue(array_key_exists('zonetype', $zone));

        $this->assertEqual($zone['zoneid'],$idZone);
        $this->assertEqual($zone['zonename'],'Default Zone');
        $this->assertEqual($zone['zonetype'],3);

        DataGenerator::cleanUp();
    }

    /**
     * A method to test the getPlacementDeliveryToday method.
     *
     * @TODO Not implemented.
     */
    function testGetPlacementDeliveryToday()
    {
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateStatsOne()
    {
        $oDate = new Date();
        $oDate->addSeconds((SECONDS_PER_DAY * 4));
        $expiryDate1 = $oDate->getYear() . "-" . $oDate->getMonth() . "-" . $oDate->getDay();

        $oDate->addSeconds((SECONDS_PER_DAY * 4));
        $expiryDate2 = $oDate->getYear() . "-" . $oDate->getMonth() . "-" . $oDate->getDay();

        $oDate->subtractSeconds((SECONDS_PER_DAY * 2));
        $expiryDateLessTwoDays = $oDate->getYear() . "-" . $oDate->getMonth() . "-" . $oDate->getDay();

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doAcls      = OA_Dal::factoryDO('acls');

        $doBanners   = OA_Dal::factoryDO('banners');
        // default values
        $doBanners->active = 't';
        $doBanners->contenttype = 'gif';
        $doBanners->pluginversion = 0;
        $doBanners->storagetype = 'sql';
        $doBanners->filename = '468x60_4.gif';
        $doBanners->imageurl = '';
        $doBanners->htmltemplate = '';
        $doBanners->htmlcache = '';
        $doBanners->width = 468;
        $doBanners->height = 60;
        $doBanners->weight = 1;
        $doBanners->seq = 0;
        $doBanners->target = '';
        $doBanners->url = 'http://www.example.com';
        $doBanners->alt = 'Campaign Alt Text';
        $doBanners->status = '';
        $doBanners->bannertext = '';
        $doBanners->description = '';
        $doBanners->autohtml = 'f';
        $doBanners->adserver = '';
        $doBanners->block = 0;
        $doBanners->capping = 0;
        $doBanners->session_capping = 0;
        $doBanners->compiledlimitation = '';
        $doBanners->append = '';
        $doBanners->appendtype = 0;
        $doBanners->bannertype = 0;
        $doBanners->alt_filename = '';
        $doBanners->alt_imageurl = '';
        $doBanners->alt_contenttype = '';


        // Add 3 campaigns - haha!
        $doCampaigns->campaignname = 'Test Campaign 1';
        $doCampaigns->clientid = 1;
        $doCampaigns->views = 0;
        $doCampaigns->clicks = 400;
        $doCampaigns->conversions = 0;
        $doCampaigns->expire = $expiryDate1;
        $doCampaigns->activate = OA_Dal::noDateString();
        $doCampaigns->active = 't';
        $doCampaigns->priority = '3';
        $doCampaigns->weight = 1;
        $doCampaigns->target_impression = 0;
        $doCampaigns->anonymous = 'f';
        $doCampaigns->updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $idCampaign1 = DataGenerator::generateOne($doCampaigns);

        $doCampaigns->campaignname = 'Test Campaign 2';
        $doCampaigns->clientid = 1;
        $doCampaigns->views = 0;
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 400;
        $doCampaigns->expire = OA_Dal::noDateString();
        $doCampaigns->activate = OA_Dal::noDateString();
        $doCampaigns->active = 't';
        $doCampaigns->priority = '2';
        $doCampaigns->weight = 1;
        $doCampaigns->target_impression = 0;
        $doCampaigns->anonymous = 'f';
        $doCampaigns->updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $idCampaign2 = DataGenerator::generateOne($doCampaigns);

        $doCampaigns->campaignname = 'Test Campaign 3';
        $doCampaigns->clientid = 1;
        $doCampaigns->views = 500;
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 0;
        $doCampaigns->expire = $expiryDate2;
        $doCampaigns->activate = OA_Dal::noDateString();
        $doCampaigns->active = 't';
        $doCampaigns->priority = '3';
        $doCampaigns->weight = 1;
        $doCampaigns->target_impression = 0;
        $doCampaigns->anonymous = 'f';
        $doCampaigns->updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $idCampaign3 = DataGenerator::generateOne($doCampaigns);

        $doCampaigns->campaignname = 'Test Campaign 4';
        $doCampaigns->clientid = 1;
        $doCampaigns->views = 500;
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 401;
        $doCampaigns->expire = OA_Dal::noDateString();
        $doCampaigns->activate = OA_Dal::noDateString();
        $doCampaigns->active = 't';
        $doCampaigns->priority = '4';
        $doCampaigns->weight = 2;
        $doCampaigns->target_impression = 0;
        $doCampaigns->anonymous = 'f';
        $doCampaigns->updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $idCampaign4 = DataGenerator::generateOne($doCampaigns);

        $doCampaigns->campaignname = 'Test Campaign 5';
        $doCampaigns->clientid = 1;
        $doCampaigns->views = 500;
        $doCampaigns->clicks = 0;
        $doCampaigns->conversions = 401;
        $doCampaigns->expire = OA_Dal::noDateString();
        $doCampaigns->activate = OA_Dal::noDateString();
        $doCampaigns->active = 't';
        $doCampaigns->priority = '3';
        $doCampaigns->weight = 2;
        $doCampaigns->target_impression = 0;
        $doCampaigns->anonymous = 'f';
        $doCampaigns->updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $idCampaign5 = DataGenerator::generateOne($doCampaigns);

        // Add 1st banner to campaign 1
        $doBanners->campaignid=$idCampaign1;
        $doBanners->alt = 'Campaign1 - Banner 1';
        $doBanners->acls_updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $idBanner1 = DataGenerator::generateOne($doBanners);

        // Banner 1, Campaign 1 - acls delivery restrictions
        $doAcls->bannerid = $idBanner1;
        $doAcls->logical = 'and';
        $doAcls->type = 'Time:Date';
        $doAcls->comparison = '!=';
        $doAcls->data = $expiryDateLessTwoDays;
        $doAcls->executionorder = 0;
        $idAcls1 = DataGenerator::generateOne($doAcls);

        $doAcls->bannerid = $idBanner1;
        $doAcls->logical = 'and';
        $doAcls->type = 'Time:Hour';
        $doAcls->comparison = '!=';
        $doAcls->data = 1;
        $doAcls->executionorder = 1;
        $idAcls2 = DataGenerator::generateOne($doAcls);

        // Add 2nd banner to campaign 1
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign1;
        $doBanners->alt = 'Campaign1 - Banner 2';
        $doBanners->acls_updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $idBanner2 = DataGenerator::generateOne($doBanners);

        // Banner 2, Campaign 1 - acls delivery restrictions
        $doAcls->bannerid = $idBanner2;
        $doAcls->logical = 'and';
        $doAcls->type = 'Time:Date';
        $doAcls->comparison = '!=';
        $doAcls->data = $expiryDateLessTwoDays;
        $doAcls->executionorder = 0;
        $idAcls3 = DataGenerator::generateOne($doAcls);

        $doAcls->bannerid = $idBanner2;
        $doAcls->logical = 'and';
        $doAcls->type = 'Time:Hour';
        $doAcls->comparison = '!=';
        $doAcls->data = '1,2';
        $doAcls->executionorder = 1;
        $idAcls4 = DataGenerator::generateOne($doAcls);

        // Add 1st banner to campaign 2  ????
        $doBanners->campaignid=$idCampaign2;
        $doBanners->alt = 'Campaign2 - Banner 1';
        $doBanners->acls_updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $idBanner3 = DataGenerator::generateOne($doBanners);

        $doBanners->campaignid=$idCampaign2;
        $doBanners->alt = 'Campaign2 - Banner 2';
        $doBanners->acls_updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $idBanner4 = DataGenerator::generateOne($doBanners);

        // Banner 1, Campaign 2 - acls delivery restrictions
        $doAcls->bannerid = $idBanner4;
        $doAcls->logical = 'and';
        $doAcls->type = 'Time:Date';
        $doAcls->comparison = '!=';
        $doAcls->data = $expiryDateLessTwoDays;
        $doAcls->executionorder = 0;
        $idAcls5 = DataGenerator::generateOne($doAcls);

        $doAcls->bannerid = $idBanner4;
        $doAcls->logical = 'and';
        $doAcls->type = 'Time:Day';
        $doAcls->comparison = '!=';
        $doAcls->data = '5';
        $doAcls->executionorder = 1;
        $idAcls6 = DataGenerator::generateOne($doAcls);

        // Add 2nd banner to campaign 2
        $doBanners->campaignid=$idCampaign2;
        $doBanners->alt = 'Campaign2 - Banner 3';
        $doBanners->acls_updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $idBanner5 = DataGenerator::generateOne($doBanners);

        // Banner 2, Campaign 2 - acls delivery restrictions
        $doAcls->bannerid = $idBanner5;
        $doAcls->logical = 'or';
        $doAcls->type = 'Time:Date';
        $doAcls->comparison = '!=';
        $doAcls->data = $expiryDateLessTwoDays;
        $doAcls->executionorder = 0;
        $idAcls7 = DataGenerator::generateOne($doAcls);

        $doAcls->bannerid = $idBanner5;
        $doAcls->logical = 'or';
        $doAcls->type = 'Time:Day';
        $doAcls->comparison = '==';
        $doAcls->data = '1,2';
        $doAcls->executionorder = 1;
        $idAcls8 = DataGenerator::generateOne($doAcls);

        // Add 1st banner to campaign 3
        $doBanners->campaignid=$idCampaign3;
        $doBanners->alt = 'Campaign3 - Banner 1';
        $doBanners->acls_updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $idBanner6 = DataGenerator::generateOne($doBanners);

        // Banner 1, Campaign 3 - acls delivery restrictions
        $doAcls->bannerid = $idBanner6;
        $doAcls->logical = 'and';
        $doAcls->type = 'Time:Date';
        $doAcls->comparison = '!=';
        $doAcls->data = $expiryDateLessTwoDays;
        $doAcls->executionorder = 0;
        $idAcls9 = DataGenerator::generateOne($doAcls);

        $doAcls->bannerid = $idBanner6;
        $doAcls->logical = 'or';
        $doAcls->type = 'Time:Day';
        $doAcls->comparison = '==';
        $doAcls->data = '5';
        $doAcls->executionorder = 1;
        $idAcls10 = DataGenerator::generateOne($doAcls);

        // Add 2nd banner to campaign 3
        $doBanners->campaignid=$idCampaign3;
        $doBanners->alt = 'Campaign3 - Banner 2';
        $doBanners->acls_updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oDate->format('%Y-%m-%d %H:%M:%S');
        $idBanner7 = DataGenerator::generateOne($doBanners);

        // Banner 2, Campaign 3 - acls delivery restrictions
        $doAcls->bannerid = $idBanner7;
        $doAcls->logical = 'or';
        $doAcls->type = 'Time:Date';
        $doAcls->comparison = '!=';
        $doAcls->data = $expiryDateLessTwoDays;
        $doAcls->executionorder = 0;
        $idAcls11 = DataGenerator::generateOne($doAcls);

        $doAcls->bannerid = $idBanner7;
        $doAcls->logical = 'or';
        $doAcls->type = 'Time:Hour';
        $doAcls->comparison = '1=';
        $doAcls->data = '1,2';
        $doAcls->executionorder = 1;
        $idAcls12 = DataGenerator::generateOne($doAcls);
    }

    /**
     * A method to generate data for testing.
     * NOT USED
     *
     * @access private
     */
/*    function _generateStatsTwo()
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
        $doCampaigns->active = 't';
        $doCampaigns->priority = '4';
        $doCampaigns->weight = 2;
        $doCampaigns->target_impression = 0;
        $doCampaigns->anonymous = 'f';
        $doCampaigns->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idCampaign = DataGenerator::generateOne($doCampaigns);

        // Add a banner
        $doBanners   = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->active = 't';
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
        $doBanners->status = '';
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
        $idBanner = DataGenerator::generateOne($doBanners);

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
        $idAgency = DataGenerator::generateOne($doAgency);

        // Add a client record (advertiser)
        $doClient = OA_Dal::factoryDO('clients');
        $doClient->agencyid = $idAgency;
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
        $idClient = DataGenerator::generateOne($doClient);

        // Add an affiliate (publisher) record
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = $idAgency;
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
        $idAffiliate = DataGenerator::generateOne($doAffiliates);

        // Add zone record
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->affiliateid = $idAffiliate;
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
        $idZone = DataGenerator::generateOne($doZones);

        // Add ad_zone_assoc record
        $doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZone->ad_id = $idBanner;
        $doAdZone->zone_id = $idZone;
        $doAdZone->priority = 0;
        $doAdZone->link_type = 1;
        $doAdZone->priority_factor = 1;
        $doAdZone->to_be_delivered = 1;
        $idZone = DataGenerator::generateOne($doZones);

        // Populate data_summary_ad_hourly
        $doAdHourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        for ($hour = 0; $hour < 24; $hour ++)
        {
            $oNow = new Date();
            $doAdHourly->day = $oNow->format('%Y-%m-%d %H:%M:%S');
            $doAdHourly->hour = $hour;
            $doAdHourly->ad_id = $idBanner;
            $doAdHourly->creative_id = rand(1, 999);
            $doAdHourly->zone_id = rand(1, 999);
            $doAdHourly->requests = rand(1, 999);
            $doAdHourly->impressions = rand(1, 999);
            $doAdHourly->clicks = rand(1, 999);
            $doAdHourly->conversions = rand(1, 999);
            $doAdHourly->total_basket_value = 0;
            $doAdHourly->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
            $idStat = DataGenerator::generateOne($doAdHourly);
        }

    }
*/

/**
 * OLD METHODS START HERE
 */
    /**
     * A method to test the getPlacements method.
     */
    function OLD_testGetPlacements()
    {
        $da = new OA_Dal_Maintenance_Priority();
        $this->_generateStatsOne();
        $ret = $da->getPlacements();

        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 5);
        $campaign = $ret[0];
        $this->assertTrue(array_key_exists('campaignid', $campaign));
        $this->assertTrue(array_key_exists('views', $campaign));
        $this->assertTrue(array_key_exists('clicks', $campaign));
        $this->assertTrue(array_key_exists('conversions', $campaign));
        $this->assertTrue(array_key_exists('activate', $campaign));
        $this->assertTrue(array_key_exists('expire', $campaign));
        $this->assertTrue(array_key_exists('target_impression', $campaign));
        $this->assertTrue(array_key_exists('target_click', $campaign));
        $this->assertTrue(array_key_exists('target_conversion', $campaign));
        $this->assertTrue(array_key_exists('priority', $campaign));
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the getPlacementData method.
     */
    function OLD_testGetPlacementData()
    {
        $da = new OA_Dal_Maintenance_Priority();
        $this->_generateStatsOne();
        $ret = $da->getPlacementData(1);
        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 1);
        $campaign = $ret[0];
        $this->assertTrue(array_key_exists('advertiser_id', $campaign));
        $this->assertTrue(array_key_exists('placement_id', $campaign));
        $this->assertTrue(array_key_exists('name', $campaign));
        $this->assertTrue(array_key_exists('active', $campaign));
        $this->assertTrue(array_key_exists('num_children', $campaign));
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the getPlacementStats method.
     */
    function OLD_testGetPlacementStats()
    {
        $da = new OA_Dal_Maintenance_Priority();
        $this->_generateStatsOne();
        $ret = $da->getPlacementStats(1);

        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 9);

        $this->assertTrue(array_key_exists('advertiser_id', $ret));
        $this->assertTrue(array_key_exists('placement_id', $ret));
        $this->assertTrue(array_key_exists('name', $ret));
        $this->assertTrue(array_key_exists('active', $ret));
        $this->assertTrue(array_key_exists('num_children', $ret));
        $this->assertTrue(array_key_exists('sum_requests', $ret));
        $this->assertTrue(array_key_exists('sum_views', $ret));
        $this->assertTrue(array_key_exists('sum_clicks', $ret));
        $this->assertTrue(array_key_exists('sum_conversions', $ret));
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the getActiveZones method.
     */
    function OLD_testGetActiveZones()
    {
        $da = new OA_Dal_Maintenance_Priority();
        $this->_generateStatsTwo();
        $ret = $da->getActiveZones();

        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 1);
        $zone = $ret[0];
        $this->assertTrue(array_key_exists('zoneid', $zone));
        $this->assertTrue(array_key_exists('zonename', $zone));
        $this->assertTrue(array_key_exists('zonetype', $zone));
        TestEnv::restoreEnv();
    }


    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function OLD__generateStatsOne()
    {
        $conf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();

        $oDate = new Date();
        $oDate->addSeconds((SECONDS_PER_DAY * 4));
        $expiryDate1 = $oDate->getYear() . "-" . $oDate->getMonth() . "-" . $oDate->getDay();

        $oDate->addSeconds((SECONDS_PER_DAY * 4));
        $expiryDate2 = $oDate->getYear() . "-" . $oDate->getMonth() . "-" . $oDate->getDay();

        $oDate->subtractSeconds((SECONDS_PER_DAY * 2));
        $expiryDateLessTwoDays = $oDate->getYear() . "-" . $oDate->getMonth() . "-" . $oDate->getDay();

        // Add 3 campaigns
        $campaignsTable = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['campaigns'],true);
        $sql = "
            INSERT INTO
                $campaignsTable
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    anonymous,
                    updated
                )
            VALUES
                (
                    1,
                    'Test Campaign',
                    1,
                    0,
                    400,
                    0,
                    '" . $expiryDate1 . "',
                    " . OA_Dal::noDateString() . ",
                    't',
                    '3',
                    1,
                    0,
                    'f',
                    '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

        $sql = "
            INSERT INTO
                $campaignsTable
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    anonymous,
                    updated
                )
            VALUES
                (
                    2,
                    'Test Campaign',
                    1,
                    0,
                    0,
                    400,
                    " . OA_Dal::noDateString() . ",
                    " . OA_Dal::noDateString() . ",
                    't',
                    '2',
                    1,
                    0,
                    'f',
                    '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

        $sql = "
            INSERT INTO
                $campaignsTable
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    anonymous,
                    updated
                )
            VALUES
                (
                    3,
                    'Test Campaign',
                    1,
                    500,
                    0,
                    0,
                    '" . $expiryDate2 . "',
                    " . OA_Dal::noDateString() . ",
                    't',
                    '3',
                    1,
                    0,
                    'f',
                    '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

        $sql = "
            INSERT INTO
                $campaignsTable
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    anonymous,
                    updated
                )
            VALUES
                (
                    4,
                    'Test Campaign',
                    1,
                    500,
                    0,
                    401,
                    " . OA_Dal::noDateString() . ",
                    " . OA_Dal::noDateString() . ",
                    't',
                    '4',
                    2,
                    0,
                    'f',
                    '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

        $sql = "
            INSERT INTO
                $campaignsTable
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    anonymous,
                    updated
                )
            VALUES
                (
                    5,
                    'Test Campaign',
                    1,
                    500,
                    0,
                    401,
                    " . OA_Dal::noDateString() . ",
                    " . OA_Dal::noDateString() . ",
                    't',
                    '3',
                    2,
                    0,
                    'f',
                    '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

        $bannersTable = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['banners'],true);
        $aclsTable = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['acls'],true);

        // Add 1st banner to campaign 1
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, acls_updated, updated)
        VALUES (1,1,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign1 - Banner 1','','','','f','',0, 0,0,'','',0,0,'','','','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "');";
        $rows = $oDbh->exec($sql);

        // Banner 1, Campaign 1 - acls delivery restrictions
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,        comparison, data,                        executionorder)
                                VALUES (1,          'and',   'Time:Date', '!=',       '$expiryDateLessTwoDays',    0)";
        $rows = $oDbh->exec($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,        comparison, data,   executionorder)
                                VALUES (1,          'and',   'Time:Hour', '!=',       '1',    1)";
        $rows = $oDbh->exec($sql);

        // Add 2nd banner to campaign 1
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, acls_updated, updated)
        VALUES (2,1,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 1 - Banner 2','','','','f','',0, 0,0,'','',0,0,'','','','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "');";
        $rows = $oDbh->exec($sql);

        // Banner 2, Campaign 1 - acls delivery restrictions
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,        comparison, data,                        executionorder)
                                VALUES (2,          'and',   'Time:Date', '!=',       '$expiryDateLessTwoDays',    0)";
        $rows = $oDbh->exec($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,        comparison, data,   executionorder)
                                VALUES (2,          'and',   'Time:Hour', '!=',       '1,2',    1)";
        $rows = $oDbh->exec($sql);

        // Add 1st banner to campaign 2
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, acls_updated, updated)
        VALUES (3,2,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 2 - Banner 1','','','','f','',0, 0,0,'','',0,0,'','','','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "');";
        $rows = $oDbh->exec($sql);

        // Banner 1, Campaign 2 - acls delivery restrictions
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,        comparison, data,                        executionorder)
                                VALUES (3,          'and',   'Time:Date', '!=',       '$expiryDateLessTwoDays',    0)";
        $rows = $oDbh->exec($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,       comparison, data,   executionorder)
                                VALUES (3,          'and',   'Time:Day', '!=',       '5',    1)";
        $rows = $oDbh->exec($sql);

        // Add 2nd banner to campaign 2
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, acls_updated, updated)
        VALUES (4,2,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 2 - Banner 2','','','','f','',0, 0,0,'','',0,0,'','','','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "');";
        $rows = $oDbh->exec($sql);

        // Banner 2, Campaign 2 - acls delivery restrictions
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,       comparison, data,                        executionorder)
                                VALUES (4,          'or',   'Time:Date', '!=',       '$expiryDateLessTwoDays',    0)";
        $rows = $oDbh->exec($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,       comparison, data,   executionorder)
                                VALUES (4,          'or',   'Time:Hour', '==',       '1,2',    1)";
        $rows = $oDbh->exec($sql);

        // Add 1st banner to campaign 3
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, acls_updated, updated)
        VALUES (5,3,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 3 - Banner 1','','','','f','',0, 0,0,'','',0,0,'','','','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "');";
        $rows = $oDbh->exec($sql);

        // Banner 1, Campaign 3 - acls delivery restrictions
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,        comparison, data,                        executionorder)
                                VALUES (5,          'and',   'Time:Date', '!=',       '$expiryDateLessTwoDays',    0)";
        $rows = $oDbh->exec($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,      comparison, data,   executionorder)
                                VALUES (5,          'or',   'Time:Day', '==',       '5',    1)";
        $rows = $oDbh->exec($sql);

        // Add 2nd banner to campaign 3
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, acls_updated, updated)
        VALUES (6,3,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 3 - Banner 2','','','','f','',0, 0,0,'','',0,0,'','','','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "');";
        $rows = $oDbh->exec($sql);

        // Banner 2, Campaign 3 - acls delivery restrictions
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,                        executionorder)
                                VALUES (6,          'or',   'Time:Date',   '!=',       '$expiryDateLessTwoDays',    0)";
        $rows = $oDbh->exec($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,       comparison, data,   executionorder)
                                VALUES (6,          'or',   'Time:Hour', '!=',       '1,2',    1)";
        $rows = $oDbh->exec($sql);
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function OLD__generateStatsTwo()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();

        // Populate data_summary_ad_hourly
        $statsTable = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'],true);
        for ($hour = 0; $hour < 24; $hour ++) {
            $oNow = new Date();
            $sql = "
                INSERT INTO
                    $statsTable
                    (
                        day,
                        hour,
                        ad_id,
                        creative_id,
                        zone_id,
                        requests,
                        impressions,
                        clicks,
                        conversions,
                        total_basket_value,
                        updated
                    )
                VALUES
                    (
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "',
                        $hour,
                        1,
                        ".rand(1, 999).",
                        ".rand(1, 999).",
                        ".rand(1, 999).",
                        ".rand(1, 999).",
                        ".rand(1, 999).",
                        ".rand(1, 999).",
                        0,
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                    )";
            $rows = $oDbh->exec($sql);
        }
        // Populate campaigns table
        $campaignsTable = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['campaigns'],true);
        $sql = "
            INSERT INTO
                $campaignsTable
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    anonymous,
                    updated
                )
            VALUES
                (
                    4,
                    'Test Campaign',
                    1,
                    500,
                    0,
                    401,
                    " . OA_Dal::noDateString() . ",
                    " . OA_Dal::noDateString() . ",
                    't',
                    '4',
                    2,
                    0,
                    'f',
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

        // Add a banner
        $bannersTable = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table'][ 'banners'],true);
        $sql = "
            INSERT INTO
                $bannersTable
                    (
                        bannerid,
                        campaignid,
                        active,
                        contenttype,
                        pluginversion,
                        storagetype,
                        filename,
                        imageurl,
                        htmltemplate,
                        htmlcache,
                        width,
                        height,
                        weight,
                        seq,
                        target,
                        url,
                        alt,
                        status,
                        bannertext,
                        description,
                        autohtml,
                        adserver,
                        block,
                        capping,
                        session_capping,
                        compiledlimitation,
                        append,
                        appendtype,
                        bannertype,
                        alt_filename,
                        alt_imageurl,
                        alt_contenttype,
                        updated,
                        acls_updated
                    )
                VALUES
                    (
                        1,
                        1,
                        't',
                        'txt',
                        0,
                        'txt',
                        '',
                        '',
                        '',
                        '',
                        0,
                        0,
                        1,
                        0,
                        '',
                        'http://exapmle.com',
                        '',
                        'asdf',
                        'tyerterty',
                        '',
                        'f',
                        '',
                        0,
                        0,
                        0,
                        'phpAds_aclCheckDate(\'20050502\', \'!=\') and phpAds_aclCheckClientIP(\'2.22.22.2\', \'!=\') and phpAds_aclCheckLanguage(\'(sq)|(eu)|(fo)|(fi)\', \'!=\')',
                        '',
                        0,
                        0,
                        '',
                        '',
                        '',
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "',
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                    )";
        $rows = $oDbh->exec($sql);

        // Add an agency record
        $agencyTable = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['agency'],true);
        $sql = "
            INSERT INTO
                $agencyTable
                (
                    agencyid,
                    name,
                    contact,
                    email,
                    username,
                    password,
                    permissions,
                    language,
                    logout_url,
                    active,
                    updated
                )
            VALUES
                (
                    1,
                    'Test Agency',
                    'sdfsdfsdf',
                    'demian@phpkitchen.com',
                    'Demian Turner',
                    'passwd',
                    0,
                    'en_GB',
                    'logout.php',
                    1,
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

        // Add a client record (advertiser)
        $clientsTable = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['clients'],true);
        $sql = "
            INSERT INTO
                $clientsTable
                    (
                        clientid,
                        agencyid,
                        clientname,
                        contact,
                        email,
                        clientusername,
                        clientpassword,
                        permissions,
                        language,
                        report,
                        reportinterval,
                        reportlastdate,
                        reportdeactivate,
                        updated
                    )
                VALUES
                    (
                        1,
                        1,
                        'test client',
                        'yes',
                        'demian@phpkitchen.com',
                        'Demian Turner',
                        '',
                        59,
                        '',
                        't',
                        7,
                        '2005-03-21',
                        't',
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                    )";
        $rows = $oDbh->exec($sql);

        // Add an affiliate (publisher) record
        $publisherTable = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['affiliates'],true);
        $sql = "
            INSERT INTO
                $publisherTable
                    (
                        affiliateid,
                        agencyid,
                        name,
                        mnemonic,
                        contact,
                        email,
                        website,
                        username,
                        password,
                        permissions,
                        language,
                        publiczones,
                        updated
                    )
                VALUES
                    (
                        1,
                        1,
                        'test publisher',
                        'ABC',
                        'foo bar',
                        'foo@example.com',
                        'www.example.com',
                        'foo',
                        'bar',
                        NULL,
                        NULL,
                        'f',
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                    )";
        $rows = $oDbh->exec($sql);

        // Add zone record
        $zonesTable = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['zones'],true);
        $sql = "
            INSERT INTO
                $zonesTable
                    (
                        zoneid,
                        affiliateid,
                        zonename,
                        description,
                        delivery,
                        zonetype,
                        category,
                        width,
                        height,
                        ad_selection,
                        chain,
                        prepend,
                        append,
                        appendtype,
                        forceappend,
                        updated
                    )
                VALUES
                    (
                        1,
                        1,
                        'Demian Turner - Default',
                        '',
                        0,
                        3,
                        '',
                        728,
                        90,
                        '',
                        '',
                        '',
                        '',
                        0,
                        'f',
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                    )";
        $rows = $oDbh->exec($sql);

        // Add ad_zone_assoc record
        $tblAdZone = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['ad_zone_assoc'],true);
        $query = "
            INSERT INTO
                {$tblAdZone}
                (
                    ad_id,
                    zone_id,
                    priority,
                    link_type,
                    priority_factor,
                    to_be_delivered
                )
            VALUES
                (
                    1,
                    1,
                    0,
                    1,
                    1,
                    1
                )";
        $rows = $oDbh->exec($query);
    }

}

?>
