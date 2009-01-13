<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

/**
 *
 * @package    OpenX
 * @subpackage Upgrade Package Management System
 * @author
 */

require_once ('XML/RPC.php' );

function UPMS_checkVersion($aServer, $id=0)
{
    // Prepare variables
    $aParams = array(
        'changeset_id' => $id,
    );

    // Create the XML-RPC message
    $message = new XML_RPC_Message('OXUPMS.checkID', array(
        XML_RPC_encode($aParams)
    ));

    // Create an XML-RPC client to talk to the XML-RPC server
    $client = new XML_RPC_Client($aServer['path'], $aServer['host'], $aServer['port']);
    $client->debug = 0;

    // Send the XML-RPC message to the server
    $response = $client->send($message, 60, 'http');

    // Was the response OK?
    if ($response && $response->faultCode() == 0) {
        $response = XML_RPC_decode($response->value());

        return $response;
    }

    return false;
}

function UPMS_registerVersion($aServer, $id=0, $name='unknown', $comments='')
{

    // Prepare variables
    $aParams = array(
        'user_name'         => $name,
        'changeset_id'      => $id,
        'comments'          => $comments,
    );

    // Create the XML-RPC message
    $message = new XML_RPC_Message('OXUPMS.registerID', array(
        XML_RPC_encode($aParams)
    ));

    // Create an XML-RPC client to talk to the XML-RPC server
    $client = new XML_RPC_Client($aServer['path'], $aServer['host'], $aServer['port']);
    $client->debug = 0;

    // Send the XML-RPC message to the server
    $response = $client->send($message, 60, 'http');

    // Was the response OK?
    if ($response && $response->faultCode() == 0) {
        $response = XML_RPC_decode($response->value());

        return $response;
    }

    return array(
        'id'        => 'unregistered',
        'user'      => 'unregistered',
        'comments'  => 'unregistered',
    );
}

function UPMS_getNextVersion($aServer)
{
    // Create the XML-RPC message
    $message = new XML_RPC_Message('OXUPMS.getNextID');

    // Create an XML-RPC client to talk to the XML-RPC server
    $client = new XML_RPC_Client($aServer['path'], $aServer['host'], $aServer['port']);
    $client->debug = 0;

    // Send the XML-RPC message to the server
    $response = $client->send($message, 60, 'http');

    // Was the response OK?
    if ($response && $response->faultCode() == 0) {
        $result = XML_RPC_decode($response->value());

        return $result;
    }
    else if ($response->faultCode() > 0)
    {
        $result = $response->faultString();
    }
    return $result;
}


?>
