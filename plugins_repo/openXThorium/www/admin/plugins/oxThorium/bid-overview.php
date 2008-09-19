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
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH .'/lib/OX/Admin/Redirect.php';

/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADMIN);

$oForm = buildForm();

if ($oForm->validate()) {
    //process submitted values
    processForm($oForm);
}
else { //either validation failed or form was not submitted, display the form
    displayPage($oForm);
}

/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildForm()
{
    $oForm = new OA_Admin_UI_Component_Form("account_form", "POST", $_SERVER['PHP_SELF']);
    $oForm->forceClientValidation(true);

    $oForm->addElement('controls', 'form-controls');
    $oForm->addElement('submit', 'payment', 'Enter payment details');
    $oForm->addElement('submit', 'inventory', 'Do it later');

    return $oForm;
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
function processForm($form)
{
    $aFields = $form->exportValues();

    if (!empty($aFields['inventory'])) {
        // redirect to inventory
        OX_Admin_Redirect::redirect('advertiser-index.php');
    }
    else if(!empty($aFields['payment'])) {
        // redirect to payment details screen
        OX_Admin_Redirect::redirect('plugins/oxThorium/bid-payment-edit.php');
    }
}

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($oForm)
{
    // menu
    $obj = OX_Component::factory('admin', 'oxThorium');
    $obj->setCurrentMenuItem('bid-overview');
    $obj->addSubMenu();

    //header
    phpAds_PageHeader("openx-market",'','../../');

    //get template and display form
    $oTpl = new OA_Plugin_Template('bid-overview.html','bidService');

    $oTpl->assign('oForm', $oForm->serialize());
    $oTpl->display();

    //footer
    phpAds_PageFooter();
}