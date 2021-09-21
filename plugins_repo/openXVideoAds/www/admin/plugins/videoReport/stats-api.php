<?php

require_once MAX_PATH . "/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/common.php";

class OX_Video_Report
{
    public static $graphMetricsToPlot = [1, 3, 2, 4, 5];
    
    public static $vastEventIdToEventName = [
         1 => 'Started',
         2 => 'Viewed > 50%',
         3 => 'Viewed > 25%',
         4 => 'Viewed > 75%',
         5 => 'Completed',
         6 => 'Muted',
         7 => 'Replayed',
         8 => 'Fullscreen',
         9 => 'Stopped',
     ];
     
    public static $vastEventIdInOrder = [1, 3, 2, 4, 5, 7, 8, 6, 9, ];

    public function __construct()
    {
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $this->statsTable = $prefix . "stats_vast";//"data_bkt_vast_e";
        $this->campaignTable = $prefix . "campaigns";
        $this->bannerTable = $prefix . "banners";
        $this->zoneTable = $prefix . "zones";
        $this->websiteTable = $prefix . "affiliates";
    }
     
    protected function getDateTimeInUtc($date)
    {
        $dateInUTC = new Date($date);
        $dateInUTC->toUTC();
        return $dateInUTC->format('%Y-%m-%d %H:%M:%S');
    }
     
    // queries the bucket table
    /*
    | interval_start | datetime      | NO   | PRI |         |       |
    | creative_id    | mediumint(20) | NO   | PRI |         |       |
    | zone_id        | mediumint(20) | NO   | PRI |         |       |
    | vast_event_id  | char(32)      | NO   | PRI |         |       |
    | count          | int(11)       | NO   |     | 0       |       |

    - a bannerid is linked to a campaignid in ox_banners
    - a campaignid is linked to a clientid in ox_campaigns
    - a clientid is in ox_clients
    */
    public function getVastStatistics(
        $entity, // advertiser, campaign, banner
                                    $entityValue, // ID
                                    $dimension, // "campaign", "banner", "day", "week", "month", "year", "hour-of-day"
                                    $startDate,
        $endDate,
        $entityFilterName = false,
        $entityFilterValue = false
    ) {
        $startDateTime = $this->getDateTimeInUtc("$startDate 00:00:00");
        $endDateTime = $this->getDateTimeInUtc("$endDate 23:59:59");
        //		echo $startDateTime . " / " . $endDateTime;

        $sqlFrom = $whereEntity = '';
        $entityValue = OA_DB::singleton()->quote($entityValue);
        switch ($entity) {
            case 'advertiser':
                $sqlFrom = $this->statsTable . " AS s 
							JOIN $this->bannerTable as b ON s.creative_id = b.bannerid
							JOIN $this->campaignTable AS c ON b.campaignid = c.campaignid";
                $whereEntity = "c.clientid = $entityValue";
            break;
            
            case 'campaign':
                $sqlFrom = $this->statsTable . " AS s 
							JOIN " . $this->bannerTable . " as b ON s.creative_id = b.bannerid
							";
                $whereEntity = "b.campaignid = $entityValue";
            break;
            
            case 'banner':
                $sqlFrom = $this->statsTable;
                $whereEntity = "creative_id = $entityValue";
            break;
            
            case 'zone':
                $sqlFrom = $this->statsTable;
                $whereEntity = "zone_id = $entityValue";
            break;
            
            case 'website':
                $sqlFrom = $this->statsTable . " AS s 
							JOIN " . $this->zoneTable . " as z ON s.zone_id = z.zoneid
							JOIN " . $this->websiteTable . " as a ON a.affiliateid = z.affiliateid
							";
                $whereEntity = "a.affiliateid = $entityValue";
            break;
        }
        
        // the field to use as an ID
        $sqlSelectAsDimensionId = $this->getSqlFieldFromDimension($dimension);
        // the field to use as a name for the row (first displayed column)
        $sqlSelectAsDimensionName = $this->getSqlFieldNameFromDimension($dimension, $sqlSelectAsDimensionId);
        
        if (!empty($entityFilterName)) {
            $entityFilterName = $this->getSqlFieldFromDimension($entityFilterName);
            $whereEntity .= " AND $entityFilterName = " . OA_DB::singleton()->quote($entityFilterValue);
        }
        $query = "	SELECT 	sum(count) as count, 
							$sqlSelectAsDimensionId as dimension_id,
							$sqlSelectAsDimensionName as dimension_name,
							vast_event_id as event_id
					FROM $sqlFrom 
					WHERE $whereEntity
						AND interval_start >= '$startDateTime'
						AND interval_start <= '$endDateTime'
					GROUP BY dimension_id, vast_event_id
					ORDER BY interval_start, vast_event_id ASC";
        //		var_dump($query);exit;
        $result = OA_DB::singleton()->queryAll($query);
        
        if (PEAR::isError($result)) {
            var_dump($result->getMessage());
            $result = [];
        }
        $dimensionToMetrics = [];
        foreach ($result as $row) {
            $rowDimension = $row['dimension_id'];
            $rowDimensionName = $row['dimension_name'];
            $metricName = $row['event_id'];
            $metricValue = $row['count'];
            $dimensionToMetrics[$rowDimension][$metricName] = $metricValue;
            $dimensionToMetrics[$rowDimension]['name'] = htmlentities($rowDimensionName);
        }
        
        // if segmented by date, we make sure all dates are set with at least an empty row (no gaps)
        $allRowNames = $this->getDateLabelsBetweenDates($startDate, $endDate, $dimension);
        if (!empty($allRowNames)) {
            $dimensionToMetricsFilled = [];
            foreach ($allRowNames as $rowName) {
                $value = ['name' => $rowName];
                if (isset($dimensionToMetrics[$rowName])) {
                    $value = $dimensionToMetrics[$rowName];
                }
                $dimensionToMetricsFilled[$rowName] = $value;
            }
            $dimensionToMetrics = $dimensionToMetricsFilled;
        }
        return $dimensionToMetrics;
    }
    
