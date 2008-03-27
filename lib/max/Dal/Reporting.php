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

require_once MAX_PATH.'/lib/max/Dal/Common.php';
require_once MAX_PATH . '/plugins/statistics/targeting/TargetingStatistics.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * The non-DB specific Data Access Layer (DAL) class for the User Interface (Reporting).
 *
 * @package    MaxDal
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Robert Hunter <roh@m3.net>
 */
class MAX_Dal_Reporting extends MAX_Dal_Common
{
    function MAX_Dal_Reporting()
    {
        parent :: MAX_Dal_Common();
    }
/* redundant
    function getPublisherDailyStats($agencyId, $publisherId, $statsStartDate = null, $statsEndDate = null)
    {
        $conf = & $GLOBALS['_MAX']['CONF'];

        $adminConstraint = $agencyId > 0 ? "AND a.agencyid=". $this->oDbh->quote($agencyId, 'integer') : '';
        $affiliateConstraint = $publisherId > 0 ? "AND z.affiliateid=". $this->oDbh->quote($publisherId, 'integer') : '';
        $statsStartConstraint = !empty($statsStartDate) ? "AND dsah.day>=". $this->oDbh->quote($statsStartDate, 'date') : '';
        $statsEndConstraint = !empty($statsEndDate) ? "AND dsah.day<=". $this->oDbh->quote($statsEndDate, 'date') : '';

        $aAdvertiserDailyStatsData = array();

        // 3.  Get the TOTAL statistics for these campaigns
        $query = "
        SELECT
            dsah.day AS day,
            SUM(dsah.impressions) AS impressions,
            SUM(dsah.clicks) AS clicks
        FROM
            {$conf['table']['clients']} AS a,
            {$conf['table']['campaigns']} AS c,
            {$conf['table']['banners']} AS b,
            {$conf['table']['data_summary_ad_hourly']} AS dsah
            LEFT JOIN {$conf['table']['zones']} AS z ON dsah.zone_id=z.zoneid
        WHERE
            c.clientid=a.clientid
            AND b.campaignid=c.campaignid
            AND dsah.ad_id=b.bannerid
            $statsStartConstraint
            $statsEndConstraint
            $adminConstraint
            $affiliateConstraint
        GROUP BY
            day
        ";

        $res = $this->oDbh->query($query);
        if (PEAR::isError($res)) {
            return MAX::raiseError($res, MAX_ERROR_DBFAILURE);
        }

        while ($row = phpAds_dbFetchArray($res)) {
            $aAdvertiserDailyStatsData[$row['day']]['day'] = $row['day'];
            $aAdvertiserDailyStatsData[$row['day']]['impressions'] = $row['impressions'];
            $aAdvertiserDailyStatsData[$row['day']]['clicks'] = $row['clicks'];
        }
        return $aAdvertiserDailyStatsData;

    }

    function getCampaignData($agencyId, $publisherId, $campaignStartDate, $campaignEndDate, $statsStartDate = null, $statsEndDate = null)
    {
        $conf = & $GLOBALS['_MAX']['CONF'];

        $adminConstraint = $agencyId > 0 ? "AND a.agencyid=". $this->oDbh->quote($agencyId, 'integer') : '';
        $affiliateConstraint = $publisherId > 0 ? "AND z.affiliateid=". $this->oDbh->quote($publisherId, 'integer') : '';
        $campaignStartConstraint = !empty($campaignStartDate) ? "AND (c.expire>=". $this->oDbh->quote($campaignStartDate, 'date') ." OR c.expire='0000-00-00')" : '';
        $campaignEndConstraint = !empty($campaignEndDate) ? "AND (c.activate<=". $this->oDbh->quote($campaignEndDate, 'date') ." OR c.activate='0000-00-00')" : '';
        $statsStartConstraint = !empty($statsStartDate) ? "AND dsah.day>=". $this->oDbh->quote($statsStartDate, 'date') : '';
        $statsEndConstraint = !empty($statsEndDate) ? "AND dsah.day<=". $this->oDbh->quote($statsEndDate, 'date') : '';

        $aCampaignData = array();

        // 1. Get the list of campaigns that are linked to zones
        $query = "
        SELECT
            c.campaignid AS campaign_id,
            c.campaignname AS campaign_name,
            c.active AS campaign_active,
            IF(c.priority='-1','1-exclusive',IF(c.priority='0','3-low','2-high')) AS campaign_priority,
            c.activate AS campaign_start_date,
            c.expire AS campaign_end_date,
            TO_DAYS(c.activate) AS campaign_start_date_days,
            TO_DAYS(c.expire) AS campaign_end_date_days,
            c.views AS campaign_booked_impressions,
            z.zoneid AS zone_id,
            z.zonename AS zone_name,
            z.width AS zone_width,
            z.height AS zone_height
        FROM
            {$conf['table']['clients']} AS a,
            {$conf['table']['campaigns']} AS c
            LEFT JOIN {$conf['table']['placement_zone_assoc']} AS pza ON c.campaignid=pza.placement_id
            LEFT JOIN {$conf['table']['zones']} AS z ON pza.zone_id=z.zoneid
        WHERE
            c.clientid=a.clientid
            $campaignStartConstraint
            $campaignEndConstraint
            $adminConstraint
            $affiliateConstraint
        ";

        $res = $this->oDbh->query($query);
        if (PEAR::isError($res)) {
            return MAX::raiseError($res, MAX_ERROR_DBFAILURE);
        }

        while ($row = $res->fetchRow()) {
            if (empty($aCampaignData[$row['campaign_id']])) {
                $aCampaignData[$row['campaign_id']]['campaign_id'] = $row['campaign_id'];
                $aCampaignData[$row['campaign_id']]['campaign_name'] = $row['campaign_name'];
                $aCampaignData[$row['campaign_id']]['campaign_active'] = $row['campaign_active'];
                $aCampaignData[$row['campaign_id']]['campaign_priority'] = $row['campaign_priority'];
                $aCampaignData[$row['campaign_id']]['campaign_start_date'] = $row['campaign_start_date'];
                $aCampaignData[$row['campaign_id']]['campaign_end_date'] = $row['campaign_end_date'];
                $aCampaignData[$row['campaign_id']]['campaign_start_date_days'] = $row['campaign_start_date_days'];
                $aCampaignData[$row['campaign_id']]['campaign_end_date_days'] = $row['campaign_end_date_days'];
                $aCampaignData[$row['campaign_id']]['campaign_booked_impressions'] = $row['campaign_booked_impressions'];
                $aCampaignData[$row['campaign_id']]['placement_zones'] = array();
                $aCampaignData[$row['campaign_id']]['ad_zones'] = array();
                $aCampaignData[$row['campaign_id']]['stats_zones'] = array();
            }

            if (!empty($row['zone_id']) && empty($aCampaignData[$row['campaign_id']]['placement_zones'][$row['zone_id']])) {
                $aCampaignData[$row['campaign_id']]['placement_zones'][$row['zone_id']]['zone_id'] = $row['zone_id'];
                $aCampaignData[$row['campaign_id']]['placement_zones'][$row['zone_id']]['zone_name'] = $row['zone_name'];
                $aCampaignData[$row['campaign_id']]['placement_zones'][$row['zone_id']]['zone_width'] = $row['zone_width'];
                $aCampaignData[$row['campaign_id']]['placement_zones'][$row['zone_id']]['zone_height'] = $row['zone_height'];
            }
        }

        // 2.  Get the list of campaigns whose banners are linked to zones
        $query = "
        SELECT
            c.campaignid AS campaign_id,
            c.campaignname AS campaign_name,
            c.active AS campaign_active,
            IF(c.priority='-1','1-exclusive',IF(c.priority='0','3-low','2-high')) AS campaign_priority,
            c.activate AS campaign_start_date,
            c.expire AS campaign_end_date,
            TO_DAYS(c.activate) AS campaign_start_date_days,
            TO_DAYS(c.expire) AS campaign_end_date_days,
            c.views AS campaign_booked_impressions,
            z.zoneid AS zone_id,
            z.zonename AS zone_name,
            z.width AS zone_width,
            z.height AS zone_height
        FROM
            {$conf['table']['clients']} AS a,
            {$conf['table']['campaigns']} AS c
            LEFT JOIN {$conf['table']['banners']} AS b ON c.campaignid=b.campaignid
            LEFT JOIN {$conf['table']['ad_zone_assoc']} AS aza ON b.bannerid=aza.ad_id
            LEFT JOIN {$conf['table']['zones']} AS z ON aza.zone_id=z.zoneid
        WHERE
            c.clientid=a.clientid
            $campaignStartConstraint
            $campaignEndConstraint
            $adminConstraint
            $affiliateConstraint
        ";

        $res = $this->oDbh->query($query);
        if (PEAR::isError($res)) {
            return MAX::raiseError($res, MAX_ERROR_DBFAILURE);
        }

        while ($row = $res->fetchRow()) {
            if (empty($aCampaignData[$row['campaign_id']])) {
                $aCampaignData[$row['campaign_id']]['campaign_id'] = $row['campaign_id'];
                $aCampaignData[$row['campaign_id']]['campaign_name'] = $row['campaign_name'];
                $aCampaignData[$row['campaign_id']]['campaign_active'] = $row['campaign_active'];
                $aCampaignData[$row['campaign_id']]['campaign_priority'] = $row['campaign_priority'];
                $aCampaignData[$row['campaign_id']]['campaign_start_date'] = $row['campaign_start_date'];
                $aCampaignData[$row['campaign_id']]['campaign_end_date'] = $row['campaign_end_date'];
                $aCampaignData[$row['campaign_id']]['campaign_start_date_days'] = $row['campaign_start_date_days'];
                $aCampaignData[$row['campaign_id']]['campaign_end_date_days'] = $row['campaign_end_date_days'];
                $aCampaignData[$row['campaign_id']]['campaign_booked_impressions'] = $row['campaign_booked_impressions'];
                $aCampaignData[$row['campaign_id']]['placement_zones'] = array();
                $aCampaignData[$row['campaign_id']]['ad_zones'] = array();
                $aCampaignData[$row['campaign_id']]['stats_zones'] = array();
            }

            if (!empty($row['zone_id']) && empty($aCampaignData[$row['campaign_id']]['ad_zones'][$row['zone_id']])) {
                $aCampaignData[$row['campaign_id']]['ad_zones'][$row['zone_id']]['zone_id'] = $row['zone_id'];
                $aCampaignData[$row['campaign_id']]['ad_zones'][$row['zone_id']]['zone_name'] = $row['zone_name'];
                $aCampaignData[$row['campaign_id']]['ad_zones'][$row['zone_id']]['zone_width'] = $row['zone_width'];
                $aCampaignData[$row['campaign_id']]['ad_zones'][$row['zone_id']]['zone_height'] = $row['zone_height'];
            }
        }

        // 3.  Get the TOTAL statistics for these campaigns
        $query = "
        SELECT
            c.campaignid AS campaign_id,
            c.campaignname AS campaign_name,
            c.active AS campaign_active,
            IF(c.priority='-1','1-exclusive',IF(c.priority='0','3-low','2-high')) AS campaign_priority,
            c.activate AS campaign_start_date,
            c.expire AS campaign_end_date,
            TO_DAYS(c.activate) AS campaign_start_date_days,
            TO_DAYS(c.expire) AS campaign_end_date_days,
            c.views AS campaign_booked_impressions,
            z.zoneid AS zone_id,
            z.zonename AS zone_name,
            z.width AS zone_width,
            z.height AS zone_height,
            SUM(dsah.impressions) AS campaign_impressions,
            SUM(dsah.clicks) AS campaign_clicks
        FROM
            {$conf['table']['clients']} AS a,
            {$conf['table']['campaigns']} AS c,
            {$conf['table']['banners']} AS b,
            {$conf['table']['data_summary_ad_hourly']} AS dsah
            LEFT JOIN {$conf['table']['zones']} AS z ON dsah.zone_id=z.zoneid
        WHERE
            c.clientid=a.clientid
            AND b.campaignid=c.campaignid
            AND dsah.ad_id=b.bannerid
            $statsStartConstraint
            $statsEndConstraint
            $adminConstraint
            $affiliateConstraint
        GROUP BY
            campaign_id,
            zone_id
        ";

        $res = $this->oDbh->query($query);
        if (PEAR::isError($res)) {
            return MAX::raiseError($res, MAX_ERROR_DBFAILURE);
        }

        while ($row = $res->fetchRow()) {
            if (empty($aCampaignData[$row['campaign_id']])) {
                $aCampaignData[$row['campaign_id']]['campaign_id'] = $row['campaign_id'];
                $aCampaignData[$row['campaign_id']]['campaign_name'] = $row['campaign_name'];
                $aCampaignData[$row['campaign_id']]['campaign_active'] = $row['campaign_active'];
                $aCampaignData[$row['campaign_id']]['campaign_priority'] = $row['campaign_priority'];
                $aCampaignData[$row['campaign_id']]['campaign_start_date'] = $row['campaign_start_date'];
                $aCampaignData[$row['campaign_id']]['campaign_end_date'] = $row['campaign_end_date'];
                $aCampaignData[$row['campaign_id']]['campaign_start_date_days'] = $row['campaign_start_date_days'];
                $aCampaignData[$row['campaign_id']]['campaign_end_date_days'] = $row['campaign_end_date_days'];
                $aCampaignData[$row['campaign_id']]['campaign_booked_impressions'] = $row['campaign_booked_impressions'];
                $aCampaignData[$row['campaign_id']]['campaign_impressions'] = 0;
                $aCampaignData[$row['campaign_id']]['campaign_clicks'] = 0;
                $aCampaignData[$row['campaign_id']]['placement_zones'] = array();
                $aCampaignData[$row['campaign_id']]['ad_zones'] = array();
                $aCampaignData[$row['campaign_id']]['stats_zones'] = array();
            }

            if (!empty($row['zone_id']) && empty($aCampaignData[$row['campaign_id']]['stats_zones'][$row['zone_id']])) {
                $aCampaignData[$row['campaign_id']]['stats_zones'][$row['zone_id']]['zone_id'] = $row['zone_id'];
                $aCampaignData[$row['campaign_id']]['stats_zones'][$row['zone_id']]['zone_name'] = $row['zone_name'];
                $aCampaignData[$row['campaign_id']]['stats_zones'][$row['zone_id']]['zone_width'] = $row['zone_width'];
                $aCampaignData[$row['campaign_id']]['stats_zones'][$row['zone_id']]['zone_height'] = $row['zone_height'];
                $aCampaignData[$row['campaign_id']]['stats_zones'][$row['zone_id']]['zone_impressions'] = $row['campaign_impressions'];
                $aCampaignData[$row['campaign_id']]['stats_zones'][$row['zone_id']]['zone_clicks'] = $row['campaign_clicks'];
            }

            $aCampaignData[$row['campaign_id']]['campaign_impressions'] += $row['campaign_impressions'];
            $aCampaignData[$row['campaign_id']]['campaign_clicks'] += $row['campaign_clicks'];
        }

        return $aCampaignData;
    }
*/
    /**
     * @todo Handle situations where user is not Admin, Agency or Advertiser
     */
/* redundant
    function phpAds_getCampaignArray()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $query =
                "SELECT
                    c.clientid,
                    c.clientname,
                    m.campaignid,
                    m.campaignname,
                    m.anonymous
                FROM
                    ".$conf['table']['prefix'].$conf['table']['campaigns']." as m,
                    ".$conf['table']['prefix'].$conf['table']['clients']."  as c
                WHERE
                    c.clientid=m.clientid
                ORDER BY
                    c.clientname, m.campaignname
                ";
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $query =
                "SELECT
                    c.clientid,
                    c.clientname,
                    m.campaignid,
                    m.campaignname,
                    m.anonymous
                FROM
                    ".$conf['table']['prefix'].$conf['table']['campaigns']." AS m,
                    ".$conf['table']['prefix'].$conf['table']['clients']." AS c
                WHERE
                    c.clientid=m.clientid
                    AND c.agencyid=".OA_Permission::getEntityId()."
                ORDER BY
                    c.clientname, m.campaignname
                ";
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $query =
                "SELECT
                    c.clientid,
                    c.clientname,
                    m.campaignid,
                    m.campaignname,
                    m.anonymous
                FROM
                    ".$conf['table']['prefix'].$conf['table']['campaigns']." AS m,
                    ".$conf['table']['prefix'].$conf['table']['clients']." AS c
                WHERE
                    c.clientid=m.clientid
                    AND c.clientid=".OA_Permission::getEntityId()."
                ORDER BY
                    c.clientname, m.campaignname";
        }

        $res = phpAds_dbQuery($query);

        while ($row = phpAds_dbFetchArray($res))
        {
            if ($row['anonymous'] == 'f')
                $campaignArray[$row['campaignid']] = "<span dir='".$GLOBALS['phpAds_TextDirection']."'>[id".$row['clientid']."]".$row['clientname']." - [id".$row['campaignid']."]".$row['campaignname']."</span> ";
            else if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
                $campaignArray[$row['campaignid']] = "<span dir='".$GLOBALS['phpAds_TextDirection']."'>[id".$row['clientid']."]".$row['clientname']." - [id".$row['campaignid']."]".$row['campaignname']." (".$GLOBALS['strHiddenCampaign'].' '.$row['campaignid'].")</span> ";
            else
                $campaignArray[$row['campaignid']] = $GLOBALS['strHiddenCampaign'].' '.$row['campaignid'];
        }

        return ($campaignArray);
    }
*/
    /**
     * @todo Handle situations where user is not Admin, Agency or Advertiser.
     */
    function phpAds_getAdvertiserArray($orderBy = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN))
        {
            $query =
                "SELECT clientid,clientname".
                " FROM ".$conf['table']['prefix'].$conf['table']['clients'];
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $query =
                "SELECT clientid,clientname".
                " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
                " WHERE agencyid=".OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $query =
                "SELECT clientid,clientname".
                " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
                " WHERE clientid=".OA_Permission::getEntityId();
        }
        $orderBy ? $query .= " ORDER BY $orderBy ASC" : 0;

        $res = phpAds_dbQuery($query);

        while ($row = phpAds_dbFetchArray($res))
            $clientArray[$row['clientid']] = phpAds_buildName ($row['clientid'], $row['clientname']);

        return ($clientArray);
    }

    /**
     * @todo Handle situations where user is not Admin, Agency, or Advertiser
     */
