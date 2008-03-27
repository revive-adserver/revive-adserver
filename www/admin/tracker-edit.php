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
     'clickwindow'
    ,'description'
    ,'move'
    ,'submit'
    ,'trackername'
    ,'viewwindow'
    ,'status'
    ,'type'
    ,'linkcampaigns'
);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('trackers', $trackerid, true);

// Initalise any tracker based plugins
$plugins = array();
$invocationPlugins = &MAX_Plugin::getPlugins('invocationTags');
foreach($invocationPlugins as $pluginKey => $plugin) {
    if (!empty($plugin->trackerEvent)) {
        $plugins[] = $plugin;
        $fieldName = strtolower($plugin->trackerEvent);
        phpAds_registerGlobal("{$fieldName}window");
    }
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (isset($submit)) {
    // If ID is not set, it should be a null-value for the auto_increment

    if (empty($trackerid)) {
        $trackerid = "null";
    }

    $new_tracker = $trackerid == 'null';

    // Set window delays
    if (isset($clickwindow)) {
        $clickwindow_seconds = 0;
        if ($clickwindow['second'] != '-') $clickwindow_seconds += (int)$clickwindow['second'];
        if ($clickwindow['minute'] != '-') $clickwindow_seconds += (int)$clickwindow['minute'] * 60;
        if ($clickwindow['hour'] != '-')     $clickwindow_seconds += (int)$clickwindow['hour'] * 60*60;
        if ($clickwindow['day'] != '-')     $clickwindow_seconds += (int)$clickwindow['day'] * 60*60*24;
    } else {
        $clickwindow_seconds = 0;
    }
    if (isset($viewwindow)) {
        $viewwindow_seconds = 0;
        if ($viewwindow['second'] != '-') $viewwindow_seconds += (int)$viewwindow['second'];
        if ($viewwindow['minute'] != '-') $viewwindow_seconds += (int)$viewwindow['minute'] * 60;
        if ($viewwindow['hour'] != '-')     $viewwindow_seconds += (int)$viewwindow['hour'] * 60*60;
        if ($viewwindow['day'] != '-')     $viewwindow_seconds += (int)$viewwindow['day'] * 60*60*24;
    } else {
        $viewwindow_seconds = 0;
    }

    $doTrackers = OA_Dal::factoryDO('trackers');
    $doTrackers->trackername = MAX_commonGetValueUnslashed('trackername');
    $doTrackers->description = MAX_commonGetValueUnslashed('description');
    $doTrackers->clickwindow = $clickwindow_seconds;
    $doTrackers->viewwindow = $viewwindow_seconds;
    $doTrackers->status = $status;
    $doTrackers->type = $type;
    $doTrackers->linkcampaigns = isset($linkcampaigns) ? "t" : "f";
    $doTrackers->clientid = $clientid;

    foreach ($plugins as $plugin) {
        $dbField = strtolower($plugin->trackerEvent) . 'window';
        $value = ${$dbField}['day'] * (24*60*60) + ${$dbField}['hour'] * (60*60) + ${$dbField}['minute'] * (60) + ${$dbField}['second'];
        $doTrackers->$dbField = $value;
    }

    if (empty($trackerid) || $trackerid == "null") {
        $trackerid = $doTrackers->insert();
    } else {
        $doTrackers->trackerid = $trackerid;
        $doTrackers->update();
    }

    Header("Location: tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid);
    exit;
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if ($trackerid != "") {
    // Get other trackers
    $doTrackers = OA_Dal::factoryDO('trackers');
    $doTrackers->clientid = $clientid;
    $doTrackers->find();

    while ($doTrackers->fetch() && $row = $doTrackers->toArray()) {
        phpAds_PageContext(
            phpAds_buildName ($row['trackerid'], $row['trackername']),
            "tracker-edit.php?clientid=".$clientid."&trackerid=".$row['trackerid'],
            $trackerid == $row['trackerid']
        );
    }

    phpAds_PageShortcut($strClientProperties, 'advertiser-edit.php?clientid='.$clientid, 'images/icon-advertiser.gif');
    //phpAds_PageShortcut($strTrackerHistory, 'stats-tracker-history.php?clientid='.$clientid.'&trackerid='.$trackerid, 'images/icon-statistics.gif');

    $extra  = "\t\t\t\t<form action='tracker-modify.php'>"."\n";
    $extra .= "\t\t\t\t<input type='hidden' name='trackerid' value='$trackerid'>"."\n";
    $extra .= "\t\t\t\t<input type='hidden' name='clientid' value='$clientid'>"."\n";
    $extra .= "\t\t\t\t<input type='hidden' name='returnurl' value='tracker-edit.php'>"."\n";
    $extra .= "\t\t\t\t<br /><br />"."\n";
    $extra .= "\t\t\t\t<b>$strModifyTracker</b><br />"."\n";
    $extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='160' vspace='4'><br />"."\n";
    $extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/icon-duplicate-tracker.gif' align='absmiddle'>&nbsp;<a href='tracker-modify.php?clientid=".$clientid."&trackerid=".$trackerid."&duplicate=true&returnurl=tracker-edit.php'>$strDuplicate</a><br />"."\n";
    $extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='160' vspace='4'><br />"."\n";
    $extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/icon-move-tracker.gif' align='absmiddle'>&nbsp;$strMoveTo<br />"."\n";
    $extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='160' vspace='2'><br />"."\n";
    $extra .= "\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."\n";
    $extra .= "\t\t\t\t<select name='moveto' style='width: 110;'>"."\n";

    $doClients = OA_Dal::factoryDO('clients');
    $doClients->whereAdd('clientid <>'.$clientid);
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $doClients->agencyid = OA_Permission::getAgencyId();
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

    phpAds_PageHeader("4.1.4.2", $extra);
    echo "<img src='" . MAX::assetPath() . "/images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getClientName(phpAds_getTrackerParentClientID($trackerid));
    echo "&nbsp;<img src='" . MAX::assetPath() . "/images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
    echo "<img src='" . MAX::assetPath() . "/images/icon-tracker.gif' align='absmiddle'>&nbsp;<b>".phpAds_getTrackerName($trackerid)."</b><br /><br /><br />";
    phpAds_ShowSections(array("4.1.4.2", "4.1.4.3", "4.1.4.5", "4.1.4.6", "4.1.4.4"));
} else {
    if (isset($move) && $move == 't') {
        // Convert client to tracker
        phpAds_PageHeader("4.1.4.2");
        echo "<img src='" . MAX::assetPath() . "/images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid);
        echo "&nbsp;<img src='" . MAX::assetPath() . "/images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
        echo "<img src='" . MAX::assetPath() . "/images/icon-tracker.gif' align='absmiddle'>&nbsp;<b>".$strUntitled."</b><br /><br /><br />";
        phpAds_ShowSections(array("4.1.4.2"));
    } else {
        // New tracker
        phpAds_PageHeader("4.1.4.1");
        echo "<img src='" . MAX::assetPath() . "/images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid);
        echo "&nbsp;<img src='" . MAX::assetPath() . "/images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
        echo "<img src='" . MAX::assetPath() . "/images/icon-tracker.gif' align='absmiddle'>&nbsp;<b>".$strUntitled."</b><br /><br /><br />";
        phpAds_ShowSections(array("4.1.4.1"));
    }
}

if ($trackerid != "" || (isset($move) && $move == 't')) {
    // Edit or Convert
    // Fetch exisiting settings
    // Parent setting for converting, tracker settings for editing
    if ($trackerid != "") $ID = $trackerid;
    if (isset($move) && $move == 't') {
        if (isset($clientid) && $clientid != "") $ID = $clientid;
    }
    $doTrackers = OA_Dal::factoryDO('trackers');
    $doTrackers->get($ID);
    $row = $doTrackers->toArray();
} else {
    // New tracker
    $doClients = OA_Dal::factoryDO('clients');
    $doClients->clientid = $clientid;

    if ($doClients->find() && $doClients->fetch() && $client = $doClients->toArray()) {
        $row['trackername'] = $client['clientname'].' - ';
    } else {
        $row['trackername'] = '';
    }

    $row['trackername']  .= $strDefault." ".$strTracker;
    $row['clickwindow']   = $conf['logging']['defaultImpressionConnectionWindow'];
    $row['viewwindow']    = $conf['logging']['defaultClickConnectionWindow'];
    $row['status']        = isset($pref['tracker_default_status']) ? $pref['tracker_default_status'] : MAX_CONNECTION_STATUS_APPROVED;
    $row['type']          = isset($pref['tracker_default_type']) ? $pref['tracker_default_type'] : MAX_CONNECTION_TYPE_SALE;
    $row['linkcampaigns'] = $pref['tracker_link_campaigns'] == true ? 't' : 'f';

    $row['description'] = '';
}

// Parse the number of seconds in the conversion windows into days, hours, minutes, seconds..
$seconds_left = $row['clickwindow'];
$clickwindow['day'] = floor($seconds_left / (60*60*24));
$seconds_left = $seconds_left % (60*60*24);
$clickwindow['hour'] = floor($seconds_left / (60*60));
$seconds_left = $seconds_left % (60*60);
$clickwindow['minute'] = floor($seconds_left / (60));
$seconds_left = $seconds_left % (60);
$clickwindow['second'] = $seconds_left;

$seconds_left = $row['viewwindow'];
$viewwindow['day'] = floor($seconds_left / (60*60*24));
$seconds_left = $seconds_left % (60*60*24);
$viewwindow['hour'] = floor($seconds_left / (60*60));
$seconds_left = $seconds_left % (60*60);
$viewwindow['minute'] = floor($seconds_left / (60));
$seconds_left = $seconds_left % (60);
$viewwindow['second'] = $seconds_left;


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$tabindex = 1;

echo "<br /><br />";
echo "<form name='clientform' method='post' action='tracker-edit.php' onSubmit='return max_formValidate(this);'>"."\n";
echo "<input type='hidden' name='trackerid' value='".(isset($trackerid) ? $trackerid : '')."'>"."\n";
echo "<input type='hidden' name='clientid' value='".(isset($clientid) ? $clientid : '')."'>"."\n";
echo "<input type='hidden' name='move' value='".(isset($move) ? $move : '')."'>"."\n";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>"."\n";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td>"."\n";
echo "\t"."<td width='200'>".$strName."</td>"."\n";
echo "\t"."<td><input class='flat' type='text' name='trackername' size='35' style='width:350px;' value='".phpAds_htmlQuotes($row['trackername'])."' tabindex='".($tabindex++)."'></td>"."\n";
echo "</tr>"."\n";
echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td>"."\n";
echo "\t"."<td width='200'>".$strDescription."</td>"."\n";
echo "\t"."<td><input class='flat' type='text' name='description' size='35' style='width:350px;' value='".phpAds_htmlQuotes($row['description'])."' tabindex='".($tabindex++)."'></td>"."\n";
echo "</tr>"."\n";
echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>". 'Conversion type' ."</td>";
echo "<td valign='top'>";

$types = $GLOBALS['_MAX']['CONN_TYPES'];
echo "<select name='type' tabindex='".($tabindex++)."'>\n";

foreach($types as $typeId => $typeName) {
    echo "<option value='$typeId' ". ($row['type'] == $typeId ? 'selected' : '')." >{$GLOBALS[$typeName]}&nbsp;</option>\n";
}
echo "</select>\n";
echo "</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr><td height='25' colspan='3'><b>".$strDefaultConversionRules."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strClickWindow."</td>";
echo "<td valign='top'>";
echo "<input id='clickwindowday' class='flat' type='text' size='3' name='clickwindow[day]' value='".$clickwindow['day']."' onKeyUp=\"phpAds_formLimitUpdate(this.form);\" tabindex='".($tabindex++)."'> ".$strDays." &nbsp;&nbsp;";
echo "<input id='clickwindowhour' class='flat' type='text' size='3' name='clickwindow[hour]' value='".$clickwindow['hour']."' onKeyUp=\"phpAds_formLimitUpdate(this.form);\" tabindex='".($tabindex++)."'> ".$strHours." &nbsp;&nbsp;";
echo "<input id='clickwindowminute' class='flat' type='text' size='3' name='clickwindow[minute]' value='".$clickwindow['minute']."' onKeyUp=\"phpAds_formLimitUpdate(this.form);\" tabindex='".($tabindex++)."'> ".$strMinutes." &nbsp;&nbsp;";
echo "<input id='clickwindowsecond' class='flat' type='text' size='3' name='clickwindow[second]' value='".$clickwindow['second']."' onBlur=\"phpAds_formLimitBlur(this.form);\" onKeyUp=\"phpAds_formLimitUpdate(this.form);\" tabindex='".($tabindex++)."'> ".$strSeconds." &nbsp;&nbsp;";
echo "</td></tr>";
echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strViewWindow."</td>";
echo "<td valign='top'>";
echo "<input id='viewwindowday' class='flat' type='text' size='3' name='viewwindow[day]' value='".$viewwindow['day']."' onKeyUp=\"phpAds_formLimitUpdate(this.form);\" tabindex='".($tabindex++)."'> ".$strDays." &nbsp;&nbsp;";
echo "<input id='viewwindowhour' class='flat' type='text' size='3' name='viewwindow[hour]' value='".$viewwindow['hour']."' onKeyUp=\"phpAds_formLimitUpdate(this.form);\" tabindex='".($tabindex++)."'> ".$strHours." &nbsp;&nbsp;";
echo "<input id='viewwindowminute' class='flat' type='text' size='3' name='viewwindow[minute]' value='".$viewwindow['minute']."' onKeyUp=\"phpAds_formLimitUpdate(this.form);\" tabindex='".($tabindex++)."'> ".$strMinutes." &nbsp;&nbsp;";
echo "<input id='viewwindowsecond' class='flat' type='text' size='3' name='viewwindow[second]' value='".$viewwindow['second']."' onBlur=\"phpAds_formLimitBlur(this.form);\" onKeyUp=\"phpAds_formLimitUpdate(this.form);\" tabindex='".($tabindex++)."'> ".$strSeconds." &nbsp;&nbsp;";
echo "</td></tr>";
echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

foreach ($plugins as $plugin) {
    $fieldName = strtolower($plugin->trackerEvent);

    $seconds_left = $row[$fieldName . 'window'];
    $window['day'] = floor($seconds_left / (60*60*24));
    $seconds_left = $seconds_left % (60*60*24);
    $window['hour'] = floor($seconds_left / (60*60));
    $seconds_left = $seconds_left % (60*60);
    $window['minute'] = floor($seconds_left / (60));
    $seconds_left = $seconds_left % (60);
    $window['second'] = $seconds_left;

    echo "<tr><td width='30'>&nbsp;</td>";
    echo "<td width='200'>" . ucfirst($fieldName) . " window</td>";
    echo "<td valign='top'>";
    echo "<input id='{$fieldName}windowday' class='flat' type='text' size='3' name='{$fieldName}window[day]' value='{$window['day']}' onKeyUp=\"phpAds_formLimitUpdate(this.form);\" tabindex='".($tabindex++)."'> ".$strDays." &nbsp;&nbsp;";
    echo "<input id='{$fieldName}windowhour' class='flat' type='text' size='3' name='{$fieldName}window[hour]' value='{$window['hour']}' onKeyUp=\"phpAds_formLimitUpdate(this.form);\" tabindex='".($tabindex++)."'> ".$strHours." &nbsp;&nbsp;";
    echo "<input id='{$fieldName}windowminute' class='flat' type='text' size='3' name='{$fieldName}window[minute]' value='{$window['minute']}' onKeyUp=\"phpAds_formLimitUpdate(this.form);\" tabindex='".($tabindex++)."'> ".$strMinutes." &nbsp;&nbsp;";
    echo "<input id='{$fieldName}windowsecond' class='flat' type='text' size='3' name='{$fieldName}window[second]' value='{$window['second']}' onBlur=\"phpAds_formLimitBlur(this.form);\" onKeyUp=\"phpAds_formLimitUpdate(this.form);\" tabindex='".($tabindex++)."'> ".$strSeconds." &nbsp;&nbsp;";
    echo "</td></tr>";
    echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
    echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
}

echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strDefaultStatus."</td>";
echo "<td valign='top'>";

$statuses = $GLOBALS['_MAX']['STATUSES'];
$startStatusesIds = array(1,2,4);
echo "<select name='status' tabindex='".($tabindex++)."'>\n";

foreach($statuses as $statusId => $statusName) {
    if(in_array($statusId, $startStatusesIds)) {
        echo "<option value='$statusId' ". ($row['status'] == $statusId ? 'selected' : '')." >{$GLOBALS[$statusName]}&nbsp;</option>\n";
    }
}
echo "</select>\n";
echo "</td></tr>";
echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
echo "<input type='checkbox' name='linkcampaigns' value='t'".($row['linkcampaigns'] == 't' ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
echo $strLinkCampaignsByDefault;
echo "</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "</table>"."\n";

echo "<br /><br />"."\n";
echo "<input type='submit' name='submit' value='".$strSaveChanges."' tabindex='".($tabindex++)."'>"."\n";

echo "</form>"."\n";


/*-------------------------------------------------------*/
/* Form requirements                                     */
/*-------------------------------------------------------*/

// Get unique affiliate
$doTrackers = OA_Dal::factoryDO('trackers');
$doTrackers->clientid = $clientid;
$unique_names = $doTrackers->getUniqueValuesFromColumn('trackername');
if ($trackerid) {
    ArrayUtils::unsetIfKeyNumeric($unique_names, $row['trackername']);
}
?>

<script language='JavaScript'>
<!--
    max_formSetRequirements('trackername', '<?php echo addslashes($strName); ?>', true, 'unique');
    max_formSetUnique('trackername', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');

    function phpAds_formLimitBlur (f)
    {
        if (f.clickwindowday.value == '') f.clickwindowday.value = '0';
        if (f.clickwindowhour.value == '') f.clickwindowhour.value = '0';
        if (f.clickwindowminute.value == '') f.clickwindowminute.value = '0';
        if (f.clickwindowsecond.value == '') f.clickwindowsecond.value = '0';

        if (f.viewwindowday.value == '') f.viewwindowday.value = '0';
        if (f.viewwindowhour.value == '') f.viewwindowhour.value = '0';
        if (f.viewwindowminute.value == '') f.viewwindowminute.value = '0';
        if (f.viewwindowsecond.value == '') f.viewwindowsecond.value = '0';

        <?php
        foreach ($plugins as $plugin) {
            $fieldName = strtolower($plugin->trackerEvent);
            echo "
                if (f.{$fieldName}windowday.value == '') f.{$fieldName}windowday.value = '0';
                if (f.{$fieldName}windowhour.value == '') f.{$fieldName}windowhour.value = '0';
                if (f.{$fieldName}windowminute.value == '') f.{$fieldName}windowminute.value = '0';
                if (f.{$fieldName}windowsecond.value == '') f.{$fieldName}windowsecond.value = '0';
            ";
        }
        ?>
        phpAds_formLimitUpdate (f);
    }

    function phpAds_formLimitUpdate (f)
    {
        // Set -
        if (f.clickwindowhour.value == '-' && f.clickwindowday.value != '-') f.clickwindowhour.value = '0';
        if (f.clickwindowminute.value == '-' && f.clickwindowhour.value != '-') f.clickwindowminute.value = '0';
        if (f.clickwindowsecond.value == '-' && f.clickwindowminute.value != '-') f.clickwindowsecond.value = '0';

        // Set 0
        if (f.clickwindowday.value == '0') f.clickwindowday.value = '-';
        if (f.clickwindowday.value == '-' && f.clickwindowhour.value == '0') f.clickwindowhour.value = '-';
        if (f.clickwindowhour.value == '-' && f.clickwindowminute.value == '0') f.clickwindowminute.value = '-';
        if (f.clickwindowminute.value == '-' && f.clickwindowsecond.value == '0') f.clickwindowsecond.value = '-';

        //  Set - if value negative
        if (f.clickwindowday.value < 0) f.clickwindowday.value = 0;
        if (f.clickwindowhour.value < 0) f.clickwindowhour.value = 0;
        if (f.clickwindowminute.value < 0) f.clickwindowminute.value = 0;
        if (f.clickwindowsecond.value < 0) f.clickwindowsecond.value = 0;

        // Set -
        if (f.viewwindowhour.value == '-' && f.viewwindowday.value != '-') f.viewwindowhour.value = '0';
        if (f.viewwindowminute.value == '-' && f.viewwindowhour.value != '-') f.viewwindowminute.value = '0';
        if (f.viewwindowsecond.value == '-' && f.viewwindowminute.value != '-') f.viewwindowsecond.value = '0';

        // Set 0
        if (f.viewwindowday.value == '0') f.viewwindowday.value = '-';
        if (f.viewwindowday.value == '-' && f.viewwindowhour.value == '0') f.viewwindowhour.value = '-';
        if (f.viewwindowhour.value == '-' && f.viewwindowminute.value == '0') f.viewwindowminute.value = '-';
        if (f.viewwindowminute.value == '-' && f.viewwindowsecond.value == '0') f.viewwindowsecond.value = '-';

        //  Set - if value negative
        if (f.viewwindowday.value < 0) f.viewwindowday.value = 0;
        if (f.viewwindowhour.value < 0) f.viewwindowhour.value = 0;
        if (f.viewwindowminute.value < 0) f.viewwindowminute.value = 0;
        if (f.viewwindowsecond.value < 0) f.viewwindowsecond.value = 0;


        <?php
        foreach ($plugins as $plugin) {
            $fieldName = strtolower($plugin->trackerEvent);
            echo "
                // Set -
                if (f.{$fieldName}windowhour.value == '-' && f.{$fieldName}windowday.value != '-') f.{$fieldName}windowhour.value = '0';
                if (f.{$fieldName}windowminute.value == '-' && f.{$fieldName}windowhour.value != '-') f.{$fieldName}windowminute.value = '0';
                if (f.{$fieldName}windowsecond.value == '-' && f.{$fieldName}windowminute.value != '-') f.{$fieldName}windowsecond.value = '0';

                // Set 0
                if (f.{$fieldName}windowday.value == '0') f.{$fieldName}windowday.value = '-';
                if (f.{$fieldName}windowday.value == '-' && f.{$fieldName}windowhour.value == '0') f.{$fieldName}windowhour.value = '-';
                if (f.{$fieldName}windowhour.value == '-' && f.{$fieldName}windowminute.value == '0') f.{$fieldName}windowminute.value = '-';
                if (f.{$fieldName}windowminute.value == '-' && f.{$fieldName}windowsecond.value == '0') f.{$fieldName}windowsecond.value = '-';
            ";
        }
        ?>
    }

    phpAds_formLimitUpdate(document.clientform);

//-->
</script>

<?php

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