    public function doesAdvertiserHaveVast($entityId)
    {
        $sqlFrom = $this->bannerTable . " AS b 
					JOIN " . $this->campaignTable . " AS c 
					ON b.campaignid = c.campaignid";
        $sqlWhere = "c.clientid = $entityId";
        return  $this->doesEntityHaveVast($sqlFrom, $sqlWhere);
    }
    
    public function doesCampaignHaveVast($entityId)
    {
        $sqlFrom = $this->bannerTable . " AS b";
        $sqlWhere = "b.campaignid = $entityId";
        return  $this->doesEntityHaveVast($sqlFrom, $sqlWhere);
    }
    
    public function doesBannerHaveVast($entityId)
    {
        $sqlFrom = $this->bannerTable . " AS b";
        $sqlWhere = "b.bannerid = $entityId";
        return  $this->doesEntityHaveVast($sqlFrom, $sqlWhere);
    }
    
    public function isZoneVast($zoneId)
    {
        $zone = Admin_DA::getZone($zoneId);
        return in_array($zone['type'], [OX_ZoneVideoOverlay, OX_ZoneVideoInstream]);
    }
    
    protected function doesEntityHaveVast($sqlFrom, $sqlWhere)
    {
        $query = "	
		   SELECT count(*) as count
		   FROM $sqlFrom
		   WHERE $sqlWhere
		   		AND width = height
		 		AND (	width = " . VAST_OVERLAY_DIMENSIONS . " 
		 			OR 	width = " . VAST_INLINE_DIMENSIONS . ")
		   ";
        $result = OA_DB::singleton()->getOne($query);
        //	    echo $result; echo $query;exit;
        if (PEAR::isError($result)) {
            echo $result->getMessage();
            return false;
        }
        return $result > 0;
    }

    public function doesWebsiteHaveVast($affiliateId)
    {
        $sqlFrom = $this->zoneTable . " AS z";
        $sqlWhere = "z.affiliateid = $affiliateId";
        return  $this->doesEntityHaveVast($sqlFrom, $sqlWhere);
    }
    
