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
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Ad.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/GetRequiredAdImpressionsLifetime.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';

class Test_OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime extends UnitTestCase
{
    
    /**
     * A method to test the _getInventoryImpressionsRequired() method.
     *
     * Test 1: Test with no inventory required, and ensure that 0 is returned.
     * Test 2: Test with inventory required, but no past data, and ensure that
     *         the default ratio is used correctly.
     * Test 3: Test with inventory required, but no past data, and ensure that
     *         the default ratio is used correctly, and that values are rounded
     *         up.
     * Test 4: Test with past data, and ensure that real ratio is calculated
     *         and used correctly.
     */
    function test_getInventoryImpressionsRequired()
    {
        $oGetRequiredAdImpressionsLifetime = new OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime();

        // Test 1
        $inventory = 0;
        $defaultRatio = 0.1;
        $result = $oGetRequiredAdImpressionsLifetime->_getInventoryImpressionsRequired($inventory, $defaultRatio);
        $this->assertEqual($result, 0);

        // Test 2
        $inventory = 1;
        $defaultRatio = 0.1;
        $result = $oGetRequiredAdImpressionsLifetime->_getInventoryImpressionsRequired($inventory, $defaultRatio);
        $this->assertEqual($result, 10);

        // Test 3
        $inventory = 1;
        $defaultRatio = 0.3;
        $result = $oGetRequiredAdImpressionsLifetime->_getInventoryImpressionsRequired($inventory, $defaultRatio);
        $this->assertEqual($result, 4);

        // Test 4
        $inventory = 100;
        $defaultRatio = 0.3;
        $inventoryToDate = 50;
        $impressionsToDate = 1000;
        $result = $oGetRequiredAdImpressionsLifetime->_getInventoryImpressionsRequired(
            $inventory,
            $defaultRatio,
            $inventoryToDate,
            $impressionsToDate
        );
        $this->assertEqual($result, 1000);
        
        // Test 5
        $inventory = 100;
        $defaultRatio = 0.3;
        $inventoryToDate = 200;
        $impressionsToDate = 1000;
        $result = $oGetRequiredAdImpressionsLifetime->_getInventoryImpressionsRequired(
            $inventory,
            $defaultRatio,
            $inventoryToDate,
            $impressionsToDate
        );
        $this->assertEqual($result, 0);
    }

    /**
     * A method to test the _getSmallestNonZeroInteger() method.
     */
    function test_getSmallestNonZeroInteger()
    {
        $oGetRequiredAdImpressionsLifetime = new OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime();
        $this->assertEqual(0, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(0,0,0)));
        $this->assertEqual(1, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(1,0,0)));
        $this->assertEqual(1, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(-1,1,1)));
        $this->assertEqual(1, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(1,1,1)));
        $this->assertEqual(0, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(-1,-1,-1)));
        $this->assertEqual(4, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(32,18,4)));
        $this->assertEqual(0, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(-1,'what','string')));
        $this->assertEqual(0, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger('foo'));
        $this->assertEqual(0, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(5000));
        $this->assertEqual(0, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger());
        $this->assertEqual(748, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(748,849,35625)));
    }
    
}
