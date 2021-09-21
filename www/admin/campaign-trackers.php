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
phpAds_registerGlobal(
    'action',
    'trackerids',
    'clickwindowday',
    'clickwindowhour',
    'clickwindowminute',
    'clickwindows',
    'clickwindowsecond',
    'hideinactive',
    'statusids',
    'submit',
    'viewwindowday',
    'viewwindowhour',
    'viewwindowminute',
    'viewwindows',
    'viewwindowsecond'
);


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('campaigns', $campaignid);

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid] = $campaignid;
phpAds_SessionDataStore();

// Initalise any tracker based plugins
$plugins = [];
$invocationPlugins = &OX_Component::getComponents('invocationTags');
foreach ($invocationPlugins as $pluginKey => $plugin) {
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
        OA_Permission::checkSessionToken();

        $clickWindow = _windowValuesToseconds($clickwindowday, $clickwindowhour, $clickwindowminute, $clickwindowsecond);
        $viewWindow = _windowValuesToseconds($viewwindowday, $viewwindowhour, $viewwindowminute, $viewwindowsecond);

        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignid);
        $doCampaigns->viewwindow = $viewWindow;
        $doCampaigns->clickwindow = $clickWindow;
        $doCampaigns->update();

        $doCampaigns_trackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaigns_trackers->campaignid = $campaignid;
        $doCampaigns_trackers->delete();
        if (isset($trackerids) && is_array($trackerids)) {
            for ($i = 0; $i < sizeof($trackerids); $i++) {
                $aFields = ['campaignid', 'trackerid', 'status'];
                $values = [$campaignid, $trackerids[$i], $statusids[$i]];

                $fieldsSize = count($aFields);
                $doCampaigns_trackers = OA_Dal::factoryDO('campaigns_trackers');
                for ($k = 0; $k < $fieldsSize; $k++) {
                    $field = $aFields[$k];
                    $doCampaigns_trackers->$field = $values[$k];
                }
                $doCampaigns_trackers->insert();
            }
        }

        // Queue confirmation message
        $translation = new OX_Translation();
        $translated_message = $translation->translate($GLOBALS['strCampaignTrackersHaveBeenUpdated'], [
            MAX::constructURL(MAX_URL_ADMIN, "campaign-edit.php?clientid=" . $clientid . "&campaignid=" . $campaignid),
            htmlspecialchars($doCampaigns->campaignname)
        ]);
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

        OX_Admin_Redirect::redirect("campaign-trackers.php?clientid=" . $clientid . "&campaignid=" . $campaignid);
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
$pageName = basename($_SERVER['SCRIPT_NAME']);
$tabindex = 1;
$agencyId = OA_Permission::getAgencyId();
$aEntities = ['clientid' => $clientid, 'campaignid' => $campaignid];

// Display navigation
$aOtherAdvertisers = Admin_DA::getAdvertisers(['agency_id' => $agencyId]);
$aOtherCampaigns = Admin_DA::getPlacements(['advertiser_id' => $clientid]);
MAX_displayNavigationCampaign($campaignid, $aOtherAdvertisers, $aOtherCampaigns, $aEntities);

if (!empty($campaignid)) {
    $doCampaigns = OA_Dal::factoryDO('campaigns');
    if ($doCampaigns->get($campaignid)) {
        $campaign = $doCampaigns->toArray();
    }
}

$tabindex = 1;

echo "\t\t\t\t<form name='availabletrackers' method='post' action='campaign-trackers.php'>\n";
echo "\t\t\t\t<input type='hidden' name='campaignid' value='" . $GLOBALS['campaignid'] . "'>\n";
echo "\t\t\t\t<input type='hidden' name='clientid' value='" . $GLOBALS['clientid'] . "'>\n";
echo "\t\t\t\t<input type='hidden' name='action' value='set'>\n";
echo "\t\t\t\t<input type='hidden' name='token' value='" . htmlspecialchars(phpAds_SessionGetToken(), ENT_QUOTES) . "'>\n";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>" . "\n";
echo "<tr><td height='25' width='100%' colspan='3'><b>{$GLOBALS['strConversionWindow']}</b></td></tr>" . "\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>" . "\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>" . "\n";


