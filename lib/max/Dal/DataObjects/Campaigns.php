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
 * Table Definition for campaigns
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Campaigns extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    var $dalModelName = 'Campaigns';
    var $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'campaigns';                       // table name
    var $campaignid;                      // int(9)  not_null primary_key auto_increment
    var $campaignname;                    // string(255)  not_null
    var $clientid;                        // int(9)  not_null multiple_key
    var $views;                           // int(11)
    var $clicks;                          // int(11)
    var $conversions;                     // int(11)
    var $expire;                          // date(10)  binary
    var $activate;                        // date(10)  binary
    var $priority;                        // int(11)  not_null
    var $weight;                          // int(4)  not_null
    var $target_impression;               // int(11)  not_null
    var $target_click;                    // int(11)  not_null
    var $target_conversion;               // int(11)  not_null
    var $anonymous;                       // string(1)  not_null enum
    var $companion;                       // int(1)
    var $comments;                        // blob(65535)  blob
    var $revenue;                         // real(12)
    var $revenue_type;                    // int(6)
    var $updated;                         // datetime(19)  not_null binary
    var $block;                           // int(11)  not_null
    var $capping;                         // int(11)  not_null
    var $session_capping;                 // int(11)  not_null
    var $an_campaign_id;                  // int(11)
    var $as_campaign_id;                  // int(11)
    var $status;                          // int(11)  not_null
    var $an_status;                       // int(11)  not_null
    var $as_reject_reason;                // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Campaigns',$k,$v); }

    var $defaultValues = array(
                'clientid' => 0,
                'views' => -1,
                'clicks' => -1,
                'conversions' => -1,
                'expire' => '%NO_DATE_TIME%',
                'activate' => '%NO_DATE_TIME%',
                'priority' => 0,
                'weight' => 1,
                'target_impression' => 0,
                'target_click' => 0,
                'target_conversion' => 0,
                'anonymous' => 'f',
                'companion' => 0,
                'block' => 0,
                'capping' => 0,
                'session_capping' => 0,
                'status' => 0,
                'an_status' => 0,
                'as_reject_reason' => 0,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function insert()
    {
        $id = parent::insert();
        if (!$id) {
            return $id;
        }

        // Initalise any tracker based plugins
        $plugins = array();
        require_once MAX_PATH.'/lib/max/Plugin.php';
        $invocationPlugins = &MAX_Plugin::getPlugins('invocationTags');
        foreach($invocationPlugins as $pluginKey => $plugin) {
            if (!empty($plugin->trackerEvent)) {
                $plugins[] = $plugin;
            }
        }

        // Link automatically any trackers which are marked as "link with any new campaigns"
        $doTrackers = $this->factory('trackers');
        $doTrackers->clientid = $this->clientid;
        $doTrackers->linkcampaigns = 't';
        $doTrackers->find();

        while ($doTrackers->fetch()) {
            $doCampaigns_trackers = $this->factory('campaigns_trackers');
            $doCampaigns_trackers->init();
            $doCampaigns_trackers->trackerid = $doTrackers->trackerid;
            $doCampaigns_trackers->campaignid = $this->campaignid;
            $doCampaigns_trackers->clickwindow = $doTrackers->clickwindow;
            $doCampaigns_trackers->viewwindow = $doTrackers->viewwindow;
            $doCampaigns_trackers->status = $doTrackers->status;
            foreach ($plugins as $oPlugin) {
                $fieldName = strtolower($oPlugin->trackerEvent);
                $doCampaigns_trackers->$fieldName = $doTrackers->$fieldName;
            }
            $doCampaigns_trackers->insert();
        }

        return $id;
    }

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->campaignid;
    }

    function _getContext()
    {
        return 'Campaign';
    }

    /**
     * A private method to return the account ID of the
     * account that should "own" audit trail entries for
     * this entity type; NOT related to the account ID
     * of the currently active account performing an
     * action.
     *
     * @return integer The account ID to insert into the
     *                 "account_id" column of the audit trail
     *                 database table.
     */
    function getOwningAccountId()
    {
        return $this->_getOwningAccountIdFromParent('clients', 'clientid');
    }

   /**
     * build a campaign specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = $this->campaignname;
        switch ($actionid)
        {
            case OA_AUDIT_ACTION_UPDATE:
                        $aAuditFields['clientid']   = $this->clientid;
                        break;
        }
    }

}

?>