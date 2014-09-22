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

// Require the DAL file for the delivery engine
require_once(MAX_PATH . '/lib/OA/Dal/Delivery/' . strtolower($conf['database']['type']) . '.php');

// Require the XMLRPC classes
require_once 'XML/RPC/Server.php';

// function to handle the XML-RPC upgrade check request
$server = new XML_RPC_Server(array(
    'getZoneLinkedAds'  => array('function' => '_getZoneLinkedAds'),
    'getLinkedAds'      => array('function' => '_getLinkedAds'),
    'getZoneInfo'       => array('function' => '_getZoneInfo'),
    'getAd'             => array('function' => '_getAd'),
    'pluginExecute'     => array('function' => '_pluginExecute'),
));

function _getZoneLinkedAds($params)
{
    $paramZoneId = $params->getParam(0);
    $zoneId = $paramZoneId->scalarval();
    $response = new XML_RPC_Value(serialize(OA_Dal_Delivery_getZoneLinkedAds($zoneId)), 'base64');

    return new XML_RPC_Response($response);
}

function _getLinkedAds($params)
{
    $paramSearch = $params->getParam(0);
    $search = $paramSearch->scalarval();
    $response = new XML_RPC_Value(serialize(OA_Dal_Delivery_getLinkedAds($search)), 'base64');

    return new XML_RPC_Response($response);
}

function _getZoneInfo($params)
{
    $paramZoneId = $params->getParam(0);
    $zoneId = $paramZoneId->scalarval();
    $response = new XML_RPC_Value(serialize(OA_Dal_Delivery_getZoneInfo($zoneId)), 'base64');

    return new XML_RPC_Response($response);
}

function _getAd($params)
{
    $paramAdId = $params->getParam(0);
    $adId = $paramAdId->scalarval();
    $response = new XML_RPC_Value(serialize(OA_Dal_Delivery_getAd($adId)), 'base64');

    return new XML_RPC_Response($response);
}

function _pluginExecute($params)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    $paramParams = $params->getParam(0);
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
