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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Central/Rpc.php';
require_once MAX_PATH . '/lib/OA/Dal/Central/M2M.php';
require_once 'Cache/Lite.php';

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
     * @param OA_Central_Common Caller class
     * @return OA_Dal_Central_adNetworks
     */
    function OA_Central_RpcMapper(&$oCentral)
    {
        $this->oRpc =& new OA_Dal_Central_Rpc($oCentral);
    }

    /**
     * A method to connect the OAP platform and the account Id to OAC
     *
     * Note: Admin connection requires no auth. All other calls need to be M2M authorised
     *
     * @return mixed The M2M password if OAP and it's account is correctly connected to OAC,
     *               PEAR_Error otherwise
     */
    function connectM2M($accountId, $accountType)
    {
        $aParams = array(
            new XML_RPC_Value($accountId, $GLOBALS['XML_RPC_Int']),
            new XML_RPC_Value($accountType, $GLOBALS['XML_RPC_String']),
        );
        $method = $accountType == OA_ACCOUNT_ADMIN ? 'callNoAuth' : 'callM2M';
        $result = $this->oRpc->$method('connectM2M', $aParams);

        return $result;
    }

    /**
     * A method to re-connect the OAP platform and the account Id to OAC, getting a fresh password
     *
     * Note: this method shouldn't ever be called because it's handled at RPC layer,
     *       it is present just for reference
     */
    function reconnectM2M()
    {
        //return $this->oRpc->callM2M('reconnectM2M');
    }

    /**
     * A method to retrieve an M2M authentication ticket
     *
     * @return mixed The ticket string on success, PEAR_Error otherwise
     */
    function getM2MTicket()
    {
        return $this->oRpc->callM2M('getM2MTicket');
    }

    /**
     * Refs R-AN-1: Connecting OpenXPlatform with SSO
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
     * A method to retrieve currency FX feed from central.
     *
     */
    function getFXFeed()
    {
        OA::debug("EXECUTING!");
    	$result = $this->oRpc->callM2M('getFXFeed');
        OA::debug($result);
        return PEAR::isError($result) ? false : $result;
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
     * R2: Introduced {@see OA_Dll status} field for campaigns
     *
     * The $aWebsites array format is:
     *
     * Array
     * (
     *     [0] => Array
     *         (
     *             [url] => http://www.openx.org
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
     *                                     [status] => 0
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
     *                     [url] => http://www.openx.org
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
     *                                     [status] => 2
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
     * A method to update or add zone.
     *
     * The $aZone array format is (for add):
     *
     * Array
     * (
     *      [websiteId]   => 5
     *      [name]        => Test Zone
     *      [description] => My description
     *      [width]       => 60
     *      [height]      => 70
     * )
     *
     *
     * The $aZone array format is (for update):
     *
     * Array
     * (
     *      [id]          => 121
     *      [websiteId]   => 5
     *      [name]        => Test Zone
     *      [description] => My description
     *      [width]       => 60
     *      [height]      => 70
     * )
     *
     *
     * @param array $aZone
     * @param int  zone id
     */
    function updateZone($aZone)
    {
        return $this->oRpc->callNoAuth('updateZone',
                                       array(XML_RPC_encode($aZone)));
    }


    /**
     * A method to delete zone from Ad Networks
     *
     * @param int $zoneId  zone id into Ad Networks
     */
    function deleteZone($zoneId)
    {
        $aId = array('id' => $zoneId);
        return $this->oRpc->callNoAuth('deleteZone',
                                       array(XML_RPC_encode($aId))
                                      );
    }

    /**
     * Call XMLRPC method from central
     * Input - ids advertisers and campain that is in oap
     * Ouptut - advetisers and campain that isn't in oap and is on oac
     *
     * The $requstIds array format
     *
     * Array
     * (
     *      [0]   => Array
     *               (
     *                  [id]            => 11
     *                  [campaigns_ids] => Array
     *                                     (
     *                                      [0] => 12
     *                                      [1] => 133
     *                                     )
     *               )
     *      [1]   => Array
     *               (
     *                  [id]            => 112
     *                  [campaigns_ids] => Array
     *                                     (
     *                                      [0] => 16
     *                                      [1] => 10
     *                                     )
     *               )
     * )
     *
     * The result array format
     *
     * Array
     * (
     *      [websitesAdvertisers]   => Array (
     *          [0] => Array (
     *              [id]           => 11
     *              [country_name] => Albania
     *              [city]         =>
     *              [address]      =>
     *              [post_code]    =>
     *              [campaigns]    => Array (
     *                  [0] => Array (
     *                      [id]         => 55
     *                      [start_date] => 1125485421
     *                      [end_date]   => 1125495421
     *                      [status]     => 1
     *                      [rate]       => 100
     *                      [pricing]    => 0
     *                      [weight]     => 10
     *                      [banners] => Array  (
     *                          [0] => Array (
     *                              [id]  => 34
     *                              [url] => google.com
     *                          )
     *                  )
     *              )
     *          )
     *      )
     * )
     *
     * @param array $requstIds
     * @return array  request result
     */
    function getWebsitesAdvertisers($requstIds)
    {
        return $this->oRpc->callNoAuth('getWebsitesAdvertisers',
                                       array(XML_RPC_encode($requstIds))
                                      );
    }

    /**
     * Call XMLRPC method from central
     *  for set campaign data from oap
     * Input - array data and ids campains from oap
     *
     * The $aCampaigns array format
     *
     * Array
     * (
     *      [21]   => Array
     *               (
     *                  [id]             => 2
     *                  [invocationCode] => ''
     *                  [deliveredCount] => 50
     *               )
     *      [45]   => Array
     *               (
     *                  [id]             => 5
     *                  [invocationCode] => ''
     *                  [deliveredCount] => 0
     *               )
     * )
     *
     * @param array $aCampaigns
     */
    function setCampaignsProperties($aCampaigns)
    {
        return $this->oRpc->callNoAuth('setCampaignsProperties',
                                       array(XML_RPC_encode($aCampaigns))
                                      );
    }

    /**
     * A method to get updates about subscribed websites
     *
     * @see C-AN-2 Website application status
     *
     * The returned array format is:
     *
     * Array
     * (
     *      [10872] => 0
     *      [10873] => 0
     *      [10874] => 1
     *      [10875] => 1
     * )
     *
     * @return mixed The array of campaigns with their statuses, PEAR_Error otherwise
     *               Key is the OAC campaign Id, value is the {@see OA_Dll remote status}
     */
    function getCampaignStatuses()
    {
        return $this->oRpc->callNoAuth('getCampaignStatuses');
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
        $aResult = $this->oRpc->callM2M('getCommunityStats');

        return $aResult;
    }

    /**
     * Google AdSense procedures
     *
     * NOTE:
     * Exceptions mimic the original ones mentioned here:
     * @see http://code.google.com/apis/adsense/developer/adsense_api_error_codes.html
     * but they are increased by 10000
     * so e.g. AdSense exception #301 (User does not have an AdSense account) is mapped to #10301
     *
     */

    /**
     * A method to create AdSense account
     *
     * @param string $loginEmail
     * @param string $websiteUrl
     * @param string $websiteLocale
     * @param string $usersPreferredLocale
     *
     * The result array looks like:
     *
     * Array
     * (
     * 		[adsense_account_id] => 1
     * 		[affiliate_code] => code
     * )
     *
     * @return mixed An array described above on success, PEAR_Error otherwise
     *
     */
    function adsenseCreateAccount($loginEmail, $websiteUrl, $websiteLocale, $usersPreferredLocale)
    {
        return $this->oRpc->callNoAuth('adsenseCreateAccount', array(
            new XML_RPC_Value($loginEmail, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($websiteUrl, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($websiteLocale, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($usersPreferredLocale, $GLOBALS['XML_RPC_String'])
        ));
    }

    /**
     * A method to link AdSense account
     *
     * @param string $loginEmail
     * @param string $postalCode
     * @param string $phone (last 5 digits)
     *
     * The result array looks like:
     *
     * Array
     * (
     * 		[adsense_account_id] => 1
     * 		[affiliate_code] => code
     * )
     *
     * @return mixed An array described above on success, PEAR_Error otherwise
     *
     */
    function adsenseLinkAccount($loginEmail, $postalCode, $phone)
    {
        return $this->oRpc->callNoAuth('adsenseLinkAccount', array(
            new XML_RPC_Value($loginEmail, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($postalCode, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($phone, $GLOBALS['XML_RPC_String'])
        ));
    }

    /**
     * A method to check AdSense account status
     *
     * @see org.openads.adnetworks.adsense.AdSenseAccountStatus enumeration in OAC for details
     * @todo decide on available statuses and put the info here
     *
     * @param int $adsenseAccountId
     * @return mixed Account status (int) on success, PEAR_Error otherwise
     *
     */
    function adsenseGetAccountStatus($adsenseAccountId)
    {
    	return $this->oRpc->callNoAuth('adsenseGetAccountStatus', array(
            new XML_RPC_Value($adsenseAccountId, $GLOBALS['XML_RPC_Int'])
        ));
    }

    /**
     * A method to create AdSense banner
     *
     * @param int $adsenseAccountId
     * @param string $name
     * @param string $backgroundColor
     * @param string $borderColor
     * @param string $textColor
     * @param string $titleColor
     * @param string $urlColor
     * @param string $adUnitType
     * @param string $layout
     * @param boolean $isFramedPage
     *
     * The result array looks like:
     *
     * Array
     * (
     * 		[banner_id] => 1
     * 		[banner_code] => code
     * )
     *
     * @return mixed An array described above on success, PEAR_Error otherwise
     *
     */
	function adsenseCreateBanner($adsenseAccountId, $name, $backgroundColor, $borderColor, $textColor, $titleColor, $urlColor, $adUnitType, $layout, $isFramedPage)
	{
		return $this->oRpc->callNoAuth('adsenseCreateBanner', array(
            new XML_RPC_Value($adsenseAccountId, $GLOBALS['XML_RPC_Int']),
            new XML_RPC_Value($name, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($backgroundColor, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($borderColor, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($textColor, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($titleColor, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($urlColor, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($adUnitType, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($layout, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($isFramedPage, $GLOBALS['XML_RPC_Boolean'])
        ));
	}

    /**
     * A method to update AdSense banner
     *
     * @param int $bannerId
     * @param string $name
     * @param string $backgroundColor
     * @param string $borderColor
     * @param string $textColor
     * @param string $titleColor
     * @param string $urlColor
     * @param string $adUnitType
     * @param string $layout
     * @param boolean $isFramedPage
     *
     * @return mixed A string Banner code on success, PEAR_Error otherwise
     *
     */
	function adsenseUpdateBanner($bannerId, $name, $backgroundColor, $borderColor, $textColor, $titleColor, $urlColor, $adUnitType, $layout, $isFramedPage)
	{
		return $this->oRpc->callNoAuth('adsenseUpdateBanner', array(
			new XML_RPC_Value($bannerId, $GLOBALS['XML_RPC_Int']),
            new XML_RPC_Value($name, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($backgroundColor, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($borderColor, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($textColor, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($titleColor, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($urlColor, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($adUnitType, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($layout, $GLOBALS['XML_RPC_String']),
            new XML_RPC_Value($isFramedPage, $GLOBALS['XML_RPC_Boolean'])
        ));
	}

    /**
     * A method to get AdSense revenue
     *
     * @param int $batchSequence
     *
     * The result array looks like:
     *
     * Array
     * (
     *     [0] => Array
     *         (
     *             [banner_id] => 31337 (int)
     *             [start] => UTC string
     *             [end] => UTC string
     *             [clicks] => 31337 (int)
     *             [impressions] => 31337 (int)
     *             [revenue] => string
     *             [currency] => string (should be constant)
     *             [type] => string (should be constant)
     *         )
     *     [1] => Array
     * 			...
     *	)
     *
     * @return mixed An array described above
     *
     */
	function adsenseGetRevenue($batchSequence)
	{
		return $this->oRpc->callNoAuth('adsenseGetRevenue', array(
			new XML_RPC_Value($batchSequence, $GLOBALS['XML_RPC_Int'])
        ));
	}

    /**
     * A method to get ad unit types and ad layout sizes supported by AdSense
     *
     * The result array looks like:
     *
     * Array
     * (
     *     [FourLinkUnit] => Array
     *         (
     *             [0] => 200x90
     *             [1] => 468x15
     *         )
     *
     *     [ImageOnly] => Array
     *         (
     *             [0] => 336x280
     *             [1] => 250x250
     *         )
     *
     * )
     *
     * @see http://code.google.com/apis/adsense/developer/adsense_api_adformats.html
     *
     * @return mixed An array described above on success, PEAR_Error otherwise
     *
     */
    function adsenseGetUnitTypesAndLayouts()
    {
    	return $this->oRpc->callNoAuth('adsenseGetUnitTypesAndLayouts');
    }


    /**
     * A method to get website locales supported by AdSense
     *
     * The result array looks like:
     *
     * Array
     * (
     *     [0] => Array
     *         (
     *             [name] => English
     *             [code] => en
     *         )
     *
     *     [1] => Array
     *         (
     *             [name] => Chinese (Taiwan)
     *             [code] => zh_TW
     *         )
     *
     * )
     *
     * @see http://code.google.com/apis/adsense/developer/adsense_api_locales.html
     *
     * @return mixed An array described above on success, PEAR_Error otherwise
     *
     */
    function adsenseGetSupportedWebsiteLocales()
    {
    	return $this->oRpc->callNoAuth('adsenseGetSupportedWebsiteLocales');
    }

    /**
     * A method to get user locales supported by AdSense
     *
     * The result array looks like:
     *
     * Array
     * (
     *     [0] => Array
     *         (
     *             [name] => English (United Kingdom)
     *             [code] => en_GB
     *         )
     *
     *     [1] => Array
     *         (
     *             [name] => Polish
     *             [code] => pl
     *         )
     *
     * )
     *
     * @see http://code.google.com/apis/adsense/developer/adsense_api_locales.html
     *
     * @return mixed An array described above on success, PEAR_Error otherwise
     *
     */
    function adsenseGetSupportedUserLocales()
    {
    	return $this->oRpc->callNoAuth('adsenseGetSupportedUserLocales');
    }


}

?>
