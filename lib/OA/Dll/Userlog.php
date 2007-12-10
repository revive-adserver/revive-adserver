<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
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
 * @package    OpenadsDll
 * @author     Alexander J. Tarachanowicz II <aj.tarachanowicz@openads.org>
 */

// Require the following classes:
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Audit.php';
require_once MAX_PATH . '/lib/max/language/Userlog.php';
Language_Userlog::load();


/**
 * The OA_Dll_Audit class extends the OA_Dll class.
 *
 */
class OA_Dll_Userlog extends OA_Dll
{

    /**
     * Retrieves audit data for the selected context type
     *
     * @return array assoc array containing audit data
     */
    function getAuditDetail($auditId)
    {
        $oAudit = & OA_Dal::factoryDO('audit');
        $oAudit->get($auditId);

        $oAudit->details = unserialize($oAudit->details);
        $aAudit = $oAudit->toArray();
        $aAudit['name'] = $aAudit['details']['key_desc'];
        unset($aAudit['details']['key_desc']);

        // remove parent context id
        $this->_removeParentContextId($aAudit);

        //  get children details
        if ($this->hasChildren($aAudit['auditid'], $aAudit['context'])) {
            $aAudit['children'] = $this->getChildren($aAudit['auditid'], $aAudit['context']);
        }

        //  set action type
        switch($aAudit['actionid']) {
        case OA_AUDIT_ACTION_INSERT:
            $aAudit['action'] = $GLOBALS['strInsert'];
            break;
        case OA_AUDIT_ACTION_UPDATE:
            $aAudit['action'] = $GLOBALS['strUpdate'];
            break;
        case OA_AUDIT_ACTION_DELETE:
            $aAudit['action'] = $GLOBALS['strDelete'];
            break;
        }

        return $aAudit;
    }

    function getAuditLog($aParam)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oAudit = OA_Dal::factoryDO($conf['table']['audit']);

