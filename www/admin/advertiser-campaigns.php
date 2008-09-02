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
require_once MAX_PATH . '/lib/OX/Util/Utils.php';

// Required files
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/max/other/html.php';

phpAds_registerGlobalUnslashed('expand', 'collapse', 'hideinactive', 'listorder', 'orderdirection');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
if (!empty($clientid)) { //check if client explicitly given
    OA_Permission::enforceAccessToObject('clients', $clientid);
}


//get advertisers and set the current one
$aAdvertisers = getAdvertiserMap();
if (empty($clientid)) {
    $ids = array_keys($aAdvertisers);
    if ($session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid']) {
        $clientid = $session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'];
    }
    
    if (!$clientid || !isset($aAdvertisers[$clientid])) { //check if 'current' from session was not removed 
        $clientid = !empty($ids) ? $ids[0] : -1; //if no advertisers set to non-existent id 
    }   
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/
addPageTools($clientid);
$oHeaderModel = buildHeaderModel($clientid, $aAdvertisers);
phpAds_PageHeader(null, $oHeaderModel);

/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($hideinactive)) {
	if (isset($session['prefs']['advertiser-campaigns.php'][$clientid]['hideinactive'])) {
		$hideinactive = $session['prefs']['advertiser-campaigns.php'][$clientid]['hideinactive'];
	} else {
	   $pref = &$GLOBALS['_MAX']['PREF'];
	   $hideinactive = ($pref['ui_hide_inactive'] == true);
	}
}

if (!isset($listorder)) {
	if (isset($session['prefs']['advertiser-campaigns.php'][$clientid]['listorder'])) {
		$listorder = $session['prefs']['advertiser-campaigns.php'][$clientid]['listorder'];
	} else {
		$listorder = '';
	}
}

