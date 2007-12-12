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

require_once MAX_PATH . '/lib/OA/Permission/Gacl.php';
require_once MAX_PATH . '/lib/OA/Upgrade/GaclPermissions.php';


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

        $oGaclPermissions = new OA_GaclPermissions();
        if (!$oGaclPermissions->insert()) {
            return false;
        }

        if (PEAR::isError($this->migrateUsers())) {
            return false;
        }
        return true;
    }

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
//                        1   => array('ADVERTISER', 'EDIT'),
//                        2   => array('BANNER', 'EDIT'),
//                        4   => array('BANNER', 'ADD'),
                        8   => array('BANNER', 'DEACTIVATE'),
                        16  => array('BANNER', 'ACTIVATE'),
//                        32  => array('STATS', 'TARGETING'),
//                        64  => array('CONVERSION', 'EDIT'),
//                        128 => array('CONVERSION', 'IMPORT'),
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
//                        1   => array('TRAFFICKER', 'EDIT'),
                        2   => array('ZONE', 'LINK'),
                        4   => array('ZONE', 'ADD'),
                        8   => array('ZONE', 'DELETE'),
                        16  => array('ZONE', 'EDIT'),
                        32  => array('ZONE', 'INVOCATION'),
//                        64  => array('STATS', 'ZONE'),
                    ),
	       ),
	    );

	    foreach ($aUserdata as $gaclGroup => $aUser) {
    	    $result = $this->_migrateUsers($gaclGroup, $aUser);
    	    if (PEAR::isError($result)) {
    	        return $result;
    	    }
	    }

		return true;
    }

	function _migrateUsers($gaclGroup, $aUser)
	{
	    extract($aUser);

	    $aConf = $GLOBALS['_MAX']['CONF'];
	    $oDbh  = OA_DB::singleton();
	    $oGacl = OA_Permission_Gacl::factory();
	    $groupId = $oGacl->get_group_id("{$gaclGroup}_ACCOUNTS", null, 'AXO');

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
            $this->oUpgrade->oLogger->logError("Error while retrieving existing {$gaclGroup} accounts");
            return $aSource;
        }

	    foreach ($aSource as $sourceId => $aData) {
            if (empty($aData['name'])) {
                $aData['name'] = ucwords(strtolower($gaclGroup)).' '.$sourceId;
            }
            if (empty($aData['contact_name'])) {
                $aData['contact_name'] = $aData['name'];
            }
            if (empty($aData['email_address'])) {
                $aData['email_address'] = '';
            }

            $query = "
                INSERT INTO {$tblAccounts} (
                    account_type
                ) VALUES (
                    ".$oDbh->quote($gaclGroup)."
                )
            ";

            $result = $oDbh->exec($query);

            if (PEAR::isError($result)) {
                $this->oUpgrade->oLogger->logError("Error while creating account for {$gaclGroup} {$sourceId}");
                return $result;
            }

            $accountId = $oDbh->lastInsertID($prefix.'accounts', 'account_id');

            $result = $oGacl->add_object('ACCOUNTS', $aData['name'], $accountId, 0, 0, 'AXO');
            if (!$result) {
                $this->oUpgrade->oLogger->logError("Error while adding {$gaclGroup} {$sourceId} AXO");
                return new PEAR_Error();
            }

            if ($groupId) {
                $result = $oGacl->add_group_object($groupId, 'ACCOUNTS', $accountId, 'AXO');
                if (!$result) {
                    $this->oUpgrade->oLogger->logError("Error while adding {$gaclGroup} {$sourceId} to the accounts AXO group");
                    return new PEAR_Error();
                }
            }

            if ($gaclGroup == 'ADMIN') {
                // Create a new manager account
                $query = "
                    INSERT INTO {$tblAccounts} (
                        account_type
                    ) VALUES (
                        ".$oDbh->quote('MANAGER')."
                    )
                ";

                $result = $oDbh->exec($query);

                if (PEAR::isError($result)) {
                    $this->oUpgrade->oLogger->logError("Error while creating manager account for {$gaclGroup} {$sourceId}");
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
                    $this->oUpgrade->oLogger->logError("Error while creating default agency for {$gaclGroup} {$sourceId}");
                    return $result;
                }

                $agencyId = $oDbh->lastInsertID($prefix.'agency', 'agencyid');

                $result = $oGacl->add_object('ACCOUNTS', 'Default manager', $managerAccountId, 0, 0, 'AXO');
                if (!$result) {
                    $this->oUpgrade->oLogger->logError("Error while adding {$gaclGroup} {$sourceId} manager AXO");
                    return new PEAR_Error();
                }

        	    $managerGid = $oGacl->get_group_id("MANAGER_ACCOUNTS", null, 'AXO');

                if ($managerGid) {
                    $result = $oGacl->add_group_object($managerGid, 'ACCOUNTS', $managerAccountId, 'AXO');
                    if (!$result) {
                        $this->oUpgrade->oLogger->logError("Error while adding {$gaclGroup} {$sourceId} manager to the accounts AXO group");
                        return new PEAR_Error();
                    }
                }

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
                        $this->oUpgrade->oLogger->logError("Error while migrating {$entity} table for {$gaclGroup} {$sourceId}");
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
                    $this->oUpgrade->oLogger->logError("Error while updating entity {$gaclGroup} {$sourceId} with account details");
                    return $result;
                }
            }

            if (!empty($aData['username']) && !empty($aData['password'])) {
                $defaultAccountId = $gaclGroup == 'ADMIN' ? $managerAccountId : $accountId;

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
                    $this->oUpgrade->oLogger->logError("Error while creating user for {$gaclGroup} {$sourceId}");
                    return $result;
                }

                $userId = $oDbh->lastInsertID($prefix.'users', 'user_id');

                $result = $oGacl->add_object('USERS', $aData['contact_name'], $userId, 0, 0, 'ARO');
                if (!$result) {
                    $this->oUpgrade->oLogger->logError("Error while adding {$gaclGroup} {$sourceId} ARO");
                    return new PEAR_Error();
                }

                if ($gaclGroup == 'ADMIN') {
                    // Grant access to the admin AXO group
                    $result = $oGacl->add_acl(
                        array('ACCOUNT' => array('ACCESS')),
                        array('USERS' => array($userId)),
                        null,
                        null,
                        array('ACCOUNTS' => $groupId)
                    );
                    if (!$result) {
                        $this->oLogger->logError('error creating the admin ACL');
                        return false;
                    }
                } else {
                    // Grant access to the user
                    $aPermissions = array('ACCOUNT' => array('ACCESS'));

                    if (!empty($permissionMap)) {
                        foreach ($permissionMap as $k => $v) {
                            if ($aData['permissions'] & $k) {
                                if (!isset($aPermissions[$v[0]])) {
                                    $aPermissions[$v[0]] = array();
                                }
                                $aPermissions[$v[0]][] = $v[1];
                            }
                        }
                    }

                    // Create a single ACL
                    $result = $oGacl->add_acl(
                        $aPermissions,
                        array('USERS' => array($userId)),
                        null,
                        array('ACCOUNTS' => array($accountId))
                    );

                    if (!$result) {
                        $this->oUpgrade->oLogger->logError("Error creating ACL {$gaclGroup} {$sourceId}");
                        return new PEAR_Error();
                    }
                }
            }
	    }

        return true;
	}
}

?>