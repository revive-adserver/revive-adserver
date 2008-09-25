<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-gd.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/OX/Translation.php';

// Register input variables
phpAds_registerGlobal('expand', 'collapse', 'hideinactive', 'listorder', 'orderdirection');


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
if (!empty($clientid) && !OA_Permission::hasAccessToObject('clients', $clientid)) { //check if can see given advertiser
    $page = basename($_SERVER['PHP_SELF']);
    OX_Admin_Redirect::redirect($page);
}
if (!empty($campaignid) && !OA_Permission::hasAccessToObject('campaigns', $campaignid)) {
    $page = basename($_SERVER['PHP_SELF']);
    OX_Admin_Redirect::redirect("$page?clientid=$clientid");
}


/*-------------------------------------------------------*/
/* Init data                                             */
/*-------------------------------------------------------*/
//get advertisers and set the current one
$aAdvertisers = getAdvertiserMap();
if (empty($clientid)) { //if it's empty
    $campaignid = null; //reset campaign id, we could derive it after we have clientid
    if ($session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid']) {
        //try previous one from session
        $sessionClientId = $session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'];
        if (isset($aAdvertisers[$sessionClientId])) { //check if 'id' from session was not removed
            $clientid = $sessionClientId;
        }
    }
    if (empty($clientid)) { //was empty, is still empty - just pick one, no need for redirect
        $ids = array_keys($aAdvertisers);
        if (!empty($ids)) {
            $clientid = $ids[0];
        }
        else {
            $clientid = -1; //if no advertisers set to non-existent id
            $campaignid = -1; //also reset campaign id
        }
    }
}
else {
    if (!isset($aAdvertisers[$clientid])) {
        $page = basename($_SERVER['PHP_SELF']);
        OX_Admin_Redirect::redirect($page);
    }
}

//get campaigns - if there was any client id derived
if ($clientid > 0) {
    $aCampaigns = getCampaignMap($clientid);
    if (empty($campaignid)) { //if it's empty
        if ($session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid]) {
            //try previous one from session
            $sessionCampaignId = $session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid];
            if (isset($aCampaigns[$sessionCampaignId])) { //check if 'id' from session was not removed
                $campaignid = $sessionCampaignId;
            }
        }
        if (empty($campaignid)) { //was empty, is still empty - just pick one, no need for redirect
            $ids = array_keys($aCampaigns);
            $campaignid = !empty($ids) ? $ids[0] : -1; //if no campaigns set to non-existent id
        }
    }
    else {
        if (!isset($aCampaigns[$campaignid])) {
            $page = basename($_SERVER['PHP_SELF']);
            OX_Admin_Redirect::redirect("$page?clientid=$clientid");
        }
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
$tabindex = 1;
$agencyId = OA_Permission::getAgencyId();
$aEntities = array('clientid' => $clientid, 'campaignid' => $campaignid);
$oTrans = new OX_Translation();

// Display navigation
$aOtherAdvertisers = Admin_DA::getAdvertisers(array('agency_id' => $agencyId));
$aOtherCampaigns = Admin_DA::getPlacements(array('advertiser_id' => $clientid));

addPageTools($clientid, $campaignid);
$oHeaderModel = buildHeaderModel($aEntities);
phpAds_PageHeader(null, $oHeaderModel);


/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($hideinactive)) {
    if (isset($session['prefs']['campaign-banners.php'][$campaignid]['hideinactive'])) {
        $hideinactive = $session['prefs']['campaign-banners.php'][$campaignid]['hideinactive'];
    } else {
        $pref =& $GLOBALS['_MAX']['PREF'];
        $hideinactive = ($pref['ui_hide_inactive'] == true);
    }
}

if (!isset($listorder)) {
    if (isset($session['prefs']['campaign-banners.php'][$campaignid]['listorder'])) {
        $listorder = $session['prefs']['campaign-banners.php'][$campaignid]['listorder'];
    } else {
        $listorder = '';
    }
}

