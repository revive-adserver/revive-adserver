<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';
require_once MAX_PATH . '/lib/OA/Admin/Menu.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';


// Register input variables
phpAds_registerGlobalUnslashed ('move', 'name', 'website', 'contact', 'email', 'language', 'advsignup',
                               'errormessage', 'submit', 'publiczones_old', 'formId', 'category', 'country', 'language');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid, true);

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
     $GLOBALS['_MAX']['CONF']['plugins']['openXThorium'])
{
    $oComponent = &OX_Component::factory('admin', 'oxThorium', 'oxThorium');
}

//build form
$websiteForm = buildWebsiteForm($affiliate);

if ($websiteForm->validate()) {
    //process submitted values
    processForm($affiliateid, $websiteForm, $oComponent);
}
else { //either validation failed or form was not submitted, display the form
    displayPage($affiliateid, $websiteForm);
}


/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildWebsiteForm($affiliate)
{
    // Initialise Ad  Networks
    $oAdNetworks = new OA_Central_AdNetworks();

    $form = new OA_Admin_UI_Component_Form("affiliateform", "POST", $_SERVER['PHP_SELF']);
    $form->forceClientValidation(true);
    $form->addElement('hidden', 'affiliateid', $affiliate['affiliateid']);

    $form->addElement('header', 'basic_info', $GLOBALS['strBasicInformation']);
    $form->addElement('text', 'website', $GLOBALS['strWebsiteURL']);
    $form->addElement('text', 'name', $GLOBALS['strName']);
    if (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) {
        $form->addElement('checkbox', 'advsignup', $GLOBALS['strAdvertiserSignup'], $GLOBALS['strAdvertiserSignupDesc'],
            array('disabled' => !$GLOBALS['_MAX']['CONF']['sync']['checkForUpdates']));
        $form->addElement('custom', 'advertiser-signup-dialog', null,
                         array('formId'  => $form->getId()), false);
    }
    $form->addElement('text', 'contact', $GLOBALS['strContact']);
    $form->addElement('text', 'email', $GLOBALS['strEMail']);

    $form->addElement('select', 'category', $GLOBALS['strCategory'], $oAdNetworks->getCategoriesSelect(), array('style'=>'width: 16em;'));
    $catLangGroup['country'] = $form->createElement('select', 'country', null, $oAdNetworks->getCountriesSelect());
    $catLangGroup['country']->setAttribute('style', 'width: 16em;');
    $catLangGroup['lang'] = $form->createElement('select', 'language', null, $oAdNetworks->getLanguagesSelect());
    $catLangGroup['lang']->setAttribute('style', 'width: 16em;');
    $form->addGroup($catLangGroup, 'catlang_group', $GLOBALS['strCountry'].' / '.$GLOBALS['strLanguage'], array(" "), false);


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

    // Get unique affiliate
    // XXX: Although the JS suggests otherwise, this unique_name constraint isn't enforced.
    $doAffiliates = OA_Dal::factoryDO('affiliates');
    $doAffiliates->agencyid = OA_Permission::getAgencyId();
    $aUniqueNames = $doAffiliates->getUniqueValuesFromColumn('name', $affiliate['name']);
    $nameUniqueMsg = $translation->translate($GLOBALS['strXUniqueField'],
        array($GLOBALS['strAffiliate'], strtolower($GLOBALS['strName'])));
    $form->addRule('name', $nameUniqueMsg, 'unique', $aUniqueNames);



    //set form  values
    $form->setDefaults($affiliate);
    $form->setDefaults(
        array("category" => $affiliate['oac_category_id'],
              "country"  => $affiliate['oac_country_code'],
              "language" => $affiliate['oac_language_id'],
              'advsignup' => !empty($affiliate['as_website_id'])
        ));
    return $form;
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
 function processForm($affiliateid, $form, $oComponent)
{
    $aFields = $form->exportValues();
    $newWebsite = empty($aFields['affiliateid']);

    if (!(is_numeric($aFields['oac_category_id'])) || ($aFields['oac_category_id'] <= 0)) {
            $aFields['oac_category_id'] = 'NULL';
    }

    // Setup a new publisher object and set the fields passed in from the form:
    $oPublisher = new OA_Dll_PublisherInfo();
    $oPublisher->agencyId       = $aFields['agencyid'];
    $oPublisher->contactName    = $aFields['contact'];
    $oPublisher->emailAddress   = $aFields['email'];
    $oPublisher->publisherId    = $aFields['affiliateid'];
    $oPublisher->publisherName  = $aFields['name'];
    $oPublisher->oacCategoryId  = $aFields['category'];
    $oPublisher->oacCountryCode = $aFields['country'];
    $oPublisher->oacLanguageId  = $aFields['language'];
    $oPublisher->website        = $aFields['website'];

    // Do I need to handle this?
    // $oPublisher->adNetworks =   ($adnetworks == 't') ? true : false;
    $oPublisher->advSignup  =   ($aFields['advsignup'] == '1') ? true : false;

    $oPublisherDll = new OA_Dll_Publisher();
    if ($oPublisherDll->modify($oPublisher) && !$oPublisherDll->_noticeMessage) {
        //  process form data for oxThorium
        if ($oComponent)
        {
            $aFields['affiliateid'] = $oPublisher->publisherId;
            $oComponent->processAffiliateForm($aFields);
        }

        // Queue confirmation message
        $translation = new OX_Translation ();
        if ($newWebsite) {
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
}

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($affiliateid, $form)
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

    $oTpl->assign('error',  $oPublisherDll->_errorMessage);
    $oTpl->assign('notice', $oPublisherDll->_noticeMessage);


    $oTpl->assign('showAdDirect', (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) ? true : false);
    $oTpl->assign('keyAddNew', $keyAddNew);

    $oTpl->display();

    //footer
    phpAds_PageFooter();
}
?>
