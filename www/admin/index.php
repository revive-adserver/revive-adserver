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
require_once MAX_PATH . '/lib/OA/Permission.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    // Show Dashboard if Dashboard is enabled
    if ($GLOBALS['_MAX']['CONF']['ui']['dashboardEnabled']) {
        OX_Admin_Redirect::redirect('dashboard.php');
    } else {
        OX_Admin_Redirect::redirect('agency-index.php');
    }
}

if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    // Show Dashboard if Dashboard is enabled, Sync is enabled and PHP is SSL enabled
    if ($GLOBALS['_MAX']['CONF']['ui']['dashboardEnabled'] && $GLOBALS['_MAX']['CONF']['sync']['checkForUpdates'] && OA::getAvailableSSLExtensions()) {
        OX_Admin_Redirect::redirect('dashboard.php');
    } else {
        OX_Admin_Redirect::redirect('advertiser-index.php');
    }
}

if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
    OX_Admin_Redirect::redirect('stats.php?entity=advertiser&breakdown=history&clientid=' . OA_Permission::getEntityId());
}

if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
    OX_Admin_Redirect::redirect('stats.php?entity=affiliate&breakdown=history&affiliateid=' . OA_Permission::getEntityId());
}
