<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$Id$
*/

require_once 'demoUI-common.php';

if (isset($_REQUEST['action']) && in_array($_REQUEST['action'],array('1','2','3','4')))
{
    $i = $_REQUEST['action'];

    switch ($i)
    {
        case '4':
            OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);
            break;
        case '3':
            OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
            break;
        case '2':
            OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADMIN);
            break;
    }

    $colour  = $GLOBALS['_MAX']['PREF']['demoUserInterface_demopref_'.OA_Permission::getAccountType(true)];
    //$image   = 'demoUI'.$i.'.jpg';
    $message = $GLOBALS['_MAX']['CONF']['demoUserInterface']['message'.$i];

    phpAds_PageHeader('demo-menu-'.$i,'','../../');

    $oTpl = new OA_Plugin_Template('demoUI.html','demoUserInterface');
    //$oTpl->assign('image',$image);
    $oTpl->assign('message',$message);
    $oTpl->assign('colour',$colour);
    $oTpl->display();

    phpAds_PageFooter();
}
else
{
    require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
    MAX_Admin_Redirect::redirect('plugins/demoUserInterface/demoUI-index.php');
}


?>