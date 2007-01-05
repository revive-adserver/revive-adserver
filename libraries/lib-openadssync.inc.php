<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
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
	
	// Create XML-RPC request message
	$msg = new xmlrpcmsg("Openads.Sync", $params);

	// Send XML-RPC request message
	if($response = $client->send($msg, 10))
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

		// Save to cache
		phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_config']."
			SET
				updates_cache = '".addslashes(serialize($cache))."',
				updates_timestamp = ".time()."
		");
		
		return $ret;
	}
	
	return array(-1, 'No response from the server');
}

?>