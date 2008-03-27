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
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

// Register input variables
phpAds_registerGlobal (
     'action'
    ,'campaignids'
    ,'clickwindowday'
    ,'clickwindowhour'
    ,'clickwindowminute'
    ,'clickwindows'
    ,'clickwindowsecond'
    ,'hideinactive'
    ,'statusids'
    ,'submit'
    ,'viewwindowday'
    ,'viewwindowhour'
    ,'viewwindowminute'
    ,'viewwindows'
    ,'viewwindowsecond'
);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('trackers', $trackerid);

// Initalise any tracker based plugins
$plugins = array();
$invocationPlugins = &MAX_Plugin::getPlugins('invocationTags');
foreach($invocationPlugins as $pluginKey => $plugin) {
    if (!empty($plugin->trackerEvent)) {
        $plugins[] = $plugin;
        $fieldName = strtolower($plugin->trackerEvent);
        phpAds_registerGlobal("{$fieldName}windowday", "{$fieldName}windowhour", "{$fieldName}windowminute", "{$fieldName}windowsecond", "{$fieldName}windows");
    }
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (!empty($trackerid)) {
    if (isset($action) && $action == 'set') {
        $doCampaign_trackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaign_trackers->trackerid = $trackerid;
        $doCampaign_trackers->delete();

        if (isset($campaignids) && is_array($campaignids)) {
            for ($i=0; $i<sizeof($campaignids); $i++) {
                $clickwindow = $clickwindowday[$i] * (24*60*60) + $clickwindowhour[$i] * (60*60) + $clickwindowminute[$i] * (60) + $clickwindowsecond[$i];
                $viewwindow = $viewwindowday[$i] * (24*60*60) + $viewwindowhour[$i] * (60*60) + $viewwindowminute[$i] * (60) + $viewwindowsecond[$i];

                $fields = array("campaignid", "trackerid", "status", "viewwindow", "clickwindow");
                $values = array($campaignids[$i], $trackerid, $statusids[$i], $viewwindow, $clickwindow);

                foreach ($plugins as $plugin) {
                    $dbField = strtolower($plugin->trackerEvent) . "window";
                    $value = ${$dbField."day"}[$i] * (24*60*60) + ${$dbField."hour"}[$i] * (60*60) + ${$dbField."minute"}[$i] * (60) + ${$dbField."second"}[$i];
                    $fields[] = $dbField;
                    $values[] = $value;
                }

                $doCampaign_trackers = OA_Dal::factoryDO('campaigns_trackers');
                for ($k = 0; $k < count($fields); $k++) {
                    $field = $fields[$k];
                    $doCampaign_trackers->$field = $values[$k];
                }
                $doCampaign_trackers->insert();
            }
        }
        header ("Location: tracker-variables.php?clientid=".$clientid."&trackerid=".$trackerid);
        exit;
    }
}



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (!isset($hideinactive)) {
    if (isset($session['prefs']['tracker-campaigns.php']['hideinactive'])) {
        $hideinactive = $session['prefs']['tracker-campaigns.php']['hideinactive'];
    } else {
        $pref = &$GLOBALS['_MAX']['PREF'];
        $hideinactive = ($pref['ui_hide_inactive'] == true);
    }
}

if (!isset($listorder)) {
    if (isset($session['prefs']['tracker-campaigns.php']['listorder'])) {
        $listorder = $session['prefs']['tracker-campaigns.php']['listorder'];
    } else {
        $listorder = '';
    }
}

if (!isset($orderdirection)) {
    if (isset($session['prefs']['tracker-campaigns.php']['orderdirection'])) {
        $orderdirection = $session['prefs']['tracker-campaigns.php']['orderdirection'];
    } else {
        $orderdirection = '';
    }
}


// Get other trackers
$doTrackers = OA_Dal::factoryDO('trackers');
$doTrackers->clientid = $clientid;
$doTrackers->find();

while ($doTrackers->fetch() && $row = $doTrackers->toArray()) {
    phpAds_PageContext(
        phpAds_buildName ($row['trackerid'], $row['trackername']),
        "tracker-campaigns.php?clientid=".$clientid."&trackerid=".$row['trackerid'],
        $trackerid == $row['trackerid']
    );
}

if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    phpAds_PageShortcut($strClientProperties, 'advertiser-edit.php?clientid='.$clientid, 'images/icon-advertiser.gif');
    //phpAds_PageShortcut($strTrackerHistory, 'stats-tracker-history.php?clientid='.$clientid.'&trackerid='.$trackerid, 'images/icon-statistics.gif');


    $extra  = "\t\t\t\t<form action='tracker-modify.php'>"."\n";
    $extra .= "\t\t\t\t<input type='hidden' name='trackerid' value='$trackerid'>"."\n";
    $extra .= "\t\t\t\t<input type='hidden' name='clientid' value='$clientid'>"."\n";
    $extra .= "\t\t\t\t<input type='hidden' name='returnurl' value='tracker-campaigns.php'>"."\n";
    $extra .= "\t\t\t\t<br /><br />"."\n";
    $extra .= "\t\t\t\t<b>$strModifyTracker</b><br />"."\n";
    $extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='160' vspace='4'><br />"."\n";
    $extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/icon-duplicate-tracker.gif' align='absmiddle'>&nbsp;<a href='tracker-modify.php?clientid=".$clientid."&trackerid=".$trackerid."&duplicate=true&returnurl=tracker-campaigns.php'>$strDuplicate</a><br />"."\n";
    $extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='160' vspace='4'><br />"."\n";
    $extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/icon-move-tracker.gif' align='absmiddle'>&nbsp;$strMoveTo<br />"."\n";
    $extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='160' vspace='2'><br />"."\n";
    $extra .= "\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."\n";
    $extra .= "\t\t\t\t<select name='moveto' style='width: 110;'>"."\n";

    $doClients = OA_Dal::factoryDO('clients');
    $doClients->whereAdd('clientid <> '.$clientid);

    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $doClients->addReferenceFilter('agency', OA_Permission::getEntityId());
    }
    $doClients->find();

    while ($doClients->fetch() && $row = $doClients->toArray()) {
        $extra .= "\t\t\t\t\t<option value='".$row['clientid']."'>".phpAds_buildName($row['clientid'], $row['clientname'])."</option>\n";
    }

    $extra .= "\t\t\t\t</select>&nbsp;\n";
    $extra .= "\t\t\t\t<input type='image' src='" . MAX::assetPath() . "/images/".$phpAds_TextDirection."/go_blue.gif'><br />\n";
    $extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='160' vspace='4'><br />\n";
    $extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/icon-recycle.gif' align='absmiddle'>\n";
    $extra .= "\t\t\t\t<a href='tracker-delete.php?clientid=$clientid&trackerid=$trackerid&returnurl=advertiser-trackers.php'".phpAds_DelConfirm($strConfirmDeleteTracker).">$strDelete</a><br />\n";
    $extra .= "\t\t\t\t</form>\n";


    phpAds_PageHeader("4.1.4.3", $extra);
    echo "\t\t\t\t<img src='" . MAX::assetPath() . "/images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid)."\n";
    echo "\t\t\t\t<img src='" . MAX::assetPath() . "/images/".$phpAds_TextDirection."/caret-rs.gif'>\n";
    echo "\t\t\t\t<img src='" . MAX::assetPath() . "/images/icon-tracker.gif' align='absmiddle'>\n";
    echo "\t\t\t\t<b>".phpAds_getTrackerName($trackerid)."</b><br /><br /><br />\n";
    phpAds_ShowSections(array("4.1.4.2", "4.1.4.3", "4.1.4.5", "4.1.4.6", "4.1.4.4"));
}

