<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



/*********************************************************/
/* Main code                                             */
/*********************************************************/

phpAds_unpackCookies();



/*********************************************************/
/* Register globals                                      */
/*********************************************************/

function phpAds_registerGlobal ()
{
	global $HTTP_GET_VARS, $HTTP_POST_VARS;
	
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
	
	if (!isset($phpAds_cookieCache)) $phpAds_cookieCache = array(array(), array());
	
	$phpAds_cookieCache[$expire ? 1 : 0][] = array ($name, $value, $expire);
}



/*********************************************************/
/* Send all cookies to the browser and clear cache       */
/*********************************************************/

function phpAds_flushCookie ()
{
	global $HTTP_COOKIE_VARS, $phpAds_config, $phpAds_cookieCache;

/*	I didn't enable this, as it's useless IMHO

	// Remove old style cookies
	foreach ($HTTP_COOKIE_VARS as $k => $v)
	{
		if (strpos($k, 'phpAds_') === 0)
		{
			if (is_array($v))
			{
				// Remove array cookies
				foreach (array_keys($v) as $kk)
					setcookie($k.'['.$kk.']', '', time() - 86400, '/');
			}
			else
			{
				// Remove scalar cookies
				setcookie($k, '', time() - 86400, '/');
			}
		}
	}
*/

	if (isset($phpAds_cookieCache))
	{
		// Send P3P headers
		if ($phpAds_config['p3p_policies'])
		{
			$p3p_header = '';
			
			if ($phpAds_config['p3p_policy_location'] != '')
				$p3p_header .= "policyref=\"".$phpAds_config['p3p_policy_location']."\"";
			
			if ($phpAds_config['p3p_policy_location'] != '' &&
			    $phpAds_config['p3p_compact_policy'] != '')
				$p3p_header .= ", ";
			
			if ($phpAds_config['p3p_compact_policy'] != '')
				$p3p_header .= "CP=\"".$phpAds_config['p3p_compact_policy']."\"";
			
			if ($p3p_header != '')
				header ("P3P: $p3p_header");
		}
		
		// Send session cookies
		if (isset($phpAds_cookieCache[0]))
			phpAds_packCookies($phpAds_cookieCache[0], true);
		
		// Send long term cookies
		if (isset($phpAds_cookieCache[1]))
			phpAds_packCookies($phpAds_cookieCache[1], false);
				
		// Clear cache
		$phpAds_cookieCache = array(array(), array());
	}
}



/*********************************************************/
/* Pack/unpack cookies                                   */
/*********************************************************/

function phpAds_packCookies($cache, $session)
{
	global $phpAds_config;
	
	// Get path
	$url = parse_url($phpAds_config['url_prefix']);
	
	// Merge all cookies into one, to prevent reaching cookie limit
	$cookies = array();
	
	// Store cookies into an array
	foreach ($cache as $v)
	{
		list ($name, $value, $expire) = $v;
		
		$cookies[$name] = array('v' => $value);
		
		if (!$session)
			$cookies[$name]['e'] = $expire;
	}
	
	// Encode only if necessary
	if (count($cookies))
	{
		// Serialize cookie array
		$cookies = serialize($cookies);
		
		// Compress and base64 encode it to save space/bandwidth and to allow more cookies
		if (extension_loaded('zlib'))
			$cookies = base64_encode(gzdeflate($cookies));
	}
	else
	{
		// Unset cookie
		$cookies = '';
	}
	
	if ($session)
		setcookie('phpAds_cookies[0]', $cookies); //, $url['host']);	
	else
		setcookie('phpAds_cookies[1]', $cookies, time() + 86400 * 365 * 5, $url['path']); //, $url['host']);
}

function phpAds_unpackCookies()
{
	global $HTTP_COOKIE_VARS, $phpAds_cookieCache;
	
	if (!isset($phpAds_cookieCache)) $phpAds_cookieCache = array(array(), array());
	
	if (isset($HTTP_COOKIE_VARS['phpAds_cookies']) && is_array($HTTP_COOKIE_VARS['phpAds_cookies']))
	{
		for ($i = 1; $i >= 0; $i--)
		{
			if (!isset($HTTP_COOKIE_VARS['phpAds_cookies'][$i]) || !$HTTP_COOKIE_VARS['phpAds_cookies'][$i])
				continue;
			
			$c = $HTTP_COOKIE_VARS['phpAds_cookies'][$i];
				
			if (extension_loaded('zlib'))
			{
				// Decode and decompress if needed
				$c = @gzinflate(@base64_decode($c));
			}
			else
			{
				// Remove backslashes if needed
				if (ini_get('magic_quotes_gpc'))
					$c = stripslashes($c);
			}
	
			if (($c = @unserialize($c)) && is_array($c))
			{
				// Cookies were stored in the correct way
				$now = time();
				$str = array();
				
				// Create a query-string with cookies
				foreach ($c as $k => $v)
				{
					if (isset($v['v']) && (!$i || isset($v['e'])))
					{
						// Check for session cookies or not expired ones
						if (!$i || $v['e'] > $now)
						{
							// Cookie not expired, append it
							$str[] = $k.'='.urlencode($v['v']);
							
							// Add cookie to the cach, so that it won't be lost
							// in case we need to store other cookies
							$phpAds_cookieCache[$i][] = array ($k, $v['v'], isset($v['e']) ? $v['e'] : 0);
						}
					}
				}
				
				if (count($str))
				{
					// Extract cookies into $c following magic_quotes configuration
					parse_str(join('&', $str), $c);
					
					// Merge them with the real cookie and make them available
					$c += $HTTP_COOKIE_VARS;
					$HTTP_COOKIE_VARS = $c;
					
					// Update the superglobal too, just in case it is used for debug
					$_COOKIE = $c;
				}
			}
		}
	}
}

?>