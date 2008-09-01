<?php

require_once MAX_PATH . '/extensions/deliveryAdRender/oxThorium/marketplace.php';

if (MAX_marketplaceEnabled()) {
    if (isset($_GET['indium'])) {
        if ($_GET['indium']) {
            if (!empty($conf['oxIndium']['cacheTime'])) {
                $expiry = $conf['oxIndium']['cacheTime'] < 0 ? null : MAX_commonGetTimeNow + $conf['oxIndium']['cacheTime'];
            } else {
                $expiry = _getTimeYearFromNow();
            }
            MAX_cookieSet('In', '1', $expiry);
        }
    } else {
        $scriptName = basename($_SERVER['SCRIPT_FILENAME']);
        $oxpUrl = MAX_commonGetDeliveryUrl($scriptName).'?';
        if (!empty($_SERVER['QUERY_STRING'])) {
            $oxpUrl .= $_SERVER['QUERY_STRING'].'&';
        }
        $oxpUrl .= 'indium=INDIUM_OK';
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http').'://'.
        $url .= $conf['oxIndium']['indiumHost'].'/redir?r='.urlencode($oxpUrl);
        $url .= '&pid=OpenXDemo'; // TODO - where from the pid should be taken?
        $url .= '&cb='.mt_rand(0, PHP_INT_MAX);
        header("Location: {$url}");
        exit;
    }
}

MAX_commonDisplay1x1();

?>