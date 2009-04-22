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
$Id: market-signup.php 31449 2009-01-27 08:09:50Z bernard.lange $
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

    $oForm = new OA_Admin_UI_Component_Form("market-signup-form", "POST", $_SERVER['PHP_SELF']);
    $oForm->forceClientValidation(true);

    $oForm->addElement('header', 'signup_info', $oMarketComponent->translate('Associate an existing OpenX account'));
    $oForm->addElement('html', 'info', "<div style='line-height: 170%;'>".$oMarketComponent->translate("To activate OpenX Market, please provide your existing OpenX account information. <br>Don't have an OpenX account? <a href='%s' target='_blank'>Sign up for a new account first</a> and then associate it below.</div>", array($ssoSignupUrl))); 
    $oForm->addElement('text', 'm_username', $oMarketComponent->translate('OpenX User name'));
    $oForm->addElement('password', 'm_password', $oMarketComponent->translate('Password'));
    $oForm->addElement('checkbox', 'terms_agree', null, $oMarketComponent->translate("I accept the OpenX Market <a target='_blank' href='%s'>terms and conditions</a> and <a target='_blank' href='%s'>data privacy policy</a>.", array($termsLink, $privacyLink)));
    $oForm->addElement('controls', 'form-controls');
    $oForm->addElement('submit', 'save', $oMarketComponent->translate('Submit'));
    
    //Form validation rules
    $usernameRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'], array($oMarketComponent->translate('OpenX Account name')));
    $oForm->addRule('m_username', $usernameRequired, 'required');

    $passwordRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'], array($oMarketComponent->translate('Password')));
    $oForm->addRule('m_password', $passwordRequired, 'required');

    $agreeWithTerms = $oMarketComponent->translate("Please agree with OpenX Market terms and conditions and data privacy policy");
    $oForm->addRule('terms_agree', $agreeWithTerms, 'required');

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

    //get template and display form
    $oTpl = new OA_Plugin_Template('market-signup.html','openXMarket');
    $oTpl->assign('form', $oForm->serialize());

    $oTpl->assign('hasError', !empty($aProcessingError));
    $oTpl->assign('error', $aProcessingError);
    $oTpl->assign('publisherSupportEmail', $oMarketComponent->getConfigValue('publisherSupportEmail'));

    $oTpl->assign('aSsoErrors', array(701, 702));
    $oTpl->assign('aLinkOxpErrors', array(901, 902)); //, 903, 904, 905, 906, 907, 908));
    
    $oTpl->display();

    //footer
    phpAds_PageFooter();
}
?>
