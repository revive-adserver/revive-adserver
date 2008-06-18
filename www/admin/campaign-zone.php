<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';

// Initialise Ad  Networks
$oAdNetworks = new OA_Central_AdNetworks();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$advertiserId   = MAX_getValue('clientid');
$campaignId     = MAX_getValue('campaignid');
$agencyId = OA_Permission::getAgencyId();
$aOtherAdvertisers = Admin_DA::getAdvertisers(array('agency_id' => $agencyId));
$aOtherCampaigns = Admin_DA::getPlacements(array('advertiser_id' => $advertiserId));
$pageName = basename($_SERVER['PHP_SELF']);
$aEntities = array('clientid' => $advertiserId, 'campaignid' => $campaignId);
MAX_displayNavigationCampaign($pageName, $aOtherAdvertisers, $aOtherCampaigns, $aEntities);
    
/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('campaign-zone.html');

$oDalZones      = OA_Dal::factoryDAL('zones');
$linkedWebsites    = $oDalZones->getWebsitesAndZonesListByCategory($agencyId, $categoryId, $campaignId, true);
$aCategoriesIds    = $oDalZones->getCategoriesIdsFromWebsitesAndZones($linkedWebsites);
$availableWebsites = $oDalZones->getWebsitesAndZonesListByCategory($agencyId, $categoryId, $campaignId, false);
$aCategoriesIds2   = $oDalZones->getCategoriesIdsFromWebsitesAndZones($availableWebsites);

$aCategoriesIds = array_merge($aCategoriesIds, $aCategoriesIds2);
$aCategories    = array('' => "- {$GLOBALS['strAllCategories']} -", -1 => $GLOBALS['strUncategorized']);
$aCategories    = $aCategories + $oAdNetworks->getCategoriesSelect($aCategoriesIds, false);
 

$oTpl->assign('linkedWebsites', $linkedWebsites );
$oTpl->assign('availableWebsites', $availableWebsites );
$oTpl->assign('advertiserId', $advertiserId);
$oTpl->assign('campaignId', $campaignId);
$oTpl->assign('aCategories', $aCategories);

$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
