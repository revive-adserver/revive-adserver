<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

// Register input variables
phpAds_registerGlobal ('returnurl');


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($trackerid)) {
    $ids = explode(',', $trackerid);
    while (list(,$trackerid) = each($ids)) {

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
    $translation = new OX_Translation ();

    if (count($ids) == 1) {
        $translated_message = $translation->translate ($GLOBALS['strTrackerHasBeenDeleted'], array(
            htmlspecialchars($aTracker['trackername'])
        ));
    } else {
        $translated_message = $translation->translate ($GLOBALS['strTrackersHaveBeenDeleted']);
    }

    OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
}

if (empty($returnurl)) {
	$returnurl = 'advertiser-trackers.php';
}

header ("Location: ".$returnurl."?clientid=".$clientid);

?>