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
require (phpAds_path."/libraries/lib-io.inc.php");
require (phpAds_path."/libraries/lib-db.inc.php");

if ($phpAds_config['log_adviews'] || $phpAds_config['acl'])
{
	require (phpAds_path."/libraries/lib-remotehost.inc.php");
	
	if ($phpAds_config['log_adviews'])
		require (phpAds_path."/libraries/lib-log.inc.php");
	
	if ($phpAds_config['acl'])
		require (phpAds_path."/libraries/lib-limitations.inc.php");
}

require (phpAds_path."/libraries/lib-cache.inc.php");



/*********************************************************/
/* Register input variables                              */
/*********************************************************/

phpAds_registerGlobal ('clientid', 'clientID', 'what', 'source',
					   'n');



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$url = parse_url($phpAds_config['url_prefix']);


if (isset($clientID) && !isset($clientid)) $clientid = $clientID;
if (!isset($clientid)) $clientid = 0;
if (!isset($what)) $what = '';
if (!isset($source)) $source = '';
if (!isset($n)) $n = 'default';

// Remove referer, to be sure it doesn't cause problems with limitations
if (isset($HTTP_SERVER_VARS['HTTP_REFERER'])) unset($HTTP_SERVER_VARS['HTTP_REFERER']);
if (isset($HTTP_REFERER)) unset($HTTP_REFERER);


if (phpAds_dbConnect())
{
	mt_srand(floor((isset($n) && strlen($n) > 5 ? hexdec($n[0].$n[2].$n[3].$n[4].$n[5]): 1000000) * (double)microtime()));
	
	// Reset followed zone chain
	$phpAds_followedChain = array();
	
	$found = false;
	$first = true;
	
	while (($first || $what != '') && $found == false)
	{
		$first = false;
		
		if (substr($what,0,5) == 'zone:')
		{
			if (!defined('LIBVIEWZONE_INCLUDED'))
				require (phpAds_path.'/libraries/lib-view-zone.inc.php');
			
			$row = phpAds_fetchBannerZone($what, $clientid, '', $source, false);
		}
		else
		{
			if (!defined('LIBVIEWQUERY_INCLUDED'))
				require (phpAds_path.'/libraries/lib-view-query.inc.php');
			
			if (!defined('LIBVIEWDIRECT_INCLUDED'))
				require (phpAds_path.'/libraries/lib-view-direct.inc.php');
			
			$row = phpAds_fetchBannerDirect($what, $clientid, '', $source, false);
		}
		
		if (is_array ($row))
			$found = true;
		else
			$what  = $row;
	}
}
else
{
	$found = false;
}


