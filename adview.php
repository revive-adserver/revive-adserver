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

if ($phpAds_config['log_adviews'] || $phpAds_config['acl'])
{
	require (phpAds_path."/lib-remotehost.inc.php");
	
	if ($phpAds_config['log_adviews'])
		require (phpAds_path."/lib-log.inc.php");
	
	if ($phpAds_config['acl'])
		require (phpAds_path."/lib-acl.inc.php");
}

require (phpAds_path."/lib-cache.inc.php");



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$url = parse_url($phpAds_config['url_prefix']);

if (isset($clientID) && !isset($clientid))	
	$clientid = $clientID;

if (!isset($clientid))
	$clientid = 0;

if (!isset($what))
	$what = '';

if (!isset($source))
	$source = '';

if (!isset($n))
	$n = 'default';

if (phpAds_dbConnect())
{
	$found = false;
	$first = true;
	
	while (($first || $what != '') && $found == false)
	{
		$first = false;
		
		if (substr($what,0,5) == 'zone:')
		{
			if (!defined('LIBVIEWZONE_INCLUDED'))
				require (phpAds_path.'/lib-view-zone.inc.php');
			
			$row = phpAds_fetchBannerZone($what, $clientid, '', $source);
		}
		else
		{
			if (!defined('LIBVIEWQUERY_INCLUDED'))
				require (phpAds_path.'/lib-view-query.inc.php');
			
			if (!defined('LIBVIEWDIRECT_INCLUDED'))
				require (phpAds_path.'/lib-view-direct.inc.php');
			
			$row = phpAds_fetchBannerDirect($what, $clientid, '', $source);
		}
		
		if (is_array ($row))
			$found = true;
		else
			$what  = $row;
	}
}

if ($found)
{
	// Send P3P Headers
	if ($phpAds_config['p3p_policies'])
	{
		$p3p_header = '';
		
		if (isset($phpAds_config['p3p_policy_location']) && 
		    $phpAds_config['p3p_policy_location'] != '')
			$p3p_header .= " policyref=\"".$phpAds_config['p3p_policy_location']."\"";
		
		if ($phpAds_config['p3p_compact_policy'] != '')
			$p3p_header .= " CP=\"".$phpAds_config['p3p_compact_policy']."\"";
		
		if ($p3p_header != '')
			header ("P3P: $p3p_header");
	}
	
	
	$cookie = array();
	
	
	// Log this impression
	if ($phpAds_config['block_adviews'] == 0 ||
	   ($phpAds_config['block_adviews'] > 0 && !isset($phpAds_blockView[$row['bannerid']])))
	{
		if ($phpAds_config['log_adviews'])
			phpAds_logImpression ($row['bannerid'], $row['clientid'], $row['zoneid'], $source);
		
		// Send block cookies
		if ($phpAds_config['block_adviews'] > 0)
			SetCookie("phpAds_blockView[".$row['bannerid']."]", time(), time() + $phpAds_config['block_adviews'], '/');
	}
	
	if ($row['block'] != '' && $row['block'] != '0')
	{
		SetCookie("phpAds_blockAd[".$row['bannerid']."]", time(), time() + $row['block'], '/');
	}
	
	// Send bannerid headers
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
			
			// Determine cachebuster
			if (eregi ('\{random(:([1-9])){0,1}\}', $row['filename'], $matches))
			{
				if ($matches[1] == "")
					$randomdigits = 8;
				else
					$randomdigits = $matches[2];
				
				$randomnumber = sprintf ('%0'.$randomdigits.'d', mt_rand (0, pow (10, $randomdigits) - 1));
				$row['imageurl'] = str_replace ($matches[0], $randomnumber, $row['imageurl']);
			}
			
			if (eregi ('\{random(:([1-9])){0,1}\}', $row['url'], $matches))
			{
				if (!isset($randomnumber) || $randomnumber == '')
				{
					if ($matches[1] == "")
						$randomdigits = 8;
					else
						$randomdigits = $matches[2];
					
					$randomnumber = sprintf ('%0'.$randomdigits.'d', mt_rand (0, pow (10, $randomdigits) - 1));
				}
				
				$row['url'] = str_replace ($matches[0], $randomnumber, $row['url']);
			}
			
			// Store destination URL
			$cookie['dest'] = $row['url'];
			
			// Redirect to the banner
			setcookie ("phpAds_banner[".$n."]", serialize($cookie), 0, $url["path"]);
			header 	  ("Location: ".$row['imageurl']);
			break;
		
		
		case 'web':
			$cookie['dest'] = $row['url'];
			
			// Redirect to the banner
			setcookie ("phpAds_banner[".$n."]", serialize($cookie), 0, $url["path"]);
			header 	  ("Location: ".$row['imageurl']);
			break;
		
		
		case 'sql':
			$cookie['dest'] = $row['url'];
			
			// Load the banner from the database
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
				setcookie ("phpAds_banner[".$n."]", serialize($cookie), 0, $url["path"]);
				header 	  ('Content-type: image/'.$row['contenttype'].'; name='.md5(microtime()).'.'.$row['contenttype']);
				echo $image['contents'];
			}
			
			break;
	}
}
else
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
	
	setcookie ("phpAds_banner[".$n."]", 'DEFAULT', 0, $url["path"]);
	
	if ($phpAds_config['default_banner_url'] != '')
		header 	  ("Location: ".$phpAds_config['default_banner_url']);
}

phpAds_dbClose();

?>
