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
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (phpAds_isUser(phpAds_Admin))
{
	$query = "
	   SELECT
	       storagetype,
	       imageurl,
	       status,
	       htmltemplate,
	       htmlcache,
	       bannerid AS ad_id,
	       autohtml
	   FROM {$conf['table']['prefix']}{$conf['table']['banners']}
	";
}
elseif (phpAds_isUser(phpAds_Agency))
{
    $agencyId = phpAds_getUserId();
    
	$query = "
	   SELECT
	       b.storagetype AS storagetype,
	       b.imageurl AS imageurl,
	       b.status AS status,
	       b.htmltemplate AS htmltemplate,
	       b.htmlcache AS htmlcache,
	       b.bannerid AS ad_id,
	       b.autohtml AS autohtml
	   FROM
	       {$conf['table']['prefix']}{$conf['table']['banners']} AS b,
	       {$conf['table']['prefix']}{$conf['table']['campaigns']} AS m,
	       {$conf['table']['prefix']}{$conf['table']['clients']} AS c
	   WHERE
	       b.campaignid=m.campaignid
           AND m.clientid=c.clientid
	       AND c.agencyid=$agencyId
	";
}
$res = phpAds_dbQuery($query);

while ($current = phpAds_dbFetchArray($res))
{
	// Rebuild filename
	if ($current['storagetype'] == 'sql' || $current['storagetype'] == 'web')
		$current['imageurl'] = '';
	
	// Add slashes to status to prevent javascript errors
	// NOTE: not needed in banner-edit because of magic_quotes_gpc
	$current['status'] = addslashes($current['status']);
	
	
	// Rebuild cache
	$current['htmltemplate'] = stripslashes($current['htmltemplate']);
	$current['htmlcache']    = addslashes(phpAds_getBannerCache($current));
	
	phpAds_dbQuery(
		"UPDATE ".$conf['table']['prefix'].$conf['table']['banners'].
		" SET htmlcache='".$current['htmlcache']."'".
		",imageurl='".$current['imageurl']."'".
		", updated = '".date('Y-m-d H:i:s')."'".
		" WHERE bannerid=".$current['ad_id']
	);
}

MAX_Admin_Redirect::redirect('maintenance-banners.php');

?>
