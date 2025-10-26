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
require_once MAX_PATH . '/lib/OX/Util/Utils.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/OA/Permission.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);

$aEntityMap = [];
$idx = 0;

if (!empty($clientid)) {
    if (!OA_Permission::hasAccessToObject('clients', $clientid)) {
        echo "{ }";
        exit;
    }

    // Retrieve list of campaigns
    $dalCampaigns = OA_Dal::factoryDAL('campaigns');
    $aCampaigns = $dalCampaigns->getClientCampaigns($clientid);

    foreach ($aCampaigns as $campaignId => $aCampaign) {
        $campaignName = $aCampaign['name'];
        $aEntityMap[$campaignId] = [
            'name' => $campaignName,
            'idx' => $idx++,
        ];
    }
}

MAX_header('Content-Type: application/json');

echo json_encode($aEntityMap, JSON_FORCE_OBJECT);
