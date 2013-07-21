<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Required files
require_once MAX_PATH . '/lib/max/resources/res-iab.inc.php';

/*-------------------------------------------------------*/
/* Get the description for a specific size               */
/*-------------------------------------------------------*/

function phpAds_getBannerSize ($width, $height)
{
	global $phpAds_IAB, $strCustom;

	$result = $strCustom." ($width x $height)";

	foreach (array_keys($phpAds_IAB) as $key)
	{
		if ($phpAds_IAB[$key]['width'] == $width &&
			$phpAds_IAB[$key]['height'] == $height)
		{
			$result = $GLOBALS['strIab'][$key];
		}
	}

	return ($result);
}



/*-------------------------------------------------------*/
/* Find out if the selected size exists                  */
/*-------------------------------------------------------*/

function phpAds_sizeExists ($width, $height)
{
	global $phpAds_IAB;

	$result = false;

	foreach (array_keys($phpAds_IAB) as $key)
	{
		if ($phpAds_IAB[$key]['width'] == $width &&
			$phpAds_IAB[$key]['height'] == $height)
		{
			$result = true;
		}
	}

	return ($result);
}

?>