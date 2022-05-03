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
 * @package    MaxDelivery
 * @subpackage ad
 *
 * This library contains the functions to select and generate the HTML for an ad
 *
 * The code below makes several references to an "ad-array", this is /almost/ an ad-object, and implements
 * the following interface.
 *
 * Array
 *   (
 *       [ad_id] => 123
 *       [placement_id] => 4
 *       [active] => t
 *       [name] => Web Flash (With backup)
 *       [type] => web
 *       [contenttype] => swf
 *       [pluginversion] => 6
 *       [filename] => banner_468x60.swf
 *       [imageurl] =>
 *       [htmltemplate] =>
 *       [htmlcache] =>
 *       [width] => 468
 *       [height] => 60
 *       [weight] => 1
 *       [seq] => 0
 *       [target] => _blank
 *       [url] => http://www.example.net/landing_page/
 *       [alt] =>
 *       [status] =>
 *       [bannertext] =>
 *       [adserver] =>
 *       [block] => 0
 *       [capping] => 0
 *       [session_capping] => 0
 *       [compiledlimitation] =>
 *       [acl_plugins] =>
 *       [prepend] =>
 *       [append] =>
 *       [bannertype] => 0
 *       [alt_filename] => backup_banner_468x60.gif
 *       [alt_imageurl] =>
 *       [alt_contenttype] => gif
 *       [campaign_priority] => 5
 *       [campaign_weight] => 0
 *       [campaign_companion] => 0
 *       [priority] => 0.10989010989
 *       [zoneid] => 567
 *       [bannerid] => 123
 *       [storagetype] => web
 *       [campaignid] => 4
 *       [zone_companion] =>
 *       [prepend] =>
 *   )
 *
 */

/**
 * This is the code that renders the HTML required to display an ad
 *
 * @param array   $aBanner      The array of banner properties for the banner to be rendered
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $target       The target attribute for generated <a href> links
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param boolean $withtext     Should "text below banner" be appended to the generated code
 * @param string  $charset      Character set to convert the rendered output into
 * @param boolean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $logView      Should this view be logged (views in admin should not be logged
 *                              also - 3rd party callback logging should not be logged at view time)
 * @param boolean $richMedia    Does this invocation method allow for serving 3rd party/html ads
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 * @param array   $context      The context of this ad selection
 *                              - used for companion positioning
 *                              - and excluding banner/campaigns from this ad-call
 *
 * @return string   The HTML to display this ad
 */
