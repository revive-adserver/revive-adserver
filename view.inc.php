<?

// Get a banner
function get_banner($what, $clientID, $context=0, $source="")
{
    global $phpAds_db, $REMOTE_HOST, $phpAds_tbl_banners, $REMOTE_ADDR, $HTTP_USER_AGENT,$phpAds_con_key, $phpAds_random_retrieve,$phpAds_mult_key;
    $where = "";
    if($context == 0)
    {
        $context = array();
    }
    
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
    {
        $where .= " AND ";
    }        

    $select = "SELECT 
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
    {
        $select .= " AND clientID = $clientID ";
    }                  
    
    if(is_string($what) && !ereg("[0-9]x[0-9]", $what))
    {
        switch($what) 
        {
            // Get all HTML banners     
            case "html":  
                    $select .= " AND format = 'html' ";
                    break;

            //Not any of the special words (i.e. 'html'), So, must be a keyword
            default: 
                $select .= " AND (";
                
                $what_array = explode(",",$what);
                for($k=0; $k<count($what_array); $k++)
                {
                    if($phpAds_random_retrieve == "1")
                    {
                       if(substr($what_array[$k],0,1)=="+" OR substr($what_array[$k],0,1)=="_")
                       {
                          $what_array[$k]=substr($what_array[$k],1);
                          $select=substr($select,0,(strlen($select)-3));
                          if($what_array[$k]!="" && $what_array[$k]!=" ")
                          {
                             $select .= "AND keyword LIKE '%".trim($what_array[$k])."%' OR ";
                          }
                       }
                       elseif(substr($what_array[$k],0,1)=="-")
                       {
                          $what_array[$k]=substr($what_array[$k],1);
                          $select=substr($select,0,(strlen($select)-3));
                          $select .= "keyword LIKE '%".trim($what_array[$k])."%' OR ";
                       }
                       else
                       {
                          if($phpAds_mult_key == "1")
                          {
                             if($what_array[$k]!="" && $what_array[$k]!=" ")
                             {
                                $select .= "keyword LIKE '%".trim($what_array[$k])."%' OR ";
                             }
                          }
                          else
                          {
                             $select .= "keyword = '".trim($what_array[$k])."' OR ";
                          }
                       }
                    }
                    else
                    {
                       if($phpAds_mult_key == "1")
                       {
                          $select .= "keyword LIKE '%".trim($what_array[$k])."%' OR ";
                       }
                       else
                       {
                          $select .= "keyword = '".trim($what_array[$k])."' OR ";
                       }
                   }
                             
                }

                /*
                The special 'global' keyword allows you to define a banner as global and
                show up under all keywords. I put this in so that if I didn't have any banners 
                for a particular keyword, instead of being blank, it would show one of the global
                banners - Weston Bustraan <weston@infinityteldata.net> 
                */                
                $select .= "keyword = 'global') ";

        } //switch($what)
    } 
    elseif(is_int($what))
    {
        $select .= " AND bannerID = $what ";
    }
    else
    {
        list($width, $height) = explode("x", $what);
        // Get all banners with the specified width/height
        $select .= " AND width = $width 
                    AND height = $height ";
    }


    if($phpAds_random_retrieve == "1") // Test to see if there are any banners left in that category
    {
       $testselect ="$select AND seq!='1'";
       $testres = @mysql_db_query($phpAds_db, $testselect);
       if(!$testrow = @mysql_fetch_array($testres)) // If no banners left then reset all banners in that category to "unused"
       {
          $del_select=strstr($select,'WHERE');
          $delete_select="UPDATE $phpAds_tbl_banners SET seq='' ".$del_select;
          mysql_db_query($phpAds_db, $delete_select);
       }
       $select .=" AND seq!='1'";
    }

    // print($select);
    $res = @mysql_db_query($phpAds_db, $select);
    if(!$res)
        return(false);
    $rows = array();
    $weighttable = array();
    $weightsum = 0;
    while ($tmprow = @mysql_fetch_array($res)) {
	for ($i = $weightsum; $i < ($weightsum + $tmprow["weight"]); $i++) {
           $weighttable[$i] = sizeof($rows);
        }
	$weightsum = $weightsum + $tmprow["weight"];
   	$rows[] = $tmprow; 
    }


    $date = getdate(time());
    $request = array('remote_host'	=> 	$REMOTE_ADDR,
		     'user_agent'	=>	$HTTP_USER_AGENT,
		     'weekday'		=>	$date['wday'],
                     'source'           =>      $source,
                     'time'             =>      $date['hours']);

    srand((double)microtime()*1000000);
    if ($weightsum > 0)
    {
	if ($weightsum == 1)
	{
		$ranweight=0;
	} else
	{
		$weightsum--;
    		$ranweight = rand(0,$weightsum);
	}
    } else
    {
	return($rows[0]);
    }
    for ($i=0;$i<$weightsum;$i++)
    {
        $tmprow=$rows[$weighttable[$ranweight]];
        if (acl_check($request,$tmprow))
        {
            return ($tmprow);
        } else
        {
            unset($weighttable[$ranweight]);
            $weightsum--;
            $ranweight = rand(0,$weightsum);
        }
    }
}

