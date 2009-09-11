<?php
require_once '../../../../init.php';
require_once '../../config.php';
require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';

$inputVariables = array( 
	'entity', 'entityId',
	'startDate', 'endDate', 'dimension',
	'exportCsv', 'showAs', 'expandId');
MAX_commonRegisterGlobalsArray($inputVariables);
PEAR::pushErrorHandling(null);

require_once 'stats-api.php';
require_once 'stats-debug.php';
include_once 'lib/SmartyFunctions/function.url.php';
include_once 'lib/SmartyFunctions/modifier.formatNumber.php';
include_once 'VastAreaGraph.php';
include_once 'VastMultiAreaGraph.php';

// Entity 
$availableEntities = array(
	'advertiser',
	'campaign',
	'banner',
    'website',
    'zone'
);
if(!in_array($entity, $availableEntities))
{
	exit("Invalid input parameters");
}

$entityToRequiredAccess = array(
    'advertiser' => 'clients',
    'campaign' => 'campaigns',
    'banner' => 'banners',
    'website' => 'affiliates',
    'zone' => 'zones',
);
OA_Permission::enforceAccessToObject($entityToRequiredAccess[$entity], $entityId);
$entityId = (int)$entityId;
$startDate = urlencode($startDate);
$endDate = urlencode($endDate);

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
if($entity == 'website') {
    $availableDimensions['zone'] = "Zone";
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
$videoReport = new OX_Video_Report();
$dataTable = $videoReport->getVastStatistics(
									$entity, 
									$entityId,
									$dimension,
									$startDate,
									$endDate );
$columns = $videoReport->getColumnsIdToNameInOrder($availableDimensions[$dimension]);
$summaryRow = $videoReport->getSummaryRowFromDataTable($dataTable);

if(!empty($exportCsv)) {
	require_once "stats-export-csv.php";
    exit;
}

$graphMetricsToPlot = OX_Video_Report::$graphMetricsToPlot; 
$graphEventsIdToName = $graphValues = array();
foreach($graphMetricsToPlot as $eventId) {
    $value = 0;
    if(isset($summaryRow[$eventId])) {
       $value = $summaryRow[$eventId];
    }
	$graphValues[$eventId] = $value;
	$graphEventsIdToName[$eventId] = OX_Video_Report::$vastEventIdToEventName[$eventId];
}
$topGraph = new VastAreaGraph($graphValues, $graphEventsIdToName);
$topGraphJSON = $topGraph->getJSON();
//var_dump($topGraphJSON);exit;
if($selectedShowAs != 'table') {
	if($selectedShowAs == 'graph-count') {
		$dataTableXLabelToDataSets = $videoReport->getDataTableForGraphCount($dataTable);
		$isPlottingPercentage = false;
	} elseif ($selectedShowAs == 'graph-percentage') {
		$dataTableXLabelToDataSets = $videoReport->getDataTableForGraphPercentage($dataTable);
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
} elseif($selectedDimension == 'zone') {
	// Zones do not expand
	$selectedDimensionExpanded = false;
} else if($entity == 'advertiser') {
	// Date expands to show Sub Campaigns when looking at an advertiser
	$selectedDimensionExpanded = 'campaign';
} else if($entity == 'campaign') {
	// Date expands to show Sub Banners when looking at a campaign
	$selectedDimensionExpanded = 'banner';
} else if($entity == 'website') {
	// Websites expand to Zones
	$selectedDimensionExpanded = 'zone';
} else{
	// Date do not expand when looking at Banners or Zones
	$selectedDimensionExpanded = false;
}

if($selectedDimensionExpanded && !empty($expandId)) {
	$expandedDataTable = $videoReport->getVastStatistics(
									$entity, 
									$entityId,
									$selectedDimensionExpanded,
									$startDate,
									$endDate,
									$dimension,
									$expandId 
									 );
}
$isThereAnyData = @$summaryRow[1] > 0;
// TEMPLATE
$oTpl = new OA_Plugin_Template('video-report.html', 'openXVideoAds');
$oTpl->register_function('url', 'smarty_function_url');
$oTpl->register_modifier('formatNumber', 'smarty_modifier_formatNumber');
$oTpl->assign('isThereAnyData', $isThereAnyData );
$oTpl->assign('isThereAtLeastTwoDataPoints', $isThereAtLeastTwoDataPoints );
$oTpl->assign('entityName', ucfirst($entity));
$oTpl->assign('dataForTopGraphInJsonFormat', $topGraphJSON );
$oTpl->assign('dataForBottomGraphInJsonFormat', $bottomGraphJSON );
$oTpl->assign('dataTable', $dataTable);
$oTpl->assign('expandedDataTable', $expandedDataTable);
$oTpl->assign('selectedDimensionExpanded', urlencode($selectedDimensionExpanded));
$oTpl->assign('columns', $columns);
$oTpl->assign('summaryRow', $summaryRow);
$oTpl->assign('availableDateRanges', $availableDateRanges);
$oTpl->assign('thirtyDaysAgo', $thirtyDaysAgo);
$oTpl->assign('expandId', urlencode($expandId));
$oTpl->assign('today', $today);
$oTpl->assign('startDate', $startDate); 
$oTpl->assign('endDate', $endDate);
$oTpl->assign('selectedDateRangeName', $selectedDateRangeName);
$oTpl->assign('availableDimensions', $availableDimensions);
$oTpl->assign('selectedDimension', urlencode($selectedDimension));
$oTpl->assign('availableShowAs', $availableShowAs);
$oTpl->assign('selectedShowAs', urlencode($selectedShowAs));

// VIEW
phpAds_PageHeader("stats-vast-".$entity,'','../../');
$oTpl->display();
phpAds_PageFooter();
