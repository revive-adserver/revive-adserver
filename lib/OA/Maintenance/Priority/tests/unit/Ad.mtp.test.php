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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Ad.php';

/**
 * A class for testing the OA_Maintenance_Priority_Ad class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_Ad extends UnitTestCase
{

    /**
     * The class constructor method.
     */
    function  Test_OA_Maintenance_Priority_Ad()
    {
        $this->UnitTestCase();
        Mock::generate('OA_Dal_Maintenance_Priority');
        Mock::generatePartial('OA_Maintenance_Priority_Ad', 'MockPartialOA_Maintenance_Priority_Ad', array('_abort'));
    }

    /**
     * A method to be called before every test to store default
     * mocked data access layers in the service locator.
     */
    function setUp()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oMaxDalMaintenancePriority = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oMaxDalMaintenancePriority);
    }

    /**
     * A method to be called after every test to remove the
     * mocked data access layers from the service locator.
     *
     */
    function tearDown()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->remove('OA_Dal_Maintenance_Priority');
    }

    /**
     * A method to test the OA_Maintenance_Priority_Ad() method.
     *
     * Requirements:
     * Test 1: Test with invalid input and ensure the _abort() method is called.
     * Test 2: Test, and ensure parameters are correctly set.
     */
    function testOA_Maintenance_Priority_Ad()
    {
        // Test 1
        $aParams = 'foo';
        $oMaxEntityAd = new MockPartialOA_Maintenance_Priority_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->OA_Maintenance_Priority_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array();
        $oMaxEntityAd = new MockPartialOA_Maintenance_Priority_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->OA_Maintenance_Priority_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'status' => OA_ENTITY_STATUS_RUNNING
        );
        $oMaxEntityAd = new MockPartialOA_Maintenance_Priority_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->OA_Maintenance_Priority_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'status' => OA_ENTITY_STATUS_RUNNING,
            'type'   => 'sql',
            'weight' => 1
        );
        $oMaxEntityAd = new MockPartialOA_Maintenance_Priority_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->OA_Maintenance_Priority_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'ad_id'  => 'foo',
            'status' => OA_ENTITY_STATUS_RUNNING,
            'type'   => 'sql',
            'weight' => 1
        );
        $oMaxEntityAd = new MockPartialOA_Maintenance_Priority_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->OA_Maintenance_Priority_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'ad_id'  => 1,
            'type'   => 'sql',
            'weight' => 1
        );
        $oMaxEntityAd = new MockPartialOA_Maintenance_Priority_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->OA_Maintenance_Priority_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'ad_id'  => 1,
            'status' => OA_ENTITY_STATUS_RUNNING,
            'weight' => 1
        );
        $oMaxEntityAd = new MockPartialOA_Maintenance_Priority_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->OA_Maintenance_Priority_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'ad_id'  => 1,
            'status' => OA_ENTITY_STATUS_AWAITING,
            'type'   => 'sql'
        );
        $oMaxEntityAd = new MockPartialOA_Maintenance_Priority_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->OA_Maintenance_Priority_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'ad_id'  => 1,
            'status' => OA_ENTITY_STATUS_AWAITING,
            'type'   => 'sql',
            'weight' => 'foo'
        );
        $oMaxEntityAd = new MockPartialOA_Maintenance_Priority_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->OA_Maintenance_Priority_Ad($aParams);
        $oMaxEntityAd->tally();

        // Test 2
        $aParams = array(
            'ad_id'  => 1
        );
        $oMaxEntityAd = new OA_Maintenance_Priority_Ad($aParams);
        $this->assertEqual($oMaxEntityAd->id, 1);
        $this->assertNull($oMaxEntityAd->active);
        $this->assertNull($oMaxEntityAd->type);
        $this->assertNull($oMaxEntityAd->weight);

        $aParams = array(
            'ad_id'  => 1,
            'status' => OA_ENTITY_STATUS_RUNNING,
            'type'   => 'sql',
            'weight' => 2
        );
        $oMaxEntityAd = new OA_Maintenance_Priority_Ad($aParams);
        $this->assertEqual($oMaxEntityAd->id, 1);
        $this->assertTrue($oMaxEntityAd->active);
        $this->assertEqual($oMaxEntityAd->type, 'sql');
        $this->assertEqual($oMaxEntityAd->weight, 2);
    }

    /**
     * A method to test the getDeliveryLimitations() method.
     */
    function testGetDeliveryLimitations()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oMaxDalMaintenancePriority = &$oServiceLocator->get('OA_Dal_Maintenance_Priority');
        $oMaxDalMaintenancePriority->expectArgumentsAt(0, 'getAllDeliveryLimitationsByTypeId', array(1, 'ad'));
        $oMaxDalMaintenancePriority->expectCallCount('getAllDeliveryLimitationsByTypeId', 1);

        $aParams = array(
            'ad_id'  => 1
        );
        $oMaxEntityAd = new OA_Maintenance_Priority_Ad($aParams);
        $oMaxEntityAd->getDeliveryLimitations();

        $oMaxDalMaintenancePriority->tally();
    }

}

?>