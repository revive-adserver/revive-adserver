<?php
require_once '../../../../init.php';
require_once '../../config.php';
require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';

phpAds_registerGlobal(
	'entity', 'entityId',
	'startDate', 'endDate', 'dimension',
	'exportCsv', 'showAs', 'expandId'
);
PEAR::pushErrorHandling(null);

require_once 'stats-api.php';
include_once 'lib/SmartyFunctions/function.url.php';
include_once 'lib/SmartyFunctions/modifier.formatNumber.php';
include_once 'VastAreaGraph.php';
include_once 'VastMultiAreaGraph.php';

// Entity 
$availableEntityToEntityIdName = array(
	'advertiser',
	'campaign',
	'banner'
);
if(!in_array($entity, $availableEntityToEntityIdName))
{
	exit("Invalid input parameters");
}

// "Show as" dropdown
$availableShowAs = array(
	'table' => "Table",
	'graph-percentage' => "Graph (% of views)",
	'graph-count' => "Graph (# of views)",
);
if(empty($showAs) || !isset($availableShowAs[$showAs])) {
	$showAs = 'table';
}
$selectedShowAs = $showAs;

// "View by" dimension
$availableDimensions = array();
if(in_array($entity, array('campaign', 'advertiser'))) {
	$availableDimensions['banner'] = "Banner";
	if($entity == 'advertiser') {
		$availableDimensions['campaign'] = "Campaign";
	}
}
$availableDimensions += array(
	"day" => "Day", 
	"week" => "Week", 
	"month" => "Month", 
	"year" => "Year", 
	"hour-of-day" => "Hour of Day"
);
if(empty($dimension)) {
	$dimension = 'day';
}

// if show as "graph" but dimension by campaign or banner, 
// reset dimension to day: we only graph date by default
//if($selectedShowAs != 'table'
//	&& (in_array($dimension, array('campaign', 'banner')))) {
//	$dimension = 'day';
//}
$selectedDimension = $dimension;

// Period preset in calendar
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('1 day ago'));
$sevenDaysAgo = date('Y-m-d', strtotime('7 days ago'));
$thirtyDaysAgo = date('Y-m-d', strtotime('30 days ago'));
$availableDateRanges = array(
	'Today' => array($today, $today),
	'Yesterday' => array($yesterday, $yesterday),
	'Last 7 days' => array($sevenDaysAgo, $today),
	'Last 30 days' => array($thirtyDaysAgo, $today),
);
if(empty($startDate) || empty($endDate)) {
	$defaultDateRange = 'Last 7 days';
	$startDate = $availableDateRanges[$defaultDateRange][0];
	$endDate = $availableDateRanges[$defaultDateRange][1];
}
if(($selectedDateRangeName = array_search(array($startDate,$endDate), $availableDateRanges)) === false) {
	$selectedDateRangeName = "$startDate - $endDate";
}


// BUILDING REPORT
$vastReport = new OX_Vast_Report();
$dataTable = $vastReport->getVastStatistics(
									$entity, 
									$entityId,
									$dimension,
									$startDate,
									$endDate );
$columns = $vastReport->getColumnsIdToNameInOrder($availableDimensions[$dimension]);
$summaryRow = $vastReport->getSummaryRowFromDataTable($dataTable);

if(!empty($exportCsv)) {
	require_once "stats-export-csv.php";
    exit;
}

$graphMetricsToPlot = OX_Vast_Report::$graphMetricsToPlot; 
$graphEventsIdToName = $graphValues = array();
foreach($graphMetricsToPlot as $eventId) {
    $value = 0;
    if(isset($summaryRow[$eventId])) {
       $value = $summaryRow[$eventId];
    }
	$graphValues[$eventId] = $value;
	$graphEventsIdToName[$eventId] = OX_Vast_Report::$vastEventIdToEventName[$eventId];
}
$topGraph = new VastAreaGraph($graphValues, $graphEventsIdToName);
$topGraphJSON = $topGraph->getJSON();
//var_dump($topGraphJSON);exit;
if($selectedShowAs != 'table') {
	if($selectedShowAs == 'graph-count') {
		$dataTableXLabelToDataSets = $vastReport->getDataTableForGraphCount($dataTable);
		$isPlottingPercentage = false;
	} elseif ($selectedShowAs == 'graph-percentage') {
		$dataTableXLabelToDataSets = $vastReport->getDataTableForGraphPercentage($dataTable);
		$isPlottingPercentage = true;
	}
	$bottomGraph = new VastMultiAreaGraph($dataTableXLabelToDataSets, $graphEventsIdToName, $isPlottingPercentage);
	$bottomGraphJSON = $bottomGraph->getJSON();
}

// Expanded row
if($selectedDimension == 'campaign') {
	// Campaigns expand to Banners
	$selectedDimensionExpanded = 'banner';
} elseif($selectedDimension == 'banner') {
	// Banners do not expand
	$selectedDimensionExpanded = false;
} else {
	if($entity == 'advertiser') {
		// Date expands to show Sub Campaigns when looking at an advertiser
		$selectedDimensionExpanded = 'campaign';
	} else if($entity == 'campaign') {
		// Date expands to show Sub Banners when looking at a campaign
		$selectedDimensionExpanded = 'banner';
	} else {
		// Date do not expand when looking at Banners
		$selectedDimensionExpanded = false;
	}
}
if($selectedDimensionExpanded && !empty($expandId)) {
	$expandedDataTable = $vastReport->getVastStatistics(
									$entity, 
									$entityId,
									$selectedDimensionExpanded,
									$startDate,
									$endDate,
									$dimension,
									$expandId
									 );
}
// TEMPLATE
$oTpl = new OA_Plugin_Template('vast-report.html', 'TODO title');
$oTpl->register_function('url', 'smarty_function_url');
$oTpl->register_modifier('formatNumber', 'smarty_modifier_formatNumber');
$oTpl->assign('dataForTopGraphInJsonFormat', $topGraphJSON );
$oTpl->assign('dataForBottomGraphInJsonFormat', $bottomGraphJSON );
$oTpl->assign('dataTable', $dataTable);
$oTpl->assign('expandedDataTable', $expandedDataTable);
$oTpl->assign('selectedDimensionExpanded', $selectedDimensionExpanded);
$oTpl->assign('columns', $columns);
$oTpl->assign('summaryRow', $summaryRow);
$oTpl->assign('availableDateRanges', $availableDateRanges);
$oTpl->assign('thirtyDaysAgo', $thirtyDaysAgo);
$oTpl->assign('expandId', $expandId);
$oTpl->assign('today', $today);
$oTpl->assign('startDate', $startDate);
$oTpl->assign('endDate', $endDate);
$oTpl->assign('selectedDateRangeName', $selectedDateRangeName);
$oTpl->assign('availableDimensions', $availableDimensions);
$oTpl->assign('selectedDimension', $selectedDimension);
$oTpl->assign('availableShowAs', $availableShowAs);
$oTpl->assign('selectedShowAs', $selectedShowAs);

// VIEW
phpAds_PageHeader("stats-vast-".$entity,'','../../');
$oTpl->display();
phpAds_PageFooter();
