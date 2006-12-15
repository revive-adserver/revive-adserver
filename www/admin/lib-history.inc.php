<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$Id: lib-history.inc.php 5724 2006-10-16 06:03:30Z arlen $
*/

phpAds_registerGlobal('listorder', 'orderdirection');

// Include required files
require ('lib-gd.inc.php');

if (!isset($period) || $period == '')
    $period = 'd';

if (isset($lib_history_params))
{
    foreach (array_keys($lib_history_params) as $key)
        $params[] = $key.'='.$lib_history_params[$key];
    
    $params = '?'.implode ('&', $params).'&';
}
else
    $params = '?';

$tabindex = 1;

require_once('lib-data-statistics.inc.php');

/*-------------------------------------------------------*/
/* Determine span of statistics                          */
/*-------------------------------------------------------*/
if (phpAds_isUser(phpAds_Admin)) {
    $query = "SELECT " .
                "UNIX_TIMESTAMP(MIN(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day)) AS span, " .
                "TO_DAYS(NOW()) - TO_DAYS(MIN(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day)) + 1 AS span_days " .
            "FROM " .
                $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] . " " .
           
                (isset($lib_history_where) ? "WHERE " . $lib_history_where : "");
                
} elseif (phpAds_isUser(phpAds_Client)) {
    $query = "SELECT " .
                "UNIX_TIMESTAMP(MIN(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day)) AS span, " .
                "TO_DAYS(NOW()) - TO_DAYS(MIN(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day)) + 1 AS span_days " .
            "FROM " .
                $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] . ", " .
                $conf['table']['prefix'].$conf['table']['banners'] . ", " .
                $conf['table']['prefix'].$conf['table']['campaigns'] . " " .
                (isset($lib_history_where) ? "WHERE " . $lib_history_where . " AND " : "WHERE ") .
                $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".ad_id = ".$conf['table']['prefix'].$conf['table']['banners'].".bannerid " .
                "AND ".$conf['table']['prefix'].$conf['table']['banners'].".campaignid = ".$conf['table']['prefix'].$conf['table']['campaigns'].".campaignid " .
                "AND ".$conf['table']['prefix'].$conf['table']['campaigns'].".clientid = ". phpAds_getUserID();
} elseif (phpAds_isUser(phpAds_Affiliate)) {                
                
    $query = "SELECT " .
                "UNIX_TIMESTAMP(MIN(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day)) AS span, " .
                "TO_DAYS(NOW()) - TO_DAYS(MIN(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day)) + 1 AS span_days " .
            "FROM " .
                $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] . ", " .
                $conf['table']['prefix'].$conf['table']['zones'] . " " .
                (isset($lib_history_where) ? "WHERE " . $lib_history_where . " AND " : "WHERE ") .
                $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".zone_id = ".$conf['table']['prefix'].$conf['table']['zones'].".zoneid " .
                "AND ".$conf['table']['prefix'].$conf['table']['zones'].".affiliateid = " . phpAds_getUserID();
                    
} elseif (phpAds_isUser(phpAds_Agency)) {
    $query = "SELECT " .
                "UNIX_TIMESTAMP(MIN(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day)) AS span, " .
                "TO_DAYS(NOW()) - TO_DAYS(MIN(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day)) + 1 AS span_days " .
            "FROM " .
                $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] . ", " .
                $conf['table']['prefix'].$conf['table']['banners'] . ", " .
                $conf['table']['prefix'].$conf['table']['campaigns'] . ", " .
                $conf['table']['prefix'].$conf['table']['clients'] . " " .
                (isset($lib_history_where) ? "WHERE " . $lib_history_where . " AND " : "WHERE ") .
                $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".ad_id = ".$conf['table']['prefix'].$conf['table']['banners'].".bannerid " .
                "AND ".$conf['table']['prefix'].$conf['table']['banners'].".campaignid = ".$conf['table']['prefix'].$conf['table']['campaigns'].".campaignid " .
                "AND ".$conf['table']['prefix'].$conf['table']['campaigns'].".clientid = ".$conf['table']['prefix'].$conf['table']['clients'].".clientid " .
                "AND ".$conf['table']['prefix'].$conf['table']['clients'].".agencyid=" . phpAds_getUserID();
    
} else {
    global $strErrorBadUserType;
    echo "<div class='errormessage' style='width: 400px;'><img class='errormessage' src='images/errormessage.gif' align='absmiddle' alt=''>";
    echo "<span class='tab-r'>$strErrorBadUserType</span></div>";
}
            
$res = phpAds_dbQuery($query)
    or phpAds_sqlDie();

if ($row = phpAds_dbFetchArray($res))
{
    $span          = $row['span'];
    $span_days   = $row['span_days'];
    $span_months = ((date('Y') - date('Y', $span)) * 12) + (date('m') - date('m', $span)) + 1;
    $span_weeks  = (int)($span_days / 7) + ($span_days % 7 ? 1 : 0);
}

