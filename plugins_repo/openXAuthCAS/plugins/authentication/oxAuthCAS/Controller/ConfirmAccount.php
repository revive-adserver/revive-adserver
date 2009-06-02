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

require_once dirname(__FILE__) . '/../Central/Cas.php';
require_once dirname(__FILE__) .'/SsoController.php';
/**
 * A very simple controller for sso-accounts confirmation page.
 *
 * Its a starting point for farther refactorization. Once we will decide
 * to use full blown framework system with some controllers it should
 * be relatively easily to migrate this class.
 *
 */
class OA_Controller_SSO_ConfirmAccount
    extends OA_Controller_SSO_SsoController
{
    /**
     * actions specific variables
     */
    var $ssoAccountId;
    var $doUsers;
    var $urlConfirm = "sso-confirm.php?id=%d&action=%s&email=%s";

    /**
     * Messages
     */
    var $msgErrorNoMatchingUser = 'Error: There is no matching user. Check if your link is correct or contact your OpenX administrator.';
    var $msgErrorPrefix = 'Error: ';
    var $msgErrorGeneralUpdateError = 'Error while updating an account. Please try again.';
    var $msgErrorWrongCredentials = 'Your username or password are not correct. Please try again.';
    var $msgErrorGeneralAccountCreateError = 'Could not create your new OpenX account. Please try again.';
    var $msgErrorWrongParameters = 'Wrong parameters';


    function initModel()
    {
        $this->aModel = array(
            'hideCreate' => true,
            'hideLink' => true,
        );
    }
    
    
    function getRegisteredActions()
    {
        return array(
            'link',
            'create',
            'check',
            'display'
        );        
    }    


    /**
     * Default action.
     *
     */
    function displayAction()
    {
        if($this->verify()) {
            return $this->loadDoUsers();
        }
        return false;
    }
    

    /**
     * Action "link". Links existing SSO account with users account.
     */
    function linkAction()
    {
        if (!$this->verify()) {
            return false;
        }
        if (!$this->loadDoUsers()) {
            return false;
        }
        $this->setModelProperty('hideLink', false);

        if (empty($this->request['ssoexistinguser']) || empty($this->request['ssoexistingpassword']))
        {
            $this->addError($this->msgErrorWrongParameters);
            return false;
        }

        $ssoLinkAccountId = $this->getSsoAccountIdByUsernamePassword();
        if (!$ssoLinkAccountId) {
        	return false;
        }

        // @todo - add a database constraint on sso_user_id
        if ($userId = $this->checkIfSsoUserExists($ssoLinkAccountId)) {
            if ($this->useExistingAccount($userId, $this->doUsers->user_id)) {
                $this->redirectToConfirmPageAndExit('linked', $userId);
            }
        }

        $accountEmail = $this->getSsoAccountEmail($ssoLinkAccountId);
        if ($accountEmail)
        {
            $this->doUsers->sso_user_id = $ssoLinkAccountId;
            $this->doUsers->email_address = $accountEmail;
            $ret = $this->doUsers->update();
            if ($ret !== false && !$this->isError($ret)) {
                $this->oCentral->rejectPartialAccount($this->ssoAccountId, $this->request['vh']);
                $this->redirectToConfirmPageAndExit('linked', $this->doUsers->user_id);
            } else {
                $this->addError($this->msgErrorGeneralUpdateError);
            }
        } else {
            $this->addError($this->msgErrorWrongCredentials);
        }
        return false;
    }


    /**
     * Action "create". Creates a new SSO account
     *
     */
    function createAction()
    {
        if (!$this->verify()) {
            return false;
        }
        if (!$this->loadDoUsers()) {
            return false;
        }
        $this->setModelProperty('hideCreate', false);
        if (!empty($this->request['ssonewuser']) && !empty($this->request['ssonewpassword']))
        {
            $ret = $this->oCentral->completePartialAccount($this->ssoAccountId, $this->request['ssonewuser'],
                md5($this->request['ssonewpassword']), $this->request['vh']);
            if (!$this->isError($ret))
            {
                $this->redirectToConfirmPageAndExit('created', $this->doUsers->user_id);
            } else {
                $this->addError($ret);
            }
        }
        $this->setModelProperty('errorCreateFailed', $this->oPlugin->translate($this->msgErrorGeneralAccountCreateError));
        return false;
    }

    
    /**
     * Action "check". Checks if username is available
     *
     */
    function checkAction()
    {
        // @todo - add validation here before passing username to xml-rpc call
        // waiting here for a product decision on minimum length of username
        $ret = false;
        if ($this->request['proposedusername']) {
            $ret = $this->oCentral->isUserNameAvailable($this->request['proposedusername']);
        }
        echo ($ret && !$this->isError($ret)) ? 'available': 'notavailable';
        exit();
    }
    
    
    function redirectToConfirmPageAndExit($action, $userId)
    {
        $doUsers = OA_Dal::staticGetDO('users', $userId);
        $url = sprintf($this->urlConfirm, $userId, $action, $doUsers->email_address);
        header ("Location: " . $url);
        exit();
    }
}

?>
