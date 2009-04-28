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
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';

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


$doAffiliates = OA_Dal::factoryDO('affiliates');
$doAffiliates->addListOrderBy($listorder, $orderdirection);

// Get affiliates and build the tree
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
{
	$doAffiliates->agencyid = OA_Permission::getEntityId();
}
elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER))
{
	$doAffiliates->affiliateid = OA_Permission::getEntityId();
}

$doAffiliates->find();
while ($doAffiliates->fetch() && $row_affiliates = $doAffiliates->toArray())
{
	$affiliates[$row_affiliates['affiliateid']] = $row_affiliates;
	$affiliates[$row_affiliates['affiliateid']]['expand'] = 0;
	$affiliates[$row_affiliates['affiliateid']]['count'] = 0;
    $affiliates[$row_affiliates['affiliateid']]['channels'] = Admin_DA::getChannels(array('publisher_id' => $row_affiliates['affiliateid']));

    $affiliates[$row_affiliates['affiliateid']]['adv_signup'] = !empty($row_affiliates['as_website_id']) ? $strYes : $strNo;
}

$doZones = OA_Dal::factoryDO('zones');
$doZones->addListOrderBy($listorder, $orderdirection);

$doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
$doAdZoneAssoc->selectAdd();
$doAdZoneAssoc->selectAdd('zone_id');
$doAdZoneAssoc->selectAdd('COUNT(*) AS num_ads');
$doAdZoneAssoc->groupBy('zone_id');

// Get the zones for each affiliate
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN))
{
    $doAdZoneAssoc->whereAdd('zone_id > 0');
}
elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
{
    $agencyId = OA_Permission::getAgencyId();

    $doAffiliates = OA_Dal::factoryDO('affiliates');
    $doAffiliates->agencyid = $agencyId;
    $doZones->joinAdd($doAffiliates);

    $doAdZoneAssoc->joinAdd($doZones);
}

$doZones->find();

while ($doZones->fetch() && $row_zones = $doZones->toArray())
{
	if (isset($affiliates[$row_zones['affiliateid']]))
	{
		$zones[$row_zones['zoneid']] = $row_zones;
		$affiliates[$row_zones['affiliateid']]['count']++;
	}
}

$doAdZoneAssoc->find();
while ($doAdZoneAssoc->fetch() && $row_ad_zones = $doAdZoneAssoc->toArray()) {
    // set warning flag if zone has no low-priority ads linked
    MAX_Dal_Delivery_Include();
    $aZoneAds = OA_Dal_Delivery_getZoneLinkedAds($row_ad_zones['zone_id']);
    $lpc_flag = false;
    if ($aZoneAds['count_active'] > 0) {
        if (count($aZoneAds['lAds']) == 0) {
            $lpc_flag = true;
        }
    }
    $zones[$row_ad_zones['zone_id']]['lpc_flag'] = $lpc_flag;

    $zones[$row_ad_zones['zone_id']]['num_ads'] = $row_ad_zones['num_ads'];
}

// Build Tree
if (isset($zones) && is_array($zones) && count($zones) > 0)
{
	// Add banner to campaigns
	foreach (array_keys($zones) as $zkey)
	{
		$affiliates[$zones[$zkey]['affiliateid']]['zones'][$zkey] = $zones[$zkey];
	}

	unset ($zones);
}

$doAffiliates = OA_Dal::factoryDO('affiliates');
$doZones = OA_Dal::factoryDO('zones');

if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    $doAffiliates->agencyid = OA_Permission::getAgencyId();
    $doZones->joinAdd($doAffiliates);
}

$itemsPerPage = 250;
$oPager = OX_buildPager($affiliates, $itemsPerPage);
$oTopPager = OX_buildPager($affiliates, $itemsPerPage, false);
list($itemsFrom, $itemsTo) = $oPager->getOffsetByPageId();
$affiliates =  array_slice($affiliates, $itemsFrom - 1, $itemsPerPage, true);

$oTpl->assign('pager', $oPager);
$oTpl->assign('topPager', $oTopPager);

$oTpl->assign('affiliates',     $affiliates);
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
