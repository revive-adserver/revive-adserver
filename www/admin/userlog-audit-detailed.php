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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll/Audit.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/www/admin/config.php';

// Register input variables
$auditId = MAX_getStoredValue('auditId', 0);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.2");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));

//  initialize parameters
$pageName = basename($_SERVER['PHP_SELF']);

$oTpl = new OA_Admin_Template('userlog-audit-detailed.html');

$oAudit = & new OA_Dll_Audit();
$aAuditDetail = $oAudit->getAuditDetail($auditId);

$oTpl->assign('aAuditDetail', $aAuditDetail);

$oTpl->display();

phpAds_PageFooter();

?>