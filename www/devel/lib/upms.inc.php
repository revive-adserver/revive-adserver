<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 *
 * @package    OpenX
 * @subpackage Upgrade Package Management System
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