function MAX_adRender(array &$aBanner, int $zoneId = 0, string $source = '', string $target = '', string $ct0 = '', bool $withText = false, string $charset = '', bool $logClick = true, bool $logView = true, bool $richMedia = true, string $loc = '', string $referer = null, array &$context = [])
{
    $aBanner['bannerContent'] = "";

    // Sanitize these user-inputted variables before passing to the _adRender* calls
    if (empty($target)) {
        $target = !empty($aBanner['target']) ? $aBanner['target'] : '_blank';
    }
    $target = htmlspecialchars($target, ENT_QUOTES);
    $source = htmlspecialchars($source, ENT_QUOTES);

    // Pre adRender hook
    OX_Delivery_Common_hook('preAdRender', [&$aBanner, &$zoneId, &$source, &$ct0, &$withText, &$logClick, &$logView, null, &$richMedia, &$loc, &$referer]);

    $functionName = _getAdRenderFunction($aBanner, $richMedia);
    $code = OX_Delivery_Common_hook('adRender', [&$aBanner, &$zoneId, &$source, &$ct0, &$withText, &$logClick, &$logView, null, &$richMedia, &$loc, &$referer], $functionName);

    // Get URL and image prefixes, stripping the traling slash
    $urlPrefix = rtrim(MAX_commonGetDeliveryUrl(), '/');
    $imgUrlPrefix = rtrim(_adRenderBuildImageUrlPrefix(), '/');

    // Build magic macros with logurl first
    $aMagicMacros = [
        '{timestamp}' => MAX_commonGetTimeNow(),
        '{random}' => MAX_getRandomNumber(),
        '{target}' => $target,
        '{url_prefix}' => $urlPrefix,
        '{img_url_prefix}' => $imgUrlPrefix,
        '{bannerid}' => $aBanner['ad_id'],
        '{zoneid}' => $zoneId,
        '{source}' => $source,
        '{pageurl}' => urlencode($loc),
        '{width}' => $aBanner['width'],
        '{height}' => $aBanner['height'],
        '{websiteid}' => $aBanner['affiliate_id'] ?? 0,
        '{campaignid}' => $aBanner['placement_id'],
        '{advertiserid}' => $aBanner['client_id'],
        '{referer}' => $referer ?? '',
        '{rel}' => _adRenderBuildRelAttribute($aBanner),
        '{logurl}' => '', // Placeholder
        '{logurl_enc}' => '', // Placeholder
        '{logurl_html}' => '', // Placeholder
        '{clickurl}' => '', // Placeholder
        '{clickurl_enc}' => '', // Placeholder
        '{clickurl_html}' => '', // Placeholder
    ];

    // Site Variables in the banner code and destination
    preg_match_all('#{([a-zA-Z0-9_]*?)(_enc)?}#', $aBanner['url'] . "\n" . $code, $aMatches);
    for ($i = 0; $i < count($aMatches[1]); $i++) {
        if (isset($aMagicMacros[$aMatches[0][$i]])) {
            continue;
        }

        if (!isset($_REQUEST[$aMatches[1][$i]])) {
            continue;
        }

        $value = stripslashes($_REQUEST[$aMatches[1][$i]]);

        $aMagicMacros[$aMatches[0][$i]] = empty($macros[2][$i]) ?
            htmlspecialchars($value, ENT_QUOTES) :
            urlencode($value);
    }

    // addUrlParams hook for plugins to add key=value pairs to the log/click URLs
    $componentParams = OX_Delivery_Common_hook('addUrlParams', [$aBanner]);
    if (!empty($componentParams) && is_array($componentParams)) {
        foreach ($componentParams as $params) {
            if (!empty($params) && is_array($params)) {
                foreach ($params as $key => $value) {
                    $key = '{' . $key . '}';

                    if (isset($aMagicMacros[$key])) {
                        continue;
                    }

                    $aMagicMacros[$key] = urlencode($value);
                }
            }
        }
    }

    // Pass over the search / replace patterns
    $aBanner['aMagicMacros'] = $aMagicMacros;

    // Now all custom click URLs, either plain or urlencoded, at the top of the list
    preg_match_all('#{clickurl(|_enc|_html)}((https?(?::|%3[aA]))?(//|%2[fF]%2[fF])[^ ]+?)(?=[\'" ])#', $code, $aMatches);
    for ($i = 0; $i < count($aMatches[2]); $i++) {
        if (isset($aMagicMacros[$aMatches[0][$i]])) {
            continue;
        }

        // Decode custom dest, if urlencoded
        $dest = '//' === $aMatches[4][$i] ? $aMatches[2][$i] : urldecode($aMatches[2][$i]);

        // Treat protocol relative URL as https
        if (empty($aMatches[3][$i])) {
            $dest = 'https:' . $dest;
        }

        $dest = _adRenderBuildSignedClickUrl($aBanner, $zoneId, $source, $ct0, $logClick, $dest);

        switch ($aMatches[1][$i]) {
            case '_enc':
                $dest = urlencode($dest);
                break;

            case '_html':
                $dest = htmlspecialchars($dest, ENT_QUOTES);
                break;
        }

        // Full click urls needs to be replaced first, as the search pattern might contain macros which
        // would otherwise be replaced already by the time the end of the array is reached.
        $aMagicMacros = [$aMatches[0][$i] => $dest] + $aMagicMacros;
    }

    // And finally log and click URLs
    $aBanner['logUrl'] = _adRenderBuildLogURL($aBanner, $zoneId, $source, $loc, $referer, '&');
    $aBanner['clickUrl'] = _adRenderBuildSignedClickUrl($aBanner, $zoneId, $source, $ct0, $logClick);

    // We can remove placeholders now
    unset($aMagicMacros['{logurl}'], $aMagicMacros['{logurl_enc}'], $aMagicMacros['{logurl_html}'], $aMagicMacros['{clickurl}'], $aMagicMacros['{clickurl_enc}'], $aMagicMacros['{clickurl_html}']);

    // So that the following magic macros are replaced last
    $aMagicMacros['{logurl}'] = $aBanner['logUrl'];
    $aMagicMacros['{logurl_enc}'] = urlencode($aBanner['logUrl']);
    $aMagicMacros['{logurl_html}'] = htmlspecialchars($aBanner['logUrl'], ENT_QUOTES);
    $aMagicMacros['{clickurl}'] = $aBanner['clickUrl'];
    $aMagicMacros['{clickurl_enc}'] = urlencode($aBanner['clickUrl']);
    $aMagicMacros['{clickurl_html}'] = htmlspecialchars($aBanner['clickUrl'], ENT_QUOTES);

    // Update magic macros + Backwards compatible search / replace patterns
    $aBanner['aMagicMacros'] = $aMagicMacros;
    $aBanner['aSearch'] = array_keys($aMagicMacros);
    $aBanner['aReplace'] = array_values($aMagicMacros);

    // Do all the replacement
    $code = _adRenderReplaceMagicMacros($aBanner, $code);

    // post adRender hook
    OX_Delivery_Common_hook('postAdRender', [&$code, $aBanner, &$context]);

    return MAX_commonConvertEncoding($code, $charset);
}

