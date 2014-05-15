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
require_once MAX_PATH . '/lib/OA/Dal.php';
//require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';


require_once OX_PATH . '/lib/pear/DB/DataObject.php';

// Register input variables
phpAds_registerGlobal ('returnurl','agencyid');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// CVE-2013-5954 - see OA_Permission::checkSessionToken() method for details
OA_Permission::checkSessionToken();

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($agencyid)) {
    $doAgency = OA_Dal::factoryDO('agency');
    $doAgency->agencyid = $agencyid;
    $doAgency->get($agencyid);
    $doAgency->delete();
}

// Run the Maintenance Priority Engine process
OA_Maintenance_Priority::scheduleRun();

// Rebuild cache
// phpAds_cacheDelete();

if (!isset($returnurl) || $returnurl == '') {
	$returnurl = 'advertiser-index.php';
}

OX_Admin_Redirect::redirect($returnurl);

?>
