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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/Admin/Inventory/TrackerAppend.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('trackers', $trackerid);

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
phpAds_SessionDataStore();

// Initialize trackerAppend class
$trackerAppend = new Max_Admin_Inventory_TrackerAppend();

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
header("Content-Type: text/html; charset=ISO-8859-1");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    OA_Permission::checkSessionToken();

    $trackerAppend->handlePost($_POST);
} else {
    $trackerAppend->handleGet();
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/
$doClients = OA_Dal::factoryDO('clients');
$doClients->whereAdd('clientid <>'.$trackerid);
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    $doClients->agencyid = OA_Permission::getAgencyId();
}
$doClients->find();
$aOtherAdvertisers = array();
while ($doClients->fetch() && $row = $doClients->toArray()) {
    $aOtherAdvertisers[] = $row;
}
MAX_displayNavigationTracker($clientid, $trackerid, $aOtherAdvertisers);

$trackerAppend->display();



/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['tracker-variables.php']['trackerid'] = $trackerid;


phpAds_SessionDataStore();

phpAds_PageFooter();

?>
