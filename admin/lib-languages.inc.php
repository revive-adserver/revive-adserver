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



/*********************************************************/
/* Returns available languages as array                  */
/*********************************************************/

function phpAds_AvailableLanguages()
{
	$languages = array();
	
	$langdir = opendir("../language/");
	while ($langfile = readdir($langdir))
	{
		if (is_dir("../language/$langfile"))
		{
			if (ereg("^([a-z0-9-]+)(_[a-z0-9-]+)?$", $langfile, $matches))
			{
				$languages[$langfile] = str_replace("- ", "-", 
					ucwords(str_replace("-", "- ", $matches[1]))).
					(empty($matches[2]) ? '' : ' ('.ucwords(substr($matches[2], 1)).')');
			}
		}
	}
	closedir($langdir);
	
	asort($languages, SORT_STRING);
	
	return $languages;
}

?>