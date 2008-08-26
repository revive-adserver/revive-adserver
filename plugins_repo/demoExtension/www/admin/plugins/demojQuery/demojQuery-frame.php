<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
 * OpenX jQuery ajax functions
 *
 * @author     Bernard Lange <bernard.lange@openx.org>
 *
 * $Id$
 *
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