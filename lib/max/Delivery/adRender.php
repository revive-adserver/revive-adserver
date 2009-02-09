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
 * @package    MaxDelivery
 * @subpackage ad
 * @author     Chris Nutting <chris@m3.net>
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
 *       [append] =>
 *       [appendtype] => 0
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
 * @param bookean $logClick     Should this click be logged (clicks in admin should not be logged)
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
function MAX_adRender(&$aBanner, $zoneId=0, $source='', $target='', $ct0='', $withText=false, $charset = '', $logClick=true, $logView=true, $richMedia=true, $loc='', $referer='', $context = array())
{
    $conf = $GLOBALS['_MAX']['CONF'];

    // Sanitize these user-inputted variables before passing to the _adRenderX calls
    if (empty($target)) {
        $target = !empty($aBanner['target']) ? $aBanner['target'] : '_blank';
    }
    $target = htmlspecialchars($target, ENT_QUOTES);
    $source = htmlspecialchars($source, ENT_QUOTES);
	$aBanner['bannerContent'] = "";

	// Pre adRender hook
	OX_Delivery_Common_hook('preAdRender', array(&$aBanner, &$zoneId, &$source, &$ct0, &$withText, &$logClick, &$logView, null, &$richMedia, &$loc, &$referer));

	$functionName = _getAdRenderFunction($aBanner, $richMedia);
	$code = OX_Delivery_Common_hook('adRender', array(&$aBanner, &$zoneId, &$source, &$ct0, &$withText, &$logClick, &$logView, null, &$richMedia, &$loc, &$referer), $functionName);

    // Transform any code

    // Get a timestamp
    list($usec, $sec) = explode(' ', microtime());
    $time = (float)$usec + (float)$sec;
    // Get a random number
    $random = substr(md5(uniqid($time, true)), 0, 10);
    global $cookie_random;  // Temporary fix to get doubleclick tracking working (Bug # 88)
    $cookie_random = $random;
    // Get the click URL
    $clickUrl = _adRenderBuildClickUrl($aBanner, $zoneId, $source, urlencode($ct0), $logClick, true);
	// Get URL prefix, stripping the traling slash
    $urlPrefix = substr(MAX_commonGetDeliveryUrl(), 0, -1);

    $code = str_replace('{clickurl}', $clickUrl, $code);  // This step needs to be done separately because {clickurl} can contain {random}...
    if (strpos($code, '{logurl}') !== false) {
        $logUrl = _adRenderBuildLogURL($aBanner, $zoneId, $source, $loc, $referer, '&');
        $code = str_replace('{logurl}', $logUrl, $code);  // This step needs to be done separately because {logurl} does contain {random}...
    }
    if (strpos($code, '{logurl_enc}') !== false) {
        $logUrl_enc = urlencode(_adRenderBuildLogURL($aBanner, $zoneId, $source, $loc, $referer, '&'));
        $code = str_replace('{logurl_enc}', $logUrl_enc, $code);  // This step needs to be done separately because {logurl} does contain {random}...
    }
    if (strpos($code, '{clickurlparams}')) {
        $maxparams = _adRenderBuildParams($aBanner, $zoneId, $source, urlencode($ct0), $logClick, true);
        $code = str_replace('{clickurlparams}', $maxparams, $code);  // This step needs to be done separately because {clickurlparams} does contain {random}...
    }
    $search = array('{timestamp}','{random}','{target}','{url_prefix}','{bannerid}','{zoneid}','{source}', '{pageurl}', '{width}', '{height}', '{websiteid}', '{campaignid}', '{advertiserid}');
    $locReplace = isset($GLOBALS['loc']) ? $GLOBALS['loc'] : '';
    $websiteid = (!empty($aBanner['affiliate_id'])) ? $aBanner['affiliate_id'] : '0';
    $replace = array($time, $random, $target, $urlPrefix, $aBanner['ad_id'], $zoneId, $source, urlencode($locReplace), $aBanner['width'], $aBanner['height'], $websiteid, $aBanner['campaign_id'], $aBanner['client_id']);

    preg_match_all('#{(.*?)(_enc)?}#', $code, $macros);
    for ($i=0;$i<count($macros[1]);$i++) {
        if (!in_array($macros[0][$i], $search) && isset($_REQUEST[$macros[1][$i]])) {
            $search[] = $macros[0][$i];
            $replace[] = (!empty($macros[2][$i])) ? urlencode(stripslashes($_REQUEST[$macros[1][$i]])) : stripslashes($_REQUEST[$macros[1][$i]]);
        }
    }

    $code = str_replace($search, $replace, $code);

    $clickUrl = str_replace($search, $replace, $clickUrl);
    $aBanner['clickUrl'] = $clickUrl;

    $logUrl = _adRenderBuildLogURL($aBanner, $zoneId, $source, $loc, $referer, '&');
    $logUrl = str_replace($search, $replace, $logUrl);
    $aBanner['logUrl'] = $logUrl;

    // Pass over the search / replace patterns
    $aBanner['aSearch']  = $search;
    $aBanner['aReplace'] = $replace;

	// post adRender hook
	OX_Delivery_Common_hook('postAdRender', array(&$code, $aBanner));

//    return $code;
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
    $beacon = "$div<img src='".htmlspecialchars($logUrl)."' width='0' height='0' alt=''{$style} />{$divEnd}";
    return $beacon;
}


