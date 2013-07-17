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

// Require the initialisation file
require_once '../../init-delivery.php';

setupIncludePath();

// Required files
require_once MAX_PATH . '/lib/max/Delivery/XML-RPC.php';

// Configure the XML-RPC server to use the varous OA_Delivery_XmlRpc_View
// function to handle the XML-RPC invocation code requests
$server = new XML_RPC_Server(array(
            'openads.view'  => array(
                'function'  => 'OA_Delivery_XmlRpc_View',
                'signature' => $xmlRpcView_OA['sig'],
                'docstring' => $xmlRpcView_OA['doc']
            ),
            'openads.spc'   => array(
                'function'  => 'OA_Delivery_XmlRpc_SPC',
                'signature' => $xmlRpcSPC_OA['sig'],
                'docstring' => $xmlRpcSPC_OA['doc']
            ),
            'phpAds.view'  => array(
                'function'  => 'OA_Delivery_XmlRpc_View_PAN',
                'signature' => $xmlRpcView_PAN['sig'],
                'docstring' => $xmlRpcView_PAN['doc']
            ),
            'max.view'  => array(
                'function'  => 'OA_Delivery_XmlRpc_View_Max',
                'signature' => $xmlRpcView_Max['sig'],
                'docstring' => $xmlRpcView_Max['doc']
            )
    )
);

?>
