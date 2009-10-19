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
    public $date_time;                        // DATETIME() => openads_datetime => 14
    public $revenue;                         // DECIMAL(10,4) => openads_decimal => 1
    public $width;                           // SMALLINT(6) => openads_smallint => 1
    public $height;                          // SMALLINT(6) => openads_smallint => 1

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_market_web_stats',$k,$v); }

    var $defaultValues = array(
                'p_website_id' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Returns array of websites summary statistics
     *
     * aOption:
     *  - orderdirection  - order direction 'up' or 'down'
     *  - listorder       - colum name to order by
     *  - period_preset   - special defined periods (e.g. all_stats)
     *  - period_start    - start date of period (Y-m-d php date function format)
     *  - period_end      - end date of period (Y-m-d php date function format)
     *
     * @param array $aOption
     * @return array DB rows with statistics data
     */
    function getWebsiteStatsByAgencyId($aOption)
    {
        if (!$this->checkDate($aOption['period_start']) ||
            !$this->checkDate($aOption['period_end'])) {
            return array();
        }
        $tableName = $this->tableName();
        $orderDir = ($aOption['orderdirection'] == 'down') ? 'DESC' : 'ASC';
        $aOrderOptions = array ('name', 'impressions', 'revenue', 'ecpm' );
        if (empty($aOption['listorder']) ||
            !in_array($aOption['listorder'],$aOrderOptions)) {
            $orderClause = 'name';
        } else {
            $orderClause = $aOption['listorder'];
        }
        $orderClause .= " $orderDir";

        $oAffiliate = & OA_Dal::factoryDO('affiliates');

        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $oAffiliate->agencyid = OA_Permission::getAgencyId();
        }
        elseif (!OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            // shouldn't be here
            return array();
        }

        $oWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');
        $oWebsitePref->joinAdd($oAffiliate, 'INNER', 'affiliates');

        $this->selectAdd();
        $this->selectAdd('affiliates.affiliateid AS id');
        $this->selectAdd('affiliates.name AS name');
        $this->selectAdd('SUM(impressions) AS impressions');
        $this->selectAdd('SUM(revenue) AS revenue');
        $this->selectAdd('(SUM(revenue) * 1000 / SUM(impressions)) AS ecpm');
        $this->joinAdd($oWebsitePref);

        $this->addDateTimeLimitation($aOption);

        $this->groupBy('affiliates.affiliateid, affiliates.name');
        if (!empty($orderClause)) {
            $this->orderBy($orderClause);
        }
        $this->find();
        $aResult = array();
        while ($this->fetch()) {
            $aResult[] = $this->toArray();
        }

        return $aResult;
    }


    /**
     * Returns array of summary statistics grouped by banner size for given website
     *
     * aOption:
     *  - orderdirection  - order direction 'up' or 'down'
     *  - listorder       - colum name to order by
     *  - affiliateid     - affiliate id
     *  - period_preset   - special defined periods (e.g. all_stats)
     *  - period_start    - start date of period (Y-m-d php date function format)
     *  - period_end      - end date of period (Y-m-d php date function format)
     *
     * @param array $aOption
     * @return array DB rows with statistics data
     */
    function getSizeStatsByAffiliateId($aOption)
    {
        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            if (empty($aOption['affiliateid']) || !OA_Permission::hasAccessToObject('affiliates', $aOption['affiliateid'])) {
                return array();
            }
        }
        if (!$this->checkDate($aOption['period_start']) ||
            !$this->checkDate($aOption['period_end'])) {
            return array();
        }

        $tableName = $this->tableName();
        $orderDir = ($aOption['orderdirection'] == 'down') ? 'DESC' : 'ASC';
        $aOrderOptions = array ('name', 'impressions', 'revenue', 'ecpm' );
        if (empty($aOption['listorder']) ||
            !in_array($aOption['listorder'],$aOrderOptions)) {
            $orderClause = 'width, height';
        } else {
            $orderClause = ($aOption['listorder'] == 'name') ? 'width, height' : $aOption['listorder'];
        }
        $orderClause .= " $orderDir";

        $oWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');

        $this->selectAdd();
        //$this->selectAdd('concat(width,\'x\'height) AS name'); not compatible with postgres
        $this->selectAdd('width AS width');
        $this->selectAdd('height AS height');
        $this->selectAdd('SUM(impressions) AS impressions');
        $this->selectAdd('SUM(revenue) AS revenue');
        $this->selectAdd('(SUM(revenue) * 1000 / SUM(impressions)) AS ecpm');
        $this->joinAdd($oWebsitePref);
        $this->whereAdd($oWebsitePref->tableName() .".affiliateid = '".$this->escape($aOption['affiliateid'])."'");

        $this->addDateTimeLimitation($aOption);

        $this->groupBy($tableName.'.width, '.$tableName.'.height');
        if (!empty($orderClause)) {
            $this->orderBy($orderClause);
        }
        $this->find();
        $aResult = array();
        while ($this->fetch()) {
            $aRow = $this->toArray();
            $aRow['name'] = $aRow['width'].'x'.$aRow['height'];
            $aResult[] = $aRow;
        }

        return $aResult;
    }

    /**
     * Returns array of affiliates summary statistics grouped by banner size for list of affiliates
     *
     * aOption:
     *  - orderdirection  - order direction 'up' or 'down'
     *  - listorder       - colum name to order by
     *  - aAffiliateids   - list of affiliate id's, if empty return size stats for all websites visible to current user
     *  - period_preset   - special defined periods (e.g. all_stats)
     *  - period_start    - start date of period (Y-m-d php date function format)
     *  - period_end      - end date of period (Y-m-d php date function format)
     *
     * @param array $aOption same as in getSizeStatsByAffiliateId except aAffiliateids
     * @return array An associative array indexed with afiiliate id
     */
    function getSizeStatsForAffiliates($aOption)
    {
        if (!$this->checkDate($aOption['period_start']) ||
            !$this->checkDate($aOption['period_end'])) {
            return array();
        }
        $tableName = $this->tableName();
        $orderDir = ($aOption['orderdirection'] == 'down') ? 'DESC' : 'ASC';
        $aOrderOptions = array ('name', 'impressions', 'revenue', 'ecpm' );
        if (empty($aOption['listorder']) ||
            !in_array($aOption['listorder'],$aOrderOptions)) {
            $orderClause = 'width, height';
        } else {
            $orderClause = ($aOption['listorder'] == 'name') ? 'width, height' : $aOption['listorder'];
        }
        $orderClause .= " $orderDir";

        $oWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');

        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $oAffiliate = & OA_Dal::factoryDO('affiliates');
            $oAffiliate->agencyid = OA_Permission::getAgencyId();
            $oWebsitePref->joinAdd($oAffiliate, 'INNER', 'affiliates');
        }
        elseif (!OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            // shouldn't be here
            return array();
        }

        $this->selectAdd();
        $this->selectAdd($oWebsitePref->tableName().'.affiliateid AS id');
        //$this->selectAdd('concat(width,\'x\'height) AS name'); not compatible with postgres
        $this->selectAdd('width AS width');
        $this->selectAdd('height AS height');
        $this->selectAdd('SUM(impressions) AS impressions');
        $this->selectAdd('SUM(revenue) AS revenue');
        $this->selectAdd('(SUM(revenue) * 1000 / SUM(impressions)) AS ecpm');
        $this->joinAdd($oWebsitePref);

        if (!empty($aOption['aAffiliateids'])) {
            $aAffiliateIds = array();
            foreach ($aOption['aAffiliateids'] as $id) {
                $aAffiliateIds[] = '\''.$this->escape($id).'\'';
            }
            $this->whereAdd($oWebsitePref->tableName() .".affiliateid in (".implode(",", $aAffiliateIds).")");
        }

        $this->addDateTimeLimitation($aOption);

        $this->groupBy($oWebsitePref->tableName().'.affiliateid, '.$tableName.'.width, '.$tableName.'.height');
        if (!empty($orderClause)) {
            $this->orderBy($orderClause);
        }
        $this->find();
        $aData = array();
        while ($this->fetch()) {
            $aData[] = $this->toArray();
        }
        $aResult = array();
        foreach ($aData as $row) {
            $row['name'] = $row['width'].'x'.$row['height'];
            $aResult[$row['id']][] = $row;
        }

        return $aResult;
    }

    /**
     * Check date if is valid
     * Empty/ null $date is valid!
     *
     * @param string $date Y-m-d php date function format
     * @return bool
     */
    protected function checkDate($date) {
        if (!empty($date)) {
            $aDate = split('-',$date);
            if ((count($aDate) != 3) ||
                !@checkdate($aDate[1],$aDate[2],$aDate[0])) {
                return false;
            }
        }
        return true;
    }

    /**
     * A method to add where clauses based on the user input
     *
     * @param array $aOption
     */
    protected function addDateTimeLimitation($aOption)
    {
        if (!empty($aOption['period_start'])) {
            $oDate = new Date($aOption['period_start']);
            $oDate->toUTC();
            $this->whereAdd('date_time >= '.$this->quote($oDate->getDate(DATE_FORMAT_ISO)));
        }
        if (!empty($aOption['period_end'])) {
            $oDate = new Date($aOption['period_end']);
            $oDate->addSpan(new Date_Span('1-0-0-0'));
            $oDate->toUTC();
            $this->whereAdd('date_time < '.$this->quote($oDate->getDate(DATE_FORMAT_ISO)));
        }
    }
}
?>