<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH.'/lib/OA.php';
require_once MAX_PATH.'/lib/OA/Dal/Central/Rpc.php';


/**
 * OAP binding to the OAC APIs
 *
 */
class OA_Central_RpcMapper
{
    /**
     * @var OA_Dal_Central_Rpc
     */
    var $oRpc;

    /**
     * Class constructor
     *
     * @return OA_Dal_Central_adNetworks
     */
    function OA_Central_RpcMapper()
    {
        $this->oRpc = new OA_Dal_Central_Rpc();
    }

    /**
     * Refs R-AN-1: Connecting Openads Platform with SSO
     *
     * @todo Need clarification
     *
     * @return mixed A boolean True if the platform is correctly connected to OAC,
     *               PEAR_Error otherwise
     */
    function connectOAPToOAC($username, $password)
    {
        $this->oRpc->ssoUsername = $username;
        $this->oRpc->ssoPassword = $password;

        return $this->oRpc->callSSo('connectOAPToOAC');
    }

    /**
     * A method to retrieve the localised list of categories and subcategories
     *
     * @see R-AN-3: Gathering the data of Websites during Installation
     * @see R-AN-16: Gathering the Websites after the Installation
     *
     * @param string $language The language name, or an empty string to use OAC default
     * @return mixed The array of categories and subcategories or false on failure
     *               The returned array will have a structure like this:
     *
     * Array
     * (
     *   [10] => Array
     *     (
     *       [name] => Music
     *       [subcategories] => Array
     *         (
     *           [21] => Pop
     *           [22] => Rock
     *         )
     *
     *     )
     *
     * )
     *
     */
    function getCategories($language = '')
    {
        $result = $this->oRpc->callNoAuth('getCategories', array(
            new XML_RPC_Value($language, $GLOBALS['XML_RPC_String'])
        ));

        if (PEAR::isError($result)) {
            return false;
        }

        return $result;
    }

    /**
     * A method to retrieve the localised list of countries
     *
     * @see R-AN-3: Gathering the data of Websites during Installation
     * @see R-AN-16: Gathering the Websites after the Installation
     * @see C-AN-1: Displaying Ad Networks on Advertisers & Campaigns Screen
     *
     * @param string $language The language name, or an empty string to use OAC default
     * @return mixed The array of countries, with country identifiers as keys, or
     *               false on failure
     */
    function getCountries($language = '')
    {
        $result = $this->oRpc->callNoAuth('getCountries', array(
            new XML_RPC_Value($language, $GLOBALS['XML_RPC_String'])
        ));

        if (PEAR::isError($result)) {
            return false;
        }

        return $result;
    }

    /**
     * A method to retrieve the localised list of languages
     *
     * @see R-AN-3: Gathering the data of Websites during Installation
     * @see R-AN-16: Gathering the Websites after the Installation
     * @see C-AN-1: Displaying Ad Networks on Advertisers & Campaigns Screen
     *
     * @param string $language The language name, or an empty string to use OAC default
     * @return mixed The array of languages, with language identifiers as keys, or
     *               false on failure
     */
    function getLanguages($language = '')
    {
        $result = $this->oRpc->callNoAuth('getLanguages', array(
            new XML_RPC_Value($language, $GLOBALS['XML_RPC_String'])
        ));

        if (PEAR::isError($result)) {
            return false;
        }

        return $result;
    }

