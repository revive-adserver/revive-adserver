<?

require("config.inc.php");
require("dblib.php");
require("nocache.inc.php");

// Load language strings
require("language/$phpAds_language.inc.php");


if (!get_cfg_var ('safe_mode'))
{
	set_time_limit (300);
	ignore_user_abort(1);
}


// Make database connection
db_connect();

// Send Query
$res_clients = db_query("
	SELECT
		clientID,
		clientname,
		contact,
		email,
		views,
		clicks,
		expire,
		UNIX_TIMESTAMP(expire) as expire_st,
		activate,
		UNIX_TIMESTAMP(activate) as activate_st,
		active,
		language
	FROM
		$phpAds_tbl_clients
	") or die($strLogErrorClients);


$i = 0;
$logs = array();
$clients = array();


// PHP3 replacement for substr_count()
// quick hack found at www.php.net by webmaster@lynucs.com
function substr_count2($string,$search) { 
$temp = str_replace($search,$search."a",$string); 
return strlen($temp)-strlen($string); 
}


while($client = mysql_fetch_array($res_clients))
{
	// Process this client
	print "Processing ".$client["clientname"]."...<BR>\n";
	flush();
    
	// Load client language strings
	if ($client["language"] != "")
		include ("language/".$client["language"].".inc.php");
	else
		include ("language/$phpAds_language.inc.php");
	
	
	// Fetch all banners belonging to client   
	$res_banners = db_query("
		SELECT
			bannerID,
			clientID,
			URL,
			active
		FROM
			$phpAds_tbl_banners
		WHERE
			clientID = $client[clientID]
		") or die($strLogErrorBanners);
    
	$log = "____________________________________________________________\n";
	
	while($row_banners = mysql_fetch_array($res_banners))
	{
		$log .= "BannerID: $row_banners[bannerID] [linked to: $row_banners[URL]]\n";
		
		print "<LI>Processing banner $row_banners[bannerID] [linked to: $row_banners[URL]]...<BR>\n";
		flush();
		
		$adviews = db_total_views($row_banners["bannerID"]);
        $client["views_used"] = $adviews;
		$log .= " $strViews (total): $adviews\n";
		
		// Fetch all adviews belonging to banner belonging to client, grouped by day
		if ($phpAds_compact_stats)
            $res_adviews = db_query("
    			SELECT
    				SUM(views) as qnt,
    				DATE_FORMAT(day, '$date_format') as t_stamp_f,
    				TO_DAYS(day) AS the_day
    			FROM
    				$phpAds_tbl_adstats
    			WHERE
    				bannerID = $row_banners[bannerID] AND
                    views > 0
    			GROUP BY
    				day
    			ORDER BY
    				day DESC
    			LIMIT 7
    			") or die($strLogErrorViews);
        else
    		$res_adviews = db_query("
    			SELECT
    				*,
    				count(*) as qnt,
    				DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f,
    				TO_DAYS(t_stamp) AS the_day
    			FROM
    				$phpAds_tbl_adviews
    			WHERE
    				bannerID = $row_banners[bannerID]
    			GROUP BY
    				the_day
    			ORDER BY
    				the_day DESC
    			LIMIT 7
    			") or die($strLogErrorViews);
                           
		while($row_adviews = mysql_fetch_array($res_adviews))
			$log .= "  $row_adviews[t_stamp_f]: $row_adviews[qnt]\n";
        
		// Total adclicks
		$adclicks = db_total_clicks($row_banners["bannerID"]);
		$client["clicks_used"] = $adclicks;
        $log .= " $strClicks (total) : $adclicks\n";                  
		
		// Fetch all adclicks belonging to banner belonging to client, grouped by day
		if ($phpAds_compact_stats)
            $res_adclicks = db_query("
    			SELECT
    				SUM(clicks) as qnt,
    				DATE_FORMAT(day, '$date_format') as t_stamp_f,
    				TO_DAYS(day) AS the_day
    			FROM
    				$phpAds_tbl_adstats
    			WHERE
    				bannerID = $row_banners[bannerID] AND
                    clicks > 0
    			GROUP BY
    				day
    			ORDER BY
    				day DESC
    			LIMIT 7
    			") or die("$strLogErrorClicks ".mysql_error());
        else
            $res_adclicks = db_query("
    			SELECT
    				count(*) as qnt,
    				DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f,
    				TO_DAYS(t_stamp) AS the_day
    			FROM
    				$phpAds_tbl_adclicks
    			WHERE
    				bannerID = $row_banners[bannerID]
    			GROUP BY
    				the_day
    			ORDER BY
    				the_day DESC
    			LIMIT 7
    			") or die("$strLogErrorClicks ".mysql_error());
		while($row_adclicks = mysql_fetch_array($res_adclicks))
			$log .= "  $row_adclicks[t_stamp_f]: $row_adclicks[qnt]\n";
		
		$log .= "____________________________________________________________\n";
	}
	
	
	
	$active = "true";
	
	if ($client["clicks"] == 0 || $client["views"] == 0)
		$active = "false";
	
	if (time() < $client["activate_st"])
		$active = "false";
	
	if (time() > $client["expire_st"] && $client["expire_st"] != 0)
		$active = "false";
	
	if ($client["active"] != $active)
	{
		$client_name = $client["clientname"];
		$client_ID 	 = $client['clientID'];
		
		print "Setting activation to $active $client_name <br><br>";
		$activateresult = db_query("UPDATE $phpAds_tbl_clients SET active='$active' WHERE clientID=$client_ID") or mysql_die ("$strLogErrorDisactivate");
		
		if ($active == "false")
		{
			// Email deactivation warning
			if ($email = $client["email"])
			{
        		$strMailSubject2 =  $strMailSubjectDeleted.": ".$client_name;
				$body = "$strMailHeader\n";
				
				$body .= $strMailClientDeactivated;
				if ($client['clicks'] == 0) 			$body .= ", $strNoMoreClicks";
				if ($client['views'] == 0) 				$body .= ", $strNoMoreViews";
				if (time() < $client["activate_st"])	$body .= ", $strBeforeActivate";
				if (time() > $client["expire_st"] && $client["expire_st"] != 0)
					$body .= ", $strAfterExpire";
				
				$body .= ". $strMailNothingLeft\n\n$strMailFooter";
				mail ($client["email"], $strMailSubject2, $body,$phpAds_admin_email_headers);
				unset ($strMailSubject2) ;
			}
		}
	}
	
	// E-mail Stats to active clients
	if ($email = $client["email"] && $client["active"] == "true")
	{
		$strMailSubject1 =  $strMailSubject.": ".$client["clientname"];
		$body = "$strMailHeader\n$strMailBannerStats\n\n$log\n$strMailFooter";
		mail ($client["email"], $strMailSubject1, $body, $phpAds_admin_email_headers);
		unset ($strMailSubject1) ;
	}
	
	$i++;
}

echo "$strLogMailSent\n";  
?>
