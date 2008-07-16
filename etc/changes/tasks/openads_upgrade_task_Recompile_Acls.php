<?php

require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';

$upgradeTaskResult = MAX_AclReCompileAll(true);
$upgradeTaskMessage[] = '';
$upgradeTaskError[] = 'Recompiling Acls';
if (PEAR::isError($result))
{
    $upgradeTaskError[] = $result->getMessage();
    $upgradeTaskError[]   = $result->getCode();
}
else
{
    $upgradeTaskError[]   = 'OK';
}


?>