if (!isset($orderdirection)) {
    if (isset($session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'])) {
        $orderdirection = $session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'];
    } else {
        $orderdirection = '';
    }
}

if (isset($session['prefs']['campaign-banners.php'][$campaignid]['nodes'])) {
    $node_array = explode (",", $session['prefs']['campaign-banners.php'][$campaignid]['nodes']);
} else {
    $node_array = array();
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$doBanners = OA_Dal::factoryDO('banners');
$doBanners->campaignid = $campaignid;
$doBanners->addListorderBy($listorder, $orderdirection);
$doBanners->selectAdd('storagetype AS type');
$doBanners->find();

$countActive = 0;

while ($doBanners->fetch() && $row = $doBanners->toArray()) {
    $banners[$row['bannerid']] = $row;

    // mask banner name if anonymous campaign
    $campaign_details = Admin_DA::getPlacement($row['campaignid']);
    $campaignAnonymous = $campaign_details['anonymous'] == 't' ? true : false;
    $banners[$row['bannerid']]['description'] = MAX_getAdName($row['description'], null, null, $campaignAnonymous, $row['bannerid']);

    $banners[$row['bannerid']]['expand'] = 0;
    if ($row['status'] == OA_ENTITY_STATUS_RUNNING) {
        $countActive++;
    }
}

// Add ID found in expand to expanded nodes
if (isset($expand) && $expand != '') {
    switch ($expand) {
        case 'all':
            $node_array = array();
            if (isset($banners)) {
                foreach (array_keys($banners) as $key) {
                    $node_array[] = $key;
                }
            }
            break;

        case 'none':
            $node_array = array();
            break;

        default:
            $node_array[] = $expand;
            break;
    }
}

$node_array_size = sizeof($node_array);
for ($i=0; $i < $node_array_size; $i++) {
    if (isset($collapse) && $collapse == $node_array[$i]) {
        unset ($node_array[$i]);
    } else {
        if (isset($banners[$node_array[$i]])) {
            $banners[$node_array[$i]]['expand'] = 1;
        }
    }
}

// Figure out which banners are inactive,
$bannersHidden = 0;
if (isset($banners) && is_array($banners) && count($banners) > 0) {
    reset ($banners);
    while (list ($key, $banner) = each ($banners)) {
        if (($hideinactive == true) && ($banner['status'] != OA_ENTITY_STATUS_RUNNING)) {
            $bannersHidden++;
            unset($banners[$key]);
        }
    }
}

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";

echo "<tr height='25'>";
echo "<td height='25' width='40%'><b>&nbsp;&nbsp;<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid."&listorder=name'>".$GLOBALS['strName']."</a>";

if (($listorder == "name") || ($listorder == "")) {
    if  (($orderdirection == "") || ($orderdirection == "down")) {
        echo ' <a href="campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=up">';
        echo '<img src="' . OX::assetPath() . '/images/caret-ds.gif" border="0" alt="" title="">';
    } else{
        echo ' <a href="campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=down">';
        echo '<img src="' . OX::assetPath() . '/images/caret-u.gif" border="0" alt="" title="">';
    }
    echo '</a>';
}

echo '</b></td>';
echo '<td height="25"><b><a href="campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid.'&listorder=id">'.$GLOBALS['strID'].'</a>';

if ($listorder == "id") {
    if  (($orderdirection == "") || ($orderdirection == "down")) {
        echo '<a href="campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=up">';
        echo '<img src="' . OX::assetPath() . '/images/caret-ds.gif" border="0" alt="" title="">';
    } else {
        echo ' <a href="campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=down">';
        echo '<img src="' . OX::assetPath() . '/images/caret-u.gif" border="0" alt="" title="">';
    }
    echo '</a>';
}

echo '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "</tr>";

echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%' alt=''></td></tr>";

if (empty($clientid) || $clientid < 0) {
    echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='5'>";
    echo "&nbsp;&nbsp;$strNoClientsForBanners";
    echo "</td></tr>";
}
else if (empty($campaignid) || $campaignid < 0) {
    echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='5'>";
    $translation = new OX_Translation();
    $noBannersMsg = $translation->translate($GLOBALS['strNoCampaignsForBanners'], array($clientid));
    echo "&nbsp;&nbsp;$noBannersMsg";
    echo "</td></tr>";
}
else if (!isset($banners) || !is_array($banners) || count($banners) == 0) {
    echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='5'>";
    echo "&nbsp;&nbsp;$strNoBanners";
    echo "</td></tr>";
}
else {
    $i=0;
    foreach (array_keys($banners) as $bkey) {
        if ($i > 0) {
            echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%' alt=''></td></tr>";
        }

        // Icon & name
        $name = $strUntitled;
        if (isset($banners[$bkey]['alt']) && $banners[$bkey]['alt'] != '') {
            $name = $banners[$bkey]['alt'];
        }
        if (isset($banners[$bkey]['description']) && $banners[$bkey]['description'] != '') {
            $name = $banners[$bkey]['description'];
        }

        $name = phpAds_breakString ($name, '30');

        echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
        echo "&nbsp;";

        if (!$pref['ui_show_campaign_preview']) {
            if ($banners[$bkey]['expand'] == '1') {
                echo "<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid."&collapse=".$banners[$bkey]['bannerid']."'><img src='" . OX::assetPath() . "/images/triangle-d.gif' align='absmiddle' border='0' alt=''></a>&nbsp;";
            } else {
                echo "<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid."&expand=".$banners[$bkey]['bannerid']."'><img src='" . OX::assetPath() . "/images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0' alt=''></a>&nbsp;";
            }
        } else {
            echo "&nbsp;";
        }

        if ($banners[$bkey]['status'] == OA_ENTITY_STATUS_RUNNING) {
            if ($banners[$bkey]['type'] == 'html') {
                echo "<img src='" . OX::assetPath() . "/images/icon-banner-html.gif' align='absmiddle' alt=''>";
            } elseif ($banners[$bkey]['type'] == 'txt') {
                echo "<img src='" . OX::assetPath() . "/images/icon-banner-text.gif' align='absmiddle' alt=''>";
            } elseif ($banners[$bkey]['type'] == 'url') {
                echo "<img src='" . OX::assetPath() . "/images/icon-banner-url.gif' align='absmiddle' alt=''>";
            } else {
                echo "<img src='" . OX::assetPath() . "/images/icon-banner-stored.gif' align='absmiddle' alt=''>";
            }
        } else {
            if ($banners[$bkey]['type'] == 'html') {
                echo "<img src='" . OX::assetPath() . "/images/icon-banner-html-d.gif' align='absmiddle'>";
            } elseif ($banners[$bkey]['type'] == 'txt') {
                echo "<img src='" . OX::assetPath() . "/images/icon-banner-text-d.gif' align='absmiddle'>";
            } elseif ($banners[$bkey]['type'] == 'url') {
                echo "<img src='" . OX::assetPath() . "/images/icon-banner-url-d.gif' align='absmiddle'>";
            } else {
                echo "<img src='" . OX::assetPath() . "/images/icon-banner-stored-d.gif' align='absmiddle'>";
            }
        }

        echo "&nbsp;";
        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) && !OA_Permission::hasPermission(OA_PERM_BANNER_EDIT)) {
            echo htmlspecialchars($name);
        } else {
            echo "<a href='banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bkey."'>".htmlspecialchars($name)."</a>";
        }
        echo "</td>";

        // ID
        echo "<td height='25'>".$bkey."</td>";

        // Button 1
        echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
        if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;<a href='banner-acl.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$banners[$bkey]['bannerid']."'>$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
        } else {
            echo "&nbsp;";
        }
        echo "</td>";

        // Button 2
        echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
        $canActivate   = !OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) || OA_Permission::hasPermission(OA_PERM_BANNER_ACTIVATE);
        $canDeactivate = !OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) || OA_Permission::hasPermission(OA_PERM_BANNER_DEACTIVATE);
        if ($banners[$bkey]["status"] == OA_ENTITY_STATUS_RUNNING && $canDeactivate) {
            echo "<img src='" . OX::assetPath() . "/images/icon-deactivate.gif' align='absmiddle' border='0'>&nbsp;<a href='banner-activate.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$banners[$bkey]["bannerid"]."&value=".$banners[$bkey]["status"]."'>";
            echo $strDeActivate;
        } elseif ($banners[$bkey]["status"] == OA_ENTITY_STATUS_PAUSED && $canActivate) {
            echo "<img src='" . OX::assetPath() . "/images/icon-activate.gif' align='absmiddle' border='0'>&nbsp;<a href='banner-activate.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$banners[$bkey]["bannerid"]."&value=".$banners[$bkey]["status"]."'>";
            echo $strActivate;
        } else {
            echo "&nbsp;";
        }
        echo "</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";

        // Button 3
        echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            echo "&nbsp;";
        } else {
            echo "<img src='" . OX::assetPath() . "/images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;<a href='banner-delete.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$banners[$bkey]['bannerid']."&returnurl=campaign-banners.php'".phpAds_DelConfirm($strConfirmDeleteBanner).">$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        echo "</td></tr>";

        // Extra banner info
        if ($pref['ui_show_banner_info']) {
            echo "<tr height='1'>";
            echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='" . OX::assetPath() . "/images/spacer.gif' width='1' height='1'></td>";
            echo "<td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>";
            echo "</tr>";

            echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td colspan='1'>&nbsp;</td><td colspan='4'>";
            echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";

            echo "<tr height='25'><td colspan='2'>".htmlspecialchars(($banners[$bkey]['url'] != '' ? $banners[$bkey]['url'] : '-'))."</td></tr>";

            if ($banners[$bkey]['type'] == 'txt') {
                echo "<tr height='25'><td width='50%'>".$strSize.": ".strlen($banners[$bkey]['bannertext'])." ".$strChars."</td>";
            } else {
                echo "<tr height='25'><td width='50%'>".$strSize.": ".$banners[$bkey]['width']." x ".$banners[$bkey]['height']."</td>";
            }

            echo "<td width='50%'>".$strWeight.": ".$banners[$bkey]['weight']."</td></tr>";

            echo "</table><br /></td></tr>";
        }

        // Banner preview
        if ($banners[$bkey]['expand'] == 1 || $pref['ui_show_campaign_preview']) {
            if (!$pref['ui_show_banner_info']) {
                echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td colspan='1'>&nbsp;</td><td colspan='4'>";
            }

            echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td colspan='5'>";
            echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr>";
            echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td width='100%'>".phpAds_buildBannerCode ($banners[$bkey]['bannerid'], true)."</td>";
            echo "</tr></table><br /><br />";
            echo "</td></tr>";
        }

        $i++;
    }
}

