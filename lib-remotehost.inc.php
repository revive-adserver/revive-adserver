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



// Check for proxyserver
if ($phpAds_config['proxy_lookup'])
{
	$proxy = false;
	if (isset ($HTTP_SERVER_VARS['HTTP_VIA']) && $HTTP_SERVER_VARS['HTTP_VIA'] != '') $proxy = true;
	
	if (isset ($HTTP_SERVER_VARS['REMOTE_HOST']))
	{
		if (is_int (strpos ('proxy',   $HTTP_SERVER_VARS['REMOTE_HOST']))) $proxy = true;
		if (is_int (strpos ('cache',   $HTTP_SERVER_VARS['REMOTE_HOST']))) $proxy = true;
		if (is_int (strpos ('inktomi', $HTTP_SERVER_VARS['REMOTE_HOST']))) $proxy = true;
	}
	
	if ($proxy)
	{
		// Overwrite host address if a suitable header is found
		if (isset($HTTP_SERVER_VARS['HTTP_FORWARDED']) && 		$HTTP_SERVER_VARS['HTTP_FORWARDED'] != '') 		 $IP = $HTTP_SERVER_VARS['HTTP_FORWARDED'];
		if (isset($HTTP_SERVER_VARS['HTTP_FORWARDED_FOR']) &&	$HTTP_SERVER_VARS['HTTP_FORWARDED_FOR'] != '') 	 $IP = $HTTP_SERVER_VARS['HTTP_FORWARDED_FOR'];
		if (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED']) &&		$HTTP_SERVER_VARS['HTTP_X_FORWARDED'] != '') 	 $IP = $HTTP_SERVER_VARS['HTTP_X_FORWARDED'];
		if (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']) &&	$HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'] != '') $IP = $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'];
		if (isset($HTTP_SERVER_VARS['HTTP_CLIENT_IP']) &&		$HTTP_SERVER_VARS['HTTP_CLIENT_IP'] != '') 		 $IP = $HTTP_SERVER_VARS['HTTP_CLIENT_IP'];
		
		// Get last item from list
		$IP = explode (',', $IP);
		$IP = trim($IP[count($IP) - 1]);
		
		if ($IP != 'unknown')
		{
			$HTTP_SERVER_VARS['REMOTE_ADDR'] = $IP;
			$HTTP_SERVER_VARS['REMOTE_HOST'] = '';
		}
	}
}

if (!isset($HTTP_SERVER_VARS['REMOTE_HOST']) || $HTTP_SERVER_VARS['REMOTE_HOST'] == '')
{
	if ($phpAds_config['reverse_lookup'])
		$HTTP_SERVER_VARS['REMOTE_HOST'] = @gethostbyaddr ($HTTP_SERVER_VARS['REMOTE_ADDR']);
	else
		$HTTP_SERVER_VARS['REMOTE_HOST'] = $HTTP_SERVER_VARS['REMOTE_ADDR'];
}

?>