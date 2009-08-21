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

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ForecastZoneImpressions.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/OperationInterval.php';

/**
 * A class for testing the OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions()
    {
        $this->UnitTestCase();
        Mock::generate('OA_Dal_Maintenance_Priority');
    }

    /**
     * A method to register a mock of the OA_Dal_Maintenance_Priority
     * class in the service locator at the start of every test.
     */
    function setUp()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDalMaintenancePriority =& $oServiceLocator->get('OA_Dal_Maintenance_Priority');
        if (!is_a($oDalMaintenancePriority, 'MockOA_Dal_Maintenance_Priority')) {
            $oDalMaintenancePriority = new MockOA_Dal_Maintenance_Priority($this);
            $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDalMaintenancePriority);
        }
    }

    /**
     * A method to de-register the mock of the OA_Dal_Maintenance_Priority
     * class in the service locator at the end of every test.
     */
    function tearDown()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDalMaintenancePriority =& $oServiceLocator->remove('OA_Dal_Maintenance_Priority');
    }


    /**
     * A method to test the _getOperationIntervalRanges() method.
     */
    function test_getOperationIntervalRanges()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;
        $oServiceLocator =& OA_ServiceLocator::instance();
        $intervals = OX_OperationInterval::operationIntervalsPerWeek();

        // Test 1
        $oDate = new Date('2009-08-20 21:10:00');
        $oServiceLocator->register('now', $oDate);
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $result = $oTask->_getOperationIntervalRanges();
        $expected = array( 
            'intervalId' => 117,
            'dates' => array(
            	'start' => new Date('2009-08-20 21:00:00'),
            	'end'   => new Date('2009-08-20 21:59:59'),
            )
        );
        $this->assertEqual( $result, $expected );     
        unset($oTask);

        TestEnv::restoreConfig();
    }

}