if (!empty($trackerid)) {
    $doTrackers = OA_Dal::factoryDO('trackers');
    if ($doTrackers->get($trackerid)) {
        $tracker = $doTrackers->toArray();
    }
}

$tabindex = 1;

// Header
echo "\t\t\t\t<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>\n";
echo "\t\t\t\t<tr height='25'>\n";
echo "\t\t\t\t\t<td height='25' width='40%'>\n";
echo "\t\t\t\t\t\t<b>&nbsp;&nbsp;<a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&listorder=name'>".$GLOBALS['strName']."</a>";

if (($listorder == "name") || ($listorder == "")) {
    if  (($orderdirection == "") || ($orderdirection == "down")) {
        echo " <a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&orderdirection=up'>";
        echo "<img src='" . MAX::assetPath() . "/images/caret-ds.gif' border='0' alt='' title=''>";
    } else {
        echo " <a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&orderdirection=down'>";
        echo "<img src='" . MAX::assetPath() . "/images/caret-u.gif' border='0' alt='' title=''>";
    }
    echo "</a>";
}

echo "</b>\n";
echo "\t\t\t\t\t</td>\n";
echo "\t\t\t\t\t<td width='40'>";
echo "<b><a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&listorder=id'>".$GLOBALS['strID']."</a>";

