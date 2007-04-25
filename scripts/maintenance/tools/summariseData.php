#!/usr/bin/php -q
<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
+---------------------------------------------------------------------------+
$Id$
*/

/*
    This script is run daily sometime between midnight and 6am.  It generates statistics
    for Page URL and keyword based reports.  Here is what it does:
    1.  Delete statistics greater than 60 days old:
        a.  Zone inventory by domain and page
        b.  Zone inventory by country
        c.  Zone inventory by source
        d.  Zone inventory by site and keyword
    2.  Delete statistics for yesterday (in case it is run more than once):
        a.  Zone inventory by domain and page
        b.  Zone inventory by country
        c.  Zone inventory by source
        d.  Zone inventory by site and keyword
    3.  Go through yesterday's log file, and:
        a.  Get zone inventory statistics by domain and page.
        b.  Get zone inventory statistics by country
        c.  Get zone inventory statistics by source
        d.  Get zone inventory statistics by site and keyword
    4.  Delete forecast statistics:
        a.  Zone inventory by domain and page
        b.  Zone inventory by country
        c.  Zone inventory by source
        d.  Zone inventory by site and keyword
    4.  Create tables that forecast by day of week:
        a.  Zone inventory by domain and page
        b.  Zone inventory by country
        c.  Zone inventory by source
        d.  Zone inventory by site and keyword
    
    It expects one required and two optional paramaters:
    /usr/bin/php -q /path/to/scripts/maintenance/tools/summariseData.php {config domain} {date} {action}
    {config domain} is the name of the domain config file to load (required)
    {date} is the date of the stats that you want to re-run the script for in the format "YYYYMMDD" (optional)
    {action} is a parameter to restrict execution to certain tables to aid testing (optional)
    Valid {action} values are:- 'data_summary_zone_domain_page', 
                                'data_summary_zone_country',
                                'data_summary_zone_source',
                                'data_summary_zone_site_keyword'
    
    N.B. : The {date} parameter is the date that the script should have run on, not the "yesterday" date
*/
    // Require the initialisation file
    // Done differently from elsewhere so that it works in CLI MacOS X
    $path = dirname(__FILE__);
    define('MAX_PATH', $path . '/../../..');
    
    require_once MAX_PATH . '/init.php';
    require_once MAX_PATH . '/lib/max/other/lib-db.inc.php';
    require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
   
    $iStartTime = time();

    // Set time limit and ignore user abort
    if (!ini_get('safe_mode')) {
        @set_time_limit(600);
        @ignore_user_abort(true);
    }
    if (is_null($GLOBALS['argv'][2])) {
        $date = mktime(0,0,0,date('m'),date('d')-1,date('y'));
        // test dates
        //$date = mktime(0,0,0,5,25,2006);
        //$date = mktime(0,0,0,5,26,2006);
        //$date = mktime(0,0,0,5,27,2006);
        //$date = mktime(0,0,0,5,28,2006);
        //$date = mktime(0,0,0,5,29,2006);
        //$date = mktime(0,0,0,5,30,2006);
        //$date = mktime(0,0,0,5,31,2006);
        //$date = mktime(0,0,0,6,1,2006);
    } else {
        if (!is_numeric($GLOBALS['argv'][2]) || strlen($GLOBALS['argv'][2]) != 8) {
            quit("If you want to enter a date on the command line, you need to specify it in the format: YYYYMMDD\n\n");
        }
        $year = substr($GLOBALS['argv'][2], 0, 4);
        $month = substr($GLOBALS['argv'][2], 4, 2);
        $day = substr($GLOBALS['argv'][2], 6, 2);
        if (!checkdate($month, $day, $year)) {
            quit("You seem to have entered an invalid date: {$day}/{$month}/{$year}\n\nPlease enter a date in the format YYYYMMDD\n\n");
        }
        $date = mktime(0,0,0,$month,$day-1,$year);
    }
    
    // Define some constants
    $oldDataDays = 60; // delete data older than this amount of days
    $forecastWeeks = 2;  // number of weeks of data to forecast
    
    // test constants
    //$oldDataDays = 1000; // delete data older than this amount of days
    //$forecastWeeks = 20;  // number of weeks of data to forecast

    // Remove data from the table where it is either:
    // a.  Yesterday's data (to avoid reloading it)
    // b.  Data from more than 60 days ago (to purge the table)

    if (isset($GLOBALS['argv'][3])) {
        if ($GLOBALS['argv'][3] == 'data_summary_zone_domain_page' || $GLOBALS['argv'][3] == 'data_summary_zone_site_keyword') {
            // add domain/page table and site/keyword as they are interrelated
            $aTables = array(
                'data_summary_zone_domain_page',
                'data_summary_zone_site_keyword');
        } else {
           $aTables = array($GLOBALS['argv'][3]);
        }
    } else {
        $aTables = array(
            'data_summary_zone_domain_page',
            'data_summary_zone_country',
            'data_summary_zone_source',
            'data_summary_zone_site_keyword');
    }
    
    foreach ($aTables as $table) {
        _deleteDataSummaryDailyDay($table . '_daily', $date);
        _deleteDataSummaryDailyHistory($table . '_daily', $oldDataDays);
        _deleteDataSummaryForecast($table . '_forecast');
    }
    
    if (date('d', $date) == 1) {
        foreach ($aTables as $table) {
            _deleteDataSummaryMonthlyMonth($table . '_monthly', $date);
        }
    }
    
    $aDomainPageZones = _getForecastZones(1);
    $aCountryZones = _getForecastZones(2);    
    $aSourceZones = _getForecastZones(4);
    
    if (!empty($aDomainPageZones) && in_array('data_summary_zone_domain_page', $aTables)) {
        _buildDataSummaryZoneDomainPageDaily($aDomainPageZones, $date);
        _buildDataSummaryZoneDomainPageForecast($forecastWeeks);   
        if (date('d', $date) == 1) _buildDataSummaryZoneDomainPageMonthly($date);
        _buildDataSummaryZoneSiteKeywordDaily($date);
        _buildDataSummaryZoneSiteKeywordForecast($forecastWeeks);
        if (date('d', $date) == 1) _buildDataSummaryZoneSiteKeywordMonthly($date);
    }
    if (!empty($aCountryZones) && in_array('data_summary_zone_country', $aTables)) {
        _buildDataSummaryZoneCountryDaily($aCountryZones, $date);
        _buildDataSummaryZoneCountryForecast($forecastWeeks);
        if (date('d', $date) == 1) _buildDataSummaryZoneCountryMonthly($date);
    }
    if (!empty($aSourceZones) && in_array('data_summary_zone_source', $aTables)) {
        _buildDataSummaryZoneSourceDaily($aSourceZones, $date);
        _buildDataSummaryZoneSourceForecast($forecastWeeks);
        if (date('d', $date) == 1) _buildDataSummaryZoneSourceMonthly($date);
    }        
    
    // Make sure that we clean-up so call quit() with no parameters
    quit();
        
    ////////////////////
    // delete functions
    ////////////////////

    /**
     * Delete from $table for the given $date
     *
     * @param string $table
     * @param integer $date
     */
    function _deleteDataSummaryDailyDay($table, $date)
    {
        global $conf;
        
        $desc = "Deletion of data for the date to be run of the $table table";
    
        $query = "
            DELETE FROM {$conf['table'][$table]}
            WHERE day = '" . date('Y/m/d', $date) . "'
        ";
        $res = phpAds_dbQuery($query);
        if ($res) {
            $num = phpAds_dbAffectedRows();
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }

    /**
     * Delete from $table where data created 1 month prior to the given $date
     *
     * @param string $table
     * @param integer $date
     */
    function _deleteDataSummaryMonthlyMonth($table, $date)
    {
        global $conf;
        
        $desc = "Deletion of data for the date to be run of the $table table";
    
        $query = "
            DELETE FROM {$conf['table'][$table]}
            WHERE yearmonth = DATE_FORMAT(DATE_SUB('" . date('Y-m-d', $date) . "', INTERVAL 1 MONTH), '%Y%m')
        ";
        $res = phpAds_dbQuery($query);
        if ($res) {
            $num = phpAds_dbAffectedRows();
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }

    /**
     * Delete from $table where data created more than $oldDataDays prior to now.
     *
     * @param string $table
     * @param integer $oldDataDays
     */
    function _deleteDataSummaryDailyHistory($table, $oldDataDays)
    {
        global $conf;
        
        $desc = "Deletion of data older than $oldDataDays days for the date to be run of the $table table";
        
        $query = "
            DELETE FROM {$conf['table'][$table]}
            WHERE day < DATE_SUB(NOW(), INTERVAL " . $oldDataDays . " DAY)
        ";
        if ($res = phpAds_dbQuery($query)) {
            $num = phpAds_dbAffectedRows();
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }

    /**
     * Delete from $table
     *
     * @param string $table
     */
    function _deleteDataSummaryForecast($table)
    {
        global $conf;
        
        $desc = "Deletion of forecast data for the $table table";
    
        $query = "
            DELETE FROM {$conf['table'][$table]}
        ";
        $res = phpAds_dbQuery($query);
        if ($res) {
            $num = phpAds_dbAffectedRows();
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }
    
    
    ///////////////////////////
    // summary build functions
    ///////////////////////////
    
    /**
     * Summarise raw impressions and clicks for $aZones by domain/page for the given $date
     *
     * @param array $aZones
     * @param integer $date
     */
    function _buildDataSummaryZoneDomainPageDaily($aZones, $date)
    {
        global $conf;

        $desc = 'Summarising data_summary_zone_domain_page_daily';
        
        $query = "
        INSERT INTO {$conf['table']['data_summary_zone_domain_page_daily']}
        SELECT
            NULL,
            DATE_FORMAT(date_time, '%Y-%m-%d') AS day,
            zone_id AS zone_id,
            domain AS domain,
            page AS page,
            COUNT(*) AS impressions,
            0 as clicks
        FROM
            {$conf['table']['data_raw_ad_impression']}" . '_' . date('Ymd', $date) . "
        WHERE
            zone_id IN (" . implode(',', $aZones) . ")
        GROUP BY
            day,
            zone_id,
            domain,
            page
        ";
        if ($res = phpAds_dbQuery($query)) {
            $num1 = phpAds_dbAffectedRows();
        } else {
            dbQuit($desc, $query);
        }
        
        // add click totals
                
        $query = "
        SELECT
            DATE_FORMAT(date_time, '%Y-%m-%d') AS day,
            zone_id AS zone_id,
            domain AS domain,
            page AS page,
            COUNT(*) AS clicks
        FROM
            {$conf['table']['data_raw_ad_click']}" . '_' . date('Ymd', $date) . "
        WHERE
            zone_id IN (" . implode(',', $aZones) . ")
        GROUP BY
            day,
            zone_id,
            domain,
            page
        ";
        if ($res1 = phpAds_dbQuery($query)) {
            $aRows = array();
            while ($row = phpAds_dbFetchArray($res1)) {
                $aRows[] = $row;
            }
             
            // add click totals to corresponding rows   
            foreach ($aRows as $rowid => $row) {
                $query = "
                UPDATE {$conf['table']['data_summary_zone_domain_page_daily']}
                SET
                    clicks = ".$row['clicks']."
                WHERE day = '".$row['day']."'
                AND zone_id = ".$row['zone_id']."
                AND domain = '".mysql_escape_string($row['domain'])."'
                AND page = '".mysql_escape_string($row['page'])."'
                ";
                if ($res2 = phpAds_dbQuery($query)) {
                    if (phpAds_dbAffectedRows() > 0) {
                        unset($aRows[$rowid]); // remove this row as it matched an existing table row
                    }
                } else {
                    dbQuit($desc, $query);
                }
            }
            
            // add new rows (i.e. clicks but no impressions)
            if ($rowcnt = count($aRows)) {
                $insertMax = 1000;
                $aQueryInserts = array();
                $queryPre = "INSERT INTO {$conf['table']['data_summary_zone_domain_page_daily']} VALUES ";
                $cnt = 1;
                foreach ($aRows as $rowid => $row) {
                    $aQueryInserts[] = "(NULL, '$row[day]', $row[zone_id], '".mysql_escape_string($row[domain])."', '".mysql_escape_string($row[page])."', 0, $row[clicks])";
                    if ($cnt == $insertMax) {
                        $query = $queryPre.' '.implode(",\n", $aQueryInserts);
                        if ($res3 = phpAds_dbQuery($query)) {
                           $num2 += phpAds_dbAffectedRows();
                           $cnt = 1; 
                           $aQueryInserts = array();
                        } else {
                            dbQuit($desc, $query);
                        }
                    } else {
                        ++$cnt;
                    }
                }
                // insert any remaining rows
                if (count($aQueryInserts)) {
                    $query = $queryPre.' '.implode(",\n", $aQueryInserts);
                    if ($res3 = phpAds_dbQuery($query)) {
                        $num2 += phpAds_dbAffectedRows();
                    } else {
                        dbQuit($desc, $query);
                    }
                }
            }
            
            $num = $num1 + $num2;
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }

    /**
     * Summarise raw impressions and clicks for $aZones by country for the given $date
     *
     * @param array $aZones
     * @param integer $date
     */
    function _buildDataSummaryZoneCountryDaily($aZones, $date)
    {
        global $conf;
        
        $desc = 'Summarising data_summary_zone_country_daily';
    
        $query = "
        INSERT INTO {$conf['table']['data_summary_zone_country_daily']}
        SELECT
            NULL,
            DATE_FORMAT(date_time, '%Y-%m-%d') AS day,
            zone_id AS zone_id,
            country AS country,
            COUNT(*) AS impressions,
            0 as clicks
        FROM
            {$conf['table']['data_raw_ad_impression']}" . '_' . date('Ymd', $date) . "
        WHERE
            zone_id IN (" . implode(',', $aZones) . ")
        GROUP BY
            day,
            zone_id,
            country
        ";
        if ($res = phpAds_dbQuery($query)) {
            $num1 = phpAds_dbAffectedRows();
        } else {
            dbQuit($desc, $query);
        }
        
        // add click totals

        $query = "
        SELECT
            DATE_FORMAT(date_time, '%Y-%m-%d') AS day,
            zone_id AS zone_id,
            country AS country,
            COUNT(*) AS clicks
        FROM
            {$conf['table']['data_raw_ad_click']}" . '_' . date('Ymd', $date) . "
        WHERE
            zone_id IN (" . implode(',', $aZones) . ")
        GROUP BY
            day,
            zone_id,
            country
        ";
        if ($res1 = phpAds_dbQuery($query)) {
            $aRows = array();
            while ($row = phpAds_dbFetchArray($res1)) {
                $aRows[] = $row;
            }

            // add click totals to corresponding rows   
            foreach ($aRows as $rowid => $row) {
                $query = "
                UPDATE {$conf['table']['data_summary_zone_country_daily']}
                SET
                    clicks = ".$row['clicks']."
                WHERE day = '".$row['day']."'
                AND zone_id = ".$row['zone_id']."
                AND country = '".mysql_escape_string($row['country'])."'
                ";
                if ($res2 = phpAds_dbQuery($query)) {
                    if (phpAds_dbAffectedRows() > 0) {
                        unset($aRows[$rowid]); // remove this row as it matched an existing table row
                    }
                } else {
                    dbQuit($desc, $query);
                }
            }
            
            // add new rows (i.e. clicks but no impressions)
            if ($rowcnt = count($aRows)) {
                $insertMax = 1000;
                $aQueryInserts = array();
                $queryPre = "INSERT INTO {$conf['table']['data_summary_zone_country_daily']} VALUES ";
                $cnt = 1;
                foreach ($aRows as $rowid => $row) {
                    $aQueryInserts[] = "(NULL, '$row[day]', $row[zone_id], '$row[country]', 0, $row[clicks])";
                    if ($cnt == $insertMax) {
                        $query = $queryPre.' '.implode(",\n", $aQueryInserts);
                        if ($res3 = phpAds_dbQuery($query)) {
                           $num2 += phpAds_dbAffectedRows();
                           $cnt = 1; 
                           $aQueryInserts = array();
                        } else {
                            dbQuit($desc, $query);
                        }
                    } else {
                        ++$cnt;
                    }
                }
                // insert any remaining rows
                if (count($aQueryInserts)) {
                    $query = $queryPre.' '.implode(",\n", $aQueryInserts);
                    if ($res3 = phpAds_dbQuery($query)) {
                        $num2 += phpAds_dbAffectedRows();
                    } else {
                        dbQuit($desc, $query);
                    }
                }
            }

            $num = $num1 + $num2;
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }

    /**
     * Summarise raw impressions and clicks for $aZones by source for the given $date
     *
     * @param array $aZones
     * @param integer $date
     */
    function _buildDataSummaryZoneSourceDaily($aZones, $date)
    {
        global $conf;
        
        $desc = 'Summarising data_summary_zone_source_daily';
    
        $query = "
        INSERT INTO {$conf['table']['data_summary_zone_source_daily']}
        SELECT
            NULL,
            DATE_FORMAT(date_time, '%Y-%m-%d') AS day,
            zone_id AS zone_id,
            channel as source,
            COUNT(*) AS impressions,
            0 as clicks
        FROM
            {$conf['table']['data_raw_ad_impression']}" . '_' . date('Ymd', $date) . "
        WHERE
            zone_id IN (" . implode(',', $aZones) . ")
        GROUP BY
            day,
            zone_id,
            source
        ";
        if ($res = phpAds_dbQuery($query)) {
            $num1 = phpAds_dbAffectedRows();
        } else {
            dbQuit($desc, $query);
        }
        
        // add click totals

        $query = "
        SELECT
            DATE_FORMAT(date_time, '%Y-%m-%d') AS day,
            zone_id AS zone_id,
            channel AS source,
            COUNT(*) AS clicks
        FROM
            {$conf['table']['data_raw_ad_click']}" . '_' . date('Ymd', $date) . "
        WHERE
            zone_id IN (" . implode(',', $aZones) . ")
        GROUP BY
            day,
            zone_id,
            source
        ";
        if ($res1 = phpAds_dbQuery($query)) {
            $aRows = array();
            while ($row = phpAds_dbFetchArray($res1)) {
                $aRows[] = $row;
            }

            // add click totals to corresponding rows   
            foreach ($aRows as $rowid => $row) {
                $query = "
                UPDATE {$conf['table']['data_summary_zone_source_daily']}
                SET
                    clicks = ".$row['clicks']."
                WHERE day = '".$row['day']."'
                AND zone_id = ".$row['zone_id']."
                AND source = '".mysql_escape_string($row['source'])."'
                ";
                if ($res2 = phpAds_dbQuery($query)) {
                    if (phpAds_dbAffectedRows() > 0) {
                        unset($aRows[$rowid]); // remove this row as it matched an existing table row
                    }
                } else {
                    dbQuit($desc, $query);
                }
            }

            // add new rows (i.e. clicks but no impressions)
            if ($rowcnt = count($aRows)) {
                $insertMax = 1000;
                $aQueryInserts = array();
                $queryPre = "INSERT INTO {$conf['table']['data_summary_zone_source_daily']} VALUES ";
                $cnt = 1;
                foreach ($aRows as $rowid => $row) {
                    $aQueryInserts[] = "(NULL, '$row[day]', $row[zone_id], '$row[source]', 0, $row[clicks])";
                    if ($cnt == $insertMax) {
                        $query = $queryPre.' '.implode(",\n", $aQueryInserts);
                        if ($res3 = phpAds_dbQuery($query)) {
                           $num2 += phpAds_dbAffectedRows();
                           $cnt = 1; 
                           $aQueryInserts = array();
                        } else {
                            dbQuit($desc, $query);
                        }
                    } else {
                        ++$cnt;
                    }
                }
                // insert any remaining rows
                if (count($aQueryInserts)) {
                    $query = $queryPre.' '.implode(",\n", $aQueryInserts);
                    if ($res3 = phpAds_dbQuery($query)) {
                        $num2 += phpAds_dbAffectedRows();
                    } else {
                        dbQuit($desc, $query);
                    }
                }
            }            
            
            $num = $num1 + $num2;
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }
    
    /**
     * Summarise raw impressions and clicks for Cheapflights domains by site/keyword for the given $date
     *
     * @param integer $date
     */
    function _buildDataSummaryZoneSiteKeywordDaily($date)
    {
        global $conf;
        
        $desc = 'Summarising data_summary_zone_site_keyword_daily';

        $query = "
        SELECT
            dszdpd.day AS day,
            dszdpd.zone_id AS zone_id,
            IF (dszdpd.domain LIKE '%cheapflights%',
                'cheapflights',
                IF (dszdpd.domain LIKE '%cheapholidaydeals%',
                    'cheapholidaydeals',
                    IF (dszdpd.domain LIKE '%cheapshortbreaks%',
                        'cheapshortbreaks',
                        IF (dszdpd.domain LIKE '%cheapaccommodation%',
                            'cheapaccommodation',
                            ''
                        )
                    )
                )
            ) AS site,
            IF (dszdpd.domain LIKE '%cheapflights%'
                OR dszdpd.domain LIKE '%cheapholidaydeals%'
                OR dszdpd.domain LIKE '%cheapshortbreaks%'
                OR dszdpd.domain LIKE '%cheapaccommodation%',
                LOWER(dszdpd.page),
                ''
            ) AS page,
            SUM(impressions) AS impressions,
            SUM(clicks) AS clicks
        FROM
            {$conf['table']['data_summary_zone_domain_page_daily']} AS dszdpd,
            {$conf['table']['zones']} AS z,
            {$conf['table']['affiliates']} AS p
        WHERE
            dszdpd.zone_id = z.zoneid
            AND z.affiliateid = p.affiliateid
            AND p.agencyid = 21
            AND dszdpd.day = '" . date('Y/m/d', $date) . "'
        GROUP BY
            day,
            zone_id,
            site,
            page
        ";
        $res = phpAds_dbQuery($query)
            or dbQuit($desc, $query);

        $aValues = array();
        while ($row = phpAds_dbFetchArray($res)) {
            if (!empty($row['zone_id'])) {
                if (!empty($row['site'])) {
                    if (!empty($row['page'])) {
                        $aKeywords = explode('/', $row['page']);
                        foreach ($aKeywords as $keyword) {
                            // remove items which have % in them (usually encoding errors)
                            // remove items which have . in them (usually the page rather than directory)
                            if (preg_match('#[.%=]+#', $keyword)) {
                                $keyword = '';
                            }
                            // remove non-alphabetic keywords
                            if (!preg_match('#[A-Za-z]+#', $keyword)) {
                                $keyword = '';
                            }
                            // remove short keywords
                            if (strlen($keyword) < 3) {
                                $keyword = '';
                            }
                            if (!empty($keyword)) {
                                $aInventoryForecast[$row['day']][$row['zone_id']][$row['site']][$keyword]['impression_cnt'] += $row['impressions'];
                                $aInventoryForecast[$row['day']][$row['zone_id']][$row['site']][$keyword]['click_cnt'] += $row['clicks'];
                            }
                        }
                    }
                }
            }
        }

        // Perform an insert after this number of rows..
        $insertMax = 1000;
        $num = 0;
        foreach ($aInventoryForecast as $day => $aInventoryForecastDay) {
            foreach ($aInventoryForecastDay as $zoneId => $aInventoryForecastZone) {
                foreach ($aInventoryForecastZone as $site => $aInventoryForecastZoneSite) {
                    $aQueryInserts = array();
                    $queryPre = "INSERT INTO {$conf['table']['data_summary_zone_site_keyword_daily']} VALUES ";
                    $cnt = 1;   
                    foreach ($aInventoryForecastZoneSite as $keyword => $row) {
                        $aQueryInserts[] = "(NULL, '$day', $zoneId,'".mysql_escape_string($site)."', '".mysql_escape_string($keyword)."', $row[impression_cnt], $row[click_cnt])";
                        if ($cnt == $insertMax) {
                            $query = $queryPre.' '.implode(",\n", $aQueryInserts);
                            if ($res = phpAds_dbQuery($query)) {
                                $num += phpAds_dbAffectedRows();
                                $cnt = 1; 
                                $aQueryInserts = array();
                            } else {
                                dbQuit($desc, $query);
                            }
                        } else {
                            ++$cnt;
                        }
                    }
                    // insert any remaining rows
                    if (count($aQueryInserts)) {
                        $query = $queryPre.' '.implode(",\n", $aQueryInserts);
                        if ($res = phpAds_dbQuery($query)) {
                            $num += phpAds_dbAffectedRows();
                        } else {
                            dbQuit($desc, $query);
                        }
                    }
                }
            }
        }
        echo $desc." completed. ($num rows)\n";
    }
    
    
    ////////////////////////////
    // forecast build functions
    ////////////////////////////

    /**
     * Create forecast data by domain/page based on daily data from $forecastWeeks ago to the present
     * Forecast is broken down into days of the week (Mon, Tue, etc)
     *
     * @param integer $forecastWeeks
     */
    function _buildDataSummaryZoneDomainPageForecast($forecastWeeks)
    {
        global $conf;
        
        $desc = 'Forecasting data_summary_zone_domain_page_forecast';
    
        $query = "
        INSERT INTO {$conf['table']['data_summary_zone_domain_page_forecast']}
        SELECT
            NULL,
            DAYOFWEEK(day) AS day_of_week,
            zone_id AS zone_id,
            domain AS domain,
            page AS page,
            SUM(impressions) / $forecastWeeks AS impressions,
            SUM(clicks) / $forecastWeeks AS clicks
        FROM
            {$conf['table']['data_summary_zone_domain_page_daily']}
        WHERE
            day <= DATE_SUB(NOW(), INTERVAL 1 DAY)
            AND day >= DATE_SUB(NOW(), INTERVAL " . ($forecastWeeks * 7) . " DAY)
        GROUP BY
            day_of_week,
            zone_id,
            domain,
            page
        ";
        if ($res = phpAds_dbQuery($query)) {
            $num = phpAds_dbAffectedRows();
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }

    /**
     * Create forecast data by country based on daily data from $forecastWeeks ago to the present
     * Forecast is broken down into days of the week (Mon, Tue, etc)
     *
     * @param integer $forecastWeeks
     */
    function _buildDataSummaryZoneCountryForecast($forecastWeeks)
    {
        global $conf;
        
        $desc = 'Forecasting data_summary_zone_country_forecast';

        $query = "
        INSERT INTO {$conf['table']['data_summary_zone_country_forecast']}
        SELECT
            NULL,
            DAYOFWEEK(day) AS day_of_week,
            zone_id AS zone_id,
            country AS country,
            SUM(impressions) / $forecastWeeks AS impressions,
            SUM(clicks) / $forecastWeeks AS clicks
        FROM
            {$conf['table']['data_summary_zone_country_daily']}
        WHERE
            day <= DATE_SUB(NOW(), INTERVAL 1 DAY)
            AND day >= DATE_SUB(NOW(), INTERVAL " . ($forecastWeeks * 7) . " DAY)
        GROUP BY
            day_of_week,
            zone_id,
            country
        ";
        if ($res = phpAds_dbQuery($query)) {
            $num = phpAds_dbAffectedRows();
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }

    /**
     * Create forecast data by source based on daily data from $forecastWeeks ago to the present
     * Forecast is broken down into days of the week (Mon, Tue, etc)
     *
     * @param integer $forecastWeeks
     */
    function _buildDataSummaryZoneSourceForecast($forecastWeeks)
    {
        global $conf;
        
        $desc = 'Forecasting data_summary_zone_source_forecast';

        $query = "
        INSERT INTO {$conf['table']['data_summary_zone_source_forecast']}
        SELECT
            NULL,
            DAYOFWEEK(day) AS day_of_week,
            zone_id AS zone_id,
            source AS source,
            SUM(impressions) / $forecastWeeks AS impressions,
            SUM(clicks) / $forecastWeeks AS clicks
        FROM
            {$conf['table']['data_summary_zone_source_daily']}
        WHERE
            day <= DATE_SUB(NOW(), INTERVAL 1 DAY)
            AND day >= DATE_SUB(NOW(), INTERVAL " . ($forecastWeeks * 7) . " DAY)
        GROUP BY
            day_of_week,
            zone_id,
            source
        ";
        if ($res = phpAds_dbQuery($query)) {
            $num = phpAds_dbAffectedRows();
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }

    /**
     * Create forecast data by site/keyword based on daily data from $forecastWeeks ago to the present
     * Forecast is broken down into days of the week (Mon, Tue, etc)     
     *
     * @param integer $forecastWeeks
     */
    function _buildDataSummaryZoneSiteKeywordForecast($forecastWeeks)
    {
        global $conf;
        
        $desc = 'Forecasting data_summary_zone_site_keyword_forecast';

        $query = "
        INSERT INTO {$conf['table']['data_summary_zone_site_keyword_forecast']}
        SELECT
            NULL,
            DAYOFWEEK(day) AS day_of_week,
            zone_id AS zone_id,
            site AS site,
            keyword AS keyword,
            SUM(impressions) / $forecastWeeks AS impressions,
            SUM(clicks) / $forecastWeeks AS clicks
        FROM
            {$conf['table']['data_summary_zone_site_keyword_daily']}
        WHERE
            day <= DATE_SUB(NOW(), INTERVAL 1 DAY)
            AND day >= DATE_SUB(NOW(), INTERVAL " . ($forecastWeeks * 7) . " DAY)
        GROUP BY
            day_of_week,
            zone_id,
            site,
            keyword
        ";
        if ($res = phpAds_dbQuery($query)) {
            $num = phpAds_dbAffectedRows();
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }

    
    ///////////////////////////
    // monthly build functions
    ///////////////////////////
    
    /**
     * Summarise data by month and domain/page for the month prior to that of $date
     *
     * @param integer $date
     */
    function _buildDataSummaryZoneDomainPageMonthly($date)
    {
        global $conf;
        
        $desc = 'Summarising data_summary_zone_domain_page_monthly';
        
        $query = "
        INSERT INTO {$conf['table']['data_summary_zone_domain_page_monthly']}
        SELECT
            NULL,
            DATE_FORMAT(day, '%Y%m') AS yearmonth,
            zone_id AS zone_id,
            domain AS domain,
            page AS page,
            SUM(impressions) AS impressions,
            SUM(clicks) AS clicks
        FROM {$conf['table']['data_summary_zone_domain_page_daily']}
        WHERE 
            DATE_FORMAT(day, '%Y%m') = DATE_FORMAT(DATE_SUB('" . date('Y-m-d', $date) . "', INTERVAL 1 MONTH), '%Y%m')
        GROUP BY
            yearmonth,
            zone_id,
            domain,
            page
        ";
        if ($res = phpAds_dbQuery($query)) {
            $num = phpAds_dbAffectedRows();
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }

    /**
     * Summarise data by month and country for the month prior to that of $date
     *
     * @param integer $date
     */
    function _buildDataSummaryZoneCountryMonthly($date)
    {
        global $conf;

        $desc = 'Summarising data_summary_zone_country_monthly';
               
        $query = "
        INSERT INTO {$conf['table']['data_summary_zone_country_monthly']}
        SELECT
            NULL,
            DATE_FORMAT(day, '%Y%m') AS yearmonth,
            zone_id AS zone_id,
            country AS country,
            SUM(impressions) AS impressions,
            SUM(clicks) AS clicks
        FROM {$conf['table']['data_summary_zone_country_daily']}
        WHERE 
            DATE_FORMAT(day, '%Y%m') = DATE_FORMAT(DATE_SUB('" . date('Y-m-d', $date) . "', INTERVAL 1 MONTH), '%Y%m')
        GROUP BY
            yearmonth,
            zone_id,
            country
        ";
        if ($res = phpAds_dbQuery($query)) {
            $num = phpAds_dbAffectedRows();
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }

    /**
     * Summarise data by month and source for the month prior to that of $date
     *
     * @param integer $date
     */
    function _buildDataSummaryZoneSourceMonthly($date)
    {
        global $conf;
        
        $desc = 'Summarising data_summary_zone_source_monthly';
        
        $query = "
        INSERT INTO {$conf['table']['data_summary_zone_source_monthly']}
        SELECT
            NULL,
            DATE_FORMAT(day, '%Y%m') AS yearmonth,
            zone_id AS zone_id,
            source AS source,
            SUM(impressions) AS impressions,
            SUM(clicks) AS clicks
        FROM {$conf['table']['data_summary_zone_source_daily']}
        WHERE 
            DATE_FORMAT(day, '%Y%m') = DATE_FORMAT(DATE_SUB('" . date('Y-m-d', $date) . "', INTERVAL 1 MONTH), '%Y%m')
        GROUP BY
            yearmonth,
            zone_id,
            source
        ";
        if ($res = phpAds_dbQuery($query)) {
            $num = phpAds_dbAffectedRows();
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }

    /**
     * Summarise data by month and site/keyword for the month prior to that of $date
     *
     * @param integer $date
     */
    function _buildDataSummaryZoneSiteKeywordMonthly($date)
    {
        global $conf;
        
        $desc = 'Summarising data_summary_zone_site_keyword_monthly';
        
        $query = "
        INSERT INTO {$conf['table']['data_summary_zone_site_keyword_monthly']}
        SELECT
            NULL,
            DATE_FORMAT(day, '%Y%m') AS yearmonth,
            zone_id AS zone_id,
            site AS site,
            keyword AS keyword,
            SUM(impressions) AS impressions,
            SUM(clicks) AS clicks
        FROM {$conf['table']['data_summary_zone_site_keyword_daily']}
        WHERE 
            DATE_FORMAT(day, '%Y%m') = DATE_FORMAT(DATE_SUB('" . date('Y-m-d', $date) . "', INTERVAL 1 MONTH), '%Y%m')
        GROUP BY
            yearmonth,
            zone_id,
            site,
            keyword
        ";
        if ($res = phpAds_dbQuery($query)) {
            $num = phpAds_dbAffectedRows();
            echo $desc." completed. ($num rows)\n";
        } else {
            dbQuit($desc, $query);
        }
    }


    //////////////////
    // misc functions
    //////////////////
    
    /**
     * get zones with forecast type set to $type (bitwise comparison)
     * type 1: domain/page (aka 'page URL')
     * type 2: country
     * type 4: source
     *
     * @param integer $type
     * @return array
     */
    function _getForecastZones($type)
    {
        global $conf;
    
        $query = "
        SELECT
            zoneid AS zone_id,
            inventory_forecast_type as type
        FROM
            {$conf['table']['zones']}
        WHERE
            inventory_forecast_type & $type
        ";
        $res = phpAds_dbQuery($query)
            or dbQuit($desc, $query);
    
        $aZones = array();
        while ($row = phpAds_dbFetchArray($res)) {
            $aZones[] = $row['zone_id'];
        }
        
        return $aZones;
    }

    /**
     * Display mysql error message with $query and $desc
     *
     * @param string $desc
     * @param string $query
     */
    function dbQuit($desc, $query) {
        $message = $desc." failed:\n";
        $message .= "\$query = '{$query}'\n\n";
        $message .= "mysql_error() = '" . mysql_error() . "\n\n";
        quit($message);
    }
    
    /**
     * Safe-exit function that will take an optional message which will be output to STDOUT
     * It also cleans up after itself so that things like the LOCK file are removed.
     *
     * @param string $message
     */
    function quit($message = false) {
        global $conf, $fh, $iStartTime;
        if ($message) {
            echo $message;
        }

        if (is_resource($fh)) {
            fclose($fh);
            unlink($conf['table']['lockfile']);
        }

        $iEndTime = time();
        $iDuration = $iEndTime - $iStartTime;
        echo "\nScript duration = {$iDuration}s\n";
        exit;
    }

?>
