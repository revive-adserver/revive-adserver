<?php // $Revision: 1.1.2.2 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2003 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// This is by no means a complete list of all iso3166 codes, but rather
// an unofficial list used by most browsers. If you have corrections or
// additions to this list, please send them to niels@creatype.nl

// German
// Corrections --> minichip@users.sourceforge.net

$phpAds_USStates['AL'] = "Alabama";
$phpAds_USStates['AK'] = "Alaska";
$phpAds_USStates['AZ'] = "Arizona";
$phpAds_USStates['AR'] = "Arkansas";
$phpAds_USStates['CA'] = "Kalifornien";
$phpAds_USStates['CO'] = "Kolorado";
$phpAds_USStates['CT'] = "Connecticut";
$phpAds_USStates['DE'] = "Delaware";
$phpAds_USStates['DC'] = "Dist. of Columbia";
$phpAds_USStates['FL'] = "Florida";
$phpAds_USStates['GA'] = "Georgia";
$phpAds_USStates['GU'] = "Guam";
$phpAds_USStates['HI'] = "Hawaii";
$phpAds_USStates['ID'] = "Idaho";
$phpAds_USStates['IL'] = "Illinois";
$phpAds_USStates['IN'] = "Indiana";
$phpAds_USStates['IA'] = "Iowa";
$phpAds_USStates['KS'] = "Kansas";
$phpAds_USStates['KY'] = "Kentucky";
$phpAds_USStates['LA'] = "Louisiana";
$phpAds_USStates['ME'] = "Maine";
$phpAds_USStates['MD'] = "Maryland";
$phpAds_USStates['MA'] = "Massachusetts";
$phpAds_USStates['MI'] = "Michigan";
$phpAds_USStates['MN'] = "Minnesota";
$phpAds_USStates['MS'] = "Mississippi";
$phpAds_USStates['MO'] = "Missouri";
$phpAds_USStates['MT'] = "Montana";
$phpAds_USStates['NE'] = "Nebraska";
$phpAds_USStates['NV'] = "Nevada";
$phpAds_USStates['NH'] = "New Hampshire";
$phpAds_USStates['NJ'] = "New Jersey";
$phpAds_USStates['NM'] = "New Mexico";
$phpAds_USStates['NY'] = "New York";
$phpAds_USStates['NC'] = "Nord-Carolina";
$phpAds_USStates['ND'] = "Nord-Dakota";
$phpAds_USStates['OH'] = "Ohio";
$phpAds_USStates['OK'] = "Oklahoma";
$phpAds_USStates['OR'] = "Oregon";
$phpAds_USStates['PA'] = "Pennsylvania";
$phpAds_USStates['PR'] = "Puerto Rico";
$phpAds_USStates['RI'] = "Rhode Island";
$phpAds_USStates['SC'] = "Süd-Carolina";
$phpAds_USStates['SD'] = "Süd-Dakota";
$phpAds_USStates['TN'] = "Tennessee";
$phpAds_USStates['TX'] = "Texas";
$phpAds_USStates['UT'] = "Utah";
$phpAds_USStates['VT'] = "Vermont";
$phpAds_USStates['VA'] = "Virginia";
$phpAds_USStates['VI'] = "Jungferninseln";
$phpAds_USStates['WA'] = "Washington";
$phpAds_USStates['WV'] = "West Virginia";
$phpAds_USStates['WI'] = "Wisconsin";
$phpAds_USStates['WY'] = "Wyoming";



// Load localized strings
if (file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/res-usstates.lang.php'))
	@include(phpAds_path.'/language/'.$phpAds_config['language'].'/res-usstates.lang.php');

?>