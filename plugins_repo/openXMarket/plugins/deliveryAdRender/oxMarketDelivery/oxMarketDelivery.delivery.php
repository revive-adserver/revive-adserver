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
 *  OpenX Market plugin - delivery functions
 *
 * @package    OpenXPlugin
 * @subpackage openXMarket
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 * @author     Chris Nutting <chris.nutting@openx.org>
 */

/**
 * delivery postAdRender hook for OpenX Market
 *
 * @param string $code
 * @param array $aBanner
 */
function Plugin_deliveryAdRender_oxMarketDelivery_oxMarketDelivery_Delivery_postAdRender(&$code, $aBanner)
{
    $aMarketInfo = _marketNeeded($GLOBALS['_OA']['invocationType'], $code, $aBanner);
    if ($aMarketInfo !== false) {
        if ($html = OX_marketProcess($code, $aBanner, $aMarketInfo['campaign'], $aMarketInfo['website'])) {
            $code = $html;
        }
    }
    // PostAdRender hook enriched with $aMarketInfo
    OX_Delivery_Common_hook('oxMarketPostAdRender', array(&$code, $aBanner, $aMarketInfo));
}


/**
 * delivery postAdSelect hook for OpenX Market
 *
 * @param string $output
 */
function Plugin_deliveryAdRender_oxMarketDelivery_oxMarketDelivery_Delivery_postAdSelect(&$output)
{
    // Check if there was no banner selected
    if (empty($output['bannerid']) && !empty($GLOBALS['_MAX']['considered_ads']))
    {
        // Check if invocation tag was read zone info, and zone was linked to  market zone opt-in
        $zoneInfo = $GLOBALS['_MAX']['considered_ads'][0];
        if (isset($zoneInfo['zone_id']) && !empty($zoneInfo['marketZoneOptinAds']))
        {
            // check if there is special banner
            reset($zoneInfo['marketZoneOptinAds']);
            $aAd = current($zoneInfo['marketZoneOptinAds']);
            if (is_array($aAd)) {
                $aAd['campaignid']  = $aAd['placement_id'];
                $aAd['zoneid']      = $zoneInfo['zone_id'];
                $aAd['bannerid']    = $aAd['ad_id'];
                $aAd['storagetype'] = $aAd['type'];
                $aAd['width']       = $zoneInfo['width'];
                $aAd['height']      = $zoneInfo['height'];
                $aAd['affiliate_id'] = $zoneInfo['publisher_id'];
                $aAd['agency_id'] = $zoneInfo['agency_id'];
                $aMarketInfo = _marketNeeded($GLOBALS['_OA']['invocationType'], $output['html'], $aAd);
                if ($aMarketInfo !== false) {
                    if ($html = OX_marketProcess($output['html'], $aAd, $aMarketInfo['campaign'], $aMarketInfo['website'])) {
                        //PostAdRender (yep, we are rendering now banner in postAdSelect) hook enriched with $aMarketInfo
                        OX_Delivery_Common_hook('oxMarketPostAdRender', array(&$html, $aAd, $aMarketInfo));
                    
                        // Do same things as in MAX_adRender after postAdRender hook
                        $output['html'] = MAX_commonConvertEncoding($html, $GLOBALS['charset']);
                    }
                }
            }
        }
    }
}


/**
 * This function checks to see if market processing is needed for the current impression:
 *
 * @param string $scriptFile invocationType (e.g. 'js', 'frame')
 * @param string $code The rendered HTML to display the banner
 * @param array $aAd The array of banner properties
 * @return array of two elements 'campaign' - campaign market info array and 'website' - website market info array; return false if any check failed
 */
