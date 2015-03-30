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
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';
require_once MAX_PATH . '/lib/OA/Admin/Menu.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';


// Register input variables
phpAds_registerGlobalUnslashed ('move', 'name', 'website', 'contact', 'email',
                               'errormessage', 'submit', 'publiczones_old', 'formId');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid, true);


/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'] = $affiliateid;
phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* Initialise data                                    */
/*-------------------------------------------------------*/
if ($affiliateid != "") {
    // Do not get this information if the page
    // is the result of an error message
    if (!isset($affiliate)) {
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        if ($doAffiliates->get($affiliateid)) {
            $affiliate = $doAffiliates->toArray();
        }
    }
} else {
    //set some default
    $affiliate['website'] = 'http://';
}


/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/
//  check if Thorium plugin is enabled
$oComponent = null;
if ( isset($GLOBALS['_MAX']['CONF']['plugins']['openXThorium']) &&
     $GLOBALS['_MAX']['CONF']['plugins']['openXThorium']) {
    $oComponent = &OX_Component::factory('admin', 'oxThorium', 'oxThorium');
}

//build form
$websiteForm = buildWebsiteForm($affiliate);

if ($websiteForm->validate()) {
    //process submitted values
    $oPublisherDll = processForm($affiliateid, $websiteForm, $oComponent);
    if ($oPublisherDll->_errorMessage || $oPublisherDll->_noticeMessage) {
        displayPage($affiliateid, $websiteForm, $oPublisherDll);
    }
}
else { //either validation failed or form was not submitted, display the form
    displayPage($affiliateid, $websiteForm);
}


/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildWebsiteForm($affiliate)
{
    $form = new OA_Admin_UI_Component_Form("affiliateform", "POST", $_SERVER['SCRIPT_NAME']);
    $form->forceClientValidation(true);
    $form->addElement('hidden', 'affiliateid', $affiliate['affiliateid']);

    $form->addElement('header', 'basic_info', $GLOBALS['strBasicInformation']);
    $form->addElement('text', 'website', $GLOBALS['strWebsiteURL']);
    $form->addElement('text', 'name', $GLOBALS['strName']);
    $form->addElement('text', 'contact', $GLOBALS['strContact']);
    $form->addElement('text', 'email', $GLOBALS['strEMail']);

    $form->addElement('controls', 'form-controls');
    $form->addElement('submit', 'save', 'Save changes');

    //Form validation rules
    $translation = new OX_Translation();
    $urlRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strWebsiteURL']));
    $form->addRule('website', $urlRequiredMsg, 'required');
    $form->addRule('website', $GLOBALS['strInvalidWebsiteURL'], 'regex', '#^http(s?)\://.+$#');
    $contactRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strContact']));
    $form->addRule('contact', $contactRequiredMsg, 'required');
    $nameRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strName']));
    $form->addRule('name', $nameRequiredMsg, 'required');
    $emailRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strEMail']));
    $form->addRule('email', $emailRequiredMsg, 'required');
    $form->addRule('email', $GLOBALS['strEmailField'], 'email');

    //set form  values
    $form->setDefaults($affiliate);
    return $form;
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
 function processForm($affiliateid, $form, $oComponent)
{
    $aFields = $form->exportValues();
    $newWebsite = empty($aFields['affiliateid']);

    // Setup a new publisher object and set the fields passed in from the form:
    $oPublisher = new OA_Dll_PublisherInfo();
    $oPublisher->agencyId       = $aFields['agencyid'];
    $oPublisher->contactName    = $aFields['contact'];
    $oPublisher->emailAddress   = $aFields['email'];
    $oPublisher->publisherId    = $aFields['affiliateid'];
    $oPublisher->publisherName  = $aFields['name'];
    $oPublisher->website        = $aFields['website'];

    // process form data for oxThorium if this is edit existing website
    if (!$newWebsite && $oComponent)
    {
        $aFields['affiliateid'] = $oPublisher->publisherId;
        $oComponent->processAffiliateForm($aFields);
    }

    $oPublisherDll = new OA_Dll_Publisher();
    if ($oPublisherDll->modify($oPublisher) && !$oPublisherDll->_noticeMessage) {

        // Queue confirmation message
        $translation = new OX_Translation ();
        if ($newWebsite) {
            //process form data for oxThorium for new website
            if ($oComponent)
            {
                $aFields['affiliateid'] = $oPublisher->publisherId;
                $oComponent->processAffiliateForm($aFields);
            }
            $translated_message = $translation->translate ( $GLOBALS['strWebsiteHasBeenAdded'], array(
                MAX::constructURL(MAX_URL_ADMIN, 'affiliate-edit.php?affiliateid=' .  $oPublisher->publisherId),
                htmlspecialchars($oPublisher->publisherName),
                MAX::constructURL(MAX_URL_ADMIN, 'zone-edit.php?affiliateid=' .  $oPublisher->publisherId),
            ));
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
            $redirectURL = "website-index.php";
        }
        else {
            $translated_message = $translation->translate ( $GLOBALS['strWebsiteHasBeenUpdated'], array(
                MAX::constructURL(MAX_URL_ADMIN, 'affiliate-edit.php?affiliateid=' .  $oPublisher->publisherId),
                htmlspecialchars($oPublisher->publisherName),
            ));
            $redirectURL = "affiliate-edit.php?affiliateid={$oPublisher->publisherId}";
        }
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        OX_Admin_Redirect::redirect($redirectURL);

    }
    return $oPublisherDll;
}

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($affiliateid, $form, $oPublisherDll = null)
{
    //header and breadcrumbs
    $oHeaderModel = MAX_displayWebsiteBreadcrumbs($affiliateid);
    if ($affiliateid != "") {
        OA_Admin_Menu::setPublisherPageContext($affiliateid, 'affiliate-edit.php');
        addWebsitePageTools($affiliateid);
        phpAds_PageHeader(null, $oHeaderModel);
    }
    else {
        phpAds_PageHeader("affiliate-edit_new", $oHeaderModel);
    }

    //get template and display form
    $oTpl = new OA_Admin_Template('affiliate-edit.html');
    $oTpl->assign('affiliateid', $affiliateid);
    $oTpl->assign('form', $form->serialize());

    if (isset($oPublisherDll)) {
        $oTpl->assign('error',  $oPublisherDll->_errorMessage);
        $oTpl->assign('notice', $oPublisherDll->_noticeMessage);
    }

    $oTpl->assign('showAdDirect', (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) ? true : false);
    $oTpl->assign('keyAddNew', $keyAddNew);

    $oTpl->display();

    //footer
    phpAds_PageFooter();
}
?>