if ($listorder == "id") {
    if  (($orderdirection == "") || ($orderdirection == "down")) {
        echo " <a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&orderdirection=up'>";
        echo "<img src='" . MAX::assetPath() . "/images/caret-ds.gif' border='0' alt='' title=''>";
    } else {
        echo " <a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&orderdirection=down'>";
        echo "<img src='" . MAX::assetPath() . "/images/caret-u.gif' border='0' alt='' title=''>";
    }
    echo "</a>";
}
echo "</b></td>\n";

echo "\t\t\t\t\t<td width='100'>\n";
echo "\t\t\t\t\t\t<b>".$GLOBALS['strStatus']."</b>\n";
echo "\t\t\t\t\t</td>\n";

echo "\t\t\t\t\t<td>\n";
echo "\t\t\t\t\t\t<b>".$GLOBALS['strConversionWindow']."</b>\n";
echo "\t\t\t\t\t</td>\n";

echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr height='1'>\n";
echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";

$i = 0;
$checkedall = true;
$campaignshidden = 0;

$defaults = array(
    'viewwindow'  => $conf['logging']['defaultImpressionConnectionWindow'],
    'clickwindow' => $conf['logging']['defaultClickConnectionWindow'],
);

if (!empty($trackerid)) {
    $doCampaign_trackers = OA_Dal::factoryDO('campaigns_trackers');
    $doCampaign_trackers->trackerid = $trackerid;
    $campaign_tracker_row = $doCampaign_trackers->getAll(array(), $indexBy = 'campaignid');
    $defaults = $tracker;
}

$doCampaigns = OA_Dal::factoryDO('campaigns');
$doCampaigns->clientid = $clientid;
$doCampaigns->find();

