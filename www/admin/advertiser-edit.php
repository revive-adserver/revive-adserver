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
require_once MAX_PATH . '/lib/OA/Admin/Menu.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/model/InventoryPageHeaderModelBuilder.php';

// Register input variables
phpAds_registerGlobalUnslashed(
     'errormessage'
    ,'clientname'
    ,'contact'
    ,'comments'
    ,'email'
    ,'reportlastdate'
    ,'advertiser_limitation'
    ,'reportprevious'
    ,'reportdeactivate'
    ,'report'
    ,'reportinterval'
    ,'submit'
);


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid, true);


/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* Initialise data                                    */
/*-------------------------------------------------------*/
if ($clientid != "") {
    if (!isset($aAdvertiser)) {
        $doClients = OA_Dal::factoryDO('clients');
        if ($doClients->get($clientid)) {
            $aAdvertiser = $doClients->toArray();
        }
    }
}
else {
    if (!isset($aAdvertiser)) {
        $aAdvertiser['clientname']       = $strUntitled;
        $aAdvertiser['contact']          = '';
        $aAdvertiser['comments']         = '';
        $aAdvertiser['email']            = '';
        $aAdvertiser['reportdeactivate'] = 'f';
        $aAdvertiser['report']           = 'f';
        $aAdvertiser['reportinterval']   = 7;
    }
}
/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/
//build advertiser form
$advertiserForm = buildAdvertiserForm($aAdvertiser);

if ($advertiserForm->validate()) {
    //process submitted values
    processForm($aAdvertiser, $advertiserForm);
}
else { //either validation failed or form was not submitted, display the form
    displayPage($aAdvertiser, $advertiserForm);
}

/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildAdvertiserForm($aAdvertiser)
{
    $form = new OA_Admin_UI_Component_Form("clientform", "POST", $_SERVER['SCRIPT_NAME']);
    $form->forceClientValidation(true);

    $form->addElement('hidden', 'clientid', $aAdvertiser['clientid']);
    $form->addElement('header', 'header_basic', $GLOBALS['strBasicInformation']);

    $nameElem = $form->createElement('text', 'clientname', $GLOBALS['strName']);
    if (!OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $nameElem->freeze();
    }
    $form->addElement($nameElem);
    $form->addElement('text', 'contact', $GLOBALS['strContact']);
    $form->addElement('text', 'email', $GLOBALS['strEMail']);

    $form->addElement('header', 'header_adv_report', $GLOBALS['strMailSubject']);
    $form->addElement('hidden', 'reportlastdate', $aAdvertiser['reportlastdate']);
    $form->addElement('hidden', 'reportprevious', $aAdvertiser['report']);
    $form->addElement('advcheckbox', 'reportdeactivate', null, $GLOBALS['strSendDeactivationWarning'], null, array("f", "t"));
    $form->addElement('advcheckbox', 'report', null, $GLOBALS['strSendAdvertisingReport'], null, array("f", "t"));
    $form->addElement('text', 'reportinterval', $GLOBALS['strNoDaysBetweenReports'], array('class' => 'x-small'));

    $form->addElement('header', 'header_misc', $GLOBALS['strMiscellaneous']);
    $form->addElement('advcheckbox', 'advertiser_limitation', null, $GLOBALS['strAdvertiserLimitation'], null, array("0", "1"));
    $form->addElement('textarea', 'comments', $GLOBALS['strComments']);

    //we want submit to be the last element in its own separate section
    $form->addElement('controls', 'form-controls');
    $form->addElement('submit', 'submit', $GLOBALS['strSaveChanges']);

    //Form validation rules
    $translation = new OX_Translation();
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $nameRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strName']));
        $form->addRule('clientname', $nameRequiredMsg, 'required');
    }


    $contactRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strContact']));
    $form->addRule('contact', $contactRequiredMsg, 'required');
    $emailRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strEMail']));
    $form->addRule('email', $emailRequiredMsg, 'required');
    $form->addRule('email', $GLOBALS['strEmailField'], 'email');
    $form->addRule('reportinterval', $GLOBALS['strNumericField'], 'numeric');
    $form->addRule('reportinterval', $GLOBALS['strGreaterThanZeroField'], 'min', 1);


    //set form  values
    $form->setDefaults($aAdvertiser);
    return $form;
}


