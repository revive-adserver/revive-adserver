<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
 * @package    OpenadsPermission
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
    function OA_Permission_User($doUsers)
    {
        if (!is_a($doUsers, 'DataObjects_Users')) {
            MAX::raiseError('doUser not a DataObjects_Users', PEAR_LOG_ERR, PEAR_ERROR_DIE);
        }
        $this->aUser = $doUsers->toArray();

        // For safety reasons, do not store the password
        unset($this->aUser['password']);

        // Make sure we start with an empty account
        $this->_clearAccount();

        $this->switchAccount($doUsers->default_account_id);
    }

    function switchAccount($accountId)
    {
        if (!empty($accountId)) {
            $this->_clearAccount();

            $doAccount = OA_Dal::factoryDO('accounts');
            $doAccount->account_id = $accountId;
            $doAccount->find();

            if ($doAccount->fetch()) {
                $this->aAccount = $doAccount->toArray() + $this->aAccount;

                if ($this->aAccount['account_type'] != OA_ACCOUNT_ADMIN) {
                    $this->aAccount['entity_id'] = $this->_getEntityId();

                    if ($this->aAccount['account_type'] == OA_ACCOUNT_MANAGER) {
                        $this->aAccount['agency_id'] = $this->aAccount['entity_id'];
                    } else {
                        $this->aAccount['agency_id'] = $this->_getAgencyId();
                    }
                }
            }
        }
    }

    function _clearAccount()
    {
        $this->aAccount = array(
            'account_id'   => 0,
            'account_type' => '',
            'entity_id'    => 0,
            'agency_id'    => 0
        );
    }

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

        return 0;
    }

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

        return 0;
    }

    /**
     * Factory account dataobject based on account type
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