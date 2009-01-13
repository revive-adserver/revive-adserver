<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id$
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

// Initialize trackerAppend class
$trackerAppend = new Max_Admin_Inventory_TrackerAppend();

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
header("Content-Type: text/html; charset=ISO-8859-1");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