/**
 * This function builds the HTML code to display an "image" ad (e.g. GIF/JPG/PNG)
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param int     $withText     Should "text below banner" be appended to the generated code
 * @param bookean $logClick     Should this click be logged (clicks in admin should not be logged)
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
function _adRenderImage(&$aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=true, $logView=true, $useAlt=false, $richMedia=true, $loc, $referer, $useAppend=true)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $aBanner['bannerContent'] = $imageUrl = _adRenderBuildFileUrl($aBanner, $useAlt);

    if (!$richMedia) {
        return _adRenderBuildFileUrl($aBanner, $useAlt);
    }
    $prepend = (!empty($aBanner['prepend']) && $useAppend) ? $aBanner['prepend'] : '';
    $append = (!empty($aBanner['append']) && $useAppend) ? $aBanner['append'] : '';

    // Create the anchor tag..
    $clickUrl = _adRenderBuildClickUrl($aBanner, $zoneId, $source, $ct0, $logClick);
    if (!empty($clickUrl)) {  // There is a link
        $status = _adRenderBuildStatusCode($aBanner);
        //$target = !empty($aBanner['target']) ? $aBanner['target'] : '_blank';
        $clickTag = "<a href='$clickUrl' target='{target}'$status>";
        $clickTagEnd = '</a>';
    } else {
        $clickTag = '';
        $clickTagEnd = '';
    }
    // Create the image tag..
    if (!empty($imageUrl)) {
        $imgStatus = empty($clickTag) ? $status : '';
        $width = !empty($aBanner['width']) ? $aBanner['width'] : 0;
        $height = !empty($aBanner['height']) ? $aBanner['height'] : 0;
        $alt = !empty($aBanner['alt']) ? $aBanner['alt'] : '';
        $imageTag = "$clickTag<img src='$imageUrl' width='$width' height='$height' alt='$alt' title='$alt' border='0'$imgStatus />$clickTagEnd";
    } else {
        $imageTag = '';
    }
    // Get the text below the banner
    $bannerText = $withText && !empty($aBanner['bannertext']) ? "<br />$clickTag{$aBanner['bannertext']}$clickTagEnd" : '';
    // Get the image beacon...
    $beaconTag = ($logView && $conf['logging']['adImpressions']) ? _adRenderImageBeacon($aBanner, $zoneId, $source, $loc, $referer) : '';
    return $prepend . $imageTag . $bannerText . $beaconTag . $append;
}

/**
 * This function generates the code to show a "flash" ad
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param int     $withText     Should "text below banner" be appended to the generated code
 * @param bookean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $logView      Should this view be logged (views in admin should not be logged
 *                              also - 3rd party callback logging should not be logged at view time)
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 *
 * @return string               The HTML to display this ad
 */
