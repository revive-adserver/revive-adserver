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
require ("lib-expire.inc.php");
require ("lib-log.inc.php");
require	("view.inc.php");

// Set header information
include ("lib-cache.inc.php");


// Open a connection to the database
phpAds_dbConnect();

if (isset($bannerid) && isset($clientid) && isset($zoneid))
{
	phpAds_prepareLog ($bannerid, $clientid, $zoneid);
}

header ("Location: ".$phpAds_config['url_prefix']."/misc/beacon.gif");

?>
