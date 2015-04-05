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
 * Table Definition for agency
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Agency extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    var $refreshUpdatedFieldIfExists = true;

    /**
     * BC-compatible user details
     *
     * @todo Please remove later
     */
    var $username;
    var $password;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'agency';                          // table name
    public $agencyid;                        // MEDIUMINT(9) => openads_mediumint => 129 
    public $name;                            // VARCHAR(255) => openads_varchar => 130 
    public $contact;                         // VARCHAR(255) => openads_varchar => 2 
    public $email;                           // VARCHAR(64) => openads_varchar => 130 
    public $logout_url;                      // VARCHAR(255) => openads_varchar => 2 
    public $active;                          // SMALLINT(1) => openads_smallint => 17 
    public $updated;                         // DATETIME() => openads_datetime => 142 
    public $account_id;                      // MEDIUMINT(9) => openads_mediumint => 1 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Agency',$k,$v); }

    var $defaultValues = array(
                'name' => '',
                'email' => '',
                'active' => 0,
                'updated' => '%DATE_TIME%',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Handle all necessary operations when new agency is created
     *
     * @see DB_DataObject::insert()
     */
    function insert()
    {
        // Create account first
        $result = $this->createAccount(OA_ACCOUNT_MANAGER, $this->name);
        if (!$result) {
            return $result;
        }

        // Store data to create a user
        if (!empty($this->username) && !empty($this->password)) {
            $aUser = array(
                'contact_name' => $this->contact,
                'email_address' => $this->email,
                'username' => $this->username,
                'password' => $this->password,
                'default_account_id' => $this->account_id
            );
        }

        $agencyid = parent::insert();
        if (!$agencyid) {
            return $agencyid;
        }

        // Create user if needed
        // Is this even required anymore?
        if (!empty($aUser)) {
            $this->createUser($aUser);
        }

        // Execute any components which have registered at the afterAgencyCreate hook
        $aPlugins = OX_Component::getListOfRegisteredComponentsForHook('afterAgencyCreate');
        foreach ($aPlugins as $i => $id) {
            if ($obj = OX_Component::factoryByComponentIdentifier($id)) {
                $obj->afterAgencyCreate($agencyid);
            }
        }
        
        return $agencyid;
    }

    /**
     * Handle all necessary operations when an agency is updated
     *
     * @see DB_DataObject::update()
     */
    function update($dataObject = false)
    {
        // Store data to create a user
        if (!empty($this->username) && !empty($this->password)) {
            $aUser = array(
                'contact_name' => $this->contact,
                'email_address' => $this->email,
                'username' => $this->username,
                'password' => $this->password,
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

        $this->updateAccountName($this->name);

        return $ret;
    }

    /**
     * Handle all necessary operations when an agency is deleted
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
     * Returns agencyid.
     *
     * @return string
     */
    function getUserId()
    {
        return $this->agencyid;
    }

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->agencyid;
    }

    function _getContext()
    {
        return 'Agency';
    }

    /**
     * build an agency specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = $this->name;
    }

    function agencyExists($agencyName)
    {
        $this->name = $agencyName;
        return (bool)$this->count();
    }

    function belongsToAccount($accountId = null)
    {
        // Set the account ID, if not passed in
        if (empty($accountId)) {
            $accountId = OA_Permission::getAccountId();
        }

        $result = parent::belongsToAccount($accountId);

        if (!$result) {
            $doAccounts = OA_Dal::staticGetDO('accounts', $accountId);
            $result = $doAccounts->account_type == OA_ACCOUNT_ADMIN;
        }

        return $result;
    }
}

?>
