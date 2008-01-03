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
    function assignUserStartTemplateVariables(&$oTpl)
    {
        $oTpl->assign('method', 'GET');
        
        // TODOHOSTED: will need to know whether we're hosted or downloaded
        $HOSTED = false; 
        $oTpl->assign('hosted', $HOSTED);
        
        if ($HOSTED) {
           $oTpl->assign('fields', array(
               array(
                   'title'     => "E-mail",
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
                   'title'     => $strUsername,
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
        
        if ($HOSTED) {
           $userDetailsFields[] = array(
                          'name'      => 'email_address',
                          'label'     => $GLOBALS['strEMail'],
                          'value'     => 'test@test.com', // TODO: put e-mail here
                          'freezed'   => true
                      );
        
           if ($existingUser) {
              $userDetailsFields[] = array(
                           'type'      => 'custom',
                           'template'  => 'link',
                           'label'     => $GLOBALS['strPwdRecReset'],
                           'href'      => 'user-password-reset.php', // TODO: put the actual password resetting script here
                           'text'      => $GLOBALS['strPwdRecResetPwdThisUser']
                       );
           }
           else {
              $userDetailsFields[] = array(
                           'name'      => 'contact',
                           'label'     => $GLOBALS['strContactName'],
                           'value'     => $userData['contact']
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
            OA_Session::setMessage('User was unlinked from account');
            
            $doUsers = OA_Dal::staticGetDO('users', $userId);
            // delete user account if he is not linked anymore to any account
            if ($doUsers->countLinkedAccounts() == 0) {
                $doUsers->delete();
                OA_Session::setMessage('User was deleted');
            }
        } else {
            OA_Session::setMessage('Such user is not linked with account');
        }
    }
    
    /**
     * Method used in user access pages. Either creates new user if necessary or update existing one.
     *
     * @param string $login  User name
     * @param string $password  Password
     * @param string $contactName  Contact name
     * @param string $emailAddress  Email address
     * @return integer  User ID or false on error
     */
    function saveUser($login, $password, $contactName, $emailAddress)
    {
        $doUsers = OA_Dal::factoryDO('users');
        $userExists = $doUsers->fetchUserByUserName($login);
        $doUsers->contact_name = $contactName;
        $doUsers->email_address = $emailAddress;
        if ($userExists) {
            $doUsers->update();
            return $doUsers->user_id;
        } else {
            $doUsers->password = md5($passwd);
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
            OA_Session::setMessage('Error while creating user:' . $login);
        } else {
            if (!OA_Permission::isUserLinkedToAccount($accountId, $userId)) {
                OA_Session::setMessage('User was linked with account');
            } else {
                OA_Session::setMessage('User account updated');
            }
            OA_Permission::setAccountAccess($accountId, $userId);
            OA_Permission::storeUserAccountsPermissions($permissions, $accountId,
                $userId, $aAllowedPermissions);
        }
    }
    
}

?>