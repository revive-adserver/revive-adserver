<?// $Id$

function db_connect()
{
    if ($GLOBALS["phpAds_persistent_connections"])
        return @mysql_pconnect($GLOBALS["phpAds_hostname"], $GLOBALS["phpAds_mysqluser"], $GLOBALS["phpAds_mysqlpassword"]);
    else
        return @mysql_connect($GLOBALS["phpAds_hostname"], $GLOBALS["phpAds_mysqluser"], $GLOBALS["phpAds_mysqlpassword"]);
}

function db_close()
{
//    mysql_close();
}


function db_query($query, $link = "")
{
    global $phpAds_last_query, $phpAds_db;

    $phpAds_last_query = $query;
//    echo "$query<br>";
    return mysql_db_query($phpAds_db, $query);
}

// log a click to the database
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
                when = now()
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
                    when=now(),
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

// log a view to the database
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
                when = now()
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
                    when=now(),
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

function db_total_stats($table, $column, $bannerID)
{
    global $phpAds_tbl_adstats;
    
//    echo "table=$table, column=$column<br>";

    $where = "";
    if (!empty($bannerID)) 
        $where = "WHERE bannerID = $bannerID";
    
    $res = db_query("SELECT count(*) as qnt FROM $table $where") or mysql_die();
    $row = mysql_fetch_array($res);
    $ret = $row["qnt"];

    $res = db_query("SELECT sum($column) as qnt FROM $phpAds_tbl_adstats $where") or mysql_die();
    $row = mysql_fetch_array($res);
    $ret += $row["qnt"];

    return $ret;
}

function db_total_clicks($bannerID="")
{
    return db_total_stats($GLOBALS["phpAds_tbl_adclicks"], "clicks", $bannerID);
}

function db_total_views($bannerID="")
{
    return db_total_stats($GLOBALS["phpAds_tbl_adviews"], "views", $bannerID);
}

function db_delete_stats($bannerID)
{
    db_query("DELETE FROM $phpAds_tbl_adviews WHERE bannerID = $bannerID") or mysql_die();
    db_query("DELETE FROM $phpAds_tbl_adclicks WHERE bannerID = $bannerID") or mysql_die();
    db_query("DELETE FROM $phpAds_tbl_adstats WHERE bannerID = $bannerID") or mysql_die();
}
?>