/**
 * This function builds the HTML to display a 1x1 logging beacon
 *
 * @param string $logUrl    The log URL
 * @param string $beaconId  The ID of the HTML beacon tag, an underscore plus a random string will be appended
 * @param array  $userAgent The optional user agent, if null $_SERVER[HTTP_USER_AGENT]
 *                          will be used
 * @return string The HTML to show the 1x1 logging beacon
 */
function MAX_adRenderImageBeacon($logUrl, $beaconId = 'beacon', $userAgent = null)
{
    if (!isset($userAgent) && isset($_SERVER['HTTP_USER_AGENT'])) {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
    }
    $beaconId .= '_{random}';
    // Add beacon image for logging
    if (isset($userAgent) && preg_match("#Mozilla/(1|2|3|4)#", $userAgent)
        && !preg_match("#compatible#", $userAgent)) {
        $div = "<layer id='{$beaconId}' width='0' height='0' border='0' visibility='hide'>";
        $style = '';
        $divEnd = '</layer>';
    } else {
        $div = "<div id='{$beaconId}' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'>";
        $style = " style='width: 0px; height: 0px;'";
        $divEnd = '</div>';
    }
    $beacon = "$div<img src='" . htmlspecialchars($logUrl, ENT_QUOTES) . "' width='0' height='0' alt=''{$style} />{$divEnd}";
    return $beacon;
}

/**
 * This function builds the HTML to display a 1x1 logging beacon for a blank impression
 *
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 *
 * @return string The HTML to show the 1x1 logging beacon
 */
function MAX_adRenderBlankBeacon($zoneId, $source, $loc, $referer)
{
    $logUrl = _adRenderBuildLogURL([
        'ad_id' => 0,
        'placement_id' => 0,
    ], $zoneId, $source, $loc, $referer, '&');

    return str_replace('{random}', MAX_getRandomNumber(), MAX_adRenderImageBeacon($logUrl));
}

/**
 * This function builds the HTML code to display an "image" ad (e.g. GIF/JPG/PNG)
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
 * @param boolean $useAppend    Should any appended code appended to the banner be output?
 *
 * @return string               The HTML to display this ad
 */
