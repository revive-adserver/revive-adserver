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
        if (preg_match_all('#<a(.*?)href\s*=\s*(\\\\?[\'"])http(.*?)\2(.*?) *>#is', $buffer, $m)) {
            foreach ($m[0] as $k => $v) {
                // Remove target parameters
                $m[4][$k] = trim(preg_replace('#target\s*=\s*(\\\\?[\'"]).*?\1#i', '', $m[4][$k]));

                $urlDest = preg_replace('/%7B(.*?)%7D/', '{$1}', urlencode("http" . $m[3][$k]));
                $buffer = str_replace($v, "<a{$m[1][$k]}href={$m[2][$k]}{clickurl}$urlDest{$m[2][$k]}{$m[4][$k]} target={$m[2][$k]}{target}{$m[2][$k]}>", $buffer);
            }
        }

        // Search: <\s*form (.*?)action\s*=\s*['"](.*?)['"](.*?)>
        // Replace:<form\1 action="{url_prefix}/{$aConf['file']['click']}" \3><input type='hidden' name='{clickurlparams}\2'>
        $target = (!empty($banner['target'])) ? $banner['target'] : "_self";

        // strip out the method from any <forms> these will be changed to GET
        $buffer = preg_replace(
            '#<\s*form (.*?)method\s*=\s*[\\\\]?[\'"](.*?)[\'"]#is',
            "<form $1 method='GET'", $buffer
        );

        if (preg_match_all('#<\s*form (.*?)action\s*=\s*[\\\\]?[\'"](.*?)[\'\\\"][\'\\\"]?(.*?)>(.*?)</form>#is', $buffer, $m)) {
            foreach ($m[0] as $k => $v) {
                // Remove target parameters
                $m[3][$k] = trim(preg_replace('#target\s*=\s*(\\\\?[\'"]).*?\1#i', '', $m[3][$k]));

                $buffer = str_replace($v, "<form {$m[1][$k]} action='{url_prefix}/{$aConf['file']['click']}' {$m[3][$k]} target='{$target}'>{$m[4][$k]}<input type='hidden' name='{$aConf['var']['params']}' value='{clickurlparams}{$m[2][$k]}'></form>", $buffer);
            }
        }

        //$buffer = preg_replace("#<form*action='*'*>#i","<form target='{target}' $1action='{url_prefix}/{}$aConf['file']['click']'$3><input type='hidden' name='{clickurlparams}$2'>", $buffer);
        //$buffer = preg_replace("#<form*action=\"*\"*>#i","<form target=\"{target}\" $1action=\"{url_prefix}/{$aConf['file']['click']}\"$3><input type=\"hidden\" name=\"{clickurlparams}$2\">", $buffer);

        // In addition, we need to add our clickURL to the clickTAG parameter if present, for 3rd party flash ads
        // the clickTag is case insentive match, as it is correct to use clicktag, CLICKTAG, etc.
        preg_match('/^(.*)(clickTAG)\s?=\s?(.*?)([\'"])(.*)$/is', $buffer, $matches);
        if(count($matches) > 0) {
            $buffer = $matches[1] . $matches[2] . "={clickurl}".urlencode($matches[3]).$matches[4].$matches[5];
        }

        // Detect any JavaScript window.open() functions, and prepend the opened URL with our logurl
        $buffer = preg_replace('#window.open\s?\((.*?)\)#i', "window.open(\\\'{logurl}&maxdest=\\\'+$1)", $buffer);
    }

    // Since we don't want to replace adserver noscript and iframe content with click tracking etc
    $noScript = array();

    //Capture noscript content into $noScript[0], for seperate translations
    preg_match("#<noscript>(.*?)</noscript>#is", $buffer, $noScript);
    $buffer = preg_replace("#<noscript>(.*?)</noscript>#is", '{noscript}', $buffer);

    // run 3rd party component
    if(!empty($banner['adserver'])) {
        require_once LIB_PATH . '/Plugin/Component.php';
        /**
          * @todo This entire function should be relocated to the DLL and should be object-ified
          *
         */
        PEAR::pushErrorHandling(null);
        $adServerComponent = OX_Component::factoryByComponentIdentifier($banner['adserver']);
        PEAR::popErrorHandling();
        if ($adServerComponent) {
            $buffer = $adServerComponent->getBannerCache($buffer, $noScript);
        } else {
            $GLOBALS['_MAX']['bannerrebuild']['errors'] = true;
        }
    }

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