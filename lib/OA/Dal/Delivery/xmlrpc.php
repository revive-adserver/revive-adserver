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
 * @package    OpenXDal
 * @subpackage Delivery
 * @author     Chris Nutting <chris@m3.net>
 *
 * @todo        There are methods in the mysql.php Dal that will have to be replicated here
 *
 * The XML-RPC data access layer
 *
 * This DAL makes a remote request to the origin server for the requested function
 * It then returns the information retrieved to the delivery engine.
 *
 * It must also return the old cache in case of failure to connect to origin.
 *
 */

// Required files
require_once 'XML/RPC.php';

/**
 * This is the core XML-RPC client it takes the parameters passed in and bundles them up
 * and sends them as an XML-RPC request to the origin server, which processes them against
 * the central database and passes the results back to this client
 *
 * @param string $function  The name of the remote origin function to be called
 * @param array  $params    An array of the parameters to be passed to the origin function
 * @return mixed            The decoded response from the origin server
 */
function getFromOrigin($function, $params)
{
    /**
    * @package    MaxDal
    * @subpackage Delivery
    * @author     Chris Nutting <chris@m3.net>
    *
    */

    $conf = $GLOBALS['_MAX']['CONF'];

    // Create an XML-RPC client to talk to the XML-RPC server
    $client = new XML_RPC_Client($conf['origin']['script'], $conf['origin']['host'], $conf['origin']['port']);
    $message = new XML_RPC_Message($function, array());

    // Add the parameters to the message
	$message->addParam(new XML_RPC_Value($params, $GLOBALS['XML_RPC_String']));

	 // Send the XML-RPC message to the server
    $response = $client->send($message, $conf['origin']['timeout'], $conf['origin']['protocol']);

    if ((!$response) || ($response->faultCode() != 0)) {
        if (defined('OA_DELIVERY_CACHE_FUNCTION_ERROR')) {
            return OA_DELIVERY_CACHE_FUNCTION_ERROR;
        } else {
            return null;
        }
    } else {
        // Decode the serialized response
        $value = $response->value();
        $value = $value->scalarval();
        $value = unserialize($value);
    }
    return $value;
}

/**
 * The function to get and return the ads linked to a zone
 *
 * @param  int   $zoneid The id of the zone to get linked ads for
 * @return array|false
 *               The array containg zone information with nested arrays of linked ads
 *               or false on failure. Note that:
 *                  - Exclusive ads are in "xAds"
 *                  - Normal (paid) ads are in "ads"
 *                  - Low-priority ads are in "lAds"
 *                  - Companion ads, in addition to being in one of the above, are
 *                    also in "cAds" and "clAds"
 *                  - Exclusive and low-priority ads have had their priorities
 *                    calculated on the basis of the placement and advertisement
 *                    weight
 */
function OA_Dal_Delivery_getZoneLinkedAds($zoneId)
{
    return getFromOrigin('getZoneLinkedAds', $zoneId);
}

/**
 * The function to get and return the ads for direct selection
 *
 * @param  string   $search     The search string for this banner selection
 *                              Usually 'bannerid:123' or 'campaignid:123'
 *
 * @return array|false          The array of ads matching the search criteria
 *                              or false on failure
 */
function OA_Dal_Delivery_getLinkedAds($search)
{
    return getFromOrigin('getLinkedAds', $search);
}

/**
 * This function gets zone properties from the databse
 *
 * @param int $zoneid   The ID of the zone to get information about
 * @return array|false  An array containing the properties for that zone
 *                      or false on failure
 */
function OA_Dal_Delivery_getZoneInfo($zoneId)
{
    return getFromOrigin('getZoneInfo', $zoneId);
}


/**
 * The function to get and return a single ad
 *
 * @param  string       $ad_id     The ad id for the specified ad
 *
 * @return array|null   $ad        An array containing the ad data or null if nothing found
 */
function OA_Dal_Delivery_getAd($adId)
{
    return getFromOrigin('getAd', $adId);
}

/**
 * The function to get delivery limitations for a channel
 *
 * @param  int       $channelid    The channelid for the specified channel
 *
 * @return array     $limitations  An array with the acls_plugins, and compiledlimitation
 */
function OA_Dal_Delivery_getChannelLimitations($channelId)
{
    return getFromOrigin('OA_Dal_Delivery_getChannelLimitations', $channelId);
}

/**
 * This function provides an interface to execute a plugin on the remote origin server
 * and return the result
 *
 * @param array $params The parameters to be passed to the origin plugin function
 * @return mixed        The decoded response from the origin server
 */
function MAX_Dal_Delivery_pluginExecute($params)
{
    return getFromOrigin('pluginExecute', serialize($params));
}
?>
