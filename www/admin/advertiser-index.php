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
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OX/Util/Utils.php';
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
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$sections = array("4.1", "4.2", "4.3");
if (OA_Permission::hasPermission(OA_PERM_SUPER_ACCOUNT)) {
    $sections[] = '4.4';
}
phpAds_PageHeader('4.1');
phpAds_ShowSections($sections);

/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($hideinactive)) {
    if (isset($session['prefs']['advertiser-index.php']['hideinactive'])) {
        $hideinactive = $session['prefs']['advertiser-index.php']['hideinactive'];
    } else {
	    $pref = &$GLOBALS['_MAX']['PREF'];
		$hideinactive = ($pref['ui_hide_inactive'] == true);
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
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    $clients = $dalClients->getAllAdvertisers($listorder, $orderdirection);
    $campaigns = $dalCampaigns->getAllCampaigns($listorder, $orderdirection);
    $banners = $dalBanners->getAllBanners($listorder, $orderdirection);
} elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    $agency_id = OA_Permission::getEntityId();
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
        //add artificial type attribute
        $campaign['type'] = OX_Util_Utils::getCampaignType($campaign['priority']);
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
$aCount = array(
    'advertisers'        => 0,
    'advertisers_hidden' => 0,
    'campaigns'          => 0,
    'banners'            => 0,
    'campaigns_active'   => 0,
    'banners_active'     => 0
);

foreach (array_keys($clients) as $clientid) {
    $client = &$clients[$clientid];

    $aCount['advertisers']++;
    if (isset($client['campaigns'])) {
        foreach (array_keys($client['campaigns']) as $campaignid) {
            $campaign = &$client['campaigns'][$campaignid];
            $aCount['campaigns']++;
            foreach (array_keys($campaign['banners']) as $bannerid) {
                $banner = &$campaign['banners'][$bannerid];
    
                $aCount['banners']++;
                if ($hideinactive && $banner['status'] != OA_ENTITY_STATUS_RUNNING) {
                    unset($campaign['banners'][$bannerid]);
                } else {
                    $aCount['banners_active']++;
                }
            }
    
            if ($hideinactive && ($campaign['status'] != OA_ENTITY_STATUS_RUNNING || !count($campaign['banners']))) {
                $aCount['banners_active'] -= count($campaign['banners']);
                unset($client['campaigns'][$campaignid]);
                $aCount['an_hidden']++;
            } else {
                $aCount['campaigns_active']++;
            }
        }
    }

    if ($hideinactive && !count($client['campaigns'])) {
        unset($clients[$clientid]);
        $aCount['advertisers_hidden']++;
    } elseif ($isOac) {
        unset($clients[$clientid]);
        $aOacAdvertisers[$clientid] = $client;
    }

}

$oTpl->assign('aAdvertisers', $clients);
$oTpl->assign('aCount', $aCount);
$oTpl->assign('showAdDirect', true); // Always true OX-3481

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

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();
?>
