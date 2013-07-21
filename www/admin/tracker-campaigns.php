<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once LIB_PATH . '/Plugin/Component.php';

// Register input variables
phpAds_registerGlobal (
     'action'
    ,'campaignids'
    ,'hideinactive'
    ,'statusids'
    ,'submit'
);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('trackers', $trackerid);


/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
phpAds_SessionDataStore();

// Initalise any tracker based plugins
$plugins = array();
$invocationPlugins = &OX_Component::getComponents('invocationTags');
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

                $aFields = array("campaignid", "trackerid", "status", "viewwindow", "clickwindow");
                $values = array($campaignids[$i], $trackerid, $statusids[$i], $viewwindow, $clickwindow);

                $doCampaign_trackers = OA_Dal::factoryDO('campaigns_trackers');
                for ($k = 0; $k < count($aFields); $k++) {
                    $field = $aFields[$k];
                    $doCampaign_trackers->$field = $values[$k];
                }
                $doCampaign_trackers->insert();
            }
        }

        // Queue confirmation message
        $doTrackers = OA_Dal::factoryDO('trackers');
        $doTrackers->get($trackerid);

        $translation = new OX_Translation();
        $translated_message = $translation->translate ( $GLOBALS['strTrackerCampaignsHaveBeenUpdated'], array(
            MAX::constructURL(MAX_URL_ADMIN, "tracker-edit.php?clientid=".$clientid."&trackerid=".$trackerid),
            htmlspecialchars($doTrackers->trackername)
        ));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

        header ("Location: tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid);
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



$doClients = OA_Dal::factoryDO('clients');
$doClients->whereAdd('clientid <>'.$trackerid);
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    $doClients->agencyid = OA_Permission::getAgencyId();
}
$doClients->find();
$aOtherAdvertisers = array();
while ($doClients->fetch() && $row = $doClients->toArray()) {
    $aOtherAdvertisers[] = $row;
}
MAX_displayNavigationTracker($clientid, $trackerid, $aOtherAdvertisers);

$doTrackers = OA_Dal::factoryDO('trackers');
if ($doTrackers->get($trackerid)) {
    $tracker = $doTrackers->toArray();
}

$tabindex = 1;

$i = 0;
$checkedall = true;
$campaignshidden = 0;

$defaults = array(
    'status' => MAX_CONNECTION_STATUS_PENDING
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


if ($doCampaigns->getRowCount() != 0) {
    echo "\t\t\t\t<form name='availablecampaigns' method='post' action='tracker-campaigns.php'>\n";
    echo "\t\t\t\t<input type='hidden' name='trackerid' value='".$GLOBALS['trackerid']."'>\n";
    echo "\t\t\t\t<input type='hidden' name='clientid' value='".$GLOBALS['clientid']."'>\n";
    echo "\t\t\t\t<input type='hidden' name='action' value='set'>\n";
}


// Header
echo "\t\t\t\t<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>\n";
echo "\t\t\t\t<tr height='25'>\n";
echo "\t\t\t\t\t<td height='25' width='40%'>\n";
echo "\t\t\t\t\t\t<b>&nbsp;&nbsp;<a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&listorder=name'>".$GLOBALS['strName']."</a>";

if (($listorder == "name") || ($listorder == "")) {
    if  (($orderdirection == "") || ($orderdirection == "down")) {
        echo " <a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&orderdirection=up'>";
        echo "<img src='" . OX::assetPath() . "/images/caret-ds.gif' border='0' alt='' title=''>";
    } else {
        echo " <a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&orderdirection=down'>";
        echo "<img src='" . OX::assetPath() . "/images/caret-u.gif' border='0' alt='' title=''>";
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
        echo "<img src='" . OX::assetPath() . "/images/caret-ds.gif' border='0' alt='' title=''>";
    } else {
        echo " <a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&orderdirection=down'>";
        echo "<img src='" . OX::assetPath() . "/images/caret-u.gif' border='0' alt='' title=''>";
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
echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";



if ($doCampaigns->getRowCount() == 0) {
    echo "\t\t\t\t<tr bgcolor='#F6F6F6'>\n";
    echo "\t\t\t\t\t<td colspan='4' height='25'>&nbsp;&nbsp;".$strNoCampaignsToLink."</td>\n";
    echo "\t\t\t\t</tr>\n";
} else {
    $campaigns = $doCampaigns->getAll(array(), $indexByPrimaryKey = true);

    foreach ($campaigns as $campaign) {

        if ($campaign['status'] == OA_ENTITY_STATUS_RUNNING || $hideinactive != '1') {
            if ($i > 0) {
                echo "\t\t\t\t<tr height='1'>\n";
                echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>\n";
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
            if ($campaign['status'] == OA_ENTITY_STATUS_RUNNING) {
                echo "<img src='" . OX::assetPath() . "/images/icon-campaign.gif' align='absmiddle'>&nbsp;";
            }
            else {
                echo "<img src='" . OX::assetPath() . "/images/icon-campaign-d.gif' align='absmiddle'>&nbsp;";
            }

            // Name
            if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)) {
                echo "<a href='campaign-trackers.php?clientid=".$campaign['clientid']."&campaignid=".$campaign['campaignid']."'>";
                echo htmlspecialchars(phpAds_breakString ($campaign['campaignname'], '60'))."</a>";
            } else {
                echo htmlspecialchars(phpAds_breakString ($campaign['campaignname'], '60'));
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

            echo "<td nowrap>".$strView."&nbsp;&nbsp;&nbsp;&nbsp;";
            OX_Display_ConversionWindowHTML('viewwindow', $campaign['viewwindow'], $tabindex, false);
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

            echo "<td nowrap>".$strClick."&nbsp;&nbsp;&nbsp;&nbsp;";
            OX_Display_ConversionWindowHTML('clickwindow', $campaign['clickwindow'], $tabindex, false);
            echo "</td>";

            // End row
            echo "</tr>"."\n";

            $i++;
        } else {
            $campaignshidden++;
        }
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
echo "<tr><td height='25' align='".$phpAds_TextAlignLeft."' nowrap>"."\n";

if ($hideinactive == true) {
    echo "&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-activate.gif' align='absmiddle' border='0'>";
    echo "&nbsp;<a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&hideinactive=0'>".$strShowAll."</a>";
    echo "&nbsp;&nbsp;|&nbsp;&nbsp;".$campaignshidden." ".$strInactiveCampaignsHidden;
} else {
    echo "&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-hideinactivate.gif' align='absmiddle' border='0'>"."\n";
    echo "&nbsp;<a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid."&hideinactive=1'>".$strHideInactiveCampaigns."</a>"."\n";
}

echo "</td><td colspan='2' align='".$phpAds_TextAlignRight."' nowrap>"."\n";

echo "&nbsp;&nbsp;</td></tr>"."\n";
echo "</table>"."\n";
echo "<br /><br /><br /><br />"."\n";

echo "<input type='submit' id='submit' name='submit' value='$strSaveChanges' tabindex='".($tabindex++)."'>"."\n";
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
                var logelement = document.getElementById('status' + element.id);
                if (logelement) logelement.disabled = !element.checked;
            }
        }

        document.availablecampaigns.checkall.checked = !phpAds_getAllChecked();
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
