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

/*
 * Renders a single banner for the sandboxed admin preview frames built by
 * MAX_bannerPreview().
 *
 * This page deliberately does not include www/admin/config.php: it must never
 * show the login form or a full admin error page inside a small sandboxed
 * frame, where it could not be used anyway. Requests without a valid session
 * or access to the banner just get an empty 403 response.
 */

require_once '../../init.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/OA/Auth.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/lib/max/Delivery/adRender.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';

// Also isolate the creative when this URL is opened outside an iframe.
// Keep in sync with the iframe sandbox attribute set by MAX_bannerPreview().
header('Content-Security-Policy: sandbox allow-scripts allow-popups allow-popups-to-escape-sandbox');
header('Referrer-Policy: no-referrer');
header('Cache-Control: no-store');
header('Content-Type: text/html; charset=UTF-8');

function OA_bannerPreviewDeny(int $status = 403): never
{
    http_response_code($status);
    exit;
}

if (OA_INSTALLATION_STATUS != OA_INSTALLATION_STATUS_INSTALLED || empty($GLOBALS['_MAX']['CONF']['ui']['enabled'])) {
    OA_bannerPreviewDeny();
}

unset($session);
// The admin page embedding the preview has just refreshed the session
phpAds_SessionDataFetch(false);

$bannerId = $_GET['bannerid'] ?? '';
if (
    !OA_Auth::isLoggedIn()
    || !is_string($bannerId)
    || !preg_match('/^[1-9]\d*$/D', $bannerId)
    || !OA_Permission::isAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER)
    || !OA_Permission::hasAccessToObject('banners', (int) $bannerId)
) {
    OA_bannerPreviewDeny();
}

$aBanner = Admin_DA::getAd((int) $bannerId);
if (empty($aBanner)) {
    OA_bannerPreviewDeny(404);
}

$aBanner['storagetype'] = $aBanner['type'];
$aBanner['bannerid'] = $aBanner['ad_id'];
$bannerCode = MAX_adRender($aBanner, 0, '', '', '', true, '', false, false);

// Apply the admin interface stylesheet, so that previews keep the look (fonts, link colours)
// they had when they were rendered inline in the admin pages
if (!empty($session['language'])) {
    $GLOBALS['_MAX']['CONF']['max']['language'] = $session['language'];
}
Language_Loader::load('default');
$direction = ($GLOBALS['phpAds_TextDirection'] ?? 'ltr') == 'rtl' ? 'rtl' : 'ltr';
$stylesheet = "<link rel='stylesheet' href='" . htmlspecialchars(OX::assetPath() . "/css/interface-{$direction}.css", ENT_QUOTES) . "'>";

// Reports the rendered size to ox.bannerpreview.js, so that frames of banners without
// a specified size can fit their content. It is placed in the head, so that broken
// creative markup can't swallow it, and starts as soon as the document is parsed, so
// that the frame doesn't sit at its default size until every resource has loaded.
$sizeReporter = <<<'JS'
<script>
(function () {
    var lastWidth = 0;
    var lastHeight = 0;
    function report() {
        var box = document.getElementById('revive-banner-preview');
        if (!box) {
            return;
        }
        var rect = box.getBoundingClientRect();
        var width = Math.ceil(rect.width);
        var height = Math.ceil(rect.height);
        if (width === lastWidth && height === lastHeight) {
            return;
        }
        lastWidth = width;
        lastHeight = height;
        window.parent.postMessage({type: 'revive-banner-preview-size', width: width, height: height}, '*');
    }
    document.addEventListener('DOMContentLoaded', function () {
        report();
        if (window.ResizeObserver) {
            new ResizeObserver(report).observe(document.getElementById('revive-banner-preview'));
        }
    });
    window.addEventListener('load', report);
})();
</script>
JS;

echo "<!DOCTYPE html>
<html>
<head><meta charset='UTF-8'><title></title>{$stylesheet}{$sizeReporter}</head>
<body style='margin:0;overflow:hidden'><div id='revive-banner-preview' style='display:inline-block'>$bannerCode</div></body>
</html>";