        //  apply filters
        if (!empty($aParam) && is_array($aParam)) {

            if (!empty($aParam['start_date']) && !is_null($aParam['start_date'])
                && !empty($aParam['end_date']) && !is_null($aParam['end_date']))
            {
                $where = "updated >= '". $aParam['start_date'] ." 00:00:00' AND updated <= '". $aParam['end_date'] ." 23:59:00'";
                $oAudit->whereAdd($where);
            }

            //  Display all campaigns for the selected advertiser
            if (!empty($aParam['advertiser_id']) && ($aParam['advertiser_id'] > 0)
                && empty($aParam['campaign_id']))
            {

                //  retrieve all campaigns with clientid
                $oCampaign = OA_Dal::factoryDO($conf['table']['campaigns']);
                $oCampaign->selectAdd();
                $oCampaign->selectAdd('campaignid');
                $oCampaign->clientid = $aParam['advertiser_id'];
                $numRows = $oCampaign->find();
                if ($numRows > 0) {
                    while ($oCampaign->fetch()) {
                        $aCampaign[] = $oCampaign->campaignid;
                    }
                    if (!empty($aCampaign)) {
                        $where = "context = 'Campaign' AND contextid IN (". implode(',', $aCampaign) .")";
                    }
                }

                //  retrieve all banners that belong to above campaigns
                $oBanner = OA_Dal::factoryDO($conf['table']['banners']);
                $oBanner->selectAdd();
                $oBanner->selectAdd('bannerid');
                $oBanner->whereAdd('campaignid IN ('. implode(',', $aCampaign) .')');
                $numRows = $oBanner->find();
                if ($numRows > 0) {
                    while ($oBanner->fetch()) {
                        $aBanner[] = $oBanner->bannerid;
                    }
                    if (!empty($aBanner)) {
                        $where .= " OR context = 'Banner' AND contextid IN (". implode(',', $aBanner) .")";
                        $oAudit->whereAdd($where);
                    }
                }
            }
            //  Display all banners for the selected campaign
            if (!empty($aParam['advertiser_id']) && ($aParam['advertiser_id'] > 0)
                && !empty($aParam['campaign_id']) && ($aParam['campaign_id'] > 0))
            {
                //  retrieve all banners that belong to above campaigns
                $oBanner = OA_Dal::factoryDO($conf['table']['banners']);
                $oBanner->selectAdd();
                $oBanner->selectAdd('bannerid');
                $oBanner->whereAdd('campaignid = '. $aParam['campaign_id']);
                $numRows = $oBanner->find();
                if ($numRows > 0) {
                    while ($oBanner->fetch()) {
                        $aBanner[] = $oBanner->bannerid;
                    }
                    if (!empty($aBanner)) {
                        $oAudit->whereAdd("context = 'Banner' AND contextid IN (". implode(',', $aBanner) .")");
                    }
                }
            }
            //  Display all zones for the selected publisher
            if (!empty($aParam['publisher_id']) && ($aParam['publisher_id'] > 0)
                && empty($aParam['zone_id']))
            {
                $where = "context = 'Publisher' AND contextid = {$aParam['publisher_id']}";

                //  retrieve all zones for the selected publisher
                $oZone = OA_Dal::factoryDO($conf['table']['zones']);
                $oZone->selectAdd();
                $oZone->selectAdd('zoneid');
                $oZone->affiliateid = $aParam['publisher_id'];
                $numRows = $oZone->find();
                if ($numRows > 0) {
                    while($oZone->fetch()) {
                        $aZone[] = $oZone->zoneid;
                    }
                    if (!empty($aZone)) {
                        $where .= " OR context = 'Zone' AND contextid IN (". implode(',', $aZone) .")";
                    }
                }

                //  retrieve all channels for the selected publisher
                $oChannel = OA_Dal::factoryDO($conf['table']['channel']);
                $oChannel->selectAdd();
                $oChannel->selectAdd('channelid');
                $oChannel->affiliateid = $aParam['publisher_id'];
                $numRows = $oChannel->find();
                if ($numRows > 0) {
                    while($oChannel->fetch()) {
                        $aChannel[] = $oChannel->channelid;
                    }
                    if (!empty($aCampaign)) {
                        $where .= " OR context = 'Channel' AND contextid IN (". implode(',', $aChannel) .")";
                    }
                }
                $oAudit->whereAdd($where);
            }

            //  Display all channels for the selected zone
            if (!empty($aParam['publisher_id']) && ($aParam['publisher_id'] > 0)
                && !empty($aParam['zone_id']) && ($aParam['zone_id'] > 0))
            {
                $oAudit->whereAdd("context = 'Zone' AND contextid = {$aParam['zone_id']}");
            }

            //  Make sure that no items that are children are not displayed
            $oAudit->whereAdd('parentid IS NULL');

            if ($aParam['order']) {
                if ($aParam['order'] == 'down') {
                    $oAudit->orderBy($aParam['listorder'] .' ASC');
                } else {
                    $oAudit->orderBy($aParam['listorder'] .' DESC');
                }
            }

            if ((!empty($aParam['startRecord']) || $aParam['startRecord'] >= 0) && $aParam['perPage']) {
                $oAudit->limit($aParam['startRecord'], $aParam['perPage']);
            }

            $numRows = $oAudit->find();

            while ($oAudit->fetch()) {
                $aAudit = $oAudit->toArray();
                $aAudit['details'] = unserialize($aAudit['details']);

                //  set action type
                switch($aAudit['actionid']) {
                case OA_AUDIT_ACTION_INSERT:
                    $aAudit['action'] = $GLOBALS['strInserted'];
                    break;
                case OA_AUDIT_ACTION_UPDATE:
                    $aAudit['action'] = $GLOBALS['strUpdated'];
                    break;
                case OA_AUDIT_ACTION_DELETE:
                    $aAudit['action'] = $GLOBALS['strDeleted'];
                    break;
                }

                if ($aAudit['actionid'] != OA_AUDIT_ACTION_DELETE) {
                    switch($aAudit['context']) {
                    case 'Affiliate':
                        if (empty($aAudit['username'])) {
                            $aAudit['username'] = 'Installer';
                        }
                        break;
                    case 'Banner':
                        $aAudit['parentcontext'] = 'Campaign';
                        break;
                    case 'Campaign':
                        $aAudit['parentcontext'] = 'Client';
                        break;
                    case 'Channel':
                    case 'Zone':
                        $aAudit['parentcontext'] = 'Affiliate';
                        break;
                    }

                    $aAudit['parentcontextid'] = $this->getParentID($aAudit['context'], $aAudit['details']);
                } else {
                    $aAudit['hasChildren'] = $this->hasChildren($aAudit['auditid'], $aAudit['contextid']);
                }
                $aAuditInfo[] = $aAudit;
            }
        }
        return $aAuditInfo;
    }

    function getParentID($itemType, $itemDetails)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        switch ($itemType) {
        case 'Campaign':
            return $itemDetails['clientid'];
        case 'Banner':
            return $itemDetails['campaignid'];
        case 'Channel':
        case 'Zone':
            return $itemDetails['affiliateid'];
        }
    }

    function getChildren($auditID, $itemContext)
    {
        switch ($itemContext) {
        case 'Banner':
            $context = 'Ad Zone Association';
            break;
        }

        $oAudit = & OA_Dal::factoryDO($GLOBALS['_MAX']['CONF']['table']['audit']);
        $oAudit->parentid = $auditID;
        $oAudit->context  = $context;
        $numRows = $oAudit->find();

        while($oAudit->fetch()) {
            $aAudit = $oAudit->toArray();
            //  check if child has children
            if ($this->hasChildren($aAudit['auditid'], $aAudit['context'])) {
                $aAudit['children'] = $this->getChildren($aAudit['auditid'], $aAudit['context']);
            }
            $aChildren[] = $aAudit;
        }

        return $aChildren;
    }

    function hasChildren($auditID, $itemContext)
    {
        switch ($itemContext) {
        case 'Banner':
            $context = 'Ad Zone Association';
            break;
        }

        $oAudit = & OA_Dal::factoryDO($GLOBALS['_MAX']['CONF']['table']['audit']);
        $oAudit->parentid = $auditID;
        $oAudit->context  = $context;
        $numRows = $oAudit->find();

        return ($numRows > 0) ? true : false;
    }

    function _removeParentContextId(&$aAudit)
    {
        switch ($aAudit['context']) {
        case 'Ad Zone Association':
        case 'Delivery Limitation':
        case 'Image':
            if (!is_array($aAudit['details']['bannerid'])) {
                unset($aAudit['details']['banner']);
            }
            break;
        case 'Banner':
        case 'Campaign Tracker':
            if (!is_array($aAudit['details']['campaignid'])) {
                unset($aAudit['details']['campaignid']);
            }
            break;
        case 'Campaign':
        case 'Tracker':
            if (!is_array($aAudit['details']['clientid'])) {
                unset($aAudit['details']['clientid']);
            }
            break;
        case 'Channel':
        case 'Zone':
            if (!is_array($aAudit['details']['affiliateid'])) {
                unset($aAudit['details']['affiliateid']);
            }
            break;
        }
    }

    function getAuditLogForCampaignWidget($aParam='')
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oAudit = OA_Dal::factoryDO($conf['table']['audit']);

        $oDate = & new Date(OA::getNow());
        $oDate->subtractSeconds(60*60*24*7);
        $oAudit->whereAdd("context = 'Campaign'");
        $oAudit->whereAdd("updated >= '".$oDate->format('%Y%m%d')."'");
        $oAudit->whereAdd('parentid IS NULL');
        $oAudit->orderBy('auditid DESC');
        $oAudit->limit(0, 5);

        $numRows = $oAudit->find();

        while ($oAudit->fetch()) {
            $aAudit = $oAudit->toArray();
            $aAudit['details'] = unserialize($aAudit['details']);
            $aResult[] = $aAudit;
        }
        return $aResult;
    }

}
?>