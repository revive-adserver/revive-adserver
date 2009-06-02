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
require_once dirname(__FILE__) . '/BaseController.php';

/**
 * A very simple controller for sso related pages.
 *
 * Its a starting point for farther refactorization. Once we will decide
 * to use full blown framework system with some controllers it should
 * be relatively easily to migrate this class.
 *
 */
class OA_Controller_SSO_SsoController
    extends OA_Controller_SSO_BaseController
{
    var $oCentral;
    var $oPlugin;
    var $isVerified = false;


    function init()
    {
        parent::init();
        $this->oCentral = &new OA_Central_Cas();
        $this->oPlugin = OX_Component::factory('authentication', 'oxAuthCAS', 'oxAuthCAS');
    }
    

    /**
     * Verify users email and verification hash
     */
    function verify()
    {
        $this->ssoAccountId = $this->oCentral->checkEmail($this->request['vh'], $this->request['email']);
        if ($this->isError($this->ssoAccountId)) {
            $this->addError($this->ssoAccountId);
            $this->setVerified(false);
            return false;
        } else {
            $this->setVerified(true);
            return true;
        }
    }

    
    function validate()
    {
        if (empty($this->request['email']) || empty($this->request['vh'])) {
            $this->setModelProperty('errorNoMatchingAccount', true);
            return false;
        }
        return true;
    }
    

    function setVerified($isVerified)
    {
        if (!$isVerified) {
            $this->addError($this->msgErrorNoMatchingUser);
            $this->setModelProperty('errorNoMatchingAccount', true);
        }
        $this->isVerified = $isVerified;
    }

    
    /**
     * Relinks all accounts and permissions from partial account to existing account
     *
     * @param integer $existingUserId
     * @param integer $partialUserId
     * @return boolean
     */
    function useExistingAccount($existingUserId, $partialUserId)
    {
        $doUsers = OA_Dal::factoryDO('users');
        if (!$doUsers->relinkAccounts($existingUserId, $partialUserId)) {
            return false;
        }
        $doUsers = OA_Dal::staticGetDO('users', $partialUserId);
        if (!$doUsers) {
            return false;
        }
        return $doUsers->delete();
    }


    function checkIfSsoUserExists($ssoAccountId)
    {
        $doUsersCheck = OA_Dal::factoryDO('users');
        $doUsersCheck->sso_user_id = $ssoAccountId;
        if ($doUsersCheck->find(true)) {
            return $doUsersCheck->user_id;
        }
        return false;
    }

    
    function &getCasPlugin()
    {
        return $this->oPlugin;
    }
    

    function getSsoAccountIdByUsernamePassword()
    {
        $md5Password = md5($this->request['ssoexistingpassword']);
        $ret = $this->oCentral->getAccountIdByUsernamePassword(
            $this->request['ssoexistinguser'], $md5Password);
        if ($this->isError($ret)) {
            $this->addError($ret);
            return false;
        }
        return $ret;
    }
    

    function getSsoAccountEmail($ssoAccountId)
    {
        $accountEmail = false;
        if ($ssoAccountId && !$this->isError($ssoAccountId)) {
            $accountEmail = $this->oCentral->getAccountEmail($ssoAccountId);
        }
        if ($this->isError($accountEmail)) {
            $accountEmail = false;
        }
        return $accountEmail;
    }
    
    
    function loadDoUsers()
    {
        $this->doUsers = OA_Dal::factoryDO('users');
        if ($this->doUsers->loadByProperty('email_address', $this->request['email'])) {
            $this->setModelProperty('userName', $this->doUsers->contact_name);
            return true;
        } else {
            $this->setVerified(false);
            return false;
        }
    }
    
}

?>