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
$Id: bid-account-edit.php 24004 2008-08-11 15:34:24Z radek.maciaszek@openx.org $
*/

require_once 'bid-common.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/DaySpanField.php';

/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADMIN);

displayPage();

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage()
{
    //get template and display form
    $affiliateId = MAX_getStoredValue('affiliateid', null);
    $tmpl = (is_null($affiliateId)) ? 'bid-stats-website.html' : 'bid-stats-zone.html';
    $oTpl = new OA_Plugin_Template($tmpl, 'bidService');
    $startDate      = MAX_getStoredValue('period_start', null);
    $endDate        = MAX_getStoredValue('period_end', null);
    $periodPreset   = MAX_getValue('period_preset', 'today');

    $aPeriod = array(
        'period_preset'     => $periodPreset,
        'period_start'      => $startDate,
        'period_end'        => $endDate
    );

    $oDaySpan = new Admin_UI_DaySpanField('period');
    $oDaySpan->setValueFromArray($aPeriod);
    $oDaySpan->enableAutoSubmit();

    // menu
    $obj = OX_Component::factory('admin', 'oxThorium');
    $obj->setCurrentMenuItem('bid-stats');
    $obj->addSubMenu();

    //header
    phpAds_PageHeader("openx-market",'','../../');

    $oTpl->assign('daySpan',            $oDaySpan);
    $oTpl->assign('assetPath',      OX::assetPath());
    $oTpl->display();

    //footer
    phpAds_PageFooter();
}