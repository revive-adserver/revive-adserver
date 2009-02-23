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
$Id: Priority_getAllZonesWithAllocInv.dal.test.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the updateEcpmPriorities() method of the non-DB specific
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@urbantrip.com>
 */
class Test_OA_Dal_Maintenance_Priority_updateEcpmPriorities extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_updateEcpmPriorities()
    {
        $this->UnitTestCase();
    }

    /**
     * Method to test the updateEcpmPriorities method.
     */
    function testUpdateEcpmPriorities()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDal = new OA_Dal_Maintenance_Priority();

        // set up ad_zone_assoc records
        $this->addAdZoneAssoc($adId1 = 1, $zoneId1 = 1, 0.1);
        $this->addAdZoneAssoc($adId1 = 1, $zoneId2 = 2, 0.2);
        $this->addAdZoneAssoc($adId2 = 2, $zoneId3 = 3, 0.3);
        $this->addAdZoneAssoc($adId4 = 4, $zoneId4 = 4, $priority44 = 0.4);

        $aData = array(
            $adId1 => array(
                $zoneId1 => $priority11 = 0.11,
                $zoneId2 => $priority12 = 0.12,
            ),
            $adId2 => array(
                $zoneId3 => $priority23 = 0.23,
            ),
        );

        $ret = $oDal->updateEcpmPriorities($aData);
        $this->assertTrue($ret);

        $this->checkPriority($adId1, $zoneId1, $priority11);
        $this->checkPriority($adId1, $zoneId2, $priority12);
        $this->checkPriority($adId2, $zoneId3, $priority23);

        // Check that this priority didn't change
        $this->checkPriority($adId4, $zoneId4, $priority44);

        DataGenerator::cleanUp();
    }

    function checkPriority($adId, $zoneId, $priority)
    {
        $doAd_zone_assoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAd_zone_assoc->ad_id = $adId;
        $doAd_zone_assoc->zone_id = $zoneId;
        $doAd_zone_assoc->find($autofetch = true);
        $this->assertEqual($priority, $doAd_zone_assoc->priority);
    }

    function addAdZoneAssoc($adId, $zoneId, $priority)
    {
        $doAd_zone_assoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAd_zone_assoc->ad_id = $adId;
        $doAd_zone_assoc->zone_id = $zoneId;
        $doAd_zone_assoc->priority = $priority;
        DataGenerator::generateOne($doAd_zone_assoc);
    }
}

?>
