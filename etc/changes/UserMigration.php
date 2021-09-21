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

/**
 * 2.6 new User, Roles, Accounts & Permissions system
 *
 */
class UserMigration extends Migration
{
    public $languageMap = [
        'chinese_big5' => 'zh_CN',
        'chinese_gb2312' => 'zh_CN',
        'czech' => 'cs',
        'dutch' => 'nl',
        'english' => 'en',
        'english_affiliates' => 'en',
        'english_us' => 'en',
        'french' => 'fr',
        'german' => 'de',
        'hebrew' => 'he',
        'hungarian' => 'hu',
        'indonesian' => 'id',
        'italian' => 'it',
        'korean' => 'ko',
        'polish' => 'pl',
        'portuguese' => 'pt_BR',
        'brazilian_portuguese' => 'pt_BR',
        'russian_cp1251' => 'ru',
        'russian_koi8r' => 'ru',
        'spanish' => 'es',
        'turkish' => 'tr'
    ];

    public $aLanguageByAgency = [];

    public function __construct()
    {
        // We will need the admin and per-agency languages to assign the correct "Default" languages to advertiser and websites
        if (!$this->init(OA_DB::singleton())) {
            $this->_logError('Failed to initialise UserMigration class');
            return false;
        }
        $this->_log('Initialised UserMigration class, construction begun');
        $table = $this->_getQuotedTableName('preference');

        // Get admin language
        $query = "
            SELECT
                agencyid AS id,
                language AS language
            FROM
                {$table}
            WHERE
                agencyid = 0
        ";

        $adminLang = $this->oDBH->getAssoc($query);
        if (PEAR::isError($adminLang)) {
            $this->_logError("Error while retrieving admin language: " . $adminLang->getUserInfo());
            return false;
        }

        // Get agency languages
        $table = $this->_getQuotedTableName('agency');
        $query = "
            SELECT
                agencyid AS id,
                language AS language
            FROM
                {$table}";
        $agencyLang = $this->oDBH->getAssoc($query);
        if (PEAR::isError($agencyLang)) {
            $this->_logError("Error while retrieving agency languages: " . $agencyLang->getUserInfo());
            return false;
        }

        // Set the admin's language for id 0, then set each agencies language as specified, using admins if unset
        $this->aLanguageByAgency[0] = empty($adminLang[0]) ? 'english' : $adminLang[0];

        foreach ($agencyLang as $id => $language) {
            $this->aLanguageByAgency[$id] = empty($language) ? $this->aLanguageByAgency[0] : $language;
        }
        $this->_log('UserMigration class, construction complete');
    }

