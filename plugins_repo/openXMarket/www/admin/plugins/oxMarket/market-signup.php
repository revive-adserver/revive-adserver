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
// Also try to run autoregister method based on data given in installation 
oxMarketAutoRegister($oMarketComponent);

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

    $userNameMaxLenght = 26;    
    $usernameGroup[] = $oForm->createElement('text', 'm_new_username', "", array('class' => 'medium', 'maxlength' => $userNameMaxLenght));
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
        $userNameLength = array($oMarketComponent->translate($GLOBALS['strMaxLengthField'], 
            array($userNameMaxLenght)), 'maxlength', $userNameMaxLenght);
        $oForm->addGroupRule('g_new_username',
            array('m_new_username' => array(
                $userNameRequiredRule,
                $userNameLength, 
                $userNameNotUnique)
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
            $oMarketComponent->scheduleEarnMoreNotification();
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
        MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css.php?v=' . htmlspecialchars($oMarketComponent->getPluginVersion())));
    phpAds_PageHeader("market",'','../../');

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
        $result =  $oMarketComponent->getPublisherConsoleApiClient()->isSsoUserNameAvailable($userName);
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

    $marketTermsLink        = $oMarketComponent->aBranding['links']['marketTermsUrl'];
    $marketPrivacyLink      = $oMarketComponent->aBranding['links']['marketPrivacyUrl'];
    $openXTermsLink         = $oMarketComponent->aBranding['links']['openXTermsUrl'];
    $openXPrivacyLink       = $oMarketComponent->aBranding['links']['openXPrivacyUrl'];
    $publisherSupportEmail  = $oMarketComponent->aBranding['links']['publisherSupportEmail'];

    $aContentKeys = $oMarketComponent->retrieveCustomContent('market-signup');
    if (!$aContentKeys) {
        $aContentKeys = array();
    }

    //get the custom content and fallback to hardcoded if not found
    $aContentStrings['header_title'] = isset($aContentKeys['header-title'])
        ? $aContentKeys['header-title']
        : "<span class='section-header'>" . $oMarketComponent->translate("Provide an %s account", array($oMarketComponent->aBranding['service'])) . "</span>
            <span class='link' help='help-market-info'><span class='icon icon-info'>&nbsp;</span></span>
            <div class='hide' id='help-market-info' style='height: auto; width: 270px;'>
            <p>
                " . $oMarketComponent->translate("An %s account is an account which you may use to login to a variety of OpenX products like OpenX Hosted, the OpenX Community Forums, and more.", array($oMarketComponent->aBranding['service'])) . "
            </p>
          ";
    $aContentStrings['form_prefix'] = isset($aContentKeys['form-prefix'])
        ? $aContentKeys['form-prefix']
        : $oMarketComponent->translate("To get started, provide your %s account. If you don't have an %s account, you may create a new one below.", array($oMarketComponent->aBranding['service'], $oMarketComponent->aBranding['service']));

    $aContentStrings['account_question_header_text'] = isset($aContentKeys['account-question-header-text'])
        ? $aContentKeys['account-question-header-text']
        : "<div class='header'>" . $oMarketComponent->translate("Do you already have an %s account?", array($oMarketComponent->aBranding['service'])) . "</div>";

    $aContentStrings['account_question_required_message'] = isset($aContentKeys['account-question-required-message'])
        ? $aContentKeys['account-question-required-message']
        : $oMarketComponent->translate("Please indicate whether you'd like to use an existing %s account or create a new one", array($oMarketComponent->aBranding['service']));

    $aContentStrings['has_account_field_label'] = isset($aContentKeys['has-account-field-label'])
        ? $aContentKeys['has-account-field-label']
        : "<span class='type-name'>" . $oMarketComponent->translate("I <em>have</em> an %s account", array($oMarketComponent->aBranding['service'])) . "</span>";

    $aContentStrings['no_account_field_label'] = isset($aContentKeys['no-account-field-label'])
        ? $aContentKeys['no-account-field-label']
        : "<span class='type-name'>" . $oMarketComponent->translate("I <em>do not have</em> an %s account", array($oMarketComponent->aBranding['service'])) . "</span>";

    $aContentStrings['has_account_header_text'] = isset($aContentKeys['has-account-header-text'])
        ? $aContentKeys['has-account-header-text']
        : "<div class='header'>" . $oMarketComponent->translate("Please enter your %s account information", array($oMarketComponent->aBranding['service'])) . "</div>";

    $aContentStrings['login_field_label'] = isset($aContentKeys['login-field-label'])
        ? $aContentKeys['login-field-label']
        : $oMarketComponent->translate("%s Username", array($oMarketComponent->aBranding['service']));

    $aContentStrings['password_field_label'] = isset($aContentKeys['password-field-label'])
        ? $aContentKeys['password-field-label']
        : $oMarketComponent->translate('Password');

    $aContentStrings['market_terms_field_label'] = isset($aContentKeys['market-terms-field-label'])
        ? vsprintf($aContentKeys['market-terms-field-label'], array($marketTermsLink, $marketPrivacyLink))
        : $oMarketComponent->translate("I accept the %s <a target='_blank' href='%s'>terms and conditions</a> and <a target='_blank' href='%s'>data privacy policy</a>.", array($oMarketComponent->aBranding['name'], $marketTermsLink, $marketPrivacyLink));

    $aContentStrings['market_terms_field_invalid_message'] = isset($aContentKeys['market-terms-field-invalid-message'])
        ? $aContentKeys['market-terms-field-invalid-message']
        : $oMarketComponent->translate("Please agree with %s terms and conditions and data privacy policy", array($oMarketComponent->aBranding['name']));

    $aContentStrings['no_account_header_text'] = isset($aContentKeys['no-account-header-text'])
        ? $aContentKeys['no-account-header-text']
        : "<div class='header'>" . $oMarketComponent->translate("Create a new %s account", array($oMarketComponent->aBranding['service'])) . "</div>";

    $aContentStrings['signup_email_field_label'] = isset($aContentKeys['signup-email-field-label'])
        ? $aContentKeys['signup-email-field-label']
        : $oMarketComponent->translate("Email");

    $aContentStrings['signup_username_field_label'] = isset($aContentKeys['signup-username-field-label'])
        ? $aContentKeys['signup-username-field-label']
        : $oMarketComponent->translate("Desired %s username", array($oMarketComponent->aBranding['service']));

    $aContentStrings['signup_username_not_available_message'] = isset($aContentKeys['signup-username-not-available-message'])
        ? $aContentKeys['signup-username-not-available-message']
        : $oMarketComponent->translate("This %s username is not available", array($oMarketComponent->aBranding['service']));

    $aContentStrings['signup_password_field_label'] = isset($aContentKeys['signup-password-field-label'])
        ? $aContentKeys['signup-password-field-label']
        : $oMarketComponent->translate("Password");

    $aContentStrings['signup_password_confirm_field_label'] = isset($aContentKeys['signup-password-confirm-field-label'])
        ? $aContentKeys['signup-password-confirm-field-label']
        : $oMarketComponent->translate("Re-enter password");

    $aContentStrings['signup_password_field_mismatch_message'] = isset($aContentKeys['signup-password-field-mismatch-message'])
        ? $aContentKeys['signup-password-field-mismatch-message']
        : $oMarketComponent->translate("The given passwords do not match");

    $aContentStrings['signup_captcha_reload_text'] = isset($aContentKeys['signup-captcha-reload-text'])
        ? $aContentKeys['signup-captcha-reload-text']
        : "<a href='#' id='captcha-reload'>" . $oMarketComponent->translate("Try a different image") . "</a>";

    $aContentStrings['signup_captcha_field_label'] = isset($aContentKeys['signup-captcha-field-label'])
        ? $aContentKeys['signup-captcha-field-label']
        : $oMarketComponent->translate("Type the code shown below");

    $aContentStrings['signup_captcha_field_required_message'] = isset($aContentKeys['signup-captcha-field-required-message'])
        ? $aContentKeys['signup-captcha-field-required-message']
        : $oMarketComponent->translate("Please type the code shown");

    $aContentStrings['signup_captcha_field_mismatch_message'] = isset($aContentKeys['signup-captcha-field-mismatch-message'])
                ? $aContentKeys['signup-captcha-field-mismatch-message']
                : $oMarketComponent->translate("Enter the word as it is shown in the image");

    $aContentStrings['signup_openx_terms_field_label'] = isset($aContentKeys['signup-openx-terms-field-label'])
        ? vsprintf($aContentKeys['signup-openx-terms-field-label'], array($openXTermsLink, $openXPrivacyLink))
        : $oMarketComponent->translate("I accept the OpenX <a target='_blank' href='%s'>terms and conditions</a> and <a target='_blank' href='%s'>data privacy policy</a>.", array($openXTermsLink, $openXPrivacyLink));

    $aContentStrings['signup_openx_terms_field_invalid_message'] = isset($aContentKeys['signup-openx-terms-field-invalid-message'])
        ? $aContentKeys['signup-openx-terms-field-invalid-message']
        : $oMarketComponent->translate("Please agree with the OpenX terms and conditions and data privacy policy");

    $aContentStrings['submit_field_label'] = isset($aContentKeys['submit-field-label'])
        ? $aContentKeys['submit-field-label']
        : $oMarketComponent->translate("Submit");

    $aContentStrings['tracker_iframe'] = isset($aContentKeys['tracker-iframe'])
        ? $aContentKeys['tracker-iframe']
        : '';

    $aContentStrings['error_message']['701'] = isset($aContentKeys['error-701-message'])
        ? $aContentKeys['error-701-message']
        : "<div>" . $oMarketComponent->translate("Invalid user name or password.") . "</div>
            <ul>
              <li>" . $oMarketComponent->translate("Please check that the OpenX User name and password are correct.") . "</li>
              <li>" . $oMarketComponent->translate("If you have recently signed up for a new %s Account, make sure you have gone into your email and activated your %s Account.", array($oMarketComponent->aBranding['service'], $oMarketComponent->aBranding['service'])) . "</li>
            </ul>";

    $aContentStrings['error_message']['702'] = isset($aContentKeys['error-702-message'])
        ? $aContentKeys['error-702-message']
        : $aContentStrings['error_message']['701']; //701,702 reuse the message

    $aContentStrings['error_message']['703'] = isset($aContentKeys['error-703-message'])
        ? $aContentKeys['error-703-message']
        : $oMarketComponent->translate("There is already an %s account registered with the given email address.", array($oMarketComponent->aBranding['service'])) . ' ' .
          $oMarketComponent->translate("To create a new %s account please use a different email address", array($oMarketComponent->aBranding['service']));

    $aContentStrings['error_message']['901'] = isset($aContentKeys['error-901-message'])
        ? vsprintf($aContentKeys['error-901-message'], array($publisherSupportEmail))
        : $oMarketComponent->translate("This Ad Server is already associated with OpenX Market through a different %s account (Code 901).", array($oMarketComponent->aBranding['service'])) . "<br />" .
          $oMarketComponent->translate("Please contact <a href='mailto:%s'>%s publisher support</a> if you need further assistance.", array($publisherSupportEmail, $oMarketComponent->aBranding['name']));

    $aContentStrings['error_message']['902'] = isset($aContentKeys['error-902-message'])
        ? vsprintf($aContentKeys['error-902-message'], array($publisherSupportEmail))
        : $oMarketComponent->translate("This %s account is already associated with %s through a different OpenX Ad Server (Code 902).", array($oMarketComponent->aBranding['service'], $oMarketComponent->aBranding['name'])) . "<br />" . 
          $oMarketComponent->translate("Please contact <a href='mailto:%s'>%s publisher support</a> if you need further assistance.", array($publisherSupportEmail, $oMarketComponent->aBranding['name']));
  
    $aContentStrings['error_message']['912'] = isset($aContentKeys['error-912-message'])
        ? vsprintf($aContentKeys['error-912-message'], array($publisherSupportEmail))
        : $oMarketComponent->translate("An error occured while creating your %s account (Code 912).", array($oMarketComponent->aBranding['service'])) . "<br />" . 
          $oMarketComponent->translate("Please try again in couple of minutes.") . 
          $oMarketComponent->translate("If the problem persists, please contact <a href='mailto:%s'>%s publisher support</a> for assistance.", array($publisherSupportEmail, $oMarketComponent->aBranding['name']));

    $aContentStrings['error_message']['0'] = isset($aContentKeys['error-0-message'])
        ? $aContentKeys['error-0-message']
        : $oMarketComponent->translate("A generic error occurred while associating your %s account (Code 0: %s)", array($oMarketComponent->aBranding['service'])) . "<br />" .//%s needs to replaced with exc message
          $oMarketComponent->translate("The problem may be caused by an improper configuration of your OpenX Ad Server or your web server or by the lack of a required PHP extension.") . "<br />" .
          $oMarketComponent->translate("If the problem persists, please contact <a href='mailto:%s'>%s publisher support</a> for assistance.", array($publisherSupportEmail, $oMarketComponent->aBranding['name']));

    $aContentStrings['error_message']['unknown'] = isset($aContentKeys['error-unknown-message'])
        ? $aContentKeys['error-unknown-message']
        : $oMarketComponent->translate("An error occured while associating your %s account (Code %s).", array($oMarketComponent->aBranding['service'])) . "<br />" . //%s needs to be replaced with error.code
          $oMarketComponent->translate("Please try again in couple of minutes.") . 
          $oMarketComponent->translate("If the problem persists, please contact <a href='mailto:%s'>%s publisher support</a> for assistance.", array($publisherSupportEmail, $oMarketComponent->aBranding['name']));

    // PEAR XML-RPC errors
    $aXmlRpcPearErrors = getXmlRpcPearErrorsCodes();
    foreach ($aXmlRpcPearErrors as $errnum) {
        $aContentStrings['error_message'][$errnum] = isset($aContentKeys['error-generic-xml-rpc-message'])
            ? $aContentKeys['error-generic-xml-rpc-message']
            : $oMarketComponent->translate("An error occurred while associating your %s account (Code %s: %s)", array($oMarketComponent->aBranding['service'])) . "<br />" . //%s needs to replaced with code and exc message
              $oMarketComponent->translate("The problem may be caused by an improper configuration of your OpenX Ad Server or your web server or by the lack of a required PHP extension.") . "<br />" .
              $oMarketComponent->translate("If the problem persists, please contact <a href='mailto:%s'>%s publisher support</a> for assistance.", array($publisherSupportEmail, $oMarketComponent->aBranding['name']));
    }

    return $aContentStrings;
}


function getErrorMessage($oMarketComponent, $error)
{
    $aStrings = getTranslationLabels($oMarketComponent);
    $errorKey = ''.$error['code'].'';
    $publisherSupportEmail = $oMarketComponent->aBranding['links']['publisherSupportEmail'];

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
function oxMarketAutoRegister(&$oMarketComponent)
{ 
    // auto register if Hosted
    $oUser = OA_Permission::getCurrentUser();
    $linkingResult = $oMarketComponent->linkHostedAccounts(
                                            $oUser->aUser['user_id'], 
                                            $oUser->aAccount['account_id']);
    if ($linkingResult !== true) {
        // Auto register based on install data
        try {
            require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/Dal/Installer.php';
            $linkingResult = OX_oxMarket_Dal_Installer::autoRegisterMarketPlugin($oMarketComponent->getPublisherConsoleApiClient());
        } catch (Plugins_admin_oxMarket_PublisherConsoleClientException $exc) {
            OA::debug('Error during autoRegisterMarketPlugin in market-signup.php: ('.$exc->getCode().')'.$exc->getMessage());
            $linkingResult = false;
        }
    }
    if ($linkingResult === true) {
        // perform activation actions
        $oMarketComponent->removeRegisterNotification();
        $oMarketComponent->scheduleEarnMoreNotification();
        OX_Admin_Redirect::redirect("plugins/oxMarket/market-confirm.php");
        exit;
    }
}
