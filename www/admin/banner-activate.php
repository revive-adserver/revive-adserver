<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority.php';

// Register input variables
phpAds_registerGlobal ('value');


// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);

if (phpAds_isUser(phpAds_Agency))
{
    $query = "SELECT ".
		$conf['table']['prefix'].$conf['table']['banners'].".bannerid as bannerid".
		" FROM ".$conf['table']['prefix'].$conf['table']['clients'].
		",".$conf['table']['prefix'].$conf['table']['campaigns'].
		",".$conf['table']['prefix'].$conf['table']['banners'].
		" WHERE ".$conf['table']['prefix'].$conf['table']['campaigns'].".clientid='".$clientid."'".
		" AND ".$conf['table']['prefix'].$conf['table']['banners'].".campaignid='".$campaignid."'".
		" AND ".$conf['table']['prefix'].$conf['table']['banners'].".campaignid=".$conf['table']['prefix'].$conf['table']['campaigns'].".campaignid".
		" AND ".$conf['table']['prefix'].$conf['table']['campaigns'].".clientid=".$conf['table']['clients'].".clientid".
		" AND ".$conf['table']['prefix'].$conf['table']['clients'].".agencyid=".phpAds_getUserID()
    ;
    // if specific banner requested, make sure it is linked to this campaign to prevent URL mangling
    if ($bannerid) {
        $query .= " AND ".$conf['table']['prefix'].$conf['table']['banners'].".bannerid='".$bannerid."'";
    }
    $res = phpAds_dbQuery($query)
		or phpAds_sqlDie();
    if (phpAds_dbNumRows($res) == 0)
	{
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
		$result = phpAds_dbQuery("
			SELECT
				campaignid
			FROM
				".$conf['table']['prefix'].$conf['table']['banners']."
			WHERE
				bannerid = '$bannerid'
			") or phpAds_sqlDie();
		$row = phpAds_dbFetchArray($result);

		if ($row["campaignid"] == '' || phpAds_getUserID() != phpAds_getCampaignParentClientID ($row["campaignid"]))
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$campaignid = $row["campaignid"];

			$res = phpAds_dbQuery("
				UPDATE
					".$conf['table']['prefix'].$conf['table']['banners']."
				SET
					active = '$value',
					updated = '".date('Y-m-d H:i:s')."'
				WHERE
					bannerid = '$bannerid'
				") or phpAds_sqlDie();


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
	if (isset($bannerid) && $bannerid != '')
	{
		$res = phpAds_dbQuery("
			UPDATE
				".$conf['table']['prefix'].$conf['table']['banners']."
			SET
				active = '$value',
				updated = '".date('Y-m-d H:i:s')."'
			WHERE
				bannerid = '$bannerid'
		") or phpAds_sqlDie();
	}
	elseif (isset($campaignid) && $campaignid != '')
	{
		$res = phpAds_dbQuery("
			UPDATE
				".$conf['table']['prefix'].$conf['table']['banners']."
			SET
				active = '$value',
				updated = '".date('Y-m-d H:i:s')."'
			WHERE
				campaignid = '$campaignid'
		") or phpAds_sqlDie();
	}

	// Run the Maintenance Priority Engine process
    MAX_Maintenance_Priority::run();


	// Rebuild cache
	// require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
	// phpAds_cacheDelete();

	Header("Location: campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid);
}


?>
