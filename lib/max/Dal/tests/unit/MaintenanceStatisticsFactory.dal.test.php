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
$Id: MaintenanceStatisticsFactory.dal.test.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Statistics/Factory.php';

/**
 * A class for testing the MAX_Dal_Maintenance_Statistics_Factory class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Dal_TestOfMaxDalMaintenanceStatisticsFactory extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Dal_TestOfMaxDalMaintenanceStatisticsFactory()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the creation of an AdServer module via the factory.
     */
    function testCreateAdServer()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['split'] = false;
        $oMDMSF = new MAX_Dal_Maintenance_Statistics_Factory();
        $classname = $oMDMSF->_deriveClassName('AdServer');
        $this->assertEqual($classname, 'MAX_Dal_Maintenance_Statistics_AdServer_mysql');
        TestEnv::restoreConfig();
    }

    /**
     * Test the creation of a split AdServer module via the factory.
     */
    function testCreateAdServerSplit()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['split'] = true;
        $oMDMSF = new MAX_Dal_Maintenance_Statistics_Factory();
        $classname = $oMDMSF->_deriveClassName('AdServer');
        $this->assertEqual($classname, 'MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit');
        TestEnv::restoreConfig();
    }

    /**
     * Test the creation of an Tracker module via the factory.
     */
    function testCreateTracker()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['split'] = false;
        $oMDMSF = new MAX_Dal_Maintenance_Statistics_Factory();
        $classname = $oMDMSF->_deriveClassName('Tracker');
        $this->assertEqual($classname, 'MAX_Dal_Maintenance_Statistics_Tracker_mysql');
        TestEnv::restoreConfig();
    }

    /**
     * Test the creation of a split Tracker module via the factory.
     */
    function testCreateTrackerSplit()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['split'] = true;
        $oMDMSF = new MAX_Dal_Maintenance_Statistics_Factory();
        $classname = $oMDMSF->_deriveClassName('Tracker');
        $this->assertEqual($classname, 'MAX_Dal_Maintenance_Statistics_Tracker_mysqlSplit');
        TestEnv::restoreConfig();
    }

}

?>
