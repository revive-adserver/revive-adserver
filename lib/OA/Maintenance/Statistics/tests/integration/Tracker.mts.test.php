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

require_once MAX_PATH . '/lib/Max.php';

require_once MAX_PATH . '/lib/OA/DB/Table/Core.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/Tracker.php';

require_once OX_PATH . '/lib/OX.php';
require_once OX_PATH . '/lib/pear/Date.php';

// pgsql execution time before refactor: s
// pgsql execution time after refactor: 3.9714s

/**
 * A class for performing integration testing the OA_Maintenance_Statistics_Tracker class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 *
 * @TODO Update to use a mocked DAL, instead of a real database.
 */
class Test_OA_Maintenance_Statistics_Tracker extends UnitTestCase
{
    var $oDbh;
    var $tblDRTI;
    var $tblDRTVV;

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Statistics_Tracker()
    {
        $this->UnitTestCase();
        $this->oDbh = &OA_DB::singleton();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $this->tblDRTI  = $this->oDbh->quoteIdentifier($conf['table']['prefix'].'data_raw_tracker_impression', true);
        $this->tblDRTVV = $this->oDbh->quoteIdentifier($conf['table']['prefix'].'data_raw_tracker_variable_value', true);
        $conf['maintenance']['operationInterval'] = 60;
        $conf['maintenance']['compactStats'] = false;
    }

    /**
     * The main test method.
     */
    function testClass()
    {
        // Use a reference to $GLOBALS['_MAX']['CONF'] so that the configuration
        // options can be changed while the test is running
        $oTable = &OA_DB_Table_Core::singleton();
        // Create the required tables
        $oTable->createTable('data_raw_tracker_impression');
        $oTable->createTable('data_raw_tracker_variable_value');
        $oTable->createTable('log_maintenance_statistics');
        $oTable->createTable('userlog');

        // Insert the test data
        $query = "
            INSERT INTO
                {$this->tblDRTI}
                (
                    server_raw_tracker_impression_id,
                    server_raw_ip,
                    viewer_id,
                    viewer_session_id,
                    date_time,
                    tracker_id,
                    channel,
                    language,
                    ip_address,
                    host_name,
                    country,
                    https,
                    domain,
                    page,
                    query,
                    referer,
                    search_term,
                    user_agent,
                    os,
                    browser,
                    max_https
                )
            VALUES
                (
                    1,
                    'singleDB',
                    '7030ec9e03911a66006cba951848e454',
                    '',
                    '2004-11-26 12:10:42',
                    1,
                    NULL,
                    'en-us,en',
                    '127.0.0.1',
                    '',
                    '',
                    0,
                    'localhost',
                    '/test.html',
                    '',
                    '',
                    '',
                    'Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1',
                    'Linux',
                    'Firefox',
                    0
                )";
        $rows = $this->oDbh->exec($query);

        $query = "
            INSERT INTO
                {$this->tblDRTVV}
            VALUES
            (
                1,
                'singleDB',
                1,
                '2004-11-26 12:10:42',
                42
            )";
        $rows = $this->oDbh->exec($query);

        // Set the "current" time
        $oDateNow = new Date('2004-11-28 12:00:00');
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('now', $oDateNow);
        // Create and run the class
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_Tracker();
        $oMaintenanceStatistics->updateStatistics();
        // Test the results
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$this->tblDRTI}";
        $rc = $this->oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$this->tblDRTVV}";
        $rc = $this->oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        // Reset the testing environment
        TestEnv::restoreEnv();
    }

}

?>
