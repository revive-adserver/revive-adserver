<?php

if (!class_exists('OA_Maintenance_Priority'))
{
    require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';
}

$upgradeTaskResult  = OA_Maintenance_Priority::run();
$upgradeTaskMessage = '';
$upgradeTaskError   = '';

?>