<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Phil Hord				                        */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// MySQL DB Resource
$phpAds_db_link = '';


/*********************************************************/
/* Open a connection to the database			         */
/*********************************************************/

function db_connect()
{
	global $phpAds_persistent_connections;
	global $phpAds_hostname, $phpAds_mysqluser, $phpAds_mysqlpassword, $phpAds_db;
	global $phpAds_db_link;
	
    if ($phpAds_persistent_connections)
        $phpAds_db_link = @mysql_pconnect ($phpAds_hostname, $phpAds_mysqluser, $phpAds_mysqlpassword);
    else
        $phpAds_db_link = @mysql_connect ($phpAds_hostname, $phpAds_mysqluser, $phpAds_mysqlpassword);
	
	@mysql_select_db ($phpAds_db, $phpAds_db_link);
	
	return $phpAds_db_link;
}



/*********************************************************/
/* Close the connection to the database			         */
/*********************************************************/

function db_close()
{
	global $phpAds_persistent_connections;
	global $phpAds_db_link;
	
	if (!$phpAds_persistent_connections)
		@mysql_close ($phpAds_db_link);
}



/*********************************************************/
/* Execute a query								         */
/*********************************************************/

function db_query($query)
{
    global $phpAds_last_query;
	global $phpAds_db_link;
	
    $phpAds_last_query = $query;
    return @mysql_query ($query, $phpAds_db_link);
}



/*********************************************************/
/* Log a click to the database       					 */
/*********************************************************/

