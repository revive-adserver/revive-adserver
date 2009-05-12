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

// Register input variables
phpAds_registerGlobalUnslashed('hideinactive', 'listorder', 'orderdirection',
                               'pubid', 'url', 'country', 'language', 'category', 'adnetworks', 'advsignup', 'formId');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader(null, buildHeaderModel());


/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($listorder))
{
	if (isset($session['prefs']['website-index.php']['listorder']))
		$listorder = $session['prefs']['website-index.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($session['prefs']['website-index.php']['orderdirection']))
		$orderdirection = $session['prefs']['website-index.php']['orderdirection'];
	else
		$orderdirection = '';
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('website-index.html');

$dalAffiliates = OA_Dal::factoryDAL('affiliates');
$aWebsitesZones = $dalAffiliates->getWebsitesAndZonesByAgencyId();

$itemsPerPage = 250;
$oPager = OX_buildPager($aWebsitesZones, $itemsPerPage);
$oTopPager = OX_buildPager($aWebsitesZones, $itemsPerPage, false);
list($itemsFrom, $itemsTo) = $oPager->getOffsetByPageId();
$aWebsitesZones =  array_slice($aWebsitesZones, $itemsFrom - 1, $itemsPerPage, true);

$oTpl->assign('pager', $oPager);
$oTpl->assign('topPager', $oTopPager);

$oTpl->assign('affiliates',     $aWebsitesZones);
$oTpl->assign('listorder',      $listorder);
$oTpl->assign('orderdirection', $orderdirection);
$oTpl->assign('phpAds_ZoneBanner',          phpAds_ZoneBanner);
$oTpl->assign('phpAds_ZoneInterstitial',    phpAds_ZoneInterstitial);
$oTpl->assign('phpAds_ZonePopup',           phpAds_ZonePopup);
$oTpl->assign('phpAds_ZoneText'.            phpAds_ZoneText);
$oTpl->assign('showAdDirect', (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) ? true : false);


/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['website-index.php']['listorder'] = $listorder;
$session['prefs']['website-index.php']['orderdirection'] = $orderdirection;
phpAds_SessionDataStore();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oTpl->display();

phpAds_PageFooter();


function buildHeaderModel()
{
    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    return $builder->buildEntityHeader(array(), 'websites', 'list');
}

?>
