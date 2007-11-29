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
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->get($auditId);

        $oAudit->details = unserialize($oAudit->details);
        $aAudit = $oAudit->toArray();

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
                $aAudit['parentcontextid'] = $this->getParentID($aAudit['contextid'], $aAudit['context']);

                $aAuditInfo[] = $aAudit;
            }

        }
        return $aAuditInfo;
    }

    function getParentID($itemID, $itemType)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        switch ($itemType) {
        case 'Campaign':
            $oCampaign = OA_Dal::factoryDO($conf['table']['campaigns']);
            $oCampaign->selectAdd();
            $oCampaign->selectAdd('clientid');
            $oCampaign->get($itemID);
            return $oCampaign->clientid;
        case 'Banner':
            $oBanner = OA_Dal::factoryDO($conf['table']['banners']);
            $oBanner->selectAdd();
            $oBanner->selectAdd('campaignid');
            $oBanner->get($itemID);
            return $oBanner->campaignid;
        case 'Channel':
            $oChannel = OA_Dal::factoryDO($conf['table']['channel']);
            $oChannel->selectAdd();
            $oChannel->selectAdd('affiliateid');
            $oChannel->get($itemID);
            return $oChannel->affiliateid;
        case 'Zone':
            $oZone = OA_Dal::factoryDO($conf['table']['zones']);
            $oZone->selectAdd();
            $oZone->selectAdd('affiliateid');
            $oZone->get($itemID);
            return $oZone->affiliateid;
        }
    }
}
?>