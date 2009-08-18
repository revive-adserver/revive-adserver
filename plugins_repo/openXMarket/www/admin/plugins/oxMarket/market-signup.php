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
$Id$
*/

require_once 'market-common.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH .'/lib/OX/Admin/Redirect.php';

// Security check
//OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);
$oMarketComponent = OX_Component::factory('admin', 'oxMarket');
$oMarketComponent->enforceProperAccountAccess();

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
//check if you can see this page
$oMarketComponent->checkRegistered(false);
$oMarketComponent->updateSSLMessage();

// Try to automatically register user on multiple accounts mode is on
// and we are working on hosted platform
oxMarketAutoRegisterIfHosted($oMarketComponent);

$captchaRandom = mktime();
$signupForm = buildSignupForm($oMarketComponent, $captchaRandom);
$isFormValid = $signupForm->validate();

if ($isFormValid) {
    //process submitted values
    $processingError = processForm($signupForm, $oMarketComponent);
    if (!empty($processingError)) {
        updateCaptcha($signupForm, $captchaRandom);
        displayPage($signupForm, $oMarketComponent, $processingError);
    }
}
else { //either validation failed or form was not submitted, display the form
    updateCaptcha($signupForm, $captchaRandom);
    displayPage($signupForm, $oMarketComponent);
}

