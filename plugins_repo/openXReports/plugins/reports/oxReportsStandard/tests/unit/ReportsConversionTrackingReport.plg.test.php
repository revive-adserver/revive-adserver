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
    var $oPlugin;

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    function setUp()
    {
        //$this->oPlugin = &MAX_Plugin::factory('reports', 'oxStandard', 'conversionTrackingReport');
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = str_replace('reports/oxReportsStandard/tests/unit','',dirname(str_replace(MAX_PATH,'',__FILE__)));
        $this->oPlugin = &OX_Component::factory('reports', 'oxReportsStandard', 'conversionTrackingReport');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
        TestEnv::restoreConfig();
    }

    /**
     * A method to test the _prepareTrackerVariables() method.
     */
    function test_prepareTrackerVariables()
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
        $result = $this->oPlugin->_prepareTrackerVariables(array());
        $this->assertEqual(count($result),0);
        // Tests with one existing tracker in connections table
        $result = $this->oPlugin->_prepareTrackerVariables(array( $trackerId => array()));
        $this->assertEqual(count($result),1);
    }
}

?>
