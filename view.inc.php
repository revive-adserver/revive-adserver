<? // $id:

// it's best if we do this only once per load, not every time we call rand.    
mt_srand((double)microtime()*1000000);

require("$phpAds_path/dblib.php"); 

// Get a banner
function get_banner($what, $clientID, $context=0, $source="")
{
	global $phpAds_db, $REMOTE_HOST, $phpAds_tbl_banners, $REMOTE_ADDR, $HTTP_USER_AGENT, $phpAds_con_key, $phpAds_random_retrieve, $phpAds_mult_key;
	$where = "";
	if($context == 0)
		$context = array();
    
	for($i=0; $i<count($context); $i++)
	{
		list($key, $value) = each($context[$i]);
		{
			switch($key)
			{
				case "!=": $exclusive[] = "bannerID <> $value"; break;
				case "==": $inclusive[] = "bannerID = $value"; break;
			}
		}
	}

	$where_exclusive = !empty($exclusive) ? implode(" AND ", $exclusive): "";
	$where_inclusive = !empty($inclusive) ? implode(" OR ", $inclusive): "";

	$where = sprintf("$where_inclusive %s $where_exclusive", (!empty($where_inclusive) && !empty($where_exclusive)) ? "AND": "");

	$where = trim($where);
	if(!empty($where))
		$where .= " AND ";



	// separate parts
	$what_parts = explode ("|",$what);	


	for ($wpc=0;$wpc<sizeof($what_parts);$wpc++)	// build a query and execute for each part
	{
		$select = "
			SELECT
				bannerID,
				banner,
				clientID,
				format,
				width,
				height,
				alt,
				bannertext,
				url,
				weight,
				seq,
				target
			FROM
				$phpAds_tbl_banners 
			WHERE
				$where
				active = 'true' ";

		if($clientID != 0)
			$select .= " AND clientID = $clientID ";

		if (ereg("^[0-9]+$", $what_parts[$wpc]))
		{
			$select .= " AND bannerID = $what_parts[$wpc] ";
		}
    	elseif (ereg("^[0-9]+x[0-9]+$", $what_parts[$wpc]))
    	{
            list($width, $height) = explode("x", $what_parts[$wpc]);
    		// Get all banners with the specified width/height
    		$select .= " AND width = $width AND height = $height ";
    	}
		elseif ($what_parts[$wpc] != "")
		{
			switch($what_parts[$wpc]) 
        	{
			// Get all HTML banners     
			case "html":  
				$select .= " AND format = 'html' ";
				break;

				// Not any of the special words (i.e. 'html'), So, must be a keyword
			default: 
				$select .= " AND (";

					$what_array = explode(",",$what_parts[$wpc]);
				for($k=0; $k<count($what_array); $k++)
				{
					if($phpAds_con_key == "1")
					{
						if(substr($what_array[$k],0,1)=="+" OR substr($what_array[$k],0,1)=="_")
						{
							$what_array[$k]=substr($what_array[$k],1);
							$select=substr($select,0,(strlen($select)-3));
							if($what_array[$k]!="" && $what_array[$k]!=" ")
								$select .= "AND keyword LIKE '%".trim($what_array[$k])."%' OR ";
						}
						elseif(substr($what_array[$k],0,1)=="-")
						{
							$what_array[$k]=substr($what_array[$k],1);
							$select=substr($select,0,(strlen($select)-3));
							$select .= "AND keyword NOT LIKE '%".trim($what_array[$k])."%' OR ";
						}
						else
						{
							if($phpAds_mult_key == "1")
							{
								if($what_array[$k]!="" && $what_array[$k]!=" ")
									$select .= "keyword LIKE '%".trim($what_array[$k])."%' OR ";
							}
							else
								$select .= "keyword = '".trim($what_array[$k])."' OR ";
						}
					}
					else
					{
						if($phpAds_mult_key == "1")
							$select .= "keyword LIKE '%".trim($what_array[$k])."%' OR ";
						else
							$select .= "keyword = '".trim($what_array[$k])."' OR ";
					}
				}

                /*
                The special 'global' keyword allows you to define a banner as global and
                show up under all keywords. I put this in so that if I didn't have any banners 
                for a particular keyword, instead of being blank, it would show one of the global
                banners - Weston Bustraan <weston@infinityteldata.net> 
                */
                if (sizeof($what_parts) == 1)
                {
                    $select .= "keyword = 'global') ";
                }
                else
                {
                    $select .= "0) ";	// Not very nice, but works perfectly :-)
                }
				break;
			} //switch($what_parts[$wpc])
		}

		if($phpAds_random_retrieve != 0)
		{
			$seq_select = $select . " AND seq>0";
			
			// Full sequential retrieval
			if ($phpAds_random_retrieve == 3)
				$seq_select .= " ORDER BY BannerID LIMIT 1";
			
			// First attempt to fetch a banner
			$res = @db_query($seq_select);
			
			if (@mysql_num_rows($res) == 0)
			{
				// No banner left, reset all banners in this category to 'unused', try again below
    			$del_select=strstr($select,'WHERE');
				
				if ($phpAds_random_retrieve == 2)
					// Weight based sequential retrieval
					$delete_select="UPDATE $phpAds_tbl_banners SET seq=weight ".$del_select;
				else
					// Normal sequential retrieval
					$delete_select="UPDATE $phpAds_tbl_banners SET seq=1 ".$del_select;
				
				@db_query($delete_select);
				
				$select = $seq_select;
			}
			else
			{
				// Found banners, continue
				break;
			}
		}

		// Attempt to fetch a banner
		$res = @db_query($select);
		if ($res) 
		{
			if (@mysql_num_rows($res) > 0)	break;	// Found banners, continue
		}

		// No banners found in this part, try again with next part
	}

	if(!$res)
		return(false);

	$rows = array();
	$weightsum = 0;
	while ($tmprow = @mysql_fetch_array($res))
	{
        // weight of 0 disables the banner
        if ($tmprow["weight"])
        {
            $weightsum += $tmprow["weight"];
		    $rows[] = $tmprow; 
	    }
    }

	$date = getdate(time());
	$request = array(
		'remote_host'	=>	$REMOTE_ADDR,
		'user_agent'	=>	$HTTP_USER_AGENT,
		'weekday'	=>	$date['wday'],
		'source'	=>	$source,
		'time'		=>	$date['hours']);


    while ($weightsum && sizeof($rows))
    {
        $low = 0;
        $high = 0;
        $ranweight = ($weightsum>1)?mt_rand(0,$weightsum-1):0;
        for ($i=0; $i<sizeof($rows); $i++)
        {
            $low = $high;
            $high += $rows[$i]["weight"];
            if ($high > $ranweight && $low <= $ranweight)
            {
                $tmprow=$rows[$i];
                if (acl_check($request,$tmprow))
                    return ($tmprow);
                
                // Matched, but acl_check failed.  delete this row and adjust $weightsum
                if (sizeof($rows) == 1)
                    return false;

                $weightsum -= $tmprow["weight"];
                $rows[$i] = array_pop($rows);
                break;                              // break out of the for loop to try again
            }
        }
    }
}

