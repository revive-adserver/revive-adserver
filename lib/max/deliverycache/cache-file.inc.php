<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: cache-file.inc.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

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

	if ($fp = @fopen(phpAds_path.'/cache/'.$filename, 'wb'))
	{
		@fwrite ($fp, $cache_literal, strlen($cache_literal));
		@fclose ($fp);
	}
	else
		return false;
}

/*
function phpAds_cacheDelete ($name='')
{
    // DO NOT ALLOW CACHE DELETION AS IT WOULD CAUSE IT TO BE STALE!
    return;
	if ($name != '') {
		$filename = 'cache-'.md5($name).'.php';
		if (file_exists(phpAds_path.'/cache/'.$filename)) {
			@unlink (phpAds_path.'/cache/'.$filename);
			return true;
		} else {
			return false;
		}
	} else {
		$cachedir = @opendir(phpAds_path.'/cache/');
		while (false !== ($filename = @readdir($cachedir))) {
			if (preg_match('#^cache-[0-9A-F]{32}.php$#i', $filename)) {
				@unlink (phpAds_path.'/cache/'.$filename);
			}
		}
		@closedir($cachedir);
		return true;
	}
}
*/

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
