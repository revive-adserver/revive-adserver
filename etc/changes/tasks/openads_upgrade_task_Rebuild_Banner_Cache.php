<?php

require_once MAX_PATH . '/www/admin/lib-banner-cache.inc.php';

$upgradeTaskResult  = processBanners(true);
$upgradeTaskMessage = '';
$upgradeTaskError   = '';


?>