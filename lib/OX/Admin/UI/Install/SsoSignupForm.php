<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once 'BaseForm.php';

/**
 * @package OX_Admin_UI
 * @subpackage Install
 * @author Bernard Lange <bernard@openx.org> 
 */
class OX_Admin_UI_Install_SsoSignupForm 
    extends OX_Admin_UI_Install_BaseForm
{
    private $captchaUrl;
    private $captchaRandom;
    

    /**
     * Builds SSO registration form.
     * @param OX_Translation $oTranslation  instance
     * @param string $captchaUrl url for captcha to be used on form
     * @param string $captchaRandom captcha parameter that should saved in hidden
     * @param $oMarketClient OX_Dal_Market_RegistrationClient
     * @param $platformHash string 
     */
    public function __construct($oTranslation, $action, $captchaUrl, $captchaRandom, $oMarketClient, $platformHash)
    {
        parent::__construct('install-register-form', 'POST', $_SERVER['SCRIPT_NAME'], null, $oTranslation);
        $this->captchaUrl = $captchaUrl;
        $this->captchaRandom = $captchaRandom;
        $this->oMarketClient = $oMarketClient;
        
        
        $this->addElement('hidden', 'action', $action);        

        $this->buildSignupSection($captchaUrl, $captchaRandom, $platformHash);
        
        $this->addElement('controls', 'form-controls');
        $this->addElement('submit', 'signup', $GLOBALS['strBtnCreateAccountAndContinue']);          
    }


    protected function buildSignupSection($captchaUrl, $captchaRandom, $platformHash)
    {
        //build form
        $captchaUrl = $this->buildCaptchaUrl($captchaUrl, $captchaRandom, $platformHash);
        $userNameMaxLenght = 26;
        $this->addElement('hidden', 'captchaRandom', $captchaRandom);
        $this->addElement('hidden', 'platformHash', $platformHash);
    
        $this->addElement('header', 'h_account', '');
        //existing account part
        $usernameGroup[] = $this->createElement('text', 's_username', "", array('class' => 'medium', 'maxlength' => $userNameMaxLenght));
        $usernameGroup[] = $this->createElement('html', 's_username_check_indicator', '<span class="hide" id="user-check-indicator">
                                    <span class="available-int">'.$GLOBALS['strStatusAvailable'].'</span>
                                    <span class="unavailable-int">'.$GLOBALS['strStatusNotAvailable'].'</span>
                                    <span class="checking-int">'.$GLOBALS['strStatusChecking'].'</span>
                                    </span>');
        $this->addGroup ($usernameGroup, 'g_username', $GLOBALS['strOpenXUsername'], array("") );
        $this->addElement('password', 's_password', $GLOBALS['strPassword'],
            array('class' => 'medium'));
        $this->addElement('password', 's_confirm_password', $GLOBALS['strPasswordRepeat'],
            array('class' => 'medium'));
        $this->addElement('text', 's_email', $GLOBALS['strEMail'], array('class' => 'medium'));
        
        $captchaGroup[] = $this->createElement('html', 's_captcha_image', 
            "<div class='captchaContainer panel-plain'><img id='captcha-image' class='captchaImage' src='$captchaUrl' alt='Captcha Image' />");
        $captchaGroup[] = $this->createElement('text', 's_captcha', '', array('class' => 'captchaText'));
        $captchaGroup[] = $this->createElement('html', 's_captcha_reload',
            "<a class='inlineIcon iconRefresh captchaReload' href='#' id='captcha-reload' title='".$GLOBALS['strCaptchaReload']."'>&nbsp;</a>
            <span class='note'>".$GLOBALS['strCaptchaLettersCaseInsensitive']."</span>
            <div class='topleft'></div>
            <div class='topright'></div>
            <div class='bottomleft'></div>
            <div class='bottomright'></div>
          </div>");
        $this->addGroup ($captchaGroup, 'g_captcha', $GLOBALS['strCaptcha'], array("<br>", "") );
        

        $termsGroup[] = $this->createElement('checkbox', 'updates_signup', null, $GLOBALS['strSignupUpdates']);
        $this->addGroup ($termsGroup, 'g_terms', null, array("<br>") );
       
        //Form validation rules
        $this->addRequiredRule('s_email', $GLOBALS['strEMail']);
        $this->addRule('s_email', $GLOBALS['strEmailField'], 'email');
          //user name rules
        $sgUserNameRequired = $this->oTranslation->translate($GLOBALS['strXRequiredField'],
            array($GLOBALS['strOpenXUsername']));
        $userNameRequiredRule = array($sgUserNameRequired, 'required');
        $this->registerRule('usernamecheck', 'callback', 'validateUserNameUnique', $this);
        $userNameNotUnique = array($GLOBALS['strSSOUsernameNotAvailable'], 'usernamecheck');
        
        $userNameLength = array($this->oTranslation->translate($GLOBALS['strMaxLengthField'], 
            array($userNameMaxLenght)), 'maxlength', $userNameMaxLenght);
        $this->addGroupRule('g_username',
            array('s_username' => array(
                $userNameRequiredRule,
                $userNameLength, 
                $userNameNotUnique)
        ));
        
        $this->addRequiredRule('s_password', $GLOBALS['strPassword']);
        $this->addRequiredRule('s_confirm_password', $GLOBALS['strPasswordRepeat']);
        $this->addRule(array('s_confirm_password', 's_password'),
            $GLOBALS['strPasswordMismatch'] , 'compare', 'eq');
            
            
            
        $captchaRequiredRule = array($GLOBALS['strCaptchaRequired'], 'required');
        $this->addGroupRule('g_captcha',
            array(
                's_captcha' => array($captchaRequiredRule)
            ));
    }
    
    
    protected function buildCaptchaUrl($captchaUrl, $random, $platformHash)
    {
        $captchaUrl .= "?ph=$platformHash";
        $captchaUrl .= "&amp;t=$random";
    
        return $captchaUrl;
    }    
    
    public function validateUserNameUnique($userName)
    {
        $result = true; //allow by default, if we cannot validate allow username,
                        //should fail anyway on linkOXP
        try {
            $result =  $this->oMarketClient->isSsoUserNameAvailable($userName);
        }
        catch (Exception $exc) { //ignore would fail on API call anyway
        }
    
        return $result;
    }
    
    
    /**
     * Sets new captchaRandom value in the form, also resets the previously entered
     * value in the captcha field.
     *
     * @param string $captchaRandom
     */
    public function updateCaptcha($captchaRandom)
    {
        //if validation fails we need to discard old captcha submitted by user and
        //use the newly generated captcha random
        $captchaHidden = $this->getElement('captchaRandom');
    
        if ($captchaHidden->getValue() != $captchaRandom) {
            $captchaHidden->setValue($captchaRandom);
        }
        
        //reset captcha text as well, since a new one is generated on reload
        $group = $this->getElement('g_captcha');
        $group->setValue(array('s_captcha' => ''));
    }
    
    
    public function populateAccountData()
    {
        $aFields = $this->exportValues();
        $aAccount = array();
        $aAccount['username'] = $aFields['s_username'];
        $aAccount['password'] = $aFields['s_password'];
        $aAccount['email'] = $aFields['s_email'];
        $aAccount['captchaRandom'] = $aFields['captchaRandom']; 
        $aAccount['captcha'] = $aFields['s_captcha'];
        $aAccount['platformHash'] = $aFields['platformHash'];
        $aAccount['updates_signup'] = $aFields['updates_signup'];
        
        return $aAccount;
    }
}

?>