function _adRenderFlash(&$aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=true, $logView=true, $loc, $referer)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $prepend = !empty($aBanner['prepend']) ? $aBanner['prepend'] : '';
    $append = !empty($aBanner['append']) ? $aBanner['append'] : '';
    $width = !empty($aBanner['width']) ? $aBanner['width'] : 0;
    $height = !empty($aBanner['height']) ? $aBanner['height'] : 0;
    $pluginVersion = !empty($aBanner['pluginversion']) ? $aBanner['pluginversion'] : '4';
    // $imageUrlPrefix = ($_SERVER['SERVER_PORT'] == $conf['openads']['sslPort']) ? $conf['type_web_ssl_url'] : $conf['type_web_url'];
    $altImageAdCode = !empty($aBanner['alt_filename'])
        ? _adRenderImage($aBanner, $zoneId, $source, $ct0, false, $logClick, false, true, true, $loc, $referer, false)
        // An empty image is required because the javascript is parsed before the DOM tree
        : "<img src='" . _adRenderBuildImageUrlPrefix() . '/1x1.gif' . "' alt='".$aBanner['alt']."' title='".$aBanner['alt']."' border='0' />";
    // Create the anchor tag..

    $clickUrl = _adRenderBuildClickUrl($aBanner, $zoneId, $source, $ct0, $logClick);
    if (!empty($clickUrl)) {  // There is a link
        $status = _adRenderBuildStatusCode($aBanner);
        $target = !empty($aBanner['target']) ? $aBanner['target'] : '_blank';
        $swfParams = array('clickTARGET' => $target, 'clickTAG' => $clickUrl);
        $clickTag = "<a href='$clickUrl' target='$target'$status>";
        $clickTagEnd = '</a>';
    } else {
        $swfParams = array();
        $clickTag = '';
        $clickTagEnd = '';
    }

    if (!empty($aBanner['parameters'])) {
        $aAdParams = unserialize($aBanner['parameters']);
        if (isset($aAdParams['swf']) && is_array($aAdParams['swf'])) {
            // Converted SWF file, use paramters content
            $swfParams = array();
            $aBannerSwf = $aBanner;
            // Set the flag to let _adRenderBuildClickUrl know that we're not using clickTAG
            $aBannerSwf['noClickTag'] = true;
            foreach ($aAdParams['swf'] as $iKey => $aSwf) {
                $aBannerSwf['url'] = $aSwf['link'];
                $swfParams["alink{$iKey}"] = _adRenderBuildClickUrl($aBannerSwf, $zoneId, $source, $ct0, $logClick);
                $swfParams["atar{$iKey}"]  = $aSwf['tar'];
            }
        }
    }
    $fileUrl = _adRenderBuildFileUrl($aBanner, false);
    $rnd = md5(microtime());

    $swfId = (!empty($aBanner['alt']) ? $aBanner['alt'] : 'Advertisement');

    $code = "
<div id='ox_$rnd' style='display: inline;'>$altImageAdCode</div>
<script type='text/javascript'><!--/"."/ <![CDATA[
    var ox_swf = new FlashObject('{$fileUrl}', '{$swfId}', '{$width}', '{$height}', '{$pluginVersion}');\n";
    foreach ($swfParams as $key => $value) {
        // URL encode the value, but leave any Openads "magic macros" unescaped to allow substitution
        $code .= "    ox_swf.addVariable('{$key}', '" . preg_replace('#%7B(.*?)%7D#', '{$1}', urlencode($value)) . "');\n";
    }
    if (!empty($aBanner['transparent'])) {
        $code .= "\n   ox_swf.addParam('wmode','transparent');";
    }
    $code .= "
    ox_swf.addParam('allowScriptAccess','always');
    ox_swf.write('ox_$rnd');
/"."/ ]]> --></script>";

    $bannerText = $withText && !empty($aBanner['bannertext']) ? "<br />{$clickTag}{$aBanner['bannertext']}{$clickTagEnd}" : '';
    $beaconTag = ($logView && $conf['logging']['adImpressions']) ? _adRenderImageBeacon($aBanner, $zoneId, $source, $loc, $referer) : '';

    return $prepend . $code . $bannerText . $beaconTag . $append;
}

/**
 * This function generates the code to show a "quicktime" ad (e.g. MOV)
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param int     $withText     Should "text below banner" be appended to the generated code
 * @param bookean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $logView      Should this view be logged (views in admin should not be logged
 *                              also - 3rd party callback logging should not be logged at view time)
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 *
 * @return string               The HTML to display this ad
 */
