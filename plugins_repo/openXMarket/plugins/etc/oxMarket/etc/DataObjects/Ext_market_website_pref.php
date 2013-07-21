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
 * Table Definition for ext_market_website_pref
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';
require_once MAX_PATH.'/lib/max/Dal/DataObjects/Accounts.php';

class DataObjects_Ext_market_website_pref extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_market_website_pref';         // table name
    public $affiliateid;                     // MEDIUMINT(9) => openads_mediumint => 129
    public $website_id;                      // CHAR(36) => openads_char => 130
    public $is_url_synchronized;             // ENUM('t','f') => openads_enum => 2

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_website_pref',$k,$v); }

    var $defaultValues = array(
                'affiliateid' => 0,
                'website_id' => '',
                'is_url_synchronized' => 't',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Table has no autoincrement/sequence so we override sequenceKey().
     *
     * @return array
     */
    function sequenceKey() {
        return array(false, false, false);
    }

    function _auditEnabled()
    {
        return false;
    }
    
    /**
     * Get array of website_id stored in database 
     *
     * @param int $accountId manager or admin account (for admin account all websites are returned)
     * @return array of strings (website Ids)
     */
    function getRegisteredWebsitesIds($accountId)
    {
        if (isset($accountId) && 
            (int)$accountId !== (int)DataObjects_Accounts::getAdminAccountId())
        {
            $agency = OA_Dal::factoryDO('agency');
            $agency->account_id = $accountId;
            $affiliates = OA_Dal::factoryDO('affiliates');
            $affiliates->joinAdd($agency);
            $this->joinAdd($affiliates);
        }
        $this->selectAdd();
        $this->selectAdd('website_id');
        return $this->getAll();
    }
}
?>
