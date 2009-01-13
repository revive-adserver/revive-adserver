<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Permission.php';

/**
 * A class for managing users.
 *
 * @package    OpenXPermission
 */
class OA_Permission_User
{

    /**
     * @var array
     */
    var $aUser;

    /**
     * @var array
     */
    var $aAccount;

    /**
     * Class constructor
     *
     * @param DataObjects_Users $doUsers
     * @return OA_Permission_User
     */
    function OA_Permission_User($doUsers, $skipDatabaseAccess = false)
    {
        if (!is_a($doUsers, 'DataObjects_Users')) {
            MAX::raiseError('doUser not a DataObjects_Users');
        }

        // Store user information as array
        $this->aUser = $doUsers->toArray();

        // For safety reasons, do not store the password
        unset($this->aUser['password']);

        // Make sure we start with an empty account
        $this->_clearAccountData();

        if (!$skipDatabaseAccess) {
            // Check if the user is linked to the admin account
            $this->aUser['is_admin'] = $this->_isAdmin();
            $this->loadAccountData($this->aUser['default_account_id']);
        } else {
            $this->aUser['is_admin'] = false;
        }
    }

    function loadAccountData($accountId)
    {
        if (!empty($accountId))
        {
            $this->_clearAccountData();

            $doAccount = OA_Dal::factoryDO('accounts');
            $doAccount->account_id = $accountId;
            $doAccount->find();

            if ($doAccount->fetch()) {
                $this->aAccount = $doAccount->toArray() + $this->aAccount;

                if ($this->aAccount['account_type'] != OA_ACCOUNT_ADMIN) {
                    $this->aAccount['entity_id'] = $this->_getEntityId();

                    if (empty($this->aAccount['entity_id'])) {
                        Max::raiseError("No entity associated with the account");
                    }

                    if ($this->aAccount['account_type'] == OA_ACCOUNT_MANAGER) {
                        $this->aAccount['agency_id'] = $this->aAccount['entity_id'];
                    } else {
                        $this->aAccount['agency_id'] = $this->_getAgencyId();
                    }

                    if (empty($this->aAccount['agency_id'])) {
                        Max::raiseError("No manager associated with the account");
                    }
                }
            } else {
                Max::raiseError("Could not find the specified account");
            }
        }
    }

    /**
     * A private method to clear the $aAccount array
     *
     */
    function _clearAccountData()
    {
        $this->aAccount = array(
            'account_id'   => 0,
            'account_type' => '',
            'entity_id'    => 0,
            'agency_id'    => 0
        );
    }

    /**
     * A private method to retrieve the entity ID for the current account
     *
     * @return mixed The ID as integer on success, false otherwise
     */
    function _getEntityId()
    {
        $doEntity = $this->_getEntityDO();
        if (!empty($doEntity)) {
            $doEntity->account_id = $this->aAccount['account_id'];
            $doEntity->find();

            if ($doEntity->fetch()) {
                $key = $doEntity->getFirstPrimaryKey();

                return $doEntity->$key;
            }
        }

        return false;
    }

    /**
     * A private method to retrieve the agency ID for the current account
     *
     * @return mixed The ID as integer on success, false otherwise
     */
    function _getAgencyId()
    {
        $doEntity = $this->_getEntityDO();
        if (!empty($doEntity)) {
            $doEntity->account_id = $this->aAccount['account_id'];
            $doEntity->find();

            if ($doEntity->fetch()) {
                return $doEntity->agencyid;
            }
        }

        return false;
    }

    /**
     * A private method to check if the current user is linked to the admin account
     *
     * @return bool True if the user is linked to the admin account
     */
    function _isAdmin()
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->user_id = $this->aUser['user_id'];
        $doAUA  = OA_Dal::factoryDO('account_user_assoc');
        $doAUA->account_id = OA_Dal_ApplicationVariables::get('admin_account_id');
        $doUsers->joinAdd($doAUA);
        return (bool)$doUsers->count();
    }

    /**
     * Private factory method to create an entity dataobject based on account type
     *
     * @return DB_DataObjectCommon
     */
    function &_getEntityDO()
    {
        switch ($this->aAccount['account_type']) {
            case OA_ACCOUNT_MANAGER:
                $doEntity = OA_Dal::factoryDO('agency');
                break;
            case OA_ACCOUNT_ADVERTISER:
                $doEntity = OA_Dal::factoryDO('clients');
                break;
            case OA_ACCOUNT_TRAFFICKER:
                $doEntity = OA_Dal::factoryDO('affiliates');
                break;
            default:
                $doEntity = null;
                break;
        }

        return $doEntity;
    }
}

?>
