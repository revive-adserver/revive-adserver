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

if (isset($clientID) && !isset($clientid))	
	$clientid = $clientID;

if (!isset($clientid))
	$clientid = 0;

if (!isset($what))
	$what = '';

if (!isset($source))
	$source = '';



// Include the need sub-libraries
if (substr($what,0,5) == 'zone:')
{
	if (!defined('LIBVIEWZONE_INCLUDED'))
		require (phpAds_path.'/lib-view-zone.inc.php');
}
else
{
	if (!defined('LIBVIEWQUERY_INCLUDED'))
		require (phpAds_path.'/lib-view-query.inc.php');
	
	if (!defined('LIBVIEWDIRECT_INCLUDED'))
		require (phpAds_path.'/lib-view-direct.inc.php');
}



phpAds_dbConnect();

$row = phpAds_fetchBanner($what, $clientid, 0, $source, false);



if (is_array($row) && isset($row['bannerid']))
{
	// Log this impression
	phpAds_logImpression ($row['bannerid'], $row['clientid'], $row['zoneid'], $source);
	
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
	
	// Send source headers
	if (isset($source) && $source != '')
	{
		SetCookie("sourceNum", $source, 0, $url["path"]);
		if(isset($n)) SetCookie("sourceID[$n]", $source, 0, $url["path"]);
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
