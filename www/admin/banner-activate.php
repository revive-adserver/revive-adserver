<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
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
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';

// Register input variables
phpAds_registerGlobal ('value');


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
{
    $doBanners = OA_Dal::factoryDO('banners');
    $doBanners->addReferenceFilter('agency', OA_Permission::getEntityId());
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

if ($value == OA_ENTITY_STATUS_RUNNING)
	$value = OA_ENTITY_STATUS_PAUSED;
else
	$value = OA_ENTITY_STATUS_RUNNING;

if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER))
{
	if (($value == OA_ENTITY_STATUS_PAUSED && OA_Permission::isAllowed(OA_PERM_BANNER_DEACTIVATE)) ||
	    ($value == OA_ENTITY_STATUS_RUNNING && OA_Permission::isAllowed(OA_PERM_BANNER_ACTIVATE)))
	{
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($bannerid);


		if ($doBanners->campaignid == '' || OA_Permission::getEntityId() != phpAds_getCampaignParentClientID ($doBanners->campaignid))
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$campaignid = $doBanners->campaignid;
            $doBanners->status = $value;
            $doBanners->update();

			// Run the Maintenance Priority Engine process
            OA_Maintenance_Priority::run();

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
elseif (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
{
	if (!empty($bannerid))
	{
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($bannerid);
        $doBanners->status = $value;
        $doBanners->update();
	}
	elseif (!empty($campaignid))
	{
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->status = $value;
        $doBanners->whereAdd('campaignid = ' . $campaignid);

        // Update all the banners
        $doBanners->update(DB_DATAOBJECT_WHEREADD_ONLY);
	}

	// Run the Maintenance Priority Engine process
    OA_Maintenance_Priority::scheduleRun();

	// Rebuild cache
	// require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
	// phpAds_cacheDelete();
	Header("Location: campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid);
}


?>
