<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require	("config.inc.php"); 
require ("lib-db.inc.php");


// Set header information
//include ("lib-cache.inc.php");

// Open a connection to the database
phpAds_dbConnect();


if (isset($filename) && $filename != '')
{
	$res = phpAds_dbQuery("
		SELECT
			contents
		FROM
			".$phpAds_config['tbl_images']."
		WHERE
			filename = '".$filename."'
		");
	
	if (phpAds_dbNumRows($res) == 0)
	{
		// Filename not found, show default banner
		if ($phpAds_config['default_banner_url'] != "")
		{
			Header("Location: ".$phpAds_config['default_banner_url']);
		}
	}
	else
	{
		// Filename found, dump contents to browser
		$row = phpAds_dbFetchArray($res);
		
		if (isset($contenttype) && $contenttype != '')
		{
			switch ($contenttype)
			{
				case 'swf': Header('Content-type: application/x-shockwave-flash; name='.md5(microtime()).'.'.$contenttype); break;
				case 'dcr': Header('Content-type: application/x-director; name='.md5(microtime()).'.'.$contenttype); break;
				case 'rpm': Header('Content-type: audio/x-pn-realaudio-plugin; name='.md5(microtime()).'.'.$contenttype); break;
				case 'mov': Header('Content-type: video/quicktime; name='.md5(microtime()).'.'.$contenttype); break;
				default:	Header('Content-type: image/'.$contenttype.'; name='.md5(microtime()).'.'.$contenttype); break;
			}
		}
		
		echo $row['contents'];
	}
}
else
{
	// Filename not specified, show default banner
	
	if ($phpAds_config['default_banner_url'] != "")
	{
		Header("Location: ".$phpAds_config['default_banner_url']);
	}
}

phpAds_dbClose();

?>
