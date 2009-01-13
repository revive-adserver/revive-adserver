<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
$Id$
*/

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