if ($doCampaigns->getRowCount() == 0) {
    echo "\t\t\t\t<tr bgcolor='#F6F6F6'>\n";
    echo "\t\t\t\t\t<td colspan='4' height='25'>&nbsp;&nbsp;".$strNoCampaignsToLink."</td>\n";
    echo "\t\t\t\t</tr>\n";
} else {
    echo "\t\t\t\t<form name='availablecampaigns' method='post' action='tracker-campaigns.php'>\n";
    echo "\t\t\t\t<input type='hidden' name='trackerid' value='".$GLOBALS['trackerid']."'>\n";
    echo "\t\t\t\t<input type='hidden' name='clientid' value='".$GLOBALS['clientid']."'>\n";
    echo "\t\t\t\t<input type='hidden' name='action' value='set'>\n";
    $campaigns = $doCampaigns->getAll(array(), $indexByPrimaryKey = true);

    foreach ($campaigns as $campaign) {

        if ($campaign['active'] == 't' || $hideinactive != '1') {
            if ($i > 0) {
                echo "\t\t\t\t<tr height='1'>\n";
                echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>\n";
                echo "\t\t\t\t</tr>\n";
            }
            echo "\t\t\t\t<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">\n";

            // Begin row
            echo "\t\t\t\t\t<td height='25'>";

            // Show checkbox
            if (isset($campaign_tracker_row[$campaign['campaignid']])) {
                echo "<input id='cmp".$campaign['campaignid']."' type='checkbox' name='campaignids[]' value='".$campaign['campaignid']."' checked onclick='phpAds_reviewAll();' tabindex='".($tabindex++)."'>";
            } else {
                echo "<input id='cmp".$campaign['campaignid']."' type='checkbox' name='campaignids[]' value='".$campaign['campaignid']."' onclick='phpAds_reviewAll();' tabindex='".($tabindex++)."'>";
                $checkedall = false;
            }

            // Campaign icon
            if ($campaign['active'] == 't') {
                echo "<img src='" . MAX::assetPath() . "/images/icon-campaign.gif' align='absmiddle'>";
            } else {
                echo "<img src='" . MAX::assetPath() . "/images/icon-campaign-d.gif' align='absmiddle'>&nbsp;";
            }

            // Name
            if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)) {
                echo "<a href='campaign-edit.php?clientid=".$campaign['clientid']."&campaignid=".$campaign['campaignid']."'>";
                echo phpAds_breakString ($campaign['campaignname'], '60')."</a>";
            } else {
                echo phpAds_breakString ($campaign['campaignname'], '60');
            }
            echo "</td>\n";

            // ID
            echo "\t\t\t\t\t<td height='25'>".$campaign['campaignid']."</td>\n";

            // Status
            $statuses = $GLOBALS['_MAX']['STATUSES'];
            $startStatusesIds = array(1,2,4);
            echo "\t\t\t\t\t<td height='25'>";
            echo "<select name='statusids[]' id='statuscmp".$campaign['campaignid']."' tabindex='".($tabindex++)."'>\n";

            if (isset($campaign_tracker_row[$campaign['campaignid']])) {
                $trackerStatusId = $campaign_tracker_row[$campaign['campaignid']]['status'];
            } else {
                  $trackerStatusId = $defaults['status'];
            }

            foreach($statuses as $statusId => $statusName) {
                if(in_array($statusId, $startStatusesIds)) {
                    echo "<option value='$statusId' ". ($trackerStatusId == $statusId ? 'selected' : '')." >{$GLOBALS[$statusName]}&nbsp;</option>\n";
                }
            }
            echo "</select>\n";
            echo "</td>\n";

            $seconds_left = $defaults['clickwindow'];
            if (isset($campaign_tracker_row[$campaign['campaignid']]))
                $seconds_left = $campaign_tracker_row[$campaign['campaignid']]['clickwindow'];

            $clickwindowday = floor($seconds_left / (60*60*24));
            $seconds_left = $seconds_left % (60*60*24);
            $clickwindowhour = floor($seconds_left / (60*60));
            $seconds_left = $seconds_left % (60*60);
            $clickwindowminute = floor($seconds_left / (60));
            $seconds_left = $seconds_left % (60);
            $clickwindowsecond = $seconds_left;

            // Click Window
            echo "<td nowrap>".$strClick."&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<input id='clickwindowdaycmp".$campaign['campaignid']."' class='flat' type='text' size='3' name='clickwindowday[]' value='".$clickwindowday."' onKeyUp=\"phpAds_formLimitUpdate('".$campaign['campaignid']."');\" tabindex='".($tabindex++)."'> ".$strDays." &nbsp;&nbsp;";
            echo "<input id='clickwindowhourcmp".$campaign['campaignid']."' class='flat' type='text' size='3' name='clickwindowhour[]' value='".$clickwindowhour."' onKeyUp=\"phpAds_formLimitUpdate('".$campaign['campaignid']."');\" tabindex='".($tabindex++)."'> ".$strHours." &nbsp;&nbsp;";
            echo "<input id='clickwindowminutecmp".$campaign['campaignid']."' class='flat' type='text' size='3' name='clickwindowminute[]' value='".$clickwindowminute."' onKeyUp=\"phpAds_formLimitUpdate('".$campaign['campaignid']."');\" tabindex='".($tabindex++)."'> ".$strMinutes." &nbsp;&nbsp;";
            echo "<input id='clickwindowsecondcmp".$campaign['campaignid']."' class='flat' type='text' size='3' name='clickwindowsecond[]' value='".$clickwindowsecond."' onBlur=\"phpAds_formLimitBlur('".$campaign['campaignid']."');\" onKeyUp=\"phpAds_formLimitUpdate('".$campaign['campaignid']."');\" tabindex='".($tabindex++)."'> ".$strSeconds." &nbsp;&nbsp;";
            echo "</td>";

            echo "\t\t\t\t</tr>\n";

            // Mini Break Line
            echo "\t\t\t\t<tr height='1'>\n";
            echo "\t\t\t\t\t<td".($i%2==0?" bgcolor='#F6F6F6'":"")."><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>\n";
            echo "\t\t\t\t\t<td colspan='3'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>\n";
            echo "\t\t\t\t</tr>\n";

            echo "<tr height='25'".($i%2==0?" bgcolor='#F6F6F6'":"").">";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";

            $seconds_left = $defaults['viewwindow'];
            if (isset($campaign_tracker_row[$campaign['campaignid']]))
                $seconds_left = $campaign_tracker_row[$campaign['campaignid']]['viewwindow'];

            $viewwindowday = floor($seconds_left / (60*60*24));
            $seconds_left = $seconds_left % (60*60*24);
            $viewwindowhour = floor($seconds_left / (60*60));
            $seconds_left = $seconds_left % (60*60);
            $viewwindowminute = floor($seconds_left / (60));
            $seconds_left = $seconds_left % (60);
            $viewwindowsecond = $seconds_left;

            // View Window
            echo "<td nowrap>".$strView."&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<input id='viewwindowdaycmp".$campaign['campaignid']."' class='flat' type='text' size='3' name='viewwindowday[]' value='".$viewwindowday."' onKeyUp=\"phpAds_formLimitUpdate('".$campaign['campaignid']."');\" tabindex='".($tabindex++)."'> ".$strDays." &nbsp;&nbsp;";
            echo "<input id='viewwindowhourcmp".$campaign['campaignid']."' class='flat' type='text' size='3' name='viewwindowhour[]' value='".$viewwindowhour."' onKeyUp=\"phpAds_formLimitUpdate('".$campaign['campaignid']."');\" tabindex='".($tabindex++)."'> ".$strHours." &nbsp;&nbsp;";
            echo "<input id='viewwindowminutecmp".$campaign['campaignid']."' class='flat' type='text' size='3' name='viewwindowminute[]' value='".$viewwindowminute."' onKeyUp=\"phpAds_formLimitUpdate('".$campaign['campaignid']."');\" tabindex='".($tabindex++)."'> ".$strMinutes." &nbsp;&nbsp;";
            echo "<input id='viewwindowsecondcmp".$campaign['campaignid']."' class='flat' type='text' size='3' name='viewwindowsecond[]' value='".$viewwindowsecond."' onBlur=\"phpAds_formLimitBlur('".$campaign['campaignid']."');\" onKeyUp=\"phpAds_formLimitUpdate('".$campaign['campaignid']."');\" tabindex='".($tabindex++)."'> ".$strSeconds." &nbsp;&nbsp;";
            echo "</td>";

            // End row
            echo "</tr>"."\n";

            foreach ($plugins as $plugin) {
                $fieldName = strtolower($plugin->trackerEvent);
                $seconds_left = $tracker[$fieldName . 'window'];
                if (isset($campaign_tracker_row[$campaign['campaignid']])) {
                    $seconds_left = $campaign_tracker_row[$campaign['campaignid']][$fieldName . 'window'];
                }
                $days = floor($seconds_left / (60*60*24));
                $seconds_left = $seconds_left % (60*60*24);
                $hours = floor($seconds_left / (60*60));
                $seconds_left = $seconds_left % (60*60);
                $minutes = floor($seconds_left / (60));
                $seconds_left = $seconds_left % (60);
                $seconds = $seconds_left;

                // Mini Break Line
                echo "\t\t\t\t<tr height='1'>\n";
                echo "\t\t\t\t\t<td".($i%2==0?" bgcolor='#F6F6F6'":"")."><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>\n";
                echo "\t\t\t\t\t<td colspan='3'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>\n";
                echo "\t\t\t\t</tr>\n";

                echo "<tr height='25'".($i%2==0?" bgcolor='#F6F6F6'":"").">";
                echo "<td>&nbsp;</td>";
                echo "<td>&nbsp;</td>";
                echo "<td>&nbsp;</td>";

                echo "<td nowrap>" . ucfirst($fieldName) . "&nbsp;&nbsp;";
                echo "<input id='{$fieldName}windowdaycmp{$campaign['campaignid']}' class='flat' type='text' size='3' name='{$fieldName}windowday[]' value='{$days}' onKeyUp=\"phpAds_formLimitUpdate('".$campaign['campaignid']."');\" tabindex='".($tabindex++)."'> ".$strDays." &nbsp;&nbsp;";
                echo "<input id='{$fieldName}windowhourcmp{$campaign['campaignid']}' class='flat' type='text' size='3' name='{$fieldName}windowhour[]' value='{$hours}' onKeyUp=\"phpAds_formLimitUpdate('".$campaign['campaignid']."');\" tabindex='".($tabindex++)."'> ".$strHours." &nbsp;&nbsp;";
                echo "<input id='{$fieldName}windowminutecmp{$campaign['campaignid']}' class='flat' type='text' size='3' name='{$fieldName}windowminute[]' value='{$minutes}' onKeyUp=\"phpAds_formLimitUpdate('".$campaign['campaignid']."');\" tabindex='".($tabindex++)."'> ".$strMinutes." &nbsp;&nbsp;";
                echo "<input id='{$fieldName}windowsecondcmp{$campaign['campaignid']}' class='flat' type='text' size='3' name='{$fieldName}windowsecond[]' value='{$seconds}' onBlur=\"phpAds_formLimitBlur('".$campaign['campaignid']."');\" onKeyUp=\"phpAds_formLimitUpdate('".$campaign['campaignid']."');\" tabindex='".($tabindex++)."'> ".$strSeconds." &nbsp;&nbsp;";
                echo "</td></tr>";
            }

            $i++;
        } else {
            $campaignshidden++;
        }
    }
}

echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>"."\n";
echo "<input type='checkbox' name='checkall' value=''".($checkedall == true ? ' checked' : '')." onclick='phpAds_toggleAll();' tabindex='".($tabindex++)."'>"."\n";
echo "<b>".$strCheckAllNone."</b>"."\n";
echo "</td>\n";
echo "<td>&nbsp;</td>\n";
echo "<td>&nbsp;</td>\n";
echo "<td>&nbsp;</td>\n";
echo "</tr>\n";

echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='25' align='".$phpAds_TextAlignLeft."' nowrap>"."\n";

if ($hideinactive == true) {
    echo "&nbsp;&nbsp;<img src='" . MAX::assetPath() . "/images/icon-activate.gif' align='absmiddle' border='0'>";
    echo "&nbsp;<a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&hideinactive=0'>".$strShowAll."</a>";
    echo "&nbsp;&nbsp;|&nbsp;&nbsp;".$campaignshidden." ".$strInactiveCampaignsHidden;
} else {
    echo "&nbsp;&nbsp;<img src='" . MAX::assetPath() . "/images/icon-hideinactivate.gif' align='absmiddle' border='0'>"."\n";
    echo "&nbsp;<a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&hideinactive=1'>".$strHideInactiveCampaigns."</a>"."\n";
}

