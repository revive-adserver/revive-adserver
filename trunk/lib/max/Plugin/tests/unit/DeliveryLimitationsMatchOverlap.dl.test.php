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

require_once MAX_PATH . '/lib/max/Dal/Entities.php';
require_once MAX_PATH . '/lib/max/Plugin/DeliveryLimitations/MatchOverlap.php';

require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/plugins/deliveryLimitations/Time/Hour.plugin.php';

/**
 * A class for testing the MAX_Plugin_DeliveryLimitations_MatchOverlap class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMAX_Plugin_DeliveryLimitations_MatchOverlap extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMAX_Plugin_DeliveryLimitations_MatchOverlap()
    {
        $this->UnitTestCase();
        Mock::generate('MAX_Dal_Entities');
        Mock::generatePartial(
            'MAX_Plugin_DeliveryLimitations_MatchOverlap',
            'MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap',
            array('_getDal')
        );
        Mock::generatePartial(
            'MAX_Plugin_DeliveryLimitations_MatchOverlap',
            'MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_Overlap',
            array('_getDal', '_overlapAndGroup')
        );
        Mock::generatePartial(
            'MAX_Plugin_DeliveryLimitations_MatchOverlap',
            'MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_OverlapAndGroup',
            array('_getDal', '_getPlugin')
        );
        Mock::generate('Plugins_DeliveryLimitations_Time_Hour');
    }

    /**
     * A method to test the setLimitationsByAdId() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure false is returned, and the
     *         object's limitation array is set correctly.
     * Test 2: Test with basic input, and ensure true is returned, and the
     *         object's limitation array is set correctly.
     *
     * More complex testing is not done, as this is handled but the
     * testSetLimitationsByArray() method.
     */
    function testSetLimitationsByAdId()
    {
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap($this);

        // Test 1
        $adId = 'foo';
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdId($adId);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        // Test 2
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getDeliveryLimitationsByAdId',
            array(
                0 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 12
                )
            )
        );
        $oMaxDalEntities->expectArgumentsAt(0, 'getDeliveryLimitationsByAdId', array(1));
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByAdId', 1);

        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oMaxPluginDeliveryLimitationsMatchOverlap = new MAX_Plugin_DeliveryLimitations_MatchOverlap();

        $adId = 1;
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdId($adId);
        $aExpectedArray = array(
            0 => array(
                0 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 12
                )
            )
        );
        $this->assertTrue($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        $oMaxDalEntities->tally();
    }

    /**
     * A method to test the setLimitationsByAdArray() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure false is returned, and the
     *         object's limitation array is set correctly.
     * Test 2: Test with simple valid input, and ensure true is returned, and the
     *         object's limitation array is set correctly.
     * Test 3: Test with complex valid input, and ensure true is returned, and
     *         the object's limitation array is set correctly.
     */
    function testSetLimitationsByAdArray()
    {
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap($this);

        // Test 1
        $aLimitations = 'foo';
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        $aLimitations = array();
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => 'foo'
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array()
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array('foo')
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array(
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 12
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array(
                'logical'    => 'and',
                'comparison' => '=~',
                'data'       => 12
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array(
                'logical'    => 'and',
                'type'       => 'Time:Hour',
                'data'       => 12
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array(
                'logical'    => 'and',
                'type'       => 'Time:Hour',
                'comparison' => '=~'
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        $aLimitations = array(
            'foo' => array(
                'logical'    => 'and',
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 12
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        // Test 2
        $aLimitations = array(
            1 => array(
                'logical'    => 'and',
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 12
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array(
            0 => array(
                1 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 12
                )
            )
        );
        $this->assertTrue($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 12,
                'executionorder' => 1
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array(
            0 => array(
                1 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 12
                )
            )
        );
        $this->assertTrue($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        // Test 3
        $aLimitations = array(
            0 => array(
                'logical'    => 'and',
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 12
            ),
            1 => array(
                'logical'    => 'or',
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 13
            ),
            2 => array(
                'logical'    => 'or',
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 14
            ),
            3 => array(
                'logical'    => 'and',
                'type'       => 'Time:Date',
                'comparison' => '=~',
                'data'       => '2006-10-12'
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array(
            0 => array(
                0 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 12
                )
            ),
            1 => array(
                0 => array(
                    'logical'    => 'or',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 13
                )
            ),
            2 => array(
                0 => array(
                    'logical'    => 'or',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 14
                ),
                1 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Date',
                    'comparison' => '=~',
                    'data'       => '2006-10-12'
                )
            )
        );
        $this->assertTrue($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);

        $aLimitations = array(
            3 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 12,
                'executionorder' => 0
            ),
            2 => array(
                'logical'        => 'or',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 13,
                'executionorder' => 1
            ),
            1 => array(
                'logical'        => 'or',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 14,
                'executionorder' => 2
            ),
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Date',
                'comparison'     => '=~',
                'data'           => '2006-10-12',
                'executionorder' => 3
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aExpectedArray = array(
            0 => array(
                0 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 12
                )
            ),
            1 => array(
                0 => array(
                    'logical'    => 'or',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 13
                )
            ),
            2 => array(
                0 => array(
                    'logical'    => 'or',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 14
                ),
                1 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Date',
                    'comparison' => '=~',
                    'data'       => '2006-10-12'
                )
            )
        );
        $this->assertTrue($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aLimitations, $aExpectedArray);
    }

    /**
     * A method to test the setLimitationsByChannelId() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure false is returned, and the
     *         object's limitation array is set correctly.
     */
    function testSetLimitationsByChannelId()
    {
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap($this);

        // Test 1
        $adId = 'foo';
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelId($adId);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertNull($oMaxPluginDeliveryLimitationsMatchOverlap->channelId);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        // Test 2
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getDeliveryLimitationsByChannelId',
            array(
                0 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 12
                )
            )
        );
        $oMaxDalEntities->expectArgumentsAt(0, 'getDeliveryLimitationsByChannelId', array(1));
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 1);

        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oMaxPluginDeliveryLimitationsMatchOverlap = new MAX_Plugin_DeliveryLimitations_MatchOverlap();

        $adId = 1;
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelId($adId);
        $aExpectedArray = array(
            0 => array(
                0 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 12
                )
            )
        );
        $this->assertTrue($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        $oMaxDalEntities->tally();
    }

    /**
     * A method to test the setLimitationsByChannelArray() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure false is returned, and the
     *         object's limitation array is set correctly.
     * Test 2: Test with simple valid input, and ensure true is returned, and the
     *         object's limitation array is set correctly.
     * Test 3: Test with complex valid input, and ensure true is returned, and
     *         the object's limitation array is set correctly.
     */
    function testSetLimitationsByChannelArray()
    {
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap($this);

        // Test 1
        $aLimitations = 'foo';
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertNull($oMaxPluginDeliveryLimitationsMatchOverlap->channelId);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        $aLimitations = array();
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertNull($oMaxPluginDeliveryLimitationsMatchOverlap->channelId);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => 'foo'
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertNull($oMaxPluginDeliveryLimitationsMatchOverlap->channelId);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array()
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertNull($oMaxPluginDeliveryLimitationsMatchOverlap->channelId);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array('foo')
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertNull($oMaxPluginDeliveryLimitationsMatchOverlap->channelId);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array(
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 12
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertNull($oMaxPluginDeliveryLimitationsMatchOverlap->channelId);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array(
                'logical'    => 'and',
                'comparison' => '=~',
                'data'       => 12
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertNull($oMaxPluginDeliveryLimitationsMatchOverlap->channelId);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array(
                'logical'    => 'and',
                'type'       => 'Time:Hour',
                'data'       => 12
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertNull($oMaxPluginDeliveryLimitationsMatchOverlap->channelId);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array(
                'logical'    => 'and',
                'type'       => 'Time:Hour',
                'comparison' => '=~'
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertNull($oMaxPluginDeliveryLimitationsMatchOverlap->channelId);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        $aLimitations = array(
            'foo' => array(
                'logical'    => 'and',
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 12
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array();
        $this->assertFalse($result);
        $this->assertNull($oMaxPluginDeliveryLimitationsMatchOverlap->channelId);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        // Test 2
        $aLimitations = array(
            1 => array(
                'logical'    => 'and',
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 12
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array(
            0 => array(
                1 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 12
                )
            )
        );
        $this->assertTrue($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->channelId, 1);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 12,
                'executionorder' => 1
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array(
            0 => array(
                1 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 12
                )
            )
        );
        $this->assertTrue($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->channelId, 1);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        // Test 3
        $aLimitations = array(
            0 => array(
                'logical'    => 'and',
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 12
            ),
            1 => array(
                'logical'    => 'or',
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 13
            ),
            2 => array(
                'logical'    => 'or',
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 14
            ),
            3 => array(
                'logical'    => 'and',
                'type'       => 'Time:Date',
                'comparison' => '=~',
                'data'       => '2006-10-12'
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array(
            0 => array(
                0 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 12
                )
            ),
            1 => array(
                0 => array(
                    'logical'    => 'or',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 13
                )
            ),
            2 => array(
                0 => array(
                    'logical'    => 'or',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 14
                ),
                1 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Date',
                    'comparison' => '=~',
                    'data'       => '2006-10-12'
                )
            )
        );
        $this->assertTrue($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->channelId, 1);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);

        $aLimitations = array(
            3 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 12,
                'executionorder' => 0
            ),
            2 => array(
                'logical'        => 'or',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 13,
                'executionorder' => 1
            ),
            1 => array(
                'logical'        => 'or',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 14,
                'executionorder' => 2
            ),
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Date',
                'comparison'     => '=~',
                'data'           => '2006-10-12',
                'executionorder' => 3
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aLimitations);
        $aExpectedArray = array(
            0 => array(
                0 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 12
                )
            ),
            1 => array(
                0 => array(
                    'logical'    => 'or',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 13
                )
            ),
            2 => array(
                0 => array(
                    'logical'    => 'or',
                    'type'       => 'Time:Hour',
                    'comparison' => '=~',
                    'data'       => 14
                ),
                1 => array(
                    'logical'    => 'and',
                    'type'       => 'Time:Date',
                    'comparison' => '=~',
                    'data'       => '2006-10-12'
                )
            )
        );
        $this->assertTrue($result);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->channelId, 1);
        $this->assertEqual($oMaxPluginDeliveryLimitationsMatchOverlap->aChannelLimitations, $aExpectedArray);
    }

    /**
     * A method to test the match() method.
     *
     * Requirements:
     * Test 1: Test with a non-set set of ad delivery limitations, and ensure false
     *         is returned.
     * Test 2: Test with a non-set set of channel delivery limitations, and ensure
     *         false is returned.
     * Test 3: Test with set sets of delivery limitations that do NOT match, and
     *         ensure true is returned.
     * Test 4: Test with set sets of delivery limitations that DO match, and ensure
     *         true is returned.
     */
    function testMatch()
    {
        // Test 1
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap($this);
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 12
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aChannelLimitations);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->match();
        $this->assertFalse($result);

        // Test 2
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 12
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->match();
        $this->assertFalse($result);

        // Test 3
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Site:Channel',
                'comparison'     => '!~',
                'data'           => 1
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 13
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aChannelLimitations);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->match();
        $this->assertFalse($result);

        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 12
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 13
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aChannelLimitations);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->match();
        $this->assertFalse($result);

        // Test 4
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Site:Channel',
                'comparison'     => '=~',
                'data'           => 1
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 13
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aChannelLimitations);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->match();
        $this->assertTrue($result);

        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 12
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 12
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aChannelLimitations);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->match();
        $this->assertTrue($result);
    }

    /**
     * A method to test the overlap() method.
     *
     * Requirements:
     * Test 1: Test with a non-set set of ad delivery limitations, and ensure false
     *         is returned.
     * Test 2: Test with a non-set set of channel delivery limitations, and ensure false
     *         is returned.
     * Test 3: Test a simple, single ad delivery limitation vs simple, single channel
     *         delivery limitation that does not overlap.
     * Test 4: Test a simple, single ad delivery limitation vs simple, single channel
     *         delivery limitation that does overlap. (Contrived example, that would
     *         also match!)
     * Test 5: Test a simple, multi ad delivery limitation vs simple, single channel
     *         delivery limitation that does overlap.
     * Test 6: Test a simple, multi ad delivery limitation vs simple, multi channel
     *         delivery limitation that does overlap.
     * Test 7: Test a complex, multi ad delivery limitation vs complex, multi channel
     *         delivery limitation that does not overlap.
     * Test 8: Test a complex, multi ad delivery limitation vs complex, multi channel
     *         delivery limitation that does overlap.
     */
    function testOverlap()
    {
        // Test 1
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_Overlap($this);
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 12
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aChannelLimitations);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->overlap();
        $this->assertFalse($result);

        // Test 2
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_Overlap($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 12
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->overlap();
        $this->assertFalse($result);

        // Test 3
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_Overlap($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 14
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 13
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aChannelLimitations);
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(0, '_overlapAndGroup', false);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(0, '_overlapAndGroup', array($aLimitations, $aChannelLimitations));
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectCallCount('_overlapAndGroup', 1);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->overlap();
        $this->assertFalse($result);
        $oMaxPluginDeliveryLimitationsMatchOverlap->tally();

        // Test 4
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_Overlap($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 13
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 13
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aChannelLimitations);
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(0, '_overlapAndGroup', true);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(0, '_overlapAndGroup', array($aLimitations, $aChannelLimitations));
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectCallCount('_overlapAndGroup', 1);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->overlap();
        $this->assertTrue($result);
        $oMaxPluginDeliveryLimitationsMatchOverlap->tally();

        // Test 5
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_Overlap($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 12
            ),
            1 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 13
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 13
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aChannelLimitations);
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(0, '_overlapAndGroup', true);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(0, '_overlapAndGroup', array($aLimitations, $aChannelLimitations));
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectCallCount('_overlapAndGroup', 1);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->overlap();
        $this->assertTrue($result);
        $oMaxPluginDeliveryLimitationsMatchOverlap->tally();

        // Test 6
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_Overlap($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 12
            ),
            1 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 13
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 13
            ),
            1 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 14
            )
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aChannelLimitations);
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(0, '_overlapAndGroup', true);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(0, '_overlapAndGroup', array($aLimitations, $aChannelLimitations));
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectCallCount('_overlapAndGroup', 1);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->overlap();
        $this->assertTrue($result);
        $oMaxPluginDeliveryLimitationsMatchOverlap->tally();

        // Test 7
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_Overlap($this);
        $aLimitation0 = array(
            'logical'        => 'and',
            'type'           => 'Time:Hour',
            'comparison'     => '!~',
            'data'           => 12
        );
        $aLimitation1 = array(
            'logical'        => 'or',
            'type'           => 'Time:Hour',
            'comparison'     => '!~',
            'data'           => 13
        );
        $aLimitations = array(
            0 => $aLimitation0,
            1 => $aLimitation1
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aChannelLimitation0 = array(
            'logical'        => 'and',
            'type'           => 'Time:Hour',
            'comparison'     => '=~',
            'data'           => 14
        );
        $aChannelLimitation1 = array(
            'logical'        => 'or',
            'type'           => 'Time:Hour',
            'comparison'     => '=~',
            'data'           => 15
        );
        $aChannelLimitations = array(
            0 => $aChannelLimitation0,
            1 => $aChannelLimitation1
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aChannelLimitations);
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(0, '_overlapAndGroup', false);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(0, '_overlapAndGroup', array(array(0 => $aLimitation0), array(0 => $aChannelLimitation0)));
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(1, '_overlapAndGroup', false);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(1, '_overlapAndGroup', array(array(0 => $aLimitation0), array(0 => $aChannelLimitation1)));
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(2, '_overlapAndGroup', false);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(2, '_overlapAndGroup', array(array(0 => $aLimitation1), array(0 => $aChannelLimitation0)));
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(3, '_overlapAndGroup', false);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(3, '_overlapAndGroup', array(array(0 => $aLimitation1), array(0 => $aChannelLimitation1)));
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectCallCount('_overlapAndGroup', 4);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->overlap();
        $this->assertFalse($result);
        $oMaxPluginDeliveryLimitationsMatchOverlap->tally();

        // Test 8
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_Overlap($this);
        $aLimitation0 = array(
            'logical'        => 'and',
            'type'           => 'Time:Hour',
            'comparison'     => '!~',
            'data'           => 12
        );
        $aLimitation1 = array(
            'logical'        => 'or',
            'type'           => 'Time:Hour',
            'comparison'     => '!~',
            'data'           => 13
        );
        $aLimitations = array(
            0 => $aLimitation0,
            1 => $aLimitation1
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray($aLimitations);
        $aChannelLimitation0 = array(
            'logical'        => 'and',
            'type'           => 'Time:Hour',
            'comparison'     => '=~',
            'data'           => 13
        );
        $aChannelLimitation1 = array(
            'logical'        => 'or',
            'type'           => 'Time:Hour',
            'comparison'     => '=~',
            'data'           => 15
        );
        $aChannelLimitations = array(
            0 => $aChannelLimitation0,
            1 => $aChannelLimitation1
        );
        $oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray(1, $aChannelLimitations);
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(0, '_overlapAndGroup', false);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(0, '_overlapAndGroup', array(array(0 => $aLimitation0), array(0 => $aChannelLimitation0)));
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(1, '_overlapAndGroup', true);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(1, '_overlapAndGroup', array(array(0 => $aLimitation0), array(0 => $aChannelLimitation1)));
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectCallCount('_overlapAndGroup', 2);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->overlap();
        $this->assertTrue($result);
        $oMaxPluginDeliveryLimitationsMatchOverlap->tally();
    }

    /**
     * A method to test the _overlapAndGroup() method.
     *
     * Requirements:
     * Test 1: Test with non-matching types, and ensure true returned.
     * Test 2: Test with matching types, where there is no overlap, and
     *         ensure false returned.
     * Test 3: Test with matching types, where there is overlap, and
     *         ensure true returned.
     * Test 4: Test with complex matching types, where there is no
     *         overlap, and ensure false returned.
     * Test 5: Test with complex matching types, where there is
     *         overlap, and ensure true returned.
     */
    function test_overlapAndGroup()
    {
        // Test 1
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_OverlapAndGroup($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 14
            )
        );
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Day',
                'comparison'     => '=~',
                'data'           => 3
            )
        );
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->_overlapAndGroup($aLimitations, $aChannelLimitations);
        $this->assertTrue($result);

        // Test 2
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_OverlapAndGroup($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 14
            )
        );
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 15
            )
        );
        $oDeliveryLimitationPlugin1 = new MockPlugins_DeliveryLimitations_Time_Hour($this);
        $oDeliveryLimitationPlugin1->setReturnValueAt(0, 'overlap', false);
        $oDeliveryLimitationPlugin1->expectArgumentsAt(0, 'overlap', array($aLimitations[0], $aChannelLimitations[0]));
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(0, '_getPlugin', $oDeliveryLimitationPlugin1);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(0, '_getPlugin', array('Time:Hour'));
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectCallCount('_getPlugin', 1);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->_overlapAndGroup($aLimitations, $aChannelLimitations);
        $this->assertFalse($result);
        $oMaxPluginDeliveryLimitationsMatchOverlap->tally();

        // Test 3
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_OverlapAndGroup($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 14
            )
        );
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 14
            )
        );
        $oDeliveryLimitationPlugin1 = new MockPlugins_DeliveryLimitations_Time_Hour($this);
        $oDeliveryLimitationPlugin1->setReturnValueAt(0, 'overlap', true);
        $oDeliveryLimitationPlugin1->expectArgumentsAt(0, 'overlap', array($aLimitations[0], $aChannelLimitations[0]));
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(0, '_getPlugin', $oDeliveryLimitationPlugin1);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(0, '_getPlugin', array('Time:Hour'));
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectCallCount('_getPlugin', 1);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->_overlapAndGroup($aLimitations, $aChannelLimitations);
        $this->assertTrue($result);
        $oMaxPluginDeliveryLimitationsMatchOverlap->tally();

        // Test 4
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_OverlapAndGroup($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 14
            ),
            1 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 15
            )
        );
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 16
            ),
            1 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 17
            )
        );
        $oDeliveryLimitationPlugin1 = new MockPlugins_DeliveryLimitations_Time_Hour($this);
        $oDeliveryLimitationPlugin1->setReturnValueAt(0, 'overlap', false);
        $oDeliveryLimitationPlugin1->expectArgumentsAt(0, 'overlap', array($aLimitations[0], $aChannelLimitations[0]));
        $oDeliveryLimitationPlugin2 = new MockPlugins_DeliveryLimitations_Time_Hour($this);
        $oDeliveryLimitationPlugin2->setReturnValueAt(0, 'overlap', false);
        $oDeliveryLimitationPlugin2->expectArgumentsAt(0, 'overlap', array($aLimitations[0], $aChannelLimitations[1]));
        $oDeliveryLimitationPlugin3 = new MockPlugins_DeliveryLimitations_Time_Hour($this);
        $oDeliveryLimitationPlugin3->setReturnValueAt(0, 'overlap', false);
        $oDeliveryLimitationPlugin3->expectArgumentsAt(0, 'overlap', array($aLimitations[1], $aChannelLimitations[0]));
        $oDeliveryLimitationPlugin4 = new MockPlugins_DeliveryLimitations_Time_Hour($this);
        $oDeliveryLimitationPlugin4->setReturnValueAt(0, 'overlap', false);
        $oDeliveryLimitationPlugin4->expectArgumentsAt(0, 'overlap', array($aLimitations[1], $aChannelLimitations[1]));
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(0, '_getPlugin', $oDeliveryLimitationPlugin1);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(0, '_getPlugin', array('Time:Hour'));
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(1, '_getPlugin', $oDeliveryLimitationPlugin2);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(1, '_getPlugin', array('Time:Hour'));
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(2, '_getPlugin', $oDeliveryLimitationPlugin3);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(2, '_getPlugin', array('Time:Hour'));
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(3, '_getPlugin', $oDeliveryLimitationPlugin4);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(3, '_getPlugin', array('Time:Hour'));
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectCallCount('_getPlugin', 4);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->_overlapAndGroup($aLimitations, $aChannelLimitations);
        $this->assertFalse($result);
        $oMaxPluginDeliveryLimitationsMatchOverlap->tally();

        // Test 5
        $oMaxPluginDeliveryLimitationsMatchOverlap = new MockPartialMAX_Plugin_DeliveryLimitations_MatchOverlap_OverlapAndGroup($this);
        $aLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 14
            ),
            1 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 15
            )
        );
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 13
            ),
            1 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '=~',
                'data'           => 14
            )
        );
        $oDeliveryLimitationPlugin1 = new MockPlugins_DeliveryLimitations_Time_Hour($this);
        $oDeliveryLimitationPlugin1->setReturnValueAt(0, 'overlap', false);
        $oDeliveryLimitationPlugin1->expectArgumentsAt(0, 'overlap', array($aLimitations[0], $aChannelLimitations[0]));
        $oDeliveryLimitationPlugin2 = new MockPlugins_DeliveryLimitations_Time_Hour($this);
        $oDeliveryLimitationPlugin2->setReturnValueAt(0, 'overlap', true);
        $oDeliveryLimitationPlugin2->expectArgumentsAt(0, 'overlap', array($aLimitations[0], $aChannelLimitations[1]));
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(0, '_getPlugin', $oDeliveryLimitationPlugin1);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(0, '_getPlugin', array('Time:Hour'));
        $oMaxPluginDeliveryLimitationsMatchOverlap->setReturnValueAt(1, '_getPlugin', $oDeliveryLimitationPlugin2);
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectArgumentsAt(1, '_getPlugin', array('Time:Hour'));
        $oMaxPluginDeliveryLimitationsMatchOverlap->expectCallCount('_getPlugin', 2);
        $result = $oMaxPluginDeliveryLimitationsMatchOverlap->_overlapAndGroup($aLimitations, $aChannelLimitations);
        $this->assertTrue($result);
        $oMaxPluginDeliveryLimitationsMatchOverlap->tally();
    }

}

?>
