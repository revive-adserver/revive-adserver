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

$file = '/extensions/deliveryAdRenderer/oxThorium/marketplace.php';
###START_STRIP_DELIVERY
if(isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

require_once MAX_PATH . '/lib/max/Delivery/javascript.php';

/**
 * @package    MaxDelivery
 * @subpackage marketplace
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 *
 * This library defines functions that need to be available to
 * marketplace-enabled delivery engine scripts
 *
 */

function MAX_marketplaceEnabled()
{
    return !empty($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['oxThorium']);
}

/**
 * A function to check if a ping to the ID service is needed
 *
 * @todo Use a cookie
 * @return boolean
 */
function MAX_marketplaceNeedsIndium()
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    return MAX_marketplaceEnabled() && empty($_COOKIE['In']);
}

function MAX_isMarketplaceEnabledPerCampaign($aCampaignThoriumInfo)
{
    return !empty($aCampaignThoriumInfo['is_enabled']);
}

function MAX_marketplaceProcess($scriptFile, $adHtml, $aAd, $aZoneInfo = array(), $aParams = array())
{
    $output = '';
    $aCampaignThoriumInfo = MAX_cacheGetCampaignThoriumInfo($aAd['campaignid']);
    if (MAX_marketplaceEnabled()
        && MAX_isMarketplaceEnabledPerCampaign($aCampaignThoriumInfo))
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $aWebsiteThoriumInfo = MAX_cacheGetWebsiteThoriumInfo($aAd['affiliate_id']);
        if (!empty($adHtml) && !empty($aAd['width']) && !empty($aAd['height'])
            && !empty($aWebsiteThoriumInfo['publisher_id']))
        {

            $cb = mt_rand(0, PHP_INT_MAX);

            $floorPrice = (float) $aCampaignThoriumInfo['floor_price'];

            $baseUrl = 'http://'.$aConf['oxThorium']['thoriumHost'];
            $urlParams = array(
                'pid=' . $aWebsiteThoriumInfo['publisher_id'],
                'tag_type=1',
                'f='.urlencode($floorPrice),
                's='.urlencode($aAd['width'].'x'.$aAd['height']),
            );

            if ($aConf['logging']['adImpressions']) {
                // overwrite the original banner Id
                $beaconHtml = MAX_adRenderImageBeacon($aAd['logUrl'].'&bannerid=-1');
                $beaconHtml = str_replace($aAd['aSearch'], $aAd['aReplace'], $beaconHtml);
            } else {
                $beaconHtml = '';
            }

            switch ($scriptFile) {
                case 'js':
                    $uniqid = substr(md5(uniqid('', 1)), 0, 8);

                    $ntVar  = 'OXT_'.$uniqid;
                    $nfVar  = 'OXF_'.$uniqid;
                    $mktVar = 'OXM_'.$uniqid;

                    $output = "\n";
                    $output .= MAX_javascriptToHTML($adHtml, $nfVar, false);
                    $output .= "\n";
                    $output .= MAX_javascriptToHTML($beaconHtml, $ntVar, false);
                    $output .= "\n";

                    $url = $baseUrl.'/jsox?'.join('&', $urlParams);
                    $url .= '&nt='.urlencode($ntVar);
                    $url .= '&nf='.urlencode($nfVar);
                    $url .= '&cb'.$cb;

                    $output = '<script type="text/javascript" src="'.htmlspecialchars($url).'"></script>';
                    break;
                case 'frame':
                case 'spc':
                    $oVar = 'OXM_'.substr(md5(uniqid('', 1)), 0, 8);

                    $output = '<script type="text/javascript">';
                    $output .= "\n";
                    $output .= "{$oVar} = {\"t\":".
                        MAX_javascriptEncodeJsonField($beaconHtml).
                        ",\"f\":".
                        MAX_javascriptEncodeJsonField($adHtml).
                        "}\n";
                    $output .= "</script>\n";

                    $url = $baseUrl.'/json?'.join('&', $urlParams);
                    $url .= '&o='.urlencode($oVar);
                    $url .= '&cb'.$cb;

                    $output .= '<script type="text/javascript" src="'.htmlspecialchars($url).'"></script>';
                    break;
            }
       }
    }

    return $output;
}

function MAX_marketplaceLogGetIds()
{
    $aAdIds = array();
    if (!empty($_GET['fromMarketplace'])) {
        $aAdIds[0] = -1;
    }
    return $aAdIds;
}

function MAX_cacheGetCampaignThoriumInfo($campaignId, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $campaignId);
    if (!$cached || ($aRow = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aRow = MAX_Dal_Delivery_getCampaignThoriumInfo($campaignId);
        $aRow = OA_Delivery_Cache_store_return($sName, $aRow);
    }

    return $aRow;
}

function MAX_Dal_Delivery_getCampaignThoriumInfo($campaignId)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    $query = "
        SELECT
            is_enabled,
            floor_price
        FROM
            {$aConf['table']['prefix']}ext_thorium_campaign_pref
        WHERE
            campaignid = {$campaignId}";
    $res = OA_Dal_Delivery_query($query);

    if (!is_resource($res)) {
        return false;
    }
    return OA_Dal_Delivery_fetchAssoc($res);
}


function MAX_cacheInvalidateGetCampaignThoriumInfo($campaignId)
{
    require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheCommon.php';
    $oCache = new OA_Cache_DeliveryCacheCommon();
    $sName  = OA_Delivery_Cache_getName('MAX_cacheGetCampaignThoriumInfo', $campaignId);
    return $oCache->invalidateFile($sName);
}

function MAX_cacheGetWebsiteThoriumInfo($websiteId, $cached = true)
{
    $sName  = OA_Delivery_Cache_getName(__FUNCTION__, $websiteId);
    if (!$cached || ($aRow = OA_Delivery_Cache_fetch($sName)) === false) {
        MAX_Dal_Delivery_Include();
        $aRow = MAX_Dal_Delivery_getWebsiteThoriumInfo($websiteId);
        $aRow = OA_Delivery_Cache_store_return($sName, $aRow);
    }

    return $aRow;
}

function MAX_Dal_Delivery_getWebsiteThoriumInfo($websiteId)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    $query = "
        SELECT
            publisher_id
        FROM
            {$aConf['table']['prefix']}ext_thorium_website_pref
        WHERE
            affiliateid = {$websiteId}";
    $res = OA_Dal_Delivery_query($query);

    if (!is_resource($res)) {
        return false;
    }
    return OA_Dal_Delivery_fetchAssoc($res);
}

function MAX_cacheInvalidateGetWebsiteThoriumInfo($websiteId)
{
    require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheCommon.php';
    $oCache = new OA_Cache_DeliveryCacheCommon();
    $sName  = OA_Delivery_Cache_getName('MAX_cacheGetWebsiteThoriumInfo', $websiteId);
    return $oCache->invalidateFile($sName);
}

?>
