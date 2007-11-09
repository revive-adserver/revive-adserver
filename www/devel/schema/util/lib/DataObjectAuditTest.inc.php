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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Core.php';


class DataObjectAuditTest
{
    var $doAudit;

    /**
     * The constructor method.
     */
    function DataObjectAuditTest()
    {
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = true;
    }

    function _createDataObjectAudit()
    {
        $this->doAudit = OA_Dal::factoryDO('userlog');
    }

    function createTable()
    {
        if (count(OA_DB_Table::listOATablesCaseSensitive('audit')>0))
        {
            $oTable = OA_DB_Table_Core::singleton();
            $oTable->dropTable($GLOBALS['_MAX']['CONF']['table']['prefix'].'audit');
        }
        $oTable->createTable('audit');
        $this->doAudit = OA_Dal::factoryDO('audit');
    }

    /**
     * fetch a structure containing one audit record without details
     *
     * @param array $aResult
     * @param string $context
     * @param integer $actionid
     */
    function _fetchAuditArray(&$aResult, $context, $actionid)
    {
        $this->doAudit = OA_Dal::factoryDO('audit');
        $this->doAudit->context = $context;
        $this->doAudit->actionid = $actionid;
        $this->doAudit->find();
        $result = $this->doAudit->fetch();
        $idx = $this->doAudit->auditid;
        $aResult[$idx]['actionid']  = $this->doAudit->actionid;
        $aResult[$idx]['context']   = $this->doAudit->context;
        $aResult[$idx]['contextid'] = $this->doAudit->contextid;
        $aResult[$idx]['username']  = $this->doAudit->username;
        $aResult[$idx]['usertype']  = $this->doAudit->usertype;
        $aResult[$idx]['userid']    = $this->doAudit->userid;
        $aResult[$idx]['updated']   = $this->doAudit->updated;
        $array     = unserialize($this->doAudit->details);
        //$aResult[$idx]['key_field'] = $array['key_field'];
        $aResult[$idx]['key_desc']  = $array['key_desc'];
    }

    /**
     * fetch a structure containing one audit record with details
     *
     * @param array $aResult
     * @param string $context
     * @param integer $actionid
     */
    function fetchAuditData($auditid)
    {
        $aResult = array();
        $doAudit = OA_Dal::factoryDO('audit');
        if ($doAudit->get('auditid', $auditid)==1)
        {
            $aResult = unserialize($doAudit->details);
            $aResult['actionid']  = $doAudit->actionid;
            //unset($aResult[$aResult['key_field']]);
            //unset($aResult['key_field']);
            unset($aResult['key_desc']);
        }
        return $aResult;
    }

    /**
     * fetch a structure containing all audit records without details
     *
     * @param array $aResult
     * @param string $context
     * @param integer $actionid
     */
    function _fetchAuditArrayAll(&$aResult)
    {
        $this->doAudit = OA_Dal::factoryDO('audit');
        $aRows = $this->doAudit->getAll('',true);
        foreach ($aRows as $k => $aRow)
        {
            $idx = $aRow['auditid'];
            $aResult[$idx] = $aRow;
            $array     = unserialize($aRow['details']);
            //$aResult[$idx]['key_field'] = $array['key_field'];
            $aResult[$idx]['key_desc']  = $array['key_desc'];
        }
    }

    function auditCampaign()
    {
        global $session;
        $session['username'] = 'John Doe';
        $session['userid']   = rand(11-20);
        $session['usertype'] =  rand(1-10);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $aResult = array();
        $context = 'Campaign';

        $doCampaigns->clientid = rand(20,30);
        $doCampaigns->campaignname = 'My New Campaign';
        $doCampaigns->activate = OA::getNow('Y-m-d');
        $campaignId = DataGenerator::generateOne($doCampaigns);
        //$this->_fetchAuditArray($aResult, $context, OA_AUDIT_ACTION_INSERT);

        $doCampaigns->campaignname = 'My Changed Campaign';
        $doCampaigns->active = 'f';
        $doCampaigns->expire = OA::getNow('Y-m-d');
        $doCampaigns->update();
        //$this->_fetchAuditArray($aResult, $context, OA_AUDIT_ACTION_UPDATE);

        $doCampaigns->deleteById($campaignId);
        //$this->_fetchAuditArray($aResult, $context, OA_AUDIT_ACTION_DELETE);

        $this->_fetchAuditArrayAll($aResult);

        return $aResult;
    }


    function auditBanner()
    {
        global $session;
        $session['username'] = 'Fred Doe';
        $session['userid']   = rand(11-20);
        $session['usertype'] =  rand(1-10);

        $doBanners = OA_Dal::factoryDO('banners');
        $aResult = array();
        $context = 'Banner';

        $doBanners->campaignid = rand(20,30);
        $doBanners->description = 'My New Banner';
        $doBanners->contenttype = 'gif';
        $doBanners->storagetype = 'sql';
        $doBanners->alt_contenttype = 'txt';
        $bannerId = DataGenerator::generateOne($doBanners);
        //$this->_fetchAuditArray($aResult, $context, OA_AUDIT_ACTION_INSERT);

        $doBanners->description = 'My Changed Banner';
        $doBanners->active = 'f';
        $doBanners->update();
        //$this->_fetchAuditArray($aResult, $context, OA_AUDIT_ACTION_UPDATE);

        $doBanners->deleteById($bannerId);
        //$this->_fetchAuditArray($aResult, $context, OA_AUDIT_ACTION_DELETE);

        $this->_fetchAuditArrayAll($aResult);

        return $aResult;
    }

