<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

/**
 * 2.6 new User, Roles, Accounts & Permissions system
 *
 */
class UserMigration extends Migration
{

    function UserMigration()
    {
    }

	function _migrateUsers($group, $aUser)
	{
	    extract($aUser);

	    $aConf = $GLOBALS['_MAX']['CONF'];
	    $oDbh  = &OA_DB::singleton();

        $prefix      = $aConf['table']['prefix'];
	    $tblSource   = $oDbh->quoteIdentifier($prefix.$sourceTable, true);
	    $tblAccounts = $oDbh->quoteIdentifier($prefix.'accounts', true);
        $tblUsers    = $oDbh->quoteIdentifier($prefix.'users', true);
        $tblAppVar   = $oDbh->quoteIdentifier($prefix.'application_variable', true);

	    if (!empty($whereAdd)) {
	        $whereAdd = "WHERE
	           {$whereAdd}";
	    }

	    $query = "
	       SELECT
	           {$primaryKey} AS id,
	           {$fieldMap['name']} AS name,
	           {$fieldMap['contact_name']} AS contact_name,
	           {$fieldMap['email_address']} AS email_address,
	           {$fieldMap['username']} AS username,
	           {$fieldMap['password']} AS password,
	           {$fieldMap['permissions']} AS permissions
	       FROM
    	       {$tblSource}
	       {$whereAdd}
	    ";

	    $aSource = $oDbh->getAssoc($query);

        if (PEAR::isError($aSource)) {
            $this->_logError("Error while retrieving existing {$group} accounts");
            return false;
        }

	    foreach ($aSource as $sourceId => $aData) {
            if (empty($aData['name'])) {
                $aData['name'] = ucwords(strtolower($group)).' '.$sourceId;
            }
            if (empty($aData['contact_name'])) {
                $aData['contact_name'] = $aData['name'];
            }
            if (empty($aData['email_address'])) {
                $aData['email_address'] = '';
            }

            $query = "
                INSERT INTO {$tblAccounts} (
                    account_type,
                    account_name
                ) VALUES (
                    ".$oDbh->quote($group).",
                    ".$oDbh->quote($aData['name'])."
                )
            ";

            $result = $oDbh->exec($query);

            if (PEAR::isError($result)) {
                $this->_logError("Error while creating account for {$group} {$sourceId}");
                return false;
            }

            $accountId = $oDbh->lastInsertID($prefix.'accounts', 'account_id');

            if ($group == 'ADMIN') {
                // Add the admin account ID to the application variables
                $query = "
                    INSERT INTO {$tblAppVar} (
                        name,
                        value
                    ) VALUES (
                        'admin_account_id',
                        ".$oDbh->quote($accountId)."
                    )";

                $result = $oDbh->exec($query);

                if (!$result) {
                    $this->_logError('Error saving the admin account ID as application variable');
                    return false;
                }

                // Create a new manager account
                $query = "
                    INSERT INTO {$tblAccounts} (
                        account_type,
                        account_name
                    ) VALUES (
                        ".$oDbh->quote('MANAGER').",
                        ".$oDbh->quote('Default manager')."
                    )
                ";

                $result = $oDbh->exec($query);

                if (PEAR::isError($result)) {
                    $this->_logError("Error while creating manager account for {$group} {$sourceId}");
                    return false;
                }

                $managerAccountId = $oDbh->lastInsertID($prefix.'accounts', 'account_id');

                $query = "
                    INSERT INTO ".$oDbh->quoteIdentifier($prefix.'agency', true)."(
                        name,
                        email,
                        account_id,
                        active
                    ) VALUES (
                        ".$oDbh->quote('Default manager').",
                        ".$oDbh->quote($aData['email_address']).",
                        ".$oDbh->quote($managerAccountId, 'integer').",
                        1
                    )
                ";

                $result = $oDbh->exec($query);

                if (PEAR::isError($result)) {
                    $this->_logError("Error while creating default agency for {$group} {$sourceId}");
                    return false;
                }

                $agencyId = $oDbh->lastInsertID($prefix.'agency', 'agencyid');

                foreach (array('clients', 'affiliates', 'channel') as $entity) {
                    $query = "
                        UPDATE
                            ".$oDbh->quoteIdentifier($prefix.$entity, true)."
                        SET
                            agencyid = ".$oDbh->quote($agencyId, 'integer')."
                        WHERE
                            agencyid = 0
                    ";

                    $result = $oDbh->exec($query);

                    if (PEAR::isError($result)) {
                        $this->_logError("Error while migrating {$entity} table for {$group} {$sourceId}");
                        return false;
                    }
                }
            } else {
                // Save account ID in the entity table
                $query = "
                    UPDATE
                        {$tblSource}
                    SET
                        account_id = ".$oDbh->quote($accountId, 'integer')."
                    WHERE
                        {$primaryKey} = ".$oDbh->quote($sourceId, 'integer')."
                ";

                $result = $oDbh->exec($query);

                if (PEAR::isError($result)) {
                    $this->_logError("Error while updating entity {$group} {$sourceId} with account details");
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
                        default_account_id
                    ) VALUES (
                        ".$oDbh->quote($aData['contact_name']).",
                        ".$oDbh->quote($aData['email_address']).",
                        ".$oDbh->quote(strtolower($aData['username'])).",
                        ".$oDbh->quote($aData['password']).",
                        ".$oDbh->quote($defaultAccountId, 'integer')."
                    )
                ";

                $result = $oDbh->exec($query);

                if (PEAR::isError($result)) {
                    $this->_logError("Error while creating user for {$group} {$sourceId}");
                    return false;
                }

                $userId = $oDbh->lastInsertID($prefix.'users', 'user_id');
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
                    $aPermissions = array();

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

        return true;
	}

	function _insertAccountAccess($accountId, $userId)
	{
	    $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
	    $oDbh  = &OA_DB::singleton();

	    $accountId = $oDbh->quote($accountId);
	    $userId = $oDbh->quote($userId);
	    $query = "INSERT INTO
	               {$prefix}account_user_assoc
	               (account_id, user_id)
	               VALUES
	               ({$accountId},{$userId})";

  	    $result = $oDbh->Exec($query);

	    if (PEAR::isError($result))
	    {
	        $this->_logError('Failed to insert account_user_assoc record for account:'
	           .$accountId.', user: '.$userId);
	        return false;
	    }
	    return true;
    }

	function _insertAccountPermissions($accountId, $userId, $aPermissions)
	{
	    $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
	    $oDbh  = &OA_DB::singleton();

	    $accountId = $oDbh->quote($accountId);
	    $userId = $oDbh->quote($userId);

	    foreach ($aPermissions as $permissionId) {
    	    $query = "INSERT INTO
    	               {$prefix}account_user_permission_assoc
    	               (account_id, user_id, permission_id, is_allowed)
    	               VALUES
    	               ({$accountId},{$userId}, {$permissionId}, 1)";

      	    $result = $oDbh->Exec($query);
    	    if (PEAR::isError($result))
    	    {
    	        $this->_logError('Failed to insert account_user_assoc record for account: '.$accountId
    	           .', user: '.$userId.', permission: '.$permissionId);
    	        return false;
    	    }
	    }

	    return true;
    }
}

?>