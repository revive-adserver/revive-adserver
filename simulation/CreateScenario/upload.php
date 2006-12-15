<?php

require_once 'init.php';

check_environment();

if (array_key_exists('submit', $_REQUEST))
{
    upload_scenarios();
}

include TPL_PATH.'/frameheader.html';

include TPL_PATH.'/body_upload_scenario.html';
?>