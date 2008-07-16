<?php
require_once 'testPlugin-common.php';

phpAds_PageHeader("test-plugin-0",'','../../');

$oTpl = new OA_Plugin_Template('testPlugin.html','testPlugin');

$message = 'Test Plugin';
$image   = 'testPlugin.jpg';
$oTpl->assign('message',$message);
$oTpl->assign('image',$image);
$oTpl->display();


phpAds_PageFooter();

?>