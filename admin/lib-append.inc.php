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


// Set define to prevent duplicate include
define ('LIBAPPEND_INCLUDED', true);


// Include zones library if needed
if (!defined('LIBZONES_INCLUDED'))
	require ("lib-zones.inc.php");


// Define appendtypes
define ("phpAds_AppendRaw", 0);
define ("phpAds_AppendZone", 1);
define ("phpAds_AppendBanner", 2);



/*********************************************************/
/* Fetch parameters from append code                     */
/*********************************************************/

function phpAds_ParseAppendCode ($append)
{
	global $phpAds_config;
	
	$ret = array(
		array('zoneid' => '', 'delivery' => phpAds_ZonePopup),
		array()
	);
	
	if (ereg("ad(popup|layer)\.php\?([^'\"]+)['\"]", $append, $match))
	{
		if (!empty($match[2]))
		{
			$ret[0]['delivery'] = ($match[1] == 'popup') ? phpAds_ZonePopup : phpAds_ZoneInterstitial;
			
			$append = str_replace('&amp;', '&', $match[2]);
			
			if (ereg('[\?\&]?what=zone:([0-9]+)(&|$)', $append, $match))
			{
				$ret[0]['zoneid'] = $match[1];
				
				$append = explode('&', $append);
				while (list(, $v) = each($append))
				{
					$v = explode('=', $v);
					if (count($v) == 2)
						$ret[1][urldecode($v[0])] = urldecode($v[1]);
				}
			}
		}
	}
	
	return $ret;
}

?>