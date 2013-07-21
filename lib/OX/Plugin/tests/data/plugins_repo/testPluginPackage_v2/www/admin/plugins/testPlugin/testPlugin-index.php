<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

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