// Display the items to:
//  - Show all banners, or hide the inactive banners
//  - Display how many inactive banners have been hidden, if applicable
//  - Expand all banner entries
//  - Collapse all banner entries
echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%' alt=''></td></tr>";
echo "<tr height='25'><td colspan='2' height='25' nowrap>";
if ($hideinactive == true) {
    echo "&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-activate.gif' align='absmiddle' border='0'>";
    echo "&nbsp;<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid."&hideinactive=0'>".$strShowAll."</a>";
    echo "&nbsp;&nbsp;|&nbsp;&nbsp;".$bannersHidden." ".$strInactiveBannersHidden;
} else {
    echo "&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-hideinactivate.gif' align='absmiddle' border='0'>";
    echo "&nbsp;<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid."&hideinactive=1'>".$strHideInactiveBanners."</a>";
}
echo "</td>";

if (!$pref['ui_show_campaign_preview']) {
    echo "<td colspan='3' align='".$phpAds_TextAlignRight."' nowrap>";
    echo "<img src='" . OX::assetPath() . "/images/triangle-d.gif' align='absmiddle' border='0' alt=''>";
    echo "&nbsp;<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid."&expand=all' accesskey='".$keyExpandAll."'>".$strExpandAll."</a>";
    echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
    echo "<img src='" . OX::assetPath() . "/images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0' alt=''>";
    echo "&nbsp;<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid."&expand=none' accesskey='".$keyCollapseAll."'>".$strCollapseAll."</a>";
    echo "</td>";
} else {
    echo "<td colspan='2'>&nbsp;</td>";
}
echo "</tr>";

