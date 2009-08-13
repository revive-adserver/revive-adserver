<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
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

    public $__table = 'clients';                         // table name
    public $clientid;                        // MEDIUMINT(9) => openads_mediumint => 129 
    public $agencyid;                        // MEDIUMINT(9) => openads_mediumint => 129 
    public $clientname;                      // VARCHAR(255) => openads_varchar => 130 
    public $contact;                         // VARCHAR(255) => openads_varchar => 2 
    public $email;                           // VARCHAR(64) => openads_varchar => 130 
    public $report;                          // ENUM('t','f') => openads_enum => 130 
    public $reportinterval;                  // MEDIUMINT(9) => openads_mediumint => 129 
    public $reportlastdate;                  // DATE() => openads_date => 134 
    public $reportdeactivate;                // ENUM('t','f') => openads_enum => 130 
    public $comments;                        // TEXT() => openads_text => 34 
    public $updated;                         // DATETIME() => openads_datetime => 142 
    public $an_adnetwork_id;                 // INT(11) => openads_int => 1 
    public $as_advertiser_id;                // INT(11) => openads_int => 1 
    public $account_id;                      // MEDIUMINT(9) => openads_mediumint => 1 
    public $advertiser_limitation;           // TINYINT(1) => openads_tinyint => 145 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Clients',$k,$v); }

    var $defaultValues = array(
                'agencyid' => 0,
                'clientname' => '',
                'email' => '',
                'report' => 't',
                'reportinterval' => 7,
                'reportlastdate' => '%NO_DATE_TIME%',
                'reportdeactivate' => 't',
                'updated' => '%DATE_TIME%',
                'advertiser_limitation' => 0,
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
     * A method to return the ID of the manager account
     * that "owns" this advertiser account.
     *
     * @return integer The account ID of the "owning"
     *                 manager account. Returns the
     *                 admin account ID if no owning
     *                 manager account can be found.
     */
    function getOwningManagerId()
    {
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->agencyid = $this->agencyid;
        $doAgency->find();
        if ($doAgency->getRowCount() == 1) {
            $doAgency->fetch();
            return $doAgency->account_id;
        } else {
            // Could not find the owning manager
            // account ID, return the ID of the
            // admin account instead
            return OA_Dal_ApplicationVariables::get('admin_account_id');
        }
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
