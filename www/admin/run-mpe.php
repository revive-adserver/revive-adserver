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
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
OA_Permission::checkSessionToken('mpe_token');


// Set longer time out, and ignore user abort
if (!ini_get('safe_mode')) {
    @set_time_limit($conf['maintenance']['timeLimitScripts']);
    @ignore_user_abort(true);
}

// No output required
ob_start();

// Run maintenance
OA_Maintenance_Priority::run();

// Clean the output buffer
ob_clean();
