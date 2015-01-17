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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the updateEcpmPriorities() method of the non-DB specific
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal_Maintenance_Priority_updateEcpmPriorities extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
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
