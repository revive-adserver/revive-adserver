<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/OA/Permission.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    // Show Dashboard if Dashboard is enabled
    if ($GLOBALS['_MAX']['CONF']['ui']['dashboardEnabled']) {
        OX_Admin_Redirect::redirect('dashboard.php');
    } else {
        OX_Admin_Redirect::redirect('agency-index.php');
    }
}

if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    // Show Dashboard if Dashboard is enabled, Sync is enabled and PHP is SSL enabled
    if ($GLOBALS['_MAX']['CONF']['ui']['dashboardEnabled'] && $GLOBALS['_MAX']['CONF']['sync']['checkForUpdates'] && OA::getAvailableSSLExtensions()) {
        OX_Admin_Redirect::redirect('dashboard.php');
    } else {
        OX_Admin_Redirect::redirect('advertiser-index.php');
    }
}

if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
    OX_Admin_Redirect::redirect('stats.php?entity=advertiser&breakdown=history&clientid='.OA_Permission::getEntityId());
}

if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
    OX_Admin_Redirect::redirect('stats.php?entity=affiliate&breakdown=history&affiliateid='.OA_Permission::getEntityId());
}

?>
