<?// $id:

function db_connect()
{
    if ($GLOBALS["phpAds_persistent_connections"])
        return @mysql_pconnect($GLOBALS["phpAds_hostname"], $GLOBALS["phpAds_mysqluser"], $GLOBALS["phpAds_mysqlpassword"]);
    else
        return @mysql_connect($GLOBALS["phpAds_hostname"], $GLOBALS["phpAds_mysqluser"], $GLOBALS["phpAds_mysqlpassword"]);
}

function db_close()
{
    mysql_close();
}

?>