function _marketNeeded($scriptFile, $code, $aAd) {
    // Only process requests if the oxMarketDelivery component is enabled
    if (!_marketDeliveryEnabled()) {
        return false;
    }
    // Only process requests from supported tag types
    $aAllowedTypes = array('js', 'frame', 'singlepagecall', 'xmlrpc', 'local');
    if (!in_array($scriptFile, $aAllowedTypes)) {
        return false;
    }
    // Only process if ad size is allowed by market
    $sizes = OX_cacheGetCreativeSizes();
    if (!array_key_exists($aAd['width'].'x'.$aAd['height'], $sizes)) {
        return false;
    }
    
    // Check that this OXP platform or manager is connected to the publisher console
    $aConf = $GLOBALS['_MAX']['CONF'];
    $agency_id = ($aConf['oxMarket']['multipleAccountsMode']) ? $aAd['agency_id'] : null;
    $aPlatformMarketInfo = OX_cacheGetPlatformMarketInfo($agency_id);
    if (empty($aPlatformMarketInfo)) {
        return false;
    }
    
    // Check if this website is market enabled
    $aWebsiteMarketInfo = OX_cacheGetWebsiteMarketInfo(@$aAd['affiliate_id']);
    if (empty($aWebsiteMarketInfo['website_id'])) {
        return false;
    }
    
    // Check if this campaign has the market enabled
    $aCampaignMarketInfo = OX_cacheGetCampaignMarketInfo($aAd['campaignid']);
    if (empty($aCampaignMarketInfo['is_enabled'])) {
        return false;
    }
    
    // If we got this far, then this campaign should be processed for the market
    return array('campaign' => $aCampaignMarketInfo, 'website' => $aWebsiteMarketInfo);
}

function _marketDeliveryEnabled()
{
    return !empty($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['oxMarketDelivery']);
}

function OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo)
{
    $output = '';

    $aConf = $GLOBALS['_MAX']['CONF'];
    if (!empty($aAd['width']) && !empty($aAd['height']) && $aAd['width'] > 0 && $aAd['height'] >0 
        && !empty($aWebsiteMarketInfo['website_id']))
    {
        // TODO: Check if $aAd['width'] && $aAd['height'] are allowed
        $floorPrice = (float) $aCampaignMarketInfo['floor_price'];

        $baseUrl = (!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != 'off')) ? 'https://' : 'http://'; 
        $baseUrl .= $aConf['oxMarketDelivery']['brokerHost'];
        
        $aParams = array(
            'website' => $aWebsiteMarketInfo['website_id'],
            'size' => $aAd['width'].'x'.$aAd['height'],
            'floor' => $floorPrice,
        );
        
        if ($GLOBALS['_OA']['invocationType'] == 'frame') {
            // Iframe invocation needs to pass the current pageUrl and referer to the Market
            if (!empty($GLOBALS['loc'])) {
                $aParams['url'] = $GLOBALS['loc'];
            }
            if (!empty($GLOBALS['referer'])) {
                $aParams['referer'] = $GLOBALS['referer'];
            }
        }
        
        // detect if $aAd is not market banner and 
        // get 'market campaign opt-in' campain banner to channel id
        if (!isset($aAd['ext_bannertype'])
            || $aAd['ext_bannertype'] != 'market-optin-banner') // @see BANNER_TYPE_MARKET in DataObjects_Banners
        {
            // get bannerid, campaignid, clientid for market campaign opt-in
            $aMarketAd = OX_cacheGetCampaignOptInBanner($aAd['agency_id']);
            $aMarketAd = array_merge($aAd,$aMarketAd);
        } else {
            $aMarketAd = $aAd;            
        }
        if (!empty($aMarketAd)) {
            $aParams['channel'] = 'oxpv1:'.$aMarketAd['client_id']."-".$aMarketAd['placement_id']."-".$aMarketAd['ad_id']."-".$aAd['affiliate_id']."-".$aAd['zoneid'];
        }
        
        // Add marketUrlParam hook
        OX_Delivery_Common_hook('addMarketParams', array(&$aParams));
    
        // add one extra function call defined in a plugin - used in events
        if(function_exists('Plugin_deliveryLog_getExtraJsonVariables')) {
             $aParams = array_merge($aParams, $hrid = Plugin_deliveryLog_getExtraJsonVariables());
        }
    
        if(empty($aAd['logUrl'])) {
            $aAd['logUrl'] = html_entity_decode(_adRenderBuildLogURL($aAd, $aAd['zoneid']));
        }
        $localMarketImpressionBeacon = html_entity_decode(_adRenderBuildLogURL($aMarketAd, $aMarketAd['zoneid']));
        if ($aConf['logging']['adImpressions'] 
            && !empty($localMarketImpressionBeacon)) {
            $beaconHtml = MAX_adRenderImageBeacon($localMarketImpressionBeacon);
            if(isset($aAd['aSearch'])) {
                $beaconHtml = str_replace($aAd['aSearch'], $aAd['aReplace'], $beaconHtml);
            }
        } else {
            $beaconHtml = '';
        }
        
        $beaconHtml = str_replace('{random}', MAX_getRandomNumber(), $beaconHtml);

        // Load JS library if needed
        if (!is_callable('MAX_javascriptEncodeJsonField')) {
            require_once MAX_PATH . '/lib/max/Delivery/javascript.php';
        }
        
        $aParams['beacon']   = $beaconHtml;
        $aParams['fallback'] = $adHtml;

        $aJsonParams = array();
        foreach ($aParams as $param => $value) {
            $aJsonParams[] = MAX_javascriptEncodeJsonField($param).":".MAX_javascriptEncodeJsonField($value);
        }
        
        $output = '<script type="text/javascript">';
        $output .= "\n";
        $output .= "OXM_ad = {";
        $output .= join(",\n",$aJsonParams);
        $output .= "};\n";
        $output .= "</script>\n";

        $url = $baseUrl.'/jstag';

        $output .= '<script type="text/javascript" src="'.htmlspecialchars($url).'"></script>'."\n";
        if(!empty($adHtml)) {
            $output .= '<noscript>'.$adHtml.'</noscript>';
        }
   }
   return $output;
}

