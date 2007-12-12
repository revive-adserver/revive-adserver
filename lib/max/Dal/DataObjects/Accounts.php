<?php
/**
 * Table Definition for accounts
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Accounts extends DB_DataObjectCommon
{
    var $__accountName;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'accounts';                        // table name
    var $account_id;                      // int(9)  not_null primary_key auto_increment
    var $account_type;                    // string(16)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Accounts',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Handle all necessary operations when new account is created
     *
     * @see DB_DataObject::insert()
     */
    function insert()
    {
        $accountId = parent::insert();

        if (!empty($accountId)) {
            require_once MAX_PATH . '/lib/OA/Permission/Gacl.php';

            if (empty($this->__accountName)) {
                $this->__accountName = 'Unnamed account';
            }

            // Create GACL AXO
            $oGacl = &OA_Permission_Gacl::factory();
            if (!$oGacl->add_object('ACCOUNTS', $this->__accountName, $accountId, 0, 0, 'AXO')) {
                OA::debug('Error creating the gacl accounts AXO entry', PEAR_LOG_ERROR);
            } else {
                // Assign the AXO to a group, if any
                $groupName = "{$this->account_type}_ACCOUNTS";
                $groupId = $oGacl->get_group_id($groupName, null, 'AXO');
                if (!empty($groupId)) {
                    if (!$oGacl->add_group_object($groupId, 'ACCOUNTS', $accountId, 'AXO')) {
                        OA::debug('Error assigning the gacl accounts AXO entry to its group', PEAR_LOG_ERROR);
                    }
                }
            }
        }

        return $accountId;
    }

    /**
     * Handle all necessary operations when an account is deleted
     *
     * @see DB_DataObject::delete()
     */
    function delete($useWhere = false, $cascade = true, $parentid = null)
    {
        $ret = parent::delete($useWhere, $cascade, $parentid);

        if ($ret) {
            $oGacl = OA_Permission_Gacl::factory();
            $acoId = $oGacl->get_object_id('ACCOUNTS', $this->account_id, 'AXO');
            if ($acoId) {
                $oGacl->del_object($acoId, 'AXO', true);
            }
        }

        return $ret;
    }

}