function _adRenderQuicktime(&$aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=true, $logView=true, $loc, $referer)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $prepend = !empty($aBanner['prepend']) ? $aBanner['prepend'] : '';
    $append = !empty($aBanner['append']) ? $aBanner['append'] : '';
    $width = !empty($aBanner['width']) ? $aBanner['width'] : 0;
    $height = !empty($aBanner['height']) ? $aBanner['height'] : 0;
    $pluginVersion = !empty($aBanner['pluginversion']) ? $aBanner['pluginversion'] : '4';
    // $imageUrlPrefix = ($_SERVER['SERVER_PORT'] == $conf['openads']['sslPort']) ? $conf['type_web_ssl_url'] : $conf['type_web_url'];
    $fileName = !empty($aBanner['filename']) ? $aBanner['filename'] : '';
    $altImageBannercode = _adRenderImage($aBanner, $zoneId, $source, $ct0, false, $logClick, false, true, true, $loc, $referer);
    // Create the anchor tag..
    $clickTag = _adRenderBuildClickUrl($aBanner, $source, $ct0, $logClick);
    if (!empty($clickTag)) {  // There is a link
        $status = _adRenderBuildStatusCode($aBanner);
        $target = !empty($aBanner['target']) ? $aBanner['target'] : '_blank';
        $swfParams = 'clickTAG=' . $clickTag;
        $anchor = "<a href='$clickTag' target='$target'$status>";
        $anchorEnd = '</a>';
    } else {
        $swfParams = '';
        $anchor = '';
        $anchorEnd = '';
    }
    $clickTag = _adRenderBuildFileUrl($aBanner, $source, $ct0, $logClick);
    $fileUrl = _adRenderBuildFileUrl($aBanner, false, $swfParams);
    $code = "
<object classid='clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B' codebase='http://www.apple.com/qtactivex/qtplugin.cab' width='$width' height='$height'>
<param name='src' value='$fileUrl'>
<param name='controller' value='false'>
<param name='autoplay' value='true'>
<embed src='$fileUrl' controller='false' autoplay='true' width='$width' height='$height' pluginspace='http://www.apple.com/quicktime/download/'></embed>
<noembed>$altImageBannercode</noembed>
</object>";
    $bannerText = $withText && !empty($aBanner['bannertext']) ? "<br />{$anchor}{$aBanner['bannertext']}{$anchorEnd}" : '';
    // Get the image beacon...
    $beaconTag = ($logView && $conf['logging']['adImpressions']) ? _adRenderImageBeacon($aBanner, $zoneId, $source, $loc, $referer) : '';
    return $prepend . $code . $bannerText . $beaconTag . $append;
}

/**
 * This function generates the code to show an "HTML" ad (usually 3rd party adserver code)
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param int     $withText     Should "text below banner" be appended to the generated code
 * @param bookean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $logView      Should this view be logged (views in admin should not be logged
 *                              also - 3rd party callback logging should not be logged at view time)
 * @param boolean $useAlt       Should the backup file be used for this code
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 *
 * @return string               The HTML to display this ad
 */
function _adRenderHtml(&$aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=true, $logView=true, $useAlt=false, $loc, $referer)
{
    // This is a wrapper to the "parent" bannerTypeHtml function
    $aConf = $GLOBALS['_MAX']['CONF'];
    if (!function_exists('Plugin_BannerTypeHtml_delivery_adRender')) {
        @include LIB_PATH . '/Extension/bannerTypeHtml/bannerTypeHtmlDelivery.php';
    }
    return Plugin_BannerTypeHtml_delivery_adRender($aBanner, $zoneId, $source, $ct0, $withText, $logClick, $logView, $useAlt, $loc, $referer);
}

/**
 * This function generates the code to show a "text" ad
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param int     $withText     Should "text below banner" be appended to the generated code
 * @param bookean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $logView      Should this view be logged (views in admin should not be logged
 *                              also - 3rd party callback logging should not be logged at view time)
 * @param boolean $useAlt       Should the backup file be used for this code
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 *
 * @return string               The HTML to display this ad
 */
function _adRenderText(&$aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=true, $logView=true, $useAlt=false, $loc, $referer)
{
    // This is a wrapper to the "parent" bannerTypeHtml function
    $aConf = $GLOBALS['_MAX']['CONF'];
    if (!function_exists('Plugin_BannerTypeText_delivery_adRender')) {
        @include LIB_PATH . '/Extension/bannerTypeText/bannerTypeTextDelivery.php';
    }
    return Plugin_BannerTypeText_delivery_adRender($aBanner, $zoneId, $source, $ct0, $withText, $logClick, $logView, $useAlt, $loc, $referer);
}

/**
 * This function generates the code to show a "real" ad (e.g. RPM (RealMedia))
 *
 * @todo  I believe this function is never called - if so, then this function can be removed
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param int     $withText     Should "text below banner" be appended to the generated code
 * @param bookean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $logView      Should this view be logged (views in admin should not be logged
 *                              also - 3rd party callback logging should not be logged at view time)
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 *
 * @return string               The HTML to display this ad
 */