function OX_marketLogGetIds()
{
    $aAdIds = array();
    if (!empty($_GET['fromMarketplace'])) {
        $aAdIds[0] = -1;
    }
    return $aAdIds;
}

function OX_cacheGetCampaignMarketInfo($campaignId, $cached = true)
{
    if (!function_exists('OA_Delivery_Cache_getName')) {
        require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheCommon.php';
    }
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $campaignId);
    if (!$cached || ($aRow = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aRow = OX_Dal_Delivery_getCampaignMarketInfo($campaignId);
        $aRow = OA_Delivery_Cache_store_return($sName, $aRow);
    }

    return $aRow;
}

function OX_Dal_Delivery_getCampaignMarketInfo($campaignId)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    $query = "
        SELECT
            is_enabled,
            floor_price
        FROM
            {$aConf['table']['prefix']}ext_market_campaign_pref
        WHERE
            campaignid = {$campaignId}";
    $res = OA_Dal_Delivery_query($query);

    if (!is_resource($res)) {
        return false;
    }
    return OA_Dal_Delivery_fetchAssoc($res);
}

function OX_cacheInvalidateGetCampaignMarketInfo($campaignId)
{
    require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheCommon.php';
    $oCache = new OA_Cache_DeliveryCacheCommon();
    $sName  = OA_Delivery_Cache_getName('OX_cacheGetCampaignMarketInfo', $campaignId);
    return $oCache->invalidateFile($sName);
}

function OX_cacheGetWebsiteMarketInfo($websiteId, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $websiteId);
    if (!$cached || ($aRow = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aRow = OX_Dal_Delivery_getWebsiteMarketInfo($websiteId);
        $aRow = OA_Delivery_Cache_store_return($sName, $aRow);
    }

    return $aRow;
}

function OX_Dal_Delivery_getWebsiteMarketInfo($websiteId)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    $query = "
        SELECT
            website_id
        FROM
            {$aConf['table']['prefix']}ext_market_website_pref
        WHERE
            affiliateid = {$websiteId}";
    $res = OA_Dal_Delivery_query($query);

    if (!is_resource($res)) {
        return false;
    }
    return OA_Dal_Delivery_fetchAssoc($res);
}

