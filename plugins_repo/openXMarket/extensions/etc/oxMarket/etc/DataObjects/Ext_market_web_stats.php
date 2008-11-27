<?php
/**
 * Table Definition for ext_market_web_stats
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_market_web_stats extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_market_web_stats';            // table name
    public $p_website_id;                    // CHAR(36) => openads_char => 130 
    public $impressions;                     // INT(10) => openads_int => 129 
    public $day_time;                        // DATETIME() => openads_datetime => 14 
    public $revenue;                         // DECIMAL(10,4) => openads_decimal => 1 
    public $ecpm;                            // DECIMAL(10,4) => openads_decimal => 1 
    public $width;                           // SMALLINT(6) => openads_smallint => 1 
    public $height;                          // SMALLINT(6) => openads_smallint => 1 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_web_stats',$k,$v); }

    var $defaultValues = array(
                'p_website_id' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function getWebsiteStatsByAgencyId($aOption)
    {
        //TODO change to use new object
        $tableName = $this->tableName();
        $orderDir = ($aOption['orderdirection'] == 'down') ? 'DESC' : 'ASC';
        if (empty($aOption['listorder'])) {
            $orderClause = 'name';
        } else {
            $orderClause = ($aOption['listorder'] == 'name') ? 'name' : $aOption['listorder'];
        }
        $orderClause .= " $orderDir";


        //$oAffiliate = & OA_Dal::factoryDO('affiliates');

        //$oWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');
        //$oWebsitePref->joinAdd($oAffiliate, 'INNER', 'affiliates');

        //$oAccountMapping = & OA_Dal::factoryDO('ext_market_account_mapping');
        //$oAccountMapping->agencyid = OA_Permission::getAgencyId();

        $this->selectAdd();
        $this->selectAdd('p_website_id AS id');
        $this->selectAdd('CONCAT(\'test\',p_website_id) AS name');
        $this->selectAdd('SUM(impressions) AS impressions');
        $this->selectAdd('SUM(revenue) AS revenue');
        $this->selectAdd('FORMAT(SUM(revenue) * 1000 / SUM(impressions), 2) AS ecpm');
        //$this->joinAdd($oAccountMapping);
        //$this->joinAdd($oWebsitePref);
//        if (!empty($aOption['period_start']) && !empty($aOption['period_end'])) {
//            $this->whereAdd("$tableName.day_time >= '{$aOption['period_start']}' AND $tableName.day_time <= '{$aOption['period_end']}'");
//        } else if (!empty($aOption['period_start']) || !empty($aOption['period_end'])) {
//            $date = (!empty($aOption['period_start'])) ? $aOption['period_start'] : $aOption['period_end'];
//            $this->whereAdd("$tableName.day_time = '$date'");
//        }
        $this->groupBy('p_website_id');
        if (!empty($orderClause)) {
            $this->orderBy($orderClause);
        }
        $this->find();
        while ($this->fetch()) {
            $aResult[] = $this->toArray();
        }

        return $aResult;
    }
    

    function getSizeStatsByAffiliateId($aOption)
    {
		//TODO change to use new object
        $tableName = $this->tableName();
        $orderDir = ($aOption['orderdirection'] == 'down') ? 'DESC' : 'ASC';
        if (empty($aOption['listorder'])) {
            $orderClause = 'width, height';
        } else {
            $orderClause = ($aOption['listorder'] == 'name') ? 'width, height' : $aOption['listorder'];
        }
        $orderClause .= " $orderDir";

        //$oAdSize = & OA_Dal::factoryDO('ext_market_ad_size');
        //$oWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');

        $this->selectAdd();
        $this->selectAdd('CONCAT(width,height) AS name');
        $this->selectAdd('width AS width');
        $this->selectAdd('height AS height');
        $this->selectAdd('SUM(impressions) AS impressions');
        $this->selectAdd('SUM(revenue) AS revenue');
        $this->selectAdd('FORMAT(SUM(revenue) * 1000 / SUM(impressions), 2) AS ecpm');
        //$this->joinAdd($oWebsitePref);
        $this->whereAdd("p_website_id = {$aOption['affiliateid']}");
        //$this->whereAdd($oWebsitePref->tableName() .".affiliateid = {$aOption['affiliateid']}");
//        if (!empty($aOption['period_start']) && !empty($aOption['period_end'])) {
//            $this->whereAdd("$tableName.day >= '{$aOption['period_start']}' AND $tableName.day <= '{$aOption['period_end']}'");
//        } else if (!empty($aOption['period_start']) || !empty($aOption['period_end'])) {
//            $date = (!empty($aOption['period_start'])) ? $aOption['period_start'] : $aOption['period_end'];
//            $this->whereAdd("$tableName.day = '$date'");
//        }
        $this->groupBy($tableName.'.width, '.$tableName.'.height');
        if (!empty($orderClause)) {
            $this->orderBy($orderClause);
        }
        $this->find();
        while ($this->fetch()) {
            $aResult[] = $this->toArray();
        }

        return $aResult;
    }
}
?>