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
$Id: maintenance-storage-move.php 4346 2006-03-06 16:43:19Z andrew@m3.net $
*/

// Require the initialisation file
require_once '../../init.php';

require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';

// Security check
phpAds_checkAccess(phpAds_Admin);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$res = phpAds_dbQuery("
	SELECT
		storagetype AS type,
		filename,
		imageurl,
		htmltemplate,
		htmlcache
	FROM
		".$conf['table']['prefix'].$conf['table']['banners']."
");

while ($current = phpAds_dbFetchArray($res))
{
	if ($current['type'] == 'sql')
	{
		// Get the filename
		$filename = $current['filename'];
		
		// Copy the file
		$buffer = phpAds_ImageRetrieve ('sql', $filename);
		$current['filename'] = phpAds_ImageStore('web', $filename, $buffer);
		
		if ($current['filename'] != false)
		{
			// Delete the original file
			phpAds_ImageDelete ('sql', $filename);
			
			// Update fields
			$current['imageurl'] 	= '';
			$current['type'] = 'web';
			
			// Rebuild banner cache
			$current['htmltemplate'] = stripslashes($current['htmltemplate']);
			$current['htmlcache']    = addslashes(phpAds_getBannerCache($current));
			
			phpAds_dbQuery("
				UPDATE
					".$conf['table']['prefix'].$conf['table']['banners']."
				SET
					filename  = '".$current['filename']."',
					imageurl  = '".$current['imageurl']."',
					storagetype = '".$current['type']."',
					htmlcache = '".$current['htmlcache']."',
					updated = '".date('Y-m-d H:i:s')."'
				WHERE
					bannerid = ".$current['bannerid']."
			");
		}
	}
}

Header("Location: maintenance-storage.php");

?>