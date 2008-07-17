<?php

require_once MAX_PATH . '/www/admin/lib-banner-cache.inc.php';

// We can "hard-code" this preference to on, because it is only a UI preference to control if this is allowed
// The individual banners will decide if this should actually be set.
$GLOBALS['_MAX']['PREF']['auto_alter_html_banners_for_click_tracking'] = true;

$upgradeTaskResult  = processBanners(true);
$upgradeTaskMessage = '';
$upgradeTaskError   = '';


?>