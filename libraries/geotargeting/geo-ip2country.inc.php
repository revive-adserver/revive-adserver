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
	global $phpAds_config;
	
	if ($phpAds_config['geotracking_location'] == '')
		return false;
	
	$zz 	= explode('.', $addr);
	$offset = (($zz[0]<<16)+($zz[1]<<8)+$zz[2])*2;
	
	// Lookup IP in database
	if ($fp = @fopen($phpAds_config['geotracking_location'], 'r'))
	{
		fseek($fp, $offset, SEEK_SET);
		$result = fread($fp, 2);
		fclose($fp);
		
		if ($result == "\0\0")
			return (false);
		else
			return ($result);
	}
	else
		return (false);
}

?>