// Display the items to:
//  - Delete all banners, if banners exist
//  - Activate all banners, if banners exist and some banners are inactive
//  - Deactivate all banners, if banners exist and some banners are active
if (isset($banners) && count($banners)) {
    echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-el.gif' height='1' width='100%' alt=''></td></tr>";
    echo "<tr height='25'>";
    echo "<td colspan='5' height='25' align='".$phpAds_TextAlignRight."'>";
    if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        echo "<img src='" . OX::assetPath() . "/images/icon-recycle.gif' border='0' align='absmiddle' alt=''>&nbsp;<a href='banner-delete.php?clientid=".$clientid."&campaignid=".$campaignid."&returnurl=campaign-banners.php'".phpAds_DelConfirm($strConfirmDeleteAllBanners).">$strDeleteAllBanners</a>&nbsp;&nbsp;&nbsp;&nbsp;";
        if ($countActive < count($banners)) {
            echo "<img src='" . OX::assetPath() . "/images/icon-activate.gif' border='0' align='absmiddle' alt=''>&nbsp;<a href='banner-activate.php?clientid=".$clientid."&campaignid=".$campaignid."&value=" . OA_ENTITY_STATUS_PAUSED . "'>$strActivateAllBanners</a>&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        if ($countActive > 0) {
            echo "<img src='" . OX::assetPath() . "/images/icon-deactivate.gif' border='0' align='absmiddle' alt=''>&nbsp;<a href='banner-activate.php?clientid=".$clientid."&campaignid=".$campaignid."&value=" . OA_ENTITY_STATUS_RUNNING . "'>$strDeactivateAllBanners</a>&nbsp;&nbsp;";
        }
    }
    echo "</td>";
    echo "</tr>";
}

echo "</table>";
echo "<br /><br />";
echo "<br /><br />";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>$strCreditStats</b></td></tr>";
echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%' alt=''></td></tr>";

$dalCampaigns = OA_Dal::factoryDAL('campaigns');
$expirationDates = $dalCampaigns->getDaysLeftString($campaignid);
$adImpressionsLeft = phpAds_formatNumber($dalCampaigns->getAdImpressionsLeft($campaignid));
$adClicksLeft = phpAds_formatNumber($dalCampaigns->getAdClicksLeft($campaignid));
$adConversionsLeft = phpAds_formatNumber($dalCampaigns->getAdConversionsLeft($campaignid));

