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


// Set define to prevent duplicate include
define ('LIBWARNING_INCLUDED', true);


/*********************************************************/
/* Mail warning - preset is reached						 */
/*********************************************************/

function phpAds_warningMail ($campaign)
{
	global $phpAds_config;
	global $strViewsClicksLow, $strMailHeader, $strWarnClientTxt;
	global $phpAds_CharSet, $strMailNothingLeft, $strMailFooter;
	
	
	if ($phpAds_config['warn_admin'] || $phpAds_config['warn_client'])
	{
		// Load config from the db
		include (phpAds_path.'/lib-dbconfig.inc.php');
		phpAds_LoadDbConfig();
		
		// Get the client which belongs to this campaign
		$clientresult = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE clientid=".$campaign['parent']);
		if ($client = phpAds_dbFetchArray($clientresult))
		{
			// Load client language strings
			if (isset($client["language"]) && $client["language"] != "")
				include (phpAds_path.'/language/'.$client['language'].'/default.lang.php');
			else
				include (phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php');
			
			
			$Subject = $strViewsClicksLow.": ".$campaign["clientname"];
			
			$Headers = "Content-Transfer-Encoding: 8bit\r\n";
			
			if (isset($phpAds_CharSet))
				$Headers .= "Content-Type: text/plain; charset=".$phpAds_CharSet."\r\n"; 
			
			$Headers .= "From: ".$phpAds_config['admin_fullname']." <".$phpAds_config['admin_email'].">\r\n";
			if (!empty($phpAds_config['admin_email_headers']))
				$Headers .= "\r\n".$phpAds_config['admin_email_headers'];
			
			$Body    = "$strMailHeader\n";
			$Body 	.= "$strWarnClientTxt\n";
			$Body 	.= "$strMailNothingLeft\n\n";
			$Body   .= "$strMailFooter";
			
			$Body    = str_replace ("{clientname}", $campaign["clientname"], $Body);
			$Body	 = str_replace ("{contact}", $client["contact"], $Body);
			$Body    = str_replace ("{adminfullname}", $phpAds_config['admin_fullname'], $Body);
			$Body    = str_replace ("{limit}", $phpAds_config['warn_limit'], $Body);
			
			
			if ($phpAds_config['warn_admin'])
			{
				$To = !get_cfg_var('SMTP') ? '"'.$phpAds_config['admin_fullname'].'" <'.$phpAds_config['admin_email'].'>' : $client["email"];
				$Headers2 = !get_cfg_var('SMTP') ? "" : '\r\nTo: "'.$phpAds_config['admin_fullname'].'" <'.$phpAds_config['admin_email'].">"; 				
				@mail($To, $Subject, $Body, $Headers2);
			}
			
			if ($phpAds_config['warn_client'] && $client["email"] != '')
			{
				$To = !get_cfg_var('SMTP') ? '"'.$client["contact"].'" <'.$client["email"].'>' : $client["email"];
				$Headers2 = !get_cfg_var('SMTP') ? "" : '\r\nTo: "'.$client["contact"].'" <'.$client["email"].">";
				@mail($To, $Subject, $Body, $Headers2);
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
	
	$clientresult = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE clientid=".$campaign['parent']);
	if ($client = phpAds_dbFetchArray($clientresult))
	{
		if ($client["email"] != '' && $client["reportdeactivate"] == 't')
		{
			// Load client language strings
			if (isset($client["language"]) && $client["language"] != "")
				include (phpAds_path."/language/".$client["language"]."/default.lang.php");
			else
				include (phpAds_path."/language/".$phpAds_config['language']."/default.lang.php");
			
			$Subject = $strMailSubjectDeleted.": ".$campaign["clientname"];
			$To = !get_cfg_var('SMTP') ? '"'.$client["contact"].'" <'.$client["email"].'>' : $client["email"];
			
			$Headers = "Content-Transfer-Encoding: 8bit\r\n";
			
			if (isset($phpAds_CharSet))
				$Headers .= "Content-Type: text/plain; charset=".$phpAds_CharSet."\r\n"; 
			
			$Headers .= !get_cfg_var('SMTP') ? "" : 'To: "'.$client["contact"].'" <'.$client["email"].">\r\n"; 			
			$Headers .= "From: ".$phpAds_config['admin_fullname']." <".$phpAds_config['admin_email'].">\r\n";
			if (!empty($phpAds_config['admin_email_headers']))
				$Headers .= "\r\n".$phpAds_config['admin_email_headers'];
			
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
					bannerid,
					URL,
					description,
					alt
				FROM
					".$phpAds_config['tbl_banners']."
				WHERE
					clientid = ".$campaign['clientid']."
				");
			
			if (phpAds_dbNumRows($res_banners) > 0)
			{
				$Body .= "-------------------------------------------------------\n";
				
				while($row_banners = phpAds_dbFetchArray($res_banners))
				{
					$name = "[id".$row_banners['bannerid']."] ";
					
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
