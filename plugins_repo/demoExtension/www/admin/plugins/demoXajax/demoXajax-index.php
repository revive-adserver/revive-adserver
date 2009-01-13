<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
/**
 * OpenX xAjax tester
 *
 * @author     Monique Szpak <monique.szpak@openx.org>
 *
 * $Id$
 *
 */

require_once '../../../../init.php';
require_once '../../config.php';
require_once 'lib/demoXajax.inc.php';
//$xajax->debugOn();
$xajax->debugOff();

$show = $_REQUEST['show'];

phpAds_PageHeader("demo-xajax-{$show}",'','../../');

switch ($show)
{
    case 'menu': // top level menu
    case 'home': // info page
        include "templates/home.html";
        break;
    case 'noframe': // 1st menu
        include "templates/noframe.html";
        break;
    case 'frame': // 2nd menu
        $src = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/demoXajax-frame.php';
        include "templates/frame.html";
        break;
    case 'frame-smarty': // 3rd menu
        require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';
        $oTpl = new OA_Plugin_Template('frame-smarty.html','demoXajax');
        $oTpl->debugging = false;
        $src = $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/demoXajax-frame.php';
        $oTpl->assign('src', $src);
        $oTpl->display();
        break;
    case 'noframe-smarty': // 4th menu
        require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';
        $oTpl = new OA_Plugin_Template('noframe.html','demoXajax');
        $oTpl->debugging = false;
        $oTpl->display();
        break;
}

phpAds_PageFooter();

?>