    public function _migrateUsers($group, $aUser)
    {
        extract($aUser);

        $tblSource = $this->_getQuotedTableName($sourceTable);
        $tblAccounts = $this->_getQuotedTableName('accounts');
        $tblUsers = $this->_getQuotedTableName('users');
        $tblAppVar = $this->_getQuotedTableName('application_variable');
        $tblAgency = $this->_getQuotedTableName('agency');

        $whereAdd = empty($whereAdd) ? '' : "WHERE
	           {$whereAdd}";

        $this->_log('Starting User Migration for group: ' . $group . ' / ' . $whereAdd . ' /  username = ' . $fieldMap['username']);

        $query = "SELECT
	           {$primaryKey} AS id,
	           agencyid AS agency_id,
	           {$fieldMap['name']} AS name,
	           {$fieldMap['contact_name']} AS contact_name,
	           {$fieldMap['email_address']} AS email_address,
	           {$fieldMap['username']} AS username,
	           {$fieldMap['password']} AS password,
	           language AS language,
	           {$fieldMap['permissions']} AS permissions
	       FROM
    	       {$tblSource}
	       {$whereAdd}
	    ";

        $aSource = $this->oDBH->getAssoc($query);

        if (PEAR::isError($aSource)) {
            $this->_logError("Error while retrieving existing {$group} accounts: " . $aSource->getUserInfo());
            return false;
        }

        foreach ($aSource as $sourceId => $aData) {
            if (empty($aData['name'])) {
                $aData['name'] = ucwords(strtolower($group)) . ' ' . $sourceId;
            }
            if (empty($aData['contact_name'])) {
                $aData['contact_name'] = $aData['name'];
            }
            if (empty($aData['email_address'])) {
                $aData['email_address'] = '';
            }
            if (empty($aData['language'])) {
                if (!empty($this->aLanguageByAgency[$aData['agency_id']])) {
                    $aData['language'] = $this->aLanguageByAgency[$aData['agency_id']];
                } else {
                    $aData['language'] = $this->aLanguageByAgency[0];
                }
            }
            // Lookup their language in the language map, if we don't recognise it, convert it to english (sorry :()
            $aData['language'] = empty($this->languageMap[$aData['language']]) ? 'en' : $this->languageMap[$aData['language']];

            $query = "
                INSERT INTO {$tblAccounts} (
                    account_type,
                    account_name
                ) VALUES (
                    " . $this->oDBH->quote($group) . ",
                    " . $this->oDBH->quote($aData['name']) . "
                )
            ";

            $result = $this->oDBH->exec($query);

            if (PEAR::isError($result)) {
                $this->_logError("Error while creating account for {$group} {$sourceId}: " . $result->getUserInfo());
                return false;
            }

            $accountId = $this->oDBH->lastInsertID($this->prefix . 'accounts', 'account_id');

            if ($group == 'ADMIN') {
                // Add the admin account ID to the application variables
                $query = "
                    INSERT INTO {$tblAppVar} (
                        name,
                        value
                    ) VALUES (
                        'admin_account_id',
                        " . $this->oDBH->quote($accountId) . "
                    )";

                $result = $this->oDBH->exec($query);

                if (PEAR::isError($result)) {
                    $this->_logError('Error saving the admin account ID as application variable: ' . $result->getUserInfo());
                    return false;
                }
                // Create a new manager account
                $query = "
                    INSERT INTO {$tblAccounts} (
                        account_type,
                        account_name
                    ) VALUES (
                        " . $this->oDBH->quote('MANAGER') . ",
                        " . $this->oDBH->quote('Default manager') . "
                    )
                ";

                $result = $this->oDBH->exec($query);

                if (PEAR::isError($result)) {
                    $this->_logError("Error while creating manager account for {$group} {$sourceId}: " . $result->getUserInfo());
                    return false;
                }

                $managerAccountId = $this->oDBH->lastInsertID($this->prefix . 'accounts', 'account_id');

                $query = "
                    INSERT INTO {$tblAgency} (
                        name,
                        email,
                        account_id,
                        active
                    ) VALUES (
                        " . $this->oDBH->quote('Default manager') . ",
                        " . $this->oDBH->quote($aData['email_address']) . ",
                        " . $this->oDBH->quote($managerAccountId, 'integer') . ",
                        1
                    )
                ";

                $result = $this->oDBH->exec($query);

                if (PEAR::isError($result)) {
                    $this->_logError("Error while creating default agency for {$group} {$sourceId}: " . $result->getUserInfo());
                    return false;
                }

                $agencyId = $this->oDBH->lastInsertID($this->prefix . 'agency', 'agencyid');

                foreach (['clients', 'affiliates', 'channel'] as $entity) {
                    $tblEntity = $this->_getQuotedTableName($entity);
                    $query = "
                        UPDATE
                            {$tblEntity}
                        SET
                            agencyid = " . $this->oDBH->quote($agencyId, 'integer') . "
                        WHERE
                            agencyid = 0
                    ";

                    $result = $this->oDBH->exec($query);

                    if (PEAR::isError($result)) {
                        $this->_logError("Error while migrating {$entity} table for {$group} {$sourceId}: " . $result->getUserInfo());
                        return false;
                    }
                }
            } else {
                // Save account ID in the entity table
                $query = "
                    UPDATE
                        {$tblSource}
                    SET
                        account_id = " . $this->oDBH->quote($accountId, 'integer') . "
                    WHERE
                        {$primaryKey} = " . $this->oDBH->quote($sourceId, 'integer') . "
                ";

                $result = $this->oDBH->exec($query);

                if (PEAR::isError($result)) {
                    $this->_logError("Error while updating entity {$group} {$sourceId} with account details: " . $result->getUserInfo());
                    return false;
                }
            }

            if (!empty($aData['username']) && !empty($aData['password'])) {
                $defaultAccountId = $group == 'ADMIN' ? $managerAccountId : $accountId;

                $query = "
                    INSERT INTO {$tblUsers} (
                        contact_name,
                        email_address,
                        username,
                        password,
                        language,
                        default_account_id
                    ) VALUES (
                        " . $this->oDBH->quote($aData['contact_name']) . ",
                        " . $this->oDBH->quote($aData['email_address']) . ",
                        " . $this->oDBH->quote(strtolower($aData['username'])) . ",
                        " . $this->oDBH->quote($aData['password']) . ",
                        " . $this->oDBH->quote($aData['language']) . ",
                        " . $this->oDBH->quote($defaultAccountId, 'integer') . "
                    )
                ";

                $result = $this->oDBH->exec($query);

                if (PEAR::isError($result)) {
                    $this->_logError("Error while creating user for {$group} {$sourceId}: " . $result->getUserInfo());
                    return false;
                }

                $userId = $this->oDBH->lastInsertID($this->prefix . 'users', 'user_id');
                $result = $this->_insertAccountAccess($accountId, $userId);
                if (!$result) {
                    $this->_logError("error while giving access to user id: $userId to account: $accountId");
                    return false;
                }
                if ($group == 'ADMIN' && !empty($managerAccountId)) {
                    $result = $this->_insertAccountAccess($managerAccountId, $userId);
                    if (!$result) {
                        $this->_logError("error while giving access to user id: $userId to account: $managerAccountId");
                        return false;
                    }
                }

                if ($group != 'ADMIN') {
                    // Grant access to the user
                    $aPermissions = [];

                    if (!empty($permissionMap)) {
                        foreach ($permissionMap as $k => $v) {
                            if ($aData['permissions'] & $k) {
                                $aPermissions[] = $v;
                            }
                        }
                    }
                    $result = $this->_insertAccountPermissions($accountId, $userId, $aPermissions);
                    if (!$result) {
                        $this->_logError("Error creating permissions for account: {$accountId} and user {$userId}");
                        return false;
                    }
                }
            }
        }
        $this->_log('Completed User Migration for group: ' . $group . ' / ' . $whereAdd . ' /  username = ' . $fieldMap['username']);
        return true;
    }

