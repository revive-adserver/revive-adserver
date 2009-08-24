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
$Id: demoUI-page.php 30820 2009-01-13 19:02:17Z andrew.hill $
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