if (isset($row['span']) && $row['span'] > 0)
{
    /*-------------------------------------------------------*/
    /* Prepare for different periods                         */
    /*-------------------------------------------------------*/
    
    if ($period == 'd') //day
    {
        if (!isset($limit) || $limit=='') $limit = '7';
        if (!isset($start) || $start=='') $start = '0';
        
        $title = $strDays;
        $limits = array(7, 14, 21, 28);
        
        $formatted   = $date_format;
        $unformatted = "%d%m%Y";
        $returnlimit = $limit;
        $span_period = $span_days;
        
        $begin_timestamp = mktime(0, 0, 0, date('m'), date('d') - $limit + 1 - $start, date('Y'));
        $end_timestamp     = mktime(0, 0, 0, date('m'), date('d') + 1 - $start, date('Y'));
    }
    
    if ($period == 'w') //week
    {
        if (!isset($limit) || $limit=='') $limit = '4';
        if (!isset($start) || $start=='') $start = '0';
        
        $title = $strWeeks;
        $limits = array(4, 8, 12, 16);
        
        $formatted   = $date_format;
        $unformatted = "%d%m%Y";
        $returnlimit = $limit * 7;
        $span_period = $span_weeks;
        
        $shift = date('w') - ($pref['begin_of_week'] ? 1 - (date('w') == 0 ? 7 : 0) : 0);
        $begin_timestamp = mktime(0, 0, 0, date('m'), date('d') - $shift + 7 - (7 * ($limit + $start)), date('Y'));
        $end_timestamp   = mktime(0, 0, 0, date('m'), date('d') - $shift + 7 - (7 * $start), date('Y'));
    }
    
    if ($period == 'm') // month
    {
        if (!isset($limit) || $limit=='') $limit = '6';
        if (!isset($start) || $start=='') $start = '0';
        
        $title = $strMonths;
        $limits = array(6, 12);
        
        $formatted   = $month_format;
        $unformatted = "%m%Y";
        $returnlimit = $limit;
        $span_period = $span_months;
        
        $begin_timestamp = mktime(0, 0, 0, date('m') - $limit + 1 - $start, 1, date('Y'));
        $end_timestamp   = mktime(0, 0, 0, date('m') + 1 - $start, 1, date('Y'));
    }
    
    
    /*-------------------------------------------------------*/
    /* Get total statistics                                  */
    /*-------------------------------------------------------*/
    if (phpAds_isUser(phpAds_Admin)) {
       $query = "SELECT " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".requests)          AS sum_requests, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".impressions)       AS sum_views, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".clicks)            AS sum_clicks, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".conversions)       AS sum_conversions " .
                "FROM " .
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] .
                    (isset($lib_history_where) ? " WHERE " . $lib_history_where : "");
            
    } elseif (phpAds_isUser(phpAds_Client)) {
    
       $query = "SELECT " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".requests)          AS sum_requests, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".impressions)       AS sum_views, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".clicks)            AS sum_clicks, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".conversions)       AS sum_conversions " .
                "FROM " .
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] . ", " .
                    $conf['table']['prefix'].$conf['table']['banners'] . ", " .
            
                    $conf['table']['prefix'].$conf['table']['campaigns'] . " " .
            
                "WHERE " .
                
                    (isset($lib_history_where) ? $lib_history_where . " AND " : "") .
            
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".ad_id = ".$conf['table']['prefix'].$conf['table']['banners'].".bannerid " .
                
                    "AND ".$conf['table']['prefix'].$conf['table']['banners'].".campaignid = ".$conf['table']['prefix'].$conf['table']['campaigns'].".campaignid " .
            
                    "AND ".$conf['table']['prefix'].$conf['table']['campaigns'].".clientid = " . phpAds_getUserID();
    } elseif (phpAds_isUser(phpAds_Affiliate)) {
        
       $query = "SELECT " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".requests)          AS sum_requests, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".impressions)       AS sum_views, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".clicks)            AS sum_clicks, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".conversions)       AS sum_conversions " .
                "FROM " .
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] . ", " .
                    $conf['table']['prefix'].$conf['table']['zones'] . " " .
            
                "WHERE " .
                
                    (isset($lib_history_where) ? $lib_history_where . " AND " : "") .
            
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".zone_id = ".$conf['table']['prefix'].$conf['table']['zones'].".zoneid " .
                
                    "AND ".$conf['table']['prefix'].$conf['table']['zones'].".affiliateid = " . phpAds_getUserID();                 
                    
    } elseif (phpAds_isUser(phpAds_Agency)) {

       $query = "SELECT " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".requests)          AS sum_requests, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".impressions)       AS sum_views, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".clicks)            AS sum_clicks, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".conversions)       AS sum_conversions " .
                "FROM " .
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] . ", " .
                    $conf['table']['prefix'].$conf['table']['banners'] . ", " .
                    $conf['table']['prefix'].$conf['table']['campaigns'] . ", " .
                    $conf['table']['prefix'].$conf['table']['clients'] . " " .
                "WHERE " .
                    (isset($lib_history_where) ? $lib_history_where . " AND " : "") .

                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".ad_id = ".$conf['table']['prefix'].$conf['table']['banners'].".bannerid " .
                    "AND ".$conf['table']['prefix'].$conf['table']['banners'].".campaignid = ".$conf['table']['prefix'].$conf['table']['campaigns'].".campaignid " .
                    "AND ".$conf['table']['prefix'].$conf['table']['campaigns'].".clientid = ".$conf['table']['prefix'].$conf['table']['clients'].".clientid " .
                    "AND ".$conf['table']['prefix'].$conf['table']['clients'].".agencyid=" . phpAds_getUserID();
    
    } else {
    
        global $strErrorBadUserType;
        echo "<div class='errormessage' style='width: 400px;'><img class='errormessage' src='images/errormessage.gif' align='absmiddle' alt=''>";
        echo "<span class='tab-r'>$strErrorBadUserType</span></div>";
        
    }
    $result = phpAds_dbQuery($query);
    if ($row = phpAds_dbFetchArray($result)) {
        $totals['requests']     = $row['sum_requests'];
        $totals['views']        = $row['sum_views'];
        $totals['clicks']       = $row['sum_clicks'];
        $totals['conversions']  = $row['sum_conversions'];
    }
    
    /*-------------------------------------------------------*/
    /* Get statistics for selected period                    */
    /*-------------------------------------------------------*/
    $begin = date('Ymd', $begin_timestamp);
    $end   = date('Ymd', $end_timestamp);
    
    if (phpAds_isUser(phpAds_Admin)) {
       $query = "SELECT " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".requests)                        AS sum_requests, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".impressions)                     AS sum_views, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".clicks)                          AS sum_clicks, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".conversions)                     AS sum_conversions, " .
                    "DATE_FORMAT(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day, '".$formatted."')   AS date, " .
                    "DATE_FORMAT(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day, '".$unformatted."') AS date_u " .
                
                "FROM " .
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] . " " .
                "WHERE " .
                
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day >= " . $begin . " AND ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day < " . $end . " " .
    
                    (isset($lib_history_where) ? 'AND ' . $lib_history_where . ' ': '') .
    
                "GROUP BY " .
                    "date_u " .
                "ORDER BY " .
                    "date_u DESC " .
                "LIMIT " .
                    $returnlimit;
    } elseif (phpAds_isUser(phpAds_Client)) {
       $query = "SELECT " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".requests)                        AS sum_requests, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".impressions)                     AS sum_views, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".clicks)                          AS sum_clicks, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".conversions)                     AS sum_conversions, " .
                    "DATE_FORMAT(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day, '".$formatted."')   AS date, " .
                    "DATE_FORMAT(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day, '".$unformatted."') AS date_u " .
                
                "FROM " .
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] . ", " .
                    $conf['table']['prefix'].$conf['table']['banners'] . ", " .
            
                    $conf['table']['prefix'].$conf['table']['campaigns'] . " " .
            
                "WHERE " .
                
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day >= " . $begin . " AND ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day < " . $end . " " .
    
                    (isset($lib_history_where) ? 'AND ' . $lib_history_where : '') .
    
                    "AND ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".ad_id = ".$conf['table']['prefix'].$conf['table']['banners'].".bannerid " .
            
                    "AND ".$conf['table']['prefix'].$conf['table']['banners'].".campaignid = ".$conf['table']['prefix'].$conf['table']['campaigns'].".campaignid " .
            
                    "AND ".$conf['table']['prefix'].$conf['table']['campaigns'].".clientid = " . phpAds_getUserID() . " " .
                "GROUP BY " .
                    "date_u " .
                "ORDER BY " .
                    "date_u DESC " .
                "LIMIT " .
                    $returnlimit;
    } elseif (phpAds_isUser(phpAds_Affiliate)) {                    
                    
       $query = "SELECT " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".requests)                        AS sum_requests, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".impressions)                     AS sum_views, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".clicks)                          AS sum_clicks, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".conversions)                     AS sum_conversions, " .
                    "DATE_FORMAT(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day, '".$formatted."')   AS date, " .
                    "DATE_FORMAT(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day, '".$unformatted."') AS date_u " .
                
                "FROM " .
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] . ", " .
                    $conf['table']['prefix'].$conf['table']['zones'] . " " .
                
                "WHERE " .
                
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day >= " . $begin . " AND ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day < " . $end . " " .
    
                    (isset($lib_history_where) ? 'AND ' . $lib_history_where . ' ' : '') .
    
                    "AND ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".zone_id = ".$conf['table']['prefix'].$conf['table']['zones'].".zoneid " .
            
                    "AND ".$conf['table']['prefix'].$conf['table']['zones'].".affiliateid=" . phpAds_getUserID() . " " .
                "GROUP BY " .
                    "date_u " .
                "ORDER BY " .
                    "date_u DESC " .
                "LIMIT " .
                    $returnlimit;                  
        
    } elseif (phpAds_isUser(phpAds_Agency)) {
    
       $query = "SELECT " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".requests)                        AS sum_requests, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".impressions)                     AS sum_views, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".clicks)                          AS sum_clicks, " .
                    "SUM(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".conversions)                     AS sum_conversions, " .
                    "DATE_FORMAT(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day, '".$formatted."')   AS date, " .
                    "DATE_FORMAT(".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day, '".$unformatted."') AS date_u " .
                
                "FROM " .
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] . ", " .
                    $conf['table']['prefix'].$conf['table']['banners'] . ", " .
                    $conf['table']['prefix'].$conf['table']['campaigns'] . ", " .
                    $conf['table']['prefix'].$conf['table']['clients'] . " " .
                
                "WHERE " .
                
                    $conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day >= " . $begin . " AND ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".day < " . $end . " " .
                    (isset($lib_history_where) ? 'AND ' . $lib_history_where : '') .

                    " AND ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].".ad_id = ".$conf['table']['prefix'].$conf['table']['banners'].".bannerid " .
                    "AND ".$conf['table']['prefix'].$conf['table']['banners'].".campaignid = ".$conf['table']['prefix'].$conf['table']['campaigns'].".campaignid " .
                    "AND ".$conf['table']['prefix'].$conf['table']['campaigns'].".clientid = ".$conf['table']['prefix'].$conf['table']['clients'].".clientid " .
                    "AND ".$conf['table']['prefix'].$conf['table']['clients'].".agencyid=" . phpAds_getUserID() . " " .
                "GROUP BY " .
                    "date_u " .
                "ORDER BY " .
                    "date_u DESC " .
                "LIMIT " .
                    $returnlimit;
    } else {
    
        global $strErrorBadUserType;
        echo "<div class='errormessage' style='width: 400px;'><img class='errormessage' src='images/errormessage.gif' align='absmiddle' alt=''>";
        echo "<span class='tab-r'>$strErrorBadUserType</span></div>";
        
    }
                
    $result = phpAds_dbQuery($query);
    
    while ($row = phpAds_dbFetchArray($result))    {
        $stats[$row['date']]['sum_requests']    = $row['sum_requests'];
        $stats[$row['date']]['sum_views']       = $row['sum_views'];
        $stats[$row['date']]['sum_clicks']      = $row['sum_clicks'];
        $stats[$row['date']]['sum_conversions'] = $row['sum_conversions'];
    }

    /*-------------------------------------------------------*/
    /* Main code                                             */
    /*-------------------------------------------------------*/
    
    echo "<form action='".$_SERVER['PHP_SELF']."'>";
    
    if (isset($lib_history_params))
        foreach (array_keys($lib_history_params) as $key)
            echo "<input type='hidden' name='".$key."' value='".$lib_history_params[$key]."'>";
    
    echo "<select name='period' onChange='this.form.submit();' accesskey='".$keyList."' tabindex='".($tabindex++)."'>";
        echo "<option value='d'".($period == 'd' ? ' selected' : '').">".$strDailyHistory."</option>";
        echo "<option value='w'".($period == 'w' ? ' selected' : '').">".$strWeeklyHistory."</option>";
        echo "<option value='m'".($period == 'm' ? ' selected' : '').">".$strMonthlyHistory."</option>";
    echo "</select>";
    
    echo "&nbsp;&nbsp;";
    echo "<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif' border='0' name='submit'>&nbsp;";
    
    phpAds_ShowBreak();
    echo "</form>";
    
    echo "<br /><br />";
    
    
    //-----------------------------------------------------------------------------------------------------------------------
    // Output for day or month
    //-----------------------------------------------------------------------------------------------------------------------

    if ($period == 'm' || $period == 'd')
    {
    
        // Column delimiters. Prevents columns from randomly changing width
        echo "
        <table border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr height='25'>
            <td><img src='images/spacer.gif' width='200' height='1' border='0' alt='' title=''></td>
            <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        </tr>
        <tr height='25'>";

        $url = "{$_SERVER['PHP_SELF']}{$params}period={$period}&start={$start}&limit={$limit}";
        $url .= !empty($clientid) ? "&clientid=$clientid" : '';
        $url .= !empty($campaignid) ? "&campaignid=$campaignid" : '';
        $url .= !empty($bannerid) ? "&bannerid=$bannerid" : '';
        
        // Title column
        echo "<td><b>&nbsp;&nbsp;<a href='$url&listorder=key'>$title</a>";
        if ($listorder == 'key' || $listorder == "")
            echo $orderdirection == 'up'
                 ? "<a href='$url&listorder=key&orderdirection=down'><img src='images/caret-u.gif' border='0' alt='' title=''></a>"
                 : "<a href='$url&listorder=key&orderdirection=up'><img src='images/caret-ds.gif' border='0' alt='' title=''></a>";
        echo '</b></td>';

        if ($conf['logging']['adRequests']) {
            // Requests column
            echo "<td align='$phpAds_TextAlignRight'><b><a href='$url&listorder=requests'>{$GLOBALS['strRequests']}</a>";
            if ($listorder == 'requests')
                echo $orderdirection == 'up'
                     ? "<a href='$url&listorder=requests&orderdirection=down'><img src='images/caret-u.gif' border='0' alt='' title=''></a>"
                     : "<a href='$url&listorder=requests&orderdirection=up'><img src='images/caret-ds.gif' border='0' alt='' title=''></a>";
            echo '</b></td>';
        }
        // Views column
        echo "<td align='$phpAds_TextAlignRight'><b><a href='$url&listorder=views'>{$GLOBALS['strImpressions']}</a>";
        if ($listorder == 'views')
            echo $orderdirection == 'up'
                 ? "<a href='$url&listorder=views&orderdirection=down'><img src='images/caret-u.gif' border='0' alt='' title=''></a>"
                 : "<a href='$url&listorder=views&orderdirection=up'><img src='images/caret-ds.gif' border='0' alt='' title=''></a>";
        echo '</b></td>';
        
        // Clicks column
        echo "<td align='$phpAds_TextAlignRight'><b><a href='$url&listorder=clicks'>{$GLOBALS['strClicks']}</a>";
        if ($listorder == 'clicks')
            echo $orderdirection == 'up'
                 ? "<a href='$url&listorder=clicks&orderdirection=down'><img src='images/caret-u.gif' border='0' alt='' title=''></a>"
                 : "<a href='$url&listorder=clicks&orderdirection=up'><img src='images/caret-ds.gif' border='0' alt='' title=''></a>";
        echo '</b></td>';
                
        // CTR column
        echo "<td align='$phpAds_TextAlignRight'><b><a href='$url&listorder=ctr'>{$GLOBALS['strCTRShort']}</a>";
        if ($listorder == 'ctr')
            echo $orderdirection == 'up'
                 ? "<a href='$url&listorder=ctr&orderdirection=down'><img src='images/caret-u.gif' border='0' alt='' title=''></a>"
                 : "<a href='$url&listorder=ctr&orderdirection=up'><img src='images/caret-ds.gif' border='0' alt='' title=''></a>";
        echo '</b></td>';
        
        // Conversion column
        echo "<td align='$phpAds_TextAlignRight'><b><a href='$url&listorder=conversions'>{$GLOBALS['strConversions']}</a>";
        if ($listorder == 'conversions')
            echo $orderdirection == 'up'
                 ? "<a href='$url&listorder=conversions&orderdirection=down'><img src='images/caret-u.gif' border='0' alt='' title=''></a>"
                 : "<a href='$url&listorder=conversions&orderdirection=up'><img src='images/caret-ds.gif' border='0' alt='' title=''></a>";
        echo '</b></td>';
        
        // Sales Ratio column
        echo "<td align='$phpAds_TextAlignRight'><b><a href='$url&listorder=cnvr'>{$GLOBALS['strCNVRShort']}</a>";
        if ($listorder == 'cnvr')
            echo $orderdirection == 'up'
                 ? "<a href='$url&listorder=cnvr&orderdirection=down'><img src='images/caret-u.gif' border='0' alt='' title=''></a>"
                 : "<a href='$url&listorder=cnvr&orderdirection=up'><img src='images/caret-ds.gif' border='0' alt='' title=''></a>";
        echo "
            </b></td>
        </tr>
        <tr>
            <td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td>
        </tr>";

        
        //-----------------------------------------------------------------------------------------------------------------------
        //Column headers END
        //-----------------------------------------------------------------------------------------------------------------------


        //-----------------------------------------------------------------------------------------------------------------------
        //Calculate stats for day or month
        //-----------------------------------------------------------------------------------------------------------------------
        
        // total views, clicks and conversions for the period shown
        $totalviews          = 0;
        $totalclicks         = 0;
        $totalconversions    = 0;
        $totalrequests       = 0;
        
        
        $today                  = time();
                
        $array = array();
        
        for ($d=0; $d < $limit; $d++)
        {
            switch ($period)
            {
                case 'm':    $timestamp = mktime (0, 0, 0, date('m') - $d - $start, 1, date('Y'));
                            $span      = mktime (0, 0, 0, date('m', $span), 1, date('Y', $span));
                            break;
                        
                case 'd':    $timestamp = mktime (0, 0, 0, date('m'), date('d') - $d - $start, date('Y'));
                            $span      = mktime (0, 0, 0, date('m', $span), date('d', $span), date('Y', $span));
                            break;
            }
            
            $key = strftime ($formatted, $timestamp);
            $array[$d]['key'] = $key;
            $array[$d]['timestamp'] = $timestamp;
            $array[$d]['span'] = $span;            
            
            if (isset($stats[$array[$d]['key']]))
            {
                $array[$d]['requests']       = isset($stats[$key]['sum_requests']) ? $stats[$key]['sum_requests'] : 0;
                $array[$d]['views']          = isset($stats[$key]['sum_views']) ? $stats[$key]['sum_views'] : 0;
                $array[$d]['clicks']         = isset($stats[$key]['sum_clicks']) ? $stats[$key]['sum_clicks'] : 0;
                $array[$d]['ctr']            = phpAds_buildRatioPercentage($array[$d]['clicks'], $array[$d]['views']);
                $array[$d]['conversions']    = isset($stats[$key]['sum_conversions']) ? $stats[$key]['sum_conversions'] : 0;
                $array[$d]['cnvr']            = phpAds_buildRatioPercentage($array[$d]['conversions'], $array[$d]['clicks']);
                
                $totalrequests       += $array[$d]['requests'];
                $totalviews          += $array[$d]['views'];
                $totalclicks         += $array[$d]['clicks'];
                $totalconversions    += $array[$d]['conversions'];
                
                $array[$d]['available'] = true;
                
            }
            else
            {
                if ($timestamp >= $span)
                {
                    $array[$d]['requests']       = 0;
                    $array[$d]['views']          = 0;
                    $array[$d]['clicks']         = 0;
                    $array[$d]['ctr']            = phpAds_buildRatioPercentage(0, 0);
                    $array[$d]['conversions']    = 0;
                    $array[$d]['cnvr']            = phpAds_buildRatioPercentage(0, 0);
                    $array[$d]['available']     = true;
                }
                else
                {
                    $array[$d]['requests']       = '-';
                    $array[$d]['views']          = '-';
                    $array[$d]['clicks']         = '-';
                    $array[$d]['ctr']            = '-';
                    $array[$d]['conversions']    = '-';
                    $array[$d]['cnvr']            = '-';
                    $array[$d]['available']     =  false;
                }
            }
        }
        
    //-----------------------------------------------------------------------------------------------------------------------
    // Sort array according to selected column and direction
    //-----------------------------------------------------------------------------------------------------------------------
    switch ($listorder)
    {
        case 'days':        phpAds_sortArray($array,'days',($orderdirection == 'up' ? TRUE : FALSE));
                            break;
                
        case 'months':      phpAds_sortArray($array,'months',($orderdirection == 'up' ? TRUE : FALSE));
                            break;

        case 'requests':
                            phpAds_sortArray($array,'requests',($orderdirection == 'up' ? TRUE : FALSE));
                            break;
                            
        case 'views':       phpAds_sortArray($array,'views',($orderdirection == 'up' ? TRUE : FALSE));
                            break;
                        
                        
        case 'clicks':      phpAds_sortArray($array,'clicks',($orderdirection == 'up' ? TRUE : FALSE));
                            break;
                        
                        
        case 'ctr':         phpAds_sortArray($array,'ctr',($orderdirection == 'up' ? TRUE : FALSE));
                            break;
                        
                        
        case 'conversions': phpAds_sortArray($array,'conversions',($orderdirection == 'up' ? TRUE : FALSE));
                            break;
                        
                        
        case 'cnvr':        phpAds_sortArray($array,'cnvr',($orderdirection == 'up' ? TRUE : FALSE));
                            break;
                            
                        
        default:    break;
    
    }
    //-----------------------------------------------------------------------------------------------------------------------
    // Sort array according to selected column and direction END
    //-----------------------------------------------------------------------------------------------------------------------
        
        
        foreach ($array as $d=>$array)
        {
            $bgcolor="#FFFFFF";
            $d % 2 ? 0: $bgcolor= "#F6F6F6";
            
            echo "<tr>";
            
            echo "<td height='25' bgcolor='$bgcolor'>&nbsp;";
            echo "<img src='images/icon-date.gif' align='absmiddle' alt=''>&nbsp;";

    
            if (isset($lib_history_hourlyurl) && $period == 'd' && $array['available'])
                echo "<a href='".$lib_history_hourlyurl.$params."day=".strftime('%Y%m%d', $array['timestamp'])."'>".$array['key']."</a></td>";
            else
                echo $array['key']."</td>";
            
            if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' bgcolor='$bgcolor'>".phpAds_formatNumber($array['requests'])."</td>";
            echo "<td align='".$phpAds_TextAlignRight."' bgcolor='$bgcolor'>".phpAds_formatNumber($array['views'])."</td>";
            echo "<td align='".$phpAds_TextAlignRight."' bgcolor='$bgcolor'>".phpAds_formatNumber($array['clicks'])."</td>";
            echo "<td align='".$phpAds_TextAlignRight."' bgcolor='$bgcolor'>".$array['ctr']."</td>";
            echo "<td align='".$phpAds_TextAlignRight."' bgcolor='$bgcolor'>";
            if($array['conversions'] !== '-') {
                $statsConvUrl = "stats.php?entity=conversions&day=".strftime('%Y%m%d', $array['timestamp'])."&howLong=".$period;
                if(!empty($clientid)) {
                    $statsConvUrl .= '&clientid='.$clientid;
                }
                if(!empty($affiliateid)) {
                    $statsConvUrl .= '&affiliateid='.$affiliateid;
                }
                if(!empty($zoneid)) {
                    $statsConvUrl .= '&zoneid='.$zoneid;
                }
                echo "<a href='$statsConvUrl'><u>".phpAds_formatNumber($array['conversions'])."</u></a>";
            } else {
                echo $array['conversions'];
            }
            echo "</td>";
            echo "<td align='".$phpAds_TextAlignRight."' bgcolor='$bgcolor'>".$array['cnvr']."</td>";
            echo "</tr>";
            
            echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";
        }
        
        
            
        $previous = $start < $limit ? 0 : $start - $limit;
        $next = $start + $limit;
        
        echo "<tr>";
        echo "<td height='35' colspan='1' align='".$phpAds_TextAlignLeft."'>";
            echo "&nbsp;".$title.":&nbsp;";
            for ($i = 0; $i < count($limits); $i++)
            {
                if ($limit == $limits[$i])
                    echo "<a href='".$_SERVER['PHP_SELF'].$params."period=".$period."&start=".$start."&limit=".$limits[$i]."'><u>".$limits[$i]."</u></a>";
                else
                    echo "<a href='".$_SERVER['PHP_SELF'].$params."period=".$period."&start=".$start."&limit=".$limits[$i]."'>".$limits[$i]."</a>";
                
                if ($i < count($limits) - 1) echo "&nbsp;|&nbsp;";
            }
        echo "</td>";
        echo "<td height='35' colspan='6' align='".$phpAds_TextAlignRight."'>";
            if ($start > 0)
            {
                echo "<a href='".$_SERVER['PHP_SELF'].$params."period=".$period."&limit=".$limit."&start=".$previous."' accesskey='".$keyPrevious."'>";
                echo "<img src='images/arrow-l.gif' border='0' align='absmiddle' alt=''>".$strPrevious_Key."</a>";
            }
            if ($timestamp > $span)
            {
                if ($start > 0) echo "&nbsp;|&nbsp;";
                
                echo "<a href='".$_SERVER['PHP_SELF'].$params."period=".$period."&limit=".$limit."&start=".$next."' accesskey='".$keyNext."'>";
                echo $strNext_Key."<img src='images/arrow-r.gif' border='0' align='absmiddle' alt=''></a>";
            }
        echo "</td>";
        echo "</tr>";
        
        echo "<tr><td colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."'>&nbsp;</td></tr>";
        $span_this = (($start + $limit < $span_period ? $start + $limit : $span_period) - $start);

        echo "<tr bgcolor='#FFFFFF' height='25'>";
        echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'>&nbsp;</td>";
        if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strRequests."</b></td>";
        echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strImpressions."</b></td>";
        echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strClicks."</b></td>";
        echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strCTRShort."</b>&nbsp;&nbsp;</td>";
        echo "<td width='15%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strConversions."</b>&nbsp;&nbsp;</td>";
        echo "<td width='15%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strCNVR."</b>&nbsp;&nbsp;</td>";
        echo "</tr>";
        echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";

        // Total for this period
        echo "<tr>";
        echo "<td height='25'>&nbsp;<b>$strTotalThisPeriod</b></td>";
        if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['requests'] ? $totalrequests / $totals['requests'] * 100 : 0), $pref['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalrequests)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['views'] ? $totalviews / $totals['views'] * 100 : 0), $pref['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalviews)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['clicks'] ? $totalclicks / $totals['clicks'] * 100 : 0), $pref['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalclicks)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildRatioPercentage($totalclicks, $totalviews)."&nbsp;&nbsp;</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalconversions)."&nbsp;&nbsp;</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildRatioPercentage($totalconversions, $totalclicks);
        echo "</tr>";
        echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";
        
        // Average for this period
        echo "<tr>";
        echo "<td height='25'>&nbsp;$strAverageThisPeriod (".$span_this." ".$title.")</td>";
        if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalrequests / $span_this)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalviews / $span_this)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalclicks / $span_this)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>&nbsp;</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalconversions / $span_this)."&nbsp;&nbsp;</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>"."&nbsp;&nbsp;</td>";
        
        echo "</tr>";
        echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";
        
        // Total
        echo "<tr>";
        echo "<td height='25'>&nbsp;<b>$strTotal</b></td>";
        if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber((int)$totals['requests'])."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber((int)$totals['views'])."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber((int)$totals['clicks'])."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildRatioPercentage($totals['clicks'], $totals['views'])."&nbsp;&nbsp;</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber((int)$totals['conversions'])."&nbsp;&nbsp;</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildRatioPercentage($totals['conversions'], $totals['clicks']);
        echo "</tr>";
        echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";
        
        // Average
        echo "<tr>";
        echo "<td height='25'>&nbsp;$strAverage (".$span_period." ".$title.")</td>";
        if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['requests'] / $span_period : 0)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['views'] / $span_period : 0)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['clicks'] / $span_period : 0)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>&nbsp;</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['conversions'] / $span_period : 0)."&nbsp;&nbsp;</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>"."&nbsp;&nbsp;</td>";
    
        echo "</tr>";
        echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6' )."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";
        echo "</table>";
    }
    
    
    // Weekly View
    if ($period == 'w')
    {
        // Header
        echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        echo "<tr bgcolor='#FFFFFF' height='25'>";
        echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'>&nbsp;<b>$title</b></td>";
        echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'>&nbsp;</td>";
        
        for ($i=0; $i < 7; $i++)
            echo "<td align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strDayShortCuts[($i + ($pref['begin_of_week'] ? 1 : 0)) % 7]."</b></td>";
        
        echo "<td align='".$phpAds_TextAlignRight."' nowrap height='25' width='10%'><b>$strAvg</b></td>";
        echo "<td align='".$phpAds_TextAlignRight."' nowrap height='25'><b>$strTotal</b>&nbsp;&nbsp;</td>";
        echo "</tr>";
        echo "<tr><td height='1' colspan='11' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";
        
        // calculate totals
        $totalrequests      = 0;
        $totalviews         = 0;
        $totalclicks        = 0;
        $totalconversions   = 0;
                
        $today = time();
        
        for ($d=0;$d<$limit;$d++)
        {
            $totalweekviews = 0;
            $totalweekclicks = 0;
            $totalweekconversions = 0;
    
            $bgcolor="#FFFFFF";
            $d % 2 ? 0: $bgcolor= "#F6F6F6";
            
            $shift = date('w') - ($pref['begin_of_week'] ? 1 - (date('w') == 0 ? 7 : 0) : 0);
            $week_timestamp = mktime(0, 0, 0, date('m'), date('d') - $shift - (7 * ($d + $start)), date('Y'));
            $week_formatted = strftime("%V") != '' ? strftime ($weekiso_format, $week_timestamp + ($pref['begin_of_week'] ? 0 : (60*60*24))) : 
                                                       strftime ($week_format, $week_timestamp + ($pref['begin_of_week'] ? 0 : (60*60*24)));
            
            $days = 0;
            
            for ($i = 0; $i < 7; $i++)
            {
                $day_timestamp = $week_timestamp + ($i * (60 * 60 * 24));
                $key = strftime ($formatted, $week_timestamp + ($i * (60 * 60 * 24)));
                
                if (isset($stats[$key]))
                {
                    $requests[$i]       = isset($stats[$key]['sum_requests']) ? $stats[$key]['sum_requests'] : 0;
                    $views[$i]          = isset($stats[$key]['sum_views']) ? $stats[$key]['sum_views'] : 0;
                    $clicks[$i]         = isset($stats[$key]['sum_clicks']) ? $stats[$key]['sum_clicks'] : 0;
                    $ctr[$i]            = phpAds_buildCTR($views[$i], $clicks[$i]);
                    $conversions[$i]    = isset($stats[$key]['sum_conversions']) ? $stats[$key]['sum_conversions'] : 0;
                    $sr[$i]                = $stats[$key]['sum_clicks'] >0 ? ($conversions[$i] / $clicks[$i]) * 100 : 0;

                    $totalweekrequests    += $requests[$i];
                    $totalweekviews       += $views[$i];
                    $totalweekclicks      += $clicks[$i];
                    $totalweekconversions += $conversions[$i];
                    $totalweeksr          += $sr[$i];
                    
                    $requests[$i]       = phpAds_formatNumber($requests[$i]);
                    $views[$i]             = phpAds_formatNumber($views[$i]);
                    $clicks[$i]         = phpAds_formatNumber($clicks[$i]);
                    $conversions[$i]    = phpAds_formatNumber($conversions[$i]);
                    $sr[$i]                = number_format($sr[$i], $pref['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator) . "%";
                    $days++;
                }
                else
                {
                    if ($day_timestamp >= $span && $day_timestamp <= $today)
                    {
                        $requests[$i]       = 0;
                        $views[$i]          = 0;
                        $clicks[$i]         = 0;
                        $ctr[$i]            = phpAds_buildRatioPercentage($clicks[$i], $views[$i]);
                        $conversions[$i]    = 0;
                        $sr[$i]                = "0.00%";
                        $days++;
                    }
                    else
                    {
                        $requests[$i]       = '-';
                        $views[$i]          = '-';
                        $clicks[$i]         = '-';
                        $ctr[$i]            = '-';
                        $conversions[$i]    = '-';
                        $sr[$i]             = '-';
                    }
                }
            }
            
            $totalrequests      += $totalweekrequests;
            $totalviews         += $totalweekviews;
            $totalclicks        += $totalweekclicks;
            $totalconversions   += $totalweekconversions;
            
            
            if ($days > 0)
            {
                $avgrequests       = $totalweekrequests / $days;
                $avgviews          = $totalweekviews / $days;
                $avgclicks         = $totalweekclicks / $days;
                $avgctr            = phpAds_buildRatioPercentage($avgclicks, $avgviews);
                $avgconversions = $totalweekconversions / $days;
                $avgsr            = phpAds_buildRatioPercentage($avgconversions, $avgclicks);
                
                $avgrequests       = phpAds_formatNumber($avgrequests);
                $avgviews          = phpAds_formatNumber($avgviews);
                $avgclicks         = phpAds_formatNumber($avgclicks);
                $avgconversions    = phpAds_formatNumber($avgconversions);
                
                $totalweekctr     = phpAds_buildRatioPercentage($totalweekclicks, $totalweekviews);
                $totalweeksr    = phpAds_buildRatioPercentage($totalweekconversions, $totalweekclicks);
            }
            else
            {
                $avgrequests       = '-';
                $avgviews          = '-';
                $avgclicks         = '-';
                $avgctr            = '-';
                $avgconversions    = '-';
                $avgsr             = '-';
                
                $totalweekrequests      = '-';
                $totalweekviews         = '-';
                $totalweekclicks        = '-';
                $totalweekctr           = '-';
                $totalweekconversions   = '-';
                $totalweeksr            = '-';
            }
            
            echo "<tr>";
            echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$week_formatted."</td>";
            echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$strDate."</td>";
                
            for ($i = 0; $i < 7; $i++)
            {
                $day_timestamp = $week_timestamp + ($i * (60 * 60 * 24));
                echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>";
                
                $available = ($views[$i] && $views[$i] != '-') || ($clicks[$i] && $clicks[$i] != '-');
                
                if (isset($lib_history_hourlyurl) && $available)
                    echo "<a href='".$lib_history_hourlyurl.$params."day=".strftime('%Y%m%d', $day_timestamp)."'>".strftime($day_format, $day_timestamp)."</a>&nbsp;</td>";
                else
                    echo strftime($day_format, $day_timestamp)."&nbsp;</td>";
            }
            
            echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>&nbsp;</td>";
            echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>&nbsp;</td>";
            echo "</tr>";
            
            if ($conf['logging']['adRequests']) {
                // Requests
                echo "<tr>";
                echo "<td height='25' bgcolor='$bgcolor'>&nbsp;</td>";
                echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$strRequests."</td>";
            
                for ($i = 0; $i < 7; $i++)
                    echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$requests[$i]."&nbsp;</td>";
                
                echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$avgrequests."&nbsp;</td>";
                echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($totalweekrequests)."&nbsp;</td>";
                echo "</tr>";
            }
            
            
            // Views
            echo "<tr>";
            echo "<td height='25' bgcolor='$bgcolor'>&nbsp;</td>";
            echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$strImpressions."</td>";
            
            for ($i = 0; $i < 7; $i++)
                echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$views[$i]."&nbsp;</td>";
            
            echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$avgviews."&nbsp;</td>";
            echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($totalweekviews)."&nbsp;</td>";
            echo "</tr>";
            
            
            // Clicks
            echo "<tr>";
            echo "<td height='15' bgcolor='$bgcolor'>&nbsp;</td>";
            echo "<td height='15' bgcolor='$bgcolor'>&nbsp;".$strClicks."</td>";
            
            for ($i = 0; $i < 7; $i++)
                echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='15' bgcolor='$bgcolor'>".$clicks[$i]."&nbsp;</td>";
            
            echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='15' bgcolor='$bgcolor'>".$avgclicks."&nbsp;</td>";
            echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='15' bgcolor='$bgcolor'>".phpAds_formatNumber($totalweekclicks)."&nbsp;</td>";
            echo "</tr>";
            
            
            // CTR
            echo "<tr>";
            echo "<td height='25' bgcolor='$bgcolor'>&nbsp;</td>";
            echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$strCTRShort."</td>";
            
            for ($i = 0; $i < 7; $i++)
                echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$ctr[$i]."&nbsp;</td>";
            
            echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$avgctr."&nbsp;</td>";
            echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$totalweekctr."&nbsp;</td>";
            echo "</tr>";
            
            // Ad Sales
            echo "<tr>";
            echo "<td height='25' bgcolor='$bgcolor'>&nbsp;</td>";
            echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$strConversions."</td>";
            
            for ($i = 0; $i < 7; $i++) {
                $day_timestamp = $week_timestamp + ($i * (60 * 60 * 24));
                echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>";
                //echo $conversions[$i];
                if($conversions[$i] !== '-') {
                    $statsConvUrl = "stats.php?entity=conversions&day=".strftime('%Y%m%d', $day_timestamp)."&howLong=d";
                    if(!empty($clientid)) {
                        $statsConvUrl .= '&clientid='.$clientid;
                    }
                    if(!empty($affiliateid)) {
                        $statsConvUrl .= '&affiliateid='.$affiliateid;
                    }
                    if(!empty($zoneid)) {
                        $statsConvUrl .= '&zoneid='.$zoneid;
                    }
                    echo "<a href='$statsConvUrl'><u>".$conversions[$i]."</u></a>";
                } else {
                    echo $conversions[$i];
                }
                echo "&nbsp;</td>";
            }
            
            echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$avgconversions."&nbsp;</td>";
            echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>";
            if($totalweekconversions !== '-') {
                $statsConvUrl = "stats.php?entity=conversions&day=".strftime('%Y%m%d', $week_timestamp)."&howLong=w";
                if(!empty($clientid)) {
                    $statsConvUrl .= '&clientid='.$clientid;
                }
                if(!empty($affiliateid)) {
                    $statsConvUrl .= '&affiliateid='.$affiliateid;
                }
                if(!empty($zoneid)) {
                    $statsConvUrl .= '&zoneid='.$zoneid;
                }
                echo "<a href='$statsConvUrl'><u>".$totalweekconversions."</u></a>";
            } else {
                echo $totalweekconversions;
            }
            echo "&nbsp;</td>";
            echo "</tr>";

            // Ad Ratio
            echo "<tr>";
            echo "<td height='25' bgcolor='$bgcolor'>&nbsp;</td>";
            echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$strCNVR."</td>";
            
            for ($i = 0; $i < 7; $i++)
                echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$sr[$i]."&nbsp;</td>";
            
            echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$avgsr."&nbsp;</td>";
            echo "<td align='".$phpAds_TextAlignRight."' nowrap  height='25' bgcolor='$bgcolor'>".$totalweeksr."&nbsp;</td>";
            echo "</tr>";
            
            echo "<tr><td height='1' colspan='11' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";
            
        }
        
        
        $previous = $start < $limit ? 0 : $start - $limit;
        $next = $start + $limit;
        
        echo "<tr>";
        echo "<td height='35' colspan='2' align='".$phpAds_TextAlignLeft."'>";
            echo "&nbsp;".$title.":&nbsp;";
            for ($i = 0; $i < count($limits); $i++)
            {
                if ($limit == $limits[$i])
                    echo "<a href='".$_SERVER['PHP_SELF'].$params."period=".$period."&start=".$start."&limit=".$limits[$i]."'><u>".$limits[$i]."</u></a>";
                else
                    echo "<a href='".$_SERVER['PHP_SELF'].$params."period=".$period."&start=".$start."&limit=".$limits[$i]."'>".$limits[$i]."</a>";
                
                if ($i < count($limits) - 1) echo "&nbsp;|&nbsp;";
            }
        echo "</td>";
        echo "<td height='35' colspan='9' align='".$phpAds_TextAlignRight."'>";
            if ($start > 0)
            {
                echo "<a href='".$_SERVER['PHP_SELF'].$params."period=".$period."&limit=".$limit."&start=".$previous."'>";
                echo "<img src='images/arrow-l.gif' border='0' align='absmiddle' alt=''>".$strPrevious."</a>";
            }
            if ($day_timestamp > $span)
            {
                if ($start > 0) echo "&nbsp;|&nbsp;";
                
                echo "<a href='".$_SERVER['PHP_SELF'].$params."period=".$period."&limit=".$limit."&start=".$next."'>";
                echo $strNext."<img src='images/arrow-r.gif' border='0' align='absmiddle' alt=''></a>";
            }
        echo "</td>";
        echo "</tr>";
        
        echo "</table>";
    
        $span_this = (($start + $limit < $span_period ? $start + $limit : $span_period) - $start);

        //Totals
        echo "<br /><br />";
        echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        echo "<tr bgcolor='#FFFFFF' height='25'>";
        echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'>&nbsp;</td>";
        if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strRequests."</b></td>";
        echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strImpressions."</b></td>";
        echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strClicks."</b></td>";
        echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strCTRShort."</b></td>";
        echo "<td width='15%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strConversions."</b></td>";
        
        echo "<td width='15%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strCNVR."</b>&nbsp;&nbsp;</td>";
        echo "</tr>";
        echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";
        
        // Total this period
        echo "<tr>";
        echo "<td height='25'>&nbsp;<b>$strTotalThisPeriod</b></td>";
        if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['requests'] ? $totalrequests / $totals['requests'] * 100 : 0), $pref['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalrequests)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['views'] ? $totalviews / $totals['views'] * 100 : 0), $pref['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalviews)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['clicks'] ? $totalclicks / $totals['clicks'] * 100 : 0), $pref['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalclicks)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildRatioPercentage($totalclicks, $totalviews)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>(".number_format(($totals['conversions'] ? $totalconversions / $totals['conversions'] * 100 : 0), $pref['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%)&nbsp;&nbsp;".phpAds_formatNumber($totalconversions)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildRatioPercentage($totalconversions, $totalclicks)."&nbsp;&nbsp;</td>";
        echo "</tr>";
        echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";
        
        //Average this period
        echo "<tr>";
        echo "<td height='25'>&nbsp;$strAverageThisPeriod (".$span_this." ".$title.")</td>";
        if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalrequests / $span_this)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalviews / $span_this)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalclicks / $span_this)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'></td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalconversions / $span_this)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>&nbsp;&nbsp;</td>";
        echo "</tr>";
        echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";
        
        // Total
        echo "<tr>";
        echo "<td height='25'>&nbsp;<b>$strTotal</b></td>";
        if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totals['requests'])."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totals['views'])."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totals['clicks'])."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildRatioPercentage($totals['clicks'], $totals['views'])."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totals['conversions'])."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildRatioPercentage($totals['conversions'], $totals['clicks'])."&nbsp;&nbsp;</td>";
        echo "</tr>";
        echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";

        // Average
        echo "<tr>";
        echo "<td height='25'>&nbsp;$strAverage (".$span_period." ".$title.")</td>";
        if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['requests'] / $span_period : 0)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['views'] / $span_period : 0)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['clicks'] / $span_period : 0)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'></td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($span_period ? $totals['conversions'] / $span_period : 0)."</td>";
        echo "<td align='".$phpAds_TextAlignRight."' height='25'>&nbsp;&nbsp;</td>";
        echo "</tr>";
        echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";
        
        echo "</table>";
    }
    
    if (phpAds_GDImageFormat() != "none")
    {
        echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        echo "<tr><td height='20' colspan='1'>&nbsp;</td></tr>";
        echo "<tr><td bgcolor='#FFFFFF' colspan='1'>";
        echo "<img src='graph-history.php".$params."period=".$period."&start=".$start."&limit=".$limit."' border='0' alt=''>";
        echo "</td></tr><tr><td height='10' colspan='1'>&nbsp;</td></tr>";
        echo "<tr><td height='1' colspan='1' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%' alt=''></td></tr>";
        echo "</table>";
    }
}
else
{
    echo "<br /><div class='errormessage'><img class='errormessage' src='images/info.gif' width='16' height='16' border='0' align='absmiddle' alt=''>";
    echo $strNoStats.'</div>';
}

echo "<br /><br />";

?>
