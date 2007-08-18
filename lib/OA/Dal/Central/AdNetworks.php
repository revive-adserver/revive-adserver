<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
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
 * OAP binding to the OAC ad networks API
 *
 */
class OA_Dal_Central_AdNetworks
{
    /**
     * @var OA_Central_Rpc
     */
    var $oRpc;

    /**
     * Class constructor
     *
     * @return OA_Dal_Central_adNetworks
     */
    function OA_Dal_Central_AdNetworks()
    {
        $this->oRpc = new OA_Dal_Central_Rpc();
    }

    /**
     * A method to retrieve the localised list of categories and subcategories
     *
     * @see R-AN-3: Gathering the data of Websites during Installation
     * @see R-AN-16: Gathering the Websites after the Installation
     *
     * @param string $language The language name, or an empty string to use OAC default
     * @return mixed The array of categories and subcategories or PEAR_Error on failure
     *               The returned array will have a structure like this:
     *
     * Array
     * (
     *   [1] => Array
     *     (
     *       [name] => Music
     *       [subcategories] => Array
     *         (
     *           [1] => Pop
     *           [2] => Rock
     *         )
     *
     *     )
     *
     * )
     *
     */
    function getCategories($language = '')
    {
        return $this->oRpc->callNoAuth(__METHOD__, array(
            new XML_RPC_Value($language, $GLOBALS['XML_RPC_String'])
        ));
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
     *               PEAR_Error on failure
     */
    function getCountries($language = '')
    {
        return $this->oRpc->callNoAuth(__METHOD__, array(
            new XML_RPC_Value($language, $GLOBALS['XML_RPC_String'])
        ));
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
     *               PEAR_Error on failure
     */
    function getLanguages($language = '')
    {
        return $this->oRpc->callNoAuth(__METHOD__, array(
            new XML_RPC_Value($language, $GLOBALS['XML_RPC_String'])
        ));
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
     *     [0] => Array
     *         (
     *             [url] => http://www.openads.org
     *             [advertisers] => Array
     *                 (
     *                     [0] => Array
     *                         (
     *                             [advertiser_id] => 1551
     *                             [name] => CPX
     *                             [campaigns] => Array
     *                                 (
     *                                     [0] => Array
     *                                         (
     *                                             [campaign_id] => 1782
     *                                             [name] => Test
     *                                             [weight] => 1
     *                                             [capping] => 0
     *                                             [banners] => Array
     *                                                 (
     *                                                     [0] => Array
     *                                                         (
     *                                                             [banner_id] => 2876
     *                                                             [name] => Banner 1
     *                                                             [width] => 468
     *                                                             [height] => 60
     *                                                             [capping] => 0
     *                                                             [html] => <script type="text/javascript"></script>
     *                                                             [adserver] => cpx
     *                                                         )
     *
     *                                                 )
     *
     *                                         )
     *
     *                                 )
     *
     *                         )
     *
     *                     [1] => Array
     *                         (
     *                             [advertiser_id] => 1552
     *                             [name] => Kontera
     *                             [campaigns] => Array
     *                                 (
     *                                     [0] => Array
     *                                         (
     *                                             [campaign_id] => 1783
     *                                             [name] => Test
     *                                             [weight] => 1
     *                                             [capping] => 0
     *                                             [banners] => Array
     *                                                 (
     *                                                     [0] => Array
     *                                                         (
     *                                                             [banner_id] => 2877
     *                                                             [name] => Banner 468x60
     *                                                             [width] => 468
     *                                                             [height] => 60
     *                                                             [capping] => 0
     *                                                             [html] => <script type="text/javascript"></script>
     *                                                             [adserver] => kontera
     *                                                         )
     *
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
     *     [1] => Array
     *         (
     *             [url] => http://www.phpadsnew.com
     *             [advertisers] => Array
     *                 (
     *                     [1553] => Array
     *                         (
     *                             [name] => CPX
     *                             [campaigns] => Array
     *                                 (
     *                                     [1784] => Array
     *                                         (
     *                                             [name] => Test
     *                                             [weight] => 1
     *                                             [capping] => 0
     *                                             [banners] => Array
     *                                                 (
     *                                                     [2878] => Array
     *                                                         (
     *                                                             [name] => Banner 1
     *                                                             [width] => 468
     *                                                             [height] => 60
     *                                                             [capping] => 0
     *                                                             [html] => <script type="text/javascript"></script>
     *                                                             [adserver] => cpx
     *                                                         )
     *
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
        return $this->oRpc->callCaptchaSso(__METHOD__, array(
            XML_RPC_encode($aWebsites)
        ));
    }


    /**
     * A method to get the list of other networks currently available
     *
     * @see C-AN-1: Displaying Ad Networks on Advertisers & Campaigns Screen
     * @see R-AN-17
     *
     * @todo Re-think about it.
     *
     *
     * The result array looks like:
     *
     * Array
     * (
     *     [Google Adsense] => Array
     *         (
     *             [rank] => 1
     *             [data] => Array
     *                 (
     *                     [0] => Array
     *                         (
     *                             [url] => http://adsense.google.com
     *                             [country] =>
     *                             [language] => 1
     *                         )
     *
     *                     [1] => Array
     *                         (
     *                             [url] => http://adsense.google.co.uk
     *                             [country] => uk
     *                             [language] => 1
     *                         )
     *
     *                 )
     *
     *         )
     *
     *     [Advertising.com] => Array
     *         (
     *             [rank] => 2
     *             [data] => Array
     *                 (
     *                     [0] => Array
     *                         (
     *                             [url] => http://adsense.google.com
     *                             [country] =>
     *                             [language] => 1
     *                         )
     *
     *                 )
     *
     *         )
     *
     * )
     *
     * Note: country or language might be null, meaning that there are no country and/or
     *       language constraints
     *
     * @param string $country_code
     * @param int $language_id
     * @return mixed The other networs array (name as key, link as value) on success,
     *               PEAR_Error otherwise
     */
    function getOtherNetworks()
    {
        return $this->oRpc->callNoAuth(__METHOD__);
    }

    /**
     * A method to suggest a new network
     *
     * @see C-AN-1: Displaying Ad Networks on Advertisers & Campaigns Screen
     *
     * @param string $name
     * @param string $url
     * @param string $country_code
     * @param int $language_id
     * @return mixed A boolean True on success, PEAR_Error otherwise
     */
    function suggestNetwork($name, $url, $country, $language_id)
    {
        return $this->oRpc->callCaptchaSso(__METHOD__, array(
            new XML_RPC_Value($name, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($url, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($country_code, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($language_id, $GLOBALS['XML_RPC_Int'])
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
     *                     [revenue] => 10
     *                     [type] => CPC
     *                 )
     *
     *             [1] => Array
     *                 (
     *                     [start] => 2007-08-02 00:00:00
     *                     [end] => 2007-08-02 23:59:59
     *                     [revenue] => 6
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
     *                     [revenue] => 1
     *                     [type] => CPM
     *                 )
     *
     *         )
     *
     * )
     *
     * @param int $batch_sequence
     * @return mixed An array with revenue details if successul, PEAR_Error otherwise
     */
    function getRevenue($batch_sequence)
    {
        return $this->oRpc->callSso(__METHOD__, array(
            new XML_RPC_Value($batch_sequence, $GLOBALS['XML_RPC_Int'])
        ));
    }
}

?>