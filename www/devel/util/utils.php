<?php

require_once '../../../init.php';

if (array_key_exists('pkgarr',$_REQUEST))
{
    global $readPath, $writeFile;
    $readPath = MAX_PATH.'/etc/changes';
    $writeFile = MAX_PATH.'/etc/changes/openads_upgrade_array.txt';
    include MAX_PATH.'/scripts/upgrade/buildPackagesArray.php';
    $array = file_get_contents($writeFile);
    $aVersions = unserialize($array);
    var_dump($aVersions);
}
else if (array_key_exists('dbogenr',$_REQUEST))
{
    include MAX_PATH.'/scripts/db_dataobject/rebuild.php';
}

?>