function _adRenderImage(&$aBanner, $zoneId = 0, $source = '', $ct0 = '', $withText = false, $logClick = true, $logView = true, $useAlt = false, $richMedia = true, $loc = '', $referer = '', $context = [], $useAppend = true)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $aBanner['bannerContent'] = $imageUrl = _adRenderBuildFileUrl($aBanner, $useAlt);

    if (!$richMedia) {
        return _adRenderBuildFileUrl($aBanner, $useAlt);
    }
    $prepend = (!empty($aBanner['prepend']) && $useAppend) ? $aBanner['prepend'] : '';
    $append = (!empty($aBanner['append']) && $useAppend) ? $aBanner['append'] : '';

    // Create the anchor tag..
    if (!empty($aBanner['url'])) {  // There is a link
        $status = _adRenderBuildStatusCode($aBanner);
        $clickTag = "<a href='{clickurl_html}' target='{target}' rel='{rel}'{$status}>";
        $clickTagEnd = '</a>';
    } else {
        $clickTag = '';
        $clickTagEnd = '';
    }
    // Create the image tag..
    if (!empty($imageUrl)) {
        $imgStatus = empty($clickTag) && !empty($status) ? $status : '';
        $width = !empty($aBanner['width']) ? $aBanner['width'] : 0;
        $height = !empty($aBanner['height']) ? $aBanner['height'] : 0;
        $alt = !empty($aBanner['alt']) ? htmlspecialchars($aBanner['alt'], ENT_QUOTES) : '';
        $imageTag = "$clickTag<img src='" . htmlspecialchars($imageUrl, ENT_QUOTES) . "' width='$width' height='$height' alt='$alt' title='$alt' border='0'$imgStatus />$clickTagEnd";
    } else {
        $imageTag = '';
    }
    // Get the text below the banner
    $bannerText = $withText && !empty($aBanner['bannertext']) ? "<br />$clickTag" . htmlspecialchars($aBanner['bannertext'], ENT_QUOTES) . "$clickTagEnd" : '';
    // Get the image beacon...
    $beaconTag = ($logView && $conf['logging']['adImpressions']) ? _adRenderImageBeacon($aBanner, $zoneId, $source, $loc, $referer) : '';
    return $prepend . $imageTag . $bannerText . $beaconTag . $append;
}

/**
 * This function generates the code to show an "HTML" ad (usually 3rd party adserver code)
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
function _adRenderHtml(&$aBanner, $zoneId = 0, $source = '', $ct0 = '', $withText = false, $logClick = true, $logView = true, $useAlt = false, $richMedia = true, $loc = '', $referer = '', $context = [])
{
    // This is a wrapper to the "parent" bannerTypeHtml function
    if (!function_exists('Plugin_BannerTypeHtml_delivery_adRender')) {
        _includeDeliveryPluginFile('/lib/OX/Extension/bannerTypeHtml/bannerTypeHtmlDelivery.php');
    }

    return Plugin_BannerTypeHtml_delivery_adRender($aBanner, $zoneId, $source, $ct0, $withText, $logClick, $logView, $useAlt, $richMedia, $loc, $referer);
}

/**
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
function _adRenderText(&$aBanner, $zoneId = 0, $source = '', $ct0 = '', $withText = false, $logClick = true, $logView = true, $useAlt = false, $richMedia = false, $loc = '', $referer = '', $context = [])
{
    // This is a wrapper to the "parent" bannerTypeHtml function
    $aConf = $GLOBALS['_MAX']['CONF'];
    if (!function_exists('Plugin_BannerTypeText_delivery_adRender')) {
        @include LIB_PATH . '/Extension/bannerTypeText/bannerTypeTextDelivery.php';
    }
    return Plugin_BannerTypeText_delivery_adRender($aBanner, $zoneId, $source, $ct0, $withText, $logClick, $logView, $useAlt, $richMedia, $loc, $referer);
}

/**
 * This method builds the URL to an uploaded creative.
 *
 * @param array   $aBanner  The ad-array for the ad to render code for
 * @param boolean $useAlt   Should the backup file be used for this code
 * @param string  $params   Any additional parameters that should be passed to the creative
 * @return string   The URL to the creative
 */
