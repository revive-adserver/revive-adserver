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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Distributed.php';
require_once 'Date.php';

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Common class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Distributed extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Distributed()
    {
        $this->UnitTestCase();
    }

    function test_setMaintenanceDistributedLastRunInfo()
    {
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $oDal = new OA_Dal_Maintenance_Distributed();
        $oDate = & new Date();
        $oDal->setMaintenanceDistributedLastRunInfo($oDate);

        $doLbLocal = OA_Dal::factoryDO('lb_local');
        $doLbLocal->whereAdd("last_run = '".$oDate->getTime()."'",'AND');
        $this->assertTrue($doLbLocal->find(true));
    }

    function test_getMaintenanceDistributedLastRunInfo()
    {
    }

    function test_processTables()
    {
    }

    function test__pruneTable()
    {
        $oDal = new OA_Dal_Maintenance_Distributed();
        $oDateNow = new Date();
        $oDateThen = new Date();
        $oDateThen->copy($oDateNow);
        $aConf = & $GLOBALS['_MAX']['CONF'];

        $aConf['lb']['compactStats'] = '';
        $result = $oDal->_pruneTable('data_raw_ad_impression', $oDateNow);
        $this->assertNull($result);

        $prefix = $oDal->getTablePrefix();
        for ($i=1;$i<4;$i++)
        {
            $oDateThen->subtractSeconds(99999);
            $date_time = $oDateThen->getDate(DATE_FORMAT_ISO_EXTENDED);
            $query = "
                  INSERT INTO
                    {$prefix}data_raw_ad_impression
                  (date_time, ad_id, creative_id, zone_id)
                  VALUES ('{$date_time}',{$i},{$i},{$i})";
            $oDal->oDbh->exec($query);
        }

        $aConf['lb']['compactStats'] = '1';
        $aConf['lb']['compactStatsGrace'] = '33600';

        $result = $oDal->_pruneTable('data_raw_ad_impression', $oDateNow);
        $this->assertEqual($result,3);

    }

    function test__getFirstRecordTimestamp()
    {
    }

    function test__getDataRawTableContent()
    {
    }

}

?>
