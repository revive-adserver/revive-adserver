<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
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
	$view_arrays = array();

	$params = array(
		array('name' => 'remote_info',	'scalar' => false,	'type' => 'struct'),
		array('name' => 'what',			'scalar' => true,	'type' => 'string'),
		array('name' => 'clientid',		'scalar' => true,	'type' => 'int'),
		array('name' => 'target',		'scalar' => true,	'type' => 'string'),
		array('name' => 'source',		'scalar' => true,	'type' => 'string'),
		array('name' => 'withtext',		'scalar' => true,	'type' => 'boolean'),
		array('name' => 'context',		'scalar' => false)
	);

	// Parse parameters
	for ($i = 0; $i < $msg->getNumParams(); $i++)
	{
		$p = $msg->getParam($i);
		
		if ($params[$i]['name'] == 'remote_info')
		{
			// Remote information supplied be XML-RPC client
			$p = phpAds_xmlrpcDecode($p);

			if (!isset($p['remote_addr']))
				return new xmlrpcresp(0, $xmlrpcerruser + 1,
					"Missing 'remote_addr' member!");

			while (list($k, $v) = each($p))
			{
				switch ($k)
				{
					case 'remote_addr':
						$GLOBALS['HTTP_SERVER_VARS']['REMOTE_ADDR'] =
						$GLOBALS['REMOTE_ADDR'] = $v;
						break;

					case 'remote_host':
						$GLOBALS['HTTP_SERVER_VARS']['REMOTE_HOST'] =
						$GLOBALS['REMOTE_HOST'] = $v;
						break;

					default:
						$varname = 'HTTP_'.strtoupper($k);
						$GLOBALS['HTTP_SERVER_VARS'][$varname] =
						$GLOBALS[$varname] = $v;
						break;
				}
			}
		}
		elseif ($p->kindOf() == 'scalar')
		{						 
			// Scalar parameter - put the right value in view arg queue

			$p = $p->scalarval();

			switch ($params[$i]['type'])
			{
				case 'int':		$view_params[] = $p; break;
				case 'boolean':	$view_params[] = $p ? 'true' : 'false'; break;
				default:		$view_params[] = "'".addcslashes($p, "\0..\37'")."'"; break;
			}
		}
		else
		{
			// Non-scalar parameter - put the decoded value in a temp array
			// for the view arg queue

			$view_arrays[] = phpAds_xmlrpcDecode($p);
			$view_params[] = '$view_arrays['.(count($view_arrays)-1).']';
		}
	}
	

	// Call view with supplied parameters
	eval('$output = view_raw('.join(', ', $view_params).');');

	// What parameter should be always set
	if (!is_array($output))
		return new xmlrpcresp(0, $xmlrpcerruser + 99,
			"An error occurred while fetching banner code");

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