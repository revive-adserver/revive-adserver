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
 * Table Definition for ext_market_campaign_pref
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_market_campaign_pref extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_market_campaign_pref';       // table name
    public $campaignid;                      // MEDIUMINT(9) => openads_mediumint => 129
    public $is_enabled;                      // SMALLINT(1) => openads_smallint => 17
    public $floor_price;                     // DECIMAL(10,4) => openads_decimal => 1

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_campaign_pref',$k,$v); }

    var $defaultValues = array(
                'campaignid' => 0,
                'is_enabled' => 0,
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
     * Updates campaign's market opt in status to the given one.
     * 
     * @param int $campaignId 
     * @param boolean $optedIn indicates whether this campaign has market enabled
     * @param float $floorPrice campaigns floor price
     */
    function updateCampaignStatus($campaignId, $optedIn, $floorPrice)
    {
        $oExt_market_campaign_pref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $oExt_market_campaign_pref->campaignid = $campaignId;
        $recordExist = false;
        if ($oExt_market_campaign_pref->find()) {
            $oExt_market_campaign_pref->fetch();
            $recordExist = true;
        }
        $oExt_market_campaign_pref->is_enabled = $optedIn == true ? 1 : 0;
        $oExt_market_campaign_pref->floor_price = $floorPrice;
        if ($recordExist) {
            $oExt_market_campaign_pref->update();
        } 
        else {
            $oExt_market_campaign_pref->insert();
        }
        
        return $oExt_market_campaign_pref;
    }
}
?>