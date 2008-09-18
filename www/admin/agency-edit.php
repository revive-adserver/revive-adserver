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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Admin/Menu.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';

require_once LIB_PATH . '/Admin/Redirect.php';

// Register input variables
phpAds_registerGlobalUnslashed (
	 'errormessage'
	,'agencyid'
	,'name'
	,'contact'
	,'email'
	,'submit'
	,'logout_url'
);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);


/*-------------------------------------------------------*/
/* Initialise data                                    */
/*-------------------------------------------------------*/
if ($agencyid != '') {
    $doAgency = OA_Dal::staticGetDO('agency', $agencyid);
    // Do not get this information if the page
    // is the result of an error message
    if (!isset($agency)) {
        $doAgency = OA_Dal::factoryDO('agency');
        if ($doAgency->get($agencyid)) {
            $aAgency = $doAgency->toArray();
        }
    }
}
else {
    // Do not set this information if the page
    // is the result of an error message
    if (!isset($agency)) {
        $aAgency['name']         = $GLOBALS['strUntitled'];
        $aAgency['contact']      = '';
        $aAgency['email']        = '';
        $aAgency['logout_url']   = '';
    }
}


/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/
//build agency form
$agencyForm = buildAgencyForm($aAgency);

if ($agencyForm->validate()) {
    //process submitted values
    processForm($aAgency, $agencyForm);
}
else { //either validation failed or form was not submitted, display the form
    displayPage($aAgency, $agencyForm);
}

/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildAgencyForm($aAgency)
{
    $form = new OA_Admin_UI_Component_Form("agencyform", "POST", $_SERVER['PHP_SELF']);
    $form->forceClientValidation(true);

    $form->addElement('hidden', 'agencyid', $aAgency['agencyid']);
    $form->addElement('header', 'header_basic', $GLOBALS['strBasicInformation']);

    $form->addElement('text', 'name', $GLOBALS['strName']);
    $form->addElement('text', 'contact', $GLOBALS['strContact']);
    $form->addElement('text', 'email', $GLOBALS['strEMail']);

    //we want submit to be the last element in its own separate section
    $form->addElement('controls', 'form-controls');
    $form->addElement('submit', 'submit', $GLOBALS['strSaveChanges']);


    //Form validation rules
    $translation = new OX_Translation();
    $nameRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strName']));
    $form->addRule('name', $nameRequiredMsg, 'required');
    // Get unique agencyname
    $doAgency = OA_Dal::factoryDO('agency');
    $aUnique_names = $doAgency->getUniqueValuesFromColumn('name', $aAgency['name']);
    $nameUniqueMsg = $translation->translate($GLOBALS['strXUniqueField'],
        array($GLOBALS['strAgency'], strtolower($GLOBALS['strName'])));
    $form->addRule('name', $nameUniqueMsg, 'unique', $aUnique_names);

    $contactRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strContact']));
    $form->addRule('contact', $contactRequiredMsg, 'required');
    $emailRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strEMail']));
    $form->addRule('email', $emailRequiredMsg, 'required');
    $form->addRule('email', $GLOBALS['strEmailField'], 'email');


    //set form  values
    $form->setDefaults($aAgency);
    return $form;
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
function processForm($aAgency, $form)
{
    $aFields = $form->exportValues();

    // Get previous values
    if (!empty($aFields['agencyid'])) {
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($aFields['agencyid']);
        $agency = $doAgency->toArray();
    }
    // Name
    $agency['name']           = $aFields['name'];
    // Default fields
    $agency['contact']        = $aFields['contact'];
    $agency['email']          = $aFields['email'];
    $agency['logout_url']     = $aFields['logout_url'];

    // Permissions
    $doAgency = OA_Dal::factoryDO('agency');
    if (empty($aFields['agencyid'])) {
        $doAgency->setFrom($agency);
        $agencyid = $doAgency->insert();
    } else {
        $doAgency->get($aFields['agencyid']);
        $doAgency->setFrom($agency);
        $doAgency->update();
    }
    // Go to next page
    OX_Admin_Redirect::redirect('agency-index.php');
}


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($aAgency, $form)
{
    if ($aAgency['agencyid'] != '') {
        OA_Admin_Menu::setAgencyPageContext($aAgency['agencyid'], 'agency-edit.php');
        MAX_displayInventoryBreadcrumbs(array(array("name" => $aAgency['name'])), "agency");
        phpAds_PageHeader();
    }
    else {
        MAX_displayInventoryBreadcrumbs(array(array("name" => "")), "agency", true);
        phpAds_PageHeader("agency-edit_new");
    }


    //get template and display form
    $oTpl = new OA_Admin_Template('agency-edit.html');
    $oTpl->assign('form', $form->serialize());
    $oTpl->display();

    //footer
    phpAds_PageFooter();
}
?>
