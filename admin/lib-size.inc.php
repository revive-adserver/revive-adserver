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


// Define default banner sizes
$phpAds_BannerSize ['IAB Full Banner (468 x 60)'] 		  = array ('width' => 468, 'height' => 60);
$phpAds_BannerSize ['IAB Half Banner (234 x 60)'] 		  = array ('width' => 234, 'height' => 60);
$phpAds_BannerSize ['IAB Micro Bar (88 x 31)'] 			  = array ('width' => 88,  'height' => 31);
$phpAds_BannerSize ['IAB Button 1 (120 x 90)'] 			  = array ('width' => 120, 'height' => 90);
$phpAds_BannerSize ['IAB Button 2 (120 x 60)'] 		 	  = array ('width' => 120, 'height' => 60);
$phpAds_BannerSize ['IAB Square Button (125 x 125)'] 	  = array ('width' => 125, 'height' => 125);
$phpAds_BannerSize ['IAB Vertical Banner (120 x 240)'] 	  = array ('width' => 120, 'height' => 240);
$phpAds_BannerSize ['IAB Rectangle (180 x 150)'] 		  = array ('width' => 180, 'height' => 150);
$phpAds_BannerSize ['IAB Medium Rectangle (300 x 250)']   = array ('width' => 300, 'height' => 250);
$phpAds_BannerSize ['IAB Large Rectangle (336 x 280)'] 	  = array ('width' => 336, 'height' => 280);
$phpAds_BannerSize ['IAB Vertical Rectangle (240 x 400)'] = array ('width' => 240, 'height' => 400);
$phpAds_BannerSize ['IAB Square Pop-up (250 x 250)'] 	  = array ('width' => 250, 'height' => 250);
$phpAds_BannerSize ['IAB Skyscraper (120 x 600)'] 		  = array ('width' => 120, 'height' => 600);
$phpAds_BannerSize ['IAB Wide Skyscraper (160 x 600)'] 	  = array ('width' => 160, 'height' => 600);



/*********************************************************/
/* Get the description for a specific size               */
/*********************************************************/

function phpAds_getBannerSize ($width, $height)
{
	global $phpAds_BannerSize;
	
	$result = "Custom ($width x $height)";
	
	for (reset($phpAds_BannerSize);$key=key($phpAds_BannerSize);next($phpAds_BannerSize))
	{
		if ($phpAds_BannerSize[$key]['width'] == $width &&
			$phpAds_BannerSize[$key]['height'] == $height)
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
	global $phpAds_BannerSize;
	
	$result = false;
	
	for (reset($phpAds_BannerSize);$key=key($phpAds_BannerSize);next($phpAds_BannerSize))
	{
		if ($phpAds_BannerSize[$key]['width'] == $width &&
			$phpAds_BannerSize[$key]['height'] == $height)
		{
			$result = true;
		}
	}
	
	return ($result);
}


?>