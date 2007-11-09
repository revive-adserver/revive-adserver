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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing non standard DataObjects_Campaigns methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DB_DataObjectAuditTest extends DalUnitTestCase
{
    var $doAudit;

    /**
     * The constructor method.
     */
    function DB_DataObjectAuditTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = true;
    }

    function tearDown()
    {
    }

    function _fetchAuditRecord($context, $actionid)
    {
        $doAudit = OA_Dal::factoryDO('audit');
        $doAudit->context = $context;
        $doAudit->actionid = $actionid;
        $doAudit->find();
        $result = $doAudit->fetch();
        $this->assertEqual($doAudit->context, $context);
        $this->assertEqual($doAudit->actionid, $actionid);
        return $doAudit;
    }

    function _fetchAuditArrayAll()
    {
        $aResult = array();
        $this->doAudit = OA_Dal::factoryDO('audit');
        $aRows = $this->doAudit->getAll('',true);
        foreach ($aRows as $k => $aRow)
        {
            $idx = $aRow['auditid'];
            $aResult[$idx] = $aRow;
            $aResult[$idx]['array']   = unserialize($aRow['details']);
        }
        return $aResult;
    }

    function testAuditZone()
    {
        global $session;
        $session['username'] = 'zone user';
        $session['userid']   = rand(11,20);
        $session['usertype'] = rand(1,10);
        $doZone = OA_Dal::factoryDO('zones');
        $context = 'Zone';

        $doZone->agencyid = rand(20,30);
        $doZone->affiliateid = rand(20,30);
        $doZone->zonename = 'Zone A';
        $zoneId = DataGenerator::generateOne($doZone);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$zoneId);
        $this->assertEqual($aAudit['key_desc'],$doZone->zonename);
        $this->assertEqual($aAudit['zoneid'],$zoneId);
        $this->assertEqual($aAudit['zonename'],$doZone->zonename);
        $this->assertEqual($aAudit['affiliateid'],$doZone->affiliateid);

        $doZone->zonename = 'Zone B';
        $doZone->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['zonename']['is'],$doZone->zonename);
        $this->assertEqual($aAudit['zonename']['was'],'Zone A');

        $doZone->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['zoneid'],$zoneId);

        DataGenerator::cleanUp(array('zones', 'audit'));
    }

    function testAuditChannel()
    {
        global $session;
        $session['username'] = 'channel user';
        $session['userid']   = rand(11,20);
        $session['usertype'] = rand(1,10);
        $doChannel = OA_Dal::factoryDO('channel');
        $context = 'Channel';

        $doChannel->agencyid = rand(20,30);
        $doChannel->affiliateid = rand(20,30);
        $doChannel->name = 'Channel A';
        $channelId = DataGenerator::generateOne($doChannel);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$channelId);
        $this->assertEqual($aAudit['key_desc'],$doChannel->name);
        $this->assertEqual($aAudit['channelid'],$channelId);
        $this->assertEqual($aAudit['name'],$doChannel->name);
        $this->assertEqual($aAudit['agencyid'],$doChannel->agencyid);
        $this->assertEqual($aAudit['affiliateid'],$doChannel->affiliateid);

        $doChannel->name = 'Channel B';
        $doChannel->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['name']['is'],$doChannel->name);
        $this->assertEqual($aAudit['name']['was'],'Channel A');

        $doChannel->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['channelid'],$channelId);

        DataGenerator::cleanUp(array('channel', 'audit'));
    }

    function testAuditCategory()
    {
        global $session;
        $session['username'] = 'category user';
        $session['userid']   = rand(11,20);
        $session['usertype'] = rand(1,10);
        $doCategory = OA_Dal::factoryDO('category');
        $context = 'Category';

        $doCategory->name = 'Category A';
        $categoryId = DataGenerator::generateOne($doCategory);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$categoryId);
        $this->assertEqual($aAudit['key_desc'],$doCategory->name);
        $this->assertEqual($aAudit['category_id'],$categoryId);
        $this->assertEqual($aAudit['name'],$doCategory->name);

        $doCategory->name = 'Category B';
        $doCategory->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['name']['is'],$doCategory->name);
        $this->assertEqual($aAudit['name']['was'],'Category A');

        $doCategory->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['category_id'],$categoryId);

        DataGenerator::cleanUp(array('category', 'audit'));
    }

    function testAuditClient()
    {
        global $session;
        $session['username'] = 'client user';
        $session['userid']   = rand(11,20);
        $session['usertype'] = rand(1,10);
        $doClients = OA_Dal::factoryDO('clients');
        $context = 'Client';

        $doClients->clientname = 'Client A';
        $clientId = DataGenerator::generateOne($doClients);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$clientId);
        $this->assertEqual($aAudit['key_desc'],$doClients->clientname);
        $this->assertEqual($aAudit['clientid'],$clientId);
        $this->assertEqual($aAudit['clientname'],$doClients->clientname);

        $doClients->clientname = 'Client B';
        $doClients->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['clientname']['is'],$doClients->clientname);
        $this->assertEqual($aAudit['clientname']['was'],'Client A');

        $doClients->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['clientid'],$clientId);

        DataGenerator::cleanUp(array('clients', 'audit'));
    }

    function testAuditAffiliate()
    {
        global $session;
        $session['username'] = 'affiliate user';
        $session['userid']   = rand(11,20);
        $session['usertype'] = rand(1,10);
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $context = 'Affiliate';

        $doAffiliate->name = 'Client A';
        $affiliateId = DataGenerator::generateOne($doAffiliate);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$affiliateId);
        $this->assertEqual($aAudit['key_desc'],$doAffiliate->name);
        $this->assertEqual($aAudit['affiliateid'],$affiliateId);
        $this->assertEqual($aAudit['name'],$doAffiliate->name);

        $doAffiliate->name = 'Client B';
        $doAffiliate->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['name']['is'],$doAffiliate->name);
        $this->assertEqual($aAudit['name']['was'],'Client A');

        $doAffiliate->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['affiliateid'],$affiliateId);

        DataGenerator::cleanUp(array('affiliates', 'audit'));
    }

    function testAuditAffiliateExtra()
    {
        global $session;
        $session['username'] = 'affiliate_extra user';
        $session['userid']   = rand(11,20);
        $session['usertype'] = rand(1,10);
        $doAffiliateX = OA_Dal::factoryDO('affiliates_extra');
        $context = 'Affiliate Extra';

        $doAffiliateX->affiliateid = rand(1,5);
        $doAffiliateX->postcode = 'ABC 123';
        $affiliateXId = DataGenerator::generateOne($doAffiliateX);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$doAffiliateX->affiliateid);
        $this->assertEqual($aAudit['key_desc'],'');
        $this->assertEqual($aAudit['affiliateid'],$doAffiliateX->affiliateid);

        $doAffiliateX->postcode = 'DEF 456';
        $doAffiliateX->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['postcode']['is'],$doAffiliateX->postcode);
        $this->assertEqual($aAudit['postcode']['was'],'ABC 123');

        $doAffiliateX->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['affiliateid'],$doAffiliateX->affiliateid);

        DataGenerator::cleanUp(array('affiliates_extra', 'audit'));
    }

    function testAuditTracker()
    {
        global $session;
        $session['username'] = 'tracker user';
        $session['userid']   = rand(11,20);
        $session['usertype'] = rand(1,10);
        $doTrackers = OA_Dal::factoryDO('trackers');
        $context = 'Tracker';

        $doTrackers->clientid = rand(20,30);
        $doTrackers->trackername = 'Tracker A';
        $trackerId = DataGenerator::generateOne($doTrackers);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$trackerId);
        $this->assertEqual($aAudit['key_desc'],$doTrackers->trackername);
        $this->assertEqual($aAudit['trackerid'],$trackerId);
        $this->assertEqual($aAudit['clientid'],$doTrackers->clientid);
        $this->assertEqual($aAudit['trackername'],$doTrackers->trackername);

        $doTrackers->trackername = 'Tracker B';
        $doTrackers->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['trackername']['is'],$doTrackers->trackername);
        $this->assertEqual($aAudit['trackername']['was'],'Tracker A');

        $doTrackers->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['trackerid'],$trackerId);

        DataGenerator::cleanUp(array('trackers', 'audit'));
    }

    function testAuditCampaign()
    {
        global $session;
        $session['username'] = 'campaign user';
        $session['userid']   = rand(11,20);
        $session['usertype'] = rand(1,10);
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $context = 'Campaign';

        $doCampaigns->clientid = rand(20,30);
        $doCampaigns->campaignname = 'Campaign A';
        $campaignId = DataGenerator::generateOne($doCampaigns);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$campaignId);
        $this->assertEqual($aAudit['key_desc'],$doCampaigns->campaignname);
        $this->assertEqual($aAudit['campaignid'],$campaignId);
        $this->assertEqual($aAudit['clientid'],$doCampaigns->clientid);
        $this->assertEqual($aAudit['campaignname'],$doCampaigns->campaignname);

        $doCampaigns->campaignname = 'Campaign B';
        $doCampaigns->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['campaignname']['is'],$doCampaigns->campaignname);
        $this->assertEqual($aAudit['campaignname']['was'],'Campaign A');

        $doCampaigns->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['campaignid'],$campaignId);

        DataGenerator::cleanUp(array('campaigns', 'audit'));
    }

    function testAuditCampaignTrackers()
    {
        global $session;
        $session['username'] = 'campaignstrackers user';
        $session['userid']   = rand(11,20);
        $session['usertype'] = rand(1,10);
        $doCampaignsTrackers = OA_Dal::factoryDO('campaigns_trackers');
        $context = 'Campaign Tracker';

        $doCampaignsTrackers->campaignid = rand(20,30);
        $doCampaignsTrackers->trackerid  = rand(20,30);
        $campaign_trackerId = DataGenerator::generateOne($doCampaignsTrackers);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$campaign_trackerId);
        $this->assertEqual($aAudit['campaign_trackerid'],$campaign_trackerId);
        $this->assertEqual($aAudit['campaignid'],$doCampaignsTrackers->campaignid);
        $this->assertEqual($aAudit['trackerid'],$doCampaignsTrackers->trackerid);

        $doCampaignsTrackers->viewwindow = rand(1,360);
        $doCampaignsTrackers->clickwindow = rand(1,360);
        $doCampaignsTrackers->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['clickwindow']['is'],$doCampaignsTrackers->clickwindow);
        $this->assertEqual($aAudit['viewwindow']['is'],$doCampaignsTrackers->viewwindow);

        $doCampaignsTrackers->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['campaign_trackerid'],$campaign_trackerId);

        DataGenerator::cleanUp(array('campaigns_trackers', 'audit'));
    }

    function testAuditCampaignLinkTrackers()
    {
        global $session;
        $session['username'] = 'campaign user';
        $session['userid']   = rand(11,20);
        $session['usertype'] = rand(1,10);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = rand(20,30);

        $doTrackers = OA_Dal::factoryDO('trackers');
        $doTrackers->clientid = $doCampaigns->clientid;
        $doTrackers->linkcampaigns = 't';

        $trackerId = DataGenerator::generateOne($doTrackers);
        $context = 'Tracker';
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($aAudit['clientid'],$doTrackers->clientid);
        $this->assertEqual($aAudit['trackerid'],$trackerId);

        $campaignId = DataGenerator::generateOne($doCampaigns);
        $context = 'Campaign';
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($aAudit['clientid'],$doCampaigns->clientid);
        $this->assertEqual($aAudit['campaignid'],$campaignId);

        $context = 'Campaign Tracker';
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($aAudit['campaignid'],$campaignId);
        $this->assertEqual($aAudit['trackerid'],$trackerId);

        DataGenerator::cleanUp(array('campaigns', 'trackers', 'campaigns_trackers', 'audit'));
    }

    function testAuditBanner()
    {
        global $session;
        $session['username'] = 'banner user';
        $session['userid']   = rand(11,20);
        $session['usertype'] =  rand(1,10);
        $doBanners = OA_Dal::factoryDO('banners');
        $context = 'Banner';

        $doBanners->campaignid = rand(20,30);
        $doBanners->description = 'Banner A';
        $bannerId = DataGenerator::generateOne($doBanners);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$bannerId);
        $this->assertEqual($aAudit['key_desc'],$doBanners->description);
        $this->assertEqual($aAudit['bannerid'],$bannerId);
        $this->assertEqual($aAudit['description'],$doBanners->description);
        $this->assertEqual($aAudit['campaignid'],$doBanners->campaignid);

        $doBanners->description = 'Banner B';
        $doBanners->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['description']['is'],$doBanners->description);
        $this->assertEqual($aAudit['description']['was'],'Banner A');

        $doBanners->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['bannerid'],$bannerId);

        DataGenerator::cleanUp(array('banners', 'audit'));
    }

    function testAuditPreference()
    {
        global $session;
        $session['username'] = 'preference user';
        $session['userid']   = rand(11,20);
        $session['usertype'] =  rand(1,10);
        $doPreference = OA_Dal::factoryDO('preference');

        $doPreference->agencyid = 0;
        $doPreference->name = 'Default Agency';
        $agencyId = DataGenerator::generateOne($doPreference);
        $context = 'Preference';
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$doPreference->agencyid);
        $this->assertEqual($aAudit['key_desc'],$doPreference->name);
        $this->assertEqual($aAudit['agencyid'],$doPreference->agencyid);
        $this->assertEqual($aAudit['name'],$doPreference->name);

        $doPreference->name = 'Default Agency Changed';
        $doPreference->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['name']['is'],$doPreference->name);
        $this->assertEqual($aAudit['name']['was'],'Default Agency');

        $doPreference->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['agencyid'],0);
        $this->assertEqual($aAudit['name'],$doPreference->name);

        DataGenerator::cleanUp(array('preference','audit'));
    }

    function testAuditPreferenceAdvertiser()
    {
        global $session;
        $session['username'] = 'preference advertiser user';
        $session['userid']   = rand(11,20);
        $session['usertype'] =  rand(1,10);
        $doAdPreference = OA_Dal::factoryDO('preference_advertiser');

        $doAdPreference->advertiser_id = rand(2,5);
        $doAdPreference->preference = 'My Ad Pref A';
        $doAdPreference->value = 'My Ad Value A';
        $advertiserId = DataGenerator::generateOne($doAdPreference);
        $context = 'Advertiser Preference';
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$advertiserId);
        $this->assertEqual($aAudit['key_desc'],'');
        $this->assertEqual($aAudit['advertiser_id'],$advertiserId);
        $this->assertEqual($aAudit['preference'],$doAdPreference->preference);
        $this->assertEqual($aAudit['value'],$doAdPreference->value);

        $doAdPreference->value = 'My Ad Value B';
        $doAdPreference->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['value']['is'],$doAdPreference->value);
        $this->assertEqual($aAudit['value']['was'],'My Ad Value A');

        $doAdPreference->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['advertiser_id'],$doAdPreference->advertiser_id);
        $this->assertEqual($aAudit['preference'],$doAdPreference->preference);
        $this->assertEqual($aAudit['value'],$doAdPreference->value);

        DataGenerator::cleanUp(array('preference_advertiser','audit'));
    }

    function testAuditPreferencePublisher()
    {
        global $session;
        $session['username'] = 'preference publisher user';
        $session['userid']   = rand(11,20);
        $session['usertype'] =  rand(1,10);
        $doPubPreference = OA_Dal::factoryDO('preference_publisher');

        $doPubPreference->publisher_id = rand(2,5);
        $doPubPreference->preference = 'My Pub Pref A';
        $doPubPreference->value = 'My Pub Value A';
        $publisherId = DataGenerator::generateOne($doPubPreference);
        $context = 'Publisher Preference';
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$publisherId);
        $this->assertEqual($aAudit['key_desc'],'');
        $this->assertEqual($aAudit['publisher_id'],$publisherId);
        $this->assertEqual($aAudit['preference'],$doPubPreference->preference);
        $this->assertEqual($aAudit['value'],$doPubPreference->value);

        $doPubPreference->value = 'My Pub Value B';
        $doPubPreference->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['value']['is'],$doPubPreference->value);
        $this->assertEqual($aAudit['value']['was'],'My Pub Value A');

        $doPubPreference->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($aAudit['publisher_id'],$doPubPreference->publisher_id);
        $this->assertEqual($aAudit['preference'],$doPubPreference->preference);
        $this->assertEqual($aAudit['value'],$doPubPreference->value);

        DataGenerator::cleanUp(array('preference_publisher','audit'));
    }

    function testAuditAgency()
    {
        global $session;
        $session['username'] = 'admin user';
        $session['userid']   = rand(11,20);
        $session['usertype'] =  rand(1,10);

        // setup a default preference record
        // audit event 1
        $doPreference = OA_Dal::factoryDO('preference');
        $doPreference->agencyid = 0;
        $doPreference->name = 'Default Agency';
        $doPreference->language = 'English';
        $doPreference->admin_fullname = 'Default Admin';
        $doPreference->admin_email = 'admin@default.com';
        $agencyId0 = DataGenerator::generateOne($doPreference);

        // insert an agency record
        // audit event 2 & 3
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Agency';
        $doAgency->language = 'French';
        $doAgency->contact = 'Agency Admin';
        $doAgency->email = 'admin@agency.com';
        $agencyId1 = DataGenerator::generateOne($doAgency);

        // change the agency record
        // audit event 4 & 5
        $doAgency->name = 'Agency Changed';
        $doAgency->language = 'German';
        $doAgency->contact = 'Agency Admin Changed';
        $doAgency->email = 'newadmin@agency.com';
        $doAgency->update();

        // add a client for this agency
        // audit event 6
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId1;
        $doClients->clientname = 'Client A';
        $doClients->reportlastdate = '2007-04-03 18:39:45';
        $clientId = DataGenerator::generateOne($doClients);

        // delete the agency record
        // audit event 7 & 8 & 9
        $doAgency->delete();

        $aAudit = $this->_fetchAuditArrayAll();
        $this->assertEqual(count($aAudit), 9,'wrong number of audit records');

        // test 1: default agency preference insert audited
        $this->assertTrue(isset($aAudit[1]));
        $aEvent = $aAudit[1];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],1);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aEvent['context'],'Preference');
        $this->assertEqual($aEvent['userid'],$session['userid']);
        $this->assertEqual($aEvent['usertype'],$session['usertype']);
        $this->assertEqual($aEvent['username'],$session['username']);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_field'],0);
        $this->assertEqual($aEvent['array']['key_desc'],'Default Agency');
        $this->assertEqual($aEvent['array']['agencyid'],0);
        $this->assertEqual($aEvent['array']['name'],'Default Agency');
        $this->assertEqual($aEvent['array']['admin_fullname'],'Default Admin');

        // test 2: new agency insert audited
        $this->assertTrue(isset($aAudit[2]));
        $aEvent = $aAudit[2];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],2);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aEvent['context'],'Agency');
        $this->assertEqual($aEvent['userid'],$session['userid']);
        $this->assertEqual($aEvent['usertype'],$session['usertype']);
        $this->assertEqual($aEvent['username'],$session['username']);
        $this->assertEqual($aEvent['contextid'],$agencyId1);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Agency');
        $this->assertEqual($aEvent['array']['agencyid'],$agencyId1);
        $this->assertEqual($aEvent['array']['name'],'Agency');
        $this->assertEqual($aEvent['array']['contact'],'Agency Admin');

        // test 3: new agency preference insert audited
        $this->assertTrue(isset($aAudit[3]));
        $aEvent = $aAudit[3];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],3);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aEvent['context'],'Preference');
        $this->assertEqual($aEvent['userid'],$session['userid']);
        $this->assertEqual($aEvent['usertype'],$session['usertype']);
        $this->assertEqual($aEvent['username'],$session['username']);
        $this->assertEqual($aEvent['contextid'],$agencyId1);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Agency');
        $this->assertEqual($aEvent['array']['agencyid'],$agencyId1);
        $this->assertEqual($aEvent['array']['name'],'Agency');
        $this->assertEqual($aEvent['array']['admin_fullname'],'Agency Admin');

        // test 4: new agency update audited
        $this->assertTrue(isset($aAudit[4]));
        $aEvent = $aAudit[4];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],4);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_UPDATE);
        $this->assertEqual($aEvent['context'],'Agency');
        $this->assertEqual($aEvent['userid'],$session['userid']);
        $this->assertEqual($aEvent['usertype'],$session['usertype']);
        $this->assertEqual($aEvent['username'],$session['username']);
        $this->assertEqual($aEvent['contextid'],$agencyId1);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Agency Changed');
        $this->assertEqual($aEvent['array']['name']['is'],'Agency Changed');
        $this->assertEqual($aEvent['array']['name']['was'],'Agency');
        $this->assertEqual($aEvent['array']['language']['is'],'German');
        $this->assertEqual($aEvent['array']['language']['was'],'French');

        // test 5: new agency preference update audited
        $this->assertTrue(isset($aAudit[5]));
        $aEvent = $aAudit[5];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],5);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_UPDATE);
        $this->assertEqual($aEvent['context'],'Preference');
        $this->assertEqual($aEvent['userid'],$session['userid']);
        $this->assertEqual($aEvent['usertype'],$session['usertype']);
        $this->assertEqual($aEvent['username'],$session['username']);
        $this->assertEqual($aEvent['contextid'],$agencyId1);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Agency Changed');
        $this->assertEqual($aEvent['array']['name']['is'],'Agency Changed');
        $this->assertEqual($aEvent['array']['name']['was'],'Agency');
        $this->assertEqual($aEvent['array']['language']['is'],'German');
        $this->assertEqual($aEvent['array']['language']['was'],'French');

        // test 6: new client insert audited
        $this->assertTrue(isset($aAudit[6]));
        $aEvent = $aAudit[6];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],6);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aEvent['context'],'Client');
        $this->assertEqual($aEvent['userid'],$session['userid']);
        $this->assertEqual($aEvent['usertype'],$session['usertype']);
        $this->assertEqual($aEvent['username'],$session['username']);
        $this->assertEqual($aEvent['contextid'],$clientId);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Client A');
        $this->assertEqual($aEvent['array']['clientid'],$clientId);
        $this->assertEqual($aEvent['array']['clientname'],'Client A');
        $this->assertEqual($aEvent['array']['agencyid'],$agencyId1);

        // test 7: new agency client delete audited
        $this->assertTrue(isset($aAudit[7]));
        $aEvent = $aAudit[7];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],7);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aEvent['context'],'Client');
        $this->assertEqual($aEvent['userid'],$session['userid']);
        $this->assertEqual($aEvent['usertype'],$session['usertype']);
        $this->assertEqual($aEvent['username'],$session['username']);
        $this->assertEqual($aEvent['contextid'],$clientId);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Client A');
        $this->assertEqual($aEvent['array']['clientid'],$clientId);
        $this->assertEqual($aEvent['array']['clientname'],'Client A');
        $this->assertEqual($aEvent['array']['agencyid'],$agencyId1);

        // test 8: new agency preference delete audited
        $this->assertTrue(isset($aAudit[8]));
        $aEvent = $aAudit[8];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],8);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aEvent['context'],'Preference');
        $this->assertEqual($aEvent['userid'],$session['userid']);
        $this->assertEqual($aEvent['usertype'],$session['usertype']);
        $this->assertEqual($aEvent['username'],$session['username']);
        $this->assertEqual($aEvent['contextid'],$agencyId1);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Agency Changed');
        $this->assertEqual($aEvent['array']['agencyid'],$agencyId1);

        // test 9: new agency delete audited
        $this->assertTrue(isset($aAudit[9]));
        $aEvent = $aAudit[9];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],9);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aEvent['context'],'Agency');
        $this->assertEqual($aEvent['userid'],$session['userid']);
        $this->assertEqual($aEvent['usertype'],$session['usertype']);
        $this->assertEqual($aEvent['username'],$session['username']);
        $this->assertEqual($aEvent['contextid'],$agencyId1);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Agency Changed');
        $this->assertEqual($aEvent['array']['agencyid'],$agencyId1);
        $this->assertEqual($aEvent['array']['name'],'Agency Changed');

        DataGenerator::cleanUp(array('agency', 'preference', 'audit'));
    }

}
?>