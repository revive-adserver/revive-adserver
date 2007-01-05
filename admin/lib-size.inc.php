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



// Prevent full path disclosure
if (!defined('phpAds_path')) die();



// Include required files
require (phpAds_path."/libraries/resources/res-iab.inc.php");



/*********************************************************/
/* Get the description for a specific size               */
/*********************************************************/

function phpAds_getBannerSize ($width, $height)
{
	global $phpAds_IAB, $strCustom;
	
	$result = $strCustom." ($width x $height)";
	
	foreach (array_keys($phpAds_IAB) as $key)
	{
		if ($phpAds_IAB[$key]['width'] == $width &&
			$phpAds_IAB[$key]['height'] == $height)
		{
			$result = $key;
		}
	}
	
	return ($result);
}



/*********************************************************/
/* Find out if the selected size exists                  */
/*********************************************************/

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