    function auditZone()
    {
        global $session;
        $session['username'] = 'Zoe Doe';
        $session['userid']   = rand(11,20);
        $session['usertype'] = rand(1,10);
        $doZone = OA_Dal::factoryDO('zones');
        $aResult = array();
        $context = 'Zone';

        $doZone->agencyid = rand(20,30);
        $doZone->affiliateid = rand(20,30);
        $doZone->zonename = 'Zone A';
        $zoneId = DataGenerator::generateOne($doZone);
        //$this->_fetchAuditArray($aResult, $context, OA_AUDIT_ACTION_INSERT);

        $doZone->zonename = 'Zone B';
        $doZone->update();
        //$this->_fetchAuditArray($aResult, $context, OA_AUDIT_ACTION_UPDATE);

        $doZone->delete();
        //$this->_fetchAuditArray($aResult, $context, OA_AUDIT_ACTION_DELETE);

        $this->_fetchAuditArrayAll($aResult);

        return $aResult;
    }

    function auditClient()
    {
        global $session;
        $session['username'] = 'Jane Doe';
        $session['userid']   = rand(11-20);
        $session['usertype'] =  rand(1-10);

        $doClients = OA_Dal::factoryDO('clients');
        $aResult = array();
        $context = 'Client';

        $doClients->agencyid = rand(20,30);
        $doClients->clientname = 'My New Client';
        $doClients->clientusername = 'client user';
        $doClients->contact = 'Mr User';
        $clientId = DataGenerator::generateOne($doClients);
        //$this->_fetchAuditArray($aResult, $context, OA_AUDIT_ACTION_INSERT);

        $doClients->clientname = 'My Changed Client';
        $doClients->contact = 'Ms User';
        $doClients->update();
        //$this->_fetchAuditArray($aResult, $context, OA_AUDIT_ACTION_UPDATE);

        $doClients->deleteById($clientId);
        //$this->_fetchAuditArray($aResult, $context, OA_AUDIT_ACTION_DELETE);

        $this->_fetchAuditArrayAll($aResult);

        return $aResult;
    }

/*    function auditSet()
    {
        $this->createTable();
        global $session;
        $session['username'] = 'Joe Agency';
        $session['userid']   =  rand(11-20);
        $session['usertype'] =  rand(1-10);
        $aResult = array();

        // insert a client
        $doClients = OA_Dal::factoryDO('clients');

        $doClients->agencyid = 0;
        $doClients->clientname = 'My New Client';
        $doClients->clientusername = 'client user';
        $doClients->contact = 'Mr User';
        $clientId = DataGenerator::generateOne($doClients);

        // insert a campaign
        $doCampaigns = OA_Dal::factoryDO('campaigns');

        $doCampaigns->clientid = $clientId;
        $doCampaigns->campaignname = 'My New Campaign';
        $doCampaigns->activate = OA::getNow('Y-m-d');
        $campaignId = DataGenerator::generateOne($doCampaigns);

        // insert a banner
        $doBanners = OA_Dal::factoryDO('banners');

        $doBanners->campaignid = $campaignId;
        $doBanners->description = 'My New Banner';
        $doBanners->contenttype = 'gif';
        $doBanners->storagetype = 'sql';
        $doBanners->alt_contenttype = 'txt';
        $bannerId = DataGenerator::generateOne($doBanners);

        // change the client
        $doClients->clientname = 'My Changed Client';
        $doClients->contact = 'Ms User';
        $doClients->update();


        // change the campaign
        $doCampaigns->campaignname = 'My Changed Campaign';
        $doCampaigns->active = 'f';
        $doCampaigns->expire = OA::getNow('Y-m-d');
        $doCampaigns->update();

        // change the banner
        $doBanners->description = 'My Changed Banner';
        $doBanners->active = 'f';
        $doBanners->update();

        $doBanners->deleteById($bannerId);

        $doCampaigns->deleteById($campaignId);

        $doClients->deleteById($clientId);

        $aResult = array();
        $this->_fetchAuditArrayAll($aResult);
        return $aResult;
    }
*/

    function auditAgency()
    {
        global $session;
        $session['username'] = 'Default Admin';
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
        $doAgency->name = 'Agency A';
        $doAgency->language = 'French';
        $doAgency->contact = 'Agency Admin A';
        $doAgency->email = 'adminA@agency.com';
        $agencyId1 = DataGenerator::generateOne($doAgency);

        // change the agency record
        // audit event 4 & 5
        $doAgency->name = 'Agency B';
        $doAgency->language = 'German';
        $doAgency->contact = 'Agency Admin B';
        $doAgency->email = 'adminB@agency.com';
        $doAgency->update();

        // add some clients for this agency
        // audit event 6 & 7
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId1;
        $doClients->clientname = 'Client A';
        $doClients->reportlastdate = '2007-04-03 18:39:45';
        $aClientId = DataGenerator::generateOne($doClients);

        $doAgency->onDeleteCascade = true;
        // delete the agency record
        // audit event 8 & 9
        $doAgency->delete();

        $aResult = array();
        $this->_fetchAuditArrayAll($aResult);
        return $aResult;
    }
}
?>