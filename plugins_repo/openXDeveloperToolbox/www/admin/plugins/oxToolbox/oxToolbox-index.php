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

require_once 'oxToolbox-common.php';

phpAds_PageHeader("devtools-home",'','../../');

$oTpl = new OA_Plugin_Template('oxToolbox.html','oxToolbox');
$oTpl->display();

phpAds_PageFooter();

?>