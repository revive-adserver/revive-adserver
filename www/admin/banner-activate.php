<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority.php';

// Register input variables
phpAds_registerGlobal ('value');


// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);
if (phpAds_isUser(phpAds_Agency))
{
    $doBanners = OA_Dal::factoryDO('banners');
    $doBanners->addReferenceFilter('agency', phpAds_getUserID());
    $doBanners->addReferenceFilter('campaigns', $campaignid);
    $doBanners->addReferenceFilter('clients', $clientid);
    if (!empty($bannerid)) {
        $doBanners->addReferenceFilter('banners', $bannerid);
    }
    $doBanners->find();

    if (!$doBanners->getRowCount()) {
        phpAds_PageHeader("2");
    	phpAds_Die ($strAccessDenied, $strNotAdmin);
    }
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if ($value == "t")
	$value = "f";
else
	$value = "t";

if (phpAds_isUser(phpAds_Client))
{
	if (($value == 'f' && phpAds_isAllowed(phpAds_DisableBanner)) ||
	    ($value == 't' && phpAds_isAllowed(phpAds_ActivateBanner)))
	{
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($bannerid);


		if ($doBanners->campaignid == '' || phpAds_getUserID() != phpAds_getCampaignParentClientID ($doBanners->campaignid))
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$campaignid = $doBanners->campaignid;
            $doBanners->active = $value;
            $doBanners->update();

			// Run the Maintenance Priority Engine process
            MAX_Maintenance_Priority::run();

			// Rebuild cache
			// require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
			// phpAds_cacheDelete();

			Header("Location: stats.php?entity=campaign&breakdown=banners&clientid=".$clientid."&campaignid=".$campaignid);
		}
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}
elseif (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency))
{
	if (!empty($bannerid))
	{
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($bannerid);
        $doBanners->active = $value;
        $doBanners->update();
	}
	elseif (!empty($campaignid))
	{
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->active = $value;
        $doBanners->whereAdd('campaignid = ' . $campaignid);

        // Update all the banners
        $doBanners->update(DB_DATAOBJECT_WHEREADD_ONLY);
	}

	// Run the Maintenance Priority Engine process
    MAX_Maintenance_Priority::run();


	// Rebuild cache
	// require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
	// phpAds_cacheDelete();

	Header("Location: campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid);
}


?>
