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



// Include required files
require ("$phpAds_path/dblib.php"); 
require ("$phpAds_path/lib-expire.inc.php");

// Seed the random number generator
mt_srand((double)microtime()*1000000);



/*********************************************************/
/* Build the SQL query needed to fetch the banners       */
/*********************************************************/

function phpAds_buildQuery ($what, $clientID, $context=0, $source="")
{


}



/*********************************************************/
/* Get a banner						                     */
/*********************************************************/

function get_banner($what, $clientID, $context=0, $source="")
{
	global $phpAds_db, $REMOTE_HOST, $phpAds_tbl_banners, $REMOTE_ADDR, $HTTP_USER_AGENT, $phpAds_con_key;
	global $phpAds_random_retrieve, $phpAds_mult_key, $phpAds_tbl_clients;
	
	$where = "";
	if($context == 0)
		$context = array();
    
	for($i=0; $i<count($context); $i++)
	{
		list($key, $value) = each($context[$i]);
		{
			switch($key)
			{
				case "!=": $exclusive[] = "b.bannerID <> $value"; break;
				case "==": $inclusive[] = "b.bannerID = $value"; break;
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
				$phpAds_tbl_banners.bannerID as bannerID,
				$phpAds_tbl_banners.banner as banner,
				$phpAds_tbl_banners.clientID as clientID,
				$phpAds_tbl_banners.format as format,
				$phpAds_tbl_banners.width as width,
				$phpAds_tbl_banners.height as height,
				$phpAds_tbl_banners.alt as alt,
				$phpAds_tbl_banners.bannertext as bannertext,
				$phpAds_tbl_banners.url as url,
				$phpAds_tbl_banners.weight as weight,
				$phpAds_tbl_banners.seq as seq,
				$phpAds_tbl_banners.target as target,
				$phpAds_tbl_clients.weight as clientweight
			FROM
				$phpAds_tbl_banners,
				$phpAds_tbl_clients
			WHERE
				$phpAds_tbl_banners.active = 'true' AND 
				$phpAds_tbl_clients.active = 'true' AND 
				$where
				$phpAds_tbl_banners.clientID = $phpAds_tbl_clients.clientID";
		
		if($clientID != 0)
			$select .= " AND $phpAds_tbl_banners.clientID = $clientID ";
		
		
		// Rule
		if(substr($what_parts[$wpc],0,5)=="zone:")
		{
			// Not yet implemented
			// working on it --Niels
			$select .= " AND (FETCH FROM DATABASE) ";
		}
		
		// Other
		elseif ($what_parts[$wpc] != "")
		{
			$conditions = "";
			$onlykeywords = true;
			
			$what_array = explode(",",$what_parts[$wpc]);
			for ($k=0; $k < count($what_array); $k++)
			{
				// Process switches
				if($phpAds_con_key == "1")
				{
					if(substr($what_array[$k],0,1)=="+" OR substr($what_array[$k],0,1)=="_")
					{
						$operator = "AND";
						$what_array[$k]=substr($what_array[$k],1);
					}
					elseif(substr($what_array[$k],0,1)=="-")
					{
						$operator = "NOT";
						$what_array[$k]=substr($what_array[$k],1);
					}
					else
						$operator = "OR";
				}
				else
					$operator = "OR";
				
				
				//	Test statements
				if($what_array[$k] != "" && $what_array[$k] != " ")
				{
					// Banner dimensions
					if(ereg("^[0-9]+x[0-9]+$", $what_array[$k]))
					{
						list($width, $height) = explode("x", $what_array[$k]);
							
						if ($operator == "OR")
							$conditions .= "OR ($phpAds_tbl_banners.width = $width AND $phpAds_tbl_banners.height = $height) ";
						elseif ($operator == "AND")
							$conditions .= "AND ($phpAds_tbl_banners.width = $width AND $phpAds_tbl_banners.height = $height) ";
						else
							$conditions .= "AND ($phpAds_tbl_banners.width != $width OR $phpAds_tbl_banners.height != $height) ";
						
						$onlykeywords = false;
					}
					
					// Banner ID
					elseif((substr($what_array[$k],0,9)=="bannerid:") or (ereg("^[0-9]+$", $what_array[$k])))
					{
						if (substr($what_array[$k],0,9)=="bannerid:") 
							$what_array[$k]=substr($what_array[$k],9);
							
						if ($what_array[$k] != "" && $what_array[$k] != " ")
						{
							if ($operator == "OR")
								$conditions .= "OR $phpAds_tbl_banners.bannerID='".trim($what_array[$k])."' ";
							elseif ($operator == "AND")
								$conditions .= "AND $phpAds_tbl_banners.bannerID='".trim($what_array[$k])."' ";
							else
								$conditions .= "AND $phpAds_tbl_banners.bannerID!='".trim($what_array[$k])."' ";
						}
						
						$onlykeywords = false;
					}
					
					// Client ID
					elseif(substr($what_array[$k],0,9)=="clientid:")
					{
						$what_array[$k]=substr($what_array[$k],9);
						if($what_array[$k]!="" && $what_array[$k]!=" ")
						{
							if ($operator == "OR")
								$conditions .= "OR $phpAds_tbl_banners.clientID='".trim($what_array[$k])."' ";
							elseif ($operator == "AND")
								$conditions .= "AND $phpAds_tbl_banners.clientID='".trim($what_array[$k])."' ";
							else
								$conditions .= "AND $phpAds_tbl_banners.clientID!='".trim($what_array[$k])."' ";
						}
						
						$onlykeywords = false;
					}
					
					// Format
					elseif(substr($what_array[$k],0,7)=="format:")
					{
						$what_array[$k]=substr($what_array[$k],7);
						if($what_array[$k]!="" && $what_array[$k]!=" ")
						{
							if ($operator == "OR")
								$conditions .= "OR $phpAds_tbl_banners.format='".trim($what_array[$k])."' ";
							elseif ($operator == "AND")
								$conditions .= "AND $phpAds_tbl_banners.format='".trim($what_array[$k])."' ";
							else
								$conditions .= "AND $phpAds_tbl_banners.format!='".trim($what_array[$k])."' ";
						}
						
						$onlykeywords = false;
					}
					
					// HTML
					elseif($what_array[$k] == "html")
					{
						if ($operator == "OR")
							$conditions .= "OR $phpAds_tbl_banners.format='html' ";
						elseif ($operator == "AND")
							$conditions .= "AND $phpAds_tbl_banners.format='html' ";
						else
							$conditions .= "AND $phpAds_tbl_banners.format!='html' ";
						
						$onlykeywords = false;
					}
					
					// Keywords
					else
					{
						if($phpAds_mult_key != "1")
							if ($operator == "OR")
								$conditions .= "OR $phpAds_tbl_banners.keyword = '".trim($what_array[$k])."' ";
							elseif ($operator == "AND")
								$conditions .= "AND $phpAds_tbl_banners.keyword = '".trim($what_array[$k])."' ";
							else
								$conditions .= "AND $phpAds_tbl_banners.keyword != '".trim($what_array[$k])."' ";
						else
							if ($operator == "OR")
								$conditions .= "OR $phpAds_tbl_banners.keyword LIKE '%".trim($what_array[$k])."%' ";
							elseif ($operator == "AND")
								$conditions .= "AND $phpAds_tbl_banners.keyword LIKE '%".trim($what_array[$k])."%' ";
							else
								$conditions .= "AND $phpAds_tbl_banners.keyword NOT LIKE '%".trim($what_array[$k])."%' ";
					}
				}
			}
			
			// Strip first AND or OR from $conditions
			$conditions = strstr($conditions, " ");
			
			// Add global keyword
			if (sizeof($what_parts) == 1 && $onlykeywords == true)
	        {
	        	$conditions .= "OR $phpAds_tbl_banners.keyword = 'global' ";
    	  	}
			
			// Add conditions to select
			if ($conditions != "") $select .= 	" AND (" . $conditions . ") ";
		}
		
		//echo $select."<br>";
		
		if($phpAds_random_retrieve != 0)
		{
			$seq_select = $select . " AND $phpAds_tbl_banners.seq>0";
			
			// Full sequential retrieval
			if ($phpAds_random_retrieve == 3)
				$seq_select .= " ORDER BY $phpAds_tbl_banners.bannerID LIMIT 1";
			
			// First attempt to fetch a banner
			$res = @db_query($seq_select);
			
			if (@mysql_num_rows($res) == 0)
			{
				// No banner left, reset all banners in this category to 'unused', try again below
				if (isset($conditions) && $conditions != "")
					$del_select = "WHERE $conditions";
				else
					$del_select = "";
				
				if ($phpAds_random_retrieve == 2)
					// Weight based sequential retrieval
					$delete_select="UPDATE $phpAds_tbl_banners SET $phpAds_tbl_banners.seq=$phpAds_tbl_banners.weight ".$del_select;
				else
					// Normal sequential retrieval
					$delete_select="UPDATE $phpAds_tbl_banners SET $phpAds_tbl_banners.seq=1 ".$del_select;
				
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
            $weightsum += ($tmprow["weight"] * $tmprow["clientweight"]);
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
            $high += ($rows[$i]["weight"] * $rows[$i]["clientweight"]);
            
			if ($high > $ranweight && $low <= $ranweight)
            {
				if ($phpAds_acl = '1')
				{
					$tmprow=$rows[$i];
	                if (acl_check($request,$tmprow))
	                    return ($tmprow);
	                
	                // Matched, but acl_check failed.  delete this row and adjust $weightsum
	                if (sizeof($rows) == 1)
	                    return false;
					
	                $weightsum -= $tmprow["weight"];
	                $rows[$i] = array_pop($rows);
					
					// break out of the for loop to try again
	                break;
				}
				else
				{
					return ($row[$i]);
				}
            }
        }
    }
}



/*********************************************************/
/* Mail warning - preset is reached						 */
/*********************************************************/

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



/*********************************************************/
/* Log an adview for the banner with $bannerID			 */
/*********************************************************/

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
	
	if($host = phpads_ignore_host())
	{ 
		$res = @db_log_view($bannerID, $host);
		phpAds_expire ($clientID, phpAds_Views);
	}
}



/*********************************************************/
/* Java-encodes text									 */
/*********************************************************/

function enjavanate($str)
{
	$lines = explode("\n", $str);
	
	reset ($lines);

	$i = 0;
    while (list(,$line) = each($lines))
	{
        $line = str_replace("\r", "", $line);
        $line = str_replace("'", "\\'", $line);
        
    	if (!empty($line))
    	{
            if ($i++)
                print "document.writeln('');\n";
            print "document.write('$line');\n";
        }
	}
}



/*********************************************************/
/* Create the HTML needed to display the banner			 */
/*********************************************************/

function view_raw($what, $clientID=0, $target="", $source="", $withtext=0, $context=0)
{
    global $phpAds_db, $REMOTE_HOST, $phpAds_url_prefix;
	global $phpAds_default_banner_url, $phpAds_default_banner_target;

	if(!ereg("^[0-9]+$", $clientID))
	{
		$target = $clientID;
		$clientID = 0;
	}

	db_connect();
    $row = get_banner($what, $clientID, $context, $source);

	$outputbuffer = "";
	
	if (is_array($row))
	{
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
				// HTML banner
				$html = stripslashes($row["banner"]);
				$html = str_replace ("{timestamp}", time(), $html);
				
				if(!empty($row["url"])) 
				{
					if (strpos ($html, "{targeturl}") > 0)
					{
						$outputbuffer .= str_replace ("{targeturl}", urlencode("$phpAds_url_prefix/click.php?bannerID=".$row['bannerID']), $html);
					}
					else
					{
						$outputbuffer .= "<a href='$phpAds_url_prefix/click.php?bannerID=".$row['bannerID']."'".$target.">";
		                $outputbuffer .= $html;
					}
				} 
				else
				{
					$newbanner	 = '';
					$prevhrefpos = '';
					
					$lowerbanner = strtolower($html);
					$hrefpos	 = strpos($lowerbanner,"href=");
					
					while ($hrefpos > 0)
					{
						$hrefpos = $hrefpos + 5;
						$doublequotepos = strpos($lowerbanner, '"', $hrefpos);
						$singlequotepos = strpos($lowerbanner, "'", $hrefpos);
						
						if ($doublequotepos > 0 && $singlequotepos > 0)
						{
							if ($doublequotepos < $singlequotepos)
							{
								$quotepos  = $doublequotepos;
								$quotechar = '"';
							}
							else
							{
								$quotepos  = $singlequotepos;
								$quotechar = "'";
							}
						}
						else
						{
							if ($doublequotepos > 0)
							{
								$quotepos  = $doublequotepos;
								$quotechar = '"';
							}
							elseif ($singlequotepos > 0)
							{
								$quotepos  = $singlequotepos;
								$quotechar = "'";
							}
							else
								$quotepos  = 0;
						}
							
						if ($quotepos > 0)
						{
							$endquotepos = strpos($lowerbanner, $quotechar, $quotepos+1);
							$newbanner = $newbanner . 
										 substr($html, $prevhrefpos, $hrefpos - $prevhrefpos) . 
										 $quotechar . "$phpAds_url_prefix/htmlclick.php?bannerID=" . 
										 $row['bannerID'] . "&dest=" . 
										 urlencode(substr($html, $quotepos+1, $endquotepos - $quotepos - 1));
							
							$prevhrefpos = $hrefpos + ($endquotepos - $quotepos);
						} 
						else
						{
							$spacepos = strpos($lowerbanner, " ", $hrefpos+1);
							$endtagpos = strpos($lowerbanner, ">", $hrefpos+1);
							
							if ($spacepos < $endtagpos) 
								$endpos = $spacepos; 
							else 
								$endpos = $endtagpos;
	 						
							$newbanner = $newbanner . 
										 substr($html, $prevhrefpos, $hrefpos - $prevhrefpos) . 
										 "\"" . "$phpAds_url_prefix/htmlclick.php?bannerID=" . 
										 $row['bannerID'] . "&dest=" . 
										 urlencode(substr($html, $hrefpos, $endpos - $hrefpos)) . "\"";
							
							$prevhrefpos = $hrefpos + ($endpos - $hrefpos);
						}
						$hrefpos = strpos($lowerbanner, "href=", $hrefpos + 1);
						
					}
					$newbanner = $newbanner.substr($html, $prevhrefpos);
					$outputbuffer .= $newbanner;
					
				}
				if (!empty($row["url"]) && strpos ($row['banner'], "{targeturl}") == 0) 
					$outputbuffer .= "</a>";
			}
			elseif ($row["format"] == "url")
			{
				// Banner refered through URL
				
				// Determine cachebuster
				if (eregi ("\{random(:([1-9])){0,1}\}", $row['banner'], $matches))
				{
					if ($matches[1] == "")
						$randomdigits = 8;
					else
						$randomdigits = $matches[2];
					
					$randomnumber = sprintf ("%0".$randomdigits."d", mt_rand (0, pow (10, $randomdigits) - 1));
					$row['banner'] = str_replace ($matches[0], $randomnumber, $row['banner']);
					
					$randomstring = "&cb=$randomnumber";
				}
				else
				{
					$randomstring = "";
				}
				
				if (empty($row["url"]))
					$outputbuffer .= "<img src='$row[banner]' width='".$row['width']."' height='".$row['height']."' alt='".$row['alt']."' border='0'>";
				else
					$outputbuffer .= "<a href='$phpAds_url_prefix/click.php?bannerID=".$row['bannerID'].$randomstring."'".$target."><img src='".$row['banner']."' width='".$row['width']."' height='".$row['height']."' alt='".$row['alt']."' border='0'></a>";
				
				if($withtext && !empty($row["bannertext"]))
					$outputbuffer .= "<br>\n<a href='$phpAds_url_prefix/click.php?bannerID=".$row['bannerID']."'".$target.">".$row['bannertext']."</a>";
			}
			elseif ($row["format"] == "web")
			{
				// Banner stored on webserver
				
				if (empty($row["url"]))
					$outputbuffer .= "<img src='".$row['banner']."' width='".$row['width']."' height='".$row['height']."' alt='".$row['alt']."' border='0'>";
				else
					$outputbuffer .= "<a href='$phpAds_url_prefix/click.php?bannerID=".$row['bannerID']."'".$target."><img src='".$row['banner']."' width='".$row['width']."' height='".$row['height']."' alt='".$row['alt']."' border='0'></a>";
				
				if($withtext && !empty($row["bannertext"]))
					$outputbuffer .= "<br>\n<a href='$phpAds_url_prefix/click.php?bannerID=".$row['bannerID']."'".$target.">".$row['bannertext']."</a>";
			}
			else
			{
				// Banner stored in MySQL
				
				if (empty($row["url"]))
					$outputbuffer .= "<img src='$phpAds_url_prefix/viewbanner.php?bannerID=".$row['bannerID']."' width='".$row['width']."' height='".$row['height']."' alt='".$row['alt']."' border='0'>";
				else
					$outputbuffer .= "<a href='$phpAds_url_prefix/click.php?bannerID=".$row['bannerID']."'".$target."><img src='$phpAds_url_prefix/viewbanner.php?bannerID=".$row['bannerID']."' width='".$row['width']."' height='".$row['height']."' alt='".$row['alt']."' border='0'></a>";
				
				if($withtext && !empty($row["bannertext"]))
					$outputbuffer .= "<br>\n<a href='$phpAds_url_prefix/click.php?bannerID=".$row['bannerID']."'".$target.">".$row['bannertext']."</a>";
			}
			
			// Log this AdView
			if(!empty($row["bannerID"]))
				log_adview($row["bannerID"],$row["clientID"]);
		}
	}
	else
	{
		// An error occured, or there are no banners to display at all
		// Use the default banner if defined
		
		if ($phpAds_default_banner_target != "" && $phpAds_default_banner_url != "")
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
			
			$outputbuffer .= "<a href='$phpAds_default_banner_target'$target><img src='$phpAds_default_banner_url' border='0'></a>";
		}
	}
	
	db_close();
	
	return( array("html" => $outputbuffer, 
				  "bannerID" => $row["bannerID"])
		  );
}



/*********************************************************/
/* Display a banner										 */
/*********************************************************/

function view($what, $clientID=0, $target="", $source="", $withtext=0, $context=0)
{
	$output = view_raw($what, $clientID, "$target", "$source", $withtext, $context);
	print($output["html"]);
	return($output["bannerID"]);
}



/*********************************************************/
/* Create the Javascript to display a banner			 */
/*********************************************************/

function view_js($what, $clientID=0, $target="", $source="", $withtext=0, $context=0)
{
	$output = view_raw($what, $clientID, "$target", "$source", $withtext, $context);
	
	enjavanate($output["html"]);
	return($output["bannerID"]);
}



function view_t($what, $target="")
{
	view ($what, $target, 1);
}

?>