/* redundant
    function phpAds_getZoneArray($orderBy = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $query =
                "SELECT
                    a.affiliateid,
                    a.name,
                    z.zoneid,
                    z.zonename
                FROM
                    ".$conf['table']['prefix'].$conf['table']['zones']." as z,
                    ".$conf['table']['prefix'].$conf['table']['affiliates']." as a
                WHERE
                    a.affiliateid=z.affiliateid";
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $query =
                "SELECT
                    a.affiliateid,
                    a.name,
                    z.zoneid,
                    z.zonename
                FROM
                    ".$conf['table']['prefix'].$conf['table']['zones']." as z,
                    ".$conf['table']['prefix'].$conf['table']['affiliates']." as a
                WHERE
                    a.affiliateid=z.affiliateid
                    AND a.agencyid=".OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $query =
                "SELECT
                    a.affiliateid,
                    a.name,
                    z.zoneid,
                    z.zonename
                FROM
                    ".$conf['table']['prefix'].$conf['table']['zones']." as z,
                    ".$conf['table']['prefix'].$conf['table']['affiliates']." as a
                WHERE
                    a.affiliateid=z.affiliateid
                    AND a.affiliateid=".OA_Permission::getEntityId();
        }
        $orderBy ? $query .= " ORDER BY $orderBy ASC" : 0;


        $res = phpAds_dbQuery($query);

        while ($row = phpAds_dbFetchArray($res)) {
            $zoneArray[$row['zoneid']] = "<span dir='".$GLOBALS['phpAds_TextDirection']."'>[id".$row['affiliateid']."]".$row['name']." - [id".$row['zoneid']."]".$row['zonename']."</span> ";
        }

        return ($zoneArray);
    }
*/
    /**
     * @todo Handle cases where user is not Admin, Agency or Advertiser
     */
    function phpAds_getPublisherArray($orderBy = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $query =
                "SELECT affiliateid,name".
                " FROM ".$conf['table']['prefix'].$conf['table']['affiliates'];
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $query =
                "SELECT affiliateid,name".
                " FROM ".$conf['table']['prefix'].$conf['table']['affiliates'].
                " WHERE agencyid=".OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $query =
                "SELECT affiliateid,name".
                " FROM ".$conf['table']['prefix'].$conf['table']['affiliates'].
                " WHERE affiliateid=".OA_Permission::getEntityId();
        }
        $orderBy ? $query .= " ORDER BY $orderBy ASC" : 0;

        $res = phpAds_dbQuery($query);

        while ($row = phpAds_dbFetchArray($res))
            $affiliateArray[$row['affiliateid']] = phpAds_buildAffiliateName ($row['affiliateid'], $row['name']);;

        return ($affiliateArray);
    }

    function phpAds_getTrackerArray()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $where = "c.clientid = t.clientid";

        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $where .= " AND c.agencyid = " . OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $where .= " AND t.clientid = " . OA_Permission::getEntityId();
        }

        $query = "
            SELECT
                c.clientname AS client_name,
                c.clientid AS client_id,
                t.trackername AS tracker_name,
                t.trackerid AS tracker_id
            FROM
                {$conf['table']['trackers']} AS t,
                {$conf['table']['clients']} AS c
            WHERE
                {$where}
            ORDER BY
                c.clientname,t.trackername
        ";
        $res = phpAds_dbQuery($query);

        while ($row = phpAds_dbFetchArray($res)) {
            $trackerArray[$row['tracker_id']] = "<span dir='".$GLOBALS['phpAds_TextDirection']."'>[id".$row['client_id']."] ".$row['client_name']." - [id".$row['tracker_id']."] ".$row['tracker_name']."</span> ";
        }

        return ($trackerArray);
    }

    /**
     * @todo Move this out of the DAL.
     */
