<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/Entity/Ad.php';

/**
 * A class for testing the MAX_Entity_Ad class.
 *
 * @package    MaxEntity
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @author     James Floyd <james@m3.net>
 */
class Maintenance_TestOfMAX_Entity_Ad extends UnitTestCase
{

    /**
     * The class constructor method.
     */
    function  Maintenance_TestOfMAX_Entity_Ad()
    {
        $this->UnitTestCase();
        Mock::generate('OA_Dal_Maintenance_Priority');
        Mock::generatePartial('MAX_Entity_Ad', 'MockPartialMAX_Entity_Ad', array('_abort'));
    }

    /**
     * A method to be called before every test to store default
     * mocked data access layers in the service locator.
     */
    function setUp()
    {
        $oServiceLocator = &ServiceLocator::instance();
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
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->remove('OA_Dal_Maintenance_Priority');
    }

    /**
     * A method to test the MAX_Entity_Ad() method.
     *
     * Requirements:
     * Test 1: Test with invalid input and ensure the _abort() method is called.
     * Test 2: Test, and ensure parameters are correctly set.
     */
    function testMAX_Entity_Ad()
    {
        // Test 1
        $aParams = 'foo';
        $oMaxEntityAd = new MockPartialMAX_Entity_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->MAX_Entity_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array();
        $oMaxEntityAd = new MockPartialMAX_Entity_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->MAX_Entity_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'active' => 't'
        );
        $oMaxEntityAd = new MockPartialMAX_Entity_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->MAX_Entity_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'active' => 't',
            'type'   => 'sql',
            'weight' => 1
        );
        $oMaxEntityAd = new MockPartialMAX_Entity_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->MAX_Entity_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'ad_id'  => 'foo',
            'active' => 't',
            'type'   => 'sql',
            'weight' => 1
        );
        $oMaxEntityAd = new MockPartialMAX_Entity_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->MAX_Entity_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'ad_id'  => 1,
            'type'   => 'sql',
            'weight' => 1
        );
        $oMaxEntityAd = new MockPartialMAX_Entity_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->MAX_Entity_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'ad_id'  => 1,
            'active' => 't',
            'weight' => 1
        );
        $oMaxEntityAd = new MockPartialMAX_Entity_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->MAX_Entity_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'ad_id'  => 1,
            'active' => 'bar',
            'type'   => 'sql'
        );
        $oMaxEntityAd = new MockPartialMAX_Entity_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->MAX_Entity_Ad($aParams);
        $oMaxEntityAd->tally();

        $aParams = array(
            'ad_id'  => 1,
            'active' => 'f',
            'type'   => 'sql',
            'weight' => 'foo'
        );
        $oMaxEntityAd = new MockPartialMAX_Entity_Ad($this);
        $oMaxEntityAd->expectCallCount('_abort', 1);
        $oMaxEntityAd->MAX_Entity_Ad($aParams);
        $oMaxEntityAd->tally();

        // Test 2
        $aParams = array(
            'ad_id'  => 1
        );
        $oMaxEntityAd = new MAX_Entity_Ad($aParams);
        $this->assertEqual($oMaxEntityAd->id, 1);
        $this->assertNull($oMaxEntityAd->active);
        $this->assertNull($oMaxEntityAd->type);
        $this->assertNull($oMaxEntityAd->weight);

        $aParams = array(
            'ad_id'  => 1,
            'active' => 't',
            'type'   => 'sql',
            'weight' => 2
        );
        $oMaxEntityAd = new MAX_Entity_Ad($aParams);
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
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalMaintenancePriority = &$oServiceLocator->get('OA_Dal_Maintenance_Priority');
        $oMaxDalMaintenancePriority->expectArgumentsAt(0, 'getAllDeliveryLimitationsByTypeId', array(1, 'ad'));
        $oMaxDalMaintenancePriority->expectCallCount('getAllDeliveryLimitationsByTypeId', 1);

        $aParams = array(
            'ad_id'  => 1
        );
        $oMaxEntityAd = new MAX_Entity_Ad($aParams);
        $oMaxEntityAd->getDeliveryLimitations();

        $oMaxDalMaintenancePriority->tally();
    }

}

?>
