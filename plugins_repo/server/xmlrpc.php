<?php
require_once 'init.php';

require_once(PRS_PATH.'/PluginServer.php');

$server = new OX_PluginServer();
$server->xmlfile = '../release/releases.xml';

$server->start();

?>