function OX_cacheInvalidateGetWebsiteMarketInfo($websiteId)
{
    require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheCommon.php';
    $oCache = new OA_Cache_DeliveryCacheCommon();
    $sName  = OA_Delivery_Cache_getName('OX_cacheGetWebsiteMarketInfo', $websiteId);
    return $oCache->invalidateFile($sName);
}


function OX_cacheGetPlatformMarketInfo($agency_id, $cached = true)
{
    if (!function_exists('OA_Delivery_Cache_getName')) {
        require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheCommon.php';
    }
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $agency_id);
    if (!$cached || ($aRow = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aRow = OX_Dal_Delivery_getPlatformMarketInfo($agency_id);
        $aRow = OA_Delivery_Cache_store_return($sName, $aRow);
    }

    return $aRow;
}

/**
 * This function returns a boolean if this OXP or manager account in 
 * multiple accounts mode is connected to the publisher console
 *
 * @param int agency_id used to determine account id in multiple accounts mode 
 * @return boolean true if this platform is connected to the publisher console, false otherwise
 */
function OX_Dal_Delivery_getPlatformMarketInfo($agency_id = null, $account_id = null)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    if (is_null($account_id)) {
        if($aConf['oxMarket']['multipleAccountsMode']) {
            $agency_id = (int)$agency_id;
            $query = "
                SELECT 
                    account_id as value
                FROM
                    {$aConf['table']['prefix']}{$aConf['table']['agency']}
                WHERE
                    agencyid = {$agency_id}
            ";
        } else {
            $query = "
                SELECT
                    value
                FROM
                    {$aConf['table']['prefix']}{$aConf['table']['application_variable']}
                WHERE
                    name = 'admin_account_id'
            ";
        };                
        
        $res = OA_Dal_Delivery_query($query);

        if (is_resource($res)) {
            $aRes = OA_Dal_Delivery_fetchAssoc($res);
            if ($aRes && isset($aRes['value'])) {
                $account_id = $aRes['value'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    $query = "
        SELECT
            status
        FROM
            {$aConf['table']['prefix']}ext_market_assoc_data
        WHERE
            account_id = {$account_id}    
    ";
    
    $res = OA_Dal_Delivery_query($query);
    
    if (is_resource($res)) {
        $aRes = OA_Dal_Delivery_fetchAssoc($res);
        if ($aRes && isset($aRes['status'])) {
            // Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS === 0
            return ((int)$aRes['status'] === 0); 
        } else {
            return false;
        }
    } else {
        return false;
    }
    return true;
}

function OX_cacheGetCampaignOptInBanner($agency_id, $cached = true)
{
    if (!function_exists('OA_Delivery_Cache_getName')) {
        require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheCommon.php';
    }
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $agency_id);
    if (!$cached || ($aRow = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aRow = OX_Dal_Delivery_getCampaignOptInBanner($agency_id);
        $aRow = OA_Delivery_Cache_store_return($sName, $aRow);
    }

    return $aRow;
}


/**
 * Search for bannerid form CAMPAIGN_TYPE_MARKET_CAMPAIGN_OPTIN type campaign for given agency
 *
 * @param int $agency_id agency
 * @returns array array of client_id, placement_id, ad_id of market campaign optin or empty array if banner not found 
 */
function OX_Dal_Delivery_getCampaignOptInBanner($agency_id)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    $query = "
        SELECT 
            a.clientid as client_id,
            c.campaignid as placement_id,
            b.bannerid as ad_id
        FROM 
            {$aConf['table']['prefix']}{$aConf['table']['clients']} a
            INNER JOIN {$aConf['table']['prefix']}{$aConf['table']['campaigns']} c ON a.clientid = c.clientid
            INNER JOIN {$aConf['table']['prefix']}{$aConf['table']['banners']} b ON c.campaignid = b.campaignid
        WHERE
            a.agencyid = {$agency_id} AND a.type = 1 AND c.type = 1
            ";
    $res = OA_Dal_Delivery_query($query);

    if (!is_resource($res)) {
        return array();
    }
    return OA_Dal_Delivery_fetchAssoc($res);
}


function OX_cacheGetCreativeSizes($cached = true)
{
    if (!function_exists('OA_Delivery_Cache_getName')) {
        require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheCommon.php';
    }
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__);
    if (!$cached || ($aRow = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aRow = OX_marketGetCreativeSizes();
        $aRow = OA_Delivery_Cache_store_return($sName, $aRow);
    }
    return $aRow;
}


/**
 * Read IAB Banners data from cache created by UI or permament plugin cache files
 * Returns array of supported creative sizes each item is an array:
 * key is a string 'width'x'height'
 * each array contains fields: 'id' (int), 'name' (string), 'width' (int), 'height' (int)
 * 
 * @return array 
 */
function OX_marketGetCreativeSizes()
{
    setupIncludePath(); // set PEAR path if not set
    require_once MAX_PATH . '/www/admin/plugins/oxMarket/library/OX/oxMarket/Common/Cache.php';
    $oCache = new OX_oxMarket_Common_Cache('CreativeSizes', 'oxMarket', null);
    $oCache->setFileNameProtection(false);
    $aData = $oCache->load(true);
    if ($aData == false) {
        $oCache = new OX_oxMarket_Common_Cache('CreativeSizes', 'oxMarket', 
                                        null, MAX_PATH . '/www/admin/plugins/oxMarket/var/data/dictionary/');
        $oCache->setFileNameProtection(false);
        $aData = $oCache->load(true);
        if ($aData == false) {
            // Empty array if there is no permament dictionary data
            $aData = array();
        }
    }
    return $aData;
}

function Plugin_deliveryAdRender_oxMarketDelivery_oxMarketDelivery_Delivery_preAdSelect(&$aAds, &$context, &$source, &$richMedia)
{
    if (!empty($aAds['zone_id']) && !empty($aAds['ads'])) 
    {
        $bestSize = OX_marketGetBestBannerSizeForZone($aAds);
        foreach ($aAds['ads'] as $priority => &$aBanners) {
            foreach ($aBanners as $bannerId => &$aBanner) {
                if ($aBanner['width'] == -1 && $aBanner['height'] == -1) {
                    if ($bestSize !== false) {
                        $aBanner['width']  = $bestSize['width'];
                        $aBanner['height'] = $bestSize['height'];
                    }
                    else {
                        //remove market banners if zone size is not supported
                        unset($aBanners[$bannerId]); 
                    }
                }
            }
        }
        // separate zone opt in banners   
        // -3 is DataObjects_Campaigns::PRIORITY_MARKET_REMNANT
        if (!empty($aAds['ads'][-3])) {
            $aAds['marketZoneOptinAds'] = $aAds['ads'][-3];
            unset($aAds['ads'][-3]);
        }
    }
}

function OX_marketGetBestBannerSizeForZone($zoneInfo)
{
    $bestSize = array('width' => 0, 'height' => 0);
    $sizes = OX_cacheGetCreativeSizes();
    // find best matching market size  
    foreach($sizes as $size) {
        // only check matching sizes
        if (($zoneInfo['width'] == -1 || $zoneInfo['width'] == $size['width']) &&
         ($zoneInfo['height'] == -1 || $zoneInfo['height'] == $size['height']))
        {
            // best Size is longest one (width is more important than height)
            if ($bestSize['width'] < $size['width'] ||
                ($bestSize['width'] == $size['width'] && $bestSize['height'] < $size['height'])) {
                $bestSize['width'] = $size['width'];
                $bestSize['height'] = $size['height'];
            }
        }
    } 
    if ($bestSize['width'] != 0) {
        return $bestSize;
    }
    return false;
}