function _adRenderBuildFileUrl($aBanner, $useAlt = false, $params = '')
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $fileUrl = '';
    if ($aBanner['type'] == 'url') {
        $fileUrl = $useAlt ? $aBanner['alt_imageurl'] : $aBanner['imageurl'];
        if (!empty($params)) {
            $fileUrl .= "?{$params}";
        }
    } else {
        $fileName = $useAlt ? $aBanner['alt_filename'] : $aBanner['filename'];
        $params = !empty($params) ? $params : '';
        if (!empty($fileName)) {
            if ($aBanner['type'] == 'web') {
                $fileUrl = _adRenderBuildImageUrlPrefix() . "/{$fileName}";
                if (!empty($params)) {
                    $fileUrl .= "?{$params}";
                }
            } elseif ($aBanner['type'] == 'sql') {
                $fileUrl = MAX_commonGetDeliveryUrl($conf['file']['image']) . "?filename={$fileName}&contenttype={$aBanner['contenttype']}";
                if (!empty($params)) {
                    $fileUrl .= "&{$params}";
                }
            }
        }
    }
    return $fileUrl;
}

/**
 * This function gets the server address and path for local images
 *
 * @return string The URL to access the images folder
 */
function _adRenderBuildImageUrlPrefix()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    return $GLOBALS['_MAX']['SSL_REQUEST'] ? 'https://' . $conf['webpath']['imagesSSL'] : 'http://' . $conf['webpath']['images'];
}

/**
 * This function builds the URL to the logging beacon
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 * @param string  $amp          The seperator to use for joining parameters (&amp; is XHTML compliant
 *                              for when writing out to a page, & is necessary when redirecting directly
 * @return string  The logging beacon URL
 */
function _adRenderBuildLogURL($aBanner, $zoneId = 0, $source = '', $loc = '', $referer = '', $amp = '&amp;', $fallBack = false)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    // If there is an OpenX->OpenX internal redirect, log both zones information
    $delimiter = $GLOBALS['_MAX']['MAX_DELIVERY_MULTIPLE_DELIMITER'];

    $logLastAction = (!empty($aBanner['viewwindow']) && !empty($aBanner['tracker_status'])) ? '1' : '';

    if (!empty($GLOBALS['_MAX']['adChain'])) {
        foreach ($GLOBALS['_MAX']['adChain'] as $index => $ad) {
            $aBanner['ad_id'] .= $delimiter . $ad['ad_id'];
            $aBanner['placement_id'] .= $delimiter . $ad['placement_id'];
            $zoneId .= $delimiter . $ad['zoneid'];
            $aBanner['block_ad'] .= $delimiter . $ad['block_ad'];
            $aBanner['cap_ad'] .= $delimiter . $ad['cap_ad'];
            $aBanner['session_cap_ad'] .= $delimiter . $ad['session_cap_ad'];
            $aBanner['block_campaign'] .= $delimiter . $ad['block_campaign'];
            $aBanner['cap_campaign'] .= $delimiter . $ad['cap_campaign'];
            $aBanner['session_cap_campaign'] .= $delimiter . $ad['session_cap_campaign'];
            $aBanner['block_zone'] .= $delimiter . $ad['block_zone'];
            $aBanner['cap_zone'] .= $delimiter . $ad['cap_zone'];
            $aBanner['session_cap_zone'] .= $delimiter . $ad['session_cap_zone'];
            $logLastAction .= $delimiter . (!empty($ad['viewwindow']) && !empty($ad['tracker_status'])) ? '1' : '0';
        }
    }
    $url = MAX_commonGetDeliveryUrl($conf['file']['log']);
    $url .= "?" . $conf['var']['adId'] . "=" . $aBanner['ad_id'];
    $url .= $amp . $conf['var']['campaignId'] . "=" . $aBanner['placement_id'];
    $url .= $amp . $conf['var']['zoneId'] . "=" . $zoneId;
    if (!empty($source)) {
        $url .= $amp . $conf['var']['channel'] . "=" . $source;
    }
    if (!empty($aBanner['block_ad'])) {
        $url .= $amp . $conf['var']['blockAd'] . "=" . $aBanner['block_ad'];
    }
    if (!empty($aBanner['cap_ad'])) {
        $url .= $amp . $conf['var']['capAd'] . "=" . $aBanner['cap_ad'];
    }
    if (!empty($aBanner['session_cap_ad'])) {
        $url .= $amp . $conf['var']['sessionCapAd'] . "=" . $aBanner['session_cap_ad'];
    }
    if (!empty($aBanner['block_campaign'])) {
        $url .= $amp . $conf['var']['blockCampaign'] . "=" . $aBanner['block_campaign'];
    }
    if (!empty($aBanner['cap_campaign'])) {
        $url .= $amp . $conf['var']['capCampaign'] . "=" . $aBanner['cap_campaign'];
    }
    if (!empty($aBanner['session_cap_campaign'])) {
        $url .= $amp . $conf['var']['sessionCapCampaign'] . "=" . $aBanner['session_cap_campaign'];
    }
    if (!empty($aBanner['block_zone'])) {
        $url .= $amp . $conf['var']['blockZone'] . "=" . $aBanner['block_zone'];
    }
    if (!empty($aBanner['cap_zone'])) {
        $url .= $amp . $conf['var']['capZone'] . "=" . $aBanner['cap_zone'];
    }
    if (!empty($aBanner['session_cap_zone'])) {
        $url .= $amp . $conf['var']['sessionCapZone'] . "=" . $aBanner['session_cap_zone'];
    }
    if (!empty($logLastAction)) {
        $url .= $amp . $conf['var']['lastView'] . "=" . $logLastAction;
    }
    if (!empty($loc)) {
        $url .= $amp . "loc=" . urlencode($loc);
    }
    if (!empty($referer)) {
        $url .= $amp . "referer=" . urlencode($referer);
    }
    if (!empty($fallBack)) {
        $url .= $amp . $conf['var']['fallBack'] . '=1';
    }
    $url .= $amp . "cb={random}";

    // addUrlParams hook for plugins to add key=value pairs to the log/click URLs
    $componentParams = OX_Delivery_Common_hook('addUrlParams', [$aBanner]);
    if (!empty($componentParams) && is_array($componentParams)) {
        foreach ($componentParams as $params) {
            if (!empty($params) && is_array($params)) {
                foreach ($params as $key => $value) {
                    $url .= $amp . urlencode($key) . '=' . urlencode($value);
                }
            }
        }
    }

    return _adRenderReplaceMagicMacros($aBanner, $url);
}

