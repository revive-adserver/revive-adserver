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
require ("config.inc.php");
require ("view.inc.php");
require ("acl.inc.php");

// Open a connection to the database
db_connect();


if (isset($bannerID) && !isset($what))
{
	// Show banner with bannerID
	
	$res = db_query("
		SELECT
			*
		FROM
			$phpAds_tbl_banners  
		WHERE
			bannerID = $bannerID
		") or mysql_die();
	
	if(mysql_num_rows($res) == 0)
	{
		if ($phpAds_default_banner_url != "")
		{
			Header("Location: $phpAds_default_banner_url");
		}
	}
	else
	{
		$row = mysql_fetch_array($res);
		if($row["format"] == "url" || $row["format"] == "web")
		{
			Header("Location: $row[banner]");
		} 
		elseif ($row["format"] == "swf")
		{
			Header("Content-type: application/x-shockwave-flash; name=".microtime()."\n");
			echo $row["banner"];
		}
		else 
		{
			Header("Content-type: image/".$row['format']."; name=".microtime());
			echo $row["banner"];
		}
	}
}
else
{
	// Fetch a banner
	
	if (!isset($what))
		$what = '';
	
	if (!isset($clientID))
		$clientID = 0;
	
	if (!isset($source))
		$source = '';
	
	
	$row = get_banner($what, $clientID, 0, $source, false);
	
	if (is_array($row))
	{
		if(!empty($row["bannerID"]))
		{
			if ($phpAds_p3p_policies)
			{
				$p3p_header = '';
				
				if ($phpAds_p3p_policy_location != '')
					$p3p_header .= " policyref=\"$phpAds_p3p_policy_location\"";
				
				if ($phpAds_p3p_compact_policy != '')
					$p3p_header .= " CP=\"$phpAds_p3p_compact_policy\"";
				
				if ($p3p_header != '')
					header ("P3P: $p3p_header");
			}
			
			$url = parse_url($GLOBALS["phpAds_url_prefix"]);
			SetCookie("bannerNum", $row["bannerID"], 0, $url["path"]);
			if(isset($n)) SetCookie("banID[$n]", $row["bannerID"], 0, $url["path"]);
			
			
			if ($row["format"] == "html")
			{
				echo $row["banner"];
			}
			elseif ($row["format"] == "url" || $row["format"] == "web")
			{
				Header("Location: $row[banner]");
			}
			else
			{
				if (!isset($row['banner']) || $row['banner'] == '')
				{
					// The image is not returned when using zones,
					// so if the var $row['banner'] is empty load
					// the image from the database.
					
					$res = db_query("
						SELECT
							*
						FROM
							$phpAds_tbl_banners  
						WHERE
							bannerID = ".$row['bannerID']."
						") or mysql_die();
					
					$row = mysql_fetch_array($res);
				}
				
				if ($row["format"] == "swf")
				{
					Header("Content-type: application/x-shockwave-flash; name=".microtime()."\n");
					echo $row["banner"];
				}
				else
				{
					Header("Content-type: image/".$row['format']."; name=".microtime());
					echo $row["banner"];
				}
			}
			
			log_adview($row["bannerID"], $row["clientID"]);
		}
		else
		{
			Header( "Content-type: image/$row[format]");
			echo $row["banner"];
		}
	}
	else
	{
		if ($phpAds_p3p_policies)
		{
			$p3p_header = '';
			
			if ($phpAds_p3p_policy_location != '')
				$p3p_header .= " policyref=\"$phpAds_p3p_policy_location\"";
			
			if ($phpAds_p3p_compact_policy != '')
				$p3p_header .= " CP=\"$phpAds_p3p_compact_policy\"";
			
			if ($p3p_header != '')
				header ("P3P: $p3p_header");
		}
		
		SetCookie("bannerNum", "DEFAULT", 0, $url["path"]);
		if(isset($n)) SetCookie("banID[$n]", "DEFAULT", 0, $url["path"]);
		
		Header ("Location: $phpAds_default_banner_url");
	}
}

db_close();

?>
