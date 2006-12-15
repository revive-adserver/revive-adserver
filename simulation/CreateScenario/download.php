<?php

require_once 'init.php';

check_environment();

if (array_key_exists('submit', $_REQUEST))
{
    $file = download_scenarios($_REQUEST['download']);
    header('Content-type: application/x-gzip');
    header('Content-Disposition: attachment; filename="'.$file.'"');
    readfile(TMP_PATH.'/'.$file);
    die();
}

include TPL_PATH.'/frameheader.html';

$aSims = get_simulation_file_list(FOLDER_SAVE, 'php', true);

include TPL_PATH.'/body_download_scenario.html';
?>