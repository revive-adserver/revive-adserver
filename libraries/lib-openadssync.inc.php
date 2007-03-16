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



// Set define to prevent duplicate include
define ('LIBUPDATES_INCLUDED', true);


// Include required files
require (phpAds_path.'/libraries/lib-xmlrpc.inc.php');



/*********************************************************/
/* XML-RPC server settings                               */
/*********************************************************/

$GLOBALS['phpAds_updatesServer'] = array(
	'host'	 => 'sync.openads.org',
	'script' => '/xmlrpc.php',
	'port'	 => 80
);



/*********************************************************/
/* Check for updates via XML-RPC                         */
/*********************************************************/

function phpAds_checkForUpdates($already_seen = 0, $send_sw_data = true)
{
	global $phpAds_config, $phpAds_updatesServer;
	global $xmlrpcerruser;

	// Create client object
	$client = new xmlrpc_client($phpAds_updatesServer['script'],
		$phpAds_updatesServer['host'], $phpAds_updatesServer['port']);
		
	$params = array(
		new xmlrpcval($GLOBALS['phpAds_productname'], "string"),
		new xmlrpcval($phpAds_config['config_version'], "string"),
		new xmlrpcval($already_seen, "string"),
		new xmlrpcval($phpAds_config['updates_dev_builds'] ? 'dev' : '', "string"),
		new xmlrpcval($phpAds_config['instance_id'], "string")
	);
	
	if ($send_sw_data)
	{
		// Prepare software data
		$params[] = phpAds_xmlrpcEncode(array(
			'os_type'					=> php_uname('s'),
			'os_version'				=> php_uname('r'),
			
			'webserver_type'			=> isset($_SERVER['SERVER_SOFTWARE']) ? preg_replace('#^(.*?)/.*$#', '$1', $_SERVER['SERVER_SOFTWARE']) : '',
			'webserver_version'			=> isset($_SERVER['SERVER_SOFTWARE']) ? preg_replace('#^.*?/(.*?)(?: .*)?$#', '$1', $_SERVER['SERVER_SOFTWARE']) : '',

			'db_type'					=> $GLOBALS['phpAds_dbmsname'],
			'db_version'				=> phpAds_dbResult(phpAds_dbQuery("SELECT VERSION()"), 0, 0),
			
			'php_version'				=> phpversion(),
			'php_sapi'					=> ucfirst(php_sapi_name()),
			'php_extensions'			=> get_loaded_extensions(),
			'php_register_globals'		=> (bool)ini_get('register_globals'),
			'php_magic_quotes_gpc'		=> (bool)ini_get('magic_quotes_gpc'),
			'php_safe_mode'				=> (bool)ini_get('safe_mode'),
			'php_open_basedir'			=> (bool)strlen(ini_get('open_basedir')),
			'php_upload_tmp_readable'	=> (bool)is_readable(ini_get('upload_tmp_dir').DIRECTORY_SEPARATOR),
		));
	}
	
	$iLastUpdate = 0;
	if (!empty($phpAds_config['ad_cs_data_last_sent']) && $phpAds_config['ad_cs_data_last_sent'] != '0000-00-00')
	{
	    $iLastUpdate = strtotime($phpAds_config['ad_cs_data_last_sent']); 
	}
	
	// make sure there's only one report on clicks/views a day
	if ($send_sw_data && $iLastUpdate+86400 < time()) 
	{	    

		// get ratios for clicks and views 
		// move start and end timestamp one hour back in the past so it's possible to fetch 
		// clicks/views generated when update was running
		$aData = phpAds_getAdSummaries($iLastUpdate-3600, time()-3600);

		// send only if there are values 
		if ($aData['ad_views_sum'] || $aData['ad_clicks_sum'])
		{
			$params[] = phpAds_xmlrpcEncode(array(
				'ad_views_per_second'	=> $aData['ad_views_per_second'],
				'ad_clicks_per_second'	=> $aData['ad_clicks_per_second'],
				'ad_views_sum'			=> $aData['ad_views_sum'],
				'ad_clicks_sum'			=> $aData['ad_clicks_sum'],
			));
		}
	
	}
	
	// Create XML-RPC request message
	$msg = new xmlrpcmsg("Openads.Sync", $params);

	// Send XML-RPC request message
	if ($response = $client->send($msg, 10))
	{
		// XML-RPC server found, now checking for errors
		if (!$response->faultCode())
		{
			$ret = array(0, phpAds_xmlrpcDecode($response->value()));
			
			// Prepare cache
			$cache = $ret[1];
		}
		else
		{
			$ret = array($response->faultCode(), $response->faultString());
			
			// Prepare cache
			$cache = false;
		}

		$sUpdate = "
			UPDATE
				".$phpAds_config['tbl_config']."
			SET
				updates_cache = '".addslashes(serialize($cache))."',
				updates_timestamp = ".time()."
		";
		
		if ($send_sw_data && $iLastUpdate+86400 < time())
		{
			$sUpdate .= ",
			ad_cs_data_last_sent = '".date('Y-m-d', time())."'
			";
		}
		
		// var $response is not needed from this point so we can reuse it
		// get community-stats
		$response = $client->send(new xmlrpcmsg('Openads.CommunityStats'),10);
		
		// if response contains no error store community-stats values locally
		if (!$response->faultCode())
		{
			$aCommunityStats = phpAds_xmlrpcDecode($response->value());
			if ($aCommunityStats['day'] != $phpAds_config['ad_cs_data_last_received'] && ($aCommunityStats['ad_clicks_sum'] || $aCommunityStats['ad_views_sum']))
			{
				$sUpdate .= ",
					ad_clicks_sum = ".(int)$aCommunityStats['ad_clicks_sum'].",
		 			ad_views_sum = ".(int)$aCommunityStats['ad_views_sum'].",
		 			ad_clicks_per_second = ".(float)$aCommunityStats['ad_clicks_per_second'].",
		 			ad_views_per_second = ".(float)$aCommunityStats['ad_views_per_second'].",
		 			ad_cs_data_last_received = '".$aCommunityStats['day']."'
				";
			}
		}
		
		// Save config info
		phpAds_dbQuery($sUpdate);
		
		return $ret;
	}
	
	return array(-1, 'No response from the server');
}

