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
    return mysql_db_query($phpAds_db, $query);
}
?>
