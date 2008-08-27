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
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobal (
     'action'
    ,'trackerids'
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
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
OA_Permission::enforceAccessToObject('clients',   $clientid);
OA_Permission::enforceAccessToObject('campaigns', $campaignid);

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

if (!empty($campaignid)) {
    if (isset($action) && $action == 'set') {
        $doCampaigns_trackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaigns_trackers->campaignid = $campaignid;
        $doCampaigns_trackers->delete();

        if (isset($trackerids) && is_array($trackerids)) {
            for ($i=0; $i<sizeof($trackerids); $i++) {
                $clickwindow = $clickwindowday[$i] * (24*60*60) + $clickwindowhour[$i] * (60*60) + $clickwindowminute[$i] * (60) + $clickwindowsecond[$i];
                $viewwindow = $viewwindowday[$i] * (24*60*60) + $viewwindowhour[$i] * (60*60) + $viewwindowminute[$i] * (60) + $viewwindowsecond[$i];

                $fields = array('campaignid', 'trackerid', 'status', 'viewwindow', 'clickwindow');
                $values = array($campaignid, $trackerids[$i], $statusids[$i], $viewwindow, $clickwindow);

                foreach ($plugins as $plugin) {
                    $dbField = strtolower($plugin->trackerEvent) . "window";
                    $value = ${$dbField."day"}[$i] * (24*60*60) + ${$dbField."hour"}[$i] * (60*60) + ${$dbField."minute"}[$i] * (60) + ${$dbField."second"}[$i];
                    $fields[] = $dbField;
                    $values[] = $value;
                }

                $fieldsSize = count($fields);
                $doCampaigns_trackers = OA_Dal::factoryDO('campaigns_trackers');
                for ($k = 0; $k < $fieldsSize; $k++) {
                    $field = $fields[$k];
                    $doCampaigns_trackers->$field = $values[$k];
                }
                $doCampaigns_trackers->insert();

            }
        }
        $oUI = OA_Admin_UI::getInstance();
        OX_Admin_Redirect::redirect($oUI->getNextPage());
    }
}



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/


if (!isset($listorder)) {
    if (isset($session['prefs']['campaign-trackers.php']['listorder'])) {
        $listorder = $session['prefs']['campaign-trackers.php']['listorder'];
    } else {
        $listorder = '';
    }
}

if (!isset($orderdirection)) {
    if (isset($session['prefs']['campaign-trackers.php']['orderdirection'])) {
        $orderdirection = $session['prefs']['campaign-trackers.php']['orderdirection'];
    } else {
        $orderdirection = '';
    }
}

// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
$tabindex = 1;
$agencyId = OA_Permission::getAgencyId();
$aEntities = array('clientid' => $clientid, 'campaignid' => $campaignid);

// Display navigation
$aOtherAdvertisers = Admin_DA::getAdvertisers(array('agency_id' => $agencyId));
$aOtherCampaigns = Admin_DA::getPlacements(array('advertiser_id' => $clientid));
MAX_displayNavigationCampaign($pageName, $aOtherAdvertisers, $aOtherCampaigns, $aEntities);

if (!empty($campaignid)) {
    $doCampaigns = OA_Dal::factoryDO('campaigns');
    if ($doCampaigns->get($campaignid)) {
        $campaign = $doCampaigns->toArray();
    }
}

$tabindex = 1;

// Header
echo "\t\t\t\t<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>\n";
echo "\t\t\t\t<tr height='25'>\n";
echo "\t\t\t\t\t<td height='25' width='40%'>\n";
echo "\t\t\t\t\t\t<b>&nbsp;&nbsp;<a href='campaign-trackers.php?clientid=".$clientid."&campaignid=".$campaignid."&listorder=name'>".$GLOBALS['strName']."</a>";

if (($listorder == "name") || ($listorder == "")) {
    if  (($orderdirection == "") || ($orderdirection == "down")) {
        echo " <a href='campaign-trackers.php?clientid=".$clientid."&campaignid=".$campaignid."&orderdirection=up'>";
        echo "<img src='" . OX::assetPath() . "/images/caret-ds.gif' border='0' alt='' title=''>";
    } else {
        echo " <a href='campaign-trackers.php?clientid=".$clientid."&campaignid=".$campaignid."&orderdirection=down'>";
        echo "<img src='" . OX::assetPath() . "/images/caret-u.gif' border='0' alt='' title=''>";
    }
    echo "</a>";
}

echo "</b>\n";
echo "\t\t\t\t\t</td>\n";
echo "\t\t\t\t\t<td width='40'>";
echo "<b><a href='campaign-trackers.php?clientid=".$clientid."&campaignid=".$campaignid."&listorder=id'>".$GLOBALS['strID']."</a>";

if ($listorder == "id") {
    if  (($orderdirection == "") || ($orderdirection == "down")) {
        echo " <a href='campaign-trackers.php?clientid=".$clientid."&campaignid=".$campaignid."&orderdirection=up'>";
        echo "<img src='" . OX::assetPath() . "/images/caret-ds.gif' border='0' alt='' title=''>";
    } else {
        echo " <a href='campaign-trackers.php?clientid=".$clientid."&campaignid=".$campaignid."&orderdirection=down'>";
        echo "<img src='" . OX::assetPath() . "/images/caret-u.gif' border='0' alt='' title=''>";
    }
    echo "</a>";
}
echo "</b></td>\n";

echo "\t\t\t\t\t<td width='100'>\n";
echo "\t\t\t\t\t\t<b>".$GLOBALS['strDefaultStatus']."</b>\n";
echo "\t\t\t\t\t</td>\n";

echo "\t\t\t\t\t<td>\n";
echo "\t\t\t\t\t\t<b>".$GLOBALS['strConversionWindow']."</b>\n";
echo "\t\t\t\t\t</td>\n";

echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr height='1'>\n";
echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";

$i = 0;
$checkedall = true;

if (!empty($campaignid)) {
    $doCampaign_trackers = OA_Dal::factoryDO('campaigns_trackers');
    $doCampaign_trackers->campaignid = $campaignid;
    $campaign_tracker_row = $doCampaign_trackers->getAll(array(), $indexBy = 'trackerid');

}

$doTrackers = OA_Dal::factoryDO('trackers');
$doTrackers->clientid = $clientid;
$doTrackers->addListOrderBy($listorder, $orderdirection);
$doTrackers->find();

if ($doTrackers->getRowCount() == 0) {
    echo "\t\t\t\t<tr bgcolor='#F6F6F6'>\n";
    echo "\t\t\t\t\t<td colspan='4' height='25'>&nbsp;&nbsp;".$strNoTrackersToLink."</td>\n";
    echo "\t\t\t\t</tr>\n";
} else {
    echo "\t\t\t\t<form name='availabletrackers' method='post' action='campaign-trackers.php'>\n";
    echo "\t\t\t\t<input type='hidden' name='campaignid' value='".$GLOBALS['campaignid']."'>\n";
    echo "\t\t\t\t<input type='hidden' name='clientid' value='".$GLOBALS['clientid']."'>\n";
    echo "\t\t\t\t<input type='hidden' name='action' value='set'>\n";
    $trackers = $doTrackers->getAll();

    foreach ($trackers as $tracker) {

        if ($i > 0) {
            echo "\t\t\t\t<tr height='1'>\n";
            echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>\n";
            echo "\t\t\t\t</tr>\n";
        }
        echo "\t\t\t\t<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">\n";

        // Begin row
        echo "\t\t\t\t\t<td height='25'>";

        // Show checkbox
        if (isset($campaign_tracker_row[$tracker['trackerid']])) {
            echo "<input id='trk".$tracker['trackerid']."' type='checkbox' name='trackerids[]' value='".$tracker['trackerid']."' checked onclick='phpAds_reviewAll();' tabindex='".($tabindex++)."'>";
        } else {
            echo "<input id='trk".$tracker['trackerid']."' type='checkbox' name='trackerids[]' value='".$tracker['trackerid']."' onclick='phpAds_reviewAll();' tabindex='".($tabindex++)."'>";
            $checkedall = false;
        }

        // Campaign icon
        echo "<img src='" . OX::assetPath() . "/images/icon-tracker.gif' align='absmiddle'>&nbsp;";

        // Name
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            echo "<a href='tracker-edit.php?clientid=".$tracker['clientid']."&trackerid=".$tracker['trackerid']."'>";
            echo phpAds_breakString ($tracker['trackername'], '60')."</a>";
        } else {
            echo phpAds_breakString ($tracker['trackername'], '60');
        }
        echo "</td>\n";

        // ID
        echo "\t\t\t\t\t<td height='25'>".$tracker['trackerid']."</td>\n";

        // Status
        $statuses = $GLOBALS['_MAX']['STATUSES'];
        $startStatusesIds = array(1,2,4);
        echo "\t\t\t\t\t<td height='25'>";
        echo "<select name='statusids[]' id='statustrk".$tracker['trackerid']."' tabindex='".($tabindex++)."'>\n";

        if (isset($campaign_tracker_row[$tracker['trackerid']]['status'])) {
            $trackerStatusId = $campaign_tracker_row[$tracker['trackerid']]['status'];
        } else {
            $trackerStatusId = $tracker['status'];
        }

        foreach($statuses as $statusId => $statusName) {
            if(in_array($statusId, $startStatusesIds)) {
                echo "<option value='$statusId' ". ($trackerStatusId == $statusId ? 'selected' : '')." >{$GLOBALS[$statusName]}&nbsp;</option>\n";
            }
        }
        echo "</select>\n";
        echo "</td>\n";

        $seconds_left = $tracker['clickwindow'];
        if (isset($campaign_tracker_row[$tracker['trackerid']]))
            $seconds_left = $campaign_tracker_row[$tracker['trackerid']]['clickwindow'];

        $clickwindowday = floor($seconds_left / (60*60*24));
        $seconds_left = $seconds_left % (60*60*24);
        $clickwindowhour = floor($seconds_left / (60*60));
        $seconds_left = $seconds_left % (60*60);
        $clickwindowminute = floor($seconds_left / (60));
        $seconds_left = $seconds_left % (60);
        $clickwindowsecond = $seconds_left;

        // Click Window
        echo "<td nowrap>".$strClick."&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<input id='clickwindowdaytrk".$tracker['trackerid']."' class='flat' type='text' size='3' name='clickwindowday[]' value='".$clickwindowday."' onKeyUp=\"phpAds_formLimitUpdate('".$tracker['trackerid']."');\" tabindex='".($tabindex++)."'> ".$strDays." &nbsp;&nbsp;";
        echo "<input id='clickwindowhourtrk".$tracker['trackerid']."' class='flat' type='text' size='3' name='clickwindowhour[]' value='".$clickwindowhour."' onKeyUp=\"phpAds_formLimitUpdate('".$tracker['trackerid']."');\" tabindex='".($tabindex++)."'> ".$strHours." &nbsp;&nbsp;";
        echo "<input id='clickwindowminutetrk".$tracker['trackerid']."' class='flat' type='text' size='3' name='clickwindowminute[]' value='".$clickwindowminute."' onKeyUp=\"phpAds_formLimitUpdate('".$tracker['trackerid']."');\" tabindex='".($tabindex++)."'> ".$strMinutes." &nbsp;&nbsp;";
        echo "<input id='clickwindowsecondtrk".$tracker['trackerid']."' class='flat' type='text' size='3' name='clickwindowsecond[]' value='".$clickwindowsecond."' onBlur=\"phpAds_formLimitBlur('".$tracker['trackerid']."');\" onKeyUp=\"phpAds_formLimitUpdate('".$tracker['trackerid']."');\" tabindex='".($tabindex++)."'> ".$strSeconds." &nbsp;&nbsp;";
        echo "</td>";

        echo "\t\t\t\t</tr>\n";

        // Mini Break Line
        echo "\t\t\t\t<tr height='1'>\n";
        echo "\t\t\t\t\t<td".($i%2==0?" bgcolor='#F6F6F6'":"")."><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>\n";
        echo "\t\t\t\t\t<td colspan='3'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>\n";
        echo "\t\t\t\t</tr>\n";

        echo "<tr height='25'".($i%2==0?" bgcolor='#F6F6F6'":"").">";
        echo "<td>&nbsp;</td>";
        echo "<td>&nbsp;</td>";
        echo "<td>&nbsp;</td>";

        $seconds_left = $tracker['viewwindow'];
        if (isset($campaign_tracker_row[$tracker['trackerid']]))
            $seconds_left = $campaign_tracker_row[$tracker['trackerid']]['viewwindow'];

        $viewwindowday = floor($seconds_left / (60*60*24));
        $seconds_left = $seconds_left % (60*60*24);
        $viewwindowhour = floor($seconds_left / (60*60));
        $seconds_left = $seconds_left % (60*60);
        $viewwindowminute = floor($seconds_left / (60));
        $seconds_left = $seconds_left % (60);
        $viewwindowsecond = $seconds_left;

        // View Window
        echo "<td nowrap>".$strView."&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<input id='viewwindowdaytrk".$tracker['trackerid']."' class='flat' type='text' size='3' name='viewwindowday[]' value='".$viewwindowday."' onKeyUp=\"phpAds_formLimitUpdate('".$tracker['trackerid']."');\" tabindex='".($tabindex++)."'> ".$strDays." &nbsp;&nbsp;";
        echo "<input id='viewwindowhourtrk".$tracker['trackerid']."' class='flat' type='text' size='3' name='viewwindowhour[]' value='".$viewwindowhour."' onKeyUp=\"phpAds_formLimitUpdate('".$tracker['trackerid']."');\" tabindex='".($tabindex++)."'> ".$strHours." &nbsp;&nbsp;";
        echo "<input id='viewwindowminutetrk".$tracker['trackerid']."' class='flat' type='text' size='3' name='viewwindowminute[]' value='".$viewwindowminute."' onKeyUp=\"phpAds_formLimitUpdate('".$tracker['trackerid']."');\" tabindex='".($tabindex++)."'> ".$strMinutes." &nbsp;&nbsp;";
        echo "<input id='viewwindowsecondtrk".$tracker['trackerid']."' class='flat' type='text' size='3' name='viewwindowsecond[]' value='".$viewwindowsecond."' onBlur=\"phpAds_formLimitBlur('".$tracker['trackerid']."');\" onKeyUp=\"phpAds_formLimitUpdate('".$tracker['trackerid']."');\" tabindex='".($tabindex++)."'> ".$strSeconds." &nbsp;&nbsp;";
        echo "</td>";

        // End row
        echo "</tr>"."\n";

        foreach ($plugins as $plugin) {
            $fieldName = strtolower($plugin->trackerEvent);
            $seconds_left = $tracker[$fieldName . 'window'];
            if (isset($campaign_tracker_row[$tracker['trackerid']])) {
                $seconds_left = $campaign_tracker_row[$tracker['trackerid']][$fieldName . 'window'];
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
            echo "\t\t\t\t\t<td".($i%2==0?" bgcolor='#F6F6F6'":"")."><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>\n";
            echo "\t\t\t\t\t<td colspan='3'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>\n";
            echo "\t\t\t\t</tr>\n";

            echo "<tr height='25'".($i%2==0?" bgcolor='#F6F6F6'":"").">";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";

            echo "<td nowrap>" . ucfirst($fieldName) . "&nbsp;&nbsp;";
            echo "<input id='{$fieldName}windowdaytrk{$tracker['trackerid']}' class='flat' type='text' size='3' name='{$fieldName}windowday[]' value='{$days}' onKeyUp=\"phpAds_formLimitUpdate('{$tracker['trackerid']}');\" tabindex='".($tabindex++)."'> ".$strDays." &nbsp;&nbsp;";
            echo "<input id='{$fieldName}windowhourtrk{$tracker['trackerid']}' class='flat' type='text' size='3' name='{$fieldName}windowhour[]' value='{$hours}' onKeyUp=\"phpAds_formLimitUpdate('{$tracker['trackerid']}');\" tabindex='".($tabindex++)."'> ".$strHours." &nbsp;&nbsp;";
            echo "<input id='{$fieldName}windowminutetrk{$tracker['trackerid']}' class='flat' type='text' size='3' name='{$fieldName}windowminute[]' value='{$minutes}' onKeyUp=\"phpAds_formLimitUpdate('{$tracker['trackerid']}');\" tabindex='".($tabindex++)."'> ".$strMinutes." &nbsp;&nbsp;";
            echo "<input id='{$fieldName}windowsecondtrk{$tracker['trackerid']}' class='flat' type='text' size='3' name='{$fieldName}windowsecond[]' value='{$seconds}' onBlur=\"phpAds_formLimitBlur('{$tracker['trackerid']}');\" onKeyUp=\"phpAds_formLimitUpdate('{$tracker['trackerid']}');\" tabindex='".($tabindex++)."'> ".$strSeconds." &nbsp;&nbsp;";
            echo "</td></tr>";
        }

        $i++;
    }
}

echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>"."\n";
echo "<input type='checkbox' name='checkall' value=''".($checkedall == true ? ' checked' : '')." onclick='phpAds_toggleAll();' tabindex='".($tabindex++)."'>"."\n";
echo "<b>".$strCheckAllNone."</b>"."\n";
echo "</td>\n";
echo "<td>&nbsp;</td>\n";
echo "<td>&nbsp;</td>\n";
echo "<td>&nbsp;</td>\n";
echo "</tr>\n";

echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='25' align='".$phpAds_TextAlignLeft."' nowrap>&nbsp;</td>\n";
echo "<td colspan='2' align='".$phpAds_TextAlignRight."' nowrap>"."\n";

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
        if (document.availabletrackers) {
            for (var i=0; i<document.availabletrackers.elements.length; i++)
            {
                if (document.availabletrackers.elements[i].name == 'trackerids[]')
                {
                    if (document.availabletrackers.elements[i].checked == false)
                    {
                        allchecked = true;
                    }
                }
            }
            return allchecked;
        }
    }

    function phpAds_toggleAll()
    {
        var allchecked = phpAds_getAllChecked();

        if (document.availabletrackers) {
            for (var i=0; i<document.availabletrackers.elements.length; i++)
            {
                if (document.availabletrackers.elements[i].name == 'trackerids[]')
                {
                    document.availabletrackers.elements[i].checked = allchecked;
                }
            }
            phpAds_reviewAll();
        }

    }

    function phpAds_reviewAll()
    {
        if (document.availabletrackers) {

            for (var i=0; i<document.availabletrackers.elements.length; i++)
            {
                var element = document.availabletrackers.elements[i];
                if (element.id.substring(0,3) == 'trk')
                {
                    var trkid = element.id.substring(3);
                    phpAds_formLimitBlur(trkid);
                    phpAds_formLimitUpdate(trkid);

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
                    $i = 0;
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
                        $i++;
                    }
                    ?>
                }
            }
            document.availabletrackers.checkall.checked = !phpAds_getAllChecked();
        }
    }

    function phpAds_formLimitBlur (trkid)
    {
        var cwday = document.getElementById('clickwindowdaytrk'+trkid);
        var cwhour = document.getElementById('clickwindowhourtrk'+trkid);
        var cwminute = document.getElementById('clickwindowminutetrk'+trkid);
        var cwsecond = document.getElementById('clickwindowsecondtrk'+trkid);

        if (cwday.value == '') cwday.value = '0';
        if (cwhour.value == '') cwhour.value = '0';
        if (cwminute.value == '') cwminute.value = '0';
        if (cwsecond.value == '') cwsecond.value = '0';

        var vwday = document.getElementById('viewwindowdaytrk'+trkid);
        var vwhour = document.getElementById('viewwindowhourtrk'+trkid);
        var vwminute = document.getElementById('viewwindowminutetrk'+trkid);
        var vwsecond = document.getElementById('viewwindowsecondtrk'+trkid);

        if (vwday.value == '') vwday.value = '0';
        if (vwhour.value == '') vwhour.value = '0';
        if (vwminute.value == '') vwminute.value = '0';
        if (vwsecond.value == '') vwsecond.value = '0';

        <?php
        $i = 0;
        foreach ($plugins as $plugin) {
            $fieldName = strtolower($plugin->trackerEvent);
            echo "
            var plugin{$i}_day = document.getElementById('{$fieldName}windowdaytrk'+trkid);
            var plugin{$i}_hour = document.getElementById('{$fieldName}windowhourtrk'+trkid);
            var plugin{$i}_minute = document.getElementById('{$fieldName}windowminutetrk'+trkid);
            var plugin{$i}_second = document.getElementById('{$fieldName}windowsecondtrk'+trkid);

            if (plugin{$i}_day.value == '') plugin{$i}_day.value = '0';
            if (plugin{$i}_hour.value == '') plugin{$i}_hour.value = '0';
            if (plugin{$i}_minute.value == '') plugin{$i}_minute.value = '0';
            if (plugin{$i}_second.value == '') plugin{$i}_second.value = '0';
            ";
            $i++;
        }
        ?>

        phpAds_formLimitUpdate (trkid);
    }

    function phpAds_formLimitUpdate (trkid)
    {
        var cwday = document.getElementById('clickwindowdaytrk'+trkid);
        var cwhour = document.getElementById('clickwindowhourtrk'+trkid);
        var cwminute = document.getElementById('clickwindowminutetrk'+trkid);
        var cwsecond = document.getElementById('clickwindowsecondtrk'+trkid);

        // Set -
        if (cwhour.value == '-' && cwday.value != '-') cwhour.value = '0';
        if (cwminute.value == '-' && cwhour.value != '-') cwminute.value = '0';
        if (cwsecond.value == '-' && cwminute.value != '-') cwsecond.value = '0';

        // Set 0
        if (cwday.value == '0') cwday.value = '-';
        if (cwday.value == '-' && cwhour.value == '0') cwhour.value = '-';
        if (cwhour.value == '-' && cwminute.value == '0') cwminute.value = '-';
        if (cwminute.value == '-' && cwsecond.value == '0') cwsecond.value = '-';

        var vwday = document.getElementById('viewwindowdaytrk'+trkid);
        var vwhour = document.getElementById('viewwindowhourtrk'+trkid);
        var vwminute = document.getElementById('viewwindowminutetrk'+trkid);
        var vwsecond = document.getElementById('viewwindowsecondtrk'+trkid);

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
            var plugin{$i}_day = document.getElementById('{$fieldName}windowdaytrk'+trkid);
            var plugin{$i}_hour = document.getElementById('{$fieldName}windowhourtrk'+trkid);
            var plugin{$i}_minute = document.getElementById('{$fieldName}windowminutetrk'+trkid);
            var plugin{$i}_second = document.getElementById('{$fieldName}windowsecondtrk'+trkid);

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

$session['prefs']['campaign-trackers.php']['listorder'] = $listorder;
$session['prefs']['campaign-trackers.php']['orderdirection'] = $orderdirection;

phpAds_SessionDataStore();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>