<?php
$rows = array();
foreach($dataTable as $rowName => $row) {
	$rows[] = array($rowName) + $row;
}
$toExport = array_merge(
				array( $columns ),
				$rows,
				array( $summaryRow ) );
require_once "lib/Csv/Csv.php";
$filename = 'stats-video-'.$startDate.'-'.$endDate.'.csv';
header('Content-Disposition:attachment;filename='.$filename);
header('Content-Type:application/vnd.ms-excel');
$csv = '';
foreach($toExport as $row) {
	$csv .= OX_Vast_Common_Csv::formatCsvLine($row);
}
echo $csv; 
exit;
