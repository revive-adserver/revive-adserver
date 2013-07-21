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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once MAX_PATH . '/lib/max/Dal/Admin/Variables.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Trackers.php';

/**
 * A class for testing DAL Variables methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_VariablesTest extends DalUnitTestCase
{
    private $dalVariables;

    private $varName;
    private $defaultVarCode;
    private $customCode;

    public function setUp()
    {
        $this->dalVariables = OA_Dal::factoryDAL('variables');
    }

    public function tearDown()
    {
        DataGenerator::cleanUp();
    }

    public function testGetTrackerVariables()
    {
        $rs = $this->dalVariables->getTrackerVariables(null, 1, false);
        $this->assertEqual(0, $rs->getRowCount());

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->affiliateid = 1;
        $zoneId = DataGenerator::generateOne($doZones);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = 1;
        $doBanners->acls_updated = '2007-04-03 19:22:16';
        $bannerId = DataGenerator::generateOne($doBanners);

        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_id = $bannerId;
        $doAdZoneAssoc->find();
        $doAdZoneAssoc->fetch();
        $doAdZoneAssoc->zone_id = $zoneId;
        $doAdZoneAssoc->update();

        $doTrackers = OA_Dal::factoryDO('trackers');
        $trackerId = DataGenerator::generateOne($doTrackers);

        $doCampaignsTrackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaignsTrackers->campaignid = 1;
        $doCampaignsTrackers->trackerid = $trackerId;
        DataGenerator::generateOne($doCampaignsTrackers);

        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid = $trackerId;
        $doVariables->datatype = 'numeric';
        $variableId = DataGenerator::generateOne($doVariables);

        $doVariablePublisher = OA_Dal::factoryDO('variable_publisher');
        $doVariablePublisher->variable_id = $variableId;
        $doVariablePublisher->publisher_id = 1;
        $doVariablePublisher->visible = 0;
        DataGenerator::generateOne($doVariablePublisher);

        $rs = $this->dalVariables->getTrackerVariables($zoneId, 1, false);
        $rs->reset();
        $this->assertEqual(1, $rs->getRowCount());

    }

    function testUpdateVariableCode()
    {
        $this->varName = 'my_var';
        $this->defaultVarCode = "var {$this->varName} = escape(\\'%%".strtoupper($this->varName)."_VALUE%%\\')";

        // Create a tracker with default variableMethod
        $doTrackers = OA_Dal::factoryDO('trackers');
        $trackerId = DataGenerator::generateOne($doTrackers);

        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid = $trackerId;
        $doVariables->name = $this->varName;
        $doVariables->variablecode = $this->defaultVarCode;
        $aVariableIds = DataGenerator::generate($doVariables, 2);

        // JS
        $this->assertTrue($this->dalVariables->updateVariableCode(
            $trackerId, DataObjects_Trackers::TRACKER_VARIABLE_METHOD_JS));
        $this->assertVariableCode($trackerId, DataObjects_Trackers::TRACKER_VARIABLE_METHOD_JS);

        // DOM
        $this->assertTrue($this->dalVariables->updateVariableCode(
            $trackerId, DataObjects_Trackers::TRACKER_VARIABLE_METHOD_DOM));
        $this->assertVariableCode($trackerId, DataObjects_Trackers::TRACKER_VARIABLE_METHOD_DOM);

        // Custom
        $this->customCode = 'custom';
        $doVariables->variablecode = $this->customCode;
        $doVariables->whereAdd('1=1');
        $doVariables->update(DB_DATAOBJECT_WHEREADD_ONLY);
        $this->assertTrue($this->dalVariables->updateVariableCode(
            $trackerId, DataObjects_Trackers::TRACKER_VARIABLE_METHOD_CUSTOM));
        $this->assertVariableCode($trackerId, DataObjects_Trackers::TRACKER_VARIABLE_METHOD_CUSTOM);

        // Default
        $this->assertTrue($this->dalVariables->updateVariableCode($trackerId));
        $this->assertVariableCode($trackerId);
    }

    private function assertVariableCode($trackerId, $method = null)
    {
        switch ($method) {
            case DataObjects_Trackers::TRACKER_VARIABLE_METHOD_JS:
                $expected = "var {$this->varName} = \\'%%".strtoupper($this->varName)."_VALUE%%\\'";
                break;
            case DataObjects_Trackers::TRACKER_VARIABLE_METHOD_DOM:
                $expected = '';
                break;
            case DataObjects_Trackers::TRACKER_VARIABLE_METHOD_CUSTOM:
                $expected = "var {$this->varName} = \\'" . $this->customCode . "\\'";
                break;
            default:
                $expected = $this->defaultVarCode;
        }

        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid = $trackerId;
        $doVariables->find();
        while ($doVariables->fetch()) {
            $actual = $doVariables->variablecode;
            $this->assertEqual($expected, $actual);
        }
        
    }
}

?>
