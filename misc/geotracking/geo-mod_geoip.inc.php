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


function phpAds_countryCodeByAddr($addr)
{
	// $addr parameter is ignored and is here for API consistency only
	
	$result = @apache_note('GEOIP_COUNTRY_CODE');
	
	if ($result != '' && $result != '--')
		return ($result);
	else
		return (false);
}

?>