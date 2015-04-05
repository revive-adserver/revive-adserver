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

// Include required files
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/OA/Admin/Reports/Generate.php';

global $session;

// If the report is for a "specific" period, store the period for later user
if (!is_null($_GET['period_preset']) && ($_GET['period_preset'] == 'specific')) {
    if (!is_null($_GET['period_start'])) {
        $session['prefs']['GLOBALS']['startDate'] = $_GET['period_start'] = date('Y-m-d', strtotime($_GET['period_start']));
    }
    if (!is_null($_GET['period_end'])) {
        $session['prefs']['GLOBALS']['endDate'] = $_GET['period_end'] = date('Y-m-d', strtotime($_GET['period_end']));
    }
}

// Register input variables
phpAds_registerGlobal('plugin');

$oModule = new OA_Admin_Reports_Generate();
$oModule->generate($plugin);

?>