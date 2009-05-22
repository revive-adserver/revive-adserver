<?php
require_once MAX_PATH . "/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/common.php";


$vastReport = new OX_Vast_Report;
// Generate fake stats?
if($generateFakeStatistics = false) {
    $vastReport->generateFakeVastStatistics($pastDays = 10, $bannerid = 1, $zoneid = 1);
    exit;
}

// Output all combinations of parameters for the getStatistics function?
if($outputAllCallGetStatistics = !true) {
	$availableDimensions = array("campaign", "banner", 
								"day", "week", "month", "year", "hour-of-day");
	$startDate = '2009-05-09';
	$endDate = '2009-05-12';
	foreach($availableDimensions as $dimension) {
		echo "<h2>Test '$dimension' (from $startDate to $endDate)</h2>";
		var_dump($vastReport->getVastStatistics('advertiser', 1, $dimension, $startDate, $endDate));
	}
}

class OX_Vast_Report {
	static $graphMetricsToPlot = array(1,3,2,4,5);
	
	static $vastEventIdToEventName = array(
	     1 => 'Initiated',
	     2 => 'Viewed > 50%',
	     3 => 'Viewed > 25%',
	     4 => 'Viewed > 75%',
	     5 => 'Completed',
	     6 => 'Muted',
	     7 => 'Replayed',
	     8 => 'Fullscreen',
	     9 => 'Stopped',
	 );
	 
	 static $vastEventIdInOrder = array(1,3,2,4,5,7,8,6,9,);