    /**
     * A method to subscribe one or more websites to the Ad Networks program
     *
     * @see R-AN-3: Gathering the data of Websites during Installation
     * @see R-AN-4: Creation of the Ad Networks Entities
     * @see R-AN-5: Generation of Campaigns and Banners
     *
     * The $aWebsites array format is:
     *
     * Array
     * (
     *     [0] => Array
     *         (
     *             [url] => http://www.openads.org
     *             [category] => 5
     *             [country] => GB
     *             [language] => 1
     *         )
     *
     *     [1] => Array
     *         (
     *             [url] => http://www.phpadsnew.com
     *             [category] => 5
     *             [country] => US
     *             [language] => 1
     *         )
     *
     * )
     *
     *
     * The result format is:
     *
     * Array
     * (
     *     [adnetworks] => Array
     *         (
     *             [0] => Array
     *                 (
     *                     [adnetwork_id] => 1
     *                     [name] => Beccati.com
     *                 )
     *
     *         )
     *
     *     [websites] => Array
     *         (
     *             [0] => Array
     *                 (
     *                     [website_id] => 2345
     *                     [url] => http://www.beccati.com
     *                     [campaigns] => Array
     *                         (
     *                             [0] => Array
     *                                 (
     *                                     [campaign_id] => 2000
     *                                     [adnetwork_id] => 1
     *                                     [name] => Campaign 1
     *                                     [weight] => 1
     *                                     [block] => 0
     *                                     [capping] => 0
     *                                     [session_capping] => 0
     *                                     [banners] => Array
     *                                         (
     *                                             [0] => Array
     *                                                 (
     *                                                     [banner_id] => 3000
     *                                                     [name] => Banner 1
     *                                                     [width] => 468
     *                                                     [height] => 60
     *                                                     [block] => 0
     *                                                     [capping] => 0
     *                                                     [session_capping] => 0
     *                                                     [html] => ...
     *                                                     [adserver] =>
     *                                                 )
     *
     *                                             [1] => Array
     *                                                 (
     *                                                     [banner_id] => 3002
     *                                                     [name] => Banner 2
     *                                                     [width] => 125
     *                                                     [height] => 125
     *                                                     [block] => 0
     *                                                     [capping] => 0
     *                                                     [session_capping] => 0
     *                                                     [html] => ...
     *                                                     [adserver] =>
     *                                                 )
     *
     *                                         )
     *
     *                                 )
     *
     *                         )
     *
     *                 )
     *
     *             [1] => Array
     *                 (
     *                     [website_id] => 2346
     *                     [url] => http://www.openads.org
     *                     [campaigns] => Array
     *                         (
     *                             [0] => Array
     *                                 (
     *                                     [campaign_id] => 2001
     *                                     [adnetwork_id] => 1
     *                                     [name] => Campaign 1
     *                                     [weight] => 1
     *                                     [block] => 0
     *                                     [capping] => 0
     *                                     [session_capping] => 0
     *                                     [banners] => Array
     *                                         (
     *                                             [0] => Array
     *                                                 (
     *                                                     [banner_id] => 3001
     *                                                     [name] => Banner 1
     *                                                     [width] => 468
     *                                                     [height] => 60
     *                                                     [block] => 0
     *                                                     [capping] => 0
     *                                                     [session_capping] => 0
     *                                                     [html] => ...
     *                                                     [adserver] =>
     *                                                 )
     *
     *                                         )
     *
     *                                 )
     *
     *                         )
     *
     *                 )
     *
     *         )
     *
     * )
     *
     *
     * @param array $aWebsites
     * @return mixed The array of campaigns and banners if successful, PEAR_Error
     *               otherwise
     */
    function subscribeWebsites($aWebsites)
    {
        return $this->oRpc->callCaptcha('subscribeWebsites', array(
            XML_RPC_encode($aWebsites)
        ));
    }

    /**
     * A method to unsubscribe websites
     *
     * @param array $aWebsiteIds
     */
    function unsubscribeWebsites($aWebsiteIds)
    {
        return $this->oRpc->callNoAuth('unsubscribeWebsites', array(
            XML_RPC_encode($aWebsiteIds)
        ));
    }

