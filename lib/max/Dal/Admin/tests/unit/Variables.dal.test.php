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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing DAL Variables methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_VariablesTest extends DalUnitTestCase
{

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testGetTrackerVariables()
    {
        $dalVariables = OA_Dal::factoryDAL('variables');
        $rs = $dalVariables->getTrackerVariables(null, 1, false);
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
        DataGenerator::generateOne($doVariablePublisher);

        $rs = $dalVariables->getTrackerVariables($zoneId, 1, false);
        $rs->reset();
        $this->assertEqual(1, $rs->getRowCount());

        DataGenerator::cleanUp();
    }

}

?>