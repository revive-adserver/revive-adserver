<?php

require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';

$upgradeTaskResult = MAX_AclReCompileAll(true);
if (PEAR::isError($result))
{
    $upgradeTaskMessage = $result->getMessage();
    $upgradeTaskError   = $result->getCode();
}
else
{
    $upgradeTaskMessage = '';
    $upgradeTaskError   = '';
}


?>