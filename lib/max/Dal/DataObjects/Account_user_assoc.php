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
 * Table Definition for account_user_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Account_user_assoc extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'account_user_assoc';              // table name
    public $account_id;                      // MEDIUMINT(9) => openads_mediumint => 129
    public $user_id;                         // MEDIUMINT(9) => openads_mediumint => 129
    public $linked;                          // DATETIME() => openads_datetime => 142

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Account_user_assoc',$k,$v); }

    var $defaultValues = array(
                'linked' => '%NO_DATE_TIME%',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function insert()
    {
        $this->linked = date('Y-m-d H:i:s');
        return parent::insert();
    }

    function delete($useWhere = false, $cascadeDelete = true, $parentid = null)
    {
        // delete also all permissions linked to this account/user
        $doAccount_user_permission_assoc = OA_Dal::factoryDO('account_user_permission_assoc');
        $doAccount_user_permission_assoc->user_id = $this->user_id;
        $doAccount_user_permission_assoc->account_id = $this->account_id;
        if ($useWhere)
        {
            $doAccount_user_permission_assoc->_query['condition'] = $this->_query['condition'];
        }
        $doAccount_user_permission_assoc->delete($useWhere, false, $parentid);

        return parent::delete($useWhere, $cascadeDelete, $parentid);
    }

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return 0;
    }

    function _getContext()
    {
        return 'Account User Association';
    }

    /**
     * build an accounts specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = 'Account #'.$this->account_id.' -> User #'.$this->user_id;
    }
}
