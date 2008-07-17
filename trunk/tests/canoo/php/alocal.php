<?php

define('MAX_PATH', './../..');

require_once MAX_PATH . '/www/delivery/alocal.php';

$bannercode = view_local($what = '', $zoneid = 0, $campaignid = 0, $bannerid = 3);

echo $bannercode['html'];

?>