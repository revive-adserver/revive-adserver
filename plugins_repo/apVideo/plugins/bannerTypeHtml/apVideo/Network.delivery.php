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

require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/commonDelivery.php';
require_once MAX_PATH . '/plugins/apVideo/lib/Dal/Delivery.php';

if (!is_callable('MAX_adSelect')) {
    require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
}


function Plugin_bannerTypeHtml_apVideo_Network_Delivery_adRender(&$aBanner, $zoneId = 0, $source = '', $ct0 = '', $withText = false, $logClick = true, $logView = true, $useAlt = false, $loc, $referer)
{
    global $format;

    $conf = $GLOBALS['_MAX']['CONF'];

    if ($format == 'vast') {
        // bannertext is used to store the VAST2 tag URL
        $vastUrl = $aBanner['bannertext'];

        // Backwards compatibility < 1.4.0-rc2
        if (empty($vastUrl) && !empty($aBanner['imageurl'])) {
            $vastUrl = $aBanner['imageurl'];
        }

        $impressionUrl = _adRenderBuildLogURL($aBanner, $zoneId, $source, $loc, $referer, '&');

        if (function_exists('_adRenderBuildSignedClickUrl')) {
            $clickUrl = _adRenderBuildSignedClickUrl($aBanner, $zoneId, $source, $ct0, $logClick);
        } else {
            $clickUrl = MAX_commonGetDeliveryUrl($conf['file']['click']) . '?' . $conf['var']['params'] . '=' . _adRenderBuildParams($aBanner, $zoneId, $source, $ct0, $logClick, true);
        }

        $trackingUrl = MAX_commonGetDeliveryUrl($conf['file']['frontcontroller']) .
            "?script=videoAds:vastEvent&bannerid={$aBanner['bannerid']}&zoneid={$zoneId}";
        if (!empty($source)) {
            $trackingUrl .= "&source=" . urlencode($source);
        }

        $trackingEvents = join("", array_map(function ($event) use ($trackingUrl) {
            return "<Tracking event=\"{$event}\"><![CDATA[$trackingUrl&event=" . strtolower($event) . "]]></Tracking>";
        }, [
                'start',
                'midpoint',
                'firstQuartile',
                'thirdQuartile',
                'complete',
                'mute',
                'pause',
                'replay',
                'fullscreen',
                'stop',
                'unmute',
                'resume',
        ]));

        $aDetails = AP_Video_Dal_Delivery::cacheGetAdDetails($aBanner['ad_id']);

        $aImpressions = [
            "<URL id=\"primaryAdServer\"><![CDATA[{$impressionUrl}]]></URL>",
        ];

        if (!empty($aDetails['impression_trackers'])) {
            foreach ($aDetails['impression_trackers'] as $k => $url) {
                $aImpressions[] = "<URL id=\"additional-{$k}\"><![CDATA[{$url}]]></URL>";
            }
        }

        $impressions = join("", $aImpressions);

        return <<<EOF
<Ad id="pre-roll">
    <Wrapper>
        <AdSystem>VidiX</AdSystem>
        <Impression>{$impressions}</Impression>
        <VASTAdTagURL><URL><![CDATA[{$vastUrl}]]></URL></VASTAdTagURL>
        <VideoClicks>
            <ClickTracking><URL id="VidixWrapper"><![CDATA[{$clickUrl}]]></URL></ClickTracking>
        </VideoClicks>
        <TrackingEvents>
            {$trackingEvents}
        </TrackingEvents>
    </Wrapper>
</Ad>
EOF;
    }

    return "<p><i>Preview not available for Network Video Ads</i></p>";
}