function db_log_click($bannerID, $host)
{
    global $phpAds_compact_stats, $phpAds_tbl_adstats, $phpAds_insert_delayed;
    global $phpAds_tbl_adclicks;
	
    if ($phpAds_compact_stats)
    {
        $result = @db_query(sprintf("
            UPDATE %s
                $phpAds_tbl_adstats
            SET
                clicks=clicks+1
            WHERE
                bannerID = '$bannerID' &&
                day = now()
            ", $phpAds_insert_delayed ? "LOW_PRIORITY": "")) or mysql_die();
		
        // If row didn't exist.  Create it.
        if (mysql_affected_rows() == 0) 
        {
            $result = @db_query(sprintf("
                INSERT %s INTO 
                    $phpAds_tbl_adstats
                SET
                    clicks=1,
                    views=0,
                    day = now(),
                    bannerID = '$bannerID'
                ", $phpAds_insert_delayed ? "DELAYED": "")) or mysql_die();
        }
        return $result;
    }
    
    // else
    
    return @db_query(sprintf("
        INSERT %s
        INTO
            $phpAds_tbl_adclicks
        VALUES (
            '$bannerID',
            null,
            '$host'
        )", $phpAds_insert_delayed ? "DELAYED": "")) or mysql_die();
}



/*********************************************************/
/* Log a view to the database       					 */
/*********************************************************/

function db_log_view($bannerID, $host)
{
    global $phpAds_compact_stats, $phpAds_tbl_adstats, $phpAds_insert_delayed;
    global $phpAds_tbl_adviews;
    
    if ($phpAds_compact_stats)
    {
        $result = @db_query(sprintf("
            UPDATE %s
                $phpAds_tbl_adstats
            SET
                views=views+1
            WHERE
                bannerID = '$bannerID' &&
                day = now()
            ", $phpAds_insert_delayed ? "LOW_PRIORITY": "")) or mysql_die();
		
        // If row didn't exist.  Create it.
        if (mysql_affected_rows() == 0) 
        {
            $result = @db_query(sprintf("
                INSERT %s INTO 
                    $phpAds_tbl_adstats
                SET
                    clicks=0,
                    views=1,
                    day=now(),
                    bannerID = '$bannerID'
                ", $phpAds_insert_delayed ? "DELAYED": "")) or mysql_die();
        }
        return $result;
    }
    
    // else
    
    return @db_query(sprintf("
        INSERT %s
        INTO
            $phpAds_tbl_adviews
        VALUES (
            '$bannerID',
            null,
            '$host'
        )", $phpAds_insert_delayed ? "DELAYED": "")) or mysql_die();
}



/*********************************************************/
/* Get overview statistics						         */
/*********************************************************/

function db_total_stats($table, $column, $bannerID, $timeconstraint="")
{
    global $phpAds_tbl_adstats;
    
	$ret = 0;
    $where = "";
	
    if (!empty($bannerID)) 
        $where = "WHERE bannerID = $bannerID";
    
	if (!empty($timeconstraint))
	{
		if (!empty($bannerID))
			$where .= " AND ";
		else
			$where = "WHERE ";
		
		if ($timeconstraint == "month")
		{
			$begintime = date ("Ym01000000");
			$endtime = date ("YmdHis", mktime(0, 0, 0, date("m") + 1, 1, date("Y")));
			$where .= "t_stamp >= $begintime AND t_stamp < $endtime";
		}
		elseif ($timeconstraint == "week")
		{
			$begintime = date ("Ymd000000", time() - 518400);
			$endtime = date ("Ymd000000", time() + 86400);
			$where .= "t_stamp >= $begintime AND t_stamp < $endtime";
		}
		else
		{
		    $begintime = date ("Ymd000000");
			$endtime = date ("Ymd000000", time() + 86400);
			$where .= "t_stamp >= $begintime AND t_stamp < $endtime";
		}
	}
	
    $res = db_query("SELECT count(*) as qnt FROM $table $where") or mysql_die();
    if (mysql_num_rows ($res))
    { 
        $row = mysql_fetch_array($res);
		if (isset($row['qnt'])) $ret += $row['qnt'];
    }
	
    $where = "";
    if (!empty($bannerID)) 
        $where = "WHERE bannerID = $bannerID";
    
	if (!empty($timeconstraint))
	{
		if (!empty($bannerID))
			$where .= " AND ";
		else
			$where = "WHERE ";
		
		if ($timeconstraint == "month")
		{
			$where .= "MONTH(day) = MONTH(CURDATE())";
		}
		elseif ($timeconstraint == "week")
		{
			$where .= "WEEK(day) = WEEK(CURDATE()) AND YEAR(day) = YEAR(CURDATE())";
		}
		else
		{
		    $where .= "day = CURDATE()";
		}
	}
	
    $res = db_query("SELECT sum($column) as qnt FROM $phpAds_tbl_adstats $where") or mysql_die();
    if (mysql_num_rows ($res))
    { 
        $row = mysql_fetch_array($res);
        if (isset($row['qnt'])) $ret += $row['qnt'];
    }
    return $ret;
}

function db_total_clicks($bannerID="", $timeconstraint="")
{
    return db_total_stats($GLOBALS["phpAds_tbl_adclicks"], "clicks", $bannerID, $timeconstraint);
}

function db_total_views($bannerID="", $timeconstraint="")
{
    return db_total_stats($GLOBALS["phpAds_tbl_adviews"], "views", $bannerID, $timeconstraint);
}



/*********************************************************/
/* Delete statistics							         */
/*********************************************************/

function db_delete_stats($bannerID)
{
    global $phpAds_tbl_adviews, $phpAds_tbl_adclicks, $phpAds_tbl_adstats;
	
    db_query("DELETE FROM $phpAds_tbl_adviews WHERE bannerID = $bannerID") or mysql_die();
    db_query("DELETE FROM $phpAds_tbl_adclicks WHERE bannerID = $bannerID") or mysql_die();
    db_query("DELETE FROM $phpAds_tbl_adstats WHERE bannerID = $bannerID") or mysql_die();
}



/*********************************************************/
/* Get the host of the client                            */
/*********************************************************/

function phpAds_getClientInformation()
{
	// Get host address and host name
	$addr = isset ($GLOBALS['REMOTE_ADDR']) ? $GLOBALS['REMOTE_ADDR'] : '';
	$host = isset ($GLOBALS['REMOTE_HOST']) ? $GLOBALS['REMOTE_HOST'] : '';
	
	// Lookup host name if needed
	if ($host == '' && $phpAds_reverse_lookup)
		$host = @gethostbyaddr ($addr);
	else
		$host = $addr;
	
	// Check for proxyserver
	$proxy = false;
	if (isset ($GLOBALS['HTTP_VIA']) && $GLOBALS['HTTP_VIA'] != '') $proxy = true;
	if (is_int (strpos ('proxy',   $host))) $proxy = true;
	if (is_int (strpos ('cache',   $host))) $proxy = true;
	if (is_int (strpos ('inktomi', $host))) $proxy = true;
	
	if ($proxy)
	{
		// Overwrite host address if a suitable header is found
		if (isset($GLOBALS['HTTP_FORWARDED']) && 		$GLOBALS['HTTP_FORWARDED'] != '') 		$addr = $GLOBALS['HTTP_FORWARDED'];
		if (isset($GLOBALS['HTTP_FORWARDED_FOR']) &&	$GLOBALS['HTTP_FORWARDED_FOR'] != '') 	$addr = $GLOBALS['HTTP_FORWARDED_FOR'];
		if (isset($GLOBALS['HTTP_X_FORWARDED']) &&		$GLOBALS['HTTP_X_FORWARDED'] != '') 	$addr = $GLOBALS['HTTP_X_FORWARDED'];
		if (isset($GLOBALS['HTTP_X_FORWARDED_FOR']) &&	$GLOBALS['HTTP_X_FORWARDED_FOR'] != '') $addr = $GLOBALS['HTTP_X_FORWARDED_FOR'];
		if (isset($GLOBALS['HTTP_CLIENT_IP']) &&		$GLOBALS['HTTP_CLIENT_IP'] != '') 		$addr = $GLOBALS['HTTP_CLIENT_IP'];
		
		// Get last item from list
		$addrArray = explode (',', $addr);
		$addr = trim($addrArray[sizeof($addrArray) - 1]);
		
		// Perform reverse lookup if needed
		if ($phpAds_reverse_lookup)
			$host = @gethostbyaddr ($addr);
		else
			$host = $addr;
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
