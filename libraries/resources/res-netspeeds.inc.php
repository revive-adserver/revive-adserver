<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


$phpAds_Netspeeds[0] = "Unknown";
$phpAds_Netspeeds[1] = "Dial-up";
$phpAds_Netspeeds[2] = "Cable/DSL";
$phpAds_Netspeeds[3] = "Corporate";



// Load localized strings
if (file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/res-netspeeds.lang.php'))
	@include(phpAds_path.'/language/'.$phpAds_config['language'].'/res-netspeeds.lang.php');

?>