/**
 * This function builds the HTML to display the 1x1 logging beacon
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 * @param string  $logUrl       The log URL, if empty, it will be generated automatically (default)
 *
 * @return string   The HTML to show the 1x1 logging beacon
 */
function _adRenderImageBeacon($aBanner, $zoneId = 0, $source = '', $loc = '', $referer = '', $logUrl = '')
{
    if (empty($logUrl)) {
        $logUrl = _adRenderBuildLogURL($aBanner, $zoneId, $source, $loc, $referer, '&');
    }
    return MAX_adRenderImageBeacon($logUrl);
}

/**
 * This function builds a query string params for the signed click cl.php script.
 *
 * @param array $aBanner
 * @param int $zoneId
 * @param string $source
 * @param string|null $ct0
 * @param bool $logClick
 * @param string|null $customDestination
 *
 * @return string
 */
function _adRenderBuildClickQueryString(array $aBanner, int $zoneId = 0, string $source = '', bool $logClick = true, string $customDestination = null): string
{
    // HACK - sometimes $aBanner has the banner ID as bannerid, and others it is ad_id.  This needs
    //  to be sorted in all parts of the application to reference ad_id rather than bannerid.
    if (isset($aBanner['ad_id']) && empty($aBanner['bannerid'])) {
        $aBanner['bannerid'] = $aBanner['ad_id'];
    }

    $conf = $GLOBALS['_MAX']['CONF'];
    $delimiter = $GLOBALS['_MAX']['MAX_DELIVERY_MULTIPLE_DELIMITER'];

    $logLastClick = (!empty($aBanner['clickwindow'])) ? '1' : '';
    // If there is an OpenX->OpenX internal redirect, log both zones information
    if (!empty($GLOBALS['_MAX']['adChain'])) {
        foreach ($GLOBALS['_MAX']['adChain'] as $index => $ad) {
            $aBanner['bannerid'] .= $delimiter . $ad['bannerid'];
            $aBanner['placement_id'] .= $delimiter . $ad['placement_id'];
            $zoneId .= $delimiter . $ad['zoneid'];
            $logLastClick .= (!empty($aBanner['clickwindow'])) ? '1' : '0';
        }
    }

    $aParams = [
        $conf['var']['adId'] => $aBanner['bannerid'] ?? '0',
        $conf['var']['zoneId'] => $zoneId,
    ];

    if (!empty($source)) {
        $aParams['source'] = $source;
    }

    if (!$logClick) {
        $aParams[$conf['var']['logClick']] = 'no';
    }

    if (!empty($logLastClick)) {
        $aParams[$conf['var']['lastClick']] = $logLastClick;
    }

    $dest = _adRenderReplaceMagicMacros($aBanner, $customDestination ?? $aBanner['url'] ?? '');

    if ($dest) {
        // Destination signature
        $aParams[$conf['var']['signature']] = OX_Delivery_Common_getClickSignature(
            $aBanner['bannerid'] ?? 0,
            $zoneId,
            $dest
        );
        $aParams[$conf['var']['dest']] = $dest;
    } elseif ($conf['delivery']['clickUrlValidity'] > 0) {
        // Timestamp signature
        $aParams[$conf['var']['timestamp']] = (string) MAX_commonGetTimeNow();
        $aParams[$conf['var']['signature']] = OX_Delivery_Common_getClickSignature(
            $aBanner['bannerid'] ?? 0,
            $zoneId,
            $aParams[$conf['var']['timestamp']]
        );
        $aParams[$conf['var']['dest']] = '';
    }

    return http_build_query($aParams);
}