function _adRenderReal(&$aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=true, $logView=true, $loc, $referer)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $prepend = !empty($aBanner['prepend']) ? $aBanner['prepend'] : '';
    $append = !empty($aBanner['append']) ? $aBanner['append'] : '';
    $width = !empty($aBanner['width']) ? $aBanner['width'] : 0;
    $height = !empty($aBanner['height']) ? $aBanner['height'] : 0;
    $pluginVersion = !empty($aBanner['pluginversion']) ? $aBanner['pluginversion'] : '4';
    // $imageUrlPrefix = ($_SERVER['SERVER_PORT'] == $conf['openads']['sslPort']) ? $conf['type_web_ssl_url'] : $conf['type_web_url'];
    $fileName = !empty($aBanner['filename']) ? $aBanner['filename'] : '';
    $altImageBannercode = _adRenderImage($aBanner, $zoneId, $source, $ct0, false, $logClick, false, true, true, $loc, $referer);
    // Create the anchor tag..
    $clickTag = _adRenderBuildClickUrl($aBanner, $source, $ct0, $logClick);
    if (!empty($clickTag)) {  // There is a link
        $status = _adRenderBuildStatusCode($aBanner);
        $target = !empty($aBanner['target']) ? $aBanner['target'] : '_blank';
        $swfParams = 'clickTAG=' . $clickTag;
        $anchor = "<a href='$clickTag' target='$target'$status>";
        $anchorEnd = '</a>';
    } else {
        $swfParams = '';
        $anchor = '';
        $anchorEnd = '';
    }
    $clickTag = _adRenderBuildClickUrl($aBanner, $source, $ct0, $logClick);
    $fileUrl = _adRenderBuildFileUrl($aBanner, false, $swfParams);
    $code = "
<object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='$width' height='$height'>
<param name='src' value='$fileUrl'>
<param name='controls' value='ImageWindow'>
<param name='autostart' value='true'>
<embed src='$fileUrl' controls='ImageWindow' autostart='true' width='$width' height='$height' type='audio/x-pn-realaudio-plugin'></embed>
<noembed>$altImageBannercode</noembed>
</object>";
    $bannerText = $withText && !empty($aBanner['bannertext']) ? "<br />{$anchor}{$aBanner['bannertext']}{$anchorEnd}" : '';
    // Get the image beacon...
    $beaconTag = ($logView && $conf['logging']['adImpressions']) ? _adRenderImageBeacon($aBanner, $zoneId, $source, $loc, $referer) : '';
    return $prepend . $code . $bannerText . $beaconTag . $append;
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
        $fileUrl = $aBanner['imageurl'];
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
    return (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == $conf['openads']['sslPort']) ?
        'https://' . $conf['webpath']['imagesSSL'] :
        'http://' . $conf['webpath']['images'];

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
function _adRenderBuildLogURL($aBanner, $zoneId = 0, $source = '', $loc = '', $referer = '', $amp = '&amp;')
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
    $url .= "?bannerid=" . $aBanner['ad_id'];
    $url .= $amp . "campaignid=" . $aBanner['placement_id'];
    $url .= $amp . "zoneid=" . $zoneId;
    if (!empty($source)) $url .= $amp . "source=" . $source;
    if (!empty($aBanner['block_ad'])) $url .= $amp . $conf['var']['blockAd'] . "=" . $aBanner['block_ad'];
    if (!empty($aBanner['cap_ad'])) $url .= $amp . $conf['var']['capAd'] . "=" . $aBanner['cap_ad'];
    if (!empty($aBanner['session_cap_ad'])) $url .= $amp . $conf['var']['sessionCapAd'] . "=" . $aBanner['session_cap_ad'];
    if (!empty($aBanner['block_campaign'])) $url .= $amp . $conf['var']['blockCampaign'] . "=" . $aBanner['block_campaign'];
    if (!empty($aBanner['cap_campaign'])) $url .= $amp . $conf['var']['capCampaign'] . "=" . $aBanner['cap_campaign'];
    if (!empty($aBanner['session_cap_campaign'])) $url .= $amp . $conf['var']['sessionCapCampaign'] . "=" . $aBanner['session_cap_campaign'];
    if (!empty($aBanner['block_zone'])) $url .= $amp . $conf['var']['blockZone'] . "=" . $aBanner['block_zone'];
    if (!empty($aBanner['cap_zone'])) $url .= $amp . $conf['var']['capZone'] . "=" . $aBanner['cap_zone'];
    if (!empty($aBanner['session_cap_zone'])) $url .= $amp . $conf['var']['sessionCapZone'] . "=" . $aBanner['session_cap_zone'];
    if (!empty($logLastAction)) $url .= $amp . $conf['var']['lastView'] . "=" . $logLastAction;
    if (!empty($loc)) $url .= $amp . "loc=" . urlencode($loc);
    if (!empty($referer)) $url .= $amp . "referer=" . urlencode($referer);
    $url .= $amp . "cb={random}";

    // addUrlParams hook for plugins to add key=value pairs to the log/click URLs
    $componentParams =  OX_Delivery_Common_hook('addUrlParams', array($aBanner));
    foreach ($componentParams as $params) {
        if (!empty($params) && is_array($params)) {
            foreach ($params as $key => $value) {
                $url .= $amp . urlencode($key) . '=' . urlencode($value);
            }
        }
    }
    return $url;
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
 * This function builds the custom params string (the params string uses a custom delimiter to avoid problems
 * when passing in plain (non-url encoded) destination URLs
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param bookean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $overrideDest Should the URL from the banner override a passed in destination?
 *
 * @return string The params string
 */
function _adRenderBuildParams($aBanner, $zoneId=0, $source='', $ct0='', $logClick=true, $overrideDest=false)
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
        // Determine the destination
        $dest = !empty($aBanner['url']) ? $aBanner['url'] : '';
        // If the passed in a ct0= value that is not a valid URL (simple checking), then ignore it
        $ct0 = (empty($ct0) || strtolower(substr($ct0, 0, 4)) != 'http') ? '' : htmlspecialchars($ct0, ENT_QUOTES);
        if ($aBanner['contenttype'] == "swf" && empty($aBanner['noClickTag'])) {
            // Strip maxdest with SWF banners using clickTAG
            $maxdest = '';
        } else {
            $maxdest = "{$del}{$conf['var']['dest']}={$ct0}{$dest}";
        }
        $log .= (!empty($logLastClick)) ? $del . $conf['var']['lastClick'] . '=' . $logLastClick : '';
        
        $maxparams = $delnum . $bannerId . $zoneId . $source . $log . $random;
        // addUrlParams hook for plugins to add key=value pairs to the log/click URLs
        $componentParams =  OX_Delivery_Common_hook('addUrlParams', array($aBanner));
        foreach ($componentParams as $params) {
            if (!empty($params) && is_array($params)) {
                foreach ($params as $key => $value) {
                    $maxparams .= $del . urlencode($key) . '=' . urlencode($value);
                }
            }
        }
        $maxparams .= $maxdest;
    }
    return $maxparams;
}

