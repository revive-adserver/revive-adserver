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
$Id$
*/

require_once MAX_PATH . '/lib/max/Maintenance/tests/integration/MaintenanceForecastingAdServer.mtf.test.php';
// pgsql execution time before refactor: 183.42s
// pgsql execution time after refactor: s

/**
 * A class for performing an integration test of the Maintenance Forecasting Engine.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMaintenanceForecastingAdServer_ClientUserAgent extends Maintenance_TestOfMaintenanceForecastingAdServer
{
    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Client:Useragent delivery limitation.
     *
     * Note: This test performs a FULL test of all operand types for
     *       a freeform text-field type limitation.
     */
    function testAdServerClient_Useragent()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Useragent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Useragent(\'Mozilla\', \'==\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Useragent',
            '==',
            'Mozilla',
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

        // Test that, after running the MFE, no data has been summarised
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
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'], true);
        // Add data to be summarised
        $query = "
            INSERT INTO
                {$table}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    user_agent
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'mozilla'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.0.8) Gecko/20061025 Firefox/1.5.0.8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Opera/9.02 (Windows NT 5.1; U; en)'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
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
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Useragent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Useragent(\'Mozilla\', \'!=\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Useragent',
            '!=',
            'Mozilla',
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

        // Test that, after running the MFE, no data has been summarised
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

        // Add data to be summarised
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
                    user_agent
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'mozilla'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.0.8) Gecko/20061025 Firefox/1.5.0.8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Opera/9.02 (Windows NT 5.1; U; en)'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
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
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("end_run,updated_to",'log_maintenance_forecasting');
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Useragent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Useragent(\'Mozilla\', \'=~\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Useragent',
            '=~',
            'Mozilla',
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

        // Test that, after running the MFE, no data has been summarised
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

        // Add data to be summarised
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
                    user_agent
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'mozilla'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.0.8) Gecko/20061025 Firefox/1.5.0.8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Opera/9.02 (Windows NT 5.1; U; en)'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
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
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("end_run,updated_to",'log_maintenance_forecasting');
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Useragent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Useragent(\'Mozilla\', \'!~\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Useragent',
            '!~',
            'Mozilla',
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

        // Test that, after running the MFE, no data has been summarised
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

        // Add data to be summarised
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
                    user_agent
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'mozilla'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.0.8) Gecko/20061025 Firefox/1.5.0.8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Opera/9.02 (Windows NT 5.1; U; en)'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
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
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Useragent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Useragent(\'moz.*\', \'=x\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Useragent',
            '=x',
            'moz.*',
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

        // Test that, after running the MFE, no data has been summarised
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

        // Add data to be summarised
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
                    user_agent
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'mozilla'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.0.8) Gecko/20061025 Firefox/1.5.0.8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Opera/9.02 (Windows NT 5.1; U; en)'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
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
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("end_run,updated_to",'log_maintenance_forecasting');
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Useragent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Useragent(\'moz.*\', \'!x\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Useragent',
            '!x',
            'moz.*',
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

        // Test that, after running the MFE, no data has been summarised
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

        // Add data to be summarised
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
                    user_agent
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'mozilla'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.0.8) Gecko/20061025 Firefox/1.5.0.8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Opera/9.02 (Windows NT 5.1; U; en)'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
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
        $query = $this->_buildQuerySelect("end_run,updated_to", 'log_maintenance_forecasting');
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    function OLD_testAdServerClient_Useragent()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Useragent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Useragent(\'Mozilla\', \'==\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Useragent',
            '==',
            'Mozilla',
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

        // Test that, after running the MFE, no data has been summarised
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
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'], true);
        // Add data to be summarised
        $query = "
            INSERT INTO
                {$table}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    user_agent
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'mozilla'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.0.8) Gecko/20061025 Firefox/1.5.0.8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Opera/9.02 (Windows NT 5.1; U; en)'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
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
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Useragent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Useragent(\'Mozilla\', \'!=\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Useragent',
            '!=',
            'Mozilla',
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

        // Test that, after running the MFE, no data has been summarised
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

        // Add data to be summarised
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
                    user_agent
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'mozilla'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.0.8) Gecko/20061025 Firefox/1.5.0.8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Opera/9.02 (Windows NT 5.1; U; en)'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
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
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("end_run,updated_to",'log_maintenance_forecasting');
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Useragent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Useragent(\'Mozilla\', \'=~\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Useragent',
            '=~',
            'Mozilla',
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

        // Test that, after running the MFE, no data has been summarised
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

        // Add data to be summarised
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
                    user_agent
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'mozilla'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.0.8) Gecko/20061025 Firefox/1.5.0.8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Opera/9.02 (Windows NT 5.1; U; en)'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
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
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("end_run,updated_to",'log_maintenance_forecasting');
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Useragent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Useragent(\'Mozilla\', \'!~\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Useragent',
            '!~',
            'Mozilla',
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

        // Test that, after running the MFE, no data has been summarised
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

        // Add data to be summarised
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
                    user_agent
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'mozilla'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.0.8) Gecko/20061025 Firefox/1.5.0.8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Opera/9.02 (Windows NT 5.1; U; en)'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
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
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Useragent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Useragent(\'moz.*\', \'=x\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Useragent',
            '=x',
            'moz.*',
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

        // Test that, after running the MFE, no data has been summarised
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

        // Add data to be summarised
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
                    user_agent
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'mozilla'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.0.8) Gecko/20061025 Firefox/1.5.0.8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Opera/9.02 (Windows NT 5.1; U; en)'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
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
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("end_run,updated_to",'log_maintenance_forecasting');
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = $this->_getQueryCount('data_summary_channel_daily');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Useragent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Useragent(\'moz.*\', \'!x\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Useragent',
            '!x',
            'moz.*',
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

        // Test that, after running the MFE, no data has been summarised
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

        // Add data to be summarised
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
                    user_agent
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'mozilla'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.0.8) Gecko/20061025 Firefox/1.5.0.8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'Opera/9.02 (Windows NT 5.1; U; en)'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
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
        $query = $this->_buildQuerySelect("end_run,updated_to", 'log_maintenance_forecasting');
        $query.= " WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

}

?>