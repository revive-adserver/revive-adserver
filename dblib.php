<?php

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/* $Name$ $Revision$													*/
/*                                                                      */
/* Copyright (c) 2001 by Phil Hord				                        */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



/*********************************************************/
/* Open a connection to the database			         */
/*********************************************************/

function db_connect()
{
    if ($GLOBALS["phpAds_persistent_connections"])
        return @mysql_pconnect($GLOBALS["phpAds_hostname"], $GLOBALS["phpAds_mysqluser"], $GLOBALS["phpAds_mysqlpassword"]);
    else
        return @mysql_connect($GLOBALS["phpAds_hostname"], $GLOBALS["phpAds_mysqluser"], $GLOBALS["phpAds_mysqlpassword"]);
}



/*********************************************************/
/* Close the connection to the database			         */
/*********************************************************/

function db_close()
{
	//mysql_close();
}



/*********************************************************/
/* Execute a query								         */
/*********************************************************/

function db_query($query, $link = "")
{
    global $phpAds_last_query, $phpAds_db;
	
    $phpAds_last_query = $query;
    $ret = mysql_db_query($phpAds_db, $query);
	
    return $ret;
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
			$where .= "MONTH(t_stamp) = MONTH(CURDATE())";
		elseif ($timeconstraint == "week")
			$where .= "WEEK(t_stamp) = WEEK(CURDATE()) AND YEAR(t_stamp) = YEAR(CURDATE())";
		else
		    $where .= "DATE_FORMAT(t_stamp, '%Y-%m-%d') = CURDATE()";
	}
	
    $res = db_query("SELECT count(*) as qnt FROM $table $where") or mysql_die();
    if (mysql_num_rows ($res))
    { 
        $row = mysql_fetch_array($res);
        $ret = $row["qnt"];
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
			$where .= "MONTH(day) = MONTH(CURDATE())";
		elseif ($timeconstraint == "week")
			$where .= "WEEK(day) = WEEK(CURDATE()) AND YEAR(day) = YEAR(CURDATE())";
		else
		    $where .= "day = CURDATE()";
	}
	
    $res = db_query("SELECT sum($column) as qnt FROM $phpAds_tbl_adstats $where") or mysql_die();
    if (mysql_num_rows ($res))
    { 
        $row = mysql_fetch_array($res);
        $ret += $row["qnt"];
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

?>
