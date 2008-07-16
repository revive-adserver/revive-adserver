<?php

if (!class_exists('OA_Maintenance_Priority'))
{
    require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';
}
$upgradeTaskError[] = 'Running Maintenance Prioritisation';
$upgradeTaskResult  = OA_Maintenance_Priority::run();
$upgradeTaskError[] = ($upgradeTaskResult ? 'OK' : 'Failed');
$upgradeTaskMessage = '';


?>