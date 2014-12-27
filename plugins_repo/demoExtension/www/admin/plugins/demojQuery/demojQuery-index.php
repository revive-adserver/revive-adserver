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
 * OpenX jQuery ajax functions
 */

require_once '../../../../init.php';
require_once '../../config.php';

$show = $_REQUEST['show'];

phpAds_PageHeader("demo-jquery-{$show}",'','../../');

switch ($show)
{
    case 'menu': // top level menu
    case 'home': // info page
        include "templates/home.html";
        break;
    case 'noframe': // 1st menu
        include "templates/content.html";
        break;
    case 'frame': // 2nd menu
        $src = $_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/demojQuery-frame.php';
        include "templates/frame.html";
        break;
    case 'frame-smarty': // 3rd menu
        require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';
        $oTpl = new OA_Plugin_Template('frame-smarty.html','demojQuery');
        $oTpl->debugging = false;
        $src = $_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/demojQuery-frame.php';
        $oTpl->assign('src', $src);
        $oTpl->display();
        break;
    case 'noframe-smarty': // 4th menu
        require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';
        $oTpl = new OA_Plugin_Template('content.html','demojQuery');
        $oTpl->debugging = false;
        $oTpl->display();
        break;
}

phpAds_PageFooter();

?>