	 public function __construct()
	 {
		$prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
		$this->statsTable = $prefix . "data_bkt_vast_e";
		$this->campaignTable = $prefix . "campaigns";
		$this->bannerTable = $prefix . "banners";
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
	 function getVastStatistics(	$entity, // advertiser, campaign, banner
									$entityValue, // ID
									$dimension, // "campaign", "banner", "day", "week", "month", "year", "hour-of-day"
									$startDate, 
									$endDate,
									$entityFilterName = false,
									$entityFilterValue = false
									)
	{
		$startDateTime = $this->getDateTimeInUtc("$startDate 00:00:00");
		$endDateTime = $this->getDateTimeInUtc("$endDate 23:59:59");
//		echo $startDateTime . " / " . $endDateTime;
		$sqlFrom = $whereEntity = '';
		switch($entity) {
			case 'advertiser':
				$sqlFrom = $this->statsTable. " AS s 
							JOIN $this->bannerTable as b ON s.creative_id = b.bannerid
							JOIN $this->campaignTable AS c ON b.campaignid = c.campaignid";
				$whereEntity = "c.clientid = '$entityValue'";
			break;
			
			case 'campaign':
				$sqlFrom = $this->statsTable." AS s 
							JOIN ".$this->bannerTable." as b ON s.creative_id = b.bannerid
							";
				$whereEntity = "b.campaignid = '$entityValue'";
			break;
			
			case 'banner':
				$sqlFrom = $this->statsTable;
				$whereEntity = "creative_id = '$entityValue'";
			break;
		}
		$sqlSelectAsDimensionId = $this->getSqlDimensionFieldFromName($dimension);
		$sqlSelectAsDimensionName = $sqlSelectAsDimensionId;
		if($dimension == 'banner') { 
			$sqlSelectAsDimensionName = 'b.description';
		} else if($dimension == 'campaign') { 
			$sqlSelectAsDimensionName = 'c.campaignname';
		}
		
		if(!empty($entityFilterName)) {
			$entityFilterName = $this->getSqlDimensionFieldFromName( $entityFilterName );
			$whereEntity .= " AND $entityFilterName = '$entityFilterValue'";
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
		$result =  OA_DB::singleton()->queryAll($query);
        if (PEAR::isError($result)) {
           echo $result->getMessage();
           $result = array();
        }
		$dimensionToMetrics = array();
		foreach($result as $row) {
			$rowDimension = $row['dimension_id'];
			$rowDimensionName = $row['dimension_name'];
			$metricName = $row['event_id'];
			$metricValue = $row['count'];
			$dimensionToMetrics[$rowDimension][$metricName] = $metricValue;
			$dimensionToMetrics[$rowDimension]['name'] = $rowDimensionName;
		}
		
		
		// if segmented by date, we make sure all dates are set with at least an empty row (no gaps)
		$allRowNames = $this->getDateLabelsBetweenDates($startDate, $endDate, $dimension);
		if(!empty($allRowNames)) {
			$dimensionToMetricsFilled = array();
			foreach($allRowNames as $rowName) {
			    $value = array('name' => $rowName);
			    if(isset($dimensionToMetrics[$rowName])) {
			        $value = $dimensionToMetrics[$rowName];
			    }
			    $dimensionToMetricsFilled[$rowName] = $value;
			}
			$dimensionToMetrics = $dimensionToMetricsFilled;
		}
		return $dimensionToMetrics;
	}
	
	public function doesAdvertiserHasVast($entityId)
	{
	    $sqlFrom = $this->bannerTable ." AS b 
					JOIN ".$this->campaignTable." AS c 
					ON b.campaignid = c.campaignid";
		$sqlWhere = "c.clientid = $entityId";
		return  $this->doesEntityHasVast( $sqlFrom, $sqlWhere);
	}
	
	public function doesCampaignHasVast($entityId)
	{
	    $sqlFrom = $this->bannerTable ." AS b";
		$sqlWhere = "b.campaignid = $entityId";
		return  $this->doesEntityHasVast( $sqlFrom, $sqlWhere);
	} 
	
	public function doesBannerHasVast($entityId)
	{
	    $sqlFrom = $this->bannerTable ." AS b";
		$sqlWhere = "b.bannerid = $entityId";
		return  $this->doesEntityHasVast( $sqlFrom, $sqlWhere);
	} 
	
	protected function doesEntityHasVast($sqlFrom, $sqlWhere)
	{
	    $query = "	
		   SELECT count(*) as count
		   FROM $sqlFrom
		   WHERE $sqlWhere
		   		AND width = height
		 		AND (	width = ".VAST_OVERLAY_DIMENSIONS." 
		 			OR 	width = ".VAST_INLINE_DIMENSIONS.")
		   ";
	    
		$result =  OA_DB::singleton()->getOne($query);
//	    echo $result; echo $query;exit;
        if (PEAR::isError($result)) {
           echo $result->getMessage();
           return false;
        }
	    return $result > 0;
	}
	
	protected function getDateLabelsBetweenDates($startDate, $endDate, $dimension)
	{
	    if($dimension == 'hour-of-day') {
		    return array(
					'0h', '1h', '2h', '3h', '4h', '5h', '6h', '7h', '8h', '9h', '10h', '11h', 
					'12h', '13h', '14h', '15h', '16h', '17h', '18h', '19h', '20h', '21h', '22h', '23h',
				);
	    }
	    $startTimestamp = strtotime($startDate);
	    $endTimestamp = strtotime($endDate);
	    
    	switch($dimension) {
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
			    return array();
		    break;
    	}
    	while($startTimestamp <= $endTimestamp) {
    	    $dates[] = strftime($pattern, $startTimestamp);
    	    $startTimestamp = strtotime("+1 day", $startTimestamp);
    	}
	    return $dates;
	}
	
	protected function getSqlDimensionFieldFromName($dimension)
	{
		switch($dimension) {
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
			default: 
				exit("dimension $dimension not known"); 
			break;
		}
		return $sqlSelectAsDimensionId;
	}
	
	public function getSummaryRowFromDataTable($dimensionToMetrics)
	{
		$totalMetrics = array();
		foreach($dimensionToMetrics as $dimension => $metrics) {
			foreach($metrics as $metricId => $value) {
			    // make sure this event exists
			    if(!isset(self::$vastEventIdToEventName[$metricId])) {
			        continue;
			    }
				if(!isset($totalMetrics[$metricId])) {
					$totalMetrics[$metricId] = 0;
				}
				$totalMetrics[$metricId] += $value;
			}
		}
		// only works because we know there are no event_id == 0
		return array('Total') + $totalMetrics;
	}
	
	public function getColumnsIdToNameInOrder($firstColumnName)
	{
		$columnIdToName = array();
		foreach(self::$vastEventIdInOrder as $eventId) {
			$columnIdToName[$eventId] = self::$vastEventIdToEventName[$eventId];
		}
		// only works because we know there are no event_id == 0
		return array(0 => $firstColumnName) + $columnIdToName;
	}
	
	
	public function getDataTableForGraphCount($dataTable)
	{
		$dataTableWithColumnsToPlot = array();
		foreach($dataTable as $rowId => $columnsEventIdToValue) {
			foreach(self::$graphMetricsToPlot as $eventId) {
				$value = 0;
				if(isset($columnsEventIdToValue[$eventId])) {
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
		$dataTableWithColumnsToPlotPercentage = array();
		foreach($dataTableWithColumnsToPlot as $rowName => $columnsEventIdToValue) {
			$max = max($columnsEventIdToValue);
			foreach($columnsEventIdToValue as $eventId => $eventValue ) {
				$percentage = 0;
				if($max != 0) {
					$percentage = round(100 * $eventValue / $max);
				}
				$dataTableWithColumnsToPlotPercentage[$rowName][$eventId] = $percentage;
			}
		}
		return $dataTableWithColumnsToPlotPercentage;
	}
	
	public function generateFakeVastStatistics($pastDays, $bannerId, $zoneId)
	{
		echo "generating fake data...<br>";
		$oDbh = OA_DB::singleton();
		$now = time();
		$stop = $now - $pastDays*86400;
		while($now > $stop) {
			for($eventId = 1;$eventId <= 9; $eventId++) {
				// generate events inversely proportional to the event id, 
				// also make sure 25% happens more often than 50%
				$count = ceil(rand(1,1000) * 1/ ($eventId==2?3:($eventId==3?2:$eventId)));
				$query = "INSERT INTO {$this->statsTable} (
							`interval_start` ,
							`creative_id` ,
							`zone_id` ,
							`vast_event_id` ,
							`count`
							)
							VALUES (
							FROM_UNIXTIME(".$now."), '".$bannerId."', '".$zoneId."', '".$eventId."', '".$count."'
							)";
				$result =  $oDbh->queryAll($query);
				if (PEAR::isError($result))
				{
					break;
				}
			}
			$now = strtotime("1 hour ago", $now);
		}
		echo "done!";
	}
	
}


