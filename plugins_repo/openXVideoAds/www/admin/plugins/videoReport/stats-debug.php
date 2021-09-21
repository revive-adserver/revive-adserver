<?php
/**
    Testing & QA
    ============
    1 - Data Generator
        You can use the data generator to generate data directly in the stats_vast table.
        At the beginning of "/openx/www/admin/plugins/videoReport/stats-debug.php" you will find the related code.
        Note that you can customize the range of banner and zone id to generate.
    2 - Data checks
        Calling the API for all entities and all combination of "View As" ;
        look and set $outputAllCallGetStatistics to true in  "/openx/www/admin/plugins/videoReport/stats-debug.php"

    NOTE: To trigger the data generator or the data check, you just have to visit
    any of the "Video Report" tabs, in the Statistics section. Don't try and access stats-debug.php
    directly in your browser as it will fail.
*/

$videoReport = new OX_Video_Report();
// Generate fake stats?
// Note: you can generate for any campaign and banner; However if you generate stats for a non-vast banner
// and then try to access the UI for reporting of this non-vast banner, the "access check" will fail and
// the error "Menu system error: Manager::stats-vast-campaign not found for the current user" will be displayed.
$generateFakeStatistics = false;
if ($generateFakeStatistics) {
    $bannerIds = range($minBannerId = 1, $maxBannerId = 3, $step = 1);
    $zoneIds = range($minZoneId = 4, $maxZoneId = 5, $step = 1);
    $pastDays = 17;
    echo "generating fake data for " . count($bannerIds) . " banners and " . count($zoneIds) . " zones for the last " . $pastDays . " days...<br>";
    flush();
    foreach ($bannerIds as $bannerId) {
        foreach ($zoneIds as $zoneId) {
            $videoReport->generateFakeVastStatistics($pastDays, $bannerId, $zoneId);
        }
    }
    echo "done!";
    exit;
}

// Output all combinations of parameters for the getStatistics function?
$outputAllCallGetStatistics = false;
if ($outputAllCallGetStatistics) {
    $availableDimensions = [//"campaign", "banner", "zone",
                                "day", "week", "month", "year", "hour-of-day"];
    $availableEntities = [
        //entity name, entity id
        ['banner', 1],
        ['campaign', 1],
        ['advertiser', 1],
        ['website', 1],
        ['zone', 1],
    ];
    $startDate = '2009-05-09';
    $endDate = '2009-05-12';
    foreach ($availableDimensions as $dimension) {
        echo "<h1>Test '$dimension' (from $startDate to $endDate)</h1>";
        foreach ($availableEntities as $entityNameAndValue) {
            $entityName = $entityNameAndValue[0];
            $entityValue = $entityNameAndValue[1];
            echo "<h2>Test $entityName = $entityValue</h2>";
            var_dump($videoReport->getVastStatistics($entityName, $entityValue, $dimension, $startDate, $endDate));
        }
    }
    exit;
}
