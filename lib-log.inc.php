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



/*********************************************************/
/* Log a click to the database       					 */
/*********************************************************/

function phpAds_logClick($bannerID, $host)
{
    global $phpAds_compact_stats, $phpAds_tbl_adstats, $phpAds_insert_delayed;
    global $phpAds_tbl_adclicks;
	
    if ($phpAds_compact_stats)
    {
        $result = phpAds_dbQuery(sprintf("
            UPDATE %s
                $phpAds_tbl_adstats
            SET
                clicks=clicks+1
            WHERE
                bannerID = '$bannerID' &&
                day = now()
            ", $phpAds_insert_delayed ? "LOW_PRIORITY": ""));
		
        // If row didn't exist.  Create it.
        if (phpAds_dbAffectedRows($result) == 0) 
        {
            $result = phpAds_dbQuery(sprintf("
                INSERT %s INTO 
                    $phpAds_tbl_adstats
                SET
                    clicks=1,
                    views=0,
                    day = now(),
                    bannerID = '$bannerID'
                ", $phpAds_insert_delayed ? "DELAYED": ""));
        }
        return $result;
    }
    
    // else
    
    return phpAds_dbQuery(sprintf("
        INSERT %s
        INTO
            $phpAds_tbl_adclicks
        VALUES (
            '$bannerID',
            null,
            '$host'
        )", $phpAds_insert_delayed ? "DELAYED": ""));
}



/*********************************************************/
/* Log a view to the database       					 */
/*********************************************************/

function phpAds_logView($bannerID, $host)
{
    global $phpAds_compact_stats, $phpAds_tbl_adstats, $phpAds_insert_delayed;
    global $phpAds_tbl_adviews;
    
    if ($phpAds_compact_stats)
    {
        $result = phpAds_dbQuery(sprintf("
            UPDATE %s
                $phpAds_tbl_adstats
            SET
                views=views+1
            WHERE
                bannerID = '$bannerID' &&
                day = now()
            ", $phpAds_insert_delayed ? "LOW_PRIORITY": ""));
		
        // If row didn't exist.  Create it.
        if (phpAds_dbAffectedRows($result) == 0) 
        {
            $result = phpAds_dbQuery(sprintf("
                INSERT %s INTO 
                    $phpAds_tbl_adstats
                SET
                    clicks=0,
                    views=1,
                    day=now(),
                    bannerID = '$bannerID'
                ", $phpAds_insert_delayed ? "DELAYED": ""));
        }
        return $result;
    }
    
    // else
    
    return phpAds_dbQuery(sprintf("
        INSERT %s
        INTO
            $phpAds_tbl_adviews
        VALUES (
            '$bannerID',
            null,
            '$host'
        )", $phpAds_insert_delayed ? "DELAYED": ""));
}











/*********************************************************/
/* Get the host of the client                            */
/*********************************************************/

function phpAds_getClientInformation()
{
	global $phpAds_proxy_lookup;
	
	
	// Get host address and host name
	$addr = isset ($GLOBALS['REMOTE_ADDR']) ? $GLOBALS['REMOTE_ADDR'] : '';
	$host = isset ($GLOBALS['REMOTE_HOST']) ? $GLOBALS['REMOTE_HOST'] : '';
	
	// Lookup host name if needed
	if ($host == '' && $phpAds_reverse_lookup)
		$host = @gethostbyaddr ($addr);
	else
		$host = $addr;
	
	if ($phpAds_proxy_lookup)
	{
		// Check for proxyserver
		$proxy = false;
		if (isset ($GLOBALS['HTTP_VIA']) && $GLOBALS['HTTP_VIA'] != '') $proxy = true;
		if (is_int (strpos ('proxy',   $host))) $proxy = true;
		if (is_int (strpos ('cache',   $host))) $proxy = true;
		if (is_int (strpos ('inktomi', $host))) $proxy = true;
		
		if ($proxy)
		{
			// Overwrite host address if a suitable header is found
			if (isset($GLOBALS['HTTP_FORWARDED']) && 		$GLOBALS['HTTP_FORWARDED'] != '') 		$client = $GLOBALS['HTTP_FORWARDED'];
			if (isset($GLOBALS['HTTP_FORWARDED_FOR']) &&	$GLOBALS['HTTP_FORWARDED_FOR'] != '') 	$client = $GLOBALS['HTTP_FORWARDED_FOR'];
			if (isset($GLOBALS['HTTP_X_FORWARDED']) &&		$GLOBALS['HTTP_X_FORWARDED'] != '') 	$client = $GLOBALS['HTTP_X_FORWARDED'];
			if (isset($GLOBALS['HTTP_X_FORWARDED_FOR']) &&	$GLOBALS['HTTP_X_FORWARDED_FOR'] != '') 	$client = $GLOBALS['HTTP_X_FORWARDED_FOR'];
			if (isset($GLOBALS['HTTP_CLIENT_IP']) &&		$GLOBALS['HTTP_CLIENT_IP'] != '') 		$client = $GLOBALS['HTTP_CLIENT_IP'];
			
			// Get last item from list
			$clientArray = explode (',', $client);
			$client = trim($clientArray[sizeof($clientArray) - 1]);
			
			if ($client != 'unknown')
			{
				$addr = $client;
				
				// Perform reverse lookup if needed
				if ($phpAds_reverse_lookup)
					$host = @gethostbyaddr ($addr);
				else
					$host = $addr;
			}
		}
	}
	
	return (array ($addr, $host));
}


/*********************************************************/
/* Check if host has to be ignored                       */
/*********************************************************/

function phpads_ignore_host()
{
	global $phpAds_ignore_hosts, $phpAds_reverse_lookup, $REMOTE_HOST, $REMOTE_ADDR;
	
	list ($addr, $host) = phpAds_getClientInformation();
	$found=0;
	
	while (($found == 0) && (list (, $h)=each($phpAds_ignore_hosts)))
	{
		if (ereg("^([0-9]{1,3}\.){1,3}([0-9]{1,3}|\*)$", $h))
		{
			// It's an IP address, evenually with a wildcard, so I create a regexp
			$h = str_replace(".", '\.', str_replace("*$", "", "^".$h."$"));
			
			if (ereg($h, $addr))
				$found = 1;
		}
		elseif (eregi("^(\*\.)?([a-z0-9-]+\.)*[a-z0-9-]+$", $h))
		{
			// It's an host name, evenually with a wildcard, so I create a regexp
			$h = str_replace(".", '\.', str_replace("^*", "", "^".$h."$"));
						
			if (eregi($h, $host))
				$found = 1;
		}
		elseif (eregi("$host|$addr", $h)) // This check is backwards compatibile
				$found = 1;
	}
	
	// Returns hostname or IP address if OK, false if host is ignored
	return $found ? false : (empty($host) ? $addr : $host);
}

?>