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

require_once MAX_PATH . '/lib/max/other/common.php';

function phpAds_getBannerCache($banner)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    $aPref = $GLOBALS['_MAX']['PREF'];
    $buffer = $banner['htmltemplate'];

    // Strip slashes from urls
    $banner['url']      = stripslashes($banner['url']);
    $banner['imageurl'] = stripslashes($banner['imageurl']);

    // The following properties depend on data from the invocation process
    // and can't yet be determined: {zoneid}, {bannerid}
    // These properties will be set during invocation

    if($banner['adserver'] == 'none') {
        $buffer = php_Ads_wrapBannerHtmlInClickUrl($banner, $buffer);
        return $buffer;
    }

    if ($banner['storagetype'] != 'html') {
        return $buffer;
    }

    // Auto change HTML banner
    if ($buffer != '')
    {
        // Put our click URL and our target parameter in all anchors...
        // The regexp should handle ", ', \", \' as delimiters
        if (preg_match_all('#<a(\s[^>]*?)href\s*=\s*(\\\\?[\'"])(https?://.*?)\2(.*?) *>#is', $buffer, $m)) {
            foreach ($m[0] as $k => $v) {
                // Remove target parameters
                $m[1][$k] = ' '.trim(preg_replace('#target\s*=\s*(\\\\?[\'"]).*?\1#i', '', $m[1][$k]));
                $m[4][$k] = ' '.trim(preg_replace('#target\s*=\s*(\\\\?[\'"]).*?\1#i', '', $m[4][$k]));

                $m[3][$k] = html_entity_decode($m[3][$k], null, 'UTF-8');

                $urlDest = urlencode($m[3][$k]);
                $buffer = str_replace($v, "<a{$m[1][$k]}href={$m[2][$k]}{clickurl_html}$urlDest{$m[2][$k]}{$m[4][$k]}target={$m[2][$k]}{target}{$m[2][$k]}>", $buffer);
            }
        }

        // In addition, we need to add our clickURL to the clickTAG parameter if present, for 3rd party flash ads
        // the clickTag is case insentive match, as it is correct to use clicktag, CLICKTAG, etc.
        preg_match('/^(.*)(clickTAG)\s?=\s?(.*?)([\'"])(.*)$/is', $buffer, $matches);
        if(count($matches) > 0) {
            $matches[3] = html_entity_decode($matches[3], null, 'UTF-8');
            $buffer = $matches[1] . $matches[2] . "={clickurl_enc}".urlencode($matches[3]).$matches[4].$matches[5];
        }
    }

    // Since we don't want to replace adserver noscript and iframe content with click tracking etc
    $noScript = [];

    //Capture noscript content into $noScript[0], for seperate translations
    preg_match("#<noscript>(.*?)</noscript>#is", $buffer, $noScript);
    $buffer = preg_replace("#<noscript>(.*?)</noscript>#is", '{noscript}', $buffer);

    $buffer = php_Ads_wrapBannerHtmlInClickUrl($banner, $buffer);

    // Adserver processing complete, now replace the noscript values back:
    //$buffer = preg_replace("#{noframe}#", $noFrame[2], $buffer);
    if (isset($noScript[0])) {
        $buffer = preg_replace("#{noscript}#", $noScript[0], $buffer);
    }

    // Allow custom banner types to alter the banner cache.
    $bannerTypeComponent = OX_Component::factoryByComponentIdentifier($banner['ext_bannertype']);
    if ($bannerTypeComponent) {
        $buffer = $bannerTypeComponent->getBannerCache($buffer, $noScript, $banner);
    }

    return $buffer;
}

function php_Ads_wrapBannerHtmlInClickUrl($banner, $buffer)
{
    // Wrap the banner inside a link if it doesn't seem to handle clicks itself
    if (!empty($banner['url']) && !preg_match('#<(a|area|form|script|object|iframe) #i', $buffer)) {
        return '<a href="{clickurl}" target="{target}">'.$buffer.'</a>';
    }
    return $buffer;
}