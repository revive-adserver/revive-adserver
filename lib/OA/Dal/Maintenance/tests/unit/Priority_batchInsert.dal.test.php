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

class Test_OA_Dal_Maintenance_Priority_batchInsert extends UnitTestCase
{
    function __construct()
    {
        $this->UnitTestCase();
    }

    function test_batchInsert()
    {
        $oDal = new OA_Dal_Maintenance_Priority();
        $oTable =& OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_required_impression');
        
        $this->assertEqual(array(), $this->_getRecords());
        $aData = array(
            array(
                'ad_id' => '23',
                'required_impressions' => '140',
            ),
            array(
                'ad_id' => '29',
                'required_impressions' => '120',
            )
        );
        $oDal->batchInsert('tmp_ad_required_impression', $aData, array('ad_id', 'required_impressions'));

        $result = $this->_getRecords();
        $this->assertTrue(count($result) == 2);
        $this->assertEqual($result, $aData);
        
//        var_dump($result);
//        var_dump($aData);
        $oneMoreRow = array ( 
            array(100,2)
        );
        $oDal->batchInsert('tmp_ad_required_impression', $oneMoreRow, array('ad_id', 'required_impressions'));
        $result = $this->_getRecords();
        $this->assertTrue(count($result) == 3);
        $this->assertEqual($result, array_merge($aData, array ( 
            array(
                'ad_id' => 100,
                'required_impressions' => 2
            ))));
        TestEnv::dropTempTables();
    }

    function _getRecords()
    {
        $oDbh =& OA_DB::singleton();
        $query = "SELECT * 
        		FROM ".$oDbh->quoteIdentifier('tmp_ad_required_impression',true)." 
        		ORDER BY ad_id ASC";
        $rc = $oDbh->query($query);
        $result = $rc->fetchAll();
        return $result;
    }
}

