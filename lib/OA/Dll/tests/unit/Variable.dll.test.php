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

require_once MAX_PATH . '/lib/OA/Dll/Variable.php';
require_once MAX_PATH . '/lib/OA/Dll/VariableInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/Tracker.php';
require_once MAX_PATH . '/lib/OA/Dll/TrackerInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Variable methods
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 * @author     David Keen <david.keen@openx.org>
 *
 */


class OA_Dll_VariableTest extends DllUnitTestCase {
    private $clientId;

    function __construct()
    {
        parent::__construct();
        Mock::generatePartial(
            'OA_Dll_Tracker',
            'PartialMockOA_Dll_Tracker',
            array('checkPermissions')
        );
        Mock::generatePartial(
            'OA_Dll_Variable',
            'PartialMockOA_Dll_Variable',
            array('checkPermissions')
        );
    }

    function setUp()
    {
        $this->clientId = DataGenerator::generateOne('clients', true);
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }


    /**
     * A method to test Add, Modify and Delete.
     */
    function testAddModifyDelete()
    {
        $dllTrackerPartialMock = new PartialMockOA_Dll_Tracker($this);
        $dllVariablePartialMock = new PartialMockOA_Dll_Variable($this);

        $dllTrackerPartialMock->setReturnValue('checkPermissions', true);

        $dllVariablePartialMock->setReturnValue('checkPermissions', true);

        $oTrackerInfo = new OA_Dll_TrackerInfo();
        $oTrackerInfo->trackerName = 'test tracker name';
        $oTrackerInfo->clientId       = $this->clientId;
        $dllTrackerPartialMock->modify($oTrackerInfo);

        $oVariableInfo = new OA_Dll_VariableInfo();
        $oVariableInfo->trackerId = $oTrackerInfo->trackerId;
        $oVariableInfo->variableName = 'Test variable name';

        // Add
        $this->assertTrue($dllVariablePartialMock->modify($oVariableInfo),
            $dllVariablePartialMock->getLastError());

        // Modify
        $this->assertTrue($dllVariablePartialMock->modify($oVariableInfo),
            $dllVariablePartialMock->getLastError());

        // Delete
        $this->assertTrue($dllVariablePartialMock->delete($oVariableInfo->variableId),
            $dllVariablePartialMock->getLastError());

        // Modify not existing id
        $this->assertTrue((!$dllVariablePartialMock->modify($oVariableInfo) &&
            $dllVariablePartialMock->getLastError() == OA_Dll_Variable::ERROR_UNKNOWN_ID),
            $this->_getMethodShouldReturnError(OA_Dll_Variable::ERROR_UNKNOWN_ID));

        // Delete not existing id
        $this->assertTrue((!$dllVariablePartialMock->delete($oVariableInfo->variableId) &&
            $dllVariablePartialMock->getLastError() == OA_Dll_Variable::ERROR_UNKNOWN_ID),
            $this->_getMethodShouldReturnError(OA_Dll_Variable::ERROR_UNKNOWN_ID));

        $dllVariablePartialMock->tally();
    }

    function testGet()
    {
        $dllTrackerPartialMock = new PartialMockOA_Dll_Tracker($this);
        $dllVariablePartialMock = new PartialMockOA_Dll_Variable($this);

        $dllTrackerPartialMock->setReturnValue('checkPermissions', true);
        $dllVariablePartialMock->setReturnValue('checkPermissions', true);

        $oTrackerInfo = new OA_Dll_TrackerInfo();
        $oTrackerInfo->trackerName = 'test tracker name';
        $oTrackerInfo->clientId = $this->clientId;

        $this->assertTrue($dllTrackerPartialMock->modify($oTrackerInfo),
                          $dllTrackerPartialMock->getLastError());

        // Add
        $oVariableInfo = new OA_Dll_VariableInfo();
        $oVariableInfo->trackerId = $oTrackerInfo->trackerId;
        $oVariableInfo->variableName  = 'test name 1';

        $this->assertTrue($dllVariablePartialMock->modify($oVariableInfo),
            $dllVariablePartialMock->getLastError());

        $oVariableInfoGet = null;

        // Get
        $this->assertTrue($dllVariablePartialMock->getVariable($oVariableInfo->variableId,
            $oVariableInfoGet), $dllVariablePartialMock->getLastError());

        // Check field value
        $this->assertFieldEqual($oVariableInfo, $oVariableInfoGet, 'variableName');
        $this->assertFieldEqual($oVariableInfo, $oVariableInfoGet, 'trackerId');
    }

