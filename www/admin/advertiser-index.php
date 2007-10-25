<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';

function _isBannerAssignedToCampaign($aBannerData)
{
    return $aBannerData['campaignid'] > 0;
}

// Register input variables
phpAds_registerGlobal('expand', 'collapse', 'hideinactive', 'listorder',
                      'orderdirection');

// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency);

// Initialise Ad  Networks
$oAdNetworks = new OA_Central_AdNetworks();

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

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('advertiser-index.html');


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
} elseif (phpAds_isUser(phpAds_Agency)) {
    $agency_id = phpAds_getUserID();
    $clients = $dalClients->getAllAdvertisersForAgency($agency_id, $listorder, $orderdirection);
    $campaigns = $dalCampaigns->getAllCampaignsUnderAgency($agency_id, $listorder, $orderdirection);
    $banners = $dalBanners->getAllBannersUnderAgency($agency_id, $listorder, $orderdirection);
}


// Build Tree
$clientshidden = 0;

if (!empty($banners)) {
    // Add banner to campaigns
    foreach ($banners as $bkey => $banner) {
        $name = $strUntitled;
        if (!empty($banner['alt'])) {
            $name = $banner['alt'];
        }
        if (!empty($banner['description'])) {
            $name = $banner['description'];
        }
        $banner['name'] = phpAds_breakString ($name, '30');

        if (_isBannerAssignedToCampaign($banner)) {
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
        $clients[$campaign['clientid']]['campaigns'][$ckey] = $campaign;
    }
    unset ($campaigns);
}

if (!empty($clients)) {
    foreach ($clients as $key => $client) {
        if (!isset($client['campaigns'])) {
            $client['campaigns'] = array();
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

$aOacAdvertisers = array();
$aCounts = array();
for ($i = 0; $i < 3; $i++) {
    foreach (array('advertisers', 'advertisers_hidden', 'campaigns', 'banners', 'campaigns_active', 'banners_active') as $v) {
        $aCount[$i][$v] = 0;
    }
}
foreach (array_keys($clients) as $clientid) {
    $client = &$clients[$clientid];

    $isOac = empty($client['oac_adnetwork_id']) ? 0 : 1;

    $aCount[$isOac]['advertisers']++;
    foreach (array_keys($client['campaigns']) as $campaignid) {
        $campaign = &$client['campaigns'][$campaignid];

        $aCount[$isOac]['campaigns']++;
        foreach (array_keys($campaign['banners']) as $bannerid) {
            $banner = &$campaign['banners'][$bannerid];

            $aCount[$isOac]['banners']++;
            if ($hideinactive && $banner['active'] != 't') {
                unset($campaign['banners'][$bannerid]);
            } else {
                $aCount[$isOac]['banners_active']++;
            }
        }

        if ($hideinactive && ($campaign['active'] != 't' || !count($campaign['banners']))) {
            $aCount[$isOac]['banners_active'] -= count($campaign['banners']);
            unset($client['campaigns'][$campaignid]);
        } else {
            $aCount[$isOac]['campaigns_active']++;
        }
    }

    if ($hideinactive && !count($client['campaigns'])) {
        unset($clients[$clientid]);
        $aCount[$isOac]['advertisers_hidden']++;
    } elseif ($isOac) {
        unset($clients[$clientid]);
        $aOacAdvertisers[$clientid] = $client;
    }

}

foreach (array_keys($aCount[2]) as $k) {
    $aCount[2][$k] = $aCount[0][$k] + $aCount[1][$k];
}

$aCount = array(
    'Openads' => $aCount[1],
    'Local'   => $aCount[0],
    'Total'   => $aCount[2]
);

$oTpl->assign('aOacAdvertisers', $aOacAdvertisers);
$oTpl->assign('aOapAdvertisers', $clients);
$oTpl->assign('aCount', $aCount);

if (MAX_Admin_Preferences::checkBool('updates_enabled', true)) {
    $oTpl->assign('aCountries',     $oAdNetworks->getCountriesSelect());
    $oTpl->assign('aLanguages',     $oAdNetworks->getLanguagesSelect());
    $oTpl->assign('aOtherNetworks', $oAdNetworks->getOtherNetworksForDisplay());
}

$oTpl->assign('hideinactive', $hideinactive);
$oTpl->assign('listorder', $listorder);
$oTpl->assign('orderdirection', $orderdirection);

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

$oTpl->display();

?>

<script language='JavaScript'>
<!--
    max_formSetRequirements('on-country', '<?php echo addslashes($strCountry); ?>', true, 'present');
    max_formSetRequirements('on-language', '<?php echo addslashes($strLanguage); ?>', true, 'present');
    max_formSetRequirements('on-name', '<?php echo addslashes($strName); ?>', true, 'present');
    max_formSetRequirements('on-url', 'Adnetwork URL', true, 'url');
//-->
</script>

<?php

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();
?>