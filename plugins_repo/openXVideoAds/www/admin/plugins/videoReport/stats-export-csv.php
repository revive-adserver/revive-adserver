<?php

$rows = [];
foreach ($dataTable as $rowName => $row) {
    $rows[] = [$rowName] + $row;
}
$toExport = array_merge(
    [ $columns ],
    $rows,
    [ $summaryRow ]
);
require_once "lib/Csv/Csv.php";
$filename = 'stats-video-' . $startDate . '-' . $endDate . '.csv';
header('Content-Disposition:attachment;filename=' . $filename);
header('Content-Type:application/vnd.ms-excel');
$csv = '';
foreach ($toExport as $row) {
    $csv .= OX_Vast_Common_Csv::formatCsvLine($row);
}
echo $csv;
exit;
