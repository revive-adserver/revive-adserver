<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';

// Register input variables

phpAds_registerGlobal ('acl', 'action', 'submit');

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/


$pageName = basename($_SERVER['PHP_SELF']);
$tabindex = 1;
if (phpAds_isUser(phpAds_Admin)) {
    $agencyId = empty($agencyid) ? 0 : $agencyid;
} else {
    $agencyId = phpAds_getAgencyID();
}

if (!empty($affiliateid)) {
    $aEntities = array('affiliateid' => $affiliateid, 'channelid' => $channelid);
    $aOtherChannels = Admin_DA::getChannels(array('publisher_id' => $affiliateid));
    $aOtherAgencies = array();
    $aOtherPublishers = Admin_DA::getPublishers(array('agency_id' => $agencyId));
} else {
    $aEntities = array('agencyid' => $agencyId, 'channelid' => $channelid);
    if (phpAds_isUser(phpAds_Admin)) {
        $aOtherChannels = Admin_DA::getChannels(array('agency_id' => isset($agencyid) ? $agencyid : 0, 'channel_type' => 'agency'));
        $aOtherAgencies = Admin_DA::getAgencies(array());
    } else {
        $aOtherChannels = Admin_DA::getChannels(array('agency_id' => $agencyId, 'channel_type' => 'agency'));
        $aOtherAgencies = array();
    }
    $aOtherPublishers = array();
}

if ($channelid && !MAX_checkChannel($agencyId, $channelid)) {
    phpAds_PageHeader("2");
    phpAds_Die($strAccessDenied, $strNotAdmin);
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (!empty($action)) {
    $acl = MAX_AclAdjust($acl, $action);
} elseif (!empty($submit)) {
    $acl = (isset($acl)) ? $acl : array();
    if (MAX_AclSave($acl, $aEntities)) {
        if (!empty($affiliateid)) {
            header("Location: channel-acl.php?affiliateid={$affiliateid}&channelid={$channelid}");
        } else {
            header("Location: channel-acl.php?agencyid={$agencyId}&channelid={$channelid}");
        }
        exit;
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

MAX_displayNavigationChannel($pageName, $aOtherAgencies, $aOtherPublishers, $aOtherChannels, $aEntities);

$aChannel = Admin_DA::getChannel($channelid);
$acl = (isset($acl)) ? $acl : Admin_DA::getChannelLimitations(array('channel_id' => $channelid));

if (!empty($affiliateid)) {
    $aParams = array('affiliateid' => $affiliateid, 'channelid' => $channelid);
} else {
    $aParams = array('agencyid' => $agencyId, 'channelid' => $channelid);
}

MAX_displayAcls($acl, $aParams);

echo "<br /><input type='submit' name='submit' value='{$GLOBALS['strSaveChanges']}' tabindex='".($tabindex++)."'></form>";

phpAds_PageFooter();

?>
