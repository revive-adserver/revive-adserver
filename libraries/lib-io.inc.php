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



/*********************************************************/
/* Register globals                                      */
/*********************************************************/

function phpAds_registerGlobal ()
{
	global $HTTP_GET_VARS, $HTTP_POST_VARS;
	
	if (!ini_get ('magic_quotes_gpc') ||
		!ini_get ('register_globals'))
	{
		$args = func_get_args();
		while (list(,$key) = each ($args))
		{
			if (isset($HTTP_GET_VARS[$key])) $value = $HTTP_GET_VARS[$key];
			if (isset($HTTP_POST_VARS[$key])) $value = $HTTP_POST_VARS[$key];
			
			if (isset($value))
			{
				if (!ini_get ('magic_quotes_gpc'))
				{
					if (!is_array($value))
						$value = addslashes($value);
					else
						$value = phpAds_slashArray($value);
				}
				
				$GLOBALS[$key] = $value;
				unset($value);
			}
		}
	}
}


/*********************************************************/
/* Recursive add slashes to an array                     */
/*********************************************************/

function phpAds_slashArray ($a)
{
	while (list($k,$v) = each($a))
	{
		if (!is_array($v))
			$a[$k] = addslashes($v);
		else
			$a[$k] = phpAds_slashArray($v);
	}
	
	reset ($a);
	return ($a);
}



/*********************************************************/
/* Store cookies to be set in a cache                    */
/*********************************************************/

function phpAds_setCookie ($name, $value, $expire = 0)
{
	global $phpAds_cookieCache;
	
	if (!isset($phpAds_cookieCache)) $phpAds_cookieCache = array();
	
	$phpAds_cookieCache[] = array ($name, $value, $expire);
}



/*********************************************************/
/* Send all cookies to the browser and clear cache       */
/*********************************************************/

function phpAds_flushCookie ()
{
	global $phpAds_config, $phpAds_cookieCache;
	
	if (isset($phpAds_cookieCache))
	{
		// Send P3P headers
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
		
		// Get path
		$url_prefix = parse_url($phpAds_config['url_prefix']);
		
		// Set cookies
		while (list($k,$v) = each ($phpAds_cookieCache))
		{
			list ($name, $value, $expire) = $v;
			setcookie ($name, $value, $expire, '/');
		}
		
		// Clear cache
		$phpAds_cookieCache = array();
	}
}

?>