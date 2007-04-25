<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

function _isBannerAssignedToCampaign($aBannerData)
{
    return $aBannerData['campaignid'] > 0;
}

// Register input variables
phpAds_registerGlobal('expand', 'collapse', 'hideinactive', 'listorder',
                      'orderdirection');

// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("4.1");
phpAds_ShowSections(array("4.1", "4.2", "4.3"));

/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($hideinactive)) {
    if (isset($session['prefs']['advertiser-index.php']['hideinactive'])) {
        $hideinactive = $session['prefs']['advertiser-index.php']['hideinactive'];
    } else {
	    $pref = &$GLOBALS['_MAX']['PREF'];
		$hideinactive = ($pref['gui_hide_inactive'] == 't');
    }
}

if (!isset($listorder)) {
    if (isset($session['prefs']['advertiser-index.php']['listorder'])) {
        $listorder = $session['prefs']['advertiser-index.php']['listorder'];
    } else {
        $listorder = '';
    }
}

if (!isset($orderdirection)) {
    if (isset($session['prefs']['advertiser-index.php']['orderdirection'])) {
        $orderdirection = $session['prefs']['advertiser-index.php']['orderdirection'];
    } else {
        $orderdirection = '';
    }
}

$node_array = array();
if (isset($session['prefs']['advertiser-index.php']['nodes'])) {
    $node_array = $session['prefs']['advertiser-index.php']['nodes'];
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Get clients & campaigns and build the tree
// XXX: Now that the two are next to each other, some silliness
//      is quite visible -- retrieving all items /then/ retrieving a count.
// TODO: This looks like a perfect candidate for object "polymorphism"
$dalClients = OA_Dal::factoryDAL('clients');
$dalCampaigns = OA_Dal::factoryDAL('campaigns');
$dalBanners = OA_Dal::factoryDAL('banners');
if (phpAds_isUser(phpAds_Admin)) {
    $clients = $dalClients->getAllAdvertisers($listorder, $orderdirection);
    $campaigns = $dalCampaigns->getAllCampaigns($listorder, $orderdirection);
    $banners = $dalBanners->getAllBanners($listorder, $orderdirection);

    $number_of_active_campaigns = $dalCampaigns->countActiveCampaigns();
    $number_of_active_banners = $dalBanners->countActiveBanners();
} elseif (phpAds_isUser(phpAds_Agency)) {
    $agency_id = phpAds_getUserID();
    $clients = $dalClients->getAllAdvertisersForAgency($agency_id, $listorder, $orderdirection);
    $campaigns = $dalCampaigns->getAllCampaignsUnderAgency($agency_id, $listorder, $orderdirection);
    $banners = $dalBanners->getAllBannersUnderAgency($agency_id, $listorder, $orderdirection);

    $number_of_active_campaigns =  $dalCampaigns->countActiveCampaignsUnderAgency($agency_id);
    $number_of_active_banners = $dalBanners->countActiveBannersUnderAgency($agency_id);
}
    $number_of_clients = count($clients);
    $number_of_campaigns = count($campaigns);
    $number_of_banners = count($banners);

// Build Tree
$clientshidden = 0;

if (!empty($banners)) {
    // Add banner to campaigns
    foreach ($banners as $bkey => $banner) {
        if (($hideinactive == false || $banner['active'] == 't') && _isBannerAssignedToCampaign($banner)) {
            $campaigns[$banner['campaignid']]['banners'][$bkey] = $banner;
        }
    }
    unset ($banners);
}

if (!empty($campaigns)) {
    foreach ($campaigns as $ckey => $campaign) {
        if (!isset($campaign['banners'])) {
            $campaign['banners'] = array();
        }
        if ($hideinactive == false || ($campaign['active'] == 't' &&  !empty($campaign['banners']))) {
            $clients[$campaign['clientid']]['campaigns'][$ckey] = $campaign;
        }
    }
    unset ($campaigns);
}

if (!empty($clients)) {
    foreach ($clients as $key => $client) {
        if (!isset($client['campaigns'])) {
            $client['campaigns'] = array();
        }
        if ($hideinactive && empty($client['campaigns'])) {
            $clientshidden++;
            unset($clients[$key]);
        }
    }
}

// Add ID found in expand to expanded nodes
if (!empty($expand)) {
    switch ($expand) {
        case 'all':
       	if(is_array($clients)) {
        	foreach($clients as $key=>$client) {
        	    $node_array['clients'][$key]['expand'] = TRUE;
    	        if(is_array($client['campaigns'])) {
	            	foreach($client['campaigns'] as $ckey=>$campaign) {
                		$node_array['clients'][$key]['campaigns'][$ckey]['expand'] = TRUE;
            		}
            	}
        	}
        }
        break;

        case 'none':
        if(is_array($clients)) {
        	foreach($clients as $key=>$client) {
            	$node_array['clients'][$key]['expand'] = FALSE;
            	if(is_array($client['campaigns'])) {
            		foreach($client['campaigns'] as $ckey=>$campaign) {
                		$node_array['clients'][$key]['campaigns'][$ckey]['expand'] = FALSE;
            		}
            	}
        	}
        }
        break;

        default:
        if (preg_match("/client:([0-9]*)/i", $expand, $result)) {
            $node_array['clients'][$result[1]]['expand'] = TRUE;
        } else if (preg_match("/campaign:([0-9]*)-([0-9]*)/i", $expand, $result)) {
            $node_array['clients'][$result[1]]['campaigns'][$result[2]]['expand'] = TRUE;
        }
        break;
    }
} else if (isset($collapse) && $collapse != '') {
    if (preg_match("/client:([0-9]*)/i", $collapse, $result)) {
        $node_array['clients'][$result[1]]['expand'] = FALSE;
    } else if (preg_match("/campaign:([0-9]*)-([0-9]*)/i", $collapse, $result)) {
        $node_array['clients'][$result[1]]['campaigns'][$result[2]]['expand'] = FALSE;
    }

}

if (isset($node_array['clients'])) {
    foreach($node_array['clients'] as $cid=>$client) {
        if (!empty($clients[$cid])) {
            $clients[$cid]['expand'] = (!empty($client['expand']) ? TRUE : FALSE);
            if(!empty($client['campaigns'])) {
                foreach($client['campaigns'] as $campaignid=>$campaign) {
                    $clients[$cid]['campaigns'][$campaignid]['expand'] = (!empty($campaign['expand']) ? TRUE : FALSE);
                }
            }
        }
    }
}

echo "\t\t\t\t<img src='images/icon-advertiser-new.gif' border='0' align='absmiddle'>&nbsp;\n";
echo "\t\t\t\t<a href='advertiser-edit.php' accesskey='".$keyAddNew."'>".$strAddClient_Key."</a>&nbsp;&nbsp;\n";
phpAds_ShowBreak();

echo "\t\t\t\t<br /><br />\n";
echo "\t\t\t\t<table border='0' width='100%' cellpadding='0' cellspacing='0'>\n";

echo "\t\t\t\t<tr height='25'>\n";
echo "\t\t\t\t\t<td height='25' width='40%'>\n";
echo "\t\t\t\t\t\t<b>&nbsp;&nbsp;<a href='advertiser-index.php?listorder=name'>".$GLOBALS['strName']."</a>";

if (($listorder == "name") || ($listorder == "")) {
    if  (($orderdirection == "") || ($orderdirection == "down")) {
        echo " <a href='advertiser-index.php?orderdirection=up'>";
        echo "<img src='images/caret-ds.gif' border='0' alt='' title=''>";
    } else {
        echo " <a href='advertiser-index.php?orderdirection=down'>";
        echo "<img src='images/caret-u.gif' border='0' alt='' title=''>";
    }
    echo "</a>";
}

echo "</b>\n";
echo "\t\t\t\t\t</td>\n";
echo "\t\t\t\t\t<td height='25'>\n";
echo "\t\t\t\t\t\t<b><a href='advertiser-index.php?listorder=id'>".$GLOBALS['strID']."</a>";

if ($listorder == "id") {
    if  (($orderdirection == "") || ($orderdirection == "down")) {
        echo " <a href='advertiser-index.php?orderdirection=up'>";
        echo "<img src='images/caret-ds.gif' border='0' alt='' title=''>";
    } else {
        echo " <a href='advertiser-index.php?orderdirection=down'>";
        echo "<img src='images/caret-u.gif' border='0' alt='' title=''>";
    }
    echo "</a>";
}

echo "</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
echo "\t\t\t\t\t</td>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;</td>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;</td>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;</td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr height='1'>\n";
echo "\t\t\t\t\t<td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";


if (empty($clients)) {
    echo "\t\t\t\t<tr height='25' bgcolor='#F6F6F6'>\n";
    echo "\t\t\t\t\t<td height='25' colspan='5'>&nbsp;&nbsp;".$strNoClients."</td>\n";
    echo "\t\t\t\t</tr>\n";

    echo "\t\t\t\t<tr>\n";
    echo "\t\t\t\t\t<td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>\n";
    echo "\t\t\t\t<tr>\n";
} else {
    $i=0;
    foreach ($clients as $clientId => $client) {
        echo "\t\t\t\t<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">\n";

        // Icon & name
        echo "\t\t\t\t\t<td height='25'>\n";
        if (!empty($client['campaigns'])) {
            if (!empty($client['expand'])) {
                echo "\t\t\t\t\t\t<a href='advertiser-index.php?collapse=client:{$clientId}'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>\n";
            } else {
                echo "\t\t\t\t\t\t<a href='advertiser-index.php?expand=client:{$clientId}'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>\n";
            }
        } else {
            echo "\t\t\t\t\t\t<img src='images/spacer.gif' height='16' width='16' align='absmiddle'>\n";
        }

        echo "\t\t\t\t\t\t<img src='images/icon-advertiser.gif' align='absmiddle'>\n";
        echo "\t\t\t\t\t\t<a href='advertiser-edit.php?clientid={$clientId}'>".$client['clientname']."</a>\n";
        echo "\t\t\t\t\t</td>\n";

        // ID
        echo "\t\t\t\t\t<td height='25'>{$clientId}</td>\n";

        // Button 1
        echo "\t\t\t\t\t<td height='25'>";
        if ( !empty($client['expand']) && empty($client['campaigns'])) {
            echo "<a href='campaign-edit.php?clientid={$clientId}'><img src='images/icon-campaign-new.gif' border='0' align='absmiddle' alt='$strCreate'>&nbsp;$strCreate</a>&nbsp;&nbsp;&nbsp;&nbsp;";
        } else {
            echo "&nbsp;";
        }
        echo "</td>\n";

        // Button 2
        echo "\t\t\t\t\t<td height='25'>";
        echo "<a href='advertiser-campaigns.php?clientid={$clientId}'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='$strOverview'>&nbsp;$strOverview</a>&nbsp;&nbsp;";
        echo "</td>\n";

        // Button 3
        echo "\t\t\t\t\t<td height='25'>";
        echo "<a href='advertiser-delete.php?clientid={$clientId}&returnurl=advertiser-index.php'".phpAds_DelConfirm($strConfirmDeleteClient)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "</td>\n";

        echo "\t\t\t\t</tr>\n";

        if (!empty($client['campaigns']) && !empty($client['expand'])) {
            $campaigns = $client['campaigns'];
            foreach ($campaigns as $campaignId => $campaign) {
                // Divider
                echo "\t\t\t\t<tr height='1'>\n";
                echo "\t\t\t\t\t<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>\n";
                echo "\t\t\t\t\t<td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>\n";
                echo "\t\t\t\t</tr>\n";

                // Icon & name
                echo "\t\t\t\t<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">\n";
                echo "\t\t\t\t\t<td height='25'>\n";
                echo "\t\t\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";

                if (!empty($campaign['banners'])) {
                    if (!empty($campaign['expand'])) {
                        echo "\t\t\t\t\t\t<a href='advertiser-index.php?collapse=campaign:{$clientId}-{$campaignId}'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>\n";
                    } else {
                        echo "\t\t\t\t\t\t<a href='advertiser-index.php?expand=campaign:{$clientId}-{$campaignId}'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>\n";
                    }
                } else {
                    echo "\t\t\t\t\t\t<img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;\n";
                }

                if ($campaign['active'] == 't') {
                    echo "\t\t\t\t\t\t<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;\n";
                } else {
                    echo "\t\t\t\t\t\t<img src='images/icon-campaign-d.gif' align='absmiddle'>&nbsp;\n";
                }

                echo "\t\t\t\t\t\t<a href='campaign-edit.php?clientid={$clientId}&campaignid={$campaignId}'>".$campaign['campaignname']."</td>\n";
                echo "\t\t\t\t\t</td>\n";

                // ID
                echo "\t\t\t\t\t<td height='25'>{$campaignId}</td>\n";

                // Button 1
                echo "\t\t\t\t\t<td height='25'>";
                if (empty($campaign['banners'])) {
                    echo "<a href='banner-edit.php?clientid={$clientId}&campaignid={$campaignId}'><img src='images/icon-banner-new.gif' border='0' align='absmiddle' alt='$strCreate'>&nbsp;$strCreate</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                } else {
                    echo "&nbsp;";
                }
                echo "</td>\n";

                // Button 2
                echo "\t\t\t\t\t<td height='25'>";
                echo "<a href='campaign-banners.php?clientid={$clientId}&campaignid={$campaignId}'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='$strOverview'>&nbsp;$strOverview</a>&nbsp;&nbsp;";
                echo "</td>\n";

                // Button 3
                echo "\t\t\t\t\t<td height='25'>";
                echo "<a href='campaign-delete.php?clientid={$clientId}&campaignid={$campaignId}&returnurl=advertiser-index.php'".phpAds_DelConfirm($strConfirmDeleteCampaign)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                echo "</td>\n";
                echo "\t\t\t\t</tr>\n";


                if (!empty($campaign['expand']) && !empty($campaign['banners'])) {
                    $banners = $campaign['banners'];
                    foreach($banners as $bannerId => $banner) {
                        $name = $strUntitled;
                        if (!empty($banner['alt'])) {
                            $name = $banner['alt'];
                        }
                        if (!empty($banner['description'])) {
                            $name = $banner['description'];
                        }

                        $name = phpAds_breakString ($name, '30');

                        // Divider
                        echo "\t\t\t\t<tr height='1'>\n";
                        echo "\t\t\t\t\t<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>\n";
                        echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>\n";
                        echo "\t\t\t\t</tr>\n";

                        // Icon & name
                        echo "\t\t\t\t<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">\n";
                        echo "\t\t\t\t\t<td height='25'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

                        if ($banner['active'] == 't' && $campaign['active'] == 't') {
                            if ($banner['type'] == 'html') {
                                echo "<img src='images/icon-banner-html.gif' align='absmiddle'>";
                            } elseif ($banner['type'] == 'txt') {
                                echo "<img src='images/icon-banner-text.gif' align='absmiddle'>";
                            } elseif ($banner['type'] == 'url') {
                                echo "<img src='images/icon-banner-url.gif' align='absmiddle'>";
                            } else {
                                echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>";
                            }
                        } else {
                            if ($banner['type'] == 'html') {
                                echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>";
                            } elseif ($banner['type'] == 'txt') {
                                echo "<img src='images/icon-banner-text-d.gif' align='absmiddle'>";
                            } elseif ($banner['type'] == 'url') {
                                echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>";
                            } else {
                                echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>";
                            }
                        }

                        echo "&nbsp;<a href='banner-edit.php?clientid={$clientId}&campaignid={$campaignId}&bannerid={$bannerId}'>".$name."</a></td>\n";

                        // ID
                        echo "\t\t\t\t\t<td height='25'>{$bannerId}</td>\n";

                        // Empty
                        echo "\t\t\t\t\t<td>&nbsp;</td>\n";

                        // Button 2
                        echo "\t\t\t\t\t<td height='25'>";
                        echo "<a href='banner-acl.php?clientid={$clientId}&campaignid={$campaignId}&bannerid={$bannerId}'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo "</td>\n";

                        // Button 1
                        echo "\t\t\t\t\t<td height='25'>";
                        echo "<a href='banner-delete.php?clientid={$clientId}&campaignid={$campaignId}&bannerid={$bannerId}&returnurl=advertiser-index.php'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo "</td>\n";
                        echo "\t\t\t\t</tr>\n";
                    }
                }
            }
        }
        echo "\t\t\t\t<tr height='1'>\n";
        echo "\t\t\t\t\t<td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>\n";
        echo "\t\t\t\t</tr>\n";
        $i++;
    }
}

echo "\t\t\t\t<tr>\n";
echo "\t\t\t\t\t<td height='25' colspan='3' align='".$phpAds_TextAlignLeft."' nowrap>";

if ($hideinactive == true) {
    echo "&nbsp;&nbsp;<img src='images/icon-activate.gif' align='absmiddle' border='0'>";
    echo "&nbsp;<a href='advertiser-index.php?hideinactive=0'>".$strShowAll."</a>";
    echo "&nbsp;&nbsp;|&nbsp;&nbsp;".$clientshidden." ".$strInactiveAdvertisersHidden;
} else {
    echo "&nbsp;&nbsp;<img src='images/icon-hideinactivate.gif' align='absmiddle' border='0'>";
    echo "&nbsp;<a href='advertiser-index.php?hideinactive=1'>".$strHideInactiveAdvertisers."</a>";
}

echo "</td>\n";
echo "\t\t\t\t\t<td height='25' colspan='2' align='".$phpAds_TextAlignRight."' nowrap>";
echo "<img src='images/triangle-d.gif' align='absmiddle' border='0'>";
echo "&nbsp;<a href='advertiser-index.php?expand=all' accesskey='".$keyExpandAll."'>".$strExpandAll."</a>";
echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
echo "<img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'>";
echo "&nbsp;<a href='advertiser-index.php?expand=none' accesskey='".$keyCollapseAll."'>".$strCollapseAll."</a>&nbsp;&nbsp;";
echo "</td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t</table>\n";

echo "\t\t\t\t<br /><br /><br /><br />\n";
echo "\t\t\t\t<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>\n";
echo "\t\t\t\t<tr>\n";
echo "\t\t\t\t\t<td height='25' colspan='3'>&nbsp;&nbsp;<b>".$strOverall."</b></td>\n";
echo "\t\t\t\t</tr>\n";
echo "\t\t\t\t<tr height='1'>\n";
echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;&nbsp;".$strTotalBanners.": <b>".$number_of_banners."</b></td>\n";
echo "\t\t\t\t\t<td height='25'>".$strTotalCampaigns.": <b>".$number_of_campaigns."</b></td>\n";
echo "\t\t\t\t\t<td height='25'>".$strTotalClients.": <b>".$number_of_clients."</b></td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr height='1'>\n";
echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;&nbsp;".$strActiveBanners.": <b>".$number_of_active_banners."</b></td>\n";
echo "\t\t\t\t\t<td height='25'>".$strActiveCampaigns.": <b>".$number_of_active_campaigns."</b></td>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;</td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr height='1'>\n";
echo "\t\t\t\t\t<td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t</table>\n";
echo "\t\t\t\t<br /><br />\n";

/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['advertiser-index.php']['hideinactive'] = $hideinactive;
$session['prefs']['advertiser-index.php']['listorder'] = $listorder;
$session['prefs']['advertiser-index.php']['orderdirection'] = $orderdirection;
$session['prefs']['advertiser-index.php']['nodes'] = $node_array;
phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>