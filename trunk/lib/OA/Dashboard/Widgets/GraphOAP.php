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

require_once MAX_PATH . '/lib/OA/Dashboard/Graph.php';
require_once MAX_PATH . '/lib/OA/Admin/Statistics/Factory.php';

/**
 * A dashboard widget to diplay an RSS feed of the OpenX Blog
 *
 */
class OA_Dashboard_Widget_GraphOAP extends OA_Dashboard_Widget_Graph
{
    function OA_Dashboard_Widget_GraphOAP($aParams)
    {
        parent::OA_Dashboard_Widget_Graph($aParams);

        $this->oTpl->setCacheLifetime(new Date_Span('0-3-0-0'));

        if ($this->isDataRequired()) {
            $this->setData($this->getStats());
        }
    }

    function getCacheId()
    {
        return array_merge(parent::getCacheId(), array(OA_Permission::getAccountId()));
    }

    function getStats()
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
        $doDsah->selectAdd('SUM('.$doDsah->tableName().'.impressions) AS total_impressions');
        $doDsah->selectAdd('SUM('.$doDsah->tableName().'.clicks) AS total_clicks');
        $doDsah->whereAdd("date_time >= '".$doDsah->escape($oStart->format('%Y-%m-%d %H:%M:%S'))."'");
        $doDsah->whereAdd("date_time < '".$doDsah->escape($oEnd->format('%Y-%m-%d %H:%M:%S'))."'");

        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $doBanners   = OA_Dal::factoryDO('banners');
            $doCampaigns = OA_Dal::factoryDO('campaigns');
            $doClients   = OA_Dal::factoryDO('clients');
            $doClients->agencyid = OA_Permission::getEntityId();

            $doCampaigns->joinAdd($doClients);
            $doBanners->joinAdd($doCampaigns);
            $doDsah->joinAdd($doBanners);
        }

        $doDsah->groupBy('day');
        $doDsah->orderBy('day');

        $doDsah->find();

        $aStats = array();
        while ($doDsah->fetch()) {
            $row = $doDsah->toArray();
            $aStats[0][date('D', strtotime($row['day']))] = $row['total_impressions'];
            $aStats[1][date('D', strtotime($row['day']))] = $row['total_clicks'];
        }

        return $aStats;
    }
}

?>