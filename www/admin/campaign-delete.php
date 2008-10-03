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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';

// Register input variables
phpAds_registerGlobal ('returnurl');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients',   $clientid);


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($campaignid)) {
    $ids = explode(',', $campaignid);
    while (list(,$campaignid) = each($ids)) {

        // Security check
        OA_Permission::enforceAccessToObject('campaigns', $campaignid);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignid = $campaignid;
        if ($doCampaigns->get($campaignid)) {
            $aCampaign = $doCampaigns->toArray();
        }

        $doCampaigns->delete();
    }

    // Queue confirmation message
    $translation = new OX_Translation ();

    if (count($ids) == 1) {
        $translated_message = $translation->translate ($GLOBALS['strCampaignHasBeenDeleted'], array(
            htmlspecialchars($aCampaign['campaignname'])
        ));
    } else {
        $translated_message = $translation->translate ($GLOBALS['strCampaignsHaveBeenDeleted']);
    }

    OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
}

// Run the Maintenance Priority Engine process
OA_Maintenance_Priority::scheduleRun();

// Rebuild cache
// include_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
// phpAds_cacheDelete();


/*-------------------------------------------------------*/
/* Return to the index page                              */
/*-------------------------------------------------------*/

if (empty($returnurl)) {
    $returnurl = 'advertiser-campaigns.php';
}

header ("Location: ".$returnurl."?clientid=".$clientid);

?>
