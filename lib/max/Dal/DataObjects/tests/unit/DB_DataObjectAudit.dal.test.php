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
 * A class for testing DataObject Auditing methods
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
        $doAudit->orderBy('auditid');
        $n = $doAudit->find();
        $result = $doAudit->fetch();
        $this->assertEqual($doAudit->context, $context);
        $this->assertEqual($doAudit->actionid, $actionid);
        if ($n>1)
        {
            $aAudit[1] = clone($doAudit);
            for ($i=2;$i<=$n;$i++)
            {
                $result = $doAudit->fetch();
                $this->assertEqual($doAudit->context, $context);
                $this->assertEqual($doAudit->actionid, $actionid);
                $aAudit[$i] = clone($doAudit);
            }
            return $aAudit;
        }
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

        $doZone = OA_Dal::staticGetDO('zones', $zoneId);
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

        $doChannel = OA_Dal::staticGetDO('channel', $channelId);
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

        $doCategory = OA_Dal::staticGetDO('category', $categoryId);
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

        $doClients = OA_Dal::staticGetDO('clients', $clientId);
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

        $doAffiliate = OA_Dal::staticGetDO('affiliates', $affiliateId);
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

        $doTrackers = OA_Dal::staticGetDO('trackers', $trackerId);
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

        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
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
        $this->assertNotNull($campaign_trackerId,'failed to insert campaign_tracker');
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$campaign_trackerId,'expected contextid '.$campaign_trackerId);
        $this->assertEqual($aAudit['campaign_trackerid'],$campaign_trackerId,'expected (details) campaign_trackerid '.$campaign_trackerId);
        $this->assertEqual($aAudit['campaignid'],$doCampaignsTrackers->campaignid,'campaignid='.$doCampaignsTrackers->campaignid);
        $this->assertEqual($aAudit['trackerid'],$doCampaignsTrackers->trackerid.'trackerid='.$doCampaignsTrackers->trackerid);

        $doCampaignsTrackers = OA_Dal::staticGetDO('campaigns_trackers', $campaign_trackerId);
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

        $doBanners = OA_Dal::staticGetDO('banners', $bannerId);
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

    function testAuditAcls()
    {
        global $session;
        $session['username'] = 'acls user';
        $session['userid']   = rand(11,20);
        $session['usertype'] =  rand(1,10);
        $doBanners = OA_Dal::factoryDO('acls');
        $context = 'Delivery Limitation';

        $doAcls = OA_Dal::factoryDO('acls');
        $aResult = array();
        $context = 'Delivery Limitation';

        $bannerId = 99;

        $doAcls->bannerid = $bannerId;
        $doAcls->logical = 'and';
        $doAcls->type = 'Geo:Country';
        $doAcls->comparison = '==';
        $doAcls->data = 'AF,DZ,AD';
        $doAcls->executionorder = 0;

        $aclsId = DataGenerator::generateOne($doAcls);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$bannerId);
        $this->assertEqual($aAudit['key_desc'],$doAcls->type);
        $this->assertEqual($aAudit['bannerid'],$bannerId);
        $this->assertEqual($aAudit['logical'],$doAcls->logical);
        $this->assertEqual($aAudit['type'],$doAcls->type);
        $this->assertEqual($aAudit['comparison'],$doAcls->comparison);
        $this->assertEqual($aAudit['data'],$doAcls->data);
        $this->assertEqual($aAudit['executionorder'],$doAcls->executionorder);

        $doAcls = OA_Dal::staticGetDO('acls', $bannerId);
        $doAcls->data = 'AX,EZ,AZ';
        $doAcls->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$bannerId);
        $this->assertEqual($aAudit['key_desc'],$doAcls->type);
        $this->assertEqual($aAudit['data']['is'],$doAcls->data);
        $this->assertEqual($aAudit['data']['was'],'AF,DZ,AD');

        $doAcls->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,$session['username']);
        $this->assertEqual($oAudit->contextid,$bannerId);
        $this->assertEqual($aAudit['key_desc'],$doAcls->type);
        $this->assertEqual($aAudit['bannerid'],$bannerId);
        $this->assertEqual($aAudit['logical'],$doAcls->logical);
        $this->assertEqual($aAudit['type'],$doAcls->type);
        $this->assertEqual($aAudit['comparison'],$doAcls->comparison);
        $this->assertEqual($aAudit['data'],$doAcls->data);
        $this->assertEqual($aAudit['executionorder'],$doAcls->executionorder);

        DataGenerator::cleanUp(array('acls', 'audit'));
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
        $doAgency = OA_Dal::staticGetDO('agency', $agencyId1);
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
        // audit event 7 & 8 & 9 (1 agency, 1 client, 1 pref)
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

        // test 7: new agency delete audited
        $this->assertTrue(isset($aAudit[7]));
        $aEvent = $aAudit[7];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],7);
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

        // test 8: new agency client delete audited
        $this->assertTrue(isset($aAudit[8]));
        $aEvent = $aAudit[8];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],8);
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

        // test 9: new agency preference delete audited
        $this->assertTrue(isset($aAudit[9]));
        $aEvent = $aAudit[9];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],9);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aEvent['context'],'Preference');
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

    function testAuditParentId()
    {
        // Insert a banner with parents
        global $session;
        $session['username'] = 'banner user';
        $session['userid']   = rand(11,20);
        $session['usertype'] =  rand(1,10);
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->description = 'Banner A';
        $bannerId = DataGenerator::generateOne($doBanners, true);
        $campaignId = DataGenerator::getReferenceId('campaigns');

        // Delete the campaign
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $doCampaigns->delete();

        // Test the campaign auditid == banner parentid
        $oAuditCampaign = $this->_fetchAuditRecord('Campaign', OA_AUDIT_ACTION_DELETE);
        $this->assertNull($oAuditCampaign->parentid);

        $oAuditBanner = $this->_fetchAuditRecord('Banner', OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($oAuditCampaign->auditid, $oAuditBanner->parentid);

        DataGenerator::cleanUp(array('campaigns', 'banners', 'audit'));

    }

    /**
     * auditing a more complex scenario
     * create a banner - this should create a default assoc between banner and zone 0
     * create a zone and link the banner to the new zone
     * delete the zone - this should delete the linked assoc
     * delete the banner - this should delete the default assoc between banner and zone 0
     */
    function testAuditAdZoneAssoc()
    {
        global $session;
        $session['username'] = 'a user';
        $session['userid']   = rand(11,20);
        $session['usertype'] =  rand(1,10);

        $doBanners = OA_Dal::factoryDO('banners');
        $context = 'Banner';

        // insert a banner
        $doBanners->campaignid = rand(20,30);
        $doBanners->description = 'Banner A';
        $bannerId = DataGenerator::generateOne($doBanners);

        $doZone = OA_Dal::factoryDO('zones');
        $context = 'Zone';

        // insert a zone
        $doZone->affiliateid = rand(20,30);
        $doZone->zonename = 'Zone A';
        $zoneId = DataGenerator::generateOne($doZone);

        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $context = 'Ad Zone Association';

        // link the banner and the zone
        $doAdZoneAssoc->ad_id = $bannerId;
        $doAdZoneAssoc->zone_id = $zoneId;
        $doAdZoneAssoc->link_type = 99;
        $doAdZoneAssoc->priority = 1;
        $doAdZoneAssoc->priority_factor = 2;
        $doAdZoneAssoc->to_be_delivered = 1;
        $adZoneAssocId = $doAdZoneAssoc->insert();

        // deleting a zone should trigger deletion of assocs linked to that zone
        $doZone->delete();

        // deleting a banner should trigger deletion of default assoc
        // (also other zone assocs, could test that by deleting banner without deleting zone)
        $doBanners->delete();

        $aResult = $this->_fetchAuditArrayAll();

        // Test 1 :test the insert banner audit
        $aAudit = $aResult[1];
        $this->assertEqual($aAudit['auditid'],1);
        $this->assertEqual($aAudit['actionid'],OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aAudit['username'],$session['username']);
        $this->assertEqual($aAudit['contextid'],$bannerId);
        $this->assertEqual($aAudit['array']['key_desc'],$doBanners->description);
        $this->assertEqual($aAudit['array']['bannerid'],$bannerId);
        $this->assertEqual($aAudit['array']['description'],$doBanners->description);
        $this->assertEqual($aAudit['array']['campaignid'],$doBanners->campaignid);

        // Test 2 :test the insert (default) adzoneassoc audit
        $aAudit = $aResult[2];
        $this->assertEqual($aAudit['auditid'],2);
        $this->assertEqual($aAudit['actionid'],OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aAudit['username'],$session['username']);
        $this->assertEqual($aAudit['contextid'],$adZoneAssocId-1);
        $this->assertEqual($aAudit['array']['key_desc'],'Ad #'.$bannerId.' -> Zone #0');
        $this->assertEqual($aAudit['array']['ad_id'],$bannerId);
        $this->assertEqual($aAudit['array']['zone_id'],0);
        $this->assertEqual($aAudit['array']['link_type'],0);
        $this->assertNull($aAudit['array']['priority']);
        $this->assertNull($aAudit['array']['priority_factor']);
        $this->assertNull($aAudit['array']['to_be_delivered']);

        // Test 3 :test the insert zone audit
        $aAudit = $aResult[3];
        $this->assertEqual($aAudit['auditid'],3);
        $this->assertEqual($aAudit['actionid'],OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aAudit['username'],$session['username']);
        $this->assertEqual($aAudit['contextid'],$zoneId);
        $this->assertEqual($aAudit['array']['key_desc'],$doZone->zonename);
        $this->assertEqual($aAudit['array']['zoneid'],$zoneId);
        $this->assertEqual($aAudit['array']['zonename'],$doZone->zonename);
        $this->assertEqual($aAudit['array']['affiliateid'],$doZone->affiliateid);

        // Test 4: test the insert (user linked) adzoneassoc audit
        $aAudit = $aResult[4];
        $this->assertEqual($aAudit['auditid'],4);
        $this->assertEqual($aAudit['actionid'],OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aAudit['username'],$session['username']);
        $this->assertEqual($aAudit['contextid'],$adZoneAssocId);
        $this->assertEqual($aAudit['array']['key_desc'],'Ad #'.$bannerId.' -> Zone #'.$zoneId);
        $this->assertEqual($aAudit['array']['ad_id'],$bannerId);
        $this->assertEqual($aAudit['array']['zone_id'],$zoneId);
        $this->assertEqual($aAudit['array']['link_type'], 99);
        $this->assertEqual($aAudit['array']['priority'],   1);
        $this->assertEqual($aAudit['array']['priority_factor'], 2);
        $this->assertEqual($aAudit['array']['to_be_delivered'],'true');

        // Test 5 :test the delete zone audit
        $aAudit = $aResult[5];
        $this->assertEqual($aAudit['auditid'],5);
        $this->assertEqual($aAudit['actionid'],OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aAudit['username'],$session['username']);
        $this->assertEqual($aAudit['contextid'],$zoneId);
        $this->assertEqual($aAudit['array']['key_desc'],$doZone->zonename);
        $this->assertEqual($aAudit['array']['zoneid'],$zoneId);
        $this->assertEqual($aAudit['array']['zonename'],$doZone->zonename);
        $this->assertEqual($aAudit['array']['affiliateid'],$doZone->affiliateid);

        // Test 6: test the delete (user linked) adzoneassoc audit
        $aAudit = $aResult[6];
        $this->assertEqual($aAudit['auditid'],6);
        $this->assertEqual($aAudit['actionid'],OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aAudit['username'],$session['username']);
        $this->assertEqual($aAudit['contextid'],$adZoneAssocId);
        $this->assertEqual($aAudit['array']['key_desc'],'Ad #'.$bannerId.' -> Zone #'.$zoneId);
        $this->assertEqual($aAudit['array']['ad_id'],$bannerId);
        $this->assertEqual($aAudit['array']['zone_id'],$zoneId);
        $this->assertEqual($aAudit['array']['link_type'], 99);
        $this->assertEqual($aAudit['array']['priority'],   1);
        $this->assertEqual($aAudit['array']['priority_factor'], 2);
        $this->assertEqual($aAudit['array']['to_be_delivered'],'true');

        // Test 7 :test the delete banner audit
        $aAudit = $aResult[7];
        $this->assertEqual($aAudit['auditid'],7);
        $this->assertEqual($aAudit['actionid'],OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aAudit['username'],$session['username']);
        $this->assertEqual($aAudit['contextid'],$bannerId);
        $this->assertEqual($aAudit['array']['key_desc'],$doBanners->description);
        $this->assertEqual($aAudit['array']['bannerid'],$bannerId);
        $this->assertEqual($aAudit['array']['description'],$doBanners->description);
        $this->assertEqual($aAudit['array']['campaignid'],$doBanners->campaignid);

        // Test 8: test the delete (default) audit result
        $aAudit = $aResult[8];
        $this->assertEqual($aAudit['auditid'],8);
        $this->assertEqual($aAudit['actionid'],OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aAudit['username'],$session['username']);
        $this->assertEqual($aAudit['contextid'],$adZoneAssocId-1);
        $this->assertEqual($aAudit['array']['key_desc'],'Ad #'.$bannerId.' -> Zone #0');
        $this->assertEqual($aAudit['array']['ad_id'],$bannerId);
        $this->assertEqual($aAudit['array']['zone_id'], 0);
        $this->assertEqual($aAudit['array']['link_type'],0);
        $this->assertEqual($aAudit['array']['priority'], 0);
        $this->assertEqual($aAudit['array']['priority_factor'], 0);
        $this->assertEqual($aAudit['array']['to_be_delivered'], 0);

        DataGenerator::cleanUp(array('banners', 'zones', 'ad_zone_assoc', 'audit'));
    }


}
?>