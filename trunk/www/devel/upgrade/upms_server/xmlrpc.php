<?php

require_once('./init.php');

require_once('upms.inc.php');

$server = new UpgradePackageManagerServer();

$server->start();

?>