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
$Id: advertiser-campaigns.php 26814 2008-10-03 12:34:51Z rakaz $
*/

// Require the initialisation file
require_once '../../init.php';
require_once MAX_PATH . '/lib/OX/Util/Utils.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/OA/Permission.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);


$aEntityMap = array();

if (!empty($clientid)) {
    if (!OA_Permission::hasAccessToObject('clients', $clientid)) {
        echo "{ }";
        exit;
    }
  
    // Retrieve list of campaigns
    $aCampaigns = Admin_DA::getPlacements(array('advertiser_id' => $clientid));
    foreach ($aCampaigns as $campaignId => $aCampaign) {
        $campaignName = $aCampaign['name'];
        // mask campaign name if anonymous campaign
        $campaign_details = Admin_DA::getPlacement($campaignId);
        $campaignName = MAX_getPlacementName($campaign_details);
        $aEntityMap[$campaignId] = $campaignName;
    }
}
 
  
  
if (count($aEntityMap)) {
    while (list($k,$v) = each($aEntityMap)) {
        $aEntityMap[$k] = $k . ': { "name": "' . addslashes($v) . '" }';
    }
    
    echo "{" . implode(', ', $aEntityMap) . "}";
    exit;
}

echo "{ }";

?>
