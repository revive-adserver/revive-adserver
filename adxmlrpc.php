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



// Figure out our location
define ('phpAds_path', '.');


// Set invocation type
define ('phpAds_invocationType', 'xmlrpc');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/libraries/lib-db.inc.php");
require (phpAds_path."/libraries/lib-xmlrpcs.inc.php");

if (($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon']) || $phpAds_config['acl'])
{
	require (phpAds_path."/libraries/lib-remotehost.inc.php");
	
	if ($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon'])
		require (phpAds_path."/libraries/lib-log.inc.php");
	
	if ($phpAds_config['acl'])
		require (phpAds_path."/libraries/lib-limitations.inc.php");
}

require	(phpAds_path."/libraries/lib-view-main.inc.php");



/*********************************************************/
/* Wrapper function to view_raw()                        */
/*********************************************************/

function phpAds_xmlrpcView ($msg)
{
	global $xmlrpcerruser;

	$view_params = array();

	// Parse parameters
	for ($i = 0; $i < $msg->getNumParams(); $i++)
	{
		$p = $msg->getParam($i);
		
		if ($i)
		{
			// Put the decoded value the view arg array
			$view_params[] = phpAds_xmlrpcDecode($p);
		}
		else
		{
			// First parameter: Remote information supplied be XML-RPC client
			$p = phpAds_xmlrpcDecode($p);

			if (!isset($p['remote_addr']))
				return new xmlrpcresp(0, $xmlrpcerruser + 1,
					"Missing 'remote_addr' member!");

			while (list($k, $v) = each($p))
			{
				switch ($k)
				{
					case 'remote_addr':
						$_SERVER['REMOTE_ADDR'] =
						$GLOBALS['REMOTE_ADDR'] = $v;
						break;

					case 'remote_host':
						$_SERVER['REMOTE_HOST'] =
						$GLOBALS['REMOTE_HOST'] = $v;
						break;

					case 'request_uri':
						$_SERVER['REQUEST_URI'] =
						$GLOBALS['REQUEST_URI'] = $v;
						break;

					case 'server_name':
						$_SERVER['SERVER_NAME'] =
						$GLOBALS['SERVER_NAME'] = $v;
						break;

					case 'https':
						$_SERVER['HTTPS'] =
						$GLOBALS['HTTPS'] = $v;
						break;

					default:
						$varname = 'HTTP_'.strtoupper($k);
						$_SERVER[$varname] =
						$GLOBALS[$varname] = $v;
						break;
				}
			}
		}
	}
	
	// Save current URL for the URL limitation
	$GLOBALS['phpAds_currentURL'] =
		(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http').'://'.
		(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']).
		$_SERVER['REQUEST_URI'];
	
	// Save referer parameter for the Referrer limitation
	$GLOBALS['phpAds_currentReferrer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

	// Call view with supplied parameters
	$output = call_user_func_array('view_raw', $view_params);

	// What parameter should be always set
	if (!is_array($output))
		return new xmlrpcresp(0, $xmlrpcerruser + 99,
			"No matching banner found");

	if (isset($GLOBALS['phpAds_xmlError']))
		return $GLOBALS['phpAds_xmlError'];

	return new xmlrpcresp(phpAds_xmlrpcEncode($output));
}




/*********************************************************/
/* XML-RPC error handler                                 */
/*********************************************************/

function phpAds_xmlrpcErrorHandler ($errno, $errstr, $errfile, $errline)
{
	global $xmlrpcerruser, $phpAds_xmlError;
	
	if ($errno & (E_ERROR|E_USER_ERROR))
		$phpAds_xmlError = new xmlrpcresp(0, $xmlrpcerruser + 100,
			"Error in '$errfile' at line $errline: $errstr");
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/


// Register function to send error as an XML-RPC error message - PHP4 only
if (function_exists('set_error_handler'))
	set_error_handler('phpAds_xmlrpcErrorHandler');


// Open a connection to the database
phpAds_dbConnect();


// Create server for the view method with possible signatures
$server = new xmlrpc_server(array(
	"phpAds.view" => array(
		"function" => 'phpAds_xmlrpcView',
		"signature" => array(
			array($xmlrpcStruct, $xmlrpcStruct, $xmlrpcString, $xmlrpcInt, $xmlrpcString, $xmlrpcString, $xmlrpcBoolean),
			array($xmlrpcStruct, $xmlrpcStruct, $xmlrpcString, $xmlrpcInt, $xmlrpcString, $xmlrpcString, $xmlrpcBoolean, $xmlrpcArray)
			)
		)
	)
);

?>