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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobalUnslashed('name', 'description', 'comments', 'submit', 'agencyid', 'channelid');

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('channel', $channelid, true);

$pageName = basename($_SERVER['PHP_SELF']);
$agencyId = OA_Permission::getAgencyId();
$tabIndex = 1;

// Obtain the needed data
if (!empty($affiliateid)) {
    $aEntities = array('agencyid' => $agencyid, 'affiliateid' => $affiliateid, 'channelid' => $channelid);
    // Editing a channel at the publisher level; Only use the
    // channels at this publisher level for the navigation bar
    $aOtherChannels = Admin_DA::getChannels(array('publisher_id' => $affiliateid));
} else {
    $aEntities = array('agencyid' => $agencyid, 'channelid' => $channelid);
    // Editing a channel at the agency level; Only use the
    // channels at this agency level for the navigation bar
    $aOtherChannels = Admin_DA::getChannels(array('agency_id' => $agencyId, 'channel_type' => 'agency'));
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (!empty($submit)) {
    if (empty($affiliateid)) $affiliateid = 0;
    if ($channelid) {
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->get($channelid);
        $doChannel->name = $name;
        $doChannel->description = $description;
        $doChannel->comments = $comments;
        $ret = $doChannel->update();
    } else {
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->agencyid = $agencyId;
        $doChannel->affiliateid = $affiliateid;
        $doChannel->name = $name;
        $doChannel->description = $description;
        $doChannel->compiledlimitation = 'true';
        $doChannel->acl_plugins = 'true';
        $doChannel->active = 1;
        $doChannel->comments = $comments;
        $ret = $channelid = $doChannel->insert();
    }

    if ($ret) {
        if (!empty($affiliateid)) {
            header("Location: channel-acl.php?affiliateid={$affiliateid}&channelid={$channelid}");
        } else {
            header("Location: channel-acl.php?channelid={$channelid}");
        }
        exit;
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

MAX_displayNavigationChannel($pageName, $aOtherChannels, $aEntities);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$doChannel = OA_Dal::factoryDO('channel');
if (!empty($channelid)) {
    $doChannel->get($channelid);
}
$channel = $doChannel->toArray();

echo "<form name='zoneform' method='post' action='channel-edit.php'>";
echo "<input type='hidden' name='agencyid' value='{$agencyId}'>";
echo "<input type='hidden' name='affiliateid' value='{$affiliateid}'>";
echo "<input type='hidden' name='channelid' value='" . ((empty($channelid)) ? '0' : $channelid) . "'>";

echo "<br /><table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>{$GLOBALS['strBasicInformation']}</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>{$GLOBALS['strName']}</td><td>";
echo "<input class='flat' type='text' name='name' size='35' style='width:350px;' value='".phpAds_htmlQuotes($channel['name'])."' tabindex='".($tabIndex++)."'></td>";
echo "</tr><tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>{$GLOBALS['strDescription']}</td><td>";
echo "<input class='flat' size='35' type='text' name='description' style='width:350px;' value='".phpAds_htmlQuotes($channel["description"])."' tabindex='".($tabIndex++)."'></td>";
echo "</tr><tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>{$GLOBALS['strComments']}</td>";

echo "<td><textarea class='comments' cols='45' rows='6' name='comments' wrap='off' dir='ltr' style='width:350px;";
echo "' tabindex='".($tabIndex++)."'>".htmlspecialchars($channel['comments'])."</textarea></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";

echo "<br /><br />";
echo "<input type='submit' name='submit' value='{$GLOBALS['strSaveChanges']}' tabindex='".($tabIndex++)."'>";
echo "</form>";

phpAds_PageFooter();

?>
