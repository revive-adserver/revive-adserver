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
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

// Register input variables
phpAds_registerGlobal('returnurl');


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);

// CVE-2013-5954 - see OA_Permission::checkSessionToken() method for details
OA_Permission::checkSessionToken();

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($trackerid)) {
    $ids = explode(',', $trackerid);
    foreach ($ids as $trackerid) {
        $doTrackers = OA_Dal::factoryDO('trackers');
        $doTrackers->trackerid = $trackerid;
        if ($doTrackers->find()) {
            // Clone the found DB_DataObject, as cannot delete() once
            // it has been fetch()ed
            $doTrackersClone = clone($doTrackers);
            // Fetch the tracker so that we can get the name of the
            // tracker for the delete message
            $doTrackers->fetch();
            $aTracker = $doTrackers->toArray();
            // Delete the cloned DB_DataObejct
            $doTrackersClone->delete();
        }
    }

    // Queue confirmation message
    $translation = new OX_Translation();

    if (count($ids) == 1) {
        $translated_message = $translation->translate($GLOBALS['strTrackerHasBeenDeleted'], [
            htmlspecialchars($aTracker['trackername'])
        ]);
    } else {
        $translated_message = $translation->translate($GLOBALS['strTrackersHaveBeenDeleted']);
    }

    OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
}

if (empty($returnurl)) {
    $returnurl = 'advertiser-trackers.php';
}

header("Location: " . $returnurl . "?clientid=" . $clientid);
