<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer <niels@creatype.nl>             */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/






/*********************************************************/
/* Mail clients and check for activation  				 */
/* and expiration dates					 				 */
/*********************************************************/

$res_clients = db_query("
	SELECT
		clientID,
		clientname,
		contact,
		email,
		language,
		reportdeactivate
	FROM
		$phpAds_tbl_clients
	WHERE
		parent = 0
	
	") or die($strLogErrorClients);

while($client = mysql_fetch_array($res_clients))
{
	// Process this client
	print "<br>Processing client ".$client["clientname"]."...<BR>\n";
	flush();
    
	// Load client language strings
	if (isset($client["language"]) && $client["language"] != "")
		include ("../language/".$client["language"].".inc.php");
	else
		include ("../language/$phpAds_language.inc.php");
	
	
	// Send Query
	$res_campaigns = db_query("
		SELECT
			clientID,
			clientname,
			views,
			clicks,
			expire,
			UNIX_TIMESTAMP(expire) as expire_st,
			activate,
			UNIX_TIMESTAMP(activate) as activate_st,
			active
		FROM
			$phpAds_tbl_clients
		WHERE
			parent = ".$client['clientID']."
		") or die($strLogErrorClients);
	
	
	while($campaign = mysql_fetch_array($res_campaigns))
	{
		// Process this client
		print "&nbsp;&nbsp;&nbsp;Processing campaign ".$campaign["clientname"]."...<BR>\n";
		flush();
	    
		
		print "&nbsp;&nbsp;&nbsp;- Current status: ".$campaign["active"]."<BR>\n";
		
		$active = "true";
		
		if ($campaign["clicks"] == 0 || $campaign["views"] == 0)
			$active = "false";
		
		if (time() < $campaign["activate_st"])
			$active = "false";
		
		if (time() > $campaign["expire_st"] && $campaign["expire_st"] != 0)
			$active = "false";
		
		if ($campaign["active"] != $active)
		{
			$client_name = $campaign["clientname"];
			$client_ID 	 = $campaign['clientID'];
			
			print "&nbsp;&nbsp;&nbsp;- Setting activation to $active<br>";
			$activateresult = db_query("UPDATE $phpAds_tbl_clients SET active='$active' WHERE clientID=$client_ID") or mysql_die ("$strLogErrorDisactivate");
			
			if ($active == "false")
			{
				// Email deactivation warning
				if ($client["email"] != '' && $client["reportdeactivate"] == 'true')
				{
					$Subject = $strMailSubjectDeleted.": ".$campaign["clientname"];
	        		$To		 = $client["contact"]." <".$client["email"].">";
					
					$Body = "$strMailHeader\n";
					$Body .= $strMailClientDeactivated;
					if ($campaign['clicks'] == 0) 			$Body .= ", $strNoMoreClicks";
					if ($campaign['views'] == 0) 			$Body .= ", $strNoMoreViews";
					if (time() < $campaign["activate_st"])	$Body .= ", $strBeforeActivate";
					if (time() > $campaign["expire_st"] && $campaign["expire_st"] != 0)
						$Body .= ", $strAfterExpire";
					$Body .= ".\n\n";
					
					
					$res_banners = db_query("
						SELECT
							bannerID,
							URL,
							description,
							alt
						FROM
							$phpAds_tbl_banners
						WHERE
							clientID = ".$campaign['clientID']."
						") or die($strLogErrorBanners);
					
					if (mysql_num_rows($res_banners) > 0)
					{
						$Body .= "-------------------------------------------------------\n";
						
						while($row_banners = mysql_fetch_array($res_banners))
						{
							$Body .= $strBanner."  ".phpAds_buildBannerName ($row_banners['bannerID'], $row_banners['description'], $row_banners['alt'])."\n";
							$Body .= "linked to: ".$row_banners['URL']."\n";
							$Body .= "-------------------------------------------------------\n";
						}
					}
					
					$Body .= "\n";
					$Body .= "$strMailNothingLeft\n\n";
					$Body .= "$strMailFooter";
					
					$Body  = str_replace ("{clientname}", $client["clientname"], $Body);
					$Body  = str_replace ("{contact}", $client["contact"], $Body);
					$Body  = str_replace ("{adminfullname}", $phpAds_admin_fullname, $Body);
					
					mail ($To, $Subject, $Body, $phpAds_admin_email_headers);
					unset ($Subject) ;
					
					print "&nbsp;&nbsp;&nbsp;- Report sent to ".$client["email"]."...<BR>\n";
					flush();
				}
			}
		}
	}
}

echo "<br><br>$strLogMailSent\n";


?>
