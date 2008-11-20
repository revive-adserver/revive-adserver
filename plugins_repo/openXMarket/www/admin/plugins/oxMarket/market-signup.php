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

$paymentForm = buildSignupForm($oMarketComponent);
$isFormValid = $paymentForm->validate();

if ($isFormValid) {
    //process submitted values
    $processingErrors = processForm($paymentForm, $oMarketComponent);
    if (!empty($processingErrors)) {
        displayPage($paymentForm, $oMarketComponent, $processingErrors);
    }
}
else { //either validation failed or form was not submitted, display the form
    displayPage($paymentForm, $oMarketComponent);
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

    $oForm->addElement('header', 'signup_info', $oMarketComponent->translate('Create an OpenX Market publisher account'));
    $oForm->addElement('html', 'info', $oMarketComponent->translate("To start using OpenX Market you need to have OpenX account. Please <a href='%s' target='_blank'>create OpenX Account</a> if you do not have one.", array($ssoSignupUrl)));
    $oForm->addElement('text', 'm_username', $oMarketComponent->translate('OpenX Account name'));
    $oForm->addElement('password', 'm_password', $oMarketComponent->translate('Password'));
    $oForm->addElement('checkbox', 'terms_agree', null, $oMarketComponent->translate("I accept the OpenX Market <a href='%s'>terms and conditions</a> and <a href='%s'>data privacy policy</a>.", array($termsLink, $privacyLink)));
    $oForm->addElement('controls', 'form-controls');
    $oForm->addElement('submit', 'save', $oMarketComponent->translate('Sign up'));
    
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


    OX_Admin_Redirect::redirect("plugins/oxMarket/market-confirm.php");
    
    //return array("error" => true, "errorMessages" => "Comunication error occured");
    
}

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($oForm, $oMarketComponent, $aProcessingErrors = null)
{
    //header
    phpAds_PageHeader("openx-market",'','../../');

    //get template and display form
    $oTpl = new OA_Plugin_Template('market-signup.html','openXMarket');
    $oTpl->assign('form', $oForm->serialize());

    $oTpl->assign('error', !empty($aProcessingErrors));
    $oTpl->assign('aErrorMessages', $aProcessingErrors['errorMessages']);
    
    $oTpl->display();

    //footer
    phpAds_PageFooter();
}
?>
