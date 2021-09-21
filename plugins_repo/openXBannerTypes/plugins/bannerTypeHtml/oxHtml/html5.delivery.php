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
 */
function Plugin_BannerTypeHTML_oxHtml_html5_Delivery_adRender(&$aBanner, $zoneId = 0, $source = '', $ct0 = '', $withText = false, $logClick = true, $logView = true, $useAlt = false, $richMedia = true, $loc, $referer)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    $filename = htmlspecialchars(_adRenderBuildImageUrlPrefix() . "/{$aBanner['filename']}/index.html");
    $logImpression = json_encode($logView && $aConf['logging']['adImpressions']);

    $aBanner['htmlcache'] = <<<EOF
<iframe id="rv-h5-{random}" name="rv-h5-{random}" src="{$filename}?clickTag={clickurl_enc}"
    marginwidth="0" marginheight="0" scrolling="no"  frameborder="0" width="{$aBanner['width']}" height="{$aBanner['height']}"
    style="width: {$aBanner['width']}px; height: {$aBanner['height']}px; border: 0"></iframe>
<script>
    document.getElementById('rv-h5-{random}').onload = $logImpression ? function () {
        var i = document.createElement('IMG');
        i.src = '{logurl}';
    } : null;
</script>
EOF;

    return _adRenderHtml($aBanner, $zoneId, $source, $ct0, $withText, $logClick, $logView, $useAlt, $richMedia, $loc, $referer);
}