    /**
     * A method to get the list of other networks currently available
     *
     * @see C-AN-1: Displaying Ad Networks on Advertisers & Campaigns Screen
     * @see R-AN-17: Refreshing the Other Ad Networks List
     *
     * The result array looks like:
     *
     * Array
     * (
     *     [Google Adsense] => Array
     *         (
     *             [rank] => 1
     *             [url] => http://adsense.google.com
     *             [is_global'] =>
     *             [countries] => Array
     *                 (
     *                     [us] => http://adsense.google.com
     *                     [uk] => http://adsense.google.co.uk
     *                 )
     *
     *             [languages] => Array
     *                 (
     *                     [0] => 1
     *                     [1] => 2
     *                 )
     *
     *         )
     *
     *     [Advertising.com] => Array
     *         (
     *             [rank] => 2
     *             [url] => http://www.advertising.com
     *             [is_global'] => 1
     *             [countries] => Array
     *                 (
     *                 )
     *
     *             [languages] => Array
     *                 (
     *                 )
     *
     *         )
     *
     * )
     *
     * @return mixed The other networs array on success, false otherwise
     */
    function getOtherNetworks()
    {
        $result = $this->oRpc->callNoAuth('getOtherNetworks');

        if (PEAR::isError($result)) {
            return false;
        }

        return $result;
    }

    /**
     * A method to suggest a new network
     *
     * @see C-AN-1: Displaying Ad Networks on Advertisers & Campaigns Screen
     *
     * @todo Decide if it's better to implement this using an XML-RPC call and
     *       having OAC to send an email to the operator, or have OAP directly
     *       send the email
     *
     * @param string $name
     * @param string $url
     * @param string $country
     * @param int $language
     * @return mixed A boolean True on success, PEAR_Error otherwise
     */
    function suggestNetwork($name, $url, $country, $language)
    {
        return $this->oRpc->callCaptchaSso('suggestNetwork', array(
            new XML_RPC_Value($name, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($url, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($country, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($language, $GLOBALS['XML_RPC_Int'])
        ));
    }

    /**
     * A method to retrieve the revenue information until last GMT midnight
     *
     * @see R-AN-7: Synchronizing the revenue information
     *
     * The result array looks like:
     *
     * Array
     * (
     *     [2876] => Array
     *         (
     *             [0] => Array
     *                 (
     *                     [start] => 2007-08-01 00:00:00
     *                     [end] => 2007-08-01 23:59:59
     *                     [revenue] => 10.54
     *                     [type] => CPC
     *                 )
     *
     *             [1] => Array
     *                 (
     *                     [start] => 2007-08-02 00:00:00
     *                     [end] => 2007-08-02 23:59:59
     *                     [revenue] => 6.34
     *                     [type] => CPC
     *                 )
     *
     *         )
     *
     *     [2877] => Array
     *         (
     *             [0] => Array
     *                 (
     *                     [start] => 2007-08-02 00:00:00
     *                     [end] => 2007-08-02 23:59:59
     *                     [revenue] => 1.23
     *                     [type] => CPM
     *                 )
     *
     *         )
     *
     * )
     *
     * @param int $batchSequence
     * @return mixed An array with revenue details if successul, PEAR_Error otherwise
     */
    function getRevenue($batchSequence)
    {
        $aResult = $this->oRpc->callSso('getRevenue', array(
            new XML_RPC_Value($batchSequence, $GLOBALS['XML_RPC_Int'])
        ));

        return $aResult;
    }

    /**
     * A method to retrieve the data needed to draw the Community Statistics
     * graph widget
     *
     *  Array
     *  (
     *      [impressions] => Array
     *          (
     *              [Mon] => 1000
     *              [Sun] => 1000
     *              [Sat] => 1000
     *              [Fri] => 1000
     *              [Thu] => 1000
     *              [Wed] => 1000
     *              [Tue] => 1000
     *          )
     *
     *      [clicks] => Array
     *          (
     *              [Mon] => 10
     *              [Sun] => 10
     *              [Sat] => 10
     *              [Fri] => 10
     *              [Thu] => 10
     *              [Wed] => 10
     *              [Tue] => 10
     *          )
     *
     *  )
     *
     * @return array An array with statistics details, PEAR_Error otherwise
     */
    function getCommunityStats()
    {
        $aResult = $this->oRpc->callSso('getCommunityStats');

        return $aResult;
    }
}

?>
