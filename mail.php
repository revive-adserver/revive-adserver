<?
require ("config.php");

$res_clients = mysql_db_query($phpAds_db, "
          SELECT
            clientID,
            clientname,
            contact,
            email,
            views,
            clicks,
            to_days(expire) as expire_day,
            to_days(curdate()) as cur_date 
          FROM
            $phpAds_tbl_clients
          ") or die($strLogErrorClients);
$i = 0;
$logs = array();
$clients = array();

while($row_clients = mysql_fetch_array($res_clients))
{
    $clients[$i] = array();
    $clients[$i]["clientID"] = $row_clients["clientID"];      
    $clients[$i]["email"] = $row_clients["email"];
    $clients[$i]["contact"] = $row_clients["contact"];
    $clients[$i]["clientname"] = $row_clients["clientname"];      
    $clients[$i]["views"] = $row_clients["views"];
    $clients[$i]["days"] = $row_clients["expire_day"] ? $row_clients["expire_day"] - $row_clients["cur_date"] : '';
    $clients[$i]["active"] = true;
    
    // Fetch all banners belonging to client   
    $res_banners = mysql_db_query($phpAds_db, "
                    SELECT
                      bannerID,
                      clientID,
                      URL,
                      active
                    FROM
                      $phpAds_tbl_banners
                    WHERE
                      clientID = $row_clients[clientID]
                    ") or die($strLogErrorBanners);
    
    $logs[$i] = "";
    while($row_banners = mysql_fetch_array($res_banners))
    {
        if($row_banners["active"] == "false")
        {
            $clients[$i]["active"] = false;
        }
        
        $logs[$i] .= "BannerID: $row_banners[bannerID] [linked to: $row_banners[URL]]\n";

        // Total adviews
        $res_adviews = mysql_db_query($phpAds_db, "
                           SELECT
                             count(*) as qnt
                           FROM
                             $phpAds_tbl_adviews
                           WHERE
                             bannerID = $row_banners[bannerID]
                           ") or die($strLogErrorViews);
        $row_adviews = mysql_fetch_array($res_adviews);
        $clients[$i]["views_used"] = $row_adviews["qnt"];    
        $logs[$i] .= " $strViews: $row_adviews[qnt] total\n";

        // Fetch all adviews belonging to banner belonging to client, grouped by day
        $res_adviews = mysql_db_query($phpAds_db, "
                           SELECT
                             *,
                             count(*) as qnt,
                             DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f
                           FROM
                             $phpAds_tbl_adviews
                           WHERE
                             bannerID = $row_banners[bannerID]
                           GROUP BY
                             t_stamp_f  
                           ORDER BY t_stamp DESC
                           LIMIT 7
                           ") or die($strLogErrorViews);
                           
        while($row_adviews = mysql_fetch_array($res_adviews))
        {
            $logs[$i] .= "  $row_adviews[t_stamp_f]: $row_adviews[qnt]\n";
        }
        
        // Total adclicks
        $res_adclicks = mysql_db_query($phpAds_db, "
                           SELECT
                             count(*) as qnt
                           FROM
                             $phpAds_tbl_adclicks
                           WHERE
                             bannerID = $row_banners[bannerID]
                           ") or die("$strLogErrorViews ".mysql_error());
        $row_adclicks = mysql_fetch_array($res_adclicks);                  
        $clients[$i]["clicks_used"] = $row_adclicks["qnt"];
      
        $logs[$i] .= " $strClicks: $row_adclicks[qnt] total\n";                  
            
        // Fetch all adclicks belonging to banner belonging to client, grouped by day
        $res_adclicks = mysql_db_query($phpAds_db, "
                           SELECT
                             *,
                             count(*) as qnt,
                             DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f
                           FROM
                             $phpAds_tbl_adclicks
                           WHERE
                             bannerID = $row_banners[bannerID]
                           GROUP BY
                             t_stamp_f  
                           ORDER BY t_stamp DESC
                           LIMIT 7
                           ") or die("$strLogErrorClicks ".mysql_error());
        while($row_adclicks = mysql_fetch_array($res_adclicks))
        {
            $logs[$i] .= "  $row_adclicks[t_stamp_f]: $row_adclicks[qnt]\n";
        }
        
        $logs[$i] .= "____________________________________________________________\n";                  
    }

    $i++;
}
    
for($i=0; $i<count($logs); $i++)
{
    if($clients[$i]["active"] == false)
    {
        continue;
    }
    
    // Check if the client has remaining adviews
    if((!empty($clients[$i]["views"]) && $clients[$i]["views"] < $clients[$i]["views_used"]) || 
       (!empty($clients[$i]["clicks"])  && $clients[$i]["clicks"] < $clients[$i]["clicks_used"]) ||
       (isset($clients[$i]["days"])  && $clients[$i]["days"] <= 0))
    {
        $client_name = $clients[$i]["clientname"];
        unset ($client_ID);
        $client_ID = $clients[$i]['clientID'];
        $result = mysql_db_query($phpAds_db,"
                UPDATE
                  $phpAds_tbl_banners
                SET
                  active = 'false'
                WHERE
                  clientID = $client_ID
        ") or mysql_die ("$strLogErrorDisactivate");
        
        $strMailSubject2 =  $strMailSubjectDeleted;
        $strMailSubject2 .=  ": ";
        $strMailSubject2 .= $client_name;
        eval("\$body = \"$strMailHeader\n$strMailNothingLeft\n\n$strMailFooter\";");
        mail($clients[$i]["email"], $strMailSubject2, $body,$phpAds_admin_email_headers);
        unset($strMailSubject2 ) ;
    }
    
    eval("\$body = \"$strMailHeader\n$strMailBannerStats\n\n\$logs[$i]\n$strMailFooter\";");
	$strMailSubject1 =  $strMailSubject ;
	$strMailSubject1 .= ": ";
	$strMailSubject1 .= $clients[$i]["clientname"];
    mail($clients[$i]["email"], $strMailSubject1, $body, $phpAds_admin_email_headers);
	unset ($strMailSubject1 ) ;
}

echo "$strLogMailSent\n";  
?>
