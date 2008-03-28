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
 * Table Definition for audit
 */

define('OA_AUDIT_ACTION_INSERT',1);
define('OA_AUDIT_ACTION_UPDATE',2);
define('OA_AUDIT_ACTION_DELETE',3);

require_once 'DB_DataObjectCommon.php';

class DataObjects_Audit extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'audit';                           // table name
    var $auditid;                         // int(9)  not_null primary_key auto_increment
    var $actionid;                        // int(9)  not_null
    var $context;                         // string(255)  not_null multiple_key
    var $contextid;                       // int(9)  
    var $parentid;                        // int(9)  multiple_key
    var $details;                         // blob(65535)  not_null blob
    var $userid;                          // int(9)  not_null
    var $username;                        // string(64)  multiple_key
    var $usertype;                        // int(4)  not_null multiple_key
    var $updated;                         // datetime(19)  multiple_key binary
    var $account_id;                      // int(9)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Audit',$k,$v); }

    var $defaultValues = array(
                'userid' => 0,
                'usertype' => 0,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    /**
     * The belongsToAccount() method behaves in a different way
     * in "audit" table case. To check if user has access
     * to view specific audit we need to check if user has access
     * to a audited object.
     *
     * @param string $accountId Account id
     * @param boolean $checkPermission Check if user has access to account in which a permission was logged
     * @return boolean|null     Returns true if belong to account, false if doesn't and null if it wasn't
     *                          able to find object in references
     */
    function belongsToAccount($accountId = null, $checkPermission = true)
    {
        if (!$this->N) {
            $key = $this->getFirstPrimaryKey();
            if (empty($this->$key)) {
                MAX::raiseError('Key on object is not set, table: '.$this->getTableWithoutPrefix());
                return null;
            }
            if (!$this->find($autoFetch = true)) {
                return null;
            }
        }
        if ($checkPermission && OA_Permission::hasAccess($this->account_id)) {
            return true;
        }
        $doAuditedObject = OA_Dal::staticGetDO($this->context,
            $this->contextid);
        if ($doAuditedObject) {
            return $doAuditedObject->belongsToAccount($accountId);
        }
        MAX::raiseError('Record do not exist, table ' . $this->context
            . ', id: ' . $this->contextid);
        return false;
    }
}