function phpAds_getAdSummaries($iStartDate, $iEndDate)
{
	global $phpAds_config;

	
	if($iStartDate > $iEndDate)
	{
	    return array();
	}
	
	if ($phpAds_config['compact_stats']) 
	{
		if($iStartDate <= 0)
		{
		    $iStartDate = phpAds_dbResult(phpAds_dbQuery("SELECT UNIX_TIMESTAMP(MIN(day)) FROM ".$phpAds_config['tbl_adstats']), 0, 0);
		    if(empty($iStartDate)){
		        return array();
		    }
		}
		
	    $sMysqlStartDay = date('Y-m-d', $iStartDate );
	    $sMysqlEndDay = date('Y-m-d', $iEndDate );
	    
	    $sMysqlStartHour = (int)date('H', $iStartDate );
	    $sMysqlEndHour = (int)date('H', $iEndDate );
	    
		$res = phpAds_dbQuery("
			SELECT
				SUM(v.clicks) AS ad_clicks_sum,
				SUM(v.views) AS ad_views_sum
			FROM
				".$phpAds_config['tbl_adstats']." AS v
			WHERE
				('".$sMysqlStartDay."' < '".$sMysqlEndDay."' 
					AND (
						(v.day = '".$sMysqlStartDay."' AND v.hour >= ".$sMysqlStartHour.")
						OR
						(v.day = '".$sMysqlEndDay."' AND v.hour < ".$sMysqlEndHour.")
						OR
						(v.day > '".$sMysqlStartDay."' AND v.day < '".$sMysqlEndDay."')
					)
				)
				OR
				('".$sMysqlStartDay."' >= '".$sMysqlEndDay."'
					AND (
						v.day = '".$sMysqlStartDay."' AND v.hour >= ".$sMysqlStartHour." AND v.hour < ".$sMysqlEndHour."
					)
				)
		");

		// extract values
		list($clicks,$views) = phpAds_dbFetchRow($res);

	}
	else 
	{
		if($iStartDate <= 0)
		{
			$iStartDateV = phpAds_dbResult(phpAds_dbQuery("SELECT UNIX_TIMESTAMP(MIN(t_stamp)) FROM ".$phpAds_config['tbl_adviews']), 0, 0);
			$iStartDateC = phpAds_dbResult(phpAds_dbQuery("SELECT UNIX_TIMESTAMP(MIN(t_stamp)) FROM ".$phpAds_config['tbl_adclicks']), 0, 0);

			if (empty($iStartDateV)) $iStartDateV = time();
			if (empty($iStartDateC)) $iStartDateC = time();

			$iStartDate = min($iStartDateV, $iStartDateC);

			if(empty($iStartDate)){
				return array();
			}
		}
		
	    $sMysqlStartDate = date('Y-m-d H:i:s', $iStartDate );
	    $sMysqlEndDate = date('Y-m-d H:i:s', $iEndDate );

		$res = phpAds_dbQuery("
			SELECT
				COUNT(*) as ad_views_sum
			FROM
				".$phpAds_config['tbl_adviews']." AS v
			WHERE
				v.t_stamp >= '".$sMysqlStartDate."' AND
				v.t_stamp < '".$sMysqlEndDate."'
		");

		// run query - get views
		$views = phpAds_dbResult($res, 0, 0);


		$res = phpAds_dbQuery("
			SELECT
				COUNT(*) as ad_clicks_sum
			FROM
				".$phpAds_config['tbl_adclicks']." AS c
			WHERE
				c.t_stamp >= '".$sMysqlStartDate."' AND
				c.t_stamp < '".$sMysqlEndDate."'
		");

		// run query - get clicks
		$clicks = phpAds_dbResult($res, 0, 0);
	    
	}

	$iTimeDiff = $iEndDate-$iStartDate;

	$aReturn = array();
	$aReturn['ad_clicks_per_second']	= round($clicks/$iTimeDiff, 4);
	$aReturn['ad_views_per_second']		= round($views/$iTimeDiff, 4);
	$aReturn['ad_clicks_sum']			= $clicks;
	$aReturn['ad_views_sum']			= $views;
	
	return $aReturn;

}
?>
