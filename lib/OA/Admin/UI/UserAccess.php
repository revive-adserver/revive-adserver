<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

/**
 * Common UserAccess related UI methods
 *
 */
class OA_Admin_UI_UserAccess
{
    var $accountId;
    var $userid;
    var $request = array();
    var $pagePrefix; // admin/agency/advertiser/affiliate
    var $aErrors = array();
    var $oPlugin;
    var $callbackNavigation;
    
    function init()
    {
        $this->initRequest();
        $this->oPlugin = OA_Auth::staticGetAuthPlugin();
        if (empty($this->userid)) {
            $this->userid = $this->oPlugin->getMatchingUserId(
                $this->request['email_address'], $this->request['login']);
        }
    }
    
    function process()
    {
        if (!empty($this->request['submit'])) {
            if ($this->userid) {
                // @todo shouldn't we always validate the user?
                $this->aErrors = $this->oPlugin->validateUsersData(
                    $this->request['login'], $this->request['passwd'],
                    $this->request['email_address']);
            }
            if (empty($this->aErrors)) {
                $this->request['userid'] = $this->oPlugin->saveUser(
                    $this->request['login'], $this->request['passwd'],
                    $this->request['contact_name'],
                    $this->request['email_address'], $this->accountId);
                if ($this->request['userid']) {
                    OA_Admin_UI_UserAccess::linkUserToAccount(
                        $this->request['userid'], $this->accountId,
                        $this->permissions);
                    MAX_Admin_Redirect::redirect($this->pagePrefix . '-access.php');
                } else {
                    $aErrors = $this->oPlugin->getSignupErrors();
                }
            }
        }
        $this->display();
    }
    
    function display()
    {
        $this->processNavigation();
        
        require_once MAX_PATH . '/lib/OA/Admin/Template.php';

        $oTpl = new OA_Admin_Template($this->pagePrefix.'-user.html');
        $oTpl->assign('action', $this->pagePrefix.'-user.php');
        $oTpl->assign('backUrl', $this->pagePrefix.'-user-start.php');
        $oTpl->assign('method', 'POST');
        $oTpl->assign('aErrors', $this->aErrors);
        
        $this->oPlugin->setTemplateVariables($oTpl);
        
        // indicates whether the user exists
        // (otherwise, a new user will be created or invitation sent)
        $oTpl->assign('existingUser', !empty($this->userid));
        
        // indicates whether the form is in editing user properties mode
        // (linked from the "Permissions" link in the User Access table)
        $oTpl->assign('editMode', !$link);
        
        $doUsers = OA_Dal::staticGetDO('users', $this->userid);
        $userData = array();
        if ($doUsers) {
            $userData = $doUsers->toArray();
        } else {
            $userData['username'] = $this->request['login'];
            $userData['contact_name'] = $this->request['contact_name'];
            $userData['email_address'] = $this->request['email_address'];
        }
        
        $oTpl->assign('fields', array(
            array(
                'title'  => $strUserDetails,
                'fields' => $this->oPlugin->getUserDetailsFields($userData)
            )
         )
        );
        
        $aHiddenFields = OA_Admin_UI_UserAccess::getHiddenFields($userData, $link);
        $oTpl->assign('hiddenFields', $aHiddenFields);
        
        $oTpl->display();
        
        phpAds_PageFooter();
    }
    
    function initRequest()
    {
        $this->request = phpAds_registerGlobalUnslashed (
            'userid', 'login', 'passwd', 'link', 'contact_name',
            'email_address', 'permissions', 'submit'
        );
        $this->userid = $this->request['userid'];
    }
    
