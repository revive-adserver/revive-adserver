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

if ($phpAds_config['acl'])
	require ("lib-acl.inc.php");

require	("view.inc.php");


// Set header information
include ("lib-cache.inc.php");


// Open a connection to the database
phpAds_dbConnect();


if (isset($clientID) && !isset($clientid))	
	$clientid = $clientID;

if (!isset($clientid))
	$clientid = 0;

if (!isset($what))
	$what = '';

if (!isset($source))
	$source = '';



$row = phpAds_fetchBanner($what, $clientid, 0, $source, false);

if (is_array($row) && isset($row['bannerid']))
{
	// Log this impression
	phpAds_prepareLog ($row["bannerid"], $row["clientid"], $row["zoneid"], $source);
	
	
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
	
	
	// Send bannerid headers
	$url = parse_url($phpAds_config['url_prefix']);
	SetCookie("bannerNum", $row["bannerid"], 0, $url["path"]);
	if(isset($n)) SetCookie("banID[$n]", $row["bannerid"], 0, $url["path"]);
	
	
	// Send zoneid headers
	if ($row['zoneid'] != 0)
	{
		SetCookie("zoneNum", $row["zoneid"], 0, $url["path"]);
		if(isset($n)) SetCookie("zoneID[$n]", $row["zoneid"], 0, $url["path"]);
	}
	
	
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
			SetCookie("destNum", $row['url'], 0, $url["path"]);
			if(isset($n)) SetCookie("destID[$n]", $row['url'], 0, $url["path"]);
			
			// Redirect to the banner
			header ("Location: ".$row['imageurl']);
			break;
		
		
		case 'web':
			SetCookie("destNum", $row['url'], 0, $url["path"]);
			if(isset($n)) SetCookie("destID[$n]", $row['url'], 0, $url["path"]);
			
			// Redirect to the banner
			header ("Location: ".$row['imageurl']);
			break;
		
		
		case 'sql':
			SetCookie("destNum", $row['url'], 0, $url["path"]);
			if(isset($n)) SetCookie("destID[$n]", $row['url'], 0, $url["path"]);
			
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
				header ('Content-type: image/'.$row['contenttype'].'; name='.md5(microtime()).'.'.$row['contenttype']);
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
	
	SetCookie("bannerNum", "DEFAULT", 0, $url["path"]);
	if(isset($n)) SetCookie("banID[$n]", "DEFAULT", 0, $url["path"]);
	
	Header ("Location: ".$phpAds_config['default_banner_url']);
}

phpAds_dbClose();

?>
