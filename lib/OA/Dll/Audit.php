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
require_once 'Date.php';

require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Audit.php';
require_once MAX_PATH . '/lib/max/language/Userlog.php';
Language_Userlog::load();


/**
 * The OA_Dll_Audit class extends the OA_Dll class.
 *
 */
class OA_Dll_Audit extends OA_Dll
{

    /**
     * Retrieves audit data for the selected context type
     *
     * @param int $auditId Audit ID
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

        $aAudit['action'] = $this->getActionName($aAudit['actionid']);

        return $aAudit;
    }

    /**
     * Gets a log of audit events
     *
     * @param array $aParam An assoc array containing various parameters
     *              $aParam = array('start_date'        => '2008-01-01',    // Date to begin filtering
     *                              'end_date'          => '2008-01-01',    // Date to end filtering
     *                              'advertiser_id'     => 123,             // Display all events for the specified advertiser
     *                                                                      // can be used in conjuction with campaign_id and banner_id
     *                              'campaign_id'       => 311,             // Display all events for the specified campaign
     *                              'banner_id'         => 1062,            // Display all events for the specified banner
     *                              'publisher_id'      => 3,               // Display all events for the specified publisher
     *                                                                      // can be used in conjuction with zone_id
     *                              'zone_id'           => 32,              // Display all events for the specified zone
     *                              'order'             => 'timestamp',     // DB column to order by
     *                              'listorder'         => 'down',          // Order direction
     *                              'startRecord'       => 0,               // Record to begin paging
     *                              'perPage'           => 10               // Number of items displayed per page
     *
     * @return array an assoc array containing the audit events for the specified parameters
     */
    function getAuditLog($aParam)
    {
        $oAudit = OA_Dal::factoryDO('audit');

        //  apply filters
        if (!empty($aParam['account_id'])) {
            $oAudit->account_id = $aParam['account_id'];
        }

        if (!empty($aParam) && is_array($aParam)) {

            if (!empty($aParam['start_date']) && !is_null($aParam['start_date'])
                && !empty($aParam['end_date']) && !is_null($aParam['end_date']))
            {
                $oStartDate = new Date($aParam['start_date']);
                $oStartDate->toUTC();
                $oEndDate = new Date($aParam['end_date']);
                $oEndDate->addSpan(new Date_Span('1-0-0-0'));
                $oEndDate->toUTC();

                $oAudit->whereAdd('updated >= '.DBC::makeLiteral($oStartDate->format('%Y-%m-%d %H:%M:%S')));
                $oAudit->whereAdd('updated < '.DBC::makeLiteral($oEndDate->format('%Y-%m-%d %H:%M:%S')));
            }


            //  Display all campaigns for the selected advertiser
            if (!empty($aParam['advertiser_id']) && ($aParam['advertiser_id'] > 0)
                && empty($aParam['campaign_id']))
            {
                //  Display advertiser being inserted
                $where = "context = 'Client' AND contextid = {$aParam['advertiser_id']}";
                $oAudit->whereAdd($where);

                //  retrieve all campaigns with clientid
                $oCampaign = OA_Dal::factoryDO('campaigns');
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
                        $oAudit->whereAdd($where, 'OR');
                    }
                }
                //  retrieve all banners that belong to above campaigns
                $oBanner = OA_Dal::factoryDO('banners');
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
                        $oAudit->whereAdd($where, 'OR');
                    }
                }
            }
            //  Display all banners for the selected campaign
            if (!empty($aParam['advertiser_id']) && ($aParam['advertiser_id'] > 0)
                && !empty($aParam['campaign_id']) && ($aParam['campaign_id'] > 0))
            {
                //  display campaign being inserted
                $where = " context = 'Campaign' AND contextid = {$aParam['campaign_id']}";
                $oAudit->whereAdd($where);
                //  retrieve all banners that belong to above campaigns
                $oBanner = OA_Dal::factoryDO('banners');
                $oBanner->selectAdd();
                $oBanner->selectAdd('bannerid');
                $oBanner->whereAdd('campaignid = '. $aParam['campaign_id']);
                $numRows = $oBanner->find();
                if ($numRows > 0) {
                    while ($oBanner->fetch()) {
                        $aBanner[] = $oBanner->bannerid;
                    }
                    if (!empty($aBanner)) {
                        $oAudit->whereAdd("context = 'Banner' AND contextid IN (". implode(',', $aBanner) .")", 'OR');
                    }
                }
            }
            //  Display all zones for the selected publisher
            if (!empty($aParam['publisher_id']) && ($aParam['publisher_id'] > 0)
                && empty($aParam['zone_id']))
            {
                $where = "context = 'Publisher' AND contextid = {$aParam['publisher_id']}";

                //  retrieve all zones for the selected publisher
                $oZone = OA_Dal::factoryDO('zones');
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
                $oChannel = OA_Dal::factoryDO('channel');
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

            $oNow = new Date();
            while ($oAudit->fetch()) {
                $aAudit = $oAudit->toArray();
                $aAudit['details'] = unserialize($aAudit['details']);

                //  format date
                $oDate = new Date($aAudit['updated']);
                $oDate->setTZbyID('UTC');
                $oDate->convertTZ($oNow->tz);
                $aAudit['updated'] = $oDate->format($GLOBALS['date_format'] .', '. $GLOBALS['time_format']);
                //  set action type
                $aAudit['action'] = $this->getActionName($aAudit['actionid']);
                $result = $this->getParentContextData($aAudit);
                $aAudit['hasChildren'] = $this->hasChildren($aAudit['auditid'], $aAudit['contextid']);

                if (empty($aAudit['username'])) {
                    $aAudit['username'] = 'Installer';
                }

                $aAuditInfo[] = $aAudit;
            }
        }
        return $aAuditInfo;
    }


    /**
     * Returns the associated action name based on the specified action id
     *
     * @var int action id
     *
     * @return string action name
     */
    function getActionName($actionId) {
        switch($actionId) {
        case OA_AUDIT_ACTION_INSERT:
             $action = $GLOBALS['strInserted'];
            break;
        case OA_AUDIT_ACTION_UPDATE:
            $action = $GLOBALS['strUpdated'];
            break;
        case OA_AUDIT_ACTION_DELETE:
            $action = $GLOBALS['strDeleted'];
            break;
        }

        return $action;
    }

    /**
     * Sets the parent context type and parent context id
     *
     * @var int context type
     *
     * @return boolean  true on success / false on failure
     */
    function getParentContextData(& $aContext) {
        switch($aContext['context']) {
        case 'Banner':
            $aContext['parentcontext']    = $GLOBALS['strCampaign'];
            $aContext['parentcontextid']  = $aContext['details']['campaignid'];
            return true;
        case 'Campaign':
            $aContext['parentcontext']    = $GLOBALS['strClient'];
            $aContext['parentcontextid']  = $aContext['details']['clientid'];
            return true;
        case 'Channel':
        case 'Zone':
            $aContext['parentcontext']    = $GLOBALS['strAffiliate'];
            $aContext['parentcontextid']  = $aContext['details']['affiliateid'];
            return true;
        }
        return false;
    }

    /**
     * Gets the children for the selected audit event
     *
     * @param int $auditID Audit ID
     * @param string $itemContext item context type
     *
     * @return array an array containing the children for the specified audit event
     */
    function getChildren($auditID, $itemContext)
    {
        switch ($itemContext) {
        case 'Banner':
            $context = $GLOBALS['strAdZoneAssociation'];
            break;
        }

        $oAudit = & OA_Dal::factoryDO('audit');
        $oAudit->parentid = $auditID;
        $oAudit->context  = $context;
        $numRows = $oAudit->find();

        while($oAudit->fetch()) {
            $aAudit = $oAudit->toArray();
            $aAudit['action'] = $this->getActionName($aAudit['actionid']);

            //  check if child has children
            if ($this->hasChildren($aAudit['auditid'], $aAudit['context'])) {
                $aAudit['children'] = $this->getChildren($aAudit['auditid'], $aAudit['context']);
            }
            $aChildren[] = $aAudit;
        }

        return (!empty($aChildren)) ? $aChildren : false;
    }

    /**
     * Check if the specified audit event has children events
     *
     * @param int $auditID Audit ID
     * @param string $itemContext item context type
     *
     * @return boolan true if event has children else false
     */
    function hasChildren($auditID, $itemContext)
    {
        switch ($itemContext) {
        case 'Banner':
            $context = $GLOBALS['strAdZoneAssociation'];
            break;
        }

        $oAudit = & OA_Dal::factoryDO('audit');
        $oAudit->parentid = $auditID;
        $oAudit->context  = $context;
        $numRows = $oAudit->find();

        return ($numRows > 0) ? true : false;
    }

    /**
     * Removes parent context id
     *
     * @param array $aAudit assoc array which to remove the parent context id from
     *
     * @return boolean true on succes else false on failure
     */
    function _removeParentContextId(&$aAudit)
    {
        switch ($aAudit['context']) {
        case 'Ad Zone Association':
        case 'Delivery Limitation':
        case 'Image':
            if (!is_array($aAudit['details']['bannerid'])) {
                unset($aAudit['details']['bannerid']);
            }
            return true;
        case 'Banner':
        case 'Campaign Tracker':
            if (!is_array($aAudit['details']['campaignid'])) {
                unset($aAudit['details']['campaignid']);
            }
            return true;
        case 'Campaign':
        case 'Tracker':
            if (!is_array($aAudit['details']['clientid'])) {
                unset($aAudit['details']['clientid']);
            }
            return true;
        case 'Channel':
        case 'Zone':
            if (!is_array($aAudit['details']['affiliateid'])) {
                unset($aAudit['details']['affiliateid']);
            }
            return true;
        }
        return false;
    }

    /**
     * requires permission checks
     *
     * @param array $aParam
     * @return array
     */
    function getAuditLogForAuditWidget($aParam = array())
    {
        $oAudit = OA_Dal::factoryDO('audit');

        if (!empty($aParam['account_id'])) {
            $oAudit->account_id = $aParam['account_id'];
        }

        $oDate = new Date();
        $oDate->subtractSpan(new Date_Span('7-0-0-0'));
        $oDate->toUTC();
        $oAudit->whereAdd("username <> 'Maintenance'");
        $oAudit->whereAdd('parentid IS NULL');
        $oAudit->whereAdd("updated >= ".DBC::makeLiteral($oDate->format('%Y-%m-%d %H:%M:%S')));
        $oAudit->orderBy('auditid DESC');
        $oAudit->limit(0, 5);

        $numRows = $oAudit->find();

        $oNow = new Date();
        $aResult = array();
        while ($oAudit->fetch()) {
            $aAudit = $oAudit->toArray();
            $oDate = new Date($aAudit['updated']);
            $oDate->setTZbyID('UTC');
            $oDate->convertTZ($oNow->tz);
            $aAudit['updated'] = $oDate->format('%Y-%m-%d %H:%M:%S');
            $aAudit['details'] = unserialize($aAudit['details']);
            $aResult[] = $aAudit;
        }
        return $aResult;
    }

}
?>