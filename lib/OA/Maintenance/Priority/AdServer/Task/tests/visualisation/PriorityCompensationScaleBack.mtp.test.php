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

if (!defined('IMAGE_CANVAS_SYSTEM_FONT_PATH')) {
    define('IMAGE_CANVAS_SYSTEM_FONT_PATH', '/usr/share/fonts/msttcorefonts/');
}

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/PriorityCompensation.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Image/Canvas.php';
require_once MAX_PATH . '/lib/pear/Image/Graph.php';

/**
 * A class for testing that scaling back of the compensation factor in the
 * OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class happens
 * quickly enough to prevent over-delivery.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation_ScaleBack extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation_ScaleBack()
    {
        $this->UnitTestCase();
        Mock::generate('OA_Dal_Maintenance_Priority');
        Mock::generatePartial(
            'OA_Maintenance_Priority_AdServer_Task_PriorityCompensation',
            'PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensationScaleBack',
            array('_getDal')
        );
    }

    /**
     * A method to visually test the scaling back of the compensation factor.
     *
     * Performs a simple test where a non-active zone causes an ad to not deliver,
     * forcing the compensation factor up. The zone is then activated, resulting in
     * over-delivery. The compensation factor should then rapidly return to a level
     * that results in the desired level of delivery.
     */
    function testScaleBackSimple()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Mock the OA_Dal_Maintenance_Priority class
        $oDal = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);
        // Partially mock the OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class
        $oPriorityCompensation = new PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensationScaleBack($this);
        $oPriorityCompensation->setReturnReference('_getDal', $oDal);
        $oPriorityCompensation->OA_Maintenance_Priority_AdServer_Task_PriorityCompensation();
        // Define the number of initial iterations to test over
        $initialIterations = 12;
        // Define how many impressions are in the zone in each initial iteration
        $initialZoneImpressions = 10;
        // Define the number of final iterations to test over
        $finalIterations = 12;
        // Define how many impressions are in the zone in each final iteration
        $finalZoneImpressions = 10000;
        // Define the test ad, giving the number of required impressions
        // each hour (fixed), the channel the ad is in (if any), and the
        // colour to graph the ad
        // The number of ads must not exceed ($initialZoneImpressions - 1)
        // or ($finalZoneImpressions - 1), to ensure that the values for
        // the requestedImpressions >= 1 for all ads
        $aAds[1] = array(
            'requiredImpressions'   => 5000,
            'channel'               => null,
            'requiredColour'        => '#AA00FF',
            'requestedColour'       => 'blue',
            'availableColour'       => 'black',
            'deliveredColour'       => 'green',
            'priorityFactorColour'  => 'red'
        );
        // Preapare the graph data sets, ready to accept test data
        foreach ($aAds as $adKey => $aAdData) {
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Required Impressions');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Requested Impressions');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Available Impressions');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Delivered Impressions');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Priority Factor');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Priority');
        }
        // Prepare the zone/ads for the initial iterations
        $oZone = new OA_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = $initialZoneImpressions;
        $zoneTotalRequired = 0;
        foreach ($aAds as $adKey => $aAdData) {
            $zoneTotalRequired += $aAdData['requiredImpressions'];
        }
        foreach ($aAds as $adKey => $aAdData) {
            $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
            $oAd->requiredImpressions = $aAdData['requiredImpressions'];
            if ($zoneTotalRequired > $oZone->availableImpressions) {
                $oAd->requestedImpressions = floor(($oZone->availableImpressions - 1) / count($aAds));
            } else {
                $oAd->requestedImpressions = $aAdData['requiredImpressions'];
            }
            $oZone->addAdvert($oAd);
        }
        $result = $oPriorityCompensation->learnedPriorities($oZone);
        // Perform the initial iterations
        $oSavedZone;
        $zoneImpressions = $initialZoneImpressions;
        for ($iteration = 0; $iteration <= $initialIterations; $iteration++) {
            // As these are the initial iterations, no delivery of any ads (zone not active)
            foreach ($aAds as $adKey => $aAdData) {
                $aDelivered[$adKey] = 0;
            }
            // Add the new data to the graph of the results
            foreach ($aAds as $adKey => $aAdData) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
                ${$dataSetName}->addPoint($iteration, $aAds[$adKey]['requiredImpressions']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['requested_impressions']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
                if (is_null($aAdData['channel'])) {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions);
                } else {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions * $aChannels[$aAdData['channel']]);
                }
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
                ${$dataSetName}->addPoint($iteration, $aDelivered[$adKey]);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['priority_factor']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['priority']);
            }
            // Prepare the ads/zone for the next iteration
            $oZone = new OA_Maintenance_Priority_Zone(array('zoneid' => 1));
            $oZone->availableImpressions = $zoneImpressions;
            $oZone->pastActualImpressions = $zoneImpressions;
            $zoneTotalRequired = 0;
            foreach ($aAds as $adKey => $aAdData) {
                $zoneTotalRequired += $aAdData['requiredImpressions'];
            }
            foreach ($aAds as $adKey => $aAdData) {
                $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
                $oAd->requiredImpressions = $aAdData['requiredImpressions'];
                if ($zoneTotalRequired > $zoneImpressions) {
                    $oAd->requestedImpressions = floor(($zoneImpressions - 1) / count($aAds));
                } else {
                    $oAd->requestedImpressions = $aAdData['requiredImpressions'];
                }
                $oAd->pastRequiredImpressions = $aAdData['requiredImpressions'];
                $oAd->pastRequestedImpressions = $result['ads'][$adKey]['requested_impressions'];
                $oAd->pastActualImpressions = $aDelivered[$adKey];
                $oAd->pastAdZonePriorityFactor = $result['ads'][$adKey]['priority_factor'];
                $oAd->pastZoneTrafficFraction = $result['ads'][$adKey]['past_zone_traffic_fraction'];
                $oZone->addAdvert($oAd);
            }
            // Move to the next iteration
            $result = $oPriorityCompensation->learnedPriorities($oZone);
        }
        // Prepare the zone/ads for the final iterations
        $zoneTotalRequired = 0;
        foreach ($aAds as $adKey => $aAdData) {
            $zoneTotalRequired += $aAdData['requiredImpressions'];
        }
        foreach ($aAds as $adKey => $aAdData) {
            $oAd =& $oZone->aAdverts[$adKey];
            $oAd->requiredImpressions = $aAdData['requiredImpressions'];
            if ($zoneTotalRequired > $oZone->availableImpressions) {
                $oAd->requestedImpressions = floor(($oZone->availableImpressions - 1) / count($aAds));
            } else {
                $oAd->requestedImpressions = $aAdData['requiredImpressions'];
            }
        }
        $result = $oPriorityCompensation->learnedPriorities($oZone);
        // Perform the final iterations
        $zoneImpressions = $finalZoneImpressions;
        for ($iteration = $initialIterations + 1; $iteration <= $initialIterations + $finalIterations; $iteration++) {
            // As these are the final iteration, calculate delivery
            foreach ($aAds as $adKey => $aAdData) {
                $aDelivered[$adKey] = 0;
            }
            $this->_predictDelivery($aDelivered, $zoneImpressions, $aAds, $aChannels, $result, $oPriorityCompensation);
            // Add the new data to the graph of the results
            foreach ($aAds as $adKey => $aAdData) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
                ${$dataSetName}->addPoint($iteration, $aAds[$adKey]['requiredImpressions']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['requested_impressions']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
                if (is_null($aAdData['channel'])) {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions);
                } else {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions * $aChannels[$aAdData['channel']]);
                }
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
                ${$dataSetName}->addPoint($iteration, $aDelivered[$adKey]);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['priority_factor']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['priority']);
            }
            // Prepare the ads/zone for the next iteration
            $oZone = new OA_Maintenance_Priority_Zone(array('zoneid' => 1));
            $oZone->availableImpressions = $zoneImpressions;
            $oZone->pastActualImpressions = $zoneImpressions;
            $zoneTotalRequired = 0;
            foreach ($aAds as $adKey => $aAdData) {
                $zoneTotalRequired += $aAdData['requiredImpressions'];
            }
            foreach ($aAds as $adKey => $aAdData) {
                $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
                $oAd->requiredImpressions = $aAdData['requiredImpressions'];
                if ($zoneTotalRequired > $zoneImpressions) {
                    $oAd->requestedImpressions = floor(($zoneImpressions - 1) / count($aAds));
                } else {
                    $oAd->requestedImpressions = $aAdData['requiredImpressions'];
                }
                $oAd->pastRequiredImpressions = $aAdData['requiredImpressions'];
                $oAd->pastRequestedImpressions = $result['ads'][$adKey]['requested_impressions'];
                $oAd->pastActualImpressions = $aDelivered[$adKey];
                $oAd->pastAdZonePriorityFactor = $result['ads'][$adKey]['priority_factor'];
                $oAd->pastZoneTrafficFraction = $result['ads'][$adKey]['past_zone_traffic_fraction'];
                $oZone->addAdvert($oAd);
            }
            $result = $oPriorityCompensation->learnedPriorities($oZone);
        }

        // Prepare the main graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 600, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone: Simple Scale-Back Test', 12)),
                Image_Graph::vertical(
                    $oPlotarea = Image_Graph::factory('plotarea', array('axis', 'axis')),
                    $oLegend = Image_Graph::factory('legend'),
                    90
                ),
                10
            )
        );
        $oLegend->setPlotarea($oPlotarea);
        $oPlotareaSecondary =& Image_Graph::factory('plotarea', array('axis', 'axis', IMAGE_GRAPH_AXIS_Y_SECONDARY));
        $oGraph->add($oPlotareaSecondary);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_X);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_Y);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
        $oAxis->setTitle('Operation Intervals');
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Impressions', 'vertical');
        $oAxis =& Image_Graph::factory('axis', IMAGE_GRAPH_AXIS_Y_SECONDARY);
        $oPlotarea->add($oAxis);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y_SECONDARY);
        $oAxis->setTitle('Priority Factor', 'vertical2');
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
            $oPlot =& $oPlotarea->addNew('line', &${$dataSetName}, IMAGE_GRAPH_AXIS_Y_SECONDARY);
            $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['priorityFactorColour'], 'transparent'));
            $oPlot->setLineStyle($oLineStyle);
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
            $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
            $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['deliveredColour'], 'transparent'));
            $oPlot->setLineStyle($oLineStyle);
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
            $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
            $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['availableColour'], 'transparent'));
            $oPlot->setLineStyle($oLineStyle);
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
            $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
            $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['requiredColour'], 'transparent'));
            $oPlot->setLineStyle($oLineStyle);
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
            $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
            $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dotted', array($aAdData['requestedColour'], 'transparent'));
            $oPlot->setLineStyle($oLineStyle);
        }
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  "1.png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt=""/>' . "\n";

        // Prepare the priority graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 600, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone: Simple Scale-Back Test', 12)),
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
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Priority', 'vertical');
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
            $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
            $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['priorityFactorColour'], 'transparent'));
            $oPlot->setLineStyle($oLineStyle);
        }
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  "2.png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt=""/>' . "\n";

        echo '<hr />' . "\n";
    }

    /**
     * A method to visually test the scaling back of the compensation factor.
     *
     * Performs a more relalistic version of the test above, with two ads.
     */
    function testScaleBackComplex()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Mock the OA_Dal_Maintenance_Priority class
        $oDal = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);
        // Partially mock the OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class
        $oPriorityCompensation = new PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensationScaleBack($this);
        $oPriorityCompensation->setReturnReference('_getDal', $oDal);
        $oPriorityCompensation->OA_Maintenance_Priority_AdServer_Task_PriorityCompensation();
        // Define the number of initial iterations to test over
        $initialIterations = 12;
        // Define how many impressions are in the zone in each initial iteration
        $initialZoneImpressions = 10;
        // Define the number of final iterations to test over
        $finalIterations = 12;
        // Define how many impressions are in the zone in each final iteration
        $finalZoneImpressions = 20000;
        // Define the channels, including the % of zone impressions in each
        $aChannels[1] = 0.10; // Channel 1:  10% of zone traffic
        // Define the test ads, giving the number of required impressions
        // each hour (fixed), the channel the ad is in (if any), and the
        // colour to graph the ad
        // The number of ads must not exceed ($initialZoneImpressions - 1)
        // or ($finalZoneImpressions - 1), to ensure that the values for
        // the requestedImpressions >= 1 for all ads
        $aAds[1] = array(
            'requiredImpressions'   => 5000,
            'channel'               => null,
            'requiredColour'        => '#AA00FF',
            'requestedColour'       => 'blue',
            'availableColour'       => 'black',
            'deliveredColour'       => 'green',
            'priorityFactorColour'  => 'red'
        );
        $aAds[2] = array(
            'requiredImpressions'   => 5000,
            'channel'               => 1,
            'requiredColour'        => '#AA00FF',
            'requestedColour'       => 'blue',
            'availableColour'       => 'black',
            'deliveredColour'       => 'green',
            'priorityFactorColour'  => 'red'
        );
        // Preapare the graph data sets, ready to accept test data
        foreach ($aAds as $adKey => $aAdData) {
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Required Impressions');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Requested Impressions');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Available Impressions');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Delivered Impressions');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Priority Factor');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Priority');
        }
        // Prepare the zone/ads for the initial iterations
        $oZone = new OA_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = $initialZoneImpressions;
        $zoneTotalRequired = 0;
        foreach ($aAds as $adKey => $aAdData) {
            $zoneTotalRequired += $aAdData['requiredImpressions'];
        }
        foreach ($aAds as $adKey => $aAdData) {
            $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
            $oAd->requiredImpressions = $aAdData['requiredImpressions'];
            if ($zoneTotalRequired > $oZone->availableImpressions) {
                $oAd->requestedImpressions = floor(($oZone->availableImpressions - 1) / count($aAds));
            } else {
                $oAd->requestedImpressions = $aAdData['requiredImpressions'];
            }
            $oZone->addAdvert($oAd);
        }
        $result = $oPriorityCompensation->learnedPriorities($oZone);
        // Perform the initial iterations
        $oSavedZone;
        $zoneImpressions = $initialZoneImpressions;
        for ($iteration = 0; $iteration <= $initialIterations; $iteration++) {
            // As these are the initial iterations, no delivery of any ads (zone not active)
            foreach ($aAds as $adKey => $aAdData) {
                $aDelivered[$adKey] = 0;
            }
            // Add the new data to the graph of the results
            foreach ($aAds as $adKey => $aAdData) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
                ${$dataSetName}->addPoint($iteration, $aAds[$adKey]['requiredImpressions']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['requested_impressions']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
                if (is_null($aAdData['channel'])) {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions);
                } else {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions * $aChannels[$aAdData['channel']]);
                }
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
                ${$dataSetName}->addPoint($iteration, $aDelivered[$adKey]);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['priority_factor']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['priority']);
            }
            // Prepare the ads/zone for the next iteration
            $oZone = new OA_Maintenance_Priority_Zone(array('zoneid' => 1));
            $oZone->availableImpressions = $zoneImpressions;
            $oZone->pastActualImpressions = $zoneImpressions;
            $zoneTotalRequired = 0;
            foreach ($aAds as $adKey => $aAdData) {
                $zoneTotalRequired += $aAdData['requiredImpressions'];
            }
            foreach ($aAds as $adKey => $aAdData) {
                $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
                $oAd->requiredImpressions = $aAdData['requiredImpressions'];
                if ($zoneTotalRequired > $zoneImpressions) {
                    $oAd->requestedImpressions = floor(($zoneImpressions - 1) / count($aAds));
                } else {
                    $oAd->requestedImpressions = $aAdData['requiredImpressions'];
                }
                $oAd->pastRequiredImpressions = $aAdData['requiredImpressions'];
                $oAd->pastRequestedImpressions = $result['ads'][$adKey]['requested_impressions'];
                $oAd->pastActualImpressions = $aDelivered[$adKey];
                $oAd->pastAdZonePriorityFactor = $result['ads'][$adKey]['priority_factor'];
                $oAd->pastZoneTrafficFraction = $result['ads'][$adKey]['past_zone_traffic_fraction'];
                $oZone->addAdvert($oAd);
            }
            // Move to the next iteration
            $result = $oPriorityCompensation->learnedPriorities($oZone);
        }
        // Prepare the zone/ads for the final iterations
        $zoneTotalRequired = 0;
        foreach ($aAds as $adKey => $aAdData) {
            $zoneTotalRequired += $aAdData['requiredImpressions'];
        }
        foreach ($aAds as $adKey => $aAdData) {
            $oAd =& $oZone->aAdverts[$adKey];
            $oAd->requiredImpressions = $aAdData['requiredImpressions'];
            if ($zoneTotalRequired > $oZone->availableImpressions) {
                $oAd->requestedImpressions = floor(($oZone->availableImpressions - 1) / count($aAds));
            } else {
                $oAd->requestedImpressions = $aAdData['requiredImpressions'];
            }
        }
        $result = $oPriorityCompensation->learnedPriorities($oZone);
        // Perform the final iterations
        $zoneImpressions = $finalZoneImpressions;
        for ($iteration = $initialIterations + 1; $iteration <= $initialIterations + $finalIterations; $iteration++) {
            // As these are the final iteration, calculate delivery
            foreach ($aAds as $adKey => $aAdData) {
                $aDelivered[$adKey] = 0;
            }
            $this->_predictDelivery($aDelivered, $zoneImpressions, $aAds, $aChannels, $result, $oPriorityCompensation);
            // Add the new data to the graph of the results
            foreach ($aAds as $adKey => $aAdData) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
                ${$dataSetName}->addPoint($iteration, $aAds[$adKey]['requiredImpressions']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['requested_impressions']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
                if (is_null($aAdData['channel'])) {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions);
                } else {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions * $aChannels[$aAdData['channel']]);
                }
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
                ${$dataSetName}->addPoint($iteration, $aDelivered[$adKey]);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['priority_factor']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['priority']);
            }
            // Prepare the ads/zone for the next iteration
            $oZone = new OA_Maintenance_Priority_Zone(array('zoneid' => 1));
            $oZone->availableImpressions = $zoneImpressions;
            $oZone->pastActualImpressions = $zoneImpressions;
            $zoneTotalRequired = 0;
            foreach ($aAds as $adKey => $aAdData) {
                $zoneTotalRequired += $aAdData['requiredImpressions'];
            }
            foreach ($aAds as $adKey => $aAdData) {
                $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
                $oAd->requiredImpressions = $aAdData['requiredImpressions'];
                if ($zoneTotalRequired > $zoneImpressions) {
                    $oAd->requestedImpressions = floor(($zoneImpressions - 1) / count($aAds));
                } else {
                    $oAd->requestedImpressions = $aAdData['requiredImpressions'];
                }
                $oAd->pastRequiredImpressions = $aAdData['requiredImpressions'];
                $oAd->pastRequestedImpressions = $result['ads'][$adKey]['requested_impressions'];
                $oAd->pastActualImpressions = $aDelivered[$adKey];
                $oAd->pastAdZonePriorityFactor = $result['ads'][$adKey]['priority_factor'];
                $oAd->pastZoneTrafficFraction = $result['ads'][$adKey]['past_zone_traffic_fraction'];
                $oZone->addAdvert($oAd);
            }
            $result = $oPriorityCompensation->learnedPriorities($oZone);
        }

        // Prepare the main graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 600, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone: 2 Ad Complex Scale-Back Test', 12)),
                Image_Graph::vertical(
                    $oPlotarea = Image_Graph::factory('plotarea', array('axis', 'axis')),
                    $oLegend = Image_Graph::factory('legend'),
                    90
                ),
                10
            )
        );
        $oLegend->setPlotarea($oPlotarea);
        $oPlotareaSecondary =& Image_Graph::factory('plotarea', array('axis', 'axis', IMAGE_GRAPH_AXIS_Y_SECONDARY));
        $oGraph->add($oPlotareaSecondary);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_X);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_Y);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
        $oAxis->setTitle('Operation Intervals');
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Impressions', 'vertical');
        $oAxis =& Image_Graph::factory('axis', IMAGE_GRAPH_AXIS_Y_SECONDARY);
        $oPlotarea->add($oAxis);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y_SECONDARY);
        $oAxis->setTitle('Priority Factor', 'vertical2');
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            if ($adKey == 1) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName}, IMAGE_GRAPH_AXIS_Y_SECONDARY);
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['priorityFactorColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['deliveredColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['availableColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['requiredColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dotted', array($aAdData['requestedColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
            }
        }
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  "1.png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt=""/>' . "\n";

        // Prepare the priority graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 600, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone: 2 Ad Complex Scale-Back Test', 12)),
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
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Priority', 'vertical');
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            if ($adKey == 1) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['priorityFactorColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
            }
        }
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  "2.png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt=""/>' . "\n";

        // Prepare the main graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 600, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone: 2 Ad Complex Scale-Back Test', 12)),
                Image_Graph::vertical(
                    $oPlotarea = Image_Graph::factory('plotarea', array('axis', 'axis')),
                    $oLegend = Image_Graph::factory('legend'),
                    90
                ),
                10
            )
        );
        $oLegend->setPlotarea($oPlotarea);
        $oPlotareaSecondary =& Image_Graph::factory('plotarea', array('axis', 'axis', IMAGE_GRAPH_AXIS_Y_SECONDARY));
        $oGraph->add($oPlotareaSecondary);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_X);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_Y);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
        $oAxis->setTitle('Operation Intervals');
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Impressions', 'vertical');
        $oAxis =& Image_Graph::factory('axis', IMAGE_GRAPH_AXIS_Y_SECONDARY);
        $oPlotarea->add($oAxis);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y_SECONDARY);
        $oAxis->setTitle('Priority Factor', 'vertical2');
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            if ($adKey == 2) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName}, IMAGE_GRAPH_AXIS_Y_SECONDARY);
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['priorityFactorColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['deliveredColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['availableColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['requiredColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dotted', array($aAdData['requestedColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
            }
        }
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  "3.png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt=""/>' . "\n";

        // Prepare the priority graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 600, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone: 2 Ad Complex Scale-Back Test', 12)),
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
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Priority', 'vertical');
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            if ($adKey == 2) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['priorityFactorColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
            }
        }
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  "4.png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt=""/>' . "\n";

        echo '<hr />' . "\n";
    }

    /**
     * A method to visually test the scaling back of the compensation factor.
     *
     * Performs a more relalistic version of the test above, with multiple ads,
     * and disabling of an ad during the operation of the zone.
     */
    function testScaleBackComplex2()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Mock the OA_Dal_Maintenance_Priority class
        $oDal = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);
        // Partially mock the OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class
        $oPriorityCompensation = new PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensationScaleBack($this);
        $oPriorityCompensation->setReturnReference('_getDal', $oDal);
        $oPriorityCompensation->OA_Maintenance_Priority_AdServer_Task_PriorityCompensation();
        // Define the number of initial iterations to test over
        $initialIterations = 12;
        // Define how many impressions are in the zone in each initial iteration
        $initialZoneImpressions = 10;
        // Define the number of final iterations to test over
        $finalIterations = 24;
        // Define how many impressions are in the zone in each final iteration
        $finalZoneImpressions = 20000;
        // Define the channels, including the % of zone impressions in each
        $aChannels[1] = 0.10; // Channel 1:  10% of zone traffic
        $aChannels[2] = 0.05; // Channel 2:   5% of zone traffic
        // Define the test ads, giving the number of required impressions
        // each hour (fixed), the channel the ad is in (if any), and the
        // colour to graph the ad
        // The number of ads must not exceed ($initialZoneImpressions - 1)
        // or ($finalZoneImpressions - 1), to ensure that the values for
        // the requestedImpressions >= 1 for all ads
        $aAds[1] = array(
            'requiredImpressions'   => 5000,
            'channel'               => null,
            'requiredColour'        => '#AA00FF',
            'requestedColour'       => 'blue',
            'availableColour'       => 'black',
            'deliveredColour'       => 'green',
            'priorityFactorColour'  => 'red'
        );
        $aAds[2] = array(
            'requiredImpressions'   => 5000,
            'channel'               => 1,
            'requiredColour'        => '#AA00FF',
            'requestedColour'       => 'blue',
            'availableColour'       => 'black',
            'deliveredColour'       => 'green',
            'priorityFactorColour'  => 'red'
        );
        $aAds[3] = array(
            'requiredImpressions'   => 5000,
            'channel'               => 2,
            'requiredColour'        => '#AA00FF',
            'requestedColour'       => 'blue',
            'availableColour'       => 'black',
            'deliveredColour'       => 'green',
            'priorityFactorColour'  => 'red'
        );
        // Preapare the graph data sets, ready to accept test data
        foreach ($aAds as $adKey => $aAdData) {
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Required Impressions');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Requested Impressions');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Available Impressions');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Delivered Impressions');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Priority Factor');
            $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
            ${$dataSetName} =& Image_Graph::factory('dataset');
            ${$dataSetName}->setName('Ad ' . $adKey .': Priority');
        }
        // Prepare the zone/ads for the initial iterations
        $oZone = new OA_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = $initialZoneImpressions;
        $zoneTotalRequired = 0;
        foreach ($aAds as $adKey => $aAdData) {
            $zoneTotalRequired += $aAdData['requiredImpressions'];
        }
        foreach ($aAds as $adKey => $aAdData) {
            $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
            $oAd->requiredImpressions = $aAdData['requiredImpressions'];
            if ($zoneTotalRequired > $oZone->availableImpressions) {
                $oAd->requestedImpressions = floor(($oZone->availableImpressions - 1) / count($aAds));
            } else {
                $oAd->requestedImpressions = $aAdData['requiredImpressions'];
            }
            $oZone->addAdvert($oAd);
        }
        $result = $oPriorityCompensation->learnedPriorities($oZone);
        // Perform the initial iterations
        $oSavedZone;
        $zoneImpressions = $initialZoneImpressions;
        for ($iteration = 0; $iteration <= $initialIterations; $iteration++) {
            // As these are the initial iterations, no delivery of any ads (zone not active)
            foreach ($aAds as $adKey => $aAdData) {
                $aDelivered[$adKey] = 0;
            }
            // Add the new data to the graph of the results
            foreach ($aAds as $adKey => $aAdData) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
                ${$dataSetName}->addPoint($iteration, $aAds[$adKey]['requiredImpressions']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['requested_impressions']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
                if (is_null($aAdData['channel'])) {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions);
                } else {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions * $aChannels[$aAdData['channel']]);
                }
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
                ${$dataSetName}->addPoint($iteration, $aDelivered[$adKey]);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['priority_factor']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['priority']);
            }
            // Prepare the ads/zone for the next iteration
            $oZone = new OA_Maintenance_Priority_Zone(array('zoneid' => 1));
            $oZone->availableImpressions = $zoneImpressions;
            $oZone->pastActualImpressions = $zoneImpressions;
            $zoneTotalRequired = 0;
            foreach ($aAds as $adKey => $aAdData) {
                $zoneTotalRequired += $aAdData['requiredImpressions'];
            }
            foreach ($aAds as $adKey => $aAdData) {
                $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
                $oAd->requiredImpressions = $aAdData['requiredImpressions'];
                if ($zoneTotalRequired > $zoneImpressions) {
                    $oAd->requestedImpressions = floor(($zoneImpressions - 1) / count($aAds));
                } else {
                    $oAd->requestedImpressions = $aAdData['requiredImpressions'];
                }
                $oAd->pastRequiredImpressions = $aAdData['requiredImpressions'];
                $oAd->pastRequestedImpressions = $result['ads'][$adKey]['requested_impressions'];
                $oAd->pastActualImpressions = $aDelivered[$adKey];
                $oAd->pastAdZonePriorityFactor = $result['ads'][$adKey]['priority_factor'];
                $oAd->pastZoneTrafficFraction = $result['ads'][$adKey]['past_zone_traffic_fraction'];
                $oZone->addAdvert($oAd);
            }
            // Move to the next iteration
            $result = $oPriorityCompensation->learnedPriorities($oZone);
        }
        // Prepare the zone/ads for the final iterations
        $zoneTotalRequired = 0;
        foreach ($aAds as $adKey => $aAdData) {
            $zoneTotalRequired += $aAdData['requiredImpressions'];
        }
        foreach ($aAds as $adKey => $aAdData) {
            $oAd =& $oZone->aAdverts[$adKey];
            $oAd->requiredImpressions = $aAdData['requiredImpressions'];
            if ($zoneTotalRequired > $oZone->availableImpressions) {
                $oAd->requestedImpressions = floor(($oZone->availableImpressions - 1) / count($aAds));
            } else {
                $oAd->requestedImpressions = $aAdData['requiredImpressions'];
            }
        }
        $result = $oPriorityCompensation->learnedPriorities($oZone);
        // Perform the final iterations
        $zoneImpressions = $finalZoneImpressions;
        for ($iteration = $initialIterations + 1; $iteration <= $initialIterations + $finalIterations; $iteration++) {
            // As these are the final iteration, calculate delivery
            foreach ($aAds as $adKey => $aAdData) {
                $aDelivered[$adKey] = 0;
            }
            $this->_predictDelivery($aDelivered, $zoneImpressions, $aAds, $aChannels, $result, $oPriorityCompensation);
            // Add the new data to the graph of the results
            foreach ($aAds as $adKey => $aAdData) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
                ${$dataSetName}->addPoint($iteration, $aAds[$adKey]['requiredImpressions']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['requested_impressions']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
                if (is_null($aAdData['channel'])) {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions);
                } else {
                    ${$dataSetName}->addPoint($iteration, $zoneImpressions * $aChannels[$aAdData['channel']]);
                }
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
                ${$dataSetName}->addPoint($iteration, $aDelivered[$adKey]);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['priority_factor']);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
                ${$dataSetName}->addPoint($iteration, $result['ads'][$adKey]['priority']);
            }
            // Prepare the ads/zone for the next iteration
            $oZone = new OA_Maintenance_Priority_Zone(array('zoneid' => 1));
            $oZone->availableImpressions = $zoneImpressions;
            $oZone->pastActualImpressions = $zoneImpressions;
            $zoneTotalRequired = 0;
            foreach ($aAds as $adKey => $aAdData) {
                if (!(($iteration > (($initialIterations + $finalIterations) / 2)) && ($adKey == 2))) {
                    $zoneTotalRequired += $aAdData['requiredImpressions'];
                }
            }
            foreach ($aAds as $adKey => $aAdData) {
                if (!(($iteration > (($initialIterations + $finalIterations) / 2)) && ($adKey == 2))) {
                    $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => $adKey));
                    $oAd->requiredImpressions = $aAdData['requiredImpressions'];
                    if ($zoneTotalRequired > $zoneImpressions) {
                        $oAd->requestedImpressions = floor(($zoneImpressions - 1) / count($aAds));
                    } else {
                        $oAd->requestedImpressions = $aAdData['requiredImpressions'];
                    }
                    $oAd->pastRequiredImpressions = $aAdData['requiredImpressions'];
                    $oAd->pastRequestedImpressions = $result['ads'][$adKey]['requested_impressions'];
                    $oAd->pastActualImpressions = $aDelivered[$adKey];
                    $oAd->pastAdZonePriorityFactor = $result['ads'][$adKey]['priority_factor'];
                    $oAd->pastZoneTrafficFraction = $result['ads'][$adKey]['past_zone_traffic_fraction'];
                    $oZone->addAdvert($oAd);
                }
            }
            $result = $oPriorityCompensation->learnedPriorities($oZone);
        }

        // Prepare the main graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 600, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone: Multi-Ad Complex Scale-Back Test', 12)),
                Image_Graph::vertical(
                    $oPlotarea = Image_Graph::factory('plotarea', array('axis', 'axis')),
                    $oLegend = Image_Graph::factory('legend'),
                    90
                ),
                10
            )
        );
        $oLegend->setPlotarea($oPlotarea);
        $oPlotareaSecondary =& Image_Graph::factory('plotarea', array('axis', 'axis', IMAGE_GRAPH_AXIS_Y_SECONDARY));
        $oGraph->add($oPlotareaSecondary);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_X);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_Y);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
        $oAxis->setTitle('Operation Intervals');
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Impressions', 'vertical');
        $oAxis =& Image_Graph::factory('axis', IMAGE_GRAPH_AXIS_Y_SECONDARY);
        $oPlotarea->add($oAxis);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y_SECONDARY);
        $oAxis->setTitle('Priority Factor', 'vertical2');
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            if ($adKey == 1) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName}, IMAGE_GRAPH_AXIS_Y_SECONDARY);
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['priorityFactorColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['deliveredColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['availableColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['requiredColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dotted', array($aAdData['requestedColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
            }
        }
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  "1.png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt=""/>' . "\n";

        // Prepare the priority graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 600, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone: Multi-Ad Complex Scale-Back Test', 12)),
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
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Priority', 'vertical');
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            if ($adKey == 1) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['priorityFactorColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
            }
        }
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  "2.png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt=""/>' . "\n";

        // Prepare the main graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 600, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone: Multi-Ad Complex Scale-Back Test', 12)),
                Image_Graph::vertical(
                    $oPlotarea = Image_Graph::factory('plotarea', array('axis', 'axis')),
                    $oLegend = Image_Graph::factory('legend'),
                    90
                ),
                10
            )
        );
        $oLegend->setPlotarea($oPlotarea);
        $oPlotareaSecondary =& Image_Graph::factory('plotarea', array('axis', 'axis', IMAGE_GRAPH_AXIS_Y_SECONDARY));
        $oGraph->add($oPlotareaSecondary);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_X);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_Y);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
        $oAxis->setTitle('Operation Intervals');
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Impressions', 'vertical');
        $oAxis =& Image_Graph::factory('axis', IMAGE_GRAPH_AXIS_Y_SECONDARY);
        $oPlotarea->add($oAxis);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y_SECONDARY);
        $oAxis->setTitle('Priority Factor', 'vertical2');
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            if ($adKey == 2) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName}, IMAGE_GRAPH_AXIS_Y_SECONDARY);
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['priorityFactorColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['deliveredColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['availableColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['requiredColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dotted', array($aAdData['requestedColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
            }
        }
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  "3.png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt=""/>' . "\n";

        // Prepare the priority graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 600, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone: Multi-Ad Complex Scale-Back Test', 12)),
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
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Priority', 'vertical');
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            if ($adKey == 2) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['priorityFactorColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
            }
        }
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  "4.png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt=""/>' . "\n";

        // Prepare the main graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 600, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone: Multi-Ad Complex Scale-Back Test', 12)),
                Image_Graph::vertical(
                    $oPlotarea = Image_Graph::factory('plotarea', array('axis', 'axis')),
                    $oLegend = Image_Graph::factory('legend'),
                    90
                ),
                10
            )
        );
        $oLegend->setPlotarea($oPlotarea);
        $oPlotareaSecondary =& Image_Graph::factory('plotarea', array('axis', 'axis', IMAGE_GRAPH_AXIS_Y_SECONDARY));
        $oGraph->add($oPlotareaSecondary);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_X);
        $oGridLines =& $oPlotarea->addNew('line_grid', array(), IMAGE_GRAPH_AXIS_Y);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
        $oAxis->setTitle('Operation Intervals');
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Impressions', 'vertical');
        $oAxis =& Image_Graph::factory('axis', IMAGE_GRAPH_AXIS_Y_SECONDARY);
        $oPlotarea->add($oAxis);
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y_SECONDARY);
        $oAxis->setTitle('Priority Factor', 'vertical2');
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            if ($adKey == 3) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_PriorityFactor';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName}, IMAGE_GRAPH_AXIS_Y_SECONDARY);
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['priorityFactorColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_DeliveredImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['deliveredColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_AvailableImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['availableColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequiredImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dashed', array($aAdData['requiredColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_RequestedImpressions';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Dotted', array($aAdData['requestedColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
            }
        }
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  "5.png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt=""/>' . "\n";

        // Prepare the priority graph
        $oCanvas =& Image_Canvas::factory('png', array('width' => 600, 'height' => 600, 'antialias' => false));
        $oGraph  =& Image_Graph::factory('graph', &$oCanvas);
        if (function_exists('imagettfbbox') && isset($conf['graphs']['ttfName'])) {
            $oFont =& $oGraph->addNew('ttf_font', $conf['graphs']['ttfName']);
            $oFont->setSize(9);
            $oGraph->setFont($oFont);
        }
        $oGraph->add(
            Image_Graph::vertical(
                Image_Graph::factory('title', array('Priority Compensation in Fixed Impression Zone: Multi-Ad Complex Scale-Back Test', 12)),
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
        $oAxis =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
        $oAxis->setTitle('Priority', 'vertical');
        // Ad the data sets to the graph
        foreach ($aAds as $adKey => $aAdData) {
            if ($adKey == 3) {
                $dataSetName = 'oDataSet_Ad_' . $adKey . '_Priority';
                $oPlot =& $oPlotarea->addNew('line', &${$dataSetName});
                $oLineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', array($aAdData['priorityFactorColour'], 'transparent'));
                $oPlot->setLineStyle($oLineStyle);
            }
        }
        $oPlotarea->setFillColor('white');
        $filename = "results/" . __CLASS__ . '_' . __FUNCTION__ .  "6.png";
        $oGraph->done(array('filename' => MAX_PATH . '/tests/' . $filename));
        echo '<img src="' . $filename . '" alt=""/>' . "\n";
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

}

?>
