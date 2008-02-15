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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Factory.php';

// pgsql execution time before refactor: 110.23s
// pgsql execution time after refactor: s

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_* classes.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Statistics_AdServer_DeleteOldData extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_AdServer_DeleteOldData()
    {
        $this->UnitTestCase();
    }

    /**
     * Tests the deleteOldData() method.
     */
    function testDeleteOldData()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        $aConf['maintenance']['compactStatsGrace'] = 0;
        // Insert the test data
        $this->_insertTestDeleteOldDataCampaignsTrackers();
        $this->_insertTestDeleteOldDataAdItems($aConf['table']['prefix'] . $aConf['table']['data_raw_ad_request']);
        $this->_insertTestDeleteOldDataAdItems($aConf['table']['prefix'] . $aConf['table']['data_raw_ad_impression']);
        $this->_insertTestDeleteOldDataAdItems($aConf['table']['prefix'] . $aConf['table']['data_raw_ad_click']);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_click'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_request'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        TestEnv::restoreEnv();

        $aConf['maintenance']['compactStatsGrace'] = 0;
        $dsa = $oMDMSF->factory("AdServer");
        // Insert the test data
        $this->_insertTestDeleteOldDataAdItems($aConf['table']['prefix'] . $aConf['table']['data_raw_ad_request']);
        $this->_insertTestDeleteOldDataAdItems($aConf['table']['prefix'] . $aConf['table']['data_raw_ad_impression']);
        $this->_insertTestDeleteOldDataAdItems($aConf['table']['prefix'] . $aConf['table']['data_raw_ad_click']);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_click'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_request'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        TestEnv::restoreEnv();

        $aConf['maintenance']['compactStatsGrace'] = 3600;
        $dsa = $oMDMSF->factory("AdServer");
        // Insert the test data
        $this->_insertTestDeleteOldDataCampaignsTrackers();
        $this->_insertTestDeleteOldDataAdItems($aConf['table']['prefix'] . $aConf['table']['data_raw_ad_request']);
        $this->_insertTestDeleteOldDataAdItems($aConf['table']['prefix'] . $aConf['table']['data_raw_ad_impression']);
        $this->_insertTestDeleteOldDataAdItems($aConf['table']['prefix'] . $aConf['table']['data_raw_ad_click']);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_click'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 5);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 5);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_request'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        TestEnv::restoreEnv();

        // Disable the tracker
        $aConf['maintenance']['compactStatsGrace'] = 3600;
        $dsa = $oMDMSF->factory("AdServer");
        // Insert the test data
        $this->_insertTestDeleteOldDataAdItems($aConf['table']['prefix'] . $aConf['table']['data_raw_ad_request']);
        $this->_insertTestDeleteOldDataAdItems($aConf['table']['prefix'] . $aConf['table']['data_raw_ad_impression']);
        $this->_insertTestDeleteOldDataAdItems($aConf['table']['prefix'] . $aConf['table']['data_raw_ad_click']);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_click'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_request'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        TestEnv::restoreEnv();
    }

    /**
     * A private method to insert campaign trackers links as test data for the
     * deleteOldData() test.
     *
     * @access private
     */
    function _insertTestDeleteOldDataCampaignsTrackers()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =&  OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns_trackers'],true)."
                (
                    viewwindow,
                    clickwindow
                )
            VALUES
                (?, ?)";


        $aTypes = array(
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            0, 60
        );
        $rows = $st->execute($aData);
        $aData = array(
            0, 3600
        );
        $rows = $st->execute($aData);
    }

    /**
     * A private method to insert ad requests/impressions/clicks as test
     * data for the deleteOldData() test.
     *
     * @access private
     */
    function _insertTestDeleteOldDataAdItems($table)
    {
        $oDbh =&  OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($table,true)."
                (
                    ad_id,
                    creative_id,
                    zone_id,
                    date_time
                )
            VALUES
                (?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            0,
            0,
            0,
            '2004-06-06 18:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            0,
            0,
            0,
            '2004-06-06 17:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            0,
            0,
            0,
            '2004-06-06 17:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            0,
            0,
            0,
            '2004-06-06 16:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            0,
            0,
            0,
            '2004-06-06 16:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            0,
            0,
            0,
            '2004-06-06 15:59:59'
        );
        $rows = $st->execute($aData);
    }
}

?>