// Header
echo "\t\t\t\t\n";

// View Window
echo "<tr height='25'><td nowrap>{$GLOBALS['strView']}&nbsp;&nbsp;&nbsp;&nbsp;";
OX_Display_ConversionWindowHTML('viewwindow', $campaign['viewwindow'], $tabindex);
echo "</td></tr>";

// Click Window
echo "<tr height='25'><td nowrap>{$GLOBALS['strClick']}&nbsp;&nbsp;&nbsp;&nbsp;";
OX_Display_ConversionWindowHTML('clickwindow', $campaign['clickwindow'], $tabindex);
echo "</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>" . "\n";

// Linked trackers
echo "<tr><td height='25' colspan='3'><b>{$GLOBALS['strLinkedTrackers']}</b></td></tr>" . "\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>" . "\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>" . "\n";

echo "<tr><td height='25' width='40%'>\n";
echo "<b>&nbsp;&nbsp;<a href='campaign-trackers.php?clientid={$clientid}&campaignid={$campaignid}&listorder=name'>{$GLOBALS['strName']}</a>";

if (($listorder == "name") || ($listorder == "")) {
    if (($orderdirection == "") || ($orderdirection == "down")) {
        echo " <a href='campaign-trackers.php?clientid={$clientid}&campaignid={$campaignid}&orderdirection=up'>";
        echo "<img src='" . OX::assetPath() . "/images/caret-ds.gif' border='0' alt='' title=''>";
    } else {
        echo " <a href='campaign-trackers.php?clientid={$clientid}&campaignid={$campaignid}&orderdirection=down'>";
        echo "<img src='" . OX::assetPath() . "/images/caret-u.gif' border='0' alt='' title=''>";
    }
    echo "</a>";
}

echo "</b>\n";
echo "\t\t\t\t\t</td>\n";
echo "\t\t\t\t\t<td width='40'>";
echo "<b><a href='campaign-trackers.php?clientid={$clientid}&campaignid={$campaignid}&listorder=id'>{$GLOBALS['strID']}</a>";

if ($listorder == "id") {
    if (($orderdirection == "") || ($orderdirection == "down")) {
        echo " <a href='campaign-trackers.php?clientid={$clientid}&campaignid={$campaignid}&orderdirection=up'>";
        echo "<img src='" . OX::assetPath() . "/images/caret-ds.gif' border='0' alt='' title=''>";
    } else {
        echo " <a href='campaign-trackers.php?clientid={$clientid}&campaignid={$campaignid}&orderdirection=down'>";
        echo "<img src='" . OX::assetPath() . "/images/caret-u.gif' border='0' alt='' title=''>";
    }
    echo "</a>";
}
echo "</b></td>\n";

echo "\t\t\t\t\t<td width='100'>\n";
echo "\t\t\t\t\t\t<b>{$GLOBALS['strDefaultStatus']}</b>\n";
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
    $campaign_tracker_row = $doCampaign_trackers->getAll([], $indexBy = 'trackerid');
}

$doTrackers = OA_Dal::factoryDO('trackers');
$doTrackers->clientid = $clientid;
$doTrackers->addListOrderBy($listorder, $orderdirection);
$doTrackers->find();

