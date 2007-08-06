<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/Tracker.php';

require_once MAX_PATH . '/lib/OA/DB/Table/Core.php';
require_once 'Date.php';

/**
 * A class for performing integration testing the MAX_Maintenance_Statistics_Tracker class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @TODO Update to use a mocked DAL, instead of a real database.
 */
class Maintenance_TestOfMaintenanceStatisticsTracker extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMaintenanceStatisticsTracker()
    {
        $this->UnitTestCase();
    }

    /**
     * The main test method.
     */
    function testClass()
    {
        // Use a reference to $GLOBALS['_MAX']['CONF'] so that the configuration
        // options can be changed while the test is running
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = 'max_';
        $oDbh = &OA_DB::singleton();
        $oTable = &OA_DB_Table_Core::singleton();
        // Create the required tables
        $oTable->createTable('data_raw_tracker_click');
        $oTable->createTable('data_raw_tracker_impression');
        $oTable->createTable('data_raw_tracker_variable_value');
        $oTable->createTable('log_maintenance_statistics');
        $oTable->createTable('userlog');
        // Insert the test data
        $query = "
            INSERT INTO
                max_data_raw_tracker_impression
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
        $rows = $oDbh->exec($query);

        $query = "
            INSERT INTO
                max_data_raw_tracker_variable_value
            VALUES
            (
                1,
                'singleDB',
                1,
                '2004-11-26 12:10:42',
                42
            )";
        $rows = $oDbh->exec($query);

        $query = "
            INSERT INTO
                max_data_raw_tracker_click
                (
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
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'integer',
            'timestamp',
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',2,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',6,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',4,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',3,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:51',5,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',6,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',1,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',3,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',1,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',3,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',5,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',3,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',1,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',6,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',5,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',3,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',1,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',6,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',5,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',3,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',1,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',6,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',2,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',6,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',4,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',3,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',4,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',3,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',5,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',6,'','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);

        // Set up the config as desired for testing
        $conf['maintenance']['operationInterval'] = 60;
        $conf['maintenance']['compactStats'] = false;
        $conf['modules']['Tracker'] = true;
        $conf['table']['split'] = false;
        // Set the "current" time
        $oDateNow = new Date('2004-11-28 12:00:00');
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('now', $oDateNow);
        // Create and run the class
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_Tracker();
        $oMaintenanceStatistics->updateStatistics();
        // Test the results
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_variable_value']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_click']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 30);
        // Reset the testing environment
        TestEnv::restoreEnv();
    }

}

?>
