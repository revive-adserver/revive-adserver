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
