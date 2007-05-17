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
 * Table Definition for campaigns
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Campaigns extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    var $dalModelName = 'Campaigns';
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
    var $active;                          // string(1)  not_null enum
    var $priority;                        // int(11)  not_null
    var $weight;                          // int(4)  not_null
    var $target_impression;               // int(11)  not_null
    var $target_click;                    // int(11)  not_null
    var $target_conversion;               // int(11)  not_null
    var $anonymous;                       // string(1)  not_null enum
    var $companion;                       // int(1)
    var $comments;                        // blob(65535)  blob
    var $revenue;                         // unknown(12)
    var $revenue_type;                    // int(6)
    var $updated;                         // datetime(19)  not_null binary
    var $block;                           // int(11)  not_null
    var $capping;                         // int(11)  not_null
    var $session_capping;                 // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Campaigns',$k,$v); }

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
}

?>