<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Session.php';

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
    var $callbackHeaderNavigation;
    var $callbackFooterNavigation;
    var $aAllowedPermissions = array();
    var $aPermissions = array();
    var $aHiddenFields = array();
    var $redirectUrl;
    var $backUrl;

    function init()
    {
        $this->initRequest();
        $this->oPlugin = OA_Auth::staticGetAuthPlugin();
        if (empty($this->userid)) {
            $this->userid = $this->oPlugin->getMatchingUserId(
                $this->request['email_address'], $this->request['login']);
        }
    }

    function initRequest()
    {
        $this->request = phpAds_registerGlobalUnslashed (
            'userid', 'login', 'passwd', 'passwd2', 'link', 'contact_name',
            'email_address', 'permissions', 'submit', 'language', 'token'
        );
        // Sanitize userid
        if (!empty($this->request['userid'])) {
            $this->request['userid'] = (int)$this->request['userid'];
        }
        $this->userid = $this->request['userid'];
        if (isset($this->request['permissions'])) {
            $this->aPermissions = $this->request['permissions'];
        }
    }

    function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

    function setPagePrefix($pagePrefix)
    {
        $this->pagePrefix = $pagePrefix;
    }

    function setNavigationHeaderCallback($callback)
    {
        $this->callbackHeaderNavigation = $callback;
    }

    function setNavigationFooterCallback($callback)
    {
        $this->callbackFooterNavigation = $callback;
    }

    function process()
    {
        if (!empty($this->request['submit'])) {
            if (preg_match('#[\x00-\x1F\x7F]#', $this->request['login'])) {
                $this->aErrors = array($GLOBALS['strInvalidUsername']);
            } else {
                $this->aErrors = $this->oPlugin->validateUsersData($this->request);
            }
            if (empty($this->aErrors)) {
                $this->userid = $this->oPlugin->saveUser(
                    $this->userid, $this->request['login'], $this->request['passwd'],
                    $this->request['contact_name'], $this->request['email_address'],
                    $this->request['language'], $this->accountId);
                if ($this->userid) {
                    OA_Admin_UI_UserAccess::linkUserToAccount(
                        $this->userid, $this->accountId, $this->aPermissions,
                        $this->aAllowedPermissions);
                    OX_Admin_Redirect::redirect($this->getRedirectUrl());
                } else {
                    $this->aErrors = $this->oPlugin->getSignupErrors();
                }
            }
        }
        $this->display();
    }

    function display()
    {
        $this->_processHeaderNavigation();

        require_once MAX_PATH . '/lib/OA/Admin/Template.php';

        $oTpl = new OA_Admin_Template($this->pagePrefix.'-user.html');
        $oTpl->assign('action', $this->pagePrefix.'-user.php');
        $oTpl->assign('backUrl', $this->backUrl);
        $oTpl->assign('method', 'POST');
        $oTpl->assign('aErrors', $this->aErrors);

        $this->oPlugin->setTemplateVariables($oTpl);

        $oTpl->assign('existingUser', !empty($this->userid));
        $oTpl->assign('showLinkButton', !empty($this->request['link']));

        $doUsers = OA_Dal::staticGetDO('users', $this->userid);
        $userData = array();
        if ($doUsers) {
            $userData = $doUsers->toArray();
        } else {
            $userData['username'] = $this->request['login'];
            $userData['contact_name'] = $this->request['contact_name'];
            $userData['email_address'] = $this->request['email_address'];
            $userData['language'] = $this->request['language'];
        }
        $userData['userid'] = $this->userid;

        $aTplFields = array(
            array(
                'title'     => $GLOBALS['strUserDetails'],
                'fields'    => $this->oPlugin->getUserDetailsFields($userData,
                                   $this->request['link'])
            )
        );
        $aPermissionsFields = $this->_builPermissionFields();
        if (!empty($aPermissionsFields)) {
            $aTplFields[] = array(
                'title'     => $GLOBALS['strPermissions'],
                'fields'    => $aPermissionsFields
            );
        }
        $oTpl->assign('fields', $aTplFields);

        $aHiddenFields = $this->_getHiddenFields($userData, $this->request['link'], $this->aHiddenFields);
        $oTpl->assign('hiddenFields', $aHiddenFields);

        $oTpl->display();

        $this->_processFooterNavigation();

        phpAds_PageFooter();
    }

    function _builPermissionFields()
    {
        $aPermissionsFields = array();
        $c = 0;
        foreach ($this->aAllowedPermissions as $permissionId => $aPermission) {
            if (is_array($aPermission)) {
                list($permissionName, $indent, $onClick) = $aPermission;
            } else {
                $permissionName = $aPermission;
                $indent = false;
                $onClick = false;
            }
            $aPermissionsFields[$c] = array(
                        'name'      => 'permissions[]',
                        'label'     => $permissionName,
                        'type'      => 'checkbox',
                        'value'     => $permissionId,
                        'checked'   => OA_Permission::hasPermission($permissionId,
                            $this->accountId, $this->userid),
                        'hidden'    => $isTrafficker,
                        'break'     => false,
                        'id'        => 'permissions_'.$permissionId,
                        'indent'     => $indent,
                    );
            if ($onClick) {
                $aPermissionsFields[$c]['onclick'] = $onClick;
            }
            $c++;
        }
        return $aPermissionsFields;
    }

    function _processHeaderNavigation()
    {
        if (is_callable($this->callbackHeaderNavigation)) {
            call_user_func($this->callbackHeaderNavigation);
        }
    }

    function _processFooterNavigation()
    {
        if (is_callable($this->callbackFooterNavigation)) {
            call_user_func($this->callbackFooterNavigation);
        }
    }

    /**
     * Sets a allowedPermissions array. It could be either array:
     * array(
     *   permissionId => "permission name",
     *   ..
     * )
     *
     * or array of arrays, defined as:
     * array(
     *   permissionId => array("permission name", indent, onclick)
     *   ..
     * )
     * where indent and onlick are used to make indents in permissions.
     * To do a margin before the permissions "indent"
     * should be equal true. onlick is a javascript function
     * name which should be executed when a permission checkbox
     * is clicked. It is used to enable/disable some checkboxes.
     * Example: see the affiliate-user.php file.
     *
     * @param unknown_type $aAllowedPermissions
     */
    function setAllowedPermissions($aAllowedPermissions)
    {
        $this->aAllowedPermissions = $aAllowedPermissions;
    }

    function setHiddenFields($aHiddenFields)
    {
        $this->aHiddenFields = $aHiddenFields;
    }

    function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    function setBackUrl($backUrl)
    {
        $this->backUrl = $backUrl;
    }

    function getRedirectUrl()
    {
        if (!empty($this->redirectUrl)) {
            return $this->redirectUrl;
        }
        return $this->pagePrefix . '-access.php';
    }

    /**
     * Assign common template variables
     *
     * @param Admin_Template $oTpl
     */
    function assignUserStartTemplateVariables(&$oTpl)
    {
        $oTpl->assign('method', 'GET');
        // Add variables required by the current authentication plugin
        $oPlugin = OA_Auth::staticGetAuthPlugin();
        $oPlugin->setTemplateVariables($oTpl);
        $helpString = OA_Admin_UI_UserAccess::getHelpString(
            $oTpl->get_template_vars('sso'));
        $oTpl->assign('strLinkUserHelp', $helpString);
    }

    function getHelpString($isSso)
    {
        $name = ($isSso) ? $GLOBALS['strLinkUserHelpEmail']
            : $GLOBALS['strLinkUserHelpUser'];
        return sprintf($GLOBALS['strLinkUserHelp'], $name, $GLOBALS['strLinkUser']);
    }

    /**
     * Returns hidden fields used in pages entity-user
     *
     * TODO - refactor this and move as class variables
     *
     * @param string $entityName
     * @param integer $entityId
     */
    function _getHiddenFields($userData, $link, $entities = array())
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
            array(
                'name'  => 'token',
                'value' => phpAds_SessionGetToken(),
            ),
        );
        $fields = array('userid', 'email_address');
        foreach ($fields as $field) {
            if (!empty($userData[$field])) {
                $hiddenFields[] = array(
                    'name'  => $field,
                    'value' => $userData[$field]
                );
            }
        }
        foreach ($entities as $entityName => $entityId)  {
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
        if (!empty($userId)) {
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
