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

// Register input variables
phpAds_registerGlobal(
    'duplicate',
    'moveto',
    'returnurl'
);


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('trackers', $trackerid);

// CVE-2013-5954 - see OA_Permission::checkSessionToken() method for details
OA_Permission::checkSessionToken();

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($trackerid)) {
    if (!empty($moveto)) {
        // Delete any campaign-tracker links
        $doCampaign_trackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaign_trackers->trackerid = $trackerid;
        $doCampaign_trackers->delete();

        // Move the tracker
        $doTrackers = OA_Dal::factoryDO('trackers');
        if ($doTrackers->get($trackerid)) {
            $doTrackers->clientid = $moveto;
            $doTrackers->update();

            // Queue confirmation message
            $trackerName = $doTrackers->trackername;
            $doClients = OA_Dal::factoryDO('clients');
            if ($doClients->get($moveto)) {
                $advertiserName = $doClients->clientname;
            }
            $translation = new OX_Translation();
            $translated_message = $translation->translate(
                $GLOBALS['strTrackerHasBeenMoved'],
                [htmlspecialchars($trackerName), htmlspecialchars($advertiserName)]
            );
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        }

        Header("Location: " . $returnurl . "?clientid=" . $moveto . "&trackerid=" . $trackerid);
        exit;
    } elseif (isset($duplicate) && $duplicate == 'true') {
        $doTrackers = OA_Dal::factoryDO('trackers');
        if ($doTrackers->get($trackerid)) {
            $oldName = $doTrackers->trackername;
            $new_trackerid = $doTrackers->duplicate();

            if ($doTrackers->get($new_trackerid)) {
                $newName = $doTrackers->trackername;
            }

            // Queue confirmation message
            $translation = new OX_Translation();
            $translated_message = $translation->translate(
                $GLOBALS['strTrackerHasBeenDuplicated'],
                [MAX::constructURL(MAX_URL_ADMIN, "tracker-edit.php?clientid=$clientid&trackerid=$trackerid"),
                    htmlspecialchars($oldName),
                    MAX::constructURL(MAX_URL_ADMIN, "tracker-edit.php?clientid=$clientid&trackerid=$new_trackerid"),
                    htmlspecialchars($newName)]
            );
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);


            Header("Location: " . $returnurl . "?clientid=" . $clientid . "&trackerid=" . $new_trackerid);
            exit;
        }
    }
}

Header("Location: " . $returnurl . "?clientid=" . $clientid . "&trackerid=" . $trackerid);
