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

/**
 * Table Definition for clients (Client is often called Advertiser)
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Clients extends DB_DataObjectCommon
{
    public $onDeleteCascade = true;
    public $dalModelName = 'Clients';
    public $usernameField = 'clientusername';
    public $passwordField = 'clientpassword';
    public $refreshUpdatedFieldIfExists = true;

    /**
     * Defines advertisers types
     */
    public const ADVERTISER_TYPE_DEFAULT = 0;
    public const ADVERTISER_TYPE_MARKET = 1;

    /**
     * BC-compatible user details
     *
     * @todo Please remove later
     */
    public $clientusername;
    public $clientpassword;

    /**
     * Autogenerated
     */
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
    public $account_id;                      // MEDIUMINT(9) => openads_mediumint => 1
    public $advertiser_limitation;           // TINYINT(1) => openads_tinyint => 145
    public $type;                            // TINYINT(4) => openads_tinyint => 129

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Clients', $k, $v);
    }

    public $defaultValues = [
        'agencyid' => 0,
        'clientname' => '',
        'email' => '',
        'report' => 'f',
        'reportinterval' => 7,
        'reportlastdate' => '%NO_DATE_TIME%',
        'reportdeactivate' => 'f',
        'updated' => '%DATE_TIME%',
        'advertiser_limitation' => 0,
        'type' => 0,
    ];

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Returns clientid.
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->clientid;
    }

    public function _auditEnabled()
    {
        return true;
    }

    public function _getContextId()
    {
        return $this->clientid;
    }

    public function _getContext()
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
    public function getOwningManagerId()
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
    public function insert()
    {
        // Create account first
        $result = $this->createAccount(OA_ACCOUNT_ADVERTISER, $this->clientname);
        if (!$result) {
            return $result;
        }

        // Store data to create a user
        if (!empty($this->clientusername) && !empty($this->clientpassword)) {
            $aUser = [
                'contact_name' => $this->contact,
                'email_address' => $this->email,
                'username' => $this->clientusername,
                'password' => $this->clientpassword,
                'default_account_id' => $this->account_id,
            ];
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
    public function update($dataObject = false)
    {
        // Store data to create a user
        if (!empty($this->clientusername) && !empty($this->clientpassword)) {
            $aUser = [
                'contact_name' => $this->contact,
                'email_address' => $this->email,
                'username' => $this->clientusername,
                'password' => $this->clientpassword,
                'default_account_id' => $this->account_id,
            ];
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
    public function delete($useWhere = false, $cascade = true, $parentid = null)
    {
        $result = parent::delete($useWhere, $cascade, $parentid);
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
    public function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc'] = $this->clientname;
    }
}
