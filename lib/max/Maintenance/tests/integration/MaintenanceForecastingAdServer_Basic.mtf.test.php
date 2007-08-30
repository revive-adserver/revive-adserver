<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
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
$Id $
*/

require_once MAX_PATH . '/lib/max/Maintenance/tests/integration/MaintenanceForecastingAdServer.mtf.test.php';

// pgsql execution time before refactor: 81.190s
// pgsql execution time after refactor: s

/**
 * A class for performing an integration test of the Maintenance Forecasting Engine.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMaintenanceForecastingAdServer_Basic extends Maintenance_TestOfMaintenanceForecastingAdServer
{
     /**
     * A method to perform basic end-to-end integration testing of the Maintenance
     * Forecasting Engine classes for the Ad Server.
     *
     * Requirements:
     * Test 1: Test that no zone forecast or priority data exists to begin with.
     * Test 2: Run the MFE without any channels, without stats, and without the
     *         engine ever having been run before.
     * Test 3: Run the MFE with an admin channel defined, and an admin publisher
     *         defined, with a zone that has channel forecasting enabled, but
     *         without stats, and without the engine ever having been run before.
     * Test 4: Run the MFE with an admin channel defined, and an admin publisher
     *         defined, with a zone that has channel forecasting enabled, but
     *         without stats, and with stats for today only, and without the
     *         engine ever having been run before.
     * Test 5: Run the MFE with an admin channel defined, and an admin publisher
     *         defined, with a zone that has channel forecasting enabled, but
     *         without stats, and with stats for yesterday but not in the channel,
     *         and without the engine ever having been run before.
     * Test 6: Run the MFE with an admin channel defined, and an admin publisher
     *         defined, with a zone that has channel forecasting enabled, and
     *         with stats for yesterday in the channel, and without the engine
     *         ever having been run before.
     */
    function testAdServerBasic()
    {
        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test 1
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Test 2
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Test 3
        $aData = array(
            1,
            0,
            0,
            'UK',
            'MAX_checkGeo_Country(\'GB\', \'=~\')',
            'Geo:Country',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Country',
            '=~',
            'GB',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['affiliates'], true);
        $query = "
            INSERT INTO
                {$table}
                (
                    affiliateid,
                    agencyid
                )
            VALUES
                (
                    5,
                    0
                )";
        $rows = $oDbh->exec($query);
        $this->_insertZone();

        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Test 4
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'], true);
        $query = "
            INSERT INTO
                {$table}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-15 11:00:04',
                    5,
                    0,
                    2,
                    'US'
                )";
        $rows = $oDbh->exec($query);

        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Test 5
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'], true);
        $query = "
            INSERT INTO
                {$table}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-14 11:00:04',
                    5,
                    0,
                    2,
                    'US'
                )";
        $rows = $oDbh->exec($query);

        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("end_run, updated_to", 'log_maintenance_forecasting');
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        // Test 6
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['log_maintenance_forecasting'], true);
        $query = "DELETE FROM {$table}";
        $rows = $oDbh->exec($query);
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'], true);
        $query = "
            INSERT INTO
                {$table}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-14 11:00:04',
                    5,
                    0,
                    2,
                    'GB'
                )";
        $rows = $oDbh->exec($query);

        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("day,channel_id,zone_id,actual_impressions",'data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("end_run,updated_to",'log_maintenance_forecasting');
        $query.= " WHERE log_maintenance_forecasting_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

     /**
     * A method to perform basic end-to-end integration testing of the Maintenance
     * Forecasting Engine classes for the Ad Server.
     *
     * Requirements:
     * Test 1: Test that no zone forecast or priority data exists to begin with.
     * Test 2: Run the MFE without any channels, without stats, and without the
     *         engine ever having been run before.
     * Test 3: Run the MFE with an admin channel defined, and an admin publisher
     *         defined, with a zone that has channel forecasting enabled, but
     *         without stats, and without the engine ever having been run before.
     * Test 4: Run the MFE with an admin channel defined, and an admin publisher
     *         defined, with a zone that has channel forecasting enabled, but
     *         without stats, and with stats for today only, and without the
     *         engine ever having been run before.
     * Test 5: Run the MFE with an admin channel defined, and an admin publisher
     *         defined, with a zone that has channel forecasting enabled, but
     *         without stats, and with stats for yesterday but not in the channel,
     *         and without the engine ever having been run before.
     * Test 6: Run the MFE with an admin channel defined, and an admin publisher
     *         defined, with a zone that has channel forecasting enabled, and
     *         with stats for yesterday in the channel, and without the engine
     *         ever having been run before.
     */
    function OLD_testAdServerBasic()
    {
        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test 1
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Test 2
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Test 3
        $aData = array(
            1,
            0,
            0,
            'UK',
            'MAX_checkGeo_Country(\'GB\', \'=~\')',
            'Geo:Country',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Country',
            '=~',
            'GB',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['affiliates'], true);
        $query = "
            INSERT INTO
                {$table}
                (
                    affiliateid,
                    agencyid
                )
            VALUES
                (
                    5,
                    0
                )";
        $rows = $oDbh->exec($query);
        $this->_insertZone();

        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Test 4
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'], true);
        $query = "
            INSERT INTO
                {$table}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-15 11:00:04',
                    5,
                    0,
                    2,
                    'US'
                )";
        $rows = $oDbh->exec($query);

        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Test 5
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'], true);
        $query = "
            INSERT INTO
                {$table}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-14 11:00:04',
                    5,
                    0,
                    2,
                    'US'
                )";
        $rows = $oDbh->exec($query);

        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("end_run, updated_to", 'log_maintenance_forecasting');
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        // Test 6
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['log_maintenance_forecasting'], true);
        $query = "DELETE FROM {$table}";
        $rows = $oDbh->exec($query);
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'], true);
        $query = "
            INSERT INTO
                {$table}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-14 11:00:04',
                    5,
                    0,
                    2,
                    'GB'
                )";
        $rows = $oDbh->exec($query);

        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("day,channel_id,zone_id,actual_impressions",'data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("end_run,updated_to",'log_maintenance_forecasting');
        $query.= " WHERE log_maintenance_forecasting_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

}
?>