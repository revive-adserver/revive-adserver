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
$Id: market-account-edit.php 24004 2008-08-11 15:34:24Z radek.maciaszek@openx.org $
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
$paymentForm = buildSignupForm($oMarketComponent);

if ($paymentForm->validate()) {
    //process submitted values
    processForm($paymentForm, $oMarketComponent);
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
    
    $oForm = new OA_Admin_UI_Component_Form("market-signup-form", "POST", $_SERVER['PHP_SELF']);
    $oForm->forceClientValidation(true);

    $oForm->addElement('header', 'signup_info', $oMarketComponent->translate('Create an OpenX Market publisher account'));
    $oForm->addElement('text', 'm_username', $oMarketComponent->translate('OpenX Account username'));
    $oForm->addElement('password', 'm_password', $oMarketComponent->translate('Password'));
    $oForm->addElement('advcheckbox', 'terms_agree', null, $oMarketComponent->translate("I accept the OpenX Market <a href='$termsLink'>terms and conditions</a> and <a href='$privacyLink'>data privacy policy</a>."), null, array("f", "t"));
    $oForm->addElement('controls', 'form-controls');
    $oForm->addElement('submit', 'save', $oMarketComponent->translate('Sign up'));
    
    //Form validation rules
    $usernameRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'], array($oMarketComponent->translate('OpenX Account username')));
    $oForm->addRule('m_username', $usernameRequired, 'required');

    $passwordRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'], array($oMarketComponent->translate('Password')));
    $oForm->addRule('m_password', $passwordRequired, 'required');
    

    return $oForm;
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
function processForm($oForm, $oMarketComponent)
{
    $aFields = $oForm->exportValues();

    //OA_Admin_UI::queueMessage($oTrans->translate('Signup details have been updated', 'local', 'confirm', 0));

    OX_Admin_Redirect::redirect("plugins/oxMarket/market-confirm.php");
}

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($oForm, $oMarketComponent)
{
    //header
    phpAds_PageHeader("openx-market",'','../../');

    //get template and display form
    $oTpl = new OA_Plugin_Template('market-signup.html','openXMarket');
    $oTpl->assign('form', $oForm->serialize());
    $oTpl->assign('oMarketComponent', $oForm->serialize());
    $ssoSignupUrl = $oMarketComponent->getConfigValue('ssoSignupUrl');
    $oTpl->assign('ssoSignupUrl', $ssoSignupUrl);

    $oTpl->display();

    //footer
    phpAds_PageFooter();
}
?>
