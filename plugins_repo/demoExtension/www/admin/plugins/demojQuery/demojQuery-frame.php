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
require_once MAX_PATH . '/lib/OA/Admin/UI.php';

/**
 since we are loading a page inside of a frame we do not have access to
 scripts defined in top frame. Thus we need to load them on our own if we want to
 use jQuery.
 Please note that scripts.html is an admin template not a plugin template
 **/

$oUI = OA_Admin_UI::getInstance();
$aScripts = $oUI->genericJavascript();
$oTpl = new OA_Admin_Template('layout/scripts.html');
$oTpl->assign('aGenericJavascript', $aScripts);
$oTpl->display();

//now display the page content
include "templates/content.html";


?>