/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildSignupForm($oMarketComponent, $captchaRandom)
{
    $aStrings = getTranslationLabels($oMarketComponent);

    //build form
    $oForm = new OA_Admin_UI_Component_Form("market-signup-form", "POST", $_SERVER['SCRIPT_NAME']);
    $oForm->forceClientValidation(false);
    $captchaUrl = buildCaptchaUrl($oMarketComponent, $captchaRandom);
    $oForm->addElement('hidden', 'captchaRandom', $captchaRandom);

    $oForm->addElement('header', 'h_ex_account', $aStrings['header_title']);
    $oForm->addElement('html', 'formIntro', $aStrings['form_prefix']);

    $oForm->addElement('html', 'pickAccountPrefix', $aStrings['account_question_header_text']);
    $accountChoice[] = $oForm->createElement ( 'radio', 'accountMode', null,
        $aStrings['has_account_field_label'], 'login', array ('id' => 'account-login' ) );
    $accountChoice[] = $oForm->createElement ( 'radio', 'accountMode', null,
        $aStrings['no_account_field_label'], 'signup', array ('id' => 'account-signup' ) );
    $oForm->addGroup ($accountChoice, 'g_account_choice', "");
    $accountSectionId = $oForm->isSubmitted() && isset($_POST['accountMode']) ? $_POST['accountMode'] : 'none';

    //existing account part
    $oForm->addElement('html', 'accountPrefix', $aStrings['has_account_header_text']);
    $oForm->addElement('text', 'm_username', $aStrings['login_field_label'], array('class' => 'medium'));
    $oForm->addElement('password', 'm_password', $aStrings['password_field_label'],
        array('class' => 'medium'));

    // hide elements
    $loginSectionActive = $accountSectionId == 'login';
    $oForm->addDecorator('accountPrefix', 'process', array('tag' => 'tr',
       'addAttributes' => array('id' => 'line-account-login-accountPrefix{numCall}', 'class' => $loginSectionActive ? null : 'hide')));
    $oForm->addDecorator('m_username', 'process', array('tag' => 'tr',
       'addAttributes' => array('id' => 'line-account-login-username{numCall}', 'class' => $loginSectionActive ? null : 'hide')));
    $oForm->addDecorator('m_password', 'process', array('tag' => 'tr',
       'addAttributes' => array('id' => 'line-account-login-password{numCall}', 'class' => $loginSectionActive ? null : 'hide')));

    //new account part
    $oForm->addElement('html', 'newAccountPrefix', $aStrings['no_account_header_text']);
    $oForm->addElement('text', 'm_new_email', $aStrings['signup_email_field_label'], array('class' => 'medium'));

    $usernameGroup[] = $oForm->createElement('text', 'm_new_username', "", array('class' => 'medium'));
    $usernameGroup[] = $oForm->createElement('html', 'm_username_check_indicator', '<span class="hide" id="user-check-indicator">
                                <span class="available-int">Available</span>
                                <span class="unavailable-int">Not available</span>
                                <span class="checking-int">Checking...</span>
                                </span>');
    $oForm->addGroup ($usernameGroup, 'g_new_username', $aStrings['signup_username_field_label'], array("") );


    $oForm->addElement('password', 'm_new_password', $aStrings['signup_password_field_label'],
        array('class' => 'medium'));
    $oForm->addElement('password', 'm_new_confirm_password', $aStrings['signup_password_confirm_field_label'],
        array('class' => 'medium'));

    $captchaGroup[] = $oForm->createElement('text', 'm_captcha', '', array('class' => 'medium'));
    $captchaGroup[] = $oForm->createElement('html', 'm_captcha_reload',
        $aStrings['signup_captcha_reload_text']);
    $captchaGroup[] = $oForm->createElement('html', 'm_captcha_image', "<img id='captcha-image' src='$captchaUrl' />");
    $oForm->addGroup ($captchaGroup, 'g_captcha', $aStrings['signup_captcha_field_label'], array("","<br>") );

    $oForm->addElement('checkbox', 'openx_terms_agree', null, $aStrings['signup_openx_terms_field_label']);

    // hide elements
    $signupSectionActive = $accountSectionId == 'signup';
    $oForm->addDecorator('newAccountPrefix', 'process', array('tag' => 'tr',
       'addAttributes' => array('id' => 'line-account-signup-newAccountPrefix{numCall}', 'class' => $signupSectionActive ? null : 'hide')));
    $oForm->addDecorator('m_new_email', 'process', array('tag' => 'tr',
       'addAttributes' => array('id' => 'line-account-signup-email{numCall}', 'class' => $signupSectionActive ? null : 'hide')));
    $oForm->addDecorator('g_new_username', 'process', array('tag' => 'tr',
       'addAttributes' => array('id' => 'line-account-signup-username{numCall}', 'class' => $signupSectionActive ? null : 'hide')));
    $oForm->addDecorator('m_new_password', 'process', array('tag' => 'tr',
       'addAttributes' => array('id' => 'line-account-signup-password{numCall}', 'class' => $signupSectionActive ? null : 'hide')));
    $oForm->addDecorator('m_new_confirm_password', 'process', array('tag' => 'tr',
       'addAttributes' => array('id' => 'line-account-signup-confirm-password{numCall}', 'class' => $signupSectionActive ? null : 'hide')));
    $oForm->addDecorator('g_captcha', 'process', array('tag' => 'tr',
       'addAttributes' => array('id' => 'line-account-signup-captcha{numCall}', 'class' => $signupSectionActive ? null : 'hide')));
    $oForm->addDecorator('openx_terms_agree', 'process', array('tag' => 'tr',
       'addAttributes' => array('id' => 'line-account-signup-openx-terms{numCall}', 'class' => $signupSectionActive ? null : 'hide')));

    //common
    $oForm->addElement('checkbox', 'market_terms_agree', null, $aStrings['market_terms_field_label']);
    $oForm->addDecorator('market_terms_agree', 'process', array('tag' => 'tr',
       'addAttributes' => array('id' => 'line-account-both-market-terms{numCall}', 'class' => ($loginSectionActive || $signupSectionActive) ? null : 'hide')));

    $oForm->addElement('controls', 'form-controls');
    $oForm->addElement('submit', 'save', $aStrings['submit_field_label']);


    //Form validation rules
    $oForm->addGroupRule('g_account_choice', $aStrings['account_question_required_message'], 'required', null, 1);

    //hack for conditional validation....
    if (!$oForm->isSubmitted() || $loginSectionActive) {
        $usernameRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'],
            array($aStrings['login_field_label']));
        $oForm->addRule('m_username', $usernameRequired, 'required');
        $passwordRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'],
            array($aStrings['password_field_label']));
        $oForm->addRule('m_password', $passwordRequired, 'required');
    }
    if (!$oForm->isSubmitted() || $signupSectionActive) {
        $sgEmailRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'],
            array($aStrings['signup_email_field_label']));
        $oForm->addRule('m_new_email', $sgEmailRequired, 'required');
        $oForm->addRule('m_new_email', $GLOBALS['strEmailField'], 'email');

        $sgUserNameRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'],
            array($aStrings['signup_username_field_label']));
        $userNameRequiredRule = array($sgUserNameRequired, 'required');
        $oForm->registerRule('usernamecheck', 'callback', 'validateUserNameUnique');
        $userNameNotUnique = array($aStrings['signup_username_not_available_message'], 'usernamecheck');
        $oForm->addGroupRule('g_new_username',
            array('m_new_username' => array($userNameRequiredRule, $userNameNotUnique)
        ));
        $sgPasswordRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'],
            array($aStrings['signup_password_field_label']));
        $oForm->addRule('m_new_password', $sgPasswordRequired, 'required');
        $sgPasswordConfirmRequired = $oMarketComponent->translate($GLOBALS['strXRequiredField'],
            array($aStrings['signup_password_confirm_field_label']));
        $oForm->addRule('m_new_confirm_password', $sgPasswordConfirmRequired, 'required');
        $oForm->addRule(array('m_new_confirm_password', 'm_new_password'),
            $aStrings['signup_password_field_mismatch_message'], 'compare', 'eq');
        $oForm->addRule('openx_terms_agree', $aStrings['signup_openx_terms_field_invalid_message'], 'required');
        $captchaRequiredRule = array($aStrings['signup_captcha_field_required_message'], 'required');
        $oForm->addGroupRule('g_captcha',
            array(
                'm_captcha' => array($captchaRequiredRule)
            ));
    }
    if(!$oForm->isSubmitted() || $loginSectionActive || $signupSectionActive) {
        $oForm->addRule('market_terms_agree', $aStrings['market_terms_field_invalid_message'], 'required');
    }


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
        $linkingResult = false;
        if ("login" == $aFields['accountMode']) {
            $linkingResult = $oApiClient->createAccountBySsoCred($aFields['m_username'],$aFields['m_password']);
            $mode = 'e';
        }
        elseif ("signup" == $aFields['accountMode']) {
            //call client signup function here
            $linkingResult = $oApiClient->createAccount($aFields['m_new_email'],$aFields['m_new_username'],
                                $aFields['m_new_password'], $aFields['m_captcha'], $aFields['captchaRandom']);
            $mode = 'n';                                
        }

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

    OX_Admin_Redirect::redirect("plugins/oxMarket/market-confirm.php?m=$mode");

}

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($oForm, $oMarketComponent, $aProcessingError = null)
{
    //header
    $oUI = OA_Admin_UI::getInstance();
    $oUI->registerStylesheetFile(MAX::constructURL(
        MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css?v=' . htmlspecialchars($oMarketComponent->getPluginVersion())));
    phpAds_PageHeader("openx-market",'','../../');

    //get template and display form
    $aStrings = getTranslationLabels($oMarketComponent);
    $oTpl = new OA_Plugin_Template('market-signup.html','openXMarket');
    $oTpl->assign('form', $oForm->serialize());
    $oTpl->assign('hasServerError', !empty($aProcessingError) && $aProcessingError['error']);
    $oTpl->assign('errorMessage', getErrorMessage($oMarketComponent, $aProcessingError));

    $oTpl->assign('captchaBaseUrl', buildCaptchaUrl($oMarketComponent));
    $oTpl->assign('trackerFrame', $aStrings['tracker_iframe']);
    $oTpl->assign('pluginVersion', $oMarketComponent->getPluginVersion());
    
    foreach ($aStrings as $stringKey => $stringValue) {
        $oTpl->assign($stringKey, $stringValue);
    }
    $oTpl->display();

    //footer
    phpAds_PageFooter();
}


function validateUserNameUnique($userName)
{
    $result = true; //allow by default, if we cannot validate allow username,
                    //should fail anyway on linkOXP
    try {
        $oMarketComponent = OX_Component::factory('admin', 'oxMarket');
        $result =  $oMarketComponent->isSsoUserNameAvailable($userName);
    }
    catch (Exception $exc) {
        OA::debug('Error during checking SSO username uniqueness: ('
            .$exc->getCode().')'.$exc->getMessage());
    }

    return $result;
}


function buildCaptchaUrl($oMarketComponent, $random = null)
{
    $platformHash = OA_Dal_ApplicationVariables::get('platform_hash');
    $captchaUrl = $oMarketComponent->getConfigValue('marketCaptchaUrl');
    $captchaUrl .= "?ph=$platformHash";

    if (!empty($random)) {
        $captchaUrl .= "&t=$random";
    }

    return $captchaUrl;
}


function getTranslationLabels($oMarketComponent)
{
    static $aContentStrings;

    if ($aContentStrings != null) {
        return $aContentStrings;
    }

    $marketTermsLink = $oMarketComponent->getConfigValue('marketTermsUrl');
    $marketPrivacyLink = $oMarketComponent->getConfigValue('marketPrivacyUrl');
    $openXTermsLink = $oMarketComponent->getConfigValue('openXTermsUrl');
    $openXPrivacyLink = $oMarketComponent->getConfigValue('openXPrivacyUrl');
    $publisherSupportEmail = $oMarketComponent->getConfigValue('publisherSupportEmail');

    $aContentKeys = $oMarketComponent->retrieveCustomContent('market-signup');
    if (!$aContentKeys) {
        $aContentKeys = array();
    }

    //get the custom content and fallback to hardcoded if not found
    $aContentStrings['header_title'] = isset($aContentKeys['header-title'])
        ? $aContentKeys['header-title']
        : '<span class="section-header">Provide an OpenX.org account</span>
            <span class="link" help="help-market-info"><span class="icon icon-info">&nbsp;</span></span>
            <div class="hide" id="help-market-info" style="height: auto; width: 270px;">
            <p>
                An OpenX.org account is an account which you may use to login to a variety
                of OpenX products like OpenX Hosted, the OpenX Community Forums, and more.
            </p>
          ';
    $aContentStrings['form_prefix'] = isset($aContentKeys['form-prefix'])
        ? $aContentKeys['form-prefix']
        : "To get started, provide your OpenX.org account. If you don't have an OpenX.org account, you may create a new one below.";

    $aContentStrings['account_question_header_text'] = isset($aContentKeys['account-question-header-text'])
        ? $aContentKeys['account-question-header-text']
        : "<div class='header'>Do you already have an OpenX.org account?</div>";

    $aContentStrings['account_question_required_message'] = isset($aContentKeys['account-question-required-message'])
        ? $aContentKeys['account-question-required-message']
        : "Please indicate whether you'd like to use an existing OpenX.org account or create a new one";

    $aContentStrings['has_account_field_label'] = isset($aContentKeys['has-account-field-label'])
        ? $aContentKeys['has-account-field-label']
        : "<span class='type-name'>I <em>have</em> an OpenX.org account</span>";

    $aContentStrings['no_account_field_label'] = isset($aContentKeys['no-account-field-label'])
        ? $aContentKeys['no-account-field-label']
        : "<span class='type-name'>I <em>do not have</em> an OpenX.org account</span>";

    $aContentStrings['has_account_header_text'] = isset($aContentKeys['has-account-header-text'])
        ? $aContentKeys['has-account-header-text']
        : "<div class='header'>Please enter your OpenX.org account information</div>";

    $aContentStrings['login_field_label'] = isset($aContentKeys['login-field-label'])
        ? $aContentKeys['login-field-label']
        : 'OpenX.org Username';

    $aContentStrings['password_field_label'] = isset($aContentKeys['password-field-label'])
        ? $aContentKeys['password-field-label']
        : 'Password';

    $aContentStrings['market_terms_field_label'] = isset($aContentKeys['market-terms-field-label'])
        ? vsprintf($aContentKeys['market-terms-field-label'], array($marketTermsLink, $marketPrivacyLink))
        : "I accept the OpenX Market <a target='_blank' href='$marketTermsLink'>terms and conditions</a> and <a target='_blank' href='$marketPrivacyLink'>data privacy policy</a>.";

    $aContentStrings['market_terms_field_invalid_message'] = isset($aContentKeys['market-terms-field-invalid-message'])
        ? $aContentKeys['market-terms-field-invalid-message']
        : "Please agree with OpenX Market terms and conditions and data privacy policy";

    $aContentStrings['no_account_header_text'] = isset($aContentKeys['no-account-header-text'])
        ? $aContentKeys['no-account-header-text']
        : "<div class='header'>Create a new OpenX.org account</div>";

    $aContentStrings['signup_email_field_label'] = isset($aContentKeys['signup-email-field-label'])
        ? $aContentKeys['signup-email-field-label']
        : "Email";

    $aContentStrings['signup_username_field_label'] = isset($aContentKeys['signup-username-field-label'])
        ? $aContentKeys['signup-username-field-label']
        : "Desired OpenX.org username";

    $aContentStrings['signup_username_not_available_message'] = isset($aContentKeys['signup-username-not-available-message'])
        ? $aContentKeys['signup-username-not-available-message']
        : "This OpenX.org username is not available";

    $aContentStrings['signup_password_field_label'] = isset($aContentKeys['signup-password-field-label'])
        ? $aContentKeys['signup-password-field-label']
        : "Password";

    $aContentStrings['signup_password_confirm_field_label'] = isset($aContentKeys['signup-password-confirm-field-label'])
        ? $aContentKeys['signup-password-confirm-field-label']
        : "Re-enter password";

    $aContentStrings['signup_password_field_mismatch_message'] = isset($aContentKeys['signup-password-field-mismatch-message'])
        ? $aContentKeys['signup-password-field-mismatch-message']
        : "The given passwords do not match";

    $aContentStrings['signup_captcha_reload_text'] = isset($aContentKeys['signup-captcha-reload-text'])
        ? $aContentKeys['signup-captcha-reload-text']
        : "<a href='#' id='captcha-reload'>Try a different image</a>";

    $aContentStrings['signup_captcha_field_label'] = isset($aContentKeys['signup-captcha-field-label'])
        ? $aContentKeys['signup-captcha-field-label']
        : "Type the code shown below";

    $aContentStrings['signup_captcha_field_required_message'] = isset($aContentKeys['signup-captcha-field-required-message'])
        ? $aContentKeys['signup-captcha-field-required-message']
        : "Please type the code shown";

    $aContentStrings['signup_captcha_field_mismatch_message'] = isset($aContentKeys['signup-captcha-field-mismatch-message'])
                ? $aContentKeys['signup-captcha-field-mismatch-message']
                : "Enter the word as it is shown in the image";

    $aContentStrings['signup_openx_terms_field_label'] = isset($aContentKeys['signup-openx-terms-field-label'])
        ? vsprintf($aContentKeys['signup-openx-terms-field-label'], array($openXTermsLink, $openXPrivacyLink))
        : "I accept the OpenX <a target='_blank' href='$openXTermsLink'>terms and conditions</a> and <a target='_blank' href='$openXPrivacyLink'>data privacy policy</a>.";

    $aContentStrings['signup_openx_terms_field_invalid_message'] = isset($aContentKeys['signup-openx-terms-field-invalid-message'])
        ? $aContentKeys['signup-openx-terms-field-invalid-message']
        : "Please agree with the OpenX terms and conditions and data privacy policy";

    $aContentStrings['submit_field_label'] = isset($aContentKeys['submit-field-label'])
        ? $aContentKeys['submit-field-label']
        : 'Submit';

    $aContentStrings['tracker_iframe'] = isset($aContentKeys['tracker-iframe'])
        ? $aContentKeys['tracker-iframe']
        : '';

    $aContentStrings['error_message']['701'] = isset($aContentKeys['error-701-message'])
        ? $aContentKeys['error-701-message']
        : '<div>Invalid user name or password.</div>
            <ul>
              <li>Please check that the OpenX User name and password are correct.</li>
              <li>If you have recently signed up for a new OpenX.org Account,
              make sure you have gone into your email and activated your OpenX.org Account.</li>
            </ul>';

    $aContentStrings['error_message']['702'] = isset($aContentKeys['error-702-message'])
        ? $aContentKeys['error-702-message']
        : $aContentStrings['error_message']['701']; //701,702 reuse the message

    $aContentStrings['error_message']['703'] = isset($aContentKeys['error-703-message'])
        ? $aContentKeys['error-703-message']
        : 'There is already an OpenX.org account registered with the given email address.'
          .' To create a new OpenX.org account please use a different email address';

    $aContentStrings['error_message']['901'] = isset($aContentKeys['error-901-message'])
        ? vsprintf($aContentKeys['error-901-message'], array($publisherSupportEmail))
        : 'This Ad Server is already associated with OpenX Market through a different OpenX.org account'
           .' (Code 901). <br>Please contact <a href="mailto:'.$publisherSupportEmail
           .'">OpenX Market publisher support</a> if you need further assistance.';

    $aContentStrings['error_message']['902'] = isset($aContentKeys['error-902-message'])
        ? vsprintf($aContentKeys['error-902-message'], array($publisherSupportEmail))
        : 'This OpenX.org account is already associated with OpenX Market through a different OpenX Ad Server'
          .' (Code 902). <br>Please contact <a href="mailto:'.$publisherSupportEmail
          .'">OpenX Market publisher support</a> if you need further assistance.';

    $aContentStrings['error_message']['912'] = isset($aContentKeys['error-912-message'])
        ? vsprintf($aContentKeys['error-912-message'], array($publisherSupportEmail))
        : 'An error occured while creating your OpenX.org account (Code 912).'
          .'<br>Please try again in couple of minutes. If the problem persists,'
          .'please contact <a href="mailto:'.$publisherSupportEmail.'">OpenX Market publisher support</a> for assistance.';

    $aContentStrings['error_message']['0'] = isset($aContentKeys['error-0-message'])
        ? $aContentKeys['error-0-message']
        : 'A generic error occurred while associating your OpenX.org account (Code 0: %s)' //%s needs to replaced with exc message
          .'<br>The problem may be caused by an improper configuration of your OpenX Ad Server'
          .' or your web server or by the lack of a required PHP extension.'
          .' <br>If the problem persists, please contact <a href="mailto:%s' //%s needs to be replaced with publisher support email
          .'">OpenX Market publisher support</a> for assistance.';

    $aContentStrings['error_message']['unknown'] = isset($aContentKeys['error-unknown-message'])
        ? $aContentKeys['error-unknown-message']
        : 'An error occured while associating your OpenX.org account (Code %s).' //%s needs to be replaced with error.code
          .'<br>Please try again in couple of minutes. If the problem persists,'
          .'please contact <a href="mailto:%s">OpenX Market publisher support</a>' //%s needs to be replaced with publisher support email
          .' for assistance.';

    // PEAR XML-RPC errors
    $aXmlRpcPearErrors = getXmlRpcPearErrorsCodes();
    foreach ($aXmlRpcPearErrors as $errnum) {
        $aContentStrings['error_message'][$errnum] = isset($aContentKeys['error-generic-xml-rpc-message'])
            ? $aContentKeys['error-generic-xml-rpc-message']
            : 'An error occurred while associating your OpenX.org account (Code %s: %s)' //%s needs to replaced with code and exc message
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
        $aXmlRpcPearErrors = getXmlRpcPearErrorsCodes();
        if ($error['code'] == 0) {
            $message = vsprintf($message, array($error['message'], $publisherSupportEmail));
        }
        elseif (in_array($error['code'], $aXmlRpcPearErrors)) {
            $message = vsprintf($message, array($error['code'], $error['message'], $publisherSupportEmail));
        }
    }
    else {
        $message = vsprintf($aStrings['error_message']['unknown'],
            array($error['code'], $publisherSupportEmail));
    }

    return $message;
}

/**
 * Returns codes used and returned by PEAR XML_RPC_Client
 *
 * Codes 1-7 errors caused by invalid response
 * 101-106 errors caused by invalid call (e.g. wrong url)
 *
 * @return array
 */
function getXmlRpcPearErrorsCodes()
{
    return array( '1', '2', '3', '4', '5', '6', '7',
                  '101', '102', '103', '104', '105', '106');
}

function updateCaptcha($oForm, $captchaRandom)
{
    //if validation fails we need to discard old captcha submitted by user and
    //use the newly generated captcha random
    $captchaHidden = $oForm->getElement('captchaRandom');

    if ($captchaHidden->getValue() != $captchaRandom) {
        $captchaHidden->setValue($captchaRandom);
    }
}

/**
 * Check if plugin is in multiple accounts mode and try to automatically register user.
 * On success redirect to market-confirm page
 *
 * @param Plugins_admin_oxMarket_oxMarket $oMarketComponent
 */
function oxMarketAutoRegisterIfHosted($oMarketComponent)
{ 
    $oUser = OA_Permission::getCurrentUser();
    $linkingResult = $oMarketComponent->linkHostedAccounts(
                                            $oUser->aUser['user_id'], 
                                            $oUser->aAccount['account_id']);
    if ($linkingResult === true) {
        // perform activation actions
        $oMarketComponent->removeRegisterNotification();
        OX_Admin_Redirect::redirect("plugins/oxMarket/market-confirm.php");
        exit;
    }
}