// Mail warning - preset is reached
function warn_mail($warn)
{
	global $phpAds_url_prefix, $phpAds_warn_limit, $phpAds_company_name, $phpAds_warn_admin, $phpAds_warn_client;
	global $phpAds_admin_email, $phpAds_admin_email_headers;
	$clientcontact=$warn["contact"];
	$clientname=$warn["clientname"];
	$strWarnMailSubject = "Ad views/clicks are low at $phpAds_company_name";
	$strWarnAdminTxt = "Click or View count is getting below $phpAds_warn_limit  for $clientname";
	$strWarnClientTxt = "Dear $clientcontact,\n\n Click or View count is getting below $phpAds_warn_limit  for your $clientname banners at $phpAds_company_name.\n\n Please visit $phpAds_url_prefix or reply to this e-mail to renew your subscription.";
	if($phpAds_warn_admin=='1')
		mail($phpAds_admin_email, $strWarnMailSubject, $strWarnAdminTxt, $phpAds_admin_email_headers);
	if($email=$warn["email"])
	{
		if($phpAds_warn_client=='1')
			mail($email, $strWarnMailSubject, $strWarnClientTxt, $phpAds_admin_email_headers);
	}
}

// Log an adview for the banner with $bannerID
function log_adview($bannerID,$clientID)
{
	global $phpAds_log_adviews, $phpAds_ignore_hosts, $phpAds_reverse_lookup, $phpAds_insert_delayed;
	global $row, $phpAds_tbl_banners, $phpAds_tbl_clients, $phpAds_language;
	global $REMOTE_HOST, $REMOTE_ADDR, $phpAds_warn_limit, $phpAds_warn_client, $phpAds_warn_admin;
	global $phpAds_admin_email, $phpAds_admin_email_headers, $phpAds_url_prefix, $strWarnAdminTxt, $strWarnClientTxt;

	// set banner as "used"
	db_query("Update $phpAds_tbl_banners SET seq=seq-1 WHERE bannerID='$bannerID'");

	if(!$phpAds_log_adviews)
		return(false);

	if($phpAds_reverse_lookup)
		$host = isset($REMOTE_HOST) ? $REMOTE_HOST : @gethostbyaddr($REMOTE_ADDR);
	else
		$host = $REMOTE_ADDR;

	// Check if host is on list of hosts to ignore

	$found = 0;
	while(($found == 0) && (list($key, $ignore_host)=each($phpAds_ignore_hosts))) 
	{
		if(eregi($ignore_host, $host)) // host found in ignore list
			$found = 1;
	}

	if($found == 0)
	{ 
		$res = @db_log_view($bannerID, $host);
		
		// Decrement views
		$currentview=db_query("SELECT * FROM $phpAds_tbl_clients WHERE clientID=$clientID and views > 0");
		if($viewcount=mysql_fetch_array($currentview))
		{
			$viewcount["views"]=$viewcount["views"]-1;
			
			// Mail warning - preset is reached
			if($viewcount["views"]==$phpAds_warn_limit)
				warn_mail($viewcount);
			
			db_query("UPDATE $phpAds_tbl_clients SET views=views-1 WHERE clientID=$clientID");
			
			// Check view count and de-activate banner if needed
			if($viewcount["views"]==0)
				db_query("UPDATE $phpAds_tbl_banners SET active='false' WHERE clientID=$clientID");
		}
	}
}

