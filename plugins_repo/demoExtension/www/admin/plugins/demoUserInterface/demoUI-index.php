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

require_once 'demoUI-common.php';

phpAds_PageHeader("demo-menu-i",'','../../');

$oTpl    = new OA_Plugin_Template('demoUI.html','demoUserInterface');

$message = 'OpenX User Interface Demonstration';
$oTpl->assign('message',$message);
$oTpl->display();

phpAds_PageFooter();

?>