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
$Id: market-inactive.php 41632 2009-08-18 13:38:11Z stanislaw.osinski $
*/

require_once 'market-common.php';
require_once MAX_PATH .'/lib/OX/Admin/Redirect.php';

// Security check
$oMarketComponent = OX_Component::factory('admin', 'oxMarket');
$oMarketComponent->enforceProperAccountAccess();

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/

//check if you can see this page (pluigin should be inactive in this case)
$oMarketComponent->checkRegistered();
$oMarketComponent->checkActive(false);

$aDeactivationStatus = $oMarketComponent->getInactiveStatus();
// Is there is no deactivation status it is missing API Key problem
if (!isset($aDeactivationStatus['code'])) {
    // Add form for relinking to the market
    $oForm = buildRelinkForm($oMarketComponent);
    $isFormValid = $oForm->validate();

    if ($isFormValid) {
        // process submitted values
        $aProcessingError = processRelinkForm($oForm, $oMarketComponent);
    }
}

//header
$oUI = OA_Admin_UI::getInstance();
$oUI->registerStylesheetFile(MAX::constructURL(
    MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css?v=' . htmlspecialchars($oMarketComponent->getPluginVersion())));
phpAds_PageHeader("openx-market",'','../../');

//get template and display form
$oTpl = new OA_Plugin_Template('market-inactive.html','openXMarket');

$oTpl->assign('deactivationStatus', $aDeactivationStatus['code']);
$oTpl->assign('deactivationStatusMessage', $aDeactivationStatus['message']);
$oTpl->assign('pluginVersion', $oMarketComponent->getPluginVersion());

if (isset($oForm)) {
    // Add form for relinking to the market
    $oTpl->assign('form', $oForm->serialize());
    $oTpl->assign('hasServerError', !empty($aProcessingError) && $aProcessingError['error']);
    $oTpl->assign('errorMessage', getErrorMessage($oMarketComponent, $aProcessingError));
    foreach ($aStrings as $stringKey => $stringValue) {
        $oTpl->assign($stringKey, $stringValue);
    }
}

$oTpl->assign('publisherSupportEmail', $oMarketComponent->getConfigValue('publisherSupportEmail'));

$oTpl->display();

//footer
phpAds_PageFooter();


/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildRelinkForm($oMarketComponent)
{
    $aStrings = getTranslationLabels($oMarketComponent);

    //build form
    $oForm = new OA_Admin_UI_Component_Form("market-relink-form", "POST", $_SERVER['SCRIPT_NAME']);
    $oForm->forceClientValidation(false);

    //existing account part
    $oForm->addElement('header', 'accountHeader', $aStrings['has_account_header_text']);
    $oForm->addElement('text', 'm_username', $aStrings['login_field_label'], array('class' => 'medium'));
    $oForm->addElement('password', 'm_password', $aStrings['password_field_label'],
        array('class' => 'medium'));

    //common
    $oForm->addElement('checkbox', 'market_terms_agree', null, $aStrings['market_terms_field_label']);

    $oForm->addElement('controls', 'form-controls');
    $oForm->addElement('submit', 'save', $aStrings['submit_field_label']);


    //Form validation rules
    //if (!$oForm->isSubmitted()) {
        $usernameRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'],
            array($aStrings['login_field_label']));
        $oForm->addRule('m_username', $usernameRequired, 'required');
        $passwordRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'],
            array($aStrings['password_field_label']));
        $oForm->addRule('m_password', $passwordRequired, 'required');
        $oForm->addRule('market_terms_agree', $aStrings['market_terms_field_invalid_message'], 'required');
    //}

    return $oForm;
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
function processRelinkForm($oForm, $oMarketComponent)
{
    $aFields = $oForm->exportValues();
    try {
        $oApiClient = $oMarketComponent->getPublisherConsoleApiClient();

        // GetApiKey!
        $linkingResult = $oApiClient->getApiKey($aFields['m_username'],$aFields['m_password']);

        if ($linkingResult == true) {
            // perform activation actions
            $oMarketComponent->removeRegisterNotification();
        }
    }
    catch (Exception $exc) {
        OA::debug('Error during Market signup: ('.$exc->getCode().')'.$exc->getMessage());
        if ($exc->getCode() == OA_CENTRAL_ERROR_CAPTCHA_FAILED) {
            $aStrings = getTranslationLabels($oMarketComponent);
            $oForm->setElementError('g_captcha', $aStrings['signup_captcha_field_mismatch_message']);
            return array("error" => false);
        }

        return array("error" => true, "message" => $exc->getMessage(), "code" => $exc->getCode());
    }

    OX_Admin_Redirect::redirect("plugins/oxMarket/market-confirm.php");

}

function getTranslationLabels($oMarketComponent)
{
    static $aContentStrings;

    $marketTermsLink = $oMarketComponent->getConfigValue('marketTermsUrl');
    $marketPrivacyLink = $oMarketComponent->getConfigValue('marketPrivacyUrl');
    $publisherSupportEmail = $oMarketComponent->getConfigValue('publisherSupportEmail');

    if ($aContentStrings != null) {
        return $aContentStrings;
    }

    $aContentStrings['has_account_header_text'] =
        "<div class='header'>Please enter your OpenX.org account information</div>";

    $aContentStrings['login_field_label'] =
        'OpenX.org Username';

    $aContentStrings['password_field_label'] =
        'Password';

    $aContentStrings['market_terms_field_label'] =
        "I accept the OpenX Market <a target='_blank' href='$marketTermsLink'>terms and conditions</a> and <a target='_blank' href='$marketPrivacyLink'>data privacy policy</a>.";

    $aContentStrings['submit_field_label'] =
        'Submit';

    $aContentStrings['market_terms_field_invalid_message'] =
        "Please agree with OpenX Market terms and conditions and data privacy policy";

    $aContentStrings['error_message']['701'] =
          '<div>Invalid user name or password.</div>
            <ul>
              <li>Please check that the OpenX User name and password are correct.</li>
              <li>If you have recently signed up for a new OpenX.org Account,
              make sure you have gone into your email and activated your OpenX.org Account.</li>
            </ul>';

    $aContentStrings['error_message']['702'] =
        $aContentStrings['error_message']['701']; //701,702 reuse the message

    $aContentStrings['error_message']['913'] =
          'This OpenX.org account is not associated with OpenX Market (Code 913).'
          .'<br>Please try again in couple of minutes. If the problem persists,'
          .'please contact <a href="mailto:'.$publisherSupportEmail.'">OpenX Market publisher support</a> for assistance.';

    $aContentStrings['error_message']['unknown'] =
          'An error occured (Code %s).' //%s needs to be replaced with error.code
          .'<br>Please try again in couple of minutes. If the problem persists,'
          .'please contact <a href="mailto:'.$publisherSupportEmail.'">OpenX Market publisher support</a>'
          .' for assistance.';

    // PEAR XML-RPC errors
    $aXmlRpcPearErrors = array('0', '1', '2', '3', '4', '5', '6', '7',
                  '101', '102', '103', '104', '105', '106');
    foreach ($aXmlRpcPearErrors as $errnum) {
        $aContentStrings['error_message'][$errnum] =
              'An error occurred (Code %s: %s)' //%s needs to replaced with code and exc message
              .'<br>The problem may be caused by an improper configuration of your OpenX Ad Server'
              .' or your web server or by the lack of a required PHP extension.'
              .' <br>If the problem persists, please contact <a href="mailto:%s' //%s needs to be replaced with publisher support email
              .'">OpenX Market publisher support</a> for assistance.';
    }

    return $aContentStrings;
}

function getErrorMessage($oMarketComponent, $error)
{
    $aStrings = getTranslationLabels($oMarketComponent);
    $errorKey = ''.$error['code'].'';
    $publisherSupportEmail = $oMarketComponent->getConfigValue('publisherSupportEmail');

    if (isset($aStrings['error_message'][$errorKey])) {
        $message = $aStrings['error_message'][$errorKey];
        $aXmlRpcPearErrors = array( '0', '1', '2', '3', '4', '5', '6', '7',
                  '101', '102', '103', '104', '105', '106');
        if (in_array($error['code'], $aXmlRpcPearErrors)) {
            $message = vsprintf($message, array($error['code'], $error['message'], $publisherSupportEmail));
        }
    }
    else {
        $message = vsprintf($aStrings['error_message']['unknown'],
            array($error['code'], $publisherSupportEmail));
    }

    return $message;
}