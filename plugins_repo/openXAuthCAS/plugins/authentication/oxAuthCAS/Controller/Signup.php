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
$Id: ConfirmAccount.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

require_once dirname(__FILE__) . '/../Central/Cas.php';
require_once dirname(__FILE__) .'/SsoController.php';

// Agency Dll class
require_once MAX_PATH . '/lib/OA/Dll/Agency.php';


/**
 * A very simple controller for sso-accounts confirmation page.
 *
 * Its a starting point for farther refactorization. Once we will decide
 * to use full blown framework system with some controllers it should
 * be relatively easily to migrate this class.
 *
 */
class OA_Controller_SSO_Signup
    extends OA_Controller_SSO_SsoController
{
    /**
     * actions specific variables
     */
    var $isVerified = false;
    var $ssoAccountId;
    var $doUsers;
    var $urlConfirm = "sso-confirm.php?id=%d&action=%s&email=%s";

    /**
     * Messages
     */
    var $msgErrorNoMatchingUser = 'Error: There is no matching user. Check if your link is correct or contact your OpenX administrator.';
    var $msgErrorPrefix = 'Error: ';
    var $msgErrorGeneralUpdateError = 'Error while updating an account. Please try again.';
    var $msgErrorGeneralVerificationError = 'Error while verifying your email address. Please try again.';
    var $msgErrorWrongCredentials = 'Your username or password are not correct. Please try again.';
    var $msgErrorGeneralAccountCreateError = 'Could not create your new OpenX account. Please try again.';
    var $msgErrorWrongParameters = 'Wrong parameters';


    function initModel()
    {
    }

    
    function getRegisteredActions()
    {
        return array(
            'display',
            'signup',
            'signupConfirm'
        );        
    }      
    
    
    function displayAction()
    {
    }
    
    
    function signupAction()
    {
        var_dump($this->request);
        //For new users
        //1) SSO check verify username uniqueness
        
        //2) SSO check verify email address uniqueness
        
        //3) OXP check verify email uniqueness
        
        
        //For existing users
        //1) Verify username password
        
        //2) Verify email is the same as email registered for given credentials
        
        
        
        //create OXP account (which calls CAS and creates SSO account)
        $accountMode = $this->request['ssoAccountMode'];
        $userName = $accountMode == 'link' ? $this->request['ssoUsername']
            : $this->request['newSsoUsername'];
        $password = $accountMode == 'link' ? $this->request['ssoPassword']
            : $this->request['newSsoPassword'];
        
        $aFields = array(
            'agencyName' => $this->request['firstName']." ".$this->request['lastName'],
            'contactName' => $this->request['firstName']." ".$this->request['lastName'],
            'emailAddress'=> $this->request['email'],
            'userEmail' => $this->request['email'],
            'username' => $userName,
            'password' => $password,
            'language'=> 'en'
        );
        
        $this->createAgency($aFields);
                
        //TODO insert market plugin entries into DB
        //depends on OXPL-40 
        //call market plugin register by sso credentials method
    }
    
    
    function signupConfirmAction()
    {
        if (!$this->verify()) {
            return false;
        }
        if (!$this->loadDoUsers()) {
            return false;
        }
        
        //hash verified, user exists in db, complete
        $ret = $this->markEmailAsConfirmed($this->request['email'], $this->request['vh']);
        if ($ret !== false && !$this->isError($ret)) {
            //success
            $this->setModelProperty('ssoMessage', 'KUKU verified');       
        } 
        else {
            $this->addError($this->msgErrorGeneralVerificationError);
        }
        
    }
    
    
    function markEmailAsConfirmed($email, $verificationHash)
    {
        $ret = $this->oCentral->confirmEmail($verificationHash, $email);
        
        return $ret;
    }
    
    
    
    function createAgency($aFields)
    {
        $dllAgency = new OA_Dll_Agency();
        
        $oAgencyInfo = new OA_Dll_AgencyInfo();
        $oAgencyInfo->agencyName = $aFields['agencyName'];
        $oAgencyInfo->contactName = $aFields['contactName'];
        $oAgencyInfo->emailAddress = $aFields['emailAddress'];
        $oAgencyInfo->userEmail = $aFields['userEmail'];
        $oAgencyInfo->username = $aFields['username'];
        $oAgencyInfo->password = $aFields['password'];
        $oAgencyInfo->language = $aFields['language'];
        
        try {
            $this->becomeAdmin();
            $result = $dllAgency->modify($oAgencyInfo);
            $this->becomeNoone();
            
            //get any DLL or sso errors
            if (!$result) {
                $this->addError($dllAgency->getLastError());
            }
            $aSsoErrors = $this->oPlugin->getSignupErrors(); 
            if (count($aSsoErrors)) {
                 foreach ($aSsoErrors as $errorMessage) {
                 	$this->addError($errorMessage);
                 }
            }
        }
        catch (Exception $e) {
            $this->becomeNoone();
            throw $e;
        }
        
        var_dump($result);
    }
    
    
    /**
     * This is a hacking function to allow admin protected DLL calls to execute.
     * Uses bits and pieces from autologin function of OA_Upgrade_Login (which could
     * not be used in this context unfortunately.
     */
    function becomeAdmin()
    {
        $doUser = OA_Dal::factoryDO('users');

        $doAUA = OA_Dal::factoryDO('account_user_assoc');
        $doAUA->account_id = OA_Dal_ApplicationVariables::get('admin_account_id');
        $doUser->joinAdd($doAUA);

        $doUser->find();
        if ($doUser->fetch()) {
            $doUser->default_account_id = OA_Dal_ApplicationVariables::get('admin_account_id');
            $GLOBALS['session']['user'] = new OA_Permission_User($doUser, false);
        }
    }

    
    /**
     * Reverts action taken by becomeAdmin function. Clean up user object
     * from session['user'].
     * Destroys oxp session if any.
     *
     */
    function becomeNoone()
    {
        $GLOBALS['session']['user'] = null; 
        phpAds_SessionDataDestroy();
    }
}
?>