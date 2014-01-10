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
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';
require_once MAX_PATH . '/lib/RV/Sync.php';
require_once MAX_PATH . '/www/admin/config.php';

Language_Loader::load('settings');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$title = $GLOBALS['strPlatformHashRegenerate'];
$oHeaderModel = new OA_Admin_UI_Model_PageHeaderModel($title);
phpAds_PageHeader('account-settings-index', $oHeaderModel);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$platformHash = OA_Dal_ApplicationVariables::generatePlatformHash();
if (OA_Dal_ApplicationVariables::set('platform_hash', $platformHash))
{
    echo $GLOBALS['strNewPlatformHash'] ." ". $platformHash;
    $oSync = new RV_Sync();
    OA::disableErrorHandling();
    $oSync->checkForUpdates();
    OA::enableErrorHandling();
} else {
    $this->oLogger->logError('Error inserting Platform Hash into database');
    echo $GLOBALS['strPlatformHashInsertingError'];
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();


?>
