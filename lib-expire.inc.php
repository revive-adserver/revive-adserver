<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer			                        */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Define constants
define ("phpAds_Clicks", 1);
define ("phpAds_Views", 2);



/*********************************************************/
/* Check the expiration of a client				         */
/*********************************************************/

function phpAds_expire ($clientID, $type=0)
{
	global $phpAds_config;
	
	// Get client information
	$campaignresult = phpAds_dbQuery("SELECT *, UNIX_TIMESTAMP(expire) as expire_st, UNIX_TIMESTAMP(activate) as activate_st FROM ".$phpAds_config['tbl_clients']." WHERE clientID=$clientID");
	
	if ($campaign = phpAds_dbFetchArray ($campaignresult))
	{
		// Decrement views
		if (($campaign["views"] > 0) and ($type == phpAds_Views))
		{
			$campaign["views"] = $campaign["views"] - 1;
			
			// Mail warning - preset is reached
			if ($campaign["views"] == $phpAds_config['warn_limit'])
				phpAds_warningMail ($campaign);
			
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET views=views-1 WHERE clientID=$clientID");
		}
		
		// Decrement clicks
		if (($campaign["clicks"] > 0) and ($type == phpAds_Clicks))
		{
			$campaign["clicks"] = $campaign["clicks"] - 1;
			
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET clicks=clicks-1 WHERE clientID=$clientID");
		}
		
		// Check activation status
		$active = "true";
		
		if ($campaign["clicks"] == 0 || $campaign["views"] == 0)
			$active = "false";
		
		if (time() < $campaign["activate_st"])
			$active = "false";
		
		if (time() > $campaign["expire_st"] && $campaign["expire_st"] != 0)
			$active = "false";
		
		if ($campaign["active"] != $active)
		{
			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET active='$active' WHERE clientID=$clientID");
		}
		
		if ($active == 'false')
		{
			// Send deactivation warning
			phpAds_deactivateMail ($campaign);
		}
	}
}



/*********************************************************/
/* Mail warning - preset is reached						 */
/*********************************************************/

function phpAds_warningMail ($campaign)
{
	global $phpAds_config;
	global $strViewsClicksLow, $strMailHeader, $strWarnClientTxt, $strMailNothingLeft, $strMailFooter;
	global $phpAds_CharSet;
	
	if ($phpAds_config['warn_admin'] || $phpAds_config['warn_client'])
	{
		// Get the client which belongs to this campaign
		$clientresult = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE clientID=".$campaign['parent']);
		if ($client = phpAds_dbFetchArray($clientresult))
		{
			// Load client language strings
			if (isset($client["language"]) && $client["language"] != "")
				include (phpAds_path."/language/".$client["language"].".inc.php");
			else
				include (phpAds_path."/language/".$phpAds_config['language'].".inc.php");
			
			
			$Subject = $strViewsClicksLow.": ".$campaign["clientname"];
			$To		  = $client['email'];
			
			$Headers = "Content-Transfer-Encoding: 8bit\n";
			
			if (isset($phpAds_CharSet))
				$Headers .= "Content-Type: text/plain; charset=".$phpAds_CharSet."\n"; 
			
			$Headers .= "To: ".$client['contact']." <".$client['email'].">\n";
			$Headers .= $phpAds_config['admin_email_headers']."\n";
			
			$Body    = "$strMailHeader\n";
			$Body 	.= "$strWarnClientTxt\n";
			$Body 	.= "$strMailNothingLeft\n\n";
			$Body   .= "$strMailFooter";
			
			$Body    = str_replace ("{clientname}", $campaign["clientname"], $Body);
			$Body	 = str_replace ("{contact}", $client["contact"], $Body);
			$Body    = str_replace ("{adminfullname}", $phpAds_config['admin_fullname'], $Body);
			$Body    = str_replace ("{limit}", $phpAds_config['warn_limit'], $Body);
			
			
			if ($phpAds_config['warn_admin'])
				@mail($phpAds_config['admin_email'], $Subject, $Body, $Headers);
			
			if ($client["email"] != '')
			{
				if ($phpAds_config['warn_client'])
					@mail($To, $Subject, $Body, $Headers);
			}
		}
	}
}



/*********************************************************/
/* Mail warning - preset is reached						 */
/*********************************************************/

function phpAds_deactivateMail ($campaign)
{
	global $phpAds_config;
	global $strMailSubjectDeleted, $strMailHeader, $strMailClientDeactivated;
	global $strNoMoreClicks, $strNoMoreViews, $strBeforeActivate, $strAfterExpire;
	global $strBanner, $strMailNothingLeft, $strMailFooter;
	global $strUntitled, $phpAds_CharSet;
	
	$clientresult = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE clientID=".$campaign['parent']);
	if ($client = phpAds_dbFetchArray($clientresult))
	{
		if ($client["email"] != '' && $client["reportdeactivate"] == 'true')
		{
			// Load client language strings
			if (isset($client["language"]) && $client["language"] != "")
				include (phpAds_path."/language/".$client["language"].".inc.php");
			else
				include (phpAds_path."/language/".$phpAds_config['language'].".inc.php");
			
			$Subject = $strMailSubjectDeleted.": ".$campaign["clientname"];
			$To		  = $client['email'];
			
			$Headers = "Content-Transfer-Encoding: 8bit\n";
			
			if (isset($phpAds_CharSet))
				$Headers .= "Content-Type: text/plain; charset=".$phpAds_CharSet."\n"; 
			
			$Headers .= "To: ".$client['contact']." <".$client['email'].">\n";
			$Headers .= $phpAds_config['admin_email_headers']."\n";
			
			$Body  = $strMailHeader."\n";
			$Body .= $strMailClientDeactivated;
			if ($campaign['clicks'] == 0) 			$Body .= ", $strNoMoreClicks";
			if ($campaign['views'] == 0) 			$Body .= ", $strNoMoreViews";
			if (time() < $campaign["activate_st"])	$Body .= ", $strBeforeActivate";
			if (time() > $campaign["expire_st"] && $campaign["expire_st"] != 0)
			$Body .= ", $strAfterExpire";
			$Body .= ".\n\n";
			
			
			$res_banners = phpAds_dbQuery("
				SELECT
					bannerID,
					URL,
					description,
					alt
				FROM
					".$phpAds_config['tbl_banners']."
				WHERE
					clientID = ".$campaign['clientID']."
				");
			
			if (phpAds_dbNumRows($res_banners) > 0)
			{
				$Body .= "-------------------------------------------------------\n";
				
				while($row_banners = phpAds_dbFetchArray($res_banners))
				{
					$name = "[id".$row_banners['bannerID']."] ";
					
					if ($row_banners['description'] != "")
						$name .= $row_banners['description'];
					elseif ($row_banners['alt'] != "")
						$name .= $row_banners['alt'];
					else
						$name .= $strUntitled;
					
					$Body .= $strBanner."  ".$name."\n";
					$Body .= "linked to: ".$row_banners['URL']."\n";
					$Body .= "-------------------------------------------------------\n";
				}
			}
			
			$Body .= "\n";
			$Body .= "$strMailNothingLeft\n\n";
			$Body .= "$strMailFooter";
			
			$Body  = str_replace ("{clientname}", $client["clientname"], $Body);
			$Body  = str_replace ("{contact}", $client["contact"], $Body);
			$Body  = str_replace ("{adminfullname}", $phpAds_config['admin_fullname'], $Body);
			
			@mail ($To, $Subject, $Body, $Headers);
			unset ($Subject) ;
		}
	}
}


?>