    protected function getDateLabelsBetweenDates($startDate, $endDate, $dimension)
    {
        switch ($dimension) {
            case 'hour-of-day':
                 return [
                    '0h', '1h', '2h', '3h', '4h', '5h', '6h', '7h', '8h', '9h', '10h', '11h',
                    '12h', '13h', '14h', '15h', '16h', '17h', '18h', '19h', '20h', '21h', '22h', '23h',
                ];
            break;
            case 'day':
                $pattern = '%Y-%m-%d';
            break;
            case 'week':
                $pattern = 'Week %W (%Y)';
            break;
            case 'month':
                $pattern = '%B %Y';
            break;
            case 'year':
                $pattern = '%Y';
            break;
            default:
                return [];
            break;
        }
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);
        while ($startTimestamp <= $endTimestamp) {
            $dates[] = strftime($pattern, $startTimestamp);
            $startTimestamp = strtotime("+1 day", $startTimestamp);
        }
        return $dates;
    }
    protected function getSqlFieldNameFromDimension($dimension, $sqlSelectAsDimensionId)
    {
        $sqlSelectAsDimensionName = $sqlSelectAsDimensionId;
        if ($dimension == 'banner') {
            $sqlSelectAsDimensionName = 'b.description';
        } elseif ($dimension == 'campaign') {
            $sqlSelectAsDimensionName = 'c.campaignname';
        } elseif ($dimension == 'zone') {
            $sqlSelectAsDimensionName = 'z.zonename';
        }
        return $sqlSelectAsDimensionName;
    }
    
    protected function getSqlFieldFromDimension($dimension)
    {
        switch ($dimension) {
            case 'day':
                $sqlSelectAsDimensionId = 'DATE(interval_start)';
            break;
            case 'week':
                $sqlSelectAsDimensionId = 'DATE_FORMAT(interval_start, \'Week %v (%x)\')';
            break;
            case 'month':
                $sqlSelectAsDimensionId = 'DATE_FORMAT(interval_start, \'%M %Y\')';
            break;
            case 'year':
                $sqlSelectAsDimensionId = 'DATE_FORMAT(interval_start, \'%Y\')';
            break;
            case 'hour-of-day':
                $sqlSelectAsDimensionId = 'DATE_FORMAT(interval_start, \'%kh\')';
            break;
            case 'banner':
                $sqlSelectAsDimensionId = 's.creative_id';
            break;
            case 'campaign':
                $sqlSelectAsDimensionId = 'b.campaignid';
            break;
            case 'zone':
                $sqlSelectAsDimensionId = 'zone_id';
            break;
            case 'website':
                $sqlSelectAsDimensionId = 'z.affiliateid';
            break;
            default:
                exit("dimension not known");
            break;
        }
        return $sqlSelectAsDimensionId;
    }
    
    public function getSummaryRowFromDataTable($dimensionToMetrics)
    {
        $totalMetrics = [];
        foreach ($dimensionToMetrics as $dimension => $metrics) {
            foreach ($metrics as $metricId => $value) {
                // make sure this event exists
                if (!isset(self::$vastEventIdToEventName[$metricId])) {
                    continue;
                }
                if (!isset($totalMetrics[$metricId])) {
                    $totalMetrics[$metricId] = 0;
                }
                $totalMetrics[$metricId] += $value;
            }
        }
        // only works because we know there are no event_id == 0
        return ['Total'] + $totalMetrics;
    }
    
    public function getColumnsIdToNameInOrder($firstColumnName)
    {
        $columnIdToName = [];
        foreach (self::$vastEventIdInOrder as $eventId) {
            $columnIdToName[$eventId] = self::$vastEventIdToEventName[$eventId];
        }
        // only works because we know there are no event_id == 0
        return [0 => $firstColumnName] + $columnIdToName;
    }
    
    
    public function getDataTableForGraphCount($dataTable)
    {
        $dataTableWithColumnsToPlot = [];
        foreach ($dataTable as $rowId => $columnsEventIdToValue) {
            foreach (self::$graphMetricsToPlot as $eventId) {
                $value = 0;
                if (isset($columnsEventIdToValue[$eventId])) {
                    $value = $columnsEventIdToValue[$eventId];
                }
                $rowName = $columnsEventIdToValue['name'];
                $dataTableWithColumnsToPlot[$rowName][$eventId] = $value;
            }
        }
        return $dataTableWithColumnsToPlot;
    }
    
    public function getDataTableForGraphPercentage($dataTable)
    {
        $dataTableWithColumnsToPlot = $this->getDataTableForGraphCount($dataTable);
        $dataTableWithColumnsToPlotPercentage = [];
        foreach ($dataTableWithColumnsToPlot as $rowName => $columnsEventIdToValue) {
            $max = max($columnsEventIdToValue);
            foreach ($columnsEventIdToValue as $eventId => $eventValue) {
                $percentage = 0;
                if ($max != 0) {
                    $percentage = round(100 * $eventValue / $max);
                }
                $dataTableWithColumnsToPlotPercentage[$rowName][$eventId] = $percentage;
            }
        }
        return $dataTableWithColumnsToPlotPercentage;
    }
    
    public function generateFakeVastStatistics($pastDays, $bannerId, $zoneId)
    {
        $oDbh = OA_DB::singleton();
        $now = time();
        $stop = $now - $pastDays * 86400;
        while ($now > $stop) {
            for ($eventId = 1;$eventId <= 9; $eventId++) {
                // generate events inversely proportional to the event id,
                // also make sure 25% happens more often than 50%
                $count = ceil(rand(1, 1000) * 1 / ($eventId == 2 ? 3 : ($eventId == 3 ? 2 : $eventId)));
                $query = "INSERT INTO {$this->statsTable} (
							`interval_start` ,
							`creative_id` ,
							`zone_id` ,
							`vast_event_id` ,
							`count`
							)
							VALUES (
							FROM_UNIXTIME(" . $now . "), '" . $bannerId . "', '" . $zoneId . "', '" . $eventId . "', '" . $count . "'
							)";
                $result = $oDbh->queryAll($query);
                if (PEAR::isError($result)) {
                    break;
                }
            }
            $now = strtotime("1 hour ago", $now);
        }
    }
}
