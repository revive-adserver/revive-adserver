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

require_once MAX_PATH . '/lib/OA/Dashboard/Graph.php';
require_once MAX_PATH . '/lib/OA/Admin/Statistics/Factory.php';

/**
 * A dashboard widget to diplay an RSS feed of the OpenX Blog
 *
 */
class OA_Dashboard_Widget_GraphOAP extends OA_Dashboard_Widget_Graph
{
    public function __construct($aParams)
    {
        parent::__construct($aParams);

        $this->oTpl->setCacheLifetime(new Date_Span('0-3-0-0'));

        if ($this->isDataRequired()) {
            $this->setData($this->getStats());
        }
    }

    public function getCacheId()
    {
        return array_merge(parent::getCacheId(), [OA_Permission::getAccountId()]);
    }

    public function getStats()
    {
        // Set time zone to local
        OA_setTimeZoneLocal();

        $oEnd = new Date();
        $oEnd->setHour(0);
        $oEnd->setMinute(0);
        $oEnd->setSecond(0);
        $oEnd->toUTC();

        $oStart = new Date($oEnd);
        $oStart->subtractSpan(new Date_Span('7-0-0-0'));
        $oStart->toUTC();

        $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDsah->selectAdd();
        $doDsah->selectAdd("DATE_FORMAT(date_time, '%Y-%m-%d') AS day");
        $doDsah->selectAdd('SUM(' . $doDsah->tableName() . '.impressions) AS total_impressions');
        $doDsah->selectAdd('SUM(' . $doDsah->tableName() . '.clicks) AS total_clicks');
        $doDsah->whereAdd("date_time >= '" . $doDsah->escape($oStart->format('%Y-%m-%d %H:%M:%S')) . "'");
        $doDsah->whereAdd("date_time < '" . $doDsah->escape($oEnd->format('%Y-%m-%d %H:%M:%S')) . "'");

        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $doBanners = OA_Dal::factoryDO('banners');
            $doCampaigns = OA_Dal::factoryDO('campaigns');
            $doClients = OA_Dal::factoryDO('clients');

            $doClients->agencyid = OA_Permission::getEntityId();
            $doCampaigns->joinAdd($doClients);
            $doBanners->joinAdd($doCampaigns);

            $doBanners->selectAdd();
            $doBanners->selectAdd("bannerid");
            $doBanners->find();

            $ad_ids = [];
            while ($doBanners->fetch()) {
                $ad_ids[] = $doBanners->bannerid;
            }

            if (empty($ad_ids)) {
                return [];
            }

            $doDsah->whereAdd("ad_id IN (" . implode(",", $ad_ids) . ")");
        }

        $doDsah->groupBy('day');
        $doDsah->orderBy('day');

        $doDsah->find();

        $aStats = [];
        while ($doDsah->fetch()) {
            $row = $doDsah->toArray();
            $aStats[0][date('D', strtotime($row['day']))] = $row['total_impressions'];
            $aStats[1][date('D', strtotime($row['day']))] = $row['total_clicks'];
        }

        return $aStats;
    }
}
