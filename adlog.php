<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Figure out our location
define ('phpAds_path', '.');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/lib-io.inc.php");
require (phpAds_path."/lib-db.inc.php");
require (phpAds_path."/lib-remotehost.inc.php");
require (phpAds_path."/lib-log.inc.php");
require (phpAds_path."/lib-cache.inc.php");



/*********************************************************/
/* Register input variables                              */
/*********************************************************/

phpAds_registerGlobal ('bannerid', 'clientid', 'zoneid', 'source',
					   'block', 'capping');



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($bannerid) && isset($clientid) && isset($zoneid))
{
	if (!isset($source)) $source = '';
	
	if ($phpAds_config['block_adviews'] == 0 ||
	   ($phpAds_config['block_adviews'] > 0 && 
	   (!isset($HTTP_COOKIE_VARS['phpAds_blockView'][$bannerid]) ||
	   	$HTTP_COOKIE_VARS['phpAds_blockView'][$bannerid] <= time())))
	{
		phpAds_dbConnect();
		phpAds_logImpression ($bannerid, $clientid, $zoneid, $source);
		
		// Send block cookies
		if ($phpAds_config['block_adviews'] > 0)
			phpAds_setCookie ("phpAds_blockView[".$bannerid."]", time() + $phpAds_config['block_adviews'],
							  time() + $phpAds_config['block_adviews'] + 43200);
	}
	
	
	if (isset($block) && $block != '' && $block != '0')
		phpAds_setCookie ("phpAds_blockAd[".$bannerid."]", time() + $block, time() + $block + 43200);
	
	
	if (isset($capping) && $capping != '' && $capping != '0')
	{
		if (isset($HTTP_COOKIE_VARS['phpAds_capAd'][$bannerid]))
			$newcap = $HTTP_COOKIE_VARS['phpAds_capAd'][$bannerid] + 1;
		else
			$newcap = 1;
		
		phpAds_setCookie ("phpAds_capAd[".$bannerid."]", $newcap, time() + 31536000);
	}
	
	
	phpAds_flushCookie ();
}


header 	 ("Content-type: image/gif");

// 1 x 1 gif
echo chr(0x47).chr(0x49).chr(0x46).chr(0x38).chr(0x39).chr(0x61).chr(0x01).chr(0x00).
     chr(0x01).chr(0x00).chr(0x80).chr(0x00).chr(0x00).chr(0x04).chr(0x02).chr(0x04).
 	 chr(0x00).chr(0x00).chr(0x00).chr(0x21).chr(0xF9).chr(0x04).chr(0x01).chr(0x00).
     chr(0x00).chr(0x00).chr(0x00).chr(0x2C).chr(0x00).chr(0x00).chr(0x00).chr(0x00).
     chr(0x01).chr(0x00).chr(0x01).chr(0x00).chr(0x00).chr(0x02).chr(0x02).chr(0x44).
     chr(0x01).chr(0x00).chr(0x3B);

?>