/*  redundant
    function displayAffiliateIdDropdownField($fields, $key)
    {
        $dal = new MAX_Dal_Reporting();

        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER))
        {
            echo "<input type='hidden' name='".$key."' value='".OA_Permission::getEntityId()."'>";
        }
        else
        {
            echo "<tr><td width='30'>&nbsp;</td>";
            echo "<td width='200'>".$fields[$key]['title']."</td>";
            echo "<td width='370'><select name='".$key."' tabindex='".($this->tabindex++)."'>";

            $affiliateArray = $dal->phpAds_getAffiliateArray();
            foreach (array_keys($affiliateArray) as $ckey)
                echo "<option value='".$ckey."'>".$affiliateArray[$ckey]."</option>";
            echo "</select></td>";
            echo "</tr>";
            echo "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
            echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
        }
    }
*/
    /**
     * @todo Move this out of the DAL.
     */
/* redundant
    function displayTrackerDropdownField($fields, $key)
    {
        $dal = new MAX_Dal_Reporting();

        echo "<tr><td width='30'>&nbsp;</td>";
        echo "<td width='200'>".$fields[$key]['title']."</td>";
        echo "<td width='370'><select name='".$key."' tabindex='".($this->tabindex++)."'>";

        $trackerArray = $dal->phpAds_getTrackerArray();
        for (reset($trackerArray);$ckey=key($trackerArray);next($trackerArray))
            echo "<option value='".$ckey."'>".$trackerArray[$ckey]."</option>";
        echo "</select></td>";
        echo "</tr>";
        echo "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
        echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
    }
*/
}