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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/RV/Admin/Languages.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Admin/Menu.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';


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
OA_Permission::enforceAccessToObject('agency', $agencyid, true);


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
    $form = new OA_Admin_UI_Component_Form("agencyform", "POST", $_SERVER['SCRIPT_NAME']);
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
