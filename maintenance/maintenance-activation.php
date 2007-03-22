<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Prevent full path disclosure
if (!defined('phpAds_path')) die();


// Defaults
if (!defined('phpAds_LastMidnight'))
	define('phpAds_LastMidnight', mktime(0, 0, 0, date('m'), date('d'), date('Y')));


// Include required files
if (!defined('LIBWARNING_INCLUDED'))
	require (phpAds_path."/libraries/lib-warnings.inc.php"); 



/*********************************************************/
/* Mail clients and check for activation  				 */
/* and expiration dates					 				 */
/*********************************************************/

$res_clients = phpAds_dbQuery("
	SELECT
		clientid,
		clientname,
		contact,
		email,
		language,
		reportdeactivate
	FROM
		".$phpAds_config['tbl_clients']."
	WHERE
		parent = 0
	
	") or die($GLOBALS['strLogErrorClients'].' '.phpAds_dbError());

while($client = phpAds_dbFetchArray($res_clients))
{
	// Load client language strings
	@include (phpAds_path.'/language/english/default.lang.php');
	if ($client['language'] != '') $phpAds_config['language'] = $client['language'];
	if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php'))
		@include (phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php');
	
	
	// Send Query
	$res_campaigns = phpAds_dbQuery("
		SELECT
			clientid,
			clientname,
			parent,
			views,
			clicks,
			expire,
			UNIX_TIMESTAMP(expire) as expire_st,
			activate,
			UNIX_TIMESTAMP(activate) as activate_st,
			active,
			lb_reporting
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent = ".$client['clientid']."
		") or die($GLOBALS['strLogErrorClients'].' '.phpAds_dbError());
	
	
	while($campaign = phpAds_dbFetchArray($res_campaigns))
	{
		if ($phpAds_config['maintenance_timestamp'] < phpAds_LastMidnight)
		{
			$active = "t";
			
			if ($campaign["clicks"] == 0 || $campaign["views"] == 0)
				$active = "f";
			
			if (time() < $campaign["activate_st"])
				$active = "f";
			
			if (time() > $campaign["expire_st"] && $campaign["expire_st"] != 0)
				$active = "f";
			
			if ($campaign["active"] != $active)
			{
				if ($active == "t")
					phpAds_userlogAdd (phpAds_actionActiveCampaign, $campaign['clientid']);
				else
				{
					phpAds_userlogAdd (phpAds_actionDeactiveCampaign, $campaign['clientid']);
					phpAds_deactivateMail ($campaign);
				}
				
				phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET active='$active' WHERE clientid=".$campaign['clientid']);
			}
			
			if ($active == "t" && ($phpAds_config['warn_admin'] || $phpAds_config['warn_client']))
			{
				$days_left = round(($campaign["expire_st"] - phpAds_LastMidnight) / (60*60*24));
				
				if ($days_left == $phpAds_config['warn_limit_days'])
					phpAds_warningMail ($campaign, $campaign["expire_st"]);
			}
		}
		
		// Deal with reporting when in a load balanced environment
		if ($campaign['lb_reporting'] == 't')
		{
			if (!$campaign['views'] || !$campaign['clicks'])
				phpAds_deactivateMail($campaign);
			elseif ($campaign['views'] > 0)
				phpAds_warningMail ($campaign);

			phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET lb_reporting = 'f'
				WHERE clientid = '".$campaign['clientid']."'");
		}
	}
}

?>