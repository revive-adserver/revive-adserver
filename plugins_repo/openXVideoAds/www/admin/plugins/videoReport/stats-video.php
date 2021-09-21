<?php

require_once '../../../../init.php';
require_once '../../config.php';
require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';

$inputVariables = [
    'entity', 'entityId',
    'startDate', 'endDate', 'dimension',
    'exportCsv', 'showAs', 'expandId'];
MAX_commonRegisterGlobalsArray($inputVariables);
PEAR::pushErrorHandling(null);

require_once 'stats-api.php';
require_once 'stats-debug.php';
include_once 'lib/SmartyFunctions/function.url.php';
include_once 'lib/SmartyFunctions/modifier.formatNumber.php';

// Entity
$availableEntities = [
    'advertiser',
    'campaign',
    'banner',
    'website',
    'zone'
];
if (!in_array($entity, $availableEntities)) {
    exit("Invalid input parameters");
}

$entityToRequiredAccess = [
    'advertiser' => 'clients',
    'campaign' => 'campaigns',
    'banner' => 'banners',
    'website' => 'affiliates',
    'zone' => 'zones',
];
OA_Permission::enforceAccessToObject($entityToRequiredAccess[$entity], $entityId);
$entityId = (int)$entityId;
$startDate = urlencode($startDate);
$endDate = urlencode($endDate);

// "View by" dimension
$availableDimensions = [];
if (in_array($entity, ['campaign', 'advertiser'])) {
    $availableDimensions['banner'] = "Banner";
    if ($entity == 'advertiser') {
        $availableDimensions['campaign'] = "Campaign";
    }
}
if ($entity == 'website') {
    $availableDimensions['zone'] = "Zone";
}
$availableDimensions += [
    "day" => "Day",
    "week" => "Week",
    "month" => "Month",
    "year" => "Year",
    "hour-of-day" => "Hour of Day"
];
if (empty($dimension)) {
    $dimension = 'day';
}
$selectedDimension = $dimension;

// Period preset in calendar
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('1 day ago'));
$sevenDaysAgo = date('Y-m-d', strtotime('7 days ago'));
$thirtyDaysAgo = date('Y-m-d', strtotime('30 days ago'));
$availableDateRanges = [
    'Today' => [$today, $today],
    'Yesterday' => [$yesterday, $yesterday],
    'Last 7 days' => [$sevenDaysAgo, $today],
    'Last 30 days' => [$thirtyDaysAgo, $today],
];
if (empty($startDate) || empty($endDate)) {
    $defaultDateRange = 'Last 7 days';
    $startDate = $availableDateRanges[$defaultDateRange][0];
    $endDate = $availableDateRanges[$defaultDateRange][1];
}
if (($selectedDateRangeName = array_search([$startDate, $endDate], $availableDateRanges)) === false) {
    $selectedDateRangeName = "$startDate - $endDate";
}

// BUILDING REPORT
$videoReport = new OX_Video_Report();
$dataTable = $videoReport->getVastStatistics(
    $entity,
    $entityId,
    $dimension,
    $startDate,
    $endDate
);
$columns = $videoReport->getColumnsIdToNameInOrder($availableDimensions[$dimension]);
$summaryRow = $videoReport->getSummaryRowFromDataTable($dataTable);

if (!empty($exportCsv)) {
    require_once "stats-export-csv.php";
    exit;
}

// Expanded row
if ($selectedDimension == 'campaign') {
    // Campaigns expand to Banners
    $selectedDimensionExpanded = 'banner';
} elseif ($selectedDimension == 'banner') {
    // Banners do not expand
    $selectedDimensionExpanded = false;
} elseif ($selectedDimension == 'zone') {
    // Zones do not expand
    $selectedDimensionExpanded = false;
} elseif ($entity == 'advertiser') {
    // Date expands to show Sub Campaigns when looking at an advertiser
    $selectedDimensionExpanded = 'campaign';
} elseif ($entity == 'campaign') {
    // Date expands to show Sub Banners when looking at a campaign
    $selectedDimensionExpanded = 'banner';
} elseif ($entity == 'website') {
    // Websites expand to Zones
    $selectedDimensionExpanded = 'zone';
} else {
    // Date do not expand when looking at Banners or Zones
    $selectedDimensionExpanded = false;
}

if ($selectedDimensionExpanded && !empty($expandId)) {
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
$oTpl->assign('isThereAnyData', $isThereAnyData);
$oTpl->assign('entityName', ucfirst($entity));
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

// VIEW
phpAds_PageHeader("stats-vast-" . $entity, '', '../../');
$oTpl->display();
phpAds_PageFooter();
