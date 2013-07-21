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
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
include_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/other/common.php';

// Register input variables
phpAds_registerGlobal ('campaignid', 'clientid', 'newclientid', 'returnurl', 'duplicate');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);

if(!empty($duplicate)) {
    OA_Permission::enforceAccessToObject('clients',   $clientid, false, OA_Permission::OPERATION_VIEW);
    OA_Permission::enforceAccessToObject('campaigns', $campaignid, false, OA_Permission::OPERATION_DUPLICATE);
}
else if (!empty($newclientid)) {
    OA_Permission::enforceAccessToObject('clients',   $clientid, false, OA_Permission::OPERATION_VIEW);
    OA_Permission::enforceAccessToObject('campaigns', $campaignid, false, OA_Permission::OPERATION_MOVE);
    OA_Permission::enforceAccessToObject('clients', $newclientid, false, OA_Permission::OPERATION_EDIT);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($campaignid)) {
    if (!empty($duplicate)) {
    	// Duplicate the campaign
    	$doCampaigns = OA_Dal::factoryDO('campaigns');
    	$doCampaigns->get($campaignid);
        $oldName = $doCampaigns->campaignname;
    	$newCampaignId = $doCampaigns->duplicate();

        if ($newCampaignId) {
            // Queue confirmation message
            $newName = $doCampaigns->campaignname;
            $translation = new OX_Translation();
            $translated_message = $translation->translate ( $GLOBALS['strCampaignHasBeenDuplicated'],
                array(MAX::constructURL(MAX_URL_ADMIN, "campaign-edit.php?clientid=$clientid&campaignid=$campaignid"),
                    htmlspecialchars($oldName),
                    MAX::constructURL(MAX_URL_ADMIN, "campaign-edit.php?clientid=$clientid&campaignid=$newCampaignId"),
                    htmlspecialchars($newName))
            );
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

            Header ("Location: {$returnurl}?clientid={$clientid}&campaignid={$newCampaignId}");
            exit;
        }
        else {
            phpAds_sqlDie();
        }

    }
    else if (!empty($newclientid)) {

        /*-------------------------------------------------------*/
        /* Restore cache of $node_array, if it exists            */
        /*-------------------------------------------------------*/

        if (isset($session['prefs']['advertiser-index.php']['nodes'])) {
            $node_array = $session['prefs']['advertiser-index.php']['nodes'];
        }

        /*-------------------------------------------------------*/

        // Delete any campaign-tracker links
        $doCampaign_trackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaign_trackers->campaignid = $campaignid;
        $doCampaign_trackers->delete();

        // Move the campaign
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->get($campaignid);
        $doCampaigns->clientid = $newclientid;
        $doCampaigns->update();

        // Find and delete the campains from $node_array, if
        // necessary. (Later, it would be better to have
        // links to this file pass in the clientid as well,
        // to facilitate the process below.
        if (isset($node_array['clients'])) {
            foreach ($node_array['clients'] as $key => $val) {
                if (isset($node_array['clients'][$key]['campaigns'])) {
                    unset($node_array['clients'][$key]['campaigns'][$campaignid]);
                }
            }
        }

        // Rebuild cache
        // require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
        // phpAds_cacheDelete();

        /*-------------------------------------------------------*/
        /* Save the $node_array, if necessary                    */
        /*-------------------------------------------------------*/

        if (isset($node_array)) {
            $session['prefs']['advertiser-index.php']['nodes'] = $node_array;
            phpAds_SessionDataStore();
        }

        /*-------------------------------------------------------*/

        // Queue confirmation message
        $campaignName = $doCampaigns->campaignname;
        $doClients = OA_Dal::factoryDO('clients');
        if ($doClients->get($newclientid)) {
            $advertiserName = $doClients->clientname;
        }
        $translation = new OX_Translation();
        $translated_message = $translation->translate ( $GLOBALS['strCampaignHasBeenMoved'],
            array(htmlspecialchars($campaignName), htmlspecialchars($advertiserName))
        );
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);


    }
}

Header ("Location: ".$returnurl."?clientid=".(isset($newclientid) ? $newclientid : $clientid)."&campaignid=".$campaignid);

?>
