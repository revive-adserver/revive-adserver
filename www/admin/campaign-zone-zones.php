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
require_once MAX_PATH . '/www/admin/config.php';

phpAds_registerGlobalUnslashed('status');

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('campaigns', $campaignid);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Send header with charset info
header("Content-Type: text/html" . (isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=" . $phpAds_CharSet : ""));

require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/CampaignZoneLink.php';

$oTpl = OA_Admin_UI_CampaignZoneLink::createTemplateWithModel($status);
$oTpl->display();
?>

