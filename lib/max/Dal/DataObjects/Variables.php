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
 * Table Definition for variables
 */
require_once 'DB_DataObjectCommon.php';
require_once 'Trackers.php';

class DataObjects_Variables extends DB_DataObjectCommon
{
    public $onDeleteCascade = true;
    public $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'variables';                       // table name
    public $variableid;                      // MEDIUMINT(9) => openads_mediumint => 129
    public $trackerid;                       // MEDIUMINT(9) => openads_mediumint => 129
    public $name;                            // VARCHAR(250) => openads_varchar => 130
    public $description;                     // VARCHAR(250) => openads_varchar => 2
    public $datatype;                        // ENUM('numeric','string','date') => openads_enum => 130
    public $purpose;                         // ENUM('basket_value','num_items','post_code') => openads_enum => 2
    public $reject_if_empty;                 // SMALLINT(1) => openads_smallint => 145
    public $is_unique;                       // INT(11) => openads_int => 129
    public $unique_window;                   // INT(11) => openads_int => 129
    public $variablecode;                    // VARCHAR(255) => openads_varchar => 130
    public $hidden;                          // ENUM('t','f') => openads_enum => 130
    public $updated;                         // DATETIME() => openads_datetime => 142

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Variables', $k, $v);
    }

    public $defaultValues = [
        'trackerid' => 0,
        'name' => '',
        'datatype' => 'numeric',
        'reject_if_empty' => 0,
        'is_unique' => 0,
        'unique_window' => 0,
        'variablecode' => '',
        'hidden' => 'f',
        'updated' => '%DATE_TIME%',
    ];

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    public function _auditEnabled()
    {
        return true;
    }

    public function _getContextId()
    {
        return $this->variableid;
    }

    public function _getContext()
    {
        return 'Variable';
    }

    /**
     * A method to return an array of account IDs of the account(s) that
     * should "own" any audit trail entries for this entity type; these
     * are NOT related to the account ID of the currently active account
     * (which is performing some kind of action on the entity), but is
     * instead related to the type of entity, and where in the account
     * heirrachy the entity is located.
     *
     * @return array An array containing up to three indexes:
     *                  - "OA_ACCOUNT_ADMIN" or "OA_ACCOUNT_MANAGER":
     *                      Contains the account ID of the manager account
     *                      that needs to be able to see the audit trail
     *                      entry, or, the admin account, if the entity
     *                      is a special case where only the admin account
     *                      should see the entry.
     *                  - "OA_ACCOUNT_ADVERTISER":
     *                      Contains the account ID of the advertiser account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     *                  - "OA_ACCOUNT_TRAFFICKER":
     *                      Contains the account ID of the trafficker account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     */
    public function getOwningAccountIds($resetCache = false)
    {
        // Variables don't have an account_id, get it from the
        // parent tracker (stored in the "trackers" table) using
        // the "trackerid" key
        return $this->_getOwningAccountIds('trackers', 'trackerid');
    }

    /**
     * build a variable specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    public function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc'] = $this->name;
    }

    /**
     * Sets the variablecode value based on a given tracker variable method.
     *
     * @param string $variableMethod
     */
    public function setCode($variableMethod)
    {
        $variableCode = '';
        switch ($variableMethod) {
            case DataObjects_Trackers::TRACKER_VARIABLE_METHOD_JS:
                $variableCode = "var {$this->name} = \\'%%" . strtoupper($this->name) . "_VALUE%%\\'";
                break;
            case DataObjects_Trackers::TRACKER_VARIABLE_METHOD_DOM:
                $variableCode = '';
                break;
            case DataObjects_Trackers::TRACKER_VARIABLE_METHOD_CUSTOM:
                $variableCode = "var {$this->name} = \\'" . $this->variablecode . "\\'";
                break;
            default:
                $variableCode = "var {$this->name} = escape(\\'%%" . strtoupper($this->name) . "_VALUE%%\\')";
                break;
        }
        $this->variablecode = $variableCode;
    }
}