/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
function processForm($aAdvertiser, $form)
{
    $aFields = $form->exportValues();

    // Name
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER) ) {
        $aAdvertiser['clientname'] = $aFields['clientname'];
    }
    // Default fields
    $aAdvertiser['contact']  = $aFields['contact'];
    $aAdvertiser['email']    = $aFields['email'];
    $aAdvertiser['comments'] = $aFields['comments'];

    // Same advertiser limitation
    $aAdvertiser['advertiser_limitation']  = $aFields['advertiser_limitation'] == '1' ? 1 : 0;

    // Reports
    $aAdvertiser['report'] = $aFields['report'] == 't' ? 't' : 'f';
    $aAdvertiser['reportdeactivate'] = $aFields['reportdeactivate'] == 't' ? 't' : 'f';
    $aAdvertiser['reportinterval'] = (int)$aFields['reportinterval'];
    if ($aAdvertiser['reportinterval'] == 0 ) {
       $aAdvertiser['reportinterval'] = 1;
    }
    if ($aFields['reportlastdate'] == '' || $aFields['reportlastdate'] == '0000-00-00' ||  $aFields['reportprevious'] != $aAdvertiser['report']) {
        $aAdvertiser['reportlastdate'] = date ("Y-m-d");
    }
    if (empty($aAdvertiser['clientid'])) {
        // Set agency ID
        $aAdvertiser['agencyid'] = OA_Permission::getAgencyId();

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->setFrom($aAdvertiser);
        $doClients->updated = OA::getNow();

        // Insert
        $aAdvertiser['clientid'] = $doClients->insert();

        // Queue confirmation message
        $translation = new OX_Translation ();
        $translated_message = $translation->translate ( $GLOBALS['strAdvertiserHasBeenAdded'], array(
            MAX::constructURL(MAX_URL_ADMIN, 'advertiser-edit.php?clientid=' .  $aAdvertiser['clientid']),
            htmlspecialchars($aAdvertiser['clientname']),
            MAX::constructURL(MAX_URL_ADMIN, 'campaign-edit.php?clientid=' .  $aAdvertiser['clientid']),
        ));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

        // Go to next page
        OX_Admin_Redirect::redirect("advertiser-index.php");
    }
    else {
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->get($aAdvertiser['clientid']);
        $doClients->setFrom($aAdvertiser);
        $doClients->updated = OA::getNow();
        $doClients->update();

        // Queue confirmation message
        $translation = new OX_Translation ();
        $translated_message = $translation->translate ( $GLOBALS['strAdvertiserHasBeenUpdated'],
            array(
            MAX::constructURL(MAX_URL_ADMIN, 'advertiser-edit.php?clientid=' .  $aAdvertiser['clientid']),
            htmlspecialchars($aAdvertiser['clientname'])
            ));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        OX_Admin_Redirect::redirect('advertiser-edit.php?clientid=' .  $aAdvertiser['clientid']);
    }
    exit;
}

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($aAdvertiser, $form)
{
    //header and breadcrumbs
    $oHeaderModel = buildAdvertiserHeaderModel($aAdvertiser);
    if ($aAdvertiser['clientid'] != "") {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            OA_Admin_Menu::setAdvertiserPageContext($aAdvertiser['clientid'], 'advertiser-index.php');
            addAdvertiserPageToolsAndShortcuts($aAdvertiser['clientid']);
            phpAds_PageHeader(null, $oHeaderModel);
        }
        else {
            phpAds_PageHeader(null, $oHeaderModel);
        }
    }
    else { //new advertiser
        phpAds_PageHeader('advertiser-edit_new', $oHeaderModel);
    }

    //get template and display form
    $oTpl = new OA_Admin_Template('advertiser-edit.html');

    $oTpl->assign('clientid',  $aAdvertiser['clientid']);
    $oTpl->assign('form', $form->serialize());
    $oTpl->display();

    //footer
    phpAds_PageFooter();
}

?>
