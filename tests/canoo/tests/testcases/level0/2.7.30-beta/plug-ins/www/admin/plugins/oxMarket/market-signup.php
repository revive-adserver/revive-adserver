<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id: market-signup.php 31776 2009-02-02 14:04:31Z lukasz.wikierski $
*/

require_once 'market-common.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH .'/lib/OX/Admin/Redirect.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/

$oMarketComponent = OX_Component::factory('admin', 'oxMarket');
//check if you can see this page
$oMarketComponent->checkRegistered(false);

$signupForm = buildSignupForm($oMarketComponent);
$isFormValid = $signupForm->validate();

if ($isFormValid) {
    //process submitted values
    $processingError = processForm($signupForm, $oMarketComponent);
    if (!empty($processingError)) {
        displayPage($signupForm, $oMarketComponent, $processingError);
    }
}
else { //either validation failed or form was not submitted, display the form
    displayPage($signupForm, $oMarketComponent);
}

/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildSignupForm($oMarketComponent)
{
    $termsLink = $oMarketComponent->getConfigValue('marketTermsUrl');
    $privacyLink = $oMarketComponent->getConfigValue('marketPrivacyUrl');
    $ssoSignupUrl = $oMarketComponent->getConfigValue('ssoSignupUrl');
    
    $aContentKeys = $oMarketComponent->retrieveCustomContent('market-signup');
    if (!$aContentKeys) {
        $aContentKeys = array();
    }
    
    //get the custom content
    $headerText = isset($aContentKeys['header-title']) 
        ? $aContentKeys['header-title']
        : 'Provide your OpenX.org account 
            <span class="link" help="help-market-info"><span class="icon icon-info"></span></span>
            <div class="hide" id="help-market-info" style="height: auto; width: 270px;">
            <p>
                An OpenX.org account is an account which you may use to login to a variety 
                of OpenX products like OpenX Hosted, the OpenX Community Forums, and more.
            </p>
          ';
    $formPrefix = isset($aContentKeys['form-prefix']) 
        ? vsprintf($aContentKeys['form-prefix'], array($ssoSignupUrl))
        : "If you do not have an OpenX.org account, <a target='_blank' href='$ssoSignupUrl'>signup for a new account </a> and then enter it below.";
         
    $userNameLabel = isset($aContentKeys['login-field-label']) 
        ? $aContentKeys['login-field-label'] 
        : 'OpenX.org Username';
        
    $passwordLabel = isset($aContentKeys['password-field-label']) 
        ? $aContentKeys['password-field-label'] 
        : 'OpenX.org Password';
        
    $termsLabel = isset($aContentKeys['terms-field-label']) 
        ? vsprintf($aContentKeys['terms-field-label'], array($termsLink, $privacyLink))  
        : "I accept the OpenX Market <a target='_blank' href='$termsLink'>terms and conditions</a> and <a target='_blank' href='$privacyLink'>data privacy policy</a>.";

    $termsInvalidLabel = isset($aContentKeys['terms-field-invalid-message']) 
        ? $aContentKeys['terms-field-invalid-message']  
        : "Please agree with OpenX Market terms and conditions and data privacy policy";
    
    $submitLabel = isset($aContentKeys['submit-field-label']) 
        ? $aContentKeys['submit-field-label'] 
        : 'Submit';
        
        
    $oForm = new OA_Admin_UI_Component_Form("market-signup-form", "POST", $_SERVER['PHP_SELF']);
    $oForm->forceClientValidation(true);

    $oForm->addElement('header', 'signup_info', $headerText);
    $oForm->addElement('html', 'formPrefix', $formPrefix);
    $oForm->addElement('text', 'm_username', $userNameLabel);
    $oForm->addElement('password', 'm_password', $passwordLabel);
    $oForm->addElement('checkbox', 'terms_agree', null, $termsLabel);
    $oForm->addElement('controls', 'form-controls');
    $oForm->addElement('submit', 'save', $submitLabel);
    
    //Form validation rules
    $usernameRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'], array($userNameLabel));
    $oForm->addRule('m_username', $usernameRequired, 'required');

    $passwordRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'], array($passwordLabel));
    $oForm->addRule('m_password', $passwordRequired, 'required');

    $oForm->addRule('terms_agree', $termsInvalidLabel, 'required');

    return $oForm;
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
function processForm($oForm, $oMarketComponent)
{
    $aFields = $oForm->exportValues();
    try {
        $oApiClient = $oMarketComponent->getPublisherConsoleApiClient();
        if ($oApiClient->linkOxp($aFields['m_username'],$aFields['m_password'])) {
            // perform activation actions
            $oMarketComponent->removeRegisterNotification();
            $oMarketComponent->updateAllWebsites();
        }
    } 
    catch (Exception $exc) {
        OA::debug('Error during Market signup: ('.$exc->getCode().')'.$exc->getMessage());
        return array("error" => true, "message" => $exc->getMessage(), "code" => $exc->getCode());
    }
    
    OX_Admin_Redirect::redirect("plugins/oxMarket/market-confirm.php");

}

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($oForm, $oMarketComponent, $aProcessingError = null)
{
    //header
    phpAds_PageHeader("openx-market",'','../../');

    $aContentKeys = $oMarketComponent->retrieveCustomContent('market-signup');
    if (!$aContentKeys) {
        $aContentKeys = array();
    }    
    $trackerFrame = isset($aContentKeys['tracker-iframe']) 
        ? $aContentKeys['tracker-iframe'] 
        : '';
    
    //get template and display form
    $oTpl = new OA_Plugin_Template('market-signup.html','openXMarket');
    $oTpl->assign('form', $oForm->serialize());

    $oTpl->assign('hasError', !empty($aProcessingError));
    $oTpl->assign('error', $aProcessingError);
    $oTpl->assign('publisherSupportEmail', $oMarketComponent->getConfigValue('publisherSupportEmail'));

    $oTpl->assign('aSsoErrors', array(701, 702));
    $oTpl->assign('aLinkOxpErrors', array(901, 902)); //, 903, 904, 905, 906, 907, 908));
    $oTpl->assign('trackerFrame', $trackerFrame);
    
    $oTpl->display();

    //footer
    phpAds_PageFooter();
}
?>
