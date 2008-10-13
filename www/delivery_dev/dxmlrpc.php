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

// Require the initialisation file
require_once '../../init-delivery.php';

// Require the DAL file for the delivery engine
require_once(MAX_PATH . '/lib/OA/Dal/Delivery/' . strtolower($conf['database']['type']) . '.php');

// Require the XMLRPC classes
require_once 'XML/RPC/Server.php';

###START_STRIP_DELIVERY
OA::debug('starting delivery script '.__FILE__);
###END_STRIP_DELIVERY

// function to handle the XML-RPC upgrade check request
$server = new XML_RPC_Server(array(
    'getZoneLinkedAds'  => array('function' => '_getZoneLinkedAds'),
    'getLinkedAds'      => array('function' => '_getLinkedAds'),
    'getZoneInfo'       => array('function' => '_getZoneInfo'),
    'getAd'             => array('function' => '_getAd'),
    'pluginExecute'     => array('function' => '_pluginExecute'),
));

function _getZoneLinkedAds(&$params)
{
    $paramZoneId = &$params->getParam(0);
    $zoneId = $paramZoneId->scalarval();
    $response = new XML_RPC_Value(serialize(OA_Dal_Delivery_getZoneLinkedAds($zoneId)), 'base64');

    return new XML_RPC_Response($response);
}

function _getLinkedAds(&$params)
{
    $paramSearch = &$params->getParam(0);
    $search = $paramSearch->scalarval();
    $response = new XML_RPC_Value(serialize(OA_Dal_Delivery_getLinkedAds($search)), 'base64');

    return new XML_RPC_Response($response);
}

function _getZoneInfo(&$params)
{
    $paramZoneId = &$params->getParam(0);
    $zoneId = $paramZoneId->scalarval();
    $response = new XML_RPC_Value(serialize(OA_Dal_Delivery_getZoneInfo($zoneId)), 'base64');

    return new XML_RPC_Response($response);
}

function _getAd(&$params)
{
    $paramAdId = &$params->getParam(0);
    $adId = $paramAdId->scalarval();
    $response = new XML_RPC_Value(serialize(OA_Dal_Delivery_getAd($adId)), 'base64');

    return new XML_RPC_Response($response);
}

function _pluginExecute(&$params)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    $paramParams = &$params->getParam(0);
    $pluginParams = unserialize($paramParams->scalarval());
    // Instansiate the plugin and execute the method
    include_once MAX_PATH . '/lib/max/Plugin.php';
    $plugin = MAX_Plugin::factory($pluginParams['module'], strtolower($conf['database']['type']));
    if ($plugin) {
        $result = array();
        $result = $plugin->$pluginParams['method']($pluginParams['data']);
    }

    $response = new XML_RPC_Value(serialize($result), 'base64');
    return new XML_RPC_Response($response);
}
?>
