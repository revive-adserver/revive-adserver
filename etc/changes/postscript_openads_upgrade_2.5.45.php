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

$className = 'OA_UpgradePostscript_2_4_45';


class OA_UpgradePostscript_2_4_45
{
    /**
     * @var OA_Upgrade
     */
    var $oUpgrade;

    var $oSchema;

    function OA_UpgradePostscript_2_4_45()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];

        if (PEAR::isError($this->migrateUsers())) {
            return false;
        }
        return true;
    }

    /**
     * Migrate users to new tables, migrate their permissions as well
     * 
     * @return true on success else pear_error
     */
    function migrateUsers()
    {
	    $aConf = $GLOBALS['_MAX']['CONF'];
	    $oDbh  = OA_DB::singleton();

	    $aUserdata = array(
	       'ADMIN' => array(
	           'sourceTable' => $aConf['table']['preference'],
	           'primaryKey'  => 'agencyid',
	           'fieldMap'    => array(
	                    'name'          => $oDbh->quote('Administrator'),
            	        'contact_name'  => 'admin_fullname',
            	        'email_address' => 'admin_email',
            	        'username'      => 'admin',
            	        'password'      => 'admin_pw',
            	        'permissions'   => $oDbh->quote(0, 'integer'),
                   ),
               'whereAdd'     => 'agencyid = 0',
	       ),

	       'MANAGER' => array(
	           'sourceTable' => $aConf['table']['agency'],
	           'primaryKey'  => 'agencyid',
	           'fieldMap'    => array(
                        'name'          => 'name',
                        'contact_name'  => 'contact',
                        'email_address' => 'email',
                        'username'      => 'username',
                        'password'      => 'password',
            	        'permissions'   => $oDbh->quote(0, 'integer'),
                    ),
               'whereAdd'     => 'account_id IS NULL',
	       ),

	       'ADVERTISER' => array(
	           'sourceTable' => $aConf['table']['clients'],
	           'primaryKey'  => 'clientid',
	           'fieldMap'    => array(
                        'name'          => 'clientname',
                        'contact_name'  => 'contact',
                        'email_address' => 'email',
                        'username'      => 'clientusername',
                        'password'      => 'clientpassword',
            	        'permissions'   => 'permissions',
                    ),
                'permissionMap' => array(
                        2   => OA_PERM_BANNER_EDIT,
                        4   => OA_PERM_BANNER_ADD,
                        8   => OA_PERM_BANNER_DEACTIVATE,
                        16  => OA_PERM_BANNER_ACTIVATE,
                    ),
	       ),

	       'TRAFFICKER' => array(
	           'sourceTable' => $aConf['table']['affiliates'],
	           'primaryKey'  => 'affiliateid',
	           'fieldMap'    => array(
                        'name'          => 'name',
                        'contact_name'  => 'contact',
                        'email_address' => 'email',
                        'username'      => 'username',
                        'password'      => 'password',
            	        'permissions'   => 'permissions',
                    ),
                'permissionMap' => array(
                        2   => OA_PERM_ZONE_LINK,
                        4   => OA_PERM_ZONE_ADD,
                        8   => OA_PERM_ZONE_DELETE,
                        16  => OA_PERM_ZONE_EDIT,
                        32  => OA_PERM_ZONE_INVOCATION,
                    ),
	       ),
	    );

	    foreach ($aUserdata as $group => $aUser) {
    	    $result = $this->_migrateUsers($group, $aUser);
    	    if (PEAR::isError($result)) {
    	        return $result;
    	    }
	    }

		return true;
    }

	function _migrateUsers($group, $aUser)
	{
	    extract($aUser);

	    $aConf = $GLOBALS['_MAX']['CONF'];
	    $oDbh  = OA_DB::singleton();

        $prefix      = $aConf['table']['prefix'];
	    $tblSource   = $oDbh->quoteIdentifier($prefix.$sourceTable, true);
	    $tblAccounts = $oDbh->quoteIdentifier($prefix.'accounts', true);
        $tblUsers    = $oDbh->quoteIdentifier($prefix.'users', true);

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
            $this->oUpgrade->oLogger->logError("Error while retrieving existing {$group} accounts");
            return $aSource;
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
                $this->oUpgrade->oLogger->logError("Error while creating account for {$group} {$sourceId}");
                return $result;
            }

            $accountId = $oDbh->lastInsertID($prefix.'accounts', 'account_id');

            if ($group == 'ADMIN') {
                // Create a new manager account
                $query = "
                    INSERT INTO {$tblAccounts} (
                        account_type,
                        account_name
                    ) VALUES (
                        ".$oDbh->quote('MANAGER').",
                        ".$oDbh->quote($aData['name'])."
                    )
                ";

                $result = $oDbh->exec($query);

                if (PEAR::isError($result)) {
                    $this->oUpgrade->oLogger->logError("Error while creating manager account for {$group} {$sourceId}");
                    return $result;
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
                    $this->oUpgrade->oLogger->logError("Error while creating default agency for {$group} {$sourceId}");
                    return $result;
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
                        $this->oUpgrade->oLogger->logError("Error while migrating {$entity} table for {$group} {$sourceId}");
                        return $result;
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
                    $this->oUpgrade->oLogger->logError("Error while updating entity {$group} {$sourceId} with account details");
                    return $result;
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
                        ".$oDbh->quote($aData['username']).",
                        ".$oDbh->quote($aData['password']).",
                        ".$oDbh->quote($defaultAccountId, 'integer')."
                    )
                ";

                $result = $oDbh->exec($query);

                if (PEAR::isError($result)) {
                    $this->oUpgrade->oLogger->logError("Error while creating user for {$group} {$sourceId}");
                    return $result;
                }

                $userId = $oDbh->lastInsertID($prefix.'users', 'user_id');
                $result = OA_Permission::setAccountAccess($accountId, true, $userId);
                if (!$result) {
                    $this->oLogger->logError("error while giving access to user id: $userId to account: $accountId");
                    return false;
                }
                if ($group == 'ADMIN' && !empty($managerAccountId)) {
                    $result = OA_Permission::setAccountAccess($managerAccountId, true, $userId);
                    if (!$result) {
                        $this->oLogger->logError("error while giving access to user id: $userId to account: $managerAccountId");
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
                    
                    $result = OA_Permission::storeUserAccountsPermissions($aPermissions, $accountId, $userId);
                    
                    if (!$result) {
                        $this->oUpgrade->oLogger->logError("Error creating permissions for account: {$accountId} and user {$userId}");
                        return new PEAR_Error();
                    }
                }
            }
	    }

        return true;
	}
}

?>