<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer			                        */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Check for proxyserver
if ($phpAds_config['proxy_lookup'])
{
	$proxy = false;
	if (isset ($GLOBALS['HTTP_VIA']) && $GLOBALS['HTTP_VIA'] != '') $proxy = true;
	
	if (is_int (strpos ('proxy',   $REMOTE_HOST))) $proxy = true;
	if (is_int (strpos ('cache',   $REMOTE_HOST))) $proxy = true;
	if (is_int (strpos ('inktomi', $REMOTE_HOST))) $proxy = true;
	
	if ($proxy)
	{
		// Overwrite host address if a suitable header is found
		if (isset($GLOBALS['HTTP_FORWARDED']) && 		$GLOBALS['HTTP_FORWARDED'] != '') 		$IP = $GLOBALS['HTTP_FORWARDED'];
		if (isset($GLOBALS['HTTP_FORWARDED_FOR']) &&	$GLOBALS['HTTP_FORWARDED_FOR'] != '') 	$IP = $GLOBALS['HTTP_FORWARDED_FOR'];
		if (isset($GLOBALS['HTTP_X_FORWARDED']) &&		$GLOBALS['HTTP_X_FORWARDED'] != '') 	$IP = $GLOBALS['HTTP_X_FORWARDED'];
		if (isset($GLOBALS['HTTP_X_FORWARDED_FOR']) &&	$GLOBALS['HTTP_X_FORWARDED_FOR'] != '')	$IP = $GLOBALS['HTTP_X_FORWARDED_FOR'];
		if (isset($GLOBALS['HTTP_CLIENT_IP']) &&		$GLOBALS['HTTP_CLIENT_IP'] != '') 		$IP = $GLOBALS['HTTP_CLIENT_IP'];
		
		// Get last item from list
		$IP = explode (',', $IP);
		$IP = trim($IP[count($IP) - 1]);
		
		if ($IP != 'unknown')
		{
			$REMOTE_ADDR = $IP;
			$REMOTE_HOST = '';
		}
	}
}

if (!isset($REMOTE_HOST) || $REMOTE_HOST == '')
{
	if ($phpAds_config['reverse_lookup'])
		$REMOTE_HOST = @gethostbyaddr ($REMOTE_ADDR);
	else
		$REMOTE_HOST = $REMOTE_ADDR;
}



?>