if (!isset($orderdirection)) {
	if (isset($session['prefs']['advertiser-campaigns.php'][$clientid]['orderdirection'])) {
		$orderdirection = $session['prefs']['advertiser-campaigns.php'][$clientid]['orderdirection'];
	} else {
		$orderdirection = '';
	}
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Get clients & campaign and build the tree

$doCampaigns = OA_Dal::factoryDO('campaigns');
$doCampaigns->clientid = $clientid;

$doCampaigns->addListOrderBy($listorder, $orderdirection);
$doCampaigns->find();

while ($doCampaigns->fetch() && $row_campaigns = $doCampaigns->toArray()) {
	$campaigns[$row_campaigns['campaignid']]['campaignid']   = $row_campaigns['campaignid'];

    // mask campaign name if anonymous campaign
    $campaign_details = Admin_DA::getPlacement($row_campaigns['campaignid']);
    $row_campaigns['campaignname'] = MAX_getPlacementName($campaign_details);

	$campaigns[$row_campaigns['campaignid']]['campaignname'] = $row_campaigns['campaignname'];
	$campaigns[$row_campaigns['campaignid']]['impressions']  = phpAds_formatNumber($row_campaigns['views']);
	$campaigns[$row_campaigns['campaignid']]['clicks']       = phpAds_formatNumber($row_campaigns['clicks']);
	$campaigns[$row_campaigns['campaignid']]['conversions']  = phpAds_formatNumber($row_campaigns['conversions']);
	if (($row_campaigns['activate']) && ($row_campaigns['activate'] != '0000-00-00')) {
	   $oActivateDate = &new Date($row_campaigns['activate']);
	   $campaigns[$row_campaigns['campaignid']]['activate']  = $oActivateDate->format($date_format);
    } else {
       $campaigns[$row_campaigns['campaignid']]['activate']  = '-';
    }
	if (($row_campaigns['activate']) && ($row_campaigns['expire'] != '0000-00-00')) {
	   $oExpireDate = &new Date($row_campaigns['expire']);
	   $campaigns[$row_campaigns['campaignid']]['expire']    = $oExpireDate->format($date_format);
    } else {
       $campaigns[$row_campaigns['campaignid']]['expire']    = '-';
    }
    if ($row_campaigns['priority'] == -1) {
        $campaigns[$row_campaigns['campaignid']]['priority'] = $strExclusive;
    } elseif ($row_campaigns['priority'] == 0) {
        $campaigns[$row_campaigns['campaignid']]['priority'] = $strLow;
    } else {
        $campaigns[$row_campaigns['campaignid']]['priority'] = $strHigh . ' (' . $row_campaigns['priority'] . ')';
    }
	$campaigns[$row_campaigns['campaignid']]['expand'] = 0;
	$campaigns[$row_campaigns['campaignid']]['count']  = 0;
	$campaigns[$row_campaigns['campaignid']]['status'] = $row_campaigns['status'];
    $campaigns[$row_campaigns['campaignid']]['anonymous'] = $row_campaigns['anonymous'];
    $campaigns[$row_campaigns['campaignid']]['type'] =
    OX_Util_Utils::getCampaignType($row_campaigns['priority']);
}

// Build list
$campaignshidden = 0;
if (isset($campaigns) && is_array($campaigns) && count($campaigns) > 0) {
	reset ($campaigns);
	while (list ($key, $campaign) = each ($campaigns)) {
		if ($hideinactive == true && ($campaign['status'] != OA_ENTITY_STATUS_RUNNING || $campaign['status'] == OA_ENTITY_STATUS_RUNNING &&
			count($campaign['banners']) == 0 && count($campaign['banners']) < $campaign['count'])) {
			$campaignshidden++;
			unset($campaigns[$key]);
		}
	}
}
?>


<?php
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";

echo "<tr height='25'>";
echo "<td height='25' width='40%'><b>&nbsp;&nbsp;<a href='advertiser-campaigns.php?clientid=".$clientid."&listorder=name'>".$GLOBALS['strName']."</a>";

if (($listorder == "name") || ($listorder == "")) {
	if  (($orderdirection == "") || ($orderdirection == "down")) {
		echo ' <a href="advertiser-campaigns.php?clientid='.$clientid.'&orderdirection=up">';
		echo '<img src="' . OX::assetPath() . '/images/caret-ds.gif" border="0" alt="" title="">';
	} else {
		echo ' <a href="advertiser-campaigns.php?clientid='.$clientid.'&orderdirection=down">';
		echo '<img src="' . OX::assetPath() . '/images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}
echo '</b></td>';

echo '<td height="25"><b><a href="advertiser-campaigns.php?clientid='.$clientid.'&listorder=status">Status</a>';
if ($listorder == "status") {
	if  (($orderdirection == "") || ($orderdirection == "down")) {
    	echo ' <a href="advertiser-campaigns.php?clientid='.$clientid.'&orderdirection=up">';
        echo '<img src="' . OX::assetPath() . '/images/caret-ds.gif" border="0" alt="" title="">';
    } else {
    	echo ' <a href="advertiser-campaigns.php?clientid='.$clientid.'&orderdirection=down">';
        echo '<img src="' . OX::assetPath() . '/images/caret-u.gif" border="0" alt="" title="">';
    }
    echo '</a>';
}
echo "</td>";


echo '<td height="25"><b>'.$GLOBALS['strType'].'</b></td>';
echo '<td height="25"><b><a href="advertiser-campaigns.php?clientid='.$clientid.'&listorder=id">'.$GLOBALS['strID'].'</a>';

if ($listorder == "id") {
	if  (($orderdirection == "") || ($orderdirection == "down")) {
		echo ' <a href="advertiser-campaigns.php?clientid='.$clientid.'&orderdirection=up">';
		echo '<img src="' . OX::assetPath() . '/images/caret-ds.gif" border="0" alt="" title="">';
	} else {
		echo ' <a href="advertiser-campaigns.php?clientid='.$clientid.'&orderdirection=down">';
		echo '<img src="' . OX::assetPath() . '/images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "</tr>";

echo "<tr class='break'><td colspan='7' ></td></tr>";

if (!isset($campaigns) || !is_array($campaigns) || count($campaigns) == 0) {
	echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='5'>";
	if (empty($clientid) || $clientid < 0) {
       echo "&nbsp;&nbsp;$strNoClients";
    }
    else {
       echo "&nbsp;&nbsp;$strNoCampaigns";
    }
	echo "</td></tr>";
	echo "<tr class='break'><td colspan='7' ></td></tr>";

} else {
	$i=0;
	foreach (array_keys($campaigns) as $ckey) {
		// Icon & name
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
		echo "&nbsp;";
		if (isset($campaigns[$ckey]['banners'])) {
			if ($campaigns[$ckey]['expand'] == '1') {
				echo "<a href='advertiser-campaigns.php?clientid=".$clientid."&collapse=".$campaigns[$ckey]['campaignid']."'><img src='" . OX::assetPath() . "/images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
			} else {
				echo "<a href='advertiser-campaigns.php?clientid=".$clientid."&expand=".$campaigns[$ckey]['campaignid']."'><img src='" . OX::assetPath() . "/images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
			}
		} else {
		    echo "<img src='" . OX::assetPath() . "/images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;";
		}
		if ($campaigns[$ckey]['status'] == OA_ENTITY_STATUS_RUNNING) {
			echo "<img src='" . OX::assetPath() . "/images/icon-campaign.gif' align='absmiddle'>&nbsp;";
		} else {
			echo "<img src='" . OX::assetPath() . "/images/icon-campaign-d.gif' align='absmiddle'>&nbsp;";
		}
		if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
		    if (OA_Permission::hasPermission(OA_PERM_BANNER_ACTIVATE) || OA_Permission::hasPermission(OA_PERM_BANNER_EDIT)) {
        		echo "<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['campaignid']."'>".$campaigns[$ckey]['campaignname'];
		    } else {
		        echo $campaigns[$ckey]['campaignname'];
		    }
		} 
		else {
    		echo "<a href='campaign-edit.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['campaignid']."'>".$campaigns[$ckey]['campaignname'];
		}
		echo "</td>";

    // status
		if ($campaigns[$ckey]['status'] == OA_ENTITY_STATUS_PENDING) {
        	echo "<td class=\"sts sts-pending\">$strCampaignStatusPending</td>";
        } 
        elseif ($campaigns[$ckey]['status'] == OA_ENTITY_STATUS_RUNNING) {
        	echo "<td class=\"sts sts-accepted\">$strCampaignStatusRunning</td>";
        } 
        elseif ($campaigns[$ckey]['status'] == OA_ENTITY_STATUS_PAUSED) {
        	echo "<td class=\"sts sts-paused\">$strCampaignStatusPaused</td>";
        } 
        elseif ($campaigns[$ckey]['status'] == OA_ENTITY_STATUS_AWAITING) {
        	echo "<td class=\"sts sts-not-started\">$strCampaignStatusAwaiting</td>";
        } 
        elseif ($campaigns[$ckey]['status'] == OA_ENTITY_STATUS_EXPIRED) {
        	echo "<td class=\"sts sts-finished\">$strCampaignStatusExpired</td>";
        } 
        elseif ($campaigns[$ckey]['status'] == OA_ENTITY_STATUS_INACTIVE) {
            echo "<td class=\"sts sts-inactive\">$strCampaignStatusInactive</td>";
        }
        elseif ($campaigns[$ckey]['status'] == OA_ENTITY_STATUS_APPROVAL) {
        	echo "<td class=\"sts sts-awaiting\"><a href='campaign-edit.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['campaignid']."'>$strCampaignStatusApproval &raquo;</a></td>";
        } 
        elseif ($campaigns[$ckey]['status'] == OA_ENTITY_STATUS_REJECTED) {
            echo "<td class=\"sts sts-rejected\">$strCampaignStatusRejected</td>";
        }

            //echo "<td height='25'><span class='sts-awaiting'><a href='campaign-edit.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['campaignid']."'>Awaiting approval &raquo;</a></span></td>";

        //type
        echo '<td height="25">';
        if ($campaigns[$ckey]['type'] == OX_CAMPAIGN_TYPE_CONTRACT_NORMAL || $campaigns[$ckey]['type'] == OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE) {
            echo '<span class="campaign-type campaign-contract">'.$GLOBALS['strContract'].'</span>';
        }
        else { //OX_CAMPAIGN_TYPE_REMNANT
            echo '<span class="campaign-type campaign-remnant">'.$GLOBALS['strRemnant'].'</span>';
        }

        echo '</td>';
        // ID
		echo "<td height='25'>".$campaigns[$ckey]['campaignid']."</td>";

		// Button 1
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
		if (($campaigns[$ckey]['expand'] == '1' || !isset($campaigns[$ckey]['banners'])) && !OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER))
			echo "<img src='" . OX::assetPath() . "/images/icon-banner-new.gif' border='0' align='absmiddle' alt='$strCreate'>&nbsp;<a href='banner-edit.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['campaignid']."' title='$strAddBanner'>$strAddBanner</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		else
			echo "&nbsp;";
		echo "</td>";

		// Button 2
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
		echo "<img src='" . OX::assetPath() . "/images/icon-overview-light.gif' border='0' align='absmiddle' alt='$strBanners'>&nbsp;<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['campaignid']."' title='$strBanners'>$strBanners</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "</td>";

		// Button 3
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
		if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
    		echo "<img src='" . OX::assetPath() . "/images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;<a href='campaign-delete.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['campaignid']."&returnurl=advertiser-campaigns.php'".phpAds_DelConfirm($strConfirmDeleteCampaign).">$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		} else {
		    echo "&nbsp;";
		}
		echo "</td></tr>";


		if ($pref['ui_show_campaign_info']) {
            // Divider
            echo "<tr height='1' bgcolor='#f6f6f6'>";
            echo "<td></td>";
            echo "<td colspan='6' bgcolor='#bbbbbb'></td>";
            echo "</tr>";

			echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td>&nbsp;</td><td colspan='6'>";
			echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
			echo "<tr height='25'>";
			echo "<td width='20%'>".$strImpressionsBooked.":</td>";
			echo "<td width='20%' align='right'>".($campaigns[$ckey]['impressions'] >= 0 ? $campaigns[$ckey]['impressions'] : $strUnlimited)."</td>";
			echo "<td width='10%'>&nbsp;</td>";
			echo "<td width='20%'>".$strActivationDate.":</td>";
			echo "<td width='40%'>".$campaigns[$ckey]['activate']."</td>";
			echo "</tr>";
			echo "<tr height='15'>";
			echo "<td width='20%'>".$strClicksBooked.":</td>";
			echo "<td width='20%' align='right'>".($campaigns[$ckey]['clicks'] >= 0 ? $campaigns[$ckey]['clicks'] : $strUnlimited)."</td>";
			echo "<td width='10%'>&nbsp;</td>";
			echo "<td width='20%'>".$strExpirationDate.":</td>";
			echo "<td width='40%'>".$campaigns[$ckey]['expire']."</td>";
			echo "</tr>";
			echo "<tr height='25'>";
			// Conditionally display conversion tracking values
			if ($conf['logging']['trackerImpressions']) {
                echo "<td width='20%'>".$strConversionsBooked.":</td>";
                echo "<td width='20%' align='right'>".($campaigns[$ckey]['conversions'] >= 0 ? $campaigns[$ckey]['conversions'] : $strUnlimited)."</td>";
			} else {
                echo "<td width='20%'>&nbsp;</td>";
                echo "<td width='20%'>&nbsp;</td>";
			}
			echo "<td width='10%'>&nbsp;</td>";
			echo "<td width='20%'>".$strPriority.":</td>";
			echo "<td width='40%'>".$campaigns[$ckey]['priority']."</td>";
			echo "</tr>";
			echo "</table>";
			echo "<br /></td>";
			echo "</tr>";
		}
		echo "<tr class='break'><td colspan='7' ></td></tr>";

		$i++;
	}
}

echo "<tr height='25'><td colspan='3' height='25' nowrap>";

if ($hideinactive == true) {
	echo "&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-activate.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='advertiser-campaigns.php?clientid=".$clientid."&hideinactive=0'>".$strShowAll."</a>";
	echo "&nbsp;&nbsp;|&nbsp;&nbsp;".$campaignshidden." ".$strInactiveCampaignsHidden;
} 
else {
	echo "&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-hideinactivate.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='advertiser-campaigns.php?clientid=".$clientid."&hideinactive=1'>".$strHideInactiveCampaigns."</a>";
}
echo "</td>";

echo "<td colspan='4' height='25' align='".$phpAds_TextAlignRight."' nowrap>";
if (!empty($campaigns) && !OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
    echo "<img src='" . OX::assetPath() . "/images/icon-recycle.gif' border='0' align='absmiddle'>&nbsp;<a href='campaign-delete.php?clientid=".$clientid."&returnurl=advertiser-campaigns.php'".phpAds_DelConfirm($strConfirmDeleteAllCampaigns).">$strDeleteAllCampaigns</a>&nbsp;&nbsp;";
}
echo "</td>";
echo "</tr>";

echo "</table>";
echo "<br /><br />";

/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['advertiser-campaigns.php'][$clientid]['hideinactive'] = $hideinactive;
$session['prefs']['advertiser-campaigns.php'][$clientid]['listorder'] = $listorder;
$session['prefs']['advertiser-campaigns.php'][$clientid]['orderdirection'] = $orderdirection;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;

phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();


function buildHeaderModel($advertiserId, $aAllAdvertisers)
{
    if ($advertiserId) {
        $advertiser = phpAds_getClientDetails ($advertiserId);
        $advertiserName = $advertiser ['clientname'];
        $advertiserEditUrl = "advertiser-edit.php?clientid=$advertiserId";
    }
    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader(array(
        array ('name' => $advertiserName, 'url' => $advertiserEditUrl, 
               'id' => $advertiserId, 'entities' => $aAllAdvertisers,
               'htmlName' => 'clientid'
              ),
        array('name' => '')               
    ), 'campaigns', 'list');    
    
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
    //$doClients->addSessionListOrderBy('advertiser-index.php');
    $doClients->find();

    $aAdvertiserMap = array();
    while ($doClients->fetch() && $row = $doClients->toArray()) {
        $aAdvertiserMap[$row['clientid']] = array('name' => $row['clientname'],
            'url' => "advertiser-campaigns.php?clientid=".$row['clientid']);
    }

    return $aAdvertiserMap;
}


function addPageTools($clientid)
{
    if ($clientid > 0 && !OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {    
       addPageLinkTool($GLOBALS["strAddCampaign_Key"], "campaign-edit.php?clientid=$clientid", 'iconCampaignAdd', $GLOBALS["strAddNew"] );
    }
}




?>
