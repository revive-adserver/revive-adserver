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
$Id: affiliate-edit.php 12839 2007-11-27 16:32:39Z bernard.lange@openads.org $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';

// Register input variables
phpAds_registerGlobalUnslashed ('email');



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("4.1.3.4.7.2");
echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>Create AdSense Account</b><br /><br /><br />";
phpAds_ShowSections(array("4.1.3.4.7.2"));


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('adsense-create.html');

$oTpl->assign('fields', array(
    array(
        'title'     => 'Email address for AdSense Account',
        'fields'    => array(
            array(
                'name'      => 'email',
                'label'     => 'Email',
                'value'     => ''
            )
        )
    ),
    array(
        'title'     => 'Name for the AdSense Account in Openads',
        'fields'    => array(
            array(
                'name'      => 'email',
                'label'     => 'Name for the AdSense Account in Openads',
                'value'     => ''
            )
        )
    )
));

//var_dump($oTpl);
//die();
$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