/**
 * This function builds the Click through URL for this ad
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param bookean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $overrideDest Should the URL from the banner override a passed in destination?
 *
 * @return string The click URL
 */
function _adRenderBuildClickUrl($aBanner, $zoneId=0, $source='', $ct0='', $logClick=true, $overrideDest=false)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $clickUrl = '';
    if (is_string($logClick)) {
        $clickUrl = $logClick;
    } elseif (!empty($aBanner['url']) || $overrideDest) {
        $clickUrl = MAX_commonGetDeliveryUrl($conf['file']['click']) . '?' . $conf['var']['params'] . '=' . _adRenderBuildParams($aBanner, $zoneId, $source, $ct0, $logClick, true);
    }
    return $clickUrl;
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

function _getAdRenderFunction($aBanner, $richMedia = true)
{
    $functionName = false;
    if (!empty($aBanner['ext_bannertype'])) {
        return OX_Delivery_Common_getFunctionFromComponentIdentifier($aBanner['ext_bannertype'], 'adRender');
    } else {
        switch ($aBanner['contenttype']) {
            case 'gif'  :
            case 'jpeg' :
            case 'png'  :
                $functionName = '_adRenderImage';
                break;
            case 'swf'  :
                if ($richMedia) {
                    $functionName = '_adRenderFlash';
                } else {
                    $functionName = '_adRenderImage';
                }
                break;
            case 'txt'  :
                    $functionName = '_adRenderText';
                break;
            case 'mov'  :
                    $functionName = '_adRenderQuicktime';
                break;
            default :
                switch ($aBanner['type']) {
                    case 'html' :
                        $functionName = '_adRenderHtml';
                        break;
                    case 'url' : // External banner without a recognised content type - assume image...
                        $functionName = '_adRenderImage';
                        break;
                    case 'txt' :
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

?>
