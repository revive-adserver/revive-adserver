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



// Figure out our location
define ('phpAds_path', '.');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/lib-db.inc.php");
require (phpAds_path."/lib-remotehost.inc.php");
require (phpAds_path."/lib-log.inc.php");
require (phpAds_path."/lib-cache.inc.php");



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($bannerid) && isset($clientid) && isset($zoneid))
{
	if (!isset($source)) $source = '';
	
	if ($phpAds_config['block_adviews'] == 0 ||
	   ($phpAds_config['block_adviews'] > 0 && !isset($phpAds_blockView[$bannerid])))
	{
		phpAds_dbConnect();
		phpAds_logImpression ($bannerid, $clientid, $zoneid, $source);
		
		
		// Send block cookies
		if ($phpAds_config['block_adviews'] > 0)
		{
			if ($phpAds_config['p3p_policies'])
			{
				$p3p_header = '';
				
				if ($phpAds_config['p3p_policy_location'] != '')
					$p3p_header .= " policyref=\"".$phpAds_config['p3p_policy_location']."\"";
				
				if ($phpAds_config['p3p_compact_policy'] != '')
					$p3p_header .= " CP=\"".$phpAds_config['p3p_compact_policy']."\"";
				
				if ($p3p_header != '')
					header ("P3P: $p3p_header");
			}
			
			$url = parse_url($phpAds_config['url_prefix']);
			SetCookie("phpAds_blockView[".$bannerid."]", time(), time() + $phpAds_config['block_adviews'], $url["path"]);
		}
	}
}


header 	 ("Content-type: image/gif");

// 1 x 1 gif
echo chr(0x47).chr(0x49).chr(0x46).chr(0x38).chr(0x37).chr(0x61).chr(0x01).chr(0x00).
	 chr(0x01).chr(0x00).chr(0x80).chr(0x00).chr(0x00).chr(0x04).chr(0x02).chr(0x04).
	 chr(0x00).chr(0x00).chr(0x00).chr(0x2C).chr(0x00).chr(0x00).chr(0x00).chr(0x00).
	 chr(0x01).chr(0x00).chr(0x01).chr(0x00).chr(0x00).chr(0x02).chr(0x02).chr(0x44).
	 chr(0x01).chr(0x00).chr(0x3B);

?>