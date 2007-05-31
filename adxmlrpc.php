<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Require the initialisation file
require_once './init-delivery.php';

require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';

setupIncludePath();

require_once 'XML/RPC/Server.php';



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
			$view_params[] = XML_RPC_decode($p);
		}
		else
		{
			// First parameter: Remote information supplied be XML-RPC client
			$p = XML_RPC_decode($p);

			if (!isset($p['remote_addr']))
				return new XML_RPC_Response(0, $xmlrpcerruser + 1,
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
        getHostName() .
		$_SERVER['REQUEST_URI'];

	// Save referer parameter for the Referrer limitation
	$GLOBALS['phpAds_currentReferrer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

	// Call view with supplied parameters
	$output = call_user_func_array('MAX_adSelect', $view_params);

	// What parameter should be always set
	if (!is_array($output))
		return new XML_RPC_Response(0, $xmlrpcerruser + 99,
			"No matching banner found");

	if (isset($GLOBALS['phpAds_xmlError']))
		return $GLOBALS['phpAds_xmlError'];

	return new XML_RPC_Response(XML_RPC_encode($output));
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


// Configure the XML-RPC server to use the xmlRpcView
// function to handle the XML-RPC ad view request
$server = new XML_RPC_Server(array(
	"phpAds.view" => array(
		"function" => 'phpAds_xmlrpcView',
		"signature" => array(
			array($XML_RPC_Struct, $XML_RPC_Struct, $XML_RPC_String, $XML_RPC_Int, $XML_RPC_String, $XML_RPC_String, $XML_RPC_Boolean),
			array($XML_RPC_Struct, $XML_RPC_Struct, $XML_RPC_String, $XML_RPC_Int, $XML_RPC_String, $XML_RPC_String, $XML_RPC_Boolean, $XML_RPC_Array)
			)
		)
	)
);

?>
