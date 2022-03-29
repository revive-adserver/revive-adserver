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
require_once MAX_PATH . '/lib/OA/Admin/PasswordRecovery.php';

/**
 * Common UserAccess related UI methods
 *
 */
class OA_Admin_UI_UserAccess
{
    public $accountId;
    public $userid;
    public $request = [];
    public $pagePrefix; // admin/agency/advertiser/affiliate
    public $aErrors = [];

    /** @var Plugins_Authentication */
    public $oPlugin;

    public $callbackHeaderNavigation;
    public $callbackFooterNavigation;
    public $aAllowedPermissions = [];
    public $aPermissions = [];
    public $aHiddenFields = [];
    public $redirectUrl;
    public $backUrl;

    /** @var OA_Admin_PasswordRecovery */
    private $oPasswordRecovery;

    public function init()
    {
        $this->initRequest();

        $this->oPlugin = OA_Auth::staticGetAuthPlugin();
        $this->oPasswordRecovery = new OA_Admin_PasswordRecovery();

        if (empty($this->userid)) {
            $this->userid = $this->oPlugin->getMatchingUserId(
                $this->request['email_address'],
                $this->request['login']
            );
        }
    }

    public function initRequest()
    {
        $this->request = phpAds_registerGlobalUnslashed(
            'userid',
            'login',
            'link',
            'contact_name',
            'email_address',
            'permissions',
            'submit',
            'language',
            'token'
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

    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

    public function setPagePrefix($pagePrefix)
    {
        $this->pagePrefix = $pagePrefix;
    }

    public function setNavigationHeaderCallback($callback)
    {
        $this->callbackHeaderNavigation = $callback;
    }

    public function setNavigationFooterCallback($callback)
    {
        $this->callbackFooterNavigation = $callback;
    }

    public function process()
    {
        if (!empty($this->request['submit'])) {
            if (preg_match('#[\x00-\x1F\x7F]#', $this->request['login'])) {
                $this->aErrors = [$GLOBALS['strInvalidUsername']];
            } else {
                $this->aErrors = $this->oPlugin->validateUsersData($this->request);
            }

            if (empty($this->aErrors)) {
                $newUser = empty($this->userid);

                $this->userid = $this->oPlugin->saveUser(
                    $this->userid,
                    $this->request['login'],
                    null,
                    $this->request['contact_name'],
                    $this->request['email_address'],
                    $this->request['language'],
                    $this->accountId
                );

                if ($this->userid) {
                    self::linkUserToAccount(
                        $this->userid,
                        $this->accountId,
                        $this->aPermissions,
                        $this->aAllowedPermissions
                    );

                    if ($newUser && $this->oPasswordRecovery->sendWelcomeEmail([$this->userid]) > 0) {
                        OA_Session::setMessage($GLOBALS['strUserLinkedAndWelcomeSent']);
                    }

                    OX_Admin_Redirect::redirect($this->getRedirectUrl());
                } else {
                    $this->aErrors = $this->oPlugin->getSignupErrors();
                }
            }
        }
        $this->display();
    }

    public function display()
    {
        $this->_processHeaderNavigation();

        require_once MAX_PATH . '/lib/OA/Admin/Template.php';

        $oTpl = new OA_Admin_Template($this->pagePrefix . '-user.html');
        $oTpl->assign('action', $this->pagePrefix . '-user.php');
        $oTpl->assign('backUrl', $this->backUrl);
        $oTpl->assign('method', 'POST');
        $oTpl->assign('aErrors', $this->aErrors);

        $this->oPlugin->setTemplateVariables($oTpl);

        $oTpl->assign('existingUser', !empty($this->userid));
        $oTpl->assign('showLinkButton', !empty($this->request['link']));

        $doUsers = OA_Dal::staticGetDO('users', $this->userid);
        $userData = [];
        if ($doUsers) {
            $userData = $doUsers->toArray();
        } else {
            $userData['username'] = $this->request['login'];
            $userData['contact_name'] = $this->request['contact_name'];
            $userData['email_address'] = $this->request['email_address'];
            $userData['language'] = $this->request['language'];
        }
        $userData['userid'] = $this->userid;

        $aTplFields = [
            [
                'title' => $GLOBALS['strUserDetails'],
                'fields' => $this->oPlugin->getUserDetailsFields(
                    $userData,
                    $this->request['link']
                )
            ]
        ];
        $aPermissionsFields = $this->_builPermissionFields();
        if (!empty($aPermissionsFields)) {
            $aTplFields[] = [
                'title' => $GLOBALS['strPermissions'],
                'fields' => $aPermissionsFields
            ];
        }
        $oTpl->assign('fields', $aTplFields);

        $aHiddenFields = $this->_getHiddenFields($userData, $this->request['link'], $this->aHiddenFields);
        $oTpl->assign('hiddenFields', $aHiddenFields);

        $oTpl->display();

        $this->_processFooterNavigation();

        phpAds_PageFooter();
    }

    public function _builPermissionFields()
    {
        $aPermissionsFields = [];
        $c = 0;
        foreach ($this->aAllowedPermissions as $permissionId => $aPermission) {
            if (is_array($aPermission)) {
                list($permissionName, $indent, $onClick) = $aPermission;
            } else {
                $permissionName = $aPermission;
                $indent = false;
                $onClick = false;
            }
            $aPermissionsFields[$c] = [
                        'name' => 'permissions[]',
                        'label' => $permissionName,
                        'type' => 'checkbox',
                        'value' => $permissionId,
                        'checked' => OA_Permission::hasPermission(
                            $permissionId,
                            $this->accountId,
                            $this->userid
                        ),
                        'disabled' => OA_Permission::isUserLinkedToAdmin($this->userid),
                        'break' => false,
                        'id' => 'permissions_' . $permissionId,
                        'indent' => $indent,
                    ];
            if ($onClick) {
                $aPermissionsFields[$c]['onclick'] = $onClick;
            }
            $c++;
        }
        return $aPermissionsFields;
    }

    public function _processHeaderNavigation()
    {
        if (is_callable($this->callbackHeaderNavigation)) {
            call_user_func($this->callbackHeaderNavigation);
        }
    }

    public function _processFooterNavigation()
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
     * @param array $aAllowedPermissions
     */
    public function setAllowedPermissions($aAllowedPermissions)
    {
        $this->aAllowedPermissions = $aAllowedPermissions;
    }

    public function setHiddenFields($aHiddenFields)
    {
        $this->aHiddenFields = $aHiddenFields;
    }

    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    public function setBackUrl($backUrl)
    {
        $this->backUrl = $backUrl;
    }

    public function getRedirectUrl()
    {
        if (!empty($this->redirectUrl)) {
            return $this->redirectUrl;
        }
        return $this->pagePrefix . '-access.php';
    }

    /**
     * Assign common template variables
     *
     * @param OA_Admin_Template $oTpl
     */
    public static function assignUserStartTemplateVariables($oTpl)
    {
        $oTpl->assign('method', 'GET');
        // Add variables required by the current authentication plugin
        $oPlugin = OA_Auth::staticGetAuthPlugin();
        $oPlugin->setTemplateVariables($oTpl);
        $helpString = OA_Admin_UI_UserAccess::getHelpString(
            $oTpl->get_template_vars('sso')
        );
        $oTpl->assign('strLinkUserHelp', $helpString);
    }

    public static function getHelpString($isSso)
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
    public function _getHiddenFields($userData, $link, $entities = [])
    {
        $hiddenFields = [
            [
                'name' => 'submit',
                'value' => true
            ],
            [
                'name' => 'login',
                'value' => $userData['username']
            ],
            [
                'name' => 'link',
                'value' => $link
            ],
            [
                'name' => 'token',
                'value' => phpAds_SessionGetToken(),
            ],
        ];
        $fields = ['userid', 'email_address'];
        foreach ($fields as $field) {
            if (!empty($userData[$field])) {
                $hiddenFields[] = [
                    'name' => $field,
                    'value' => $userData[$field]
                ];
            }
        }
        foreach ($entities as $entityName => $entityId) {
            $hiddenFields[] = [
                    'name' => $entityName,
                    'value' => $entityId
                ];
        }
        return $hiddenFields;
    }

    /**
     * Unlinks user from account and if necessary deletes user account.
     * Sets appropriate message
     *
     * @param integer $userId User ID
     * @param integer $accountId Account ID
     */
    public static function unlinkUserFromAccount($userId, $accountId)
    {
        if (OA_Permission::isUserLinkedToAccount($accountId, $userId)) {
            /** @var DataObjects_Account_user_assoc $doAccount_user_assoc */
            $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
            $doAccount_user_assoc->account_id = $accountId;
            $doAccount_user_assoc->user_id = $userId;
            $doAccount_user_assoc->delete();
            OA_Session::setMessage($GLOBALS['strUserUnlinkedFromAccount']);

            /** @var DataObjects_Users $doUsers */
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
    public static function resetUserDefaultAccount($userId, $accountId)
    {
        /** @var DataObjects_Users $doUsers */
        $doUsers = OA_Dal::staticGetDO('users', $userId);
        if ($doUsers->default_account_id == $accountId) {
            /** @var DataObjects_Account_user_assoc $doAccount_user_assoc */
            $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
            $doAccount_user_assoc->user_id = $userId;
            $doAccount_user_assoc->orderBy('account_id');
            $doAccount_user_assoc->limit(1);

            if ($doAccount_user_assoc->find()) {
                $doAccount_user_assoc->fetch();

                $doUsers->default_account_id = $doAccount_user_assoc->account_id;
                $doUsers->update();
            }
        }
    }

    /**
     * Returns number of users linked to account
     *
     * @param integer $accountId
     * @return integer
     */
    public static function countNumberOfUserLinkedToAccount($accountId)
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
    public static function linkUserToAccount($userId, $accountId, $permissions, $aAllowedPermissions)
    {
        if (!empty($userId)) {
            if (!OA_Permission::isUserLinkedToAccount($accountId, $userId)) {
                OA_Session::setMessage($GLOBALS['strUserLinkedToAccount']);
            } else {
                OA_Session::setMessage($GLOBALS['strUserAccountUpdated']);
            }
            OA_Permission::setAccountAccess($accountId, $userId);
            OA_Permission::storeUserAccountsPermissions(
                $permissions,
                $accountId,
                $userId,
                $aAllowedPermissions
            );
        }
    }
}
