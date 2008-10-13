<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

// Set a global variable to let the other functions know
// they are serving an XML-RPC request.
$GLOBALS['_OA']['invocationType'] = 'xml-rpc';

// Require the initialisation file
require_once '../../init-delivery.php';

###START_STRIP_DELIVERY
OA::debug('starting delivery script '.__FILE__);
###END_STRIP_DELIVERY

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