    function testHidden()
    {
        // Add websites
        $aWebsiteIds = DataGenerator::generate('affiliates', 2);

        // Add zones
        $aZoneIds = array();

        foreach ($aWebsiteIds as $websiteId) {
            $doZones = OA_Dal::factoryDO('zones');
            $doZones->affiliateid = $websiteId;
            $aZoneIds[] = DataGenerator::generateOne($doZones);
        }

        // Create a campaign
        $campaignId = DataGenerator::generateOne('campaigns');
        $doBanner = OA_Dal::factoryDO('banners');
        $doBanner->campaignid = $campaignId;
        $bannerId = DataGenerator::generateOne($doBanner);

        // Link the campaign's banner to the zones
        $doAza = OA_Dal::factoryDO('ad_zone_assoc');
        foreach ($aZoneIds as $zoneId) {
            $doAza->zone_id = $aZoneIds[$zoneId];
            $doAza->ad_id = $bannerId;
            DataGenerator::generateOne($doAza);
        }

        // Create  tracker
        $trackerId = DataGenerator::generateOne('trackers');
        
        // Link the tracker to the campaign
        $doCampaignsTrackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaignsTrackers->campaignid = $campaignId;
        $doCampaignsTrackers->trackerid = $trackerId;
        DataGenerator::generateOne($doCampaignsTrackers);

        // Add the variable hidden to website 0
        $dllVariablePartialMock = new PartialMockOA_Dll_Variable($this);
        $dllVariablePartialMock->setReturnValue('checkPermissions', true);

        $oVariableInfo = new OA_Dll_VariableInfo();
        $oVariableInfo->trackerId = $trackerId;
        $oVariableInfo->variableName = 'Test hidden variable name';
        $oVariableInfo->hidden = true;
        $oVariableInfo->hiddenWebsites = array($aWebsiteIds[1]);

        // Add with hidden website
        $this->assertTrue($dllVariablePartialMock->modify($oVariableInfo),
            $dllVariablePartialMock->getLastError());

        // Check the value of variable_publisher
        $doVariablePublisher = OA_Dal::factoryDO('variable_publisher');
        $doVariablePublisher->variable_id = $oVariableInfo->variableId;
        $doVariablePublisher->find(true);
        $this->assertEqual(1, $doVariablePublisher->count());
        $this->assertEqual($aWebsiteIds[0], $doVariablePublisher->publisher_id);
    }

    function testUnique()
    {
        // Add a tracker
        $trackerId = DataGenerator::generateOne('trackers');

        // Add a unique variable
        $dllVariablePartialMock = new PartialMockOA_Dll_Variable($this);
        $dllVariablePartialMock->setReturnValue('checkPermissions', true);

        $oVariableInfo = new OA_Dll_VariableInfo();
        $oVariableInfo->trackerId = $trackerId;
        $oVariableInfo->variableName = 'Test variable 1';
        $oVariableInfo->isUnique = true;

        $this->assertTrue($dllVariablePartialMock->modify($oVariableInfo),
            $dllVariablePartialMock->getLastError());

        // Add another unqique variable
        $oVariableInfo2 = new OA_Dll_VariableInfo();
        $oVariableInfo2->trackerId = $trackerId;
        $oVariableInfo2->variableName = 'Test variable 2';
        $oVariableInfo2->isUnique = true;

        $this->assertTrue($dllVariablePartialMock->modify($oVariableInfo2),
            $dllVariablePartialMock->getLastError());

        // Check the second var is unique
        $doVariable = OA_Dal::staticGetDO('variables', $oVariableInfo2->variableId);
        $this->assertEqual(1, $doVariable->is_unique);

        // Check the first var is not unique any more
        $doVariable = OA_Dal::staticGetDO('variables', $oVariableInfo->variableId);
        $this->assertEqual(0, $doVariable->is_unique);

    }

}

?>