<?php

require_once 'init.php';

check_environment();

if (array_key_exists('submit', $_REQUEST))
{
    delete_scenarios($_REQUEST['delete']);
}

include TPL_PATH.'/frameheader.html';

$aSims = get_simulation_file_list(FOLDER_SAVE, 'php', true);

include TPL_PATH.'/body_delete_scenario.html';
?>