// Java-encodes text for use with (remote) javascript tags
function enjavanate($str)
{
	$lines = explode("\n", $str);
	
	reset ($lines);
	while (list(,$line) = each($lines))
	{
        $line = str_replace("\r", "", $line);
        $line = str_replace("'", "\\'", $line);
        if (!empty($line))
            print "document.writeln('$line');\n";
	}
}


function view_raw($what, $clientID=0, $target="", $source="", $withtext=0, $context=0)
{
    global $phpAds_db, $REMOTE_HOST;

	if(!ereg("^[0-9]+$", $clientID))
	{
		$target = $clientID;
		$clientID = 0;
	}

	db_connect();
    $row = get_banner($what, $clientID, $context, $source);

	$outputbuffer = "";
	
	if(!empty($row["bannerID"])) 
	{
		if(!empty($target))
		{
			if(strstr($target,'+'))
			{
				if($row["target"]!="")
					$target=$row["target"];
				else
					$target=substr($target,1);
			}
			$target = " target=\"$target\"";
		}
		if($row["format"] == "html")
		{
			if(!empty($row["url"])) 
			{
				$outputbuffer .= "<a href=\"$GLOBALS[phpAds_url_prefix]/click.php?bannerID=$row[bannerID]\"$target>";
                $outputbuffer .= $row["banner"];
			} else
			{
				$lowerbanner=strtolower($row["banner"]);
				$hrefpos=strpos($lowerbanner,"href=");
				while ($hrefpos > 0)
				{
					$hrefpos=$hrefpos+5;
					$quotepos=strpos($lowerbanner,"\"",$hrefpos);
					if ($quotepos > 0)
					{
						$endquotepos=strpos($lowerbanner,"\"",$quotepos+1);
						$newbanner=$newbanner.substr($row["banner"],$prevhrefpos,$hrefpos-$prevhrefpos)."\"$GLOBALS[phpAds_url_prefix]/htmlclick.php?bannerID=$row[bannerID]&dest=".urlencode(substr($row["banner"],$quotepos+1,$endquotepos-$quotepos-1));
						$prevhrefpos=$hrefpos+($endquotepos-$quotepos);
					} else
					{
						$spacepos=strpos($lowerbanner," ",$hrefpos+1);
						$endtagpos=strpos($lowerbanner,">",$hrefpos+1);
						if ($spacepos<$endtagpos) $endpos=$spacepos; else $endpos=$endtagpos;
 						$newbanner=$newbanner.substr($row["banner"],$prevhrefpos,$hrefpos-$prevhrefpos)."\"$GLOBALS[phpAds_url_prefix]/htmlclick.php?bannerID=$row[bannerID]&dest=".urlencode(substr($row["banner"],$hrefpos,$endpos-$hrefpos))."\"";
						$prevhrefpos=$hrefpos+($endpos-$hrefpos);
					}
					$hrefpos=strpos($lowerbanner,"href=",$hrefpos+1);
				}
				$newbanner=$newbanner.substr($row["banner"],$prevhrefpos);
				$outputbuffer .= $newbanner;
			}
			if(!empty($row["url"])) 
				$outputbuffer .= "</a>";
		}
		else
		{
			if (empty($row["url"]))
			{
				if ($row["format"] == "url")	// patch for ie bug
					$outputbuffer .= "<img src=\"$row[banner]\" width=$row[width] height=$row[height] alt=\"$row[alt]\" border=0>";
    			else
					$outputbuffer .= "<img src=\"$GLOBALS[phpAds_url_prefix]/viewbanner.php?bannerID=$row[bannerID]\" width=$row[width] height=$row[height] alt=\"$row[alt]\" border=0>";
			}
			else
			{
				if ($row["format"] == "url")	// patch for ie bug
					$outputbuffer .= "<a href=\"$GLOBALS[phpAds_url_prefix]/click.php?bannerID=$row[bannerID]\"$target><img src=\"$row[banner]\" width=$row[width] height=$row[height] alt=\"$row[alt]\" border=0></a>";
				else
					$outputbuffer .= "<a href=\"$GLOBALS[phpAds_url_prefix]/click.php?bannerID=$row[bannerID]\"$target><img src=\"$GLOBALS[phpAds_url_prefix]/viewbanner.php?bannerID=$row[bannerID]\" width=$row[width] height=$row[height] alt=\"$row[alt]\" border=0></a>";
			}
			if($withtext && !empty($row["bannertext"]))
				$outputbuffer .= "<BR>\n<a href=\"$GLOBALS[phpAds_url_prefix]/click.php?bannerID=$row[bannerID]\"$target>".$row["bannertext"]."</a>";
		}
		if(!empty($row["bannerID"]))
			log_adview($row["bannerID"],$row["clientID"]);
	}
    db_close();
	
	return( array("html" => $outputbuffer, 
				  "bannerID" => $row["bannerID"])
		  );
}

function view_t($what, $target="")
{
	view ($what, $target, 1);
}

function view($what, $clientID=0, $target="", $source="", $withtext=0, $context=0)
{
	$output = view_raw($what, $clientID, "$target", "$source", $withtext, $context);
	print($output["html"]);
	return($output["bannerID"]);
}

function view_js($what, $clientID=0, $target="", $source="", $withtext=0, $context=0)
{
	$output = view_raw($what, $clientID, "$target", "$source", $withtext, $context);
	
	enjavanate($output["html"]);
	return($output["bannerID"]);
}

?>