echo "<tr><td height='25' width='33%'>$strViewCredits: <b>$adImpressionsLeft</b></td>";
echo "<td height='25' width='33%'>$strClickCredits: <b>$adClicksLeft</b></td>";
echo "<td height='25' width='33%'>$strConversionCredits: <b>$adConversionsLeft</b></td></tr>";
echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-el.gif' height='1' width='100%' alt=''></td></tr>";

echo "<tr><td height='25' width='33%'>";
if (!empty($expirationDates['estimatedExpiration'])) {
    echo "" . $expirationDates['estimatedExpiration'];
    echo "</td>";
    if (!empty($expirationDates['campaignExpiration'])) {
    	echo "<td height='25' width='33%'>" . $expirationDates['campaignExpiration'] . "</td>";
    }
} elseif (!empty($expirationDates['campaignExpiration'])) {
	echo "" . $expirationDates['campaignExpiration'] ;
}
echo "</td></tr>";

echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%' alt=''></td></tr>";
echo "</table>";
echo "<br /><br />";



/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['campaign-banners.php'][$campaignid]['hideinactive'] = $hideinactive;
$session['prefs']['campaign-banners.php'][$campaignid]['listorder'] = $listorder;
$session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'] = $orderdirection;
$session['prefs']['campaign-banners.php'][$campaignid]['nodes'] = implode (",", $node_array);
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid] = $campaignid;
phpAds_SessionDataStore();



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

function buildHeaderModel($aEntities)
{
    global $phpAds_TextDirection;
    $aConf = $GLOBALS['_MAX']['CONF'];

    $advertiserId = $aEntities['clientid'];
    $campaignId = $aEntities['campaignid'];
    $agencyId = OA_Permission::getAgencyId();

    $entityString = _getEntityString($aEntities);
    $aOtherEntities = $aEntities;
    unset($aOtherEntities['campaignid']);
    $otherEntityString = _getEntityString($aOtherEntities);

    $advertiser = phpAds_getClientDetails ($advertiserId);
    $advertiserName = $advertiser ['clientname'];
    $campaignDetails = Admin_DA::getPlacement($campaignId);
    $campaignName = $campaignDetails['name'];
    if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        $campaignEditUrl = "campaign-edit.php?clientid=$advertiserId&campaignid=$campaignId";
    }

    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader(array(
        array ('name' => $advertiserName, 'url' => '',
               'id' => $advertiserId, 'entities' => getAdvertiserMap($agencyId),
               'htmlName' => 'clientid'
              ),
        array ('name' => $campaignName, 'url' => $campaignEditUrl,
               'id' => $campaignId, 'entities' => getCampaignMap($advertiserId),
               'htmlName' => 'campaignid'
              ),
        array('name' => '')
    ), 'banners', 'list');

    return $oHeaderModel;
}


function getAdvertiserMap()
{
    $doClients = OA_Dal::factoryDO('clients');
    // Unless admin, restrict results shown.
    if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        $doClients->clientid = OA_Permission::getEntityId();
    }
    else {
        $doClients->agencyid = OA_Permission::getEntityId();
    }

    $doClients->find();

    $aAdvertiserMap = array();
    while ($doClients->fetch() && $row = $doClients->toArray()) {
        $aAdvertiserMap[$row['clientid']] = array('name' => $row['clientname'],
            'url' => "advertiser-campaigns.php?clientid=".$row['clientid']);
    }

    return $aAdvertiserMap;
}


function getCampaignMap($advertiserId)
{
    $aCampaigns = Admin_DA::getPlacements(array('advertiser_id' => $advertiserId));

    $aCampaignMap = array();
    foreach ($aCampaigns as $campaignId => $aCampaign) {
        $campaignName = $aCampaign['name'];
        // mask campaign name if anonymous campaign
        $campaign_details = Admin_DA::getPlacement($campaignId);
        $campaignName = MAX_getPlacementName($campaign_details);
        $aCampaignMap[$campaignId] = array('name' => $campaignName);
    }

    return $aCampaignMap;
}


function addPageTools($advertiserId, $campaignId)
{
    if (!($advertiserId > 0) || !($campaignId > 0)) {
        return;
    }

    if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        addPageLinkTool($GLOBALS["strAddBanner_Key"], "banner-edit.php?clientid=$advertiserId&campaignid=$campaignId", "iconBannerAdd", $GLOBALS["strAddNew"] );
    }
}
?>
