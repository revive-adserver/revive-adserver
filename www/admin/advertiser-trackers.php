<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobal ('listorder', 'orderdirection');


/*-------------------------------------------------------*/
/* Advertiser interface security                          */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);

/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($listorder))
{
	if (isset($session['prefs']['advertiser-trackers.php']['listorder']))
		$listorder = $session['prefs']['advertiser-trackers.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($session['prefs']['advertiser-trackers.php']['orderdirection']))
		$orderdirection = $session['prefs']['advertiser-trackers.php']['orderdirection'];
	else
		$orderdirection = '';
}



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
{
    addAdvertiserPageToolsAndShortcuts($clientid);
	$oHeaderModel = buildAdvertiserHeaderModel($clientid);
	phpAds_PageHeader(null, $oHeaderModel);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('advertiser-trackers.html');

$doTrackers = OA_Dal::factoryDO('trackers');
$doTrackers->clientid = $clientid;
$doTrackers->addListOrderBy($listorder, $orderdirection);
$doTrackers->find();

$aTrackers = array();
while ($doTrackers->fetch() && $row_trackers = $doTrackers->toArray()) {
	$aTrackers[$row_trackers['trackerid']] = $row_trackers;
}

$oTpl->assign('clientId', $clientid);
$oTpl->assign('aTrackers', $aTrackers);
$oTpl->assign('listorder', $listorder);
$oTpl->assign('orderdirection', $orderdirection);
$oTpl->assign('url', 'advertiser-trackers.php?clientid=' . $clientid);

$oTpl->assign('canAdd', OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER));
$oTpl->assign('canEdit', OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER));
$oTpl->assign('canLink', OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER));
$oTpl->assign('canDelete', OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER));


/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['advertiser-trackers.php']['listorder'] = $listorder;
$session['prefs']['advertiser-trackers.php']['orderdirection'] = $orderdirection;

phpAds_SessionDataStore();



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oTpl->display();

phpAds_PageFooter();


?>
