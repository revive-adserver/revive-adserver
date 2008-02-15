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
 * Table Definition for variables
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Variables extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    var $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'variables';                       // table name
    var $variableid;                      // int(9)  not_null primary_key unsigned auto_increment
    var $trackerid;                       // int(9)  not_null multiple_key
    var $name;                            // string(250)  not_null
    var $description;                     // string(250)
    var $datatype;                        // string(7)  not_null enum
    var $purpose;                         // string(12)  enum
    var $reject_if_empty;                 // int(1)  not_null unsigned
    var $is_unique;                       // int(11)  not_null multiple_key
    var $unique_window;                   // int(11)  not_null
    var $variablecode;                    // string(255)  not_null
    var $hidden;                          // string(1)  not_null enum
    var $updated;                         // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Variables',$k,$v); }

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
     * A private method to return the account ID of the
     * account that should "own" audit trail entries for
     * this entity type; NOT related to the account ID
     * of the currently active account performing an
     * action.
     *
     * @return integer The account ID to insert into the
     *                 "account_id" column of the audit trail
     *                 database table.
     */
    function getOwningAccountId()
    {
        return $this->_getOwningAccountIdFromParent('trackers', 'trackerid');
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
        switch ($actionid)
        {
            case OA_AUDIT_ACTION_INSERT:
            case OA_AUDIT_ACTION_DELETE:
                        $aAuditFields['hidden']    = $this->_formatValue('hidden');
                        break;
            case OA_AUDIT_ACTION_UPDATE:
                        break;
        }
    }

    function _formatValue($field)
    {
        switch ($field)
        {
            case 'hidden':
                return $this->_boolToStr($this->$field);
            default:
                return $this->$field;
        }
    }
}

?>