function _adRenderReplaceMagicMacros(array $aBanner, string $input): string
{
    if (!isset($aBanner['aMagicMacros'])) {
        return $input;
    }

    return str_replace(
        array_keys($aBanner['aMagicMacros']),
        array_values($aBanner['aMagicMacros']),
        $input
    );
}

function _adRenderBuildSignedClickUrl(array $aBanner, int $zoneId = 0, string $source = '', string $ct0 = null, bool $logClick = true, string $customDestination = null): string
{
    $clickUrl = MAX_commonGetDeliveryUrl($GLOBALS['_MAX']['CONF']['file']['signedClick']) . '?' .
        _adRenderBuildClickQueryString($aBanner, $zoneId, $source, $logClick, $customDestination);

    if (null === $ct0 || !preg_match('#^https?://#', $ct0)) {
        return $clickUrl;
    }

    return $ct0 . urlencode($clickUrl);
}

/**
 * This function builds the custom params string (the params string uses a custom delimiter to avoid problems
 * when passing in plain (non-url encoded) destination URLs
 *
 * @deprecated Use _adRenderBuildSignedClickUrl
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param boolean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $overrideDest Should the URL from the banner override a passed in destination?
 *
 * @return string The params string
 */

function _adRenderBuildParams($aBanner, $zoneId = 0, $source = '', $ct0 = '', $logClick = true, $overrideDest = false)
{
    // HACK - sometimes $aBanner has the banner ID as bannerid, and others it is ad_id.  This needs
    //  to be sorted in all parts of the application to reference ad_id rather than bannerid.
    if (isset($aBanner['ad_id']) && empty($aBanner['bannerid'])) {
        $aBanner['bannerid'] = $aBanner['ad_id'];
    }

    $conf = $GLOBALS['_MAX']['CONF'];
    $delimiter = $GLOBALS['_MAX']['MAX_DELIVERY_MULTIPLE_DELIMITER'];

    $logLastClick = (!empty($aBanner['clickwindow'])) ? '1' : '';
    // If there is an OpenX->OpenX internal redirect, log both zones information
    if (!empty($GLOBALS['_MAX']['adChain'])) {
        foreach ($GLOBALS['_MAX']['adChain'] as $index => $ad) {
            $aBanner['bannerid'] .= $delimiter . $ad['bannerid'];
            $aBanner['placement_id'] .= $delimiter . $ad['placement_id'];
            $zoneId .= $delimiter . $ad['zoneid'];
            $logLastClick .= (!empty($aBanner['clickwindow'])) ? '1' : '0';
        }
    }

    $maxparams = '';
    if (!empty($aBanner['url']) || $overrideDest) {
        // There is a link
        $del = $conf['delivery']['ctDelimiter'];
        $delnum = strlen($del);
        $random = "{$del}{$conf['var']['cacheBuster']}={random}";
        $bannerId = !empty($aBanner['bannerid']) ? "{$del}{$conf['var']['adId']}={$aBanner['bannerid']}" : '';
        $zoneId = "{$del}{$conf['var']['zoneId']}={$zoneId}";
        $source = !empty($source) ? "{$del}source=" . urlencode($source) : '';

        $log = $logClick ? '' : "{$del}{$conf['var']['logClick']}=no";
        $log .= (!empty($logLastClick)) ? $del . $conf['var']['lastClick'] . '=' . $logLastClick : '';

        $maxparams = $delnum . $bannerId . $zoneId . $source . $log . $random;
        // addUrlParams hook for plugins to add key=value pairs to the log/click URLs
        $componentParams = OX_Delivery_Common_hook('addUrlParams', [$aBanner]);
        if (!empty($componentParams) && is_array($componentParams)) {
            foreach ($componentParams as $params) {
                if (!empty($params) && is_array($params)) {
                    foreach ($params as $key => $value) {
                        $maxparams .= $del . urlencode($key) . '=' . urlencode($value);
                    }
                }
            }
        }
    }

    return $maxparams;
}

