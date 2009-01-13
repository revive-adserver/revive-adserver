<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

if (!defined('IMAGE_CANVAS_SYSTEM_FONT_PATH')) {
    define('IMAGE_CANVAS_SYSTEM_FONT_PATH', '/usr/share/fonts/msttcorefonts/');
}

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/PriorityCompensation.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Image/Canvas.php';
require_once MAX_PATH . '/lib/pear/Image/Graph.php';

/**
 * A class for testing the OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation()
    {
        $this->UnitTestCase();
        Mock::generate('OA_Dal_Maintenance_Priority');
        Mock::generatePartial(
            'OA_Maintenance_Priority_AdServer_Task_PriorityCompensation',
            'PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation',
            array('_getDal')
        );
    }

    /**
     * A method to visually test the learnedPriorities() method.
     *
     * Tests a series of operation intervals for a zone where some ads are limited
     * to appear only in certain "channels" of the zone, and display the results
     * graphically. Uses a fixed number of impressions in the zone each operation
     * interval.
     */
    function testLearnedPrioritiesStableZoneInvetory()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Mock the OA_Dal_Maintenance_Priority class
        $oDal = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);
        // Partially mock the OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class
        $oPriorityCompensation = new PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation($this);
        $oPriorityCompensation->setReturnReference('_getDal', $oDal);
        $oPriorityCompensation->OA_Maintenance_Priority_AdServer_Task_PriorityCompensation();
        // Define the number of iterations to test over
        $iterations = 10;
        // Define how many impressions are in the zone each iteration
        $zoneImpressions = 10000;
        // Define the channels, including the % of zone impressions in each
        $aChannels[1] = 0.10; // Channel 1:  10% of zone traffic
        $aChannels[2] = 0.02; // Channel 2:   2% of zone traffic
        // Define the ads, including the required impressions each iteration,
        // the channel the ad is limited to (if any) and the colour to use in
        // the graph of results
        $aAds[1] = array(
            'impressions' => 5000,
            'channel' => null,
            'colour' => 'red'
        );
        $aAds[2] = array(
            'impressions' => 1500,
            'channel' => 1,
            'colour' => 'blue'
        );
        $aAds[3] = array(
            'impressions' => 750,
            'channel' => 2,
            'colour' => 'green'
        );
        // Preapare the graph data sets, ready to accept test data
        foreach ($aAds as $adKey => $aAdData) {
            // Add the new data to the graph of the results
            $dataSetName = 'oDataSet_Ad' . $adKey . '_RequiredImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey . ': Required Impressions');
            $dataSetName = 'oDataSet_Ad' . $adKey . '_AvailableImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey . ': Available Impressions');
            $dataSetName = 'oDataSet_Ad' . $adKey . '_ActualImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey . ': Delivered Impressions');
        }
        $oDataSetBestError =& Image_Graph::factory('dataset');
        $oDataSetBestError->setName('Least Possible Error In Delivery');
        $oDataSetTotalError =& Image_Graph::factory('dataset');
        $oDataSetTotalError->setName('Total Error In Delivery');
        // Prepare the ads/zone for the initial iteration
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = $zoneImpressions;
        foreach ($aAds as $adKey => $aAdData) {
            $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
            $oAd->requiredImpressions = $aAdData['impressions'];
            $oAd->requestedImpressions = $aAdData['impressions'];
            $oZone->addAdvert($oAd);
        }
        $result = $oPriorityCompensation->learnedPriorities($oZone);
        // Perform the iterations
        for ($iteration = 0; $iteration <= $iterations; $iteration++) {
            // Calculate how many impressions will be delivered for each ad
            foreach ($aAds as $adKey => $aAdData) {
                $aDelivered[$adKey] = 0;
            }
            $this->_predictDelivery($aDelivered, $zoneImpressions, $aAds, $aChannels, $result, $oPriorityCompensation);
            // Add the new data to the graph of the results
            $bestError = 0;
            $totalError = 0;
            foreach ($aAds as $adKey => $aAdData) {
                $dataSetName = 'oDataSet_Ad' . $adKey . '_RequiredImpressions';
                ${$dataSetName}->addPoint($iteration, $aAds[$adKey]['impressions']);
                $dataSetName = 'oDataSet_Ad' . $adKey . '_AvailableImpressions';
                if (is_null($aAdData['channel'])) {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions);
                } else {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions * $aChannels[$aAdData['channel']]);
                }
                $dataSetName = 'oDataSet_Ad' . $adKey . '_ActualImpressions';
                ${$dataSetName}->addPoint($iteration, $aDelivered[$adKey]);
                if ((!is_null($aAdData['channel'])) && (($zoneImpressions * $aChannels[$aAdData['channel']]) < $aAds[$adKey]['impressions'])) {
                    $bestError += abs(($zoneImpressions * $aChannels[$aAdData['channel']]) - $aAds[$adKey]['impressions']);
                }
                $totalError += abs($oZone->aAdverts[$adKey]->requiredImpressions - $aDelivered[$adKey]);
            }
            $oDataSetBestError->addPoint($iteration, $bestError);
            $oDataSetTotalError->addPoint($iteration, $totalError);
            // Prepare the ads/zone for the next iteration
            $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
            $oZone->availableImpressions = $zoneImpressions;
            $oZone->pastActualImpressions = $zoneImpressions;
            foreach ($aAds as $adKey => $aAdData) {
                $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
                $oAd->requiredImpressions = $aAdData['impressions'];
                $oAd->requestedImpressions = $aAdData['impressions'];
                $oAd->pastRequiredImpressions = $aAdData['impressions'];
                $oAd->pastRequestedImpressions = $aAdData['impressions'];
                $oAd->pastActualImpressions = $aDelivered[$adKey];
                $oAd->pastAdZonePriorityFactor = $result['ads'][$adKey]['priority_factor'];
                $oAd->pastZoneTrafficFraction = $result['ads'][$adKey]['past_zone_traffic_fraction'];
                $oZone->addAdvert($oAd);
            }
            $result = $oPriorityCompensation->learnedPriorities($oZone);
        }
        // Prepare the graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 480, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', $oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone', 12)),
                Image_Graph::vertical(
                    $oPlotarea = Image_Graph::factory('plotarea', array('axis', 'axis_log')),
                    $oLegend = Image_Graph::factory('legend'),
                    80
                ),
                10
            )
        );
        $oLegend->setPlotarea($oPlotarea);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_X);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_Y);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
        $oAxis->setTitle('Operation Intervals');
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Impressions', 'vertical');
        $counter = 1;
        $aAxisLabels = array();
        while ($counter < $zoneImpressions) {
            $counter *= 10;
            $aAxisLabels[] = $counter;
        }
        $oAxis->setLabelInterval($aAxisLabels);
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            $dataSetName = 'oDataSet_Ad' . $adKey . '_RequiredImpressions';
            $oPlot =& $oPlotarea->addNew('line', ${$dataSetName});
            $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['colour'], 'transparent'));
            $oPlot->setLineStyle($oLineStyle);
            $dataSetName = 'oDataSet_Ad' . $adKey . '_AvailableImpressions';
            $oPlot =& $oPlotarea->addNew('line', ${$dataSetName});
            $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dotted', array($aAdData['colour'], 'transparent'));
            $oPlot->setLineStyle($oLineStyle);
            $dataSetName = 'oDataSet_Ad' . $adKey . '_ActualImpressions';
            $oPlot =& $oPlotarea->addNew('line', ${$dataSetName});
            $oPlot->setLineColor($aAdData['colour']);
        }
        $oPlot =& $oPlotarea->addNew('line', $oDataSetBestError);
        $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dotted', array('magenta', 'transparent'));
        $oPlot->setLineStyle($oLineStyle);
        $oPlot =& $oPlotarea->addNew('line', $oDataSetTotalError);
        $oPlot->setLineColor('magenta');
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  ".png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt="" />' . "\n";
    }

    /**
     * A method to visually test the learnedPriorities() method.
     *
     * Tests a series of operation intervals for a zone where some ads are limited
     * to appear only in certain "channels" of the zone, and display the results
     * graphically. Uses a changing number of impressions in the zone each operation
     * interval.
     */
    function testLearnedPrioritiesSmoothChangingZoneInvetory()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Mock the OA_Dal_Maintenance_Priority class
        $oDal = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);
        // Partially mock the OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class
        $oPriorityCompensation = new PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation($this);
        $oPriorityCompensation->setReturnReference('_getDal', $oDal);
        $oPriorityCompensation->OA_Maintenance_Priority_AdServer_Task_PriorityCompensation();
        // Define the number of iterations to test over
        $iterations = 48;
        // Define the maximum number of impressions in the zone
        $maxZoneImpressions = 10000;
        // Define the maximum number of impressions in the zone
        $minZoneImpressions = 1000;
        // Define the zone impression period
        $zoneImpressionPeriod = 24;
        // Define the channels, including the % of zone impressions in each
        $aChannels[1] = 0.10; // Channel 1:  10% of zone traffic
        $aChannels[2] = 0.02; // Channel 2:   2% of zone traffic
        // Define the ads, including the required impressions each iteration,
        // the channel the ad is limited to (if any) and the colour to use in
        // the graph of results
        $aAds[1] = array(
            'impressions' => 5000,
            'channel' => null,
            'colour' => 'red'
        );
        $aAds[2] = array(
            'impressions' => 1500,
            'channel' => 1,
            'colour' => 'blue'
        );
        $aAds[3] = array(
            'impressions' => 750,
            'channel' => 2,
            'colour' => 'green'
        );
        // Preapare the graph data sets, ready to accept test data
        foreach ($aAds as $adKey => $aAdData) {
            // Add the new data to the graph of the results
            $dataSetName = 'oDataSet_Ad' . $adKey . '_RequiredImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey . ': Required Impressions');
            $dataSetName = 'oDataSet_Ad' . $adKey . '_AvailableImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey . ': Available Impressions');
            $dataSetName = 'oDataSet_Ad' . $adKey . '_ActualImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey . ': Delivered Impressions');
        }
        $oDataSetBestError =& Image_Graph::factory('dataset');
        $oDataSetBestError->setName('Least Possible Error In Delivery');
        $oDataSetTotalError =& Image_Graph::factory('dataset');
        $oDataSetTotalError->setName('Total Error In Delivery');
        // Prepare the ads/zone for the initial iteration
        $thisZoneImpressions = $minZoneImpressions;
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = $thisZoneImpressions;
        foreach ($aAds as $adKey => $aAdData) {
            $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
            $oAd->requiredImpressions = $aAdData['impressions'];
            $oAd->requestedImpressions = $aAdData['impressions'];
            $oZone->addAdvert($oAd);
        }
        $result = $oPriorityCompensation->learnedPriorities($oZone);
        // Perform the iterations
        for ($iteration = 1; $iteration <= $iterations; $iteration++) {
            // Calculate how many impressions will be delivered for each ad
            foreach ($aAds as $adKey => $aAdData) {
                $aDelivered[$adKey] = 0;
            }
            $this->_predictDelivery($aDelivered, $thisZoneImpressions, $aAds, $aChannels, $result, $oPriorityCompensation);
            // Add the new data to the graph of the results
            $bestError = 0;
            $totalError = 0;
            foreach ($aAds as $adKey => $aAdData) {
                $dataSetName = 'oDataSet_Ad' . $adKey . '_RequiredImpressions';
                ${$dataSetName}->addPoint($iteration, $aAds[$adKey]['impressions']);
                $dataSetName = 'oDataSet_Ad' . $adKey . '_AvailableImpressions';
                if (is_null($aAdData['channel'])) {
                    ${$dataSetName}->addPoint($iteration, $thisZoneImpressions);
                } else {
                    ${$dataSetName}->addPoint($iteration, $thisZoneImpressions * $aChannels[$aAdData['channel']]);
                }
                $dataSetName = 'oDataSet_Ad' . $adKey . '_ActualImpressions';
                ${$dataSetName}->addPoint($iteration, $aDelivered[$adKey]);
                if ((!is_null($aAdData['channel'])) && (($thisZoneImpressions * $aChannels[$aAdData['channel']]) < $aAds[$adKey]['impressions'])) {
                    $bestError += abs(($thisZoneImpressions * $aChannels[$aAdData['channel']]) - $aAds[$adKey]['impressions']);
                }
                $totalError += abs($oZone->aAdverts[$adKey]->requiredImpressions - $aDelivered[$adKey]);
            }
            $oDataSetBestError->addPoint($iteration, $bestError);
            $oDataSetTotalError->addPoint($iteration, $totalError);
            // Prepare the ads/zone for the next iteration
            $previousZoneImpressions = $thisZoneImpressions;
            if ($iteration == 1) {
                $thisZoneImpressions =
                    $this->_predictSmoothZoneInventory($minZoneImpressions, $maxZoneImpressions, $zoneImpressionPeriod, $iteration);
            } else {
                $thisZoneImpressions =
                    $this->_predictSmoothZoneInventory($minZoneImpressions, $maxZoneImpressions, $zoneImpressionPeriod, $iteration);
            }
            $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
            $oZone->availableImpressions = $thisZoneImpressions;
            $oZone->pastActualImpressions = $previousZoneImpressions;
            foreach ($aAds as $adKey => $aAdData) {
                $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
                $oAd->requiredImpressions = $aAdData['impressions'];
                $oAd->requestedImpressions = $aAdData['impressions'];
                $oAd->pastRequiredImpressions = $aAdData['impressions'];
                $oAd->pastRequestedImpressions = $aAdData['impressions'];
                $oAd->pastActualImpressions = $aDelivered[$adKey];
                $oAd->pastAdZonePriorityFactor = $result['ads'][$adKey]['priority_factor'];
                $oAd->pastZoneTrafficFraction = $result['ads'][$adKey]['past_zone_traffic_fraction'];
                $oZone->addAdvert($oAd);
            }
            $result = $oPriorityCompensation->learnedPriorities($oZone);
        }
        // Prepare the graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 480, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', $oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone', 12)),
                Image_Graph::vertical(
                    $oPlotarea = Image_Graph::factory('plotarea', array('axis', 'axis_log')),
                    $oLegend = Image_Graph::factory('legend'),
                    80
                ),
                10
            )
        );
        $oLegend->setPlotarea($oPlotarea);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_X);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_Y);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
        $oAxis->setTitle('Operation Intervals');
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Impressions', 'vertical');
        $counter = 1;
        $aAxisLabels = array();
        while ($counter < $maxZoneImpressions) {
            $counter *= 10;
            $aAxisLabels[] = $counter;
        }
        $oAxis->setLabelInterval($aAxisLabels);
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            $dataSetName = 'oDataSet_Ad' . $adKey . '_RequiredImpressions';
            $oPlot =& $oPlotarea->addNew('line', ${$dataSetName});
            $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['colour'], 'transparent'));
            $oPlot->setLineStyle($oLineStyle);
            $dataSetName = 'oDataSet_Ad' . $adKey . '_AvailableImpressions';
            $oPlot =& $oPlotarea->addNew('line', ${$dataSetName});
            $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dotted', array($aAdData['colour'], 'transparent'));
            $oPlot->setLineStyle($oLineStyle);
            $dataSetName = 'oDataSet_Ad' . $adKey . '_ActualImpressions';
            $oPlot =& $oPlotarea->addNew('line', ${$dataSetName});
            $oPlot->setLineColor($aAdData['colour']);
        }
        $oPlot =& $oPlotarea->addNew('line', $oDataSetBestError);
        $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dotted', array('magenta', 'transparent'));
        $oPlot->setLineStyle($oLineStyle);
        $oPlot =& $oPlotarea->addNew('line', $oDataSetTotalError);
        $oPlot->setLineColor('magenta');
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  ".png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt="" />' . "\n";
    }

    /**
     * A method to visually test the learnedPriorities() method.
     *
     * Tests a series of operation intervals for a zone where some ads are limited
     * to appear only in certain "channels" of the zone, and display the results
     * graphically. Uses a changing number of impressions in the zone each operation
     * interval.
     */
    function testLearnedPrioritiesSharpChangingZoneInvetory()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Mock the OA_Dal_Maintenance_Priority class
        $oDal = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);
        // Partially mock the OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class
        $oPriorityCompensation = new PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation($this);
        $oPriorityCompensation->setReturnReference('_getDal', $oDal);
        $oPriorityCompensation->OA_Maintenance_Priority_AdServer_Task_PriorityCompensation();
        // Define the number of iterations to test over
        $iterations = 48;
        // Define the maximum number of impressions in the zone
        $maxZoneImpressions = 10000;
        // Define the maximum number of impressions in the zone
        $minZoneImpressions = 1000;
        // Define the zone impression period
        $zoneImpressionPeriod = 24;
        // Define the channels, including the % of zone impressions in each
        $aChannels[1] = 0.10; // Channel 1:  10% of zone traffic
        $aChannels[2] = 0.02; // Channel 2:   2% of zone traffic
        // Define the ads, including the required impressions each iteration,
        // the channel the ad is limited to (if any) and the colour to use in
        // the graph of results
        $aAds[1] = array(
            'impressions' => 5000,
            'channel' => null,
            'colour' => 'red'
        );
        $aAds[2] = array(
            'impressions' => 1500,
            'channel' => 1,
            'colour' => 'blue'
        );
        $aAds[3] = array(
            'impressions' => 750,
            'channel' => 2,
            'colour' => 'green'
        );
        // Preapare the graph data sets, ready to accept test data
        foreach ($aAds as $adKey => $aAdData) {
            // Add the new data to the graph of the results
            $dataSetName = 'oDataSet_Ad' . $adKey . '_RequiredImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey . ': Required Impressions');
            $dataSetName = 'oDataSet_Ad' . $adKey . '_AvailableImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey . ': Available Impressions');
            $dataSetName = 'oDataSet_Ad' . $adKey . '_ActualImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey . ': Delivered Impressions');
        }
        $oDataSetBestError =& Image_Graph::factory('dataset');
        $oDataSetBestError->setName('Least Possible Error In Delivery');
        $oDataSetTotalError =& Image_Graph::factory('dataset');
        $oDataSetTotalError->setName('Total Error In Delivery');
        // Prepare the ads/zone for the initial iteration
        $thisZoneImpressions = $minZoneImpressions;
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = $thisZoneImpressions;
        foreach ($aAds as $adKey => $aAdData) {
            $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
            $oAd->requiredImpressions = $aAdData['impressions'];
            $oAd->requestedImpressions = $aAdData['impressions'];
            $oZone->addAdvert($oAd);
        }
        $result = $oPriorityCompensation->learnedPriorities($oZone);
        // Perform the iterations
        for ($iteration = 1; $iteration <= $iterations; $iteration++) {
            // Calculate how many impressions will be delivered for each ad
            foreach ($aAds as $adKey => $aAdData) {
                $aDelivered[$adKey] = 0;
            }
            $this->_predictDelivery($aDelivered, $thisZoneImpressions, $aAds, $aChannels, $result, $oPriorityCompensation);
            // Add the new data to the graph of the results
            $bestError = 0;
            $totalError = 0;
            foreach ($aAds as $adKey => $aAdData) {
                $dataSetName = 'oDataSet_Ad' . $adKey . '_RequiredImpressions';
                ${$dataSetName}->addPoint($iteration, $aAds[$adKey]['impressions']);
                $dataSetName = 'oDataSet_Ad' . $adKey . '_AvailableImpressions';
                if (is_null($aAdData['channel'])) {
                    ${$dataSetName}->addPoint($iteration, $thisZoneImpressions);
                } else {
                    ${$dataSetName}->addPoint($iteration, $thisZoneImpressions * $aChannels[$aAdData['channel']]);
                }
                $dataSetName = 'oDataSet_Ad' . $adKey . '_ActualImpressions';
                ${$dataSetName}->addPoint($iteration, $aDelivered[$adKey]);
                if ((!is_null($aAdData['channel'])) && (($thisZoneImpressions * $aChannels[$aAdData['channel']]) < $aAds[$adKey]['impressions'])) {
                    $bestError += abs(($thisZoneImpressions * $aChannels[$aAdData['channel']]) - $aAds[$adKey]['impressions']);
                }
                $totalError += abs($oZone->aAdverts[$adKey]->requiredImpressions - $aDelivered[$adKey]);
            }
            $oDataSetBestError->addPoint($iteration, $bestError);
            $oDataSetTotalError->addPoint($iteration, $totalError);
            // Prepare the ads/zone for the next iteration
            $previousZoneImpressions = $thisZoneImpressions;
            if ($iteration == 1) {
                $thisZoneImpressions =
                    $this->_predictSharpZoneInventory($minZoneImpressions, $maxZoneImpressions, $zoneImpressionPeriod, $iteration);
            } else {
                $thisZoneImpressions =
                    $this->_predictSharpZoneInventory($minZoneImpressions, $maxZoneImpressions, $zoneImpressionPeriod, $iteration);
            }
            $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
            $oZone->availableImpressions = $thisZoneImpressions;
            $oZone->pastActualImpressions = $previousZoneImpressions;
            foreach ($aAds as $adKey => $aAdData) {
                $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
                $oAd->requiredImpressions = $aAdData['impressions'];
                $oAd->requestedImpressions = $aAdData['impressions'];
                $oAd->pastRequiredImpressions = $aAdData['impressions'];
                $oAd->pastRequestedImpressions = $aAdData['impressions'];
                $oAd->pastActualImpressions = $aDelivered[$adKey];
                $oAd->pastAdZonePriorityFactor = $result['ads'][$adKey]['priority_factor'];
                $oAd->pastZoneTrafficFraction = $result['ads'][$adKey]['past_zone_traffic_fraction'];
                $oZone->addAdvert($oAd);
            }
            $result = $oPriorityCompensation->learnedPriorities($oZone);
        }
        // Prepare the graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 480, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', $oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone', 12)),
                Image_Graph::vertical(
                    $oPlotarea = Image_Graph::factory('plotarea', array('axis', 'axis_log')),
                    $oLegend = Image_Graph::factory('legend'),
                    80
                ),
                10
            )
        );
        $oLegend->setPlotarea($oPlotarea);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_X);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_Y);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
        $oAxis->setTitle('Operation Intervals');
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Impressions', 'vertical');
        $counter = 1;
        $aAxisLabels = array();
        while ($counter < $maxZoneImpressions) {
            $counter *= 10;
            $aAxisLabels[] = $counter;
        }
        $oAxis->setLabelInterval($aAxisLabels);
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            $dataSetName = 'oDataSet_Ad' . $adKey . '_RequiredImpressions';
            $oPlot =& $oPlotarea->addNew('line', ${$dataSetName});
            $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['colour'], 'transparent'));
            $oPlot->setLineStyle($oLineStyle);
            $dataSetName = 'oDataSet_Ad' . $adKey . '_AvailableImpressions';
            $oPlot =& $oPlotarea->addNew('line', ${$dataSetName});
            $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dotted', array($aAdData['colour'], 'transparent'));
            $oPlot->setLineStyle($oLineStyle);
            $dataSetName = 'oDataSet_Ad' . $adKey . '_ActualImpressions';
            $oPlot =& $oPlotarea->addNew('line', ${$dataSetName});
            $oPlot->setLineColor($aAdData['colour']);
        }
        $oPlot =& $oPlotarea->addNew('line', $oDataSetBestError);
        $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dotted', array('magenta', 'transparent'));
        $oPlot->setLineStyle($oLineStyle);
        $oPlot =& $oPlotarea->addNew('line', $oDataSetTotalError);
        $oPlot->setLineColor('magenta');
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  ".png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt="" />' . "\n";
    }

    /**
     * A private method for predicting ads delivered.
     *
     * @access private
     */
    function _predictDelivery(&$aDelivered, $zoneImpressions, $aAds, $aChannels, $aPriorities, $oPriorityCompensation)
    {
        if ($zoneImpressions == 0) {
            return;
        }
        foreach ($aAds as $adKey => $aAdData) {
            if (is_null($aAdData['channel'])) {
                // The ad is not targeted to a channel, and so will be displayed whenever the
                // delivery engine selects the ad
                $aDelivered[$adKey] += floor($zoneImpressions * $aPriorities['ads'][$adKey]['priority']);
            } else {
                // The ad is targeted to a channel, so the ad will only be displayed when
                // selected, and when in the correct channel
                $aDelivered[$adKey] += floor($zoneImpressions * $aPriorities['ads'][$adKey]['priority'] * $aChannels[$aAdData['channel']]);
                // Also, whenever the ad is not in the correct channel, we need to
                // select a different ad to display, so remove the ad from the list
                // and select a new ad
                $filteredImpressionsWhereAdNotInChannel = floor($zoneImpressions * $aPriorities['ads'][$adKey]['priority'] * (1 - $aChannels[$aAdData['channel']]));
                $aAdsCopy = $aAds;
                unset($aAdsCopy[$adKey]);
                $aPrioritiesCopy = $aPriorities;
                unset($aPrioritiesCopy['ads'][$adKey]);
                $oPriorityCompensation->scalePriorities($aPrioritiesCopy);
                $this->_predictDelivery($aDelivered, $filteredImpressionsWhereAdNotInChannel, $aAdsCopy, $aChannels, $aPrioritiesCopy, $oPriorityCompensation);
            }
        }

    }

    /**
     * A private method for predicting zone inventory that changes smoothly with time.
     *
     * @access private
     * @param integer $minZoneImpressions The minimum number of impressions the zone
     *                                    inventory goes down to.
     * @param integer $maxZoneImpressions The maximum number of impressions the zone
     *                                    inventory goes up to.
     * @param integer $period The period over which the invetory cycles from minmum,
     *                        to maximum, and back to minimum.
     * @param integer $now The current interval, starting from 0.
     * @return integer The number of impressions in this specified interval.
     */
    function _predictSmoothZoneInventory($minZoneImpressions, $maxZoneImpressions, $period, $now)
    {
        // Find out how much to change the inventory by each interval
        $difference = $maxZoneImpressions - $minZoneImpressions;
        $deltaPerInterval = floor($difference / ($period / 2));
        // Convert the current interval to a base value
        while ($now >= 0) {
            $now = $now - $period;
        }
        $now = $now + $period;
        // $now is now between 0 and $period
        if ($now == 0) {
            // Return the minimum
            return $minZoneImpressions;
        }
        if ($now <= floor($period / 2)) {
            // Add the delta to the minimum
            return ($minZoneImpressions + ($now * $deltaPerInterval));
        }
        // Take the delta from the maximum
        return ($maxZoneImpressions - (($now - floor($period / 2))* $deltaPerInterval));
    }

    /**
     * A private method for predicting zone inventory that changes abruptly with time.
     *
     * @access private
     * @param integer $minZoneImpressions The minimum number of impressions the zone
     *                                    inventory goes down to.
     * @param integer $maxZoneImpressions The maximum number of impressions the zone
     *                                    inventory goes up to.
     * @param integer $period The period over which the invetory cycles from minmum,
     *                        to maximum, and back to minimum.
     * @param integer $now The current interval, starting from 0.
     * @return integer The number of impressions in this specified interval.
     */
    function _predictSharpZoneInventory($minZoneImpressions, $maxZoneImpressions, $period, $now)
    {
        // Find out how much to change the inventory by each interval
        $difference = $maxZoneImpressions - $minZoneImpressions;
        $deltaPerInterval = floor($difference / ($period / 2));
        // Convert the current interval to a base value
        while ($now >= 0) {
            $now = $now - $period;
        }
        $now = $now + $period;
        // $now is now between 0 and $period
        if ($now == 0) {
            // Return the minimum
            return $minZoneImpressions;
        }
        if ($now <= floor($period / 3)) {
            return $minZoneImpressions;
        }
        if (($now > floor($period / 3)) && ($now <= 2 * floor($period / 3))) {
            return $maxZoneImpressions;
        }
        return $minZoneImpressions;
    }

}

?>
