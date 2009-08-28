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
 * Table Definition for variables
 */
require_once 'DB_DataObjectCommon.php';
require_once 'Trackers.php';

class DataObjects_Variables extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    var $refreshUpdatedFieldIfExists = true;
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
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Variables',$k,$v); }

    var $defaultValues = array(
                'trackerid' => 0,
                'name' => '',
                'datatype' => 'numeric',
                'reject_if_empty' => 0,
                'is_unique' => 0,
                'unique_window' => 0,
                'variablecode' => '',
                'hidden' => 'f',
                'updated' => '%DATE_TIME%',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->variableid;
    }

    function _getContext()
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
    function getOwningAccountIds()
    {
        // Variables don't have an account_id, get it from the
        // parent tracker (stored in the "trackers" table) using
        // the "trackerid" key
        return parent::getOwningAccountIds('trackers', 'trackerid');
    }

    /**
     * build a variable specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']   = $this->name;
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
                $variableCode = "var {$this->name} = \\'%%".strtoupper($this->name)."_VALUE%%\\'";
                break;
            case DataObjects_Trackers::TRACKER_VARIABLE_METHOD_DOM:
                $variableCode = '';
                break;
            case DataObjects_Trackers::TRACKER_VARIABLE_METHOD_CUSTOM:
                $variableCode = "var {$this->name} = \\'".$this->variablecode."\\'";
                break;
            default:
                $variableCode = "var {$this->name} = escape(\\'%%".strtoupper($this->name)."_VALUE%%\\')";
                break;
        }
        $this->variablecode = $variableCode;
    }

}

?>