/**
 * This function builds the Click through URL for this ad
 *
 * @deprecated Use _adRenderBuildSignedClickUrl
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param boolean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $overrideDest Should the URL from the banner override a passed in destination?
 *
 * @return string The click URL
 */
function _adRenderBuildClickUrl($aBanner, $zoneId = 0, $source = '', $ct0 = '', $logClick = true, $overrideDest = false)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    if (empty($aBanner['url']) && !$overrideDest) {
        return '';
    }

    return MAX_commonGetDeliveryUrl($conf['file']['click']) . '?' . $conf['var']['params'] . '=' . _adRenderBuildParams($aBanner, $zoneId, $source, $ct0, $logClick, $overrideDest);
}

/**
 * Generate the Javascript onMouseOver self.status code to attempt to set the browser status bar text
 * Note: Most modern browsers prevent this feature
 *
 * @param array $aBanner The ad-array for the ad to generate status code for
 * @return string The
 */
function _adRenderBuildStatusCode($aBanner)
{
    return !empty($aBanner['status']) ? " onmouseover=\"self.status='" . addslashes($aBanner['status']) . "'; return true;\" onmouseout=\"self.status=''; return true;\"" : '';
}

function _adRenderBuildRelAttribute($aBanner)
{
    return htmlspecialchars($GLOBALS['_MAX']['CONF']['delivery']['relAttribute'] ?? '', ENT_QUOTES);
}

function _getAdRenderFunction($aBanner, $richMedia = true)
{
    $functionName = false;
    if (!empty($aBanner['ext_bannertype'])) {
        return OX_Delivery_Common_getFunctionFromComponentIdentifier($aBanner['ext_bannertype'], 'adRender');
    } else {
        switch ($aBanner['contenttype']) {
            case 'gif':
            case 'jpeg':
            case 'png':
            case 'webp':
                $functionName = '_adRenderImage';
                break;
            case 'txt':
                    $functionName = '_adRenderText';
                break;
            default:
                switch ($aBanner['type']) {
                    case 'html':
                        $functionName = '_adRenderHtml';
                        break;
                    case 'url': // External banner without a recognised content type - assume image...
                        $functionName = '_adRenderImage';
                        break;
                    case 'txt':
                        $functionName = '_adRenderText';
                        break;
                    default:
                        $functionName = '_adRenderHtml';
                        break;
                }
                break;
        }
    }
    return $functionName;
}
