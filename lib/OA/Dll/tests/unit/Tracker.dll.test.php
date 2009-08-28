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

require_once MAX_PATH . '/lib/OA/Dll/Advertiser.php';
require_once MAX_PATH . '/lib/OA/Dll/AdvertiserInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/Tracker.php';
require_once MAX_PATH . '/lib/OA/Dll/TrackerInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Tracker methods
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 * @author     David Keen <david.keen@openx.org>
 *
 */


class OA_Dll_TrackerTest extends DllUnitTestCase
{
    /**
     * @var int
     */
    var $agencyId;

    function __construct()
    {
        parent::__construct();
        Mock::generatePartial(
            'OA_Dll_Tracker',
            'PartialMockOA_Dll_Tracker',
            array('checkPermissions', 'updateVariableCode')
        );
        Mock::generatePartial(
            'OA_Dll_Advertiser',
            'PartialMockOA_Dll_Advertiser',
            array('checkPermissions', 'getDefaultAgencyId')
        );
    }

    function setUp()
    {
        $this->agencyId = DataGenerator::generateOne('agency');
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
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser($this);
        $dllTrackerPartialMock = new PartialMockOA_Dll_Tracker($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 2);

        $dllTrackerPartialMock->setReturnValue('checkPermissions', true);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';
        $oAdvertiserInfo->agencyId       = $this->agencyId;

        $dllAdvertiserPartialMock->modify($oAdvertiserInfo);

        $oTrackerInfo = new OA_Dll_TrackerInfo();
        $oTrackerInfo->clientId = $oAdvertiserInfo->advertiserId;
        $oTrackerInfo->trackerName = 'Test tracker name';

        // Add
        $this->assertTrue($dllTrackerPartialMock->modify($oTrackerInfo),
                          $dllTrackerPartialMock->getLastError());

        // Modify (don't change the variableMethod)
        unset($oTrackerInfo->variableMethod);
        $this->assertTrue($dllTrackerPartialMock->modify($oTrackerInfo),
                          $dllTrackerPartialMock->getLastError());

        // Modify (change variableMethod)
        $oTrackerInfo->variableMethod = 'dom';
        $this->assertTrue($dllTrackerPartialMock->modify($oTrackerInfo),
                          $dllTrackerPartialMock->getLastError());

        // Delete
        $this->assertTrue($dllTrackerPartialMock->delete($oTrackerInfo->trackerId),
            $dllTrackerPartialMock->getLastError());

        // Modify not existing id
        $this->assertTrue((!$dllTrackerPartialMock->modify($oTrackerInfo) &&
                          $dllTrackerPartialMock->getLastError() == OA_Dll_Tracker::ERROR_UNKNOWN_TRACKER_ID),
            $this->_getMethodShouldReturnError(OA_Dll_Tracker::ERROR_UNKNOWN_TRACKER_ID));

        // Delete not existing id
        $this->assertTrue((!$dllTrackerPartialMock->delete($oTrackerInfo->trackerId) &&
                           $dllTrackerPartialMock->getLastError() == OA_Dll_Tracker::ERROR_UNKNOWN_TRACKER_ID),
            $this->_getMethodShouldReturnError(OA_Dll_Tracker::ERROR_UNKNOWN_TRACKER_ID));

    }

    function testLinkTrackerToCampaign()
    {
        $dllTrackerPartialMock = new PartialMockOA_Dll_Tracker($this);
        $dllTrackerPartialMock->setReturnValue('checkPermissions', true);

        // Non existent tracker
        $this->assertFalse($dllTrackerPartialMock->linkTrackerToCampaign(9999, 9999));

        $doTrackers = OA_Dal::factoryDO('trackers');
        $doTrackers->clientid = 3;
        $trackerId = DataGenerator::generateOne($doTrackers);

        // Non existent campaign
        $this->assertFalse($dllTrackerPartialMock->linkTrackerToCampaign($trackerId, 9999));

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = 3;
        $campaignId = DataGenerator::generateOne($doCampaigns, true);

        $this->assertTrue($dllTrackerPartialMock->linkTrackerToCampaign($trackerId, $campaignId));

        // Link to campaign for a different advertiser
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = 5;
        $campaignId = DataGenerator::generateOne($doCampaigns, true);

        $this->assertFalse($dllTrackerPartialMock->linkTrackerToCampaign($trackerId, $campaignId));
        $this->assertTrue(!$dllTrackerPartialMock->linkTrackerToCampaign($trackerId, $campaignId) &&
            $dllTrackerPartialMock->getLastError() == OA_Dll_Tracker::ERROR_CAMPAIGN_ADVERTISER_MISMATCH,
            $this->_getMethodShouldReturnError(OA_Dll_Tracker::ERROR_CAMPAIGN_ADVERTISER_MISMATCH));
    }

    function testGet()
    {
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser($this);
        $dllTrackerPartialMock = new PartialMockOA_Dll_Tracker($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);

        $dllTrackerPartialMock->setReturnValue('checkPermissions', true);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';
        $oAdvertiserInfo->agencyId = $this->agencyId;

        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo),
                          $dllAdvertiserPartialMock->getLastError());

        // Add
        $oTrackerInfo = new OA_Dll_TrackerInfo();
        $oTrackerInfo->clientId = $oAdvertiserInfo->advertiserId;
        $oTrackerInfo->trackerName  = 'test name 1';

        $this->assertTrue($dllTrackerPartialMock->modify($oTrackerInfo),
            $dllTrackerPartialMock->getLastError());

        $oTrackerInfoGet = null;

        // Get
        $this->assertTrue($dllTrackerPartialMock->getTracker($oTrackerInfo->trackerId,
            $oTrackerInfoGet), $dllTrackerPartialMock->getLastError());

        // Check field value
        $this->assertFieldEqual($oTrackerInfo, $oTrackerInfoGet, 'trackerName');
        $this->assertFieldEqual($oTrackerInfo, $oTrackerInfoGet, 'clientId');
    }

}

?>