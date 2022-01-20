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
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 * @abstract
 *
 * This function generates the code to show a "text" ad
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param int     $withText     Should "text below banner" be appended to the generated code
 * @param boolean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $logView      Should this view be logged (views in admin should not be logged
 *                              also - 3rd party callback logging should not be logged at view time)
 * @param boolean $useAlt       Should the backup file be used for this code
 * @param boolean $richMedia    Does this invocation method allow for serving 3rd party/html ads
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 *
 * @return string               The HTML to display this ad
 */
function Plugin_BannerTypeText_delivery_adRender(&$aBanner, $zoneId = 0, $source = '', $ct0 = '', $withText = false, $logClick = true, $logView = true, $useAlt = false, $richMedia = true, $loc, $referer)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $prepend = !empty($aBanner['prepend']) ? $aBanner['prepend'] : '';
    $append = !empty($aBanner['append']) ? $aBanner['append'] : '';
    $aBanner['bannerContent'] = $aBanner['bannertext'];

    // Create the anchor tag..
    if (!empty($aBanner['url'])) {  // There is a link
        $status = _adRenderBuildStatusCode($aBanner);
        $target = !empty($aBanner['target']) ? $aBanner['target'] : '_blank';
        $clickTag = "<a href='{clickurl_html}' target='{$target}' rel='{rel}'{$status}>";
        $clickTagEnd = '</a>';
    } else {
        $clickTag = '';
        $clickTagEnd = '';
    }
    // Get the text below the banner
    $bannerText = !empty($aBanner['bannertext']) ? "$clickTag{$aBanner['bannertext']}$clickTagEnd" : '';
    // Get the image beacon...
    $beaconTag = ($logView && $conf['logging']['adImpressions']) ? _adRenderImageBeacon($aBanner, $zoneId, $source, $loc, $referer) : '';
    return $prepend . $bannerText . $beaconTag . $append;
}
