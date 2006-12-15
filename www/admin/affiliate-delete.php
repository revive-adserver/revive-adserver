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
$Id: affiliate-delete.php 6086 2006-11-23 08:29:33Z matteo@beccati.com $
*/


// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

// Register input variables
phpAds_registerGlobal ('returnurl');


// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

if (phpAds_isUser(phpAds_Agency))
{
	$query = "SELECT affiliateid FROM ".$conf['table']['prefix'].$conf['table']['affiliates']." WHERE affiliateid='".$affiliateid."' AND agencyid=".phpAds_getUserID();
	$res = phpAds_dbQuery($query) or phpAds_sqlDie();
	if (phpAds_dbNumRows($res) == 0)
	{
		phpAds_PageHeader("2");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (isset($affiliateid) && $affiliateid != '')
{
	// Reset append codes which called this affiliate's zones
	$res = phpAds_dbQuery("
			SELECT
				zoneid
			FROM
				".$conf['table']['prefix'].$conf['table']['zones']."
			WHERE
				affiliateid = '$affiliateid'
		");

	$zones = array();
	while ($row = phpAds_dbFetchArray($res))
		$zones[] = $row['zoneid'];
	
	if (count($zones))
	{
		$res = phpAds_dbQuery("
				SELECT
					zoneid,
					append
				FROM
					".$conf['table']['prefix'].$conf['table']['zones']."
				WHERE
					appendtype = ".phpAds_ZoneAppendZone." AND
					affiliateid <> '$affiliateid'
			");
		
		while ($row = phpAds_dbFetchArray($res))
		{
			$append = phpAds_ZoneParseAppendCode($row['append']);

			if (in_array($append[0]['zoneid'], $zones))
			{
				phpAds_dbQuery("
						UPDATE
							".$conf['table']['prefix'].$conf['table']['zones']."
						SET
							appendtype = ".phpAds_ZoneAppendRaw.",
							append = '',
							updated = '".date('Y-m-d H:i:s')."'
						WHERE
							zoneid = '".$row['zoneid']."'
					");
			}
		}

		
		// Delete zones
		$res = phpAds_dbQuery("
			DELETE FROM
				".$conf['table']['prefix'].$conf['table']['zones']."
			WHERE
				affiliateid = '$affiliateid'
			") or phpAds_sqlDie();
		
		// Delete links to placement
		$zoneStr = implode(',',$zones);
		$query = "
		DELETE FROM {$conf['table']['prefix']}{$conf['table']['placement_zone_assoc']}
		WHERE zone_id IN ($zoneStr)
		";
		$res = phpAds_dbQuery($query) or phpAds_sqlDie();

		// Delete links to ad
		$zoneStr = implode(',',$zones);
		$query = "
		DELETE FROM {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']}
		WHERE zone_id IN ($zoneStr)
		";
		$res = phpAds_dbQuery($query) or phpAds_sqlDie();
	}

	// Delete affiliates_extra row
	$res = phpAds_dbQuery("
		DELETE FROM
			".$conf['table']['prefix'].$conf['table']['affiliates_extra']."
		WHERE
			affiliateid = '$affiliateid'
		") or phpAds_sqlDie();

	// Delete affiliate
	$res = phpAds_dbQuery("
		DELETE FROM
			".$conf['table']['prefix'].$conf['table']['affiliates']."
		WHERE
			affiliateid = '$affiliateid'
		") or phpAds_sqlDie();
}

if (!isset($returnurl) && $returnurl == '')
	$returnurl = 'affiliate-index.php';

Header("Location: ".$returnurl);

?>