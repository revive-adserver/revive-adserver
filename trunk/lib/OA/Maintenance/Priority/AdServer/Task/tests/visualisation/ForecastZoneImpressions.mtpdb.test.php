<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
$Id$
*/

define('WEEKS', 2);
if (!defined('IMAGE_CANVAS_SYSTEM_FONT_PATH')) {
    define('IMAGE_CANVAS_SYSTEM_FONT_PATH', '/usr/share/fonts/msttcorefonts/');
}

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ForecastZoneImpressions.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/tests/visualisation/OA_Dal_Maintenance_Priority.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';
require_once MAX_PATH . '/lib/pear/Image/Canvas.php';
require_once MAX_PATH . '/lib/pear/Image/Graph.php';

set_time_limit(900);

/**
 * A class for testing the OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions extends UnitTestCase
{
    var $run;
    var $tblZones;
    var $tblBanners;
    var $tblAdZoneAssoc;
    var $tblDSZIH;


    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions()
    {
        $this->UnitTestCase();
        // Store the number of hours in defined weeks
        $this->run = WEEKS * 7 * 24;
        Mock::generate('MtceStatsLastRun');
        Mock::generate('MtcePriorityLastRun');
        Mock::generatePartial('OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions',
                              'PartialMock_OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions',
                              array('_getDal', '_init'));
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $this->tblZones = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['zones'],true);
        $this->tblBanners = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['banners'],true);
        $this->tblAdZoneAssoc = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['ad_zone_assoc'],true);
        $this->tblDSZIH = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['data_summary_zone_impression_history'],true);

    }

    /**
     * A test to see how zone impression forecasting work for a new zone,
     * using live data collected from a real zone. Uses a real database
     * connection to simplify the process of using the real collected
     * data.
     */
    function testNewZone()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Test_ForecastZoneImpressions($this);
        // Partially mock the OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions
        // class, and set the mocked _getDal() method to return the partially mocked DAL,
        // and the mocked _init() method (simply returns true)
        $oForecastZoneImpressions = new PartialMock_OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions($this);
        $oForecastZoneImpressions->setReturnReference('_getDal', $oDal);

        // Prepare the test data required for the test
        $query = "
            INSERT INTO
                {$this->tblZones}
                (
                    zoneid,
                    zonename,
                    zonetype,
                    category,
                    ad_selection,
                    chain,
                    prepend,
                    append
                )
            VALUES
                (
                    760,
                    'Sample Real Zone',
                    0,
                    '',
                    '',
                    '',
                    '',
                    ''
                )";
        $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$this->tblBanners}
                (
                    bannerid,
                    status,
                    htmltemplate,
                    htmlcache,
                    url,
                    compiledlimitation,
                    append,
                    bannertext
                )
            VALUES
                (
                    1,
                    ".OA_ENTITY_STATUS_RUNNING.",
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                )";
        $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$this->tblAdZoneAssoc}
                (
                    zone_id,
                    ad_id
                )
            VALUES
                (
                    760,
                    1
                )";
        $oDbh->exec($query);
        switch ($conf['database']['type']) {
            case 'pgsql':
                $query = "
                    COPY
                        {$this->tblDSZIH}
                    FROM
                        '" . MAX_PATH . "/lib/OA/Maintenance/Priority/AdServer/Task/tests/visualisation/ForecastZoneImpressions.sql'
                    WITH DELIMITER
                        '\t'";
                break;
            case 'mysql':
                $query = "
                    LOAD DATA INFILE
                        '" . MAX_PATH . "/lib/OA/Maintenance/Priority/AdServer/Task/tests/visualisation/ForecastZoneImpressions.sql'
                    INTO TABLE
                        {$this->tblDSZIH}
                    FIELDS TERMINATED BY
                        '\\t'
                    LINES TERMINATED BY
                        '\\n'";
                break;
        }
        $oDbh->exec($query);
        $query = "
            UPDATE
                {$this->tblDSZIH}
            SET
                forecast_impressions = NULL";
        $oDbh->exec($query);
        // Prepare the graph data sets
        $oDataSet_ForecastImpressions =& Image_Graph::factory('dataset');
        $oDataSet_ForecastImpressions->setName('Forecast Impressions');
        $oDataSet_ActualImpressions =& Image_Graph::factory('dataset');
        $oDataSet_ActualImpressions->setName('Actual Impressions');
        $oDataSet_Error =& Image_Graph::factory('dataset');
        $oDataSet_Error->setName('Error');
        // Run the forecasting over the test period
        $oDate = new Date('2005-04-01 00:00:07');
        $totalImpressions = 0;
        $totalError = 0;
        $totalAbsError = 0;
        $totalCounter = 0;
        for ($counter = 0; $counter < $this->run; $counter++) {
            $oForecastZoneImpressions->OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
            $oForecastZoneImpressions->oDateNow = new Date();
            $oForecastZoneImpressions->oDateNow->copy($oDate);
            $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates(
                $oForecastZoneImpressions->oDateNow
            );
            $oForecastZoneImpressions->oUpdateToDate = $aDates['end'];
            $oUpdatedToDate = new Date();
            $oUpdatedToDate->copy($oDate);
            $oUpdatedToDate->subtractSeconds(8); // Take back to end of previous hour
            $oForecastZoneImpressions->oStatisticsUpdatedToDate = $oUpdatedToDate;
            $oUpdatedToDate = new Date();
            $oUpdatedToDate->copy($oDate);
            $oUpdatedToDate->subtractSeconds(3608); // Take back to end of previous hour - 1 hour
            $oForecastZoneImpressions->priorityOperationInterval = $conf['maintenance']['operationInterval'];
            $oForecastZoneImpressions->oPriorityUpdatedToDate = $oMtcePriorityLastRun;
            // Forecast the impressions
            $oForecastZoneImpressions->run();
            // Add the forecast impressions to the data set
            $operationIntervalId = OA_OperationInterval::previousOperationIntervalID(OA_OperationInterval::convertDateToOperationIntervalID($oDate));
            $forecast = $GLOBALS['_MAX']['TEST']['forecastResult'][760][$operationIntervalId]['forecast_impressions'];
            if (is_null($forecast)) {
                $forecast = $GLOBALS['_MAX']['TEST']['previousForecastResult'][760][$operationIntervalId]['forecast_impressions'];
            }
            $oDataSet_ForecastImpressions->addPoint($counter, $forecast);
            // Add the actual impressions to the data set
            $interval_start = $GLOBALS['_MAX']['TEST']['forecastResult'][760][$operationIntervalId]['interval_start'];
            if (is_null($interval_start)) {
                $interval_start = $GLOBALS['_MAX']['TEST']['previousForecastResult'][760][$operationIntervalId]['interval_start'];
            }
            $interval_end = $GLOBALS['_MAX']['TEST']['forecastResult'][760][$operationIntervalId]['interval_end'];
            if (is_null($interval_end)) {
                $interval_end = $GLOBALS['_MAX']['TEST']['previousForecastResult'][760][$operationIntervalId]['interval_end'];
            }
            $query = "
                SELECT
                    actual_impressions
                FROM
                    {$this->tblDSZIH}
                WHERE
                    operation_interval = {$conf['maintenance']['operationInterval']}
                    AND operation_interval_id = $operationIntervalId
                    AND interval_start = '$interval_start'
                    AND interval_end = '$interval_end'
                    AND zone_id = 760";
            $aRow = $oDbh->queryRow($query);
            $actual = $aRow['actual_impressions'];
            $oDataSet_ActualImpressions->addPoint($counter, $actual);
            $totalImpressions += $actual;
            // Add the error data set
            $error = $actual - $forecast;
            $oDataSet_Error->addPoint($counter, abs($error));
            $totalError += $error;
            $totalAbsError += abs($error);
            $totalCounter++;
            // Update the hour being forecast
            $oDate->addSeconds(3600); // One hour
        }
        // Prepare the error data
        $averageError = ceil(abs($totalError) / $totalCounter);
        $averageErrorPercent = sprintf('%02.2f', $averageError / ceil($totalImpressions / $totalCounter) * 100);
        $averageAbsError = ceil($totalAbsError / $totalCounter);
        $averageAbsErrorPercent = sprintf('%02.2f', $averageAbsError / ceil($totalImpressions / $totalCounter) * 100);
        // Prepare the graph
        $antialias = false;
        if (function_exists('imageantialias')) {
            $antialias = true;
        }
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 480, 'antialias' => $antialias));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::vertical(
                    Image_Graph::factory('title', array('Zone Impression Forecast for New Zone over ' . WEEKS . ' Weeks', 12)),
                    Image_Graph::factory('title', array(
                        "Average Absolute Error: $averageAbsError ($averageAbsErrorPercent%)   " .
                        "Average Effective Error: $averageError ($averageErrorPercent%)",
                        8)),
                    80
                ),
                Image_Graph::vertical(
                    $oPlotarea = Image_Graph::factory('plotarea', array('axis', 'axis')),
                    $oLegend = Image_Graph::factory('legend'),
                    90
                ),
                10
            )
        );
        $oLegend->setPlotarea($oPlotarea);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_X);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_Y);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
        $oAxis->setTitle('Operation Intervals');
        $counter = 0;
        $aAxisLabels = array();
        while ($counter <= (WEEKS * 7 * 24)) {
            $counter += 24;
            $aAxisLabels[] = $counter;
        }
        $oAxis->setLabelInterval($aAxisLabels);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Impressions', 'vertical');
        // Ad the data sets to the graph
        $oPlot =& $oPlotarea->addNew('line', $oDataSet_Error);
        $oPlot->setLineColor('magenta');
        $oPlot =& $oPlotarea->addNew('line', $oDataSet_ForecastImpressions);
        $oPlot->setLineColor('red');
        $oPlot =& $oPlotarea->addNew('line', $oDataSet_ActualImpressions);
        $oPlot->setLineColor('green');
        // Complete and display the graph
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  ".png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt="" />' . "\n";
        TestEnv::restoreEnv();
    }

    /**
     * A test to see how zone impression forecasting work for an existing
     * zone, using live data collected from a real zone. Uses a real
     * database connection to simplify the process of using the real
     * collected data.
     */
    function testExistingZone()
    {
        $initialRun = 2 * 7 * 24;
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Test_ForecastZoneImpressions($this);
        // Partially mock the OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions
        // class, and set the mocked _getDal() method to return the partially mocked DAL,
        // and the mociked _init() method to always return true
        $oForecastZoneImpressions = new PartialMock_OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions($this);
        $oForecastZoneImpressions->setReturnReference('_getDal', $oDal);

        // Prepare the test data required for the test
        $query = "
            INSERT INTO
                {$this->tblZones}
                (
                    zoneid,
                    zonename,
                    zonetype,
                    category,
                    ad_selection,
                    chain,
                    prepend,
                    append
                )
            VALUES
                (
                    760,
                    'Sample Real Zone',
                    0,
                    '',
                    '',
                    '',
                    '',
                    ''
                )";
        $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$this->tblBanners}
                (
                    bannerid,
                    status,
                    htmltemplate,
                    htmlcache,
                    url,
                    bannertext,
                    compiledlimitation,
                    append
                )
            VALUES
                (
                    1,
                    ".OA_ENTITY_STATUS_RUNNING.",
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                )";
        $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$this->tblAdZoneAssoc}
                (
                    zone_id,
                    ad_id
                )
            VALUES
                (
                    760,
                    1
                )";
        $oDbh->exec($query);

        switch ($conf['database']['type']) {
            case "mysql":
                $query = "
                    LOAD DATA INFILE
                        '" . MAX_PATH . "/lib/OA/Maintenance/Priority/AdServer/Task/tests/visualisation/ForecastZoneImpressions.sql'
                    INTO TABLE
                        {$this->tblDSZIH}
                    FIELDS TERMINATED BY
                        '\\t'
                    LINES TERMINATED BY
                        '\\n'";
                break;
            case "pgsql":
                $query = "
                    COPY
                        {$this->tblDSZIH}
                    FROM
                        '" . MAX_PATH . "/lib/OA/Maintenance/Priority/AdServer/Task/tests/visualisation/ForecastZoneImpressions.sql'
                    WITH DELIMITER
                        '\t'";
                break;
        }
        $oDbh->exec($query);
        $query = "
            UPDATE
                {$this->tblDSZIH}
            SET
                forecast_impressions = NULL";
        $oDbh->exec($query);
        // Prepare the graph data sets
        $oDataSet_ForecastImpressions =& Image_Graph::factory('dataset');
        $oDataSet_ForecastImpressions->setName('Forecast Impressions');
        $oDataSet_ActualImpressions =& Image_Graph::factory('dataset');
        $oDataSet_ActualImpressions->setName('Actual Impressions');
        $oDataSet_Error =& Image_Graph::factory('dataset');
        $oDataSet_Error->setName('Error');
        // Run the forecasting over the test period
        $oDate = new Date('2005-04-01 00:00:07');
        $totalImpressions = 0;
        $totalError = 0;
        $totalAbsError = 0;
        $totalCounter = 0;
        for ($counter = 0; $counter < ($initialRun + $this->run); $counter++) {
            $oForecastZoneImpressions->OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
            $oForecastZoneImpressions->oDateNow = new Date();
            $oForecastZoneImpressions->oDateNow->copy($oDate);
            $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates(
                $oForecastZoneImpressions->oDateNow
            );
            $oForecastZoneImpressions->oUpdateToDate = $aDates['end'];
            $oUpdatedToDate = new Date();
            $oUpdatedToDate->copy($oDate);
            $oUpdatedToDate->subtractSeconds(8); // Take back to end of previous hour
            $oForecastZoneImpressions->oStatisticsUpdatedToDate = $oUpdatedToDate;
            $oUpdatedToDate = new Date();
            $oUpdatedToDate->copy($oDate);
            $oUpdatedToDate->subtractSeconds(3608); // Take back to end of previous hour - 1 hour
            $oForecastZoneImpressions->priorityOperationInterval = $conf['maintenance']['operationInterval'];
            $oForecastZoneImpressions->oPriorityUpdatedToDate = $oMtcePriorityLastRun;
            // Forecast the impressions
            $oForecastZoneImpressions->run();
            // Add the forecast impressions to the data set
            $operationIntervalId = OA_OperationInterval::previousOperationIntervalID(OA_OperationInterval::convertDateToOperationIntervalID($oDate));
            $forecast = $GLOBALS['_MAX']['TEST']['forecastResult'][760][$operationIntervalId]['forecast_impressions'];
            if (is_null($forecast)) {
                $forecast = $GLOBALS['_MAX']['TEST']['previousForecastResult'][760][$operationIntervalId]['forecast_impressions'];
            }
            if ($counter >= $initialRun) {
                $oDataSet_ForecastImpressions->addPoint($counter - $initialRun, $forecast);
            }
            // Add the actual impressions to the data set
            $interval_start = $GLOBALS['_MAX']['TEST']['forecastResult'][760][$operationIntervalId]['interval_start'];
            if (is_null($interval_start)) {
                $interval_start = $GLOBALS['_MAX']['TEST']['previousForecastResult'][760][$operationIntervalId]['interval_start'];
            }
            $interval_end = $GLOBALS['_MAX']['TEST']['forecastResult'][760][$operationIntervalId]['interval_end'];
            if (is_null($interval_end)) {
                $interval_end = $GLOBALS['_MAX']['TEST']['previousForecastResult'][760][$operationIntervalId]['interval_end'];
            }
            $query = "
                SELECT
                    actual_impressions
                FROM
                    {$this->tblDSZIH}
                WHERE
                    operation_interval = {$conf['maintenance']['operationInterval']}
                    AND operation_interval_id = $operationIntervalId
                    AND interval_start = '$interval_start'
                    AND interval_end = '$interval_end'
                    AND zone_id = 760";
            $aRow = $oDbh->queryRow($query);
            $actual = $aRow['actual_impressions'];
            if ($counter >= $initialRun) {
                $oDataSet_ActualImpressions->addPoint($counter - $initialRun, $actual);
                $totalImpressions += $actual;
            }
            // Add the error data set
            $error = $actual - $forecast;
            if ($counter >= $initialRun) {
                $oDataSet_Error->addPoint($counter - $initialRun, abs($error));
                $totalError += $error;
                $totalAbsError += abs($error);
                $totalCounter++;
            }
            // Update the hour being forecast
            $oDate->addSeconds(3600); // One hour
        }
        // Prepare the error data
        $averageError = ceil(abs($totalError) / $totalCounter);
        $averageErrorPercent = sprintf('%02.2f', $averageError / ceil($totalImpressions / $totalCounter) * 100);
        $averageAbsError = ceil($totalAbsError / $totalCounter);
        $averageAbsErrorPercent = sprintf('%02.2f', $averageAbsError / ceil($totalImpressions / $totalCounter) * 100);
        // Prepare the graph
        $antialias = false;
        if (function_exists('imageantialias')) {
            $antialias = true;
        }
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 480, 'antialias' => $antialias));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::vertical(
                    Image_Graph::factory('title', array('Zone Impression Forecast for Existing Zone over ' . WEEKS . ' Weeks', 12)),
                    Image_Graph::factory('title', array(
                        "Average Absolute Error: $averageAbsError ($averageAbsErrorPercent%)   " .
                        "Average Effective Error: $averageError ($averageErrorPercent%)",
                        8)),
                    80
                ),
                Image_Graph::vertical(
                    $oPlotarea = Image_Graph::factory('plotarea', array('axis', 'axis')),
                    $oLegend = Image_Graph::factory('legend'),
                    90
                ),
                10
            )
        );
        $oLegend->setPlotarea($oPlotarea);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_X);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_Y);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
        $oAxis->setTitle('Operation Intervals');
        $counter = 0;
        $aAxisLabels = array();
        while ($counter <= (WEEKS * 7 * 24)) {
            $counter += 24;
            $aAxisLabels[] = $counter;
        }
        $oAxis->setLabelInterval($aAxisLabels);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Impressions', 'vertical');
        // Ad the data sets to the graph
        $oPlot =& $oPlotarea->addNew('line', $oDataSet_Error);
        $oPlot->setLineColor('magenta');
        $oPlot =& $oPlotarea->addNew('line', $oDataSet_ForecastImpressions);
        $oPlot->setLineColor('red');
        $oPlot =& $oPlotarea->addNew('line', $oDataSet_ActualImpressions);
        $oPlot->setLineColor('green');
        // Complete and display the graph
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  ".png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt="" />' . "\n";
        TestEnv::restoreEnv();
    }

    /**
     * A test to see how zone impression forecasting work for the existing
     * zone above, but being treated as a new zone. Uses a real database
     * connection to simplify the process of using the real collected
     * data.
     */
    function testExistingZoneAsNew()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Test_ForecastZoneImpressions($this);
        // Partially mock the OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions
        // class, and set the mocked _getDal() method to return the partially mocked DAL,
        // and the mociked _init() method to always return true
        $oForecastZoneImpressions = new PartialMock_OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions($this);
        $oForecastZoneImpressions->setReturnReference('_getDal', $oDal);

        // Prepare the test data required for the test
        $query = "
            INSERT INTO
                {$this->tblZones}
                (
                    zoneid,
                    zonename,
                    zonetype,
                    category,
                    ad_selection,
                    chain,
                    prepend,
                    append
                )
            VALUES
                (
                    760,
                    'Sample Real Zone',
                    0,
                    '',
                    '',
                    '',
                    '',
                    ''
                )";
        $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$this->tblBanners}
                (
                    bannerid,
                    status,
                    htmltemplate,
                    htmlcache,
                    url,
                    bannertext,
                    compiledlimitation,
                    append
                )
            VALUES
                (
                    1,
                    ".OA_ENTITY_STATUS_RUNNING.",
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                )";
        $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$this->tblAdZoneAssoc}
                (
                    zone_id,
                    ad_id
                )
            VALUES
                (
                    760,
                    1
                )";
        $oDbh->exec($query);

        switch ($conf['database']['type']) {
            case 'mysql':
                $query = "
                    LOAD DATA INFILE
                        '" . MAX_PATH . "/lib/OA/Maintenance/Priority/AdServer/Task/tests/visualisation/ForecastZoneImpressions.sql'
                    INTO TABLE
                        {$this->tblDSZIH}
                    FIELDS TERMINATED BY
                        '\\t'
                    LINES TERMINATED BY
                        '\\n'";
                break;
            case 'pgsql':
                $query = "
                    COPY
                        {$this->tblDSZIH}
                    FROM
                        '" . MAX_PATH . "/lib/OA/Maintenance/Priority/AdServer/Task/tests/visualisation/ForecastZoneImpressions.sql'
                    WITH DELIMITER
                        '\t'";
                break;
        }
        $oDbh->exec($query);
        $query = "
            UPDATE
                {$this->tblDSZIH}
            SET
                forecast_impressions = NULL";
        $oDbh->exec($query);
        // Prepare the graph data sets
        $oDataSet_ForecastImpressions =& Image_Graph::factory('dataset');
        $oDataSet_ForecastImpressions->setName('Forecast Impressions');
        $oDataSet_ActualImpressions =& Image_Graph::factory('dataset');
        $oDataSet_ActualImpressions->setName('Actual Impressions');
        $oDataSet_Error =& Image_Graph::factory('dataset');
        $oDataSet_Error->setName('Error');
        // Run the forecasting over the test period
        $oDate = new Date('2005-04-01 00:00:07');
        // Add the required number of weeks to the start date
        $oDate->addSeconds(WEEKS * 7 * 24 * 60 * 60);
        // Delete the existing data that comes before this date
        $query = "
            DELETE FROM
                {$this->tblDSZIH}
            WHERE
                interval_start < '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'";
        $oDbh->exec($query);
        $totalImpressions = 0;
        $totalError = 0;
        $totalAbsError = 0;
        $totalCounter = 0;
        for ($counter = 0; $counter < $this->run; $counter++) {
            $oForecastZoneImpressions->OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
            $oForecastZoneImpressions->oDateNow = new Date();
            $oForecastZoneImpressions->oDateNow->copy($oDate);
            $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates(
                $oForecastZoneImpressions->oDateNow
            );
            $oForecastZoneImpressions->oUpdateToDate = $aDates['end'];
            $oUpdatedToDate = new Date();
            $oUpdatedToDate->copy($oDate);
            $oUpdatedToDate->subtractSeconds(8); // Take back to end of previous hour
            $oForecastZoneImpressions->oStatisticsUpdatedToDate = $oUpdatedToDate;
            $oUpdatedToDate = new Date();
            $oUpdatedToDate->copy($oDate);
            $oUpdatedToDate->subtractSeconds(3608); // Take back to end of previous hour - 1 hour
            $oForecastZoneImpressions->priorityOperationInterval = $conf['maintenance']['operationInterval'];
            $oForecastZoneImpressions->oPriorityUpdatedToDate = $oMtcePriorityLastRun;
            // Forecast the impressions
            $oForecastZoneImpressions->run();
            // Add the forecast impressions to the data set
            $operationIntervalId = OA_OperationInterval::previousOperationIntervalID(OA_OperationInterval::convertDateToOperationIntervalID($oDate));
            $forecast = $GLOBALS['_MAX']['TEST']['forecastResult'][760][$operationIntervalId]['forecast_impressions'];
            if (is_null($forecast)) {
                $forecast = $GLOBALS['_MAX']['TEST']['previousForecastResult'][760][$operationIntervalId]['forecast_impressions'];
            }
            $oDataSet_ForecastImpressions->addPoint($counter, $forecast);
            // Add the actual impressions to the data set
            $interval_start = $GLOBALS['_MAX']['TEST']['forecastResult'][760][$operationIntervalId]['interval_start'];
            if (is_null($interval_start)) {
                $interval_start = $GLOBALS['_MAX']['TEST']['previousForecastResult'][760][$operationIntervalId]['interval_start'];
            }
            $interval_end = $GLOBALS['_MAX']['TEST']['forecastResult'][760][$operationIntervalId]['interval_end'];
            if (is_null($interval_end)) {
                $interval_end = $GLOBALS['_MAX']['TEST']['previousForecastResult'][760][$operationIntervalId]['interval_end'];
            }
            $query = "
                SELECT
                    actual_impressions
                FROM
                    {$this->tblDSZIH}
                WHERE
                    operation_interval = {$conf['maintenance']['operationInterval']}
                    AND operation_interval_id = $operationIntervalId
                    AND interval_start = '$interval_start'
                    AND interval_end = '$interval_end'
                    AND zone_id = 760";
            $aRow = $oDbh->queryRow($query);
            $actual = $aRow['actual_impressions'];
            $oDataSet_ActualImpressions->addPoint($counter, $actual);
            $totalImpressions += $actual;
            // Add the error data set
            $error = $actual - $forecast;
            $oDataSet_Error->addPoint($counter, abs($error));
            $totalError += $error;
            $totalAbsError += abs($error);
            $totalCounter++;
            // Update the hour being forecast
            $oDate->addSeconds(3600); // One hour
        }
        // Prepare the error data
        $averageError = ceil(abs($totalError) / $totalCounter);
        $averageErrorPercent = sprintf('%02.2f', $averageError / ceil($totalImpressions / $totalCounter) * 100);
        $averageAbsError = ceil($totalAbsError / $totalCounter);
        $averageAbsErrorPercent = sprintf('%02.2f', $averageAbsError / ceil($totalImpressions / $totalCounter) * 100);
        // Prepare the graph
        $antialias = false;
        if (function_exists('imageantialias')) {
            $antialias = true;
        }
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 480, 'antialias' => $antialias));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::vertical(
                    Image_Graph::factory('title', array('Zone Impression Forecast for Existing Zone (as New) over ' . WEEKS . ' Weeks', 12)),
                    Image_Graph::factory('title', array(
                        "Average Absolute Error: $averageAbsError ($averageAbsErrorPercent%)   " .
                        "Average Effective Error: $averageError ($averageErrorPercent%)",
                        8)),
                    80
                ),
                Image_Graph::vertical(
                    $oPlotarea = Image_Graph::factory('plotarea', array('axis', 'axis')),
                    $oLegend = Image_Graph::factory('legend'),
                    90
                ),
                10
            )
        );
        $oLegend->setPlotarea($oPlotarea);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_X);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_Y);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
        $oAxis->setTitle('Operation Intervals');
        $counter = 0;
        $aAxisLabels = array();
        while ($counter <= (WEEKS * 7 * 24)) {
            $counter += 24;
            $aAxisLabels[] = $counter;
        }
        $oAxis->setLabelInterval($aAxisLabels);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Impressions', 'vertical');
        // Ad the data sets to the graph
        $oPlot =& $oPlotarea->addNew('line', $oDataSet_Error);
        $oPlot->setLineColor('magenta');
        $oPlot =& $oPlotarea->addNew('line', $oDataSet_ForecastImpressions);
        $oPlot->setLineColor('red');
        $oPlot =& $oPlotarea->addNew('line', $oDataSet_ActualImpressions);
        $oPlot->setLineColor('green');
        // Complete and display the graph
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  ".png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt="" />' . "\n";
        TestEnv::restoreEnv();
    }

}

?>
