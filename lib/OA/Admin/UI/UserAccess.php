<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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

/**
 * Common UserAccess related UI methods
 *
 */
class OA_Admin_UI_UserAccess
{
    /**
     * Validates user login and password - required for linking new users
     *
     * @param string $login
     * @param string $password
     * @return array  Array containing error strings or empty
     *                array if no validation errors were found
     */
    function validateUsersData($login, $password)
    {
        $aErrors = OA_Admin_UI_UserAccess::validateUsersLogin($login);
        return array_merge($aErrors, OA_Admin_UI_UserAccess::validateUsersPassword($password));
    }
    
    /**
     * Validates user login - required for linking new users
     *
     * @param string $login
     * @return array  Array containing error strings or empty
     *                array if no validation errors were found
     */
    function validateUsersLogin($login)
    {
        $aErrormessage = array();
        if (empty($login)) {
            $aErrormessage[] = $GLOBALS['strInvalidUsername'];
        } elseif (OA_Permission::userNameExists($login)) {
            $aErrormessage[] = $GLOBALS['strDuplicateClientName'];
        }
        return $aErrormessage;
    }
    
    /**
     * Validates user password - required for linking new users
     *
     * @param string $password
     * @return array  Array containing error strings or empty
     *                array if no validation errors were found
     */
    function validateUsersPassword($password)
    {
        $aErrormessage = array();
        if (!strlen($password) || strstr("\\", $password)) {
            $aErrormessage[] = $GLOBALS['strInvalidPassword'];
        }
        return $aErrormessage;
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
        
        // TODOHOSTED: will need to know whether we're hosted or downloaded
        // Actually, it's probably a question if we're using SSO or not
        $SSO = false; 
        $oTpl->assign('sso', $SSO);
        
        if ($SSO) {
           $oTpl->assign('fields', array(
               array(
                   'fields'    => array(
                       array(
                           'name'      => 'email',
                           'label'     => $GLOBALS['strEmailToLink'],
                           'value'     => '',
                           'id'        => 'user-key'
                       )
                   )
               )
           ));
        }
        else
        {
           $oTpl->assign('fields', array(
               array(
                   'fields'    => array(
                       array(
                           'name'      => 'login',
                           'label'     => $GLOBALS['strUsernameToLink'],
                           'value'     => '',
                           'id'        => 'user-key'
                       ),
                   )
               ),
           ));
        }
    }
    
    /**
     * Set user details fields required by user access (edit) pages
     *
     * @param array $userData  Array containing users data (see users table)
     * @return array  Array formatted for use in template object as in user access pages
     */
    function getUserDetailsFields($userData)
    {
        // TODOHOSTED: will need to know whether we're hosted or downloaded
        // Actually, it's probably a question if we're using SSO or not
        $SSO = false; 
        $userExists = false; // TODO: determine if user already exists
        if ($SSO) {
           $userDetailsFields[] = array(
                          'name'      => 'email_address',
                          'label'     => $GLOBALS['strEMail'],
                          'value'     => 'test@test.com', // TODO: put e-mail here
                          'freezed'   => true
                    );
           $userDetailsFields[] = array(
                        'name'      => 'contact',
                        'label'     => $GLOBALS['strContactName'],
                        'value'     => $userData['contact']
                    );

           if ($userExists) {
              $userDetailsFields[] = array(
                           'type'      => 'custom',
                           'template'  => 'link',
                           'label'     => $GLOBALS['strPwdRecReset'],
                           'href'      => 'user-password-reset.php', // TODO: put the actual password resetting script here
                           'text'      => $GLOBALS['strPwdRecResetPwdThisUser']
                       );
           }
        }
        else {
           $userDetailsFields[] = array(
                           'name'      => 'login',
                           'label'     => $GLOBALS['strUsername'],
                           'value'     => $userData['username'],
                           'freezed'   => !empty($userData['user_id'])
                       );
           $userDetailsFields[] = array(
                           'name'      => 'passwd',
                           'label'     => $GLOBALS['strPassword'],
                           'type'      => 'password',
                           'value'     => '',
                           'hidden'   => !empty($userData['user_id'])
                       );
           $userDetailsFields[] = array(
                           'name'      => 'contact_name',
                           'label'     => $GLOBALS['strContactName'],
                           'value'     => $userData['contact_name'],
                       );
           $userDetailsFields[] = array(
                           'name'      => 'email_address',
                           'label'     => $GLOBALS['strEMail'],
                           'value'     => $userData['email_address']
                       );
        }
        return $userDetailsFields;
    }
    
    /**
     * Returns hidden fields used in pages entity-user
     *
     * @param string $entityName
     * @param integer $entityId
     */
    function getHiddenFields($login, $link, $entityName = null, $entityId = null)
    {
        $hiddenFields = array(
            array(
                'name' => 'submit',
                'value' => true
            ),
            array(
                'name' => 'login',
                'value' => $login
            ),
            array(
                'name'  => 'link',
                'value' => $link
            ),
            array(
                'name'  => 'new_user',
                'value' => !OA_Permission::userNameExists($login)
            )
        );
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
     * Method used in user access pages. Either creates new user if necessary or update existing one.
     *
     * @param string $login  User name
     * @param string $password  Password
     * @param string $contactName  Contact name
     * @param string $emailAddress  Email address
     * @param integer $accountId  a
     * @return integer  User ID or false on error
     */
    function saveUser($login, $password, $contactName, $emailAddress, $accountId)
    {
        $doUsers = OA_Dal::factoryDO('users');
        $userExists = $doUsers->fetchUserByUserName($login);
        $doUsers->contact_name = $contactName;
        $doUsers->email_address = $emailAddress;
        if ($userExists) {
            $doUsers->update();
            return $doUsers->user_id;
        } else {
            $doUsers->default_account_id = $accountId;
            $doUsers->password = md5($password);
            return $doUsers->insert();
        }
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
