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
// pgsql execution time before refactor: 50.608s
// pgsql execution time after refactor: s

/**
 * A class for performing an integration test of the Maintenance Forecasting Engine.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMaintenanceForecastingAdServer_Complex extends Maintenance_TestOfMaintenanceForecastingAdServer
{
    /**
     * A method to perform intermediate end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server.
     *
     * Requirements:
     * Test 1: Test with a "complex" and/or combination channel, and ensure
     *         that only the required ad impressions are summarised.
     */
    function testAdServerComplex()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['table']['split'] = true;
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

        // Add the complex channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Complex Channel',
            'MAX_checkGeo_Country(\'GB\', \'=~\') and MAX_checkSite_Pageurl(\'m3\', \'=~\') or MAX_checkGeo_Netspeed(\'cabledsl\', \'=~\')',
            'Geo:Country,Site:Pageurl,Geo:Netspeed',
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
        $aData = array(
            1,
            'and',
            'Site:Pageurl',
            '=~',
            'm3',
            1
        );
        $rows = $this->stAclsChannel->execute($aData);
        $aData = array(
            1,
            'or',
            'Geo:Netspeed',
            '=~',
            'cabledsl',
            2
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

        // Add data to be summarised in a split table
        $oTable = &OA_DB_Table_Core::singleton();
        $oTable->createTable($aConf['table']['data_raw_ad_impression'], new Date('2006-06-14'));
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'].'_20060614', true);
        $query = "
            INSERT INTO
                {$table}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country,
                    https,
                    domain,
                    page,
                    query,
                    geo_netspeed
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text',
            'integer',
            'text',
            'text',
            'text',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'US',
            0,
            'www.example.com',
            '/index.html',
            '',
            'dialup'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB',
            0,
            'www.example.com',
            '/index.html',
            '',
            'dialup'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB',
            0,
            'www.m3.net',
            '/index.html',
            '',
            'dialup'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB',
            0,
            'www.m3.net',
            '/index.html',
            '',
            'cabledsl'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'US',
            0,
            'www.example.net',
            '/index.html',
            '',
            'cabledsl'
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
        $this->assertEqual($aRow['actual_impressions'], 3);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("end_run,updated_to",'log_maintenance_forecasting');
        $query.=" WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform intermediate end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server.
     *
     * Requirements:
     * Test 1: Test with a "complex" and/or combination channel, and ensure
     *         that only the required ad impressions are summarised.
     */
    function OLD_testAdServerComplex()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['table']['split'] = true;
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

        // Add the complex channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Complex Channel',
            'MAX_checkGeo_Country(\'GB\', \'=~\') and MAX_checkSite_Pageurl(\'m3\', \'=~\') or MAX_checkGeo_Netspeed(\'cabledsl\', \'=~\')',
            'Geo:Country,Site:Pageurl,Geo:Netspeed',
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
        $aData = array(
            1,
            'and',
            'Site:Pageurl',
            '=~',
            'm3',
            1
        );
        $rows = $this->stAclsChannel->execute($aData);
        $aData = array(
            1,
            'or',
            'Geo:Netspeed',
            '=~',
            'cabledsl',
            2
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

        // Add data to be summarised in a split table
        $oTable = &OA_DB_Table_Core::singleton();
        $oTable->createTable($aConf['table']['data_raw_ad_impression'], new Date('2006-06-14'));
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_ad_impression'].'_20060614', true);
        $query = "
            INSERT INTO
                {$table}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country,
                    https,
                    domain,
                    page,
                    query,
                    geo_netspeed
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text',
            'integer',
            'text',
            'text',
            'text',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'US',
            0,
            'www.example.com',
            '/index.html',
            '',
            'dialup'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB',
            0,
            'www.example.com',
            '/index.html',
            '',
            'dialup'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB',
            0,
            'www.m3.net',
            '/index.html',
            '',
            'dialup'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB',
            0,
            'www.m3.net',
            '/index.html',
            '',
            'cabledsl'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'US',
            0,
            'www.example.net',
            '/index.html',
            '',
            'cabledsl'
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
        $this->assertEqual($aRow['actual_impressions'], 3);
        $query = $this->_getQueryCount('log_maintenance_forecasting');
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = $this->_buildQuerySelect("end_run,updated_to",'log_maintenance_forecasting');
        $query.=" WHERE log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }
}
?>