// Mail warnning - preset is reached
function warn_mail($warn){
    global $phpAds_url_prefix, $phpAds_warn_limit, $phpAds_company_name, $phpAds_warn_admin, $phpAds_warn_client;
    global $phpAds_admin_email, $phpAds_admin_email_headers;
    $clientcontact=$warn["contact"];
    $clientname=$warn["clientname"];
    $strWarnMailSubject = "Ad views/clicks are low at $phpAds_company_name";
    $strWarnAdminTxt = "Click or View count is getting below $phpAds_warn_limit  for $clientname";
    $strWarnClientTxt = "Dear $clientcontact,\n\n Click or View count is getting below $phpAds_warn_limit  for your $clientname banners at $phpAds_company_name.\n\n Please visit $phpAds_url_prefix or reply to this e-mail to renew your subscription.";
    if($phpAds_warn_admin=='1')
    {
        mail($phpAds_admin_email, $strWarnMailSubject, $strWarnAdminTxt, $phpAds_admin_email_headers);
    }
    if($email=$warn["email"])
    {
        if($phpAds_warn_client=='1')
        {
            mail($email, $strWarnMailSubject, $strWarnClientTxt, $phpAds_admin_email_headers);
        }
    }
}

// Log an adview for the banner with $bannerID
function log_adview($bannerID,$clientID)
{
    global $phpAds_log_adviews, $phpAds_ignore_hosts, $phpAds_reverse_lookup, $phpAds_insert_delayed;
    global $row, $phpAds_tbl_adviews, $phpAds_tbl_banners, $phpAds_tbl_clients, $phpAds_language;
    global $REMOTE_HOST, $REMOTE_ADDR, $phpAds_warn_limit, $phpAds_warn_client, $phpAds_warn_admin;
    global $phpAds_admin_email, $phpAds_admin_email_headers, $phpAds_url_prefix, $strWarnAdminTxt, $strWarnClientTxt;

    // set banner as "used"
    mysql_db_query($GLOBALS["phpAds_db"], "Update $phpAds_tbl_banners SET seq='1' WHERE bannerID='$bannerID'");


    if(!$phpAds_log_adviews)
    {
        return(false);
    }

// Decrement views

    $currentview=mysql_db_query($GLOBALS["phpAds_db"], "SELECT * FROM $phpAds_tbl_clients WHERE clientID=$clientID and views > 0");
    if($viewcount=mysql_fetch_array($currentview))
    {
        $viewcount["views"]=$viewcount["views"]-1;

// Mail warning - preset is reached
        if($viewcount["views"]==$phpAds_warn_limit)
        {
            warn_mail($viewcount);
        }
        mysql_db_query($GLOBALS["phpAds_db"], "UPDATE $phpAds_tbl_clients SET views=$viewcount[views] WHERE clientID=$clientID");
// Check view count and de-activate banner if needed
        if($viewcount["views"]==0 && $viewcount["clicks"]==0)
        {
            mysql_db_query($GLOBALS["phpAds_db"], "UPDATE $phpAds_tbl_banners SET active='false' WHERE clientID=$clientID");
        }
    }


    if($phpAds_reverse_lookup)
    {
        $host = isset($REMOTE_HOST) ? $REMOTE_HOST : @gethostbyaddr($REMOTE_ADDR);
    }
    else
    {
       $host = $REMOTE_ADDR;
    }

    // Check if host is on list of hosts to ignore

    $found = 0;
    while(($found == 0) && (list($key, $ignore_host)=each($phpAds_ignore_hosts))) 
    {
        if(eregi($ignore_host, $host)) // host found in ignore list
        {
            $found = 1;
        }
    }

    if($found == 0)
    { 
        $res = @mysql_db_query($GLOBALS["phpAds_db"], sprintf("
          INSERT %s
          
            INTO $phpAds_tbl_adviews
          VALUES
            (
            '$bannerID',
            null,
            '$host'
            )
            ", $phpAds_insert_delayed ? "DELAYED": "")); 
    }
}

// view a banner 
function view($what, $clientID=0, $target = "", $source = "", $withtext=0, $context=0)
{
    global $phpAds_db, $REMOTE_HOST;

    if(!is_int($clientID))
    {
        $target = $clientID;
        $clientID = 0;
    }

    @mysql_pconnect($GLOBALS["phpAds_hostname"], $GLOBALS["phpAds_mysqluser"], $GLOBALS["phpAds_mysqlpassword"]);
    $row = get_banner($what, $clientID, $context, $source);

    if(!empty($row["bannerID"])) 
    {
        if(!empty($target))
        {
            if(strstr($target,'+'))
            {
                if($row["target"]!="")
                {
                    $target=$row["target"];
                }
                else
                {
                    $target=substr($target,1);
                }
            }
            $target = " target=\"$target\"";
        }

        if($row["format"] == "html")
        {
            if(!empty($row["url"])) 
            {
                echo "<a href=\"$GLOBALS[phpAds_url_prefix]/click.php?bannerID=$row[bannerID]\"$target>";
                echo $row["banner"];
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
                print $newbanner;
            }
            if(!empty($row["url"])) 
            {
                echo "</a>";
            }
        }
        else
        {

            echo "<a href=\"$GLOBALS[phpAds_url_prefix]/click.php?bannerID=$row[bannerID]\"$target><img src=\"$GLOBALS[phpAds_url_prefix]/viewbanner.php?bannerID=$row[bannerID]\" width=$row[width] height=$row[height] alt=\"$row[alt]\" border=0></a>";
    
            if($withtext && !empty($row["bannertext"]))
            {
                echo "<BR>\n<a href=\"$GLOBALS[phpAds_url_prefix]/click.php?bannerID=$row[bannerID]\"$target>".$row["bannertext"]."</a>";
            }        
        }
        if(!empty($row["bannerID"]))
        {
            log_adview($row["bannerID"],$row["clientID"]);
        }
    }

    return($row["bannerID"]);
}

function view_t($what, $target = "")
{
    view ($what, $target, 1);
}

?>
