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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation/Common.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the Maintenance_Priority_DeliveryLimitation_Common class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_DeliveryLimitation_Common extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_DeliveryLimitation_Common()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the deliveryBlocked() method.
     *
     * Tests that the method in the class returns a PEAR::Error, as method is abstract.
     */
    function testDeliveryBlocked()
    {
        $oDate = new Date();
        PEAR::pushErrorHandling(null);
        $this->assertTrue(is_a(OA_Maintenance_Priority_DeliveryLimitation_Common::deliveryBlocked($oDate), 'pear_error'));
        PEAR::popErrorHandling();
    }
}

?>
