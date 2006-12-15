<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

// Required files
require_once MAX_PATH . '/lib/max/other/lib-db.inc.php';
require_once 'XML/RPC.php';

/*-------------------------------------------------------*/
/* XML-RPC server settings                               */
/*-------------------------------------------------------*/

$updatesServer = array(
	'host'	 => 'max.awarez.net',
	'script' => '/update/update.php',
	'port'	 => 80
);

/**
/* Check for updates via XML-RPC
 *
 * @return array A status code is in the first element.
 *              -1: An error occurred
 *               0: No updates required
 *               1: An update is available
 *
 */
function phpAds_checkForUpdates($updateLastSeen = 0)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    global $XML_RPC_Array, $XML_RPC_String, $updatesServer;

    // Create an XML-RPC client to talk to the XML-RPC server
    $client = new XML_RPC_Client($updatesServer['script'], $updatesServer['host'], $updatesServer['port']);

    // Create the XML-RPC message
    $message = new XML_RPC_Message('max.updateCheck', array());

	// Obtain the installed version
	$query = "
	   SELECT
	       value AS version
	   FROM
	       {$conf['table']['prefix']}{$conf['table']['application_variable']}
	   WHERE
	       name = 'max_version'
	   ";
	$result = phpAds_dbQuery($query);
	$row = phpAds_dbFetchArray($result);

	// Add the parameters to the message
	$message->addParam(new XML_RPC_Value($row['version'], $XML_RPC_String));
	$message->addParam(new XML_RPC_Value($updateLastSeen, $XML_RPC_String));

    // Send the XML-RPC message to the server
    $response = $client->send($message, 10, 'http');

    // Was a response received?
    if (!$response) {
        return array(-1, 'Error: No XML-RPC response');
    } else {
        // Was a response an error?
        if ($response->faultCode() != 0) {
            return array(-1, 'Error: ' . $response->faultString());
        } else {
            // Check that the response in an array
            $value = $response->value();
            if ($value->kindOf() != $XML_RPC_Array) {
                return array(-1, 'Error: Unexpected response value');
            }
            // See if a later version exists
            $temp = $value->arraymem(0);
            if ($temp->scalarval() == 0) {
                return array(0, 0);
            }
            // Get the later version details
            $latest = array();
            $temp = $value->arraymem(1);
            $tempVal = $temp->structmem('config_readable');
            $latest['config_readable'] = $tempVal->scalarval();
            $tempVal = $temp->structmem('description');
            $latest['description'] = $tempVal->scalarval();
            $tempVal = $temp->structmem('url_zip');
            $latest['url_zip'] = $tempVal->scalarval();
            $tempVal = $temp->structmem('url_tgz');
            $latest['url_tgz'] = $tempVal->scalarval();
            // Update the database
            $query = "
                UPDATE
                    {$conf['table']['prefix']}{$conf['table']['preference']}
                SET
                    updates_last_seen = '{$latest['config_readable']}',
                    updates_timestamp = " . time()
                ;
            phpAds_dbQuery($query);
            // Return the latest version
            return array(1, $latest);
        }
    }
}

?>
