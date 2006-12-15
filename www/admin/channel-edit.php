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

// Register input variables
phpAds_registerGlobal ('name', 'description', 'comments', 'submit');

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

$pageName = basename($_SERVER['PHP_SELF']);
$tabIndex = 1;
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
    $aEntities = array('agencyid' => $agencyid, 'channelid' => $channelid);
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

if (isset($submit) && $submit == $GLOBALS['strSaveChanges']) {
    if (empty($affiliateid)) $affiliateid = 0;
    if (isset($description)) $description = addslashes ($description);
    if (isset($comments)) $comments = addslashes ($comments);
    
    if ($channelid) {
        $query = "
            UPDATE
                {$conf['table']['prefix']}{$conf['table']['channel']}
            SET
                name='{$name}',
                description='{$description}',
                comments='{$comments}'
            WHERE
                channelid='{$channelid}'
        ";
    } else {
        // Always insert the correct agencyid when channel is owned by a publisher
        if (!empty($affiliateid)) {
            $res_affiliate = phpAds_dbQuery("SELECT agencyid FROM {$conf['table']['prefix']}{$conf['table']['affiliates']} WHERE affiliateid = '{$affiliateid}'");
            $agencyId = phpAds_dbResult($res_affiliate, 0, 0);
        }
        
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['channel']}
            (
                agencyid,
                affiliateid,
                name,
                description,
                compiledlimitation,
                acl_plugins,
                active,
                comments
            )
            VALUES
            (
                {$agencyId},
                {$affiliateid},
                '{$name}',
                '{$description}',
                'true',
                '',
                1,
                '{$comments}'
            )
        ";
    }
    
    if ($query && phpAds_dbQuery($query)) {
        if (!$channelid) $channelid = phpAds_dbInsertID();
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

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$channel = Admin_DA::getChannel($channelid);

echo "<form name='zoneform' method='post' action='channel-edit.php'>";
echo "<input type='hidden' name='agencyid' value='{$agencyId}'>";
echo "<input type='hidden' name='affiliateid' value='{$affiliateid}'>";
echo "<input type='hidden' name='channelid' value='" . ((empty($channelid)) ? '0' : $channelid) . "'>";

echo "<br /><table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>{$GLOBALS['strBasicInformation']}</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>{$GLOBALS['strName']}</td><td>";
echo "<input class='flat' type='text' name='name' size='35' style='width:350px;' value='".phpAds_htmlQuotes($channel['name'])."' tabindex='".($tabIndex++)."'></td>";
echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>{$GLOBALS['strDescription']}</td><td>";
echo "<input class='flat' size='35' type='text' name='description' style='width:350px;' value='".phpAds_htmlQuotes($channel["description"])."' tabindex='".($tabIndex++)."'></td>";
echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>{$GLOBALS['strComments']}</td>";
 
echo "<td><textarea class='comments' cols='45' rows='6' name='comments' wrap='off' dir='ltr' style='width:350px;";
echo "' tabindex='".($tabIndex++)."'>".htmlentities($channel['comments'])."</textarea></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";

echo "<br /><br />";
echo "<input type='submit' name='submit' value='{$GLOBALS['strSaveChanges']}' tabindex='".($tabIndex++)."'>";
echo "</form>";

phpAds_PageFooter();

?>