    function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }
    
    function setPagePrefix($pagePrefix)
    {
        $this->pagePrefix = $pagePrefix;
    }
    
    function setNavigationCallback($callback)
    {
        $this->callbackNavigation = $callback;
    }
    
    function processNavigation()
    {
        if (is_callable($this->callbackNavigation)) {
            call_user_func($this->callbackNavigation);
        }
    }
    
    /**
     * Assign common template variables
     *
     * @param Admin_Template $oTpl
     */
    function assignUserStartTemplateVariables(&$oTpl)
    {
        $oTpl->assign('method', 'GET');
        $oTpl->assign('strLinkUserHelp', $GLOBALS['strLinkUserHelp']);

        // Add variables required by the current authentication plugin
        $oPlugin = OA_Auth::staticGetAuthPlugin();
        $oPlugin->setTemplateVariables($oTpl);
    }

    /**
     * Returns hidden fields used in pages entity-user
     *
     * @param string $entityName
     * @param integer $entityId
     */
    function getHiddenFields($userData, $link, $entityName = null, $entityId = null)
    {
        $hiddenFields = array(
            array(
                'name' => 'submit',
                'value' => true
            ),
            array(
                'name' => 'login',
                'value' => $userData['username']
            ),
            array(
                'name'  => 'link',
                'value' => $link
            ),
        );
        if (!empty($userData['email_address'])) {
            $hiddenFields[] = array(
                'name'  => 'email_address',
                'value' => $userData['email_address']
            );
        }
        if (!empty($entityName)) {
            $hiddenFields[] = array(
                'name' => $entityName,
                'value' => $entityId
            );
        }
        return $hiddenFields;
    }

    /**
     * Unlinks user from account and if necessary deletes user account.
     * Sets apropriate message
     *
     * @param integer $accountId  Account ID
     * @param integer $userId  User ID
     */
    function unlinkUserFromAccount($accountId, $userId)
    {
        if (OA_Permission::isUserLinkedToAccount($accountId, $userId)) {
            $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
            $doAccount_user_assoc->account_id = $accountId;
            $doAccount_user_assoc->user_id = $userId;
            $doAccount_user_assoc->delete();
            OA_Session::setMessage($GLOBALS['strUserUnlinkedFromAccount']);

            $doUsers = OA_Dal::staticGetDO('users', $userId);
            // delete user account if he is not linked anymore to any account
            if ($doUsers->countLinkedAccounts() == 0) {
                $doUsers->delete();
                OA_Session::setMessage($GLOBALS['strUserWasDeleted']);
            } else {
                OA_Admin_UI_UserAccess::resetUserDefaultAccount($userId, $accountId);
            }
        } else {
            OA_Session::setMessage($GLOBALS['strUserNotLinkedWithAccount']);
        }
    }

    /**
     * Resets default user's account to one of the account's ids which is linked to him.
     *
     * @param integer $userId
     * @param integer $accountId
     */
    function resetUserDefaultAccount($userId, $accountId)
    {
        $linkedAccounts = OA_Permission::getLinkedAccounts(false, $userId);
        $doUsers = OA_Dal::staticGetDO('users', $userId);
        if ($doUsers->default_account_id == $accountId) {
            $doUsers->default_account_id = array_shift($linkedAccounts);
            $doUsers->update();
        }
    }

    /**
     * Returns number of users linked to account
     *
     * @param integer $accountId
     * @return integer
     */
    function countNumberOfUserLinkedToAccount($accountId)
    {
        $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_assoc->account_id = $accountId;
        return $doAccount_user_assoc->count();
    }

    /**
     * Links user with account and set apropriate messages.
     * Common method reused across user access pages
     *
     * @param integer $userId  User ID
     * @param integer $accountId  Account ID
     * @param array $permissions Array of permissions
     * @param array $aAllowedPermissions  Array of allowed permissions
     */
    function linkUserToAccount($userId, $accountId, $permissions, $aAllowedPermissions)
    {
        if (empty($userId)) {
            $message = sprintf($GLOBALS['strNoStatsForPeriod'], $login);
            OA_Session::setMessage($message);
        } else {
            if (!OA_Permission::isUserLinkedToAccount($accountId, $userId)) {
                // TODO - add below - , $userId, $accountId
                OA_Session::setMessage($GLOBALS['strUserLinkedToAccount']);
            } else {
                OA_Session::setMessage($GLOBALS['strUserAccountUpdated']);
            }
            OA_Permission::setAccountAccess($accountId, $userId);
            OA_Permission::storeUserAccountsPermissions($permissions, $accountId,
                $userId, $aAllowedPermissions);
        }
    }

}

?>
