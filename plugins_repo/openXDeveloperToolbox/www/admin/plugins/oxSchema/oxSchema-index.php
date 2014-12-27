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

/**
 * OpenX Schema Management Utility
 */

require_once '../../../../init.php';
require_once '../../config.php';

phpAds_PageHeader("devtools-schema",'','../../');

require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';

$oTpl = new OA_Plugin_Template('oxSchema-frame.html','oxSchema');
$oTpl->debugging = false;
$src = $_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/oxSchema-frame.php';
$oTpl->assign('src', $src);
$oTpl->display();

phpAds_PageFooter();
?>