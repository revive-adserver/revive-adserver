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

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');
require_once MAX_PATH . '/etc/changes/UserMigration.php';
require_once MAX_PATH . '/etc/changes/EncodingMigration.php';
require_once(MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php');

class Migration_544 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddTable__account_preference_assoc';
        $this->aTaskList_constructive[] = 'afterAddTable__account_preference_assoc';
        $this->aTaskList_constructive[] = 'beforeAddTable__preferences';
        $this->aTaskList_constructive[] = 'afterAddTable__preferences';
        $this->aTaskList_constructive[] = 'beforeAddIndex__accounts__account_type';
        $this->aTaskList_constructive[] = 'afterAddIndex__accounts__account_type';
        $this->aTaskList_constructive[] = 'beforeAlterField__application_variable__value';
        $this->aTaskList_constructive[] = 'afterAlterField__application_variable__value';
        $this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__username';
        $this->aTaskList_destructive[] = 'afterRemoveField__affiliates__username';
        $this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__password';
        $this->aTaskList_destructive[] = 'afterRemoveField__affiliates__password';
        $this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__permissions';
        $this->aTaskList_destructive[] = 'afterRemoveField__affiliates__permissions';
        $this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__language';
        $this->aTaskList_destructive[] = 'afterRemoveField__affiliates__language';
        $this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__publiczones';
        $this->aTaskList_destructive[] = 'afterRemoveField__affiliates__publiczones';
        $this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__last_accepted_agency_agreement';
        $this->aTaskList_destructive[] = 'afterRemoveField__affiliates__last_accepted_agency_agreement';
        $this->aTaskList_destructive[] = 'beforeRemoveField__agency__username';
        $this->aTaskList_destructive[] = 'afterRemoveField__agency__username';
        $this->aTaskList_destructive[] = 'beforeRemoveField__agency__password';
        $this->aTaskList_destructive[] = 'afterRemoveField__agency__password';
        $this->aTaskList_destructive[] = 'beforeRemoveField__agency__permissions';
        $this->aTaskList_destructive[] = 'afterRemoveField__agency__permissions';
        $this->aTaskList_destructive[] = 'beforeRemoveField__agency__language';
        $this->aTaskList_destructive[] = 'afterRemoveField__agency__language';
        $this->aTaskList_destructive[] = 'beforeRemoveField__clients__clientusername';
        $this->aTaskList_destructive[] = 'afterRemoveField__clients__clientusername';
        $this->aTaskList_destructive[] = 'beforeRemoveField__clients__clientpassword';
        $this->aTaskList_destructive[] = 'afterRemoveField__clients__clientpassword';
        $this->aTaskList_destructive[] = 'beforeRemoveField__clients__permissions';
        $this->aTaskList_destructive[] = 'afterRemoveField__clients__permissions';
        $this->aTaskList_destructive[] = 'beforeRemoveField__clients__language';
        $this->aTaskList_destructive[] = 'afterRemoveField__clients__language';
    }



    public function beforeAddTable__account_preference_assoc()
    {
        return $this->beforeAddTable('account_preference_assoc');
    }

    public function afterAddTable__account_preference_assoc()
    {
        return $this->afterAddTable('account_preference_assoc');
    }

    public function beforeAddTable__preferences()
    {
        return $this->beforeAddTable('preferences');
    }

    public function afterAddTable__preferences()
    {
        return $this->afterAddTable('preferences');
    }

    public function beforeAddIndex__accounts__account_type()
    {
        return $this->beforeAddIndex('accounts', 'account_type');
    }

    public function afterAddIndex__accounts__account_type()
    {
        return $this->afterAddIndex('accounts', 'account_type');
    }

    /**
     * User Account migration
     *
     * @return boolean
     */
    public function beforeAlterField__application_variable__value()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Encoding changes must be made before remapping the users, because the user migration
        // loses the exact encoding of the language pack (in preparation for UTF-8 only packs)
        $oEncodingMigration = new EncodingMigration();
        $oEncodingMigration->convertEncoding();

        $aUserdata = [
            'ADMIN' => [
                'sourceTable' => 'preference',
                'primaryKey' => 'agencyid',
                'fieldMap' => [
                    'name' => $this->oDBH->quote('Administrator'),
                    'contact_name' => 'admin_fullname',
                    'email_address' => 'admin_email',
                    'username' => 'admin',
                    'password' => 'admin_pw',
                    'permissions' => $this->oDBH->quote(0, 'integer'),
                ],
                'whereAdd' => 'agencyid = 0',
            ],
            'MANAGER' => [
                'sourceTable' => 'agency',
                'primaryKey' => 'agencyid',
                'fieldMap' => [
                    'name' => 'name',
                    'contact_name' => 'contact',
                    'email_address' => 'email',
                    'username' => 'username',
                    'password' => 'password',
                    'permissions' => $this->oDBH->quote(0, 'integer'),
                ],
                'whereAdd' => 'account_id IS NULL',
            ],
            'ADVERTISER' => [
                'sourceTable' => 'clients',
                'primaryKey' => 'clientid',
                'fieldMap' => [
                    'name' => 'clientname',
                    'contact_name' => 'contact',
                    'email_address' => 'email',
                    'username' => 'clientusername',
                    'password' => 'clientpassword',
                    'permissions' => 'permissions',
                ],
                'permissionMap' => [
                    2 => OA_PERM_BANNER_EDIT,
                    4 => OA_PERM_BANNER_ADD,
                    8 => OA_PERM_BANNER_DEACTIVATE,
                    16 => OA_PERM_BANNER_ACTIVATE,
                ],
            ],
            'TRAFFICKER' => [
                'sourceTable' => 'affiliates',
                'primaryKey' => 'affiliateid',
                'fieldMap' => [
                    'name' => 'name',
                    'contact_name' => 'contact',
                    'email_address' => 'email',
                    'username' => 'username',
                    'password' => 'password',
                    'permissions' => 'permissions',
                ],
                'permissionMap' => [
                    2 => OA_PERM_ZONE_LINK,
                    4 => OA_PERM_ZONE_ADD,
                    8 => OA_PERM_ZONE_DELETE,
                    16 => OA_PERM_ZONE_EDIT,
                    32 => OA_PERM_ZONE_INVOCATION,
                ],
            ],
        ];

        $oUserMigration = new UserMigration();

        foreach ($aUserdata as $group => $aUser) {
            $result = $oUserMigration->_migrateUsers($group, $aUser);
            if (!$result) {
                return false;
            }
        }

        return $this->beforeAlterField('application_variable', 'value');
    }

    public function afterAlterField__application_variable__value()
    {
        return $this->afterAlterField('application_variable', 'value');
    }

    public function beforeRemoveField__affiliates__username()
    {
        return $this->beforeRemoveField('affiliates', 'username');
    }

    public function afterRemoveField__affiliates__username()
    {
        return $this->afterRemoveField('affiliates', 'username');
    }

    public function beforeRemoveField__affiliates__password()
    {
        return $this->beforeRemoveField('affiliates', 'password');
    }

    public function afterRemoveField__affiliates__password()
    {
        return $this->afterRemoveField('affiliates', 'password');
    }

    public function beforeRemoveField__affiliates__permissions()
    {
        return $this->beforeRemoveField('affiliates', 'permissions');
    }

    public function afterRemoveField__affiliates__permissions()
    {
        return $this->afterRemoveField('affiliates', 'permissions');
    }

    public function beforeRemoveField__affiliates__language()
    {
        return $this->beforeRemoveField('affiliates', 'language');
    }

    public function afterRemoveField__affiliates__language()
    {
        return $this->afterRemoveField('affiliates', 'language');
    }

    public function beforeRemoveField__affiliates__publiczones()
    {
        return $this->beforeRemoveField('affiliates', 'publiczones');
    }

    public function afterRemoveField__affiliates__publiczones()
    {
        return $this->afterRemoveField('affiliates', 'publiczones');
    }

    public function beforeRemoveField__affiliates__last_accepted_agency_agreement()
    {
        return $this->beforeRemoveField('affiliates', 'last_accepted_agency_agreement');
    }

    public function afterRemoveField__affiliates__last_accepted_agency_agreement()
    {
        return $this->afterRemoveField('affiliates', 'last_accepted_agency_agreement');
    }

    public function beforeRemoveField__agency__username()
    {
        return $this->beforeRemoveField('agency', 'username');
    }

    public function afterRemoveField__agency__username()
    {
        return $this->afterRemoveField('agency', 'username');
    }

    public function beforeRemoveField__agency__password()
    {
        return $this->beforeRemoveField('agency', 'password');
    }

    public function afterRemoveField__agency__password()
    {
        return $this->afterRemoveField('agency', 'password');
    }

    public function beforeRemoveField__agency__permissions()
    {
        return $this->beforeRemoveField('agency', 'permissions');
    }

    public function afterRemoveField__agency__permissions()
    {
        return $this->afterRemoveField('agency', 'permissions');
    }

    public function beforeRemoveField__agency__language()
    {
        return $this->beforeRemoveField('agency', 'language');
    }

    public function afterRemoveField__agency__language()
    {
        return $this->afterRemoveField('agency', 'language');
    }

    public function beforeRemoveField__clients__clientusername()
    {
        return $this->beforeRemoveField('clients', 'clientusername');
    }

    public function afterRemoveField__clients__clientusername()
    {
        return $this->afterRemoveField('clients', 'clientusername');
    }

    public function beforeRemoveField__clients__clientpassword()
    {
        return $this->beforeRemoveField('clients', 'clientpassword');
    }

    public function afterRemoveField__clients__clientpassword()
    {
        return $this->afterRemoveField('clients', 'clientpassword');
    }

    public function beforeRemoveField__clients__permissions()
    {
        return $this->beforeRemoveField('clients', 'permissions');
    }

    public function afterRemoveField__clients__permissions()
    {
        return $this->afterRemoveField('clients', 'permissions');
    }

    public function beforeRemoveField__clients__language()
    {
        return $this->beforeRemoveField('clients', 'language');
    }

    public function afterRemoveField__clients__language()
    {
        return $this->afterRemoveField('clients', 'language');
    }
}