    public function _insertAccountAccess($accountId, $userId)
    {
        $table = $this->_getQuotedTableName('account_user_assoc');
        $accountId = $this->oDBH->quote($accountId);
        $userId = $this->oDBH->quote($userId);

        $query = "INSERT INTO
	               {$table}
	               (account_id, user_id)
	               VALUES
	               ({$accountId},{$userId})";

        $result = $this->oDBH->exec($query);
        if (PEAR::isError($result)) {
            $this->_logError('_insertAccountAccess' . $result->getUserInfo());
            return false;
        }
        return true;
    }

    public function _insertAccountPermissions($accountId, $userId, $aPermissions)
    {
        $table = $this->_getQuotedTableName('account_user_permission_assoc');
        $accountId = $this->oDBH->quote($accountId);
        $userId = $this->oDBH->quote($userId);

        foreach ($aPermissions as $permissionId) {
            $query = "INSERT INTO
    	               {$table}
    	               (account_id, user_id, permission_id, is_allowed)
    	               VALUES
    	               ({$accountId},{$userId}, {$permissionId}, 1)";

            $result = $this->oDBH->exec($query);
            if (PEAR::isError($result)) {
                $this->_logError('_insertAccountPermissions' . $result->getUserInfo());
                return false;
            }
        }
        return true;
    }
}