echo "</td><td colspan='2' align='".$phpAds_TextAlignRight."' nowrap>"."\n";

echo "&nbsp;&nbsp;</td></tr>"."\n";
echo "</table>"."\n";
echo "<br /><br /><br /><br />"."\n";

echo "<input type='submit' name='submit' value='$strSaveChanges' tabindex='".($tabindex++)."'>"."\n";
echo "</form>"."\n";

?>
<script language='Javascript'>
<!--
    function phpAds_getAllChecked()
    {
        var allchecked = false;

        for (var i=0; i<document.availablecampaigns.elements.length; i++) {
            if (document.availablecampaigns.elements[i].name == 'campaignids[]') {
                if (document.availablecampaigns.elements[i].checked == false) {
                    allchecked = true;
                }
            }
        }
        return allchecked;
    }

    function phpAds_toggleAll()
    {
        var allchecked = phpAds_getAllChecked();

        for (var i=0; i<document.availablecampaigns.elements.length; i++) {
            if (document.availablecampaigns.elements[i].name == 'campaignids[]') {
                document.availablecampaigns.elements[i].checked = allchecked;
            }
        }
        phpAds_reviewAll();
    }

    function phpAds_reviewAll()
    {
        for (var i=0; i<document.availablecampaigns.elements.length; i++) {
            var element = document.availablecampaigns.elements[i];
            if (element.id.substring(0,3) == 'cmp') {
                var cmpid = element.id.substring(3);
                phpAds_formLimitBlur(cmpid);
                phpAds_formLimitUpdate(cmpid);

                var logelement = document.getElementById('status' + element.id);
                if (logelement) logelement.disabled = !element.checked;

                var cwday = document.getElementById('clickwindowday' + element.id);
                if (cwday) cwday.disabled = !element.checked;

                var cwhour = document.getElementById('clickwindowhour' + element.id);
                if (cwhour) cwhour.disabled = !element.checked;

                var cwminute = document.getElementById('clickwindowminute' + element.id);
                if (cwminute) cwminute.disabled = !element.checked;

                var cwsecond = document.getElementById('clickwindowsecond' + element.id);
                if (cwsecond) cwsecond.disabled = !element.checked;

                var vwday = document.getElementById('viewwindowday' + element.id);
                if (vwday) vwday.disabled = !element.checked;

                var vwhour = document.getElementById('viewwindowhour' + element.id);
                if (vwhour) vwhour.disabled = !element.checked;

                var vwminute = document.getElementById('viewwindowminute' + element.id);
                if (vwminute) vwminute.disabled = !element.checked;

                var vwsecond = document.getElementById('viewwindowsecond' + element.id);
                if (vwsecond) vwsecond.disabled = !element.checked;

                <?php
                foreach ($plugins as $plugin) {
                    $fieldName = strtolower($plugin->trackerEvent);

                    echo "
                        var plugin{$i}_day = document.getElementById('{$fieldName}windowday' + element.id);
                        if (plugin{$i}_day) plugin{$i}_day.disabled = !element.checked;

                        var plugin{$i}_hour = document.getElementById('{$fieldName}windowhour' + element.id);
                        if (plugin{$i}_hour) plugin{$i}_hour.disabled = !element.checked;

                        var plugin{$i}_minute = document.getElementById('{$fieldName}windowminute' + element.id);
                        if (plugin{$i}_minute) plugin{$i}_minute.disabled = !element.checked;

                        var plugin{$i}_second = document.getElementById('{$fieldName}windowsecond' + element.id);
                        if (plugin{$i}_second) plugin{$i}_second.disabled = !element.checked;
                    ";
                }
                ?>
            }
        }

        document.availablecampaigns.checkall.checked = !phpAds_getAllChecked();
    }

    function phpAds_formLimitBlur (cmpid)
    {
        var cwday = document.getElementById('clickwindowdaycmp'+cmpid);
        var cwhour = document.getElementById('clickwindowhourcmp'+cmpid);
        var cwminute = document.getElementById('clickwindowminutecmp'+cmpid);
        var cwsecond = document.getElementById('clickwindowsecondcmp'+cmpid);

        if (cwday.value == '') cwday.value = '0';
        if (cwhour.value == '') cwhour.value = '0';
        if (cwminute.value == '') cwminute.value = '0';
        if (cwsecond.value == '') cwsecond.value = '0';

        var vwday = document.getElementById('viewwindowdaycmp'+cmpid);
        var vwhour = document.getElementById('viewwindowhourcmp'+cmpid);
        var vwminute = document.getElementById('viewwindowminutecmp'+cmpid);
        var vwsecond = document.getElementById('viewwindowsecondcmp'+cmpid);

        if (vwday.value == '') vwday.value = '0';
        if (vwhour.value == '') vwhour.value = '0';
        if (vwminute.value == '') vwminute.value = '0';
        if (vwsecond.value == '') vwsecond.value = '0';

        <?php
        $i = 0;
        foreach ($plugins as $plugin) {
            $fieldName = strtolower($plugin->trackerEvent);
            echo "
            var plugin{$i}_day = document.getElementById('{$fieldName}windowdaycmp'+cmpid);
            var plugin{$i}_hour = document.getElementById('{$fieldName}windowhourcmp'+cmpid);
            var plugin{$i}_minute = document.getElementById('{$fieldName}windowminutecmp'+cmpid);
            var plugin{$i}_second = document.getElementById('{$fieldName}windowsecondcmp'+cmpid);

            if (plugin{$i}_day.value == '') plugin{$i}_day.value = '0';
            if (plugin{$i}_hour.value == '') plugin{$i}_hour.value = '0';
            if (plugin{$i}_minute.value == '') plugin{$i}_minute.value = '0';
            if (plugin{$i}_second.value == '') plugin{$i}_second.value = '0';
            ";
            $i++;
        }
        ?>

        phpAds_formLimitUpdate (cmpid);
    }

    function phpAds_formLimitUpdate (cmpid)
    {
        var cwday = document.getElementById('clickwindowdaycmp'+cmpid);
        var cwhour = document.getElementById('clickwindowhourcmp'+cmpid);
        var cwminute = document.getElementById('clickwindowminutecmp'+cmpid);
        var cwsecond = document.getElementById('clickwindowsecondcmp'+cmpid);

        var vwday = document.getElementById('viewwindowdaycmp'+cmpid);
        var vwhour = document.getElementById('viewwindowhourcmp'+cmpid);
        var vwminute = document.getElementById('viewwindowminutecmp'+cmpid);
        var vwsecond = document.getElementById('viewwindowsecondcmp'+cmpid);

        // Set -
        if (cwhour.value == '-' && cwday.value != '-') cwhour.value = '0';
        if (cwminute.value == '-' && cwhour.value != '-') cwminute.value = '0';
        if (cwsecond.value == '-' && cwminute.value != '-') cwsecond.value = '0';

        // Set 0
        if (cwday.value == '0') cwday.value = '-';
        if (cwday.value == '-' && cwhour.value == '0') cwhour.value = '-';
        if (cwhour.value == '-' && cwminute.value == '0') cwminute.value = '-';
        if (cwminute.value == '-' && cwsecond.value == '0') cwsecond.value = '-';

        // Set -
        if (vwhour.value == '-' && vwday.value != '-') vwhour.value = '0';
        if (vwminute.value == '-' && vwhour.value != '-') vwminute.value = '0';
        if (vwsecond.value == '-' && vwminute.value != '-') vwsecond.value = '0';

        // Set 0
        if (vwday.value == '0') vwday.value = '-';
        if (vwday.value == '-' && vwhour.value == '0') vwhour.value = '-';
        if (vwhour.value == '-' && vwminute.value == '0') vwminute.value = '-';
        if (vwminute.value == '-' && vwsecond.value == '0') vwsecond.value = '-';

        <?php
        $i = 0;
        foreach ($plugins as $plugin) {
            $fieldName = strtolower($plugin->trackerEvent);
            echo "
            var plugin{$i}_day = document.getElementById('{$fieldName}windowdaycmp'+cmpid);
            var plugin{$i}_hour = document.getElementById('{$fieldName}windowhourcmp'+cmpid);
            var plugin{$i}_minute = document.getElementById('{$fieldName}windowminutecmp'+cmpid);
            var plugin{$i}_second = document.getElementById('{$fieldName}windowsecondcmp'+cmpid);

            // Set -
            if (plugin{$i}_hour.value == '-' && plugin{$i}_day.value != '-') plugin{$i}_hour.value = '0';
            if (plugin{$i}_minute.value == '-' && plugin{$i}_hour.value != '-') plugin{$i}_minute.value = '0';
            if (plugin{$i}_second.value == '-' && plugin{$i}_minute.value != '-') plugin{$i}_second.value = '0';

            // Set 0
            if (plugin{$i}_day.value == '0') plugin{$i}_day.value = '-';
            if (plugin{$i}_day.value == '-' && plugin{$i}_hour.value == '0') plugin{$i}_hour.value = '-';
            if (plugin{$i}_hour.value == '-' && plugin{$i}_minute.value == '0') plugin{$i}_minute.value = '-';
            if (plugin{$i}_minute.value == '-' && plugin{$i}_second.value == '0') plugin{$i}_second.value = '-';
            ";

            $i++;
        }
        ?>

    }

    phpAds_reviewAll();
//-->
</script>

<?php
/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['tracker-campaigns.php']['hideinactive'] = $hideinactive;
$session['prefs']['tracker-campaigns.php']['listorder'] = $listorder;
$session['prefs']['tracker-campaigns.php']['orderdirection'] = $orderdirection;

phpAds_SessionDataStore();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>