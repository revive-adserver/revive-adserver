<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Set define to prevent duplicate include
define ('LIBVIEWCACHE_INCLUDED', true);


function phpAds_cacheFetch ($name)
{
	$filename = 'cache-'.md5($name).'.php';
	
	if (file_exists(phpAds_path.'/cache/'.$filename))
	{
		$cache_complete = false;
		$cache_contents	= '';
		
		@include (phpAds_path.'/cache/'.$filename);
		
		if ($cache_complete == true)
			return ($cache_contents);
		else
			return false;
	}
	else
		return false;
}

function phpAds_cacheStore ($name, $cache)
{
	$filename = 'cache-'.md5($name).'.php';
	
	$cache_literal  = "<"."?php\n\n";
	
	preg_match ("#^([0-9]{1})\.([0-9]{1})\.([0-9]{1,2})#", phpversion(), $matches);
	$phpversion = sprintf ("%01d%01d%02d", $matches[1], $matches[2], $matches[3]);
	
	if ($phpversion >= 4200)
		$cache_literal .= "$"."cache_contents = ".var_export($cache, true).";\n\n";
	else
		$cache_literal .= "$"."cache_contents = unserialize(base64_decode(\"".base64_encode(serialize($cache))."\"));\n\n";
	
	$cache_literal .= "$"."cache_name     = '".$name."';\n";
	$cache_literal .= "$"."cache_complete = true;\n\n";
	$cache_literal .= "?".">";
	
	// Write cache to a temp file, then rename it, overwritng the old cache
	// On *nix systems this should guarantee atomicity
	if ($fp = @fopen(phpAds_path.'/cache/'.$filename.'.tmp', 'wb'))
	{
		@fwrite ($fp, $cache_literal, strlen($cache_literal));
		@fclose ($fp);

		if (!@rename(phpAds_path.'/cache/'.$filename.'.tmp', phpAds_path.'/cache/'.$filename))
		{
			// On some systems rename() doesn't overwrite destination
			@unlink(phpAds_path.'/cache/'.$filename);
			@rename(phpAds_path.'/cache/'.$filename.'.tmp', phpAds_path.'/cache/'.$filename);
		}
	}
	else
		return false;
}

function phpAds_cacheDelete ($name='')
{
	if ($name != '')
	{
		$filename = 'cache-'.md5($name).'.php';
		
		if (file_exists(phpAds_path.'/cache/'.$filename))
		{
			@unlink (phpAds_path.'/cache/'.$filename);
			return true;
		}
		else
			return false;
	}
	else
	{
		$cachedir = @opendir(phpAds_path.'/cache/');
		
		while (false !== ($filename = @readdir($cachedir)))
		{
			if (preg_match('#^cache-[0-9A-F]{32}.php$#i', $filename))
				@unlink (phpAds_path.'/cache/'.$filename);
		}
		
		@closedir($cachedir);
		
		return true;
	}
}

function phpAds_cacheInfo ()
{
	$result = array();
	
	$cachedir = @opendir(phpAds_path.'/cache/');
	
	while (false !== ($filename = @readdir($cachedir)))
	{
		if (preg_match('#^cache-[0-9A-F]{32}.php$#i', $filename))
		{
			$cache_complete = false;
			$cache_contents	= '';
			$cache_name     = '';
			
			@include (phpAds_path.'/cache/'.$filename);
			
			if ($cache_complete == true)
			{
				$result[$cache_name] = strlen(serialize($cache_contents));
			}
		}
	}
	
	@closedir($cachedir);
	
	return ($result);
}

?>