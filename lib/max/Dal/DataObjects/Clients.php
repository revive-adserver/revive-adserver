<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

/**
 * Table Definition for clients (Client is often called Advertiser)
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Clients extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    var $dalModelName = 'Clients';
    var $usernameField = 'clientusername';
    var $passwordField = 'clientpassword';
    var $refreshUpdatedFieldIfExists = true;

    /**
     * BC-compatible user details
     *
     * @todo Please remove later
     */
    var $clientusername;
    var $clientpassword;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'clients';                         // table name
    var $clientid;                        // int(9)  not_null primary_key auto_increment
    var $agencyid;                        // int(9)  not_null multiple_key
    var $clientname;                      // string(255)  not_null
    var $contact;                         // string(255)  
    var $email;                           // string(64)  not_null
    var $report;                          // string(1)  not_null enum
    var $reportinterval;                  // int(9)  not_null
    var $reportlastdate;                  // date(10)  not_null binary
    var $reportdeactivate;                // string(1)  not_null enum
    var $comments;                        // blob(65535)  blob
    var $updated;                         // datetime(19)  not_null binary
    var $lb_reporting;                    // int(1)  not_null
    var $an_adnetwork_id;                 // int(11)  
    var $as_advertiser_id;                // int(11)  
    var $account_id;                      // int(9)  unique_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Clients',$k,$v); }

    var $defaultValues = array(
                'agencyid' => 0,
                'report' => 't',
                'reportinterval' => 7,
                'reportlastdate' => '%NO_DATE_TIME%',
                'reportdeactivate' => 't',
                'lb_reporting' => 0,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Returns clientid.
     *
     * @return string
     */
    function getUserId()
    {
        return $this->clientid;
    }

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->clientid;
    }

    function _getContext()
    {
        return 'Client';
    }

    /**
     * A private method to return the account ID of the
     * account that should "own" audit trail entries for
     * this entity type; NOT related to the account ID
     * of the currently active account performing an
     * action.
     *
     * @return int The account ID to insert into the
     *             "account_id" column of the audit trail
     *             database table
     */
    function getOwningAccountId()
    {
        return $this->_getOwningAccountIdFromParent('agency', 'agencyid', $allAccounts);
    }

    /**
     * A private method to return all the account IDs of the
     * accounts that own the entity
     *
     * @return array An array containing all the account IDs
     */
    function getAllOwningAccountIds()
    {
        return array($this->getOwningAccountId(), parent::getOwningAccountId());
    }

    /**
     * Handle all necessary operations when new advertiser is created
     *
     * @see DB_DataObject::insert()
     */
    function insert()
    {
        // Create account first
        $result = $this->createAccount(OA_ACCOUNT_ADVERTISER, $this->clientname);
        if (!$result) {
            return $result;
        }

        // Store data to create a user
        if (!empty($this->clientusername) && !empty($this->clientpassword)) {
            $aUser = array(
                'contact_name' => $this->contact,
                'email_address' => $this->email,
                'username' => $this->clientusername,
                'password' => $this->clientpassword,
                'default_account_id' => $this->account_id
            );
        }

        $clientId = parent::insert();
        if (!$clientId) {
            return $clientId;
        }

        // Create user if needed
        if (!empty($aUser)) {
            $this->createUser($aUser);
        }

        return $clientId;
    }

    /**
     * Handle all necessary operations when an advertiser is updated
     *
     * @see DB_DataObject::update()
     */
    function update($dataObject = false)
    {
        // Store data to create a user
        if (!empty($this->clientusername) && !empty($this->clientpassword)) {
            $aUser = array(
                'contact_name' => $this->contact,
                'email_address' => $this->email,
                'username' => $this->clientusername,
                'password' => $this->clientpassword,
                'default_account_id' => $this->account_id
            );
        }

        $ret = parent::update($dataObject);
        if (!$ret) {
            return $ret;
        }

        // Create user if needed
        if (!empty($aUser)) {
            $this->createUser($aUser);
        }

        $this->updateAccountName($this->clientname);

        return $ret;
    }

    /**
     * Handle all necessary operations when an advertiser is deleted
     *
     * @see DB_DataObject::delete()
     */
    function delete($useWhere = false, $cascade = true, $parentid = null)
    {
        $result =  parent::delete($useWhere, $cascade, $parentid);
        if ($result) {
            $this->deleteAccount();
        }

        return $result;
    }

    /**
     * build a client specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']   = $this->clientname;
    }

}

?>