if ($doTrackers->getRowCount() == 0) {
    echo "\t\t\t\t<tr bgcolor='#F6F6F6'>\n";
    echo "\t\t\t\t\t<td colspan='4' height='25'>&nbsp;&nbsp;" . $strNoTrackersToLink . "</td>\n";
    echo "\t\t\t\t</tr>\n";
} else {
    $trackers = $doTrackers->getAll();

    foreach ($trackers as $tracker) {
        if ($i > 0) {
            echo "\t\t\t\t<tr height='1'>\n";
            echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>\n";
            echo "\t\t\t\t</tr>\n";
        }
        echo "\t\t\t\t<tr height='25' " . ($i % 2 == 0 ? "bgcolor='#F6F6F6'" : "") . ">\n";

        // Begin row
        echo "\t\t\t\t\t<td height='25'>";

        // Show checkbox
        if (isset($campaign_tracker_row[$tracker['trackerid']])) {
            echo "<input id='trk" . $tracker['trackerid'] . "' type='checkbox' name='trackerids[]' value='" . $tracker['trackerid'] . "' checked onclick='phpAds_reviewAll();' tabindex='" . ($tabindex++) . "'>";
        } else {
            echo "<input id='trk" . $tracker['trackerid'] . "' type='checkbox' name='trackerids[]' value='" . $tracker['trackerid'] . "' onclick='phpAds_reviewAll();' tabindex='" . ($tabindex++) . "'>";
            $checkedall = false;
        }

        // Campaign icon
        echo "<img src='" . OX::assetPath() . "/images/icon-tracker.gif' align='absmiddle'>&nbsp;";

        // Name
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            echo "<a href='tracker-edit.php?clientid=" . $tracker['clientid'] . "&trackerid=" . $tracker['trackerid'] . "'>";
            echo htmlspecialchars(phpAds_breakString($tracker['trackername'], '60')) . "</a>";
        } else {
            echo htmlspecialchars(phpAds_breakString($tracker['trackername'], '60'));
        }
        echo "</td>\n";

        // ID
        echo "\t\t\t\t\t<td height='25'>" . $tracker['trackerid'] . "</td>\n";

        // Status
        $statuses = $GLOBALS['_MAX']['STATUSES'];
        $startStatusesIds = [1, 2, 4];
        echo "\t\t\t\t\t<td height='25'>";
        echo "<select name='statusids[]' id='statustrk" . $tracker['trackerid'] . "' tabindex='" . ($tabindex++) . "'>\n";

        if (isset($campaign_tracker_row[$tracker['trackerid']]['status'])) {
            $trackerStatusId = $campaign_tracker_row[$tracker['trackerid']]['status'];
        } else {
            $trackerStatusId = $tracker['status'];
        }

        foreach ($statuses as $statusId => $statusName) {
            if (in_array($statusId, $startStatusesIds)) {
                echo "<option value='$statusId' " . ($trackerStatusId == $statusId ? 'selected' : '') . " >{$GLOBALS[$statusName]}&nbsp;</option>\n";
            }
        }
        echo "</select>\n";
        echo "</td>\n";


        // Mini Break Line
        echo "\t\t\t\t<tr height='1'>\n";
        echo "\t\t\t\t\t<td" . ($i % 2 == 0 ? " bgcolor='#F6F6F6'" : "") . "><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>\n";
        echo "\t\t\t\t\t<td colspan='3'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>\n";
        echo "\t\t\t\t</tr>\n";

        echo "<tr height='25'" . ($i % 2 == 0 ? " bgcolor='#F6F6F6'" : "") . ">";
        echo "<td>&nbsp;</td>";
        echo "<td>&nbsp;</td>";
        echo "<td>&nbsp;</td>";

        $i++;
    }
}

echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td></tr>" . "\n";
echo "<tr " . ($i % 2 == 0 ? "bgcolor='#F6F6F6'" : "") . "><td height='25'>" . "\n";
echo "<input type='checkbox' name='checkall' value=''" . ($checkedall == true ? ' checked' : '') . " onclick='phpAds_toggleAll();' tabindex='" . ($tabindex++) . "'>" . "\n";
echo "<b>" . $strCheckAllNone . "</b>" . "\n";
echo "</td>\n";
echo "<td>&nbsp;</td>\n";
echo "<td>&nbsp;</td>\n";
echo "<td>&nbsp;</td>\n";
echo "</tr>\n";

echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>" . "\n";
echo "<tr><td height='25' align='" . $phpAds_TextAlignLeft . "' nowrap>&nbsp;</td>\n";
echo "<td colspan='2' align='" . $phpAds_TextAlignRight . "' nowrap>" . "\n";

echo "&nbsp;&nbsp;</td></tr>" . "\n";
echo "</table>" . "\n";
echo "<br /><br /><br /><br />" . "\n";

echo "<input type='submit' name='submit' value='$strSaveChanges' tabindex='" . ($tabindex++) . "'>" . "\n";
echo "</form>" . "\n";

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
                    phpAds_formLimitBlur();
                    phpAds_formLimitUpdate();

                    var logelement = document.getElementById('status' + element.id);
                    if (logelement) logelement.disabled = !element.checked;
                }
            }
            document.availabletrackers.checkall.checked = !phpAds_getAllChecked();
        }
    }

    function phpAds_formLimitBlur()
    {
        var cwday = document.getElementById('clickwindowdaytrk');
        var cwhour = document.getElementById('clickwindowhourtrk');
        var cwminute = document.getElementById('clickwindowminutetrk');
        var cwsecond = document.getElementById('clickwindowsecondtrk');

        if (cwday.value == '') cwday.value = '0';
        if (cwhour.value == '') cwhour.value = '0';
        if (cwminute.value == '') cwminute.value = '0';
        if (cwsecond.value == '') cwsecond.value = '0';

        var vwday = document.getElementById('viewwindowdaytrk');
        var vwhour = document.getElementById('viewwindowhourtrk');
        var vwminute = document.getElementById('viewwindowminutetrk');
        var vwsecond = document.getElementById('viewwindowsecondtrk');

        if (vwday.value == '') vwday.value = '0';
        if (vwhour.value == '') vwhour.value = '0';
        if (vwminute.value == '') vwminute.value = '0';
        if (vwsecond.value == '') vwsecond.value = '0';

        phpAds_formLimitUpdate();
    }

    function phpAds_formLimitUpdate()
    {
        var cwday = document.getElementById('clickwindowdaytrk');
        var cwhour = document.getElementById('clickwindowhourtrk');
        var cwminute = document.getElementById('clickwindowminutetrk');
        var cwsecond = document.getElementById('clickwindowsecondtrk');

        // Set -
        if (cwhour.value == '-' && cwday.value != '-') cwhour.value = '0';
        if (cwminute.value == '-' && cwhour.value != '-') cwminute.value = '0';
        if (cwsecond.value == '-' && cwminute.value != '-') cwsecond.value = '0';

        // Set 0
        if (cwday.value == '0') cwday.value = '-';
        if (cwday.value == '-' && cwhour.value == '0') cwhour.value = '-';
        if (cwhour.value == '-' && cwminute.value == '0') cwminute.value = '-';
        if (cwminute.value == '-' && cwsecond.value == '0') cwsecond.value = '-';

        var vwday = document.getElementById('viewwindowdaytrk');
        var vwhour = document.getElementById('viewwindowhourtrk');
        var vwminute = document.getElementById('viewwindowminutetrk');
        var vwsecond = document.getElementById('viewwindowsecondtrk');

        // Set -
        if (vwhour.value == '-' && vwday.value != '-') vwhour.value = '0';
        if (vwminute.value == '-' && vwhour.value != '-') vwminute.value = '0';
        if (vwsecond.value == '-' && vwminute.value != '-') vwsecond.value = '0';

        // Set 0
        if (vwday.value == '0') vwday.value = '-';
        if (vwday.value == '-' && vwhour.value == '0') vwhour.value = '-';
        if (vwhour.value == '-' && vwminute.value == '0') vwminute.value = '-';
        if (vwminute.value == '-' && vwsecond.value == '0') vwsecond.value = '-';
    }
    phpAds_formLimitUpdate()
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
