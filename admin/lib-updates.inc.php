<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Set define to prevent duplicate include
define ('LIBUPDATES_INCLUDED', true);


// Include required files
require (phpAds_path.'/libraries/lib-xmlrpc.inc.php');



/*********************************************************/
/* XML-RPC server settings                               */
/*********************************************************/

$phpAds_updatesServer = array(
	'host'	 => 'www.phpadsnew.com',
	'script' => '/update/xmlrpc.php',
	'port'	 => 80
);



/*********************************************************/
/* Check for updates via XML-RPC                         */
/*********************************************************/

function phpAds_checkForUpdates($already_seen = 0)
{
	global $phpAds_config, $phpAds_updatesServer;
	global $xmlrpcerruser;

	// Create client object
	$client = new xmlrpc_client($phpAds_updatesServer['script'],
		$phpAds_updatesServer['host'], $phpAds_updatesServer['port']);
	
	// Create XML-RPC request message
	$msg = new xmlrpcmsg("updateAdsNew.check", array(
		new xmlrpcval($phpAds_config['config_version'], "string"),
		new xmlrpcval($already_seen, "string"),
		new xmlrpcval($phpAds_config['updates_dev_builds'] ? 'dev' : '', "string")
	));

	// Send XML-RPC request message
	if($response = $client->send($msg, 10))
	{
		// XML-RPC server found, now checking for errors
		if (!$response->faultCode())
		{
			$ret = array(0, phpAds_xmlrpcDecode($response->value()));
			
			phpAds_dbQuery("
				UPDATE
					".$phpAds_config['tbl_config']."
				SET
					updates_last_seen = '".$ret[1]['config_version']."',
					updates_timestamp = ".time()."
			");
		}
		else
			$ret = array($response->faultCode(), $response->faultString());
		
		return $ret;
	}
	
	return array(-1, 'No response from the server');
}

?>