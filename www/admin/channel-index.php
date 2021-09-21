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
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobal('acl', 'action', 'submit');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);


// Initialise some parameters
$pageName = basename($_SERVER['SCRIPT_NAME']);
$agencyId = OA_Permission::getEntityId();
$tabindex = 1;

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.7");


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

echo "<img src='" . OX::assetPath() . "/images/icon-channel-add.gif' border='0' align='absmiddle'>&nbsp;";
echo "<a href='channel-edit.php?agencyid={$agencyId}' accesskey='" . $keyAddNew . "'>{$GLOBALS['strAddNewChannel_Key']}</a>&nbsp;&nbsp;";
phpAds_ShowBreak();

$channels = Admin_DA::getChannels(['agency_id' => $agencyId], true);

MAX_displayChannels($channels, ['agencyid' => $agencyId]);

phpAds_PageFooter();
