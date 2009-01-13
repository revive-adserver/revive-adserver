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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Dal_Maintenance_Priority_AdImpressions extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_AdImpressions()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the setRequiredAdImpressions method.
     */
    function testSaveRequiredAdImpressions()
    {
        $oDal = new OA_Dal_Maintenance_Priority();
        $oTable =& OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_required_impression');
        $GLOBALS['_OA']['DB_TABLES']['tmp_ad_required_impression'] = true;
        $aData = array(
            array(
                'ad_id'                => 23,
                'required_impressions' => 140,
            )
        );
        $result = $oDal->saveRequiredAdImpressions($aData);
        $oDbh =& OA_DB::singleton();
        $query = "SELECT * FROM ".$oDbh->quoteIdentifier('tmp_ad_required_impression',true);
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchAll();
        $this->assertTrue(is_array($aRow));
        $this->assertTrue(count($aRow) == 1);
        $aItem = $aRow[0];
        $this->assertTrue(array_key_exists('ad_id', $aItem));
        $this->assertTrue(array_key_exists('required_impressions', $aItem));
        $this->assertEqual($aItem['ad_id'], 23);
        $this->assertEqual($aItem['required_impressions'], 140);
        unset($GLOBALS['_OA']['DB_TABLES']['tmp_ad_required_impression']);
        TestEnv::dropTempTables();
    }

    /**
     * A method to test the getRequiredAdImpressions method.
     */
    function testGetRequiredAdImpressions()
    {
        $oDal = new OA_Dal_Maintenance_Priority();
        $oTable =& OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_required_impression');
        $GLOBALS['_OA']['DB_TABLES']['tmp_ad_required_impression'] = true;
        $aData = array(
            array(
                'ad_id'                => 23,
                'required_impressions' => 140,
            ),
            array(
                'ad_id'                => 29,
                'required_impressions' => 120,
            )
        );
        $result = $oDal->saveRequiredAdImpressions($aData);
        $aAdvertID = array(
            1,
            2,
            29
        );
        $aData = $oDal->getRequiredAdImpressions($aAdvertID);
        $this->assertEqual(count($aData), 1);
        $this->assertTrue(array_key_exists(29, $aData));
        $this->assertEqual($aData[29], 120);
        unset($GLOBALS['_OA']['DB_TABLES']['tmp_ad_required_impression']);
        TestEnv::dropTempTables();
    }


    /**
     * A method to test the saveAllocatedImpressions method.
     */
    function testSaveAllocatedImpressions()
    {
        $oDbh =& OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Priority();
        // Create the required temporary table for the tests
        $oTable =& OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_zone_impression');
        // Prepare the test data
        $aData = array(
            array(
                'ad_id'       => 56,
                'zone_id'     => 11,
                'required_impressions' => 9997,
                'requested_impressions' => 9000
            ),
            array(
                'ad_id'       => 56,
                'zone_id'     => 12,
                'required_impressions' => 24,
                'requested_impressions' => 24
            )
        );
        $result = $oDal->saveAllocatedImpressions($aData);
        $query = "SELECT * FROM ".$oDbh->quoteIdentifier('tmp_ad_zone_impression',true)." ORDER BY ad_id, zone_id";
        $rc = $oDbh->query($query);
        $result = $rc->fetchAll();
        $this->assertTrue(is_array($result));
        $this->assertTrue(count($result) == 2);
        $tmp = $result[0];
        $this->assertTrue(array_key_exists('ad_id', $tmp));
        $this->assertEqual($tmp['ad_id'], 56);
        $this->assertTrue(array_key_exists('zone_id', $tmp));
        $this->assertEqual($tmp['zone_id'], 11);
        $this->assertTrue(array_key_exists('required_impressions', $tmp));
        $this->assertEqual($tmp['required_impressions'], 9997);
        $this->assertTrue(array_key_exists('requested_impressions', $tmp));
        $this->assertEqual($tmp['requested_impressions'], 9000);
        $tmp = $result[1];
        $this->assertTrue(array_key_exists('ad_id', $tmp));
        $this->assertEqual($tmp['ad_id'], 56);
        $this->assertTrue(array_key_exists('zone_id', $tmp));
        $this->assertEqual($tmp['zone_id'], 12);
        $this->assertTrue(array_key_exists('required_impressions', $tmp));
        $this->assertEqual($tmp['required_impressions'], 24);
        $this->assertTrue(array_key_exists('requested_impressions', $tmp));
        $this->assertEqual($tmp['requested_impressions'], 24);
        TestEnv::dropTempTables();
    }
}

?>
