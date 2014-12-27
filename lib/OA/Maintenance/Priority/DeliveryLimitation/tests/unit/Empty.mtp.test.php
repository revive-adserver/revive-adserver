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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation/Empty.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OA_Maintenance_Priority_DeliveryLimitation_Empty extends UnitTestCase
{

    /**
     * A method to test the deliveryBlocked() method.
     */
    function testDeliveryBlocked()
    {
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'Client:IP',
            'comparison'     => '==',
            'data'           => '192.168.0.1',
            'executionorder' => 1
        );
        $oLimitationDay = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);

        $oDate = new Date('2006-02-05');
        $this->assertFalse($oLimitationDay->deliveryBlocked($oDate));
    }

}

?>
