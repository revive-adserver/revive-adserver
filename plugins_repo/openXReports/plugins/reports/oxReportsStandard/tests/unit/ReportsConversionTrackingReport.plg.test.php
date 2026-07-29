<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the Plugins_Reports_Standard_ConversionTrackingReport class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_Reports_oxStandard_ConversionTrackingReport extends UnitTestCase
{
    /**
     * @var Plugins_Reports_Standard_ConversionTrackingReport
     */
    public $oPlugin;

    public function setUp()
    {
        //$this->oPlugin = &MAX_Plugin::factory('reports', 'oxStandard', 'conversionTrackingReport');
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = str_replace('reports/oxReportsStandard/tests/unit', '', dirname(str_replace(MAX_PATH, '', __FILE__)));
        $this->oPlugin = &OX_Component::factory('reports', 'oxReportsStandard', 'conversionTrackingReport');
    }

    public function tearDown()
    {
        DataGenerator::cleanUp();
        TestEnv::restoreConfig();
    }

    public function testConnectionDetailExportsNullableStringVariables()
    {
        Language_Loader::load();
        Mock::generatePartial(
            'Plugins_Reports_OxReportsStandard_ConversionTrackingReport',
            'PartialMockConversionTrackingReport',
            ['_isTrackerLinkedToAnonymousCampaign', '_getReportParametersForDisplay', '_getReportWarningsForDisplay'],
        );
        $report = new PartialMockConversionTrackingReport();
        $report->oTrans = $this->oPlugin->oTrans;
        $report->setReturnValue('_isTrackerLinkedToAnonymousCampaign', false);
        $report->setReturnValue('_getReportParametersForDisplay', []);
        $report->setReturnValue('_getReportWarningsForDisplay', []);
        $writer = new ConversionTrackingReportCaptureWriter();
        $report->useReportWriter($writer);

        $trackers = [1 => [
            'tracker_name' => 'Tracker',
            'variables' => [2 => [
                'tracker_variable_description' => 'Optional field',
                'tracker_variable_name' => 'optional',
                'tracker_variable_data_type' => 'string',
                'tracker_variable_hidden' => 'f',
            ]],
        ]];
        $connection = array_fill_keys([
            'tracker_date_time', 'connection_comments', 'connection_channel',
            'advertiser_name', 'ad_name', 'ad_alt', 'publisher_name', 'zone_name',
            'connection_date_time', 'connection_ip_address', 'connection_country',
            'connection_domain', 'connection_language', 'connection_os',
            'connection_browser', 'window_delay',
        ], '');
        $connection += [
            'connection_status' => MAX_CONNECTION_STATUS_APPROVED,
            'connection_action' => MAX_CONNECTION_AD_IMPRESSION,
            'advertiser_id' => 1, 'ad_id' => 1, 'publisher_id' => 1, 'zone_id' => 1,
        ];

        foreach ([null, '', 'normal', '=formula', '@formula', 123] as $value) {
            $connection['variables'] = [2 => ['tracker_variable_value' => $value]];
            $report->_addConnectionDetailWorksheet([1 => ['connections' => [3 => $connection]]], $trackers);
            $expected = match ($value) {
                '=formula', '@formula' => 'formula',
                123 => '123',
                default => $value,
            };
            $this->assertIdentical($writer->rows[0][2], $expected);
        }
    }

    /**
     * A method to test the _prepareTrackerVariables() method.
     */
    public function test_prepareTrackerVariables()
    {
        // Prepare test data
        $doTrackers = OA_Dal::factoryDO('trackers');
        $trackerId = DataGenerator::generateOne($doTrackers);
        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid = $trackerId;
        $variableId = DataGenerator::generateOne($doVariables);
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $publisherId = DataGenerator::generateOne($doAffiliates);
        $doVariablePublisher = OA_Dal::factoryDO('variable_publisher');
        $doVariablePublisher->variable_id = $trackerId;
        $doVariablePublisher->publisher_id = $publisherId;
        $doVariablePublisher->visible = 1;
        $variablepublisherId = DataGenerator::generateOne($doVariablePublisher);

        // Tests with empty connections table
        $result = $this->oPlugin->_prepareTrackerVariables([]);
        $this->assertEqual(count($result), 0);
        // Tests with one existing tracker in connections table
        $result = $this->oPlugin->_prepareTrackerVariables([ $trackerId => []]);
        $this->assertEqual(count($result), 1);
    }
}

class ConversionTrackingReportCaptureWriter
{
    public $rows;

    public function createReportWorksheet(...$args) {}

    public function createReportSection($worksheet, $name, $headers, $rows, ...$args)
    {
        $this->rows = $rows;
    }
}