if ($found)
{
	// Log this impression
	if ($phpAds_config['block_adviews'] == 0 ||
	   ($phpAds_config['block_adviews'] > 0 && 
	   (!isset($HTTP_COOKIE_VARS['phpAds_blockView'][$row['bannerid']]) ||
	   	$HTTP_COOKIE_VARS['phpAds_blockView'][$row['bannerid']] <= time())))
	{
		if ($phpAds_config['log_adviews'])
			phpAds_logImpression ($row['bannerid'], $row['clientid'], $row['zoneid'], $source);
		
		// Send block cookies
		if ($phpAds_config['block_adviews'] > 0)
			phpAds_setCookie ("phpAds_blockView[".$row['bannerid']."]", time() + $phpAds_config['block_adviews'],
							  time() + $phpAds_config['block_adviews'] + 43200);
	}
	
	
	// Block
	if ($row['block'] != '' && $row['block'] != '0')
		phpAds_setCookie ("phpAds_blockAd[".$row['bannerid']."]", time() + $row['block'], time() + $row['block'] + 43200);
	
	
	// Set capping
	if ($row['capping'] != '' && $row['capping'] != '0')
	{
		if (isset($phpAds_capAd) && isset($phpAds_capAd[$row['bannerid']]))
			$newcap = $phpAds_capAd[$row['bannerid']] + 1;
		else
			$newcap = 1;
		
		phpAds_setCookie ("phpAds_capAd[".$row['bannerid']."]", $newcap, time() + 31536000);
	}
	
	
	if ($phpAds_config['geotracking_type'] != '' && $phpAds_config['geotracking_cookie'])
		if (!isset($HTTP_COOKIE_VARS['phpAds_geoInfo']) && $phpAds_geo)
			phpAds_setCookie ("phpAds_geoInfo", 
				($phpAds_geo['country'] ? $phpAds_geo['country'] : '').'|'.
			   	($phpAds_geo['continent'] ? $phpAds_geo['continent'] : '').'|'.
				($phpAds_geo['region'] ? $phpAds_geo['region'] : ''), 0);
	
	
	// Send bannerid headers
	$cookie = array();
	$cookie['bannerid'] = $row["bannerid"];
	
	// Send zoneid headers
	if ($row['zoneid'] != 0)
		$cookie['zoneid'] = $row['zoneid'];
	
	// Send source headers
	if (isset($source) && $source != '')
		$cookie['source'] = $source;
	
	
	switch ($row['storagetype'])
	{
		case 'url':
			$row['imageurl'] = str_replace ('{timestamp}', time(), $row['imageurl']);
			$row['url']      = str_replace ('{timestamp}', time(), $row['url']);
			
			
			// Replace random
			if (preg_match ('#\{random(:([0-9]+)){0,1}\}#i', $row['imageurl'], $matches))
			{
				if ($matches[2])
					$lastdigits = $matches[2];
				else
					$lastdigits = 8;
				
				$lastrandom = '';
				
				for ($r=0; $r<$lastdigits; $r=$r+9)
					$lastrandom .= (string)mt_rand (111111111, 999999999);
				
				$lastrandom  = substr($lastrandom, 0 - $lastdigits);
				$row['imageurl'] = str_replace ($matches[0], $lastrandom, $row['imageurl']);
			}
			
			if (preg_match ('#\{random(:([0-9]+)){0,1}\}#i', $row['url'], $matches))
			{
				if ($matches[2])
					$randomdigits = $matches[2];
				else
					$randomdigits = 8;
				
				if (isset($lastdigits) && $lastdigits == $randomdigits)
					$randomnumber = $lastrandom;
				else
				{
					$randomnumber = '';
					
					for ($r=0; $r<$randomdigits; $r=$r+9)
						$randomnumber .= (string)mt_rand (111111111, 999999999);
					
					$randomnumber  = substr($randomnumber, 0 - $randomdigits);
				}
				
				$row['url'] = str_replace ($matches[0], $randomnumber, $row['url']);
			}
			
			// Store destination URL
			$cookie['dest'] = $row['url'];
			
			// Redirect to the banner
			phpAds_setCookie ("phpAds_banner[".$n."]", serialize($cookie), 0);
			phpAds_flushCookie ();
			
			header 	  ("Location: ".$row['imageurl']);
			break;
		
		
		case 'web':
			$cookie['dest'] = $row['url'];
			
			// Redirect to the banner
			phpAds_setCookie ("phpAds_banner[".$n."]", serialize($cookie), 0);
			phpAds_flushCookie ();
			
			header 	  ("Location: ".$row['imageurl']);
			break;
		
		
		case 'sql':
			$cookie['dest'] = $row['url'];
			
			if (preg_match ("#Mozilla/(1|2|3|4)#", $HTTP_SERVER_VARS['HTTP_USER_AGENT']) && !preg_match("#compatible#", $HTTP_SERVER_VARS['HTTP_USER_AGENT']))
			{
				// Workaround for Netscape 4 problem
				// with animated GIFs. Redirect to
				// adimage to prevent banner changing
				// at the end of each animation loop
				
				phpAds_setCookie ("phpAds_banner[".$n."]", serialize($cookie), 0);
				phpAds_flushCookie ();
				
				if ($HTTP_SERVER_VARS['SERVER_PORT'] == 443) $phpAds_config['url_prefix'] = str_replace ('http://', 'https://', $phpAds_config['url_prefix']);
				header 	  ("Location: ".str_replace('{url_prefix}', $phpAds_config['url_prefix'], $row['imageurl']));
			}
			else
			{
				// Workaround for IE 4-5.5 problem
				// Load the banner from the database
				// and show the image directly to prevent
				// broken images when shown during a
				// form submit
				
				$res = phpAds_dbQuery("
					SELECT
						contents
					FROM
						".$phpAds_config['tbl_images']."
					WHERE
						filename = '".$row['filename']."'
				");
				
				if ($image = phpAds_dbFetchArray($res))
				{
					phpAds_setCookie ("phpAds_banner[".$n."]", serialize($cookie), 0);
					phpAds_flushCookie ();
					
					header 	  ('Content-type: image/'.$row['contenttype'].'; name='.md5(microtime()).'.'.$row['contenttype']);
					echo $image['contents'];
				}
			}
			
			break;
	}
}
else
{
	phpAds_setCookie ("phpAds_banner[".$n."]", 'DEFAULT', 0);
	phpAds_flushCookie ();
	
	if ($phpAds_config['default_banner_url'] != '')
		header ("Location: ".$phpAds_config['default_banner_url']);
	else
	{
		// Show 1x1 Gif, to ensure not broken image icon
		// is shown.
		
		header 	 ("Content-type: image/gif");
		
		echo chr(0x47).chr(0x49).chr(0x46).chr(0x38).chr(0x39).chr(0x61).chr(0x01).chr(0x00).
		     chr(0x01).chr(0x00).chr(0x80).chr(0x00).chr(0x00).chr(0x04).chr(0x02).chr(0x04).
		 	 chr(0x00).chr(0x00).chr(0x00).chr(0x21).chr(0xF9).chr(0x04).chr(0x01).chr(0x00).
		     chr(0x00).chr(0x00).chr(0x00).chr(0x2C).chr(0x00).chr(0x00).chr(0x00).chr(0x00).
		     chr(0x01).chr(0x00).chr(0x01).chr(0x00).chr(0x00).chr(0x02).chr(0x02).chr(0x44).
		     chr(0x01).chr(0x00).chr(0x3B);
	}
}

phpAds_dbClose();

?>