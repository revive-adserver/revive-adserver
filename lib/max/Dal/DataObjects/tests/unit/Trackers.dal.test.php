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

/**
 * A class for testing non standard DataObjects_Trackers methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 */
class DataObjects_TrackersTest extends DalUnitTestCase
{
    /**
     * The constructor method.
     */
    function DataObjects_TrackersTest()
    {
        $this->UnitTestCase();
    }

    function tearDown()
    {
        DataGenerator::cleanUp(array('trackers'));
    }

    function testDuplicate()
    {
        // Insert a tracker with some default data.
        $doTrackers = OA_Dal::factoryDO('trackers');
        $doTrackers->trackername = 'foo';
        $doTrackers->clientid = 1;
        $doTrackers->clickwindow = 3600;
        $doTrackers->status = 4;
        $doTrackers->type = 1;
        $trackerId = DataGenerator::generateOne($doTrackers, true);

        // Insert a variable for the tracker
        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid = $trackerId;
        $doVariables->name = 'bar';
        $variableId = DataGenerator::generateOne($doVariables);

        // Link the tracker to a campaign
        $doCampaignTrackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaignTrackers->campaignid = 1;
        $doCampaignTrackers->trackerid = $trackerId;
        $campaignTrackerId = DataGenerator::generateOne($doCampaignTrackers);

        // Duplicate the tracker
        $doTrackers = OA_Dal::staticGetDO('trackers', $trackerId);
        $newTrackerId = $doTrackers->duplicate();
        $this->assertNotEmpty($newTrackerId);

        // Get the two trackers
        $doNewTrackers = OA_Dal::staticGetDO('trackers', $newTrackerId);
        $this->assertTrue($doNewTrackers);
        $doTrackers = OA_Dal::staticGetDO('trackers', $trackerId);
        $this->assertTrue($doTrackers);

        // Assert the trackers are not equal, excluding the primary key
        $this->assertNotEqualDataObjects($this->stripKeys($doTrackers), $this->stripKeys($doNewTrackers));

        // Assert the only difference in the trackers is their description
        $doTrackers->trackername = $doNewTrackers->trackername = null;
        $this->assertEqualDataObjects($this->stripKeys($doTrackers), $this->stripKeys($doNewTrackers));

        // Get the two variables
        $doNewVariables = OA_Dal::staticGetDO('variables', 'trackerid', $newTrackerId);
        $this->assertTrue($doNewVariables);
        $doVariables = OA_Dal::staticGetDO('variables', $variableId);
        $this->assertTrue($doVariables);

        // Assert the variables are not equal, excluding the primary key
        $this->assertNotEqualDataObjects($this->stripKeys($doVariables), $this->stripKeys($doNewVariables));

        // Assert the only difference in the variables is the trackers they are attached to
        $doVariables->trackerid = $doNewVariables->trackerid = null;
        $this->assertEqualDataObjects($this->stripKeys($doVariables), $this->stripKeys($doNewVariables));

        // Get the two campaign tracker links
        $doNewCampaignTrackers = OA_Dal::staticGetDO('campaigns_trackers', 'trackerid', $newTrackerId);
        $this->assertTrue($doNewCampaignTrackers);
        $doCampaignTrackers = OA_Dal::staticGetDO('campaigns_trackers', $campaignTrackerId);
        $this->assertTrue($doCampaignTrackers);

        // Assert the campaign trackers are not equal, excluding the primary key
        $this->assertNotEqualDataObjects($this->stripKeys($doCampaignTrackers), $this->stripKeys($doNewCampaignTrackers));

        // Assert the only difference in the campaign trackers is the trackers they are attached to
        $doCampaignTrackers->trackerid = $doNewCampaignTrackers->trackerid = null;
        $this->assertEqualDataObjects($this->stripKeys($doCampaignTrackers), $this->stripKeys($doNewCampaignTrackers));

        DataGenerator::cleanUp(array('campaigns', 'campaigns_trackers','trackers','variables'));

    }

}

?>