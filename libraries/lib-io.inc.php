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
	
	if (!isset($phpAds_cookieCache)) $phpAds_cookieCache = array('s' => array(), 'p' => array());
	
	$phpAds_cookieCache[$expire ? 'p' : 's'][] = array ($name, $value, $expire);
}



/*********************************************************/
/* Send all cookies to the browser and clear cache       */
/*********************************************************/

function phpAds_flushCookie ()
{
	global $HTTP_COOKIE_VARS, $phpAds_config, $phpAds_cookieCache, $phpAds_cookieOldCache;

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

	if (isset($phpAds_cookieCache) || isset($phpAds_cookieOldCache))
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
		
		// Send temporary session cookies
		if (isset($phpAds_cookieCache['s']))
			phpAds_packCookies($phpAds_cookieCache['s'], true, true);
		
		// Send temporary permanent cookies
		if (isset($phpAds_cookieCache['p']))
			phpAds_packCookies($phpAds_cookieCache['p'], false, true);

		// Send session cookies
		if (isset($phpAds_cookieOldCache['s']))
			phpAds_packCookies($phpAds_cookieOldCache['s'], true);
		
		// Send permanent cookies
		if (isset($phpAds_cookieOldCache['p']))
			phpAds_packCookies($phpAds_cookieOldCache['p'], false);

		// Remove old temporary cookies
		if (isset($HTTP_COOKIE_VARS['phpAds_cookies']) && is_array($HTTP_COOKIE_VARS['phpAds_cookies']))
		{
			foreach (array_keys($HTTP_COOKIE_VARS['phpAds_cookies']) as $k)
			{
				if (!strlen($k))
					continue;
				
				$session = $k{0} == 's';
				
				if ($k != 's' && $k != 'p')
				{
					if ($session)
						setcookie('phpAds_cookies['.$k.']', '');
					else
						setcookie('phpAds_cookies['.$k.']', '', time() + 86400 * 365 * 5, '/');
				}
			}
		}
				
		// Clear cache
		$phpAds_cookieOldCache = $phpAds_cookieCache = array('s' => array(), 'p' => array());
	}
}



/*********************************************************/
/* Pack/unpack cookies                                   */
/*********************************************************/

function phpAds_packCookies($cache, $session, $tmp = false)
{
	global $phpAds_config;
	
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
	
	if ($tmp)
		$tmp = str_pad(join('', array_reverse(explode(' ', substr(microtime(), 2)))), 23, '0', STR_PAD_LEFT).substr(md5(uniqid('', 1)), 0, 8);
	else
		$tmp = '';
	
	if ($session)
		setcookie('phpAds_cookies[s'.$tmp.']', $cookies);
	else
		setcookie('phpAds_cookies[p'.$tmp.']', $cookies, time() + 86400 * 365 * 5, '/');
}

function phpAds_unpackCookies()
{
	global $HTTP_COOKIE_VARS, $phpAds_cookieOldCache;
	
	if (!isset($phpAds_cookieOldCache)) $phpAds_cookieOldCache = array('s' => array(), 'p' => array());
	
	if (isset($HTTP_COOKIE_VARS['phpAds_cookies']) && is_array($HTTP_COOKIE_VARS['phpAds_cookies']))
	{
		ksort($HTTP_COOKIE_VARS['phpAds_cookies']);
		
		$now = time();
		$str = array();
		
		foreach ($HTTP_COOKIE_VARS['phpAds_cookies'] as $i => $c)
		{
			if (!preg_match('/^[sp](?:[a-f0-9]{31})?$/', $i))
				continue;
			
			$session = $i{0} == 's';

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
				// Create a query-string with cookies
				foreach ($c as $k => $v)
				{
					if (isset($v['v']) && ($session || isset($v['e'])))
					{
						// Check for session cookies or not expired ones
						if ($session || $v['e'] > $now)
						{
							// Cookie not expired, append it
							$str[] = urlencode($k).'='.urlencode($v['v']);
							
							// Add cookie to the cach, so that it won't be lost
							// in case we need to store other cookies
							array_push($phpAds_cookieOldCache[$session ? 's' : 'p'], array ($k, $v['v'], isset($v['e']) ? $v['e'] : 0));
						}
					}
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

?>