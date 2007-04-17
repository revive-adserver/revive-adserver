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
$Id$
*/

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer.php';

/**
 * A class for performing an integration test of the Maintenance Forecasting Engine.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMaintenanceForecastingAdServer extends UnitTestCase
{

    var $stChannel;

    var $stAclsChannel;

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMaintenanceForecastingAdServer()
    {
        $this->UnitTestCase();
    }

    /**
     * A private method to set up the prepared SQL statements needed in the tests.
     *
     * @access private
     */
    function _prepareStatements()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['channel']}
                (
                    channelid,
                    agencyid,
                    affiliateid,
                    name,
                    compiledlimitation,
                    acl_plugins,
                    active
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'integer'
        );
        $this->stChannel = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['acls_channel']}
                (
                    channelid,
                    logical,
                    type,
                    comparison,
                    data,
                    executionorder
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'text',
            'text',
            'text',
            'integer'
        );
        $this->stAclsChannel = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
    }

    /**
     * A private method to insert the standard test zone.
     *
     * @access private
     */
    function _insertZone()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['zones']}
                (
                    zoneid,
                    affiliateid,
                    inventory_forecast_type,
                    category,
                    ad_selection,
                    chain,
                    prepend,
                    append
                )
            VALUES
                (
                    2,
                    5,
                    8,
                    '',
                    '',
                    '',
                    '',
                    ''
                )";
        $rows = $oDbh->exec($query);
    }

    /**
     * A private method to insert the standard test impressions.
     *
     * @access private
     */
    function _insertImpressions()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-12 11:00:04',
            5,
            0,
            2
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-13 12:00:04',
            5,
            0,
            2
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 13:00:04',
            5,
            0,
            2
        );
        $rows = $st->execute($aData);
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Test 2
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
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

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Test 4
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Test 5
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        // Test 6
        $query = "DELETE FROM {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 2";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
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

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised in a split table
        $oTable = &OA_DB_Table_Core::singleton();
        $oTable->createTable($aConf['table']['data_raw_ad_impression'], new Date('2006-06-14'));
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}_20060614
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 3);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Client:Browser delivery limitation.
     */
    function testAdServerClient_Browser()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Browser channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Browser(\'IE,FX\', \'=~\')',
            'Client:Browser',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Browser',
            '=~',
            'IE,FX',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    browser
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
            'IE'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'FX'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'NS'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Browser channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Browser(\'IE,FX\', \'!~\')',
            'Client:Browser',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Browser',
            '!~',
            'IE,FX',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    browser
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
            'IE'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'FX'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'NS'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Client:Domain delivery limitation.
     *
     * Note: This test is for a freeform text-field type limitation,
     *       however, it only tests the simple =~ form of the
     *       operand, as all forms of matching are tested in the
     *       Client:Useragent plugin test.
     */
    function testAdServerClient_Domain()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Domain channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Domain(\'m3\', \'=~\')',
            'Client:Domain',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Domain',
            '=~',
            'm3',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    host_name
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-14 11:00:04',
                    5,
                    0,
                    2,
                    'www.example.com'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    host_name
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-14 11:00:04',
                    5,
                    0,
                    2,
                    'www.m3.net'
                )";
        $rows = $oDbh->exec($query);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Client:Ip delivery limitation.
     */
    function testAdServerClient_Ip()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:IP channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Ip(\'192.168.0.1\', \'==\')',
            'Client:IP',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Ip',
            '==',
            '192.168.0.1',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    ip_address
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
            '192.168.0.1'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            '192.168.0.2'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            '192.168.1.1'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:IP channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Ip(\'192.168.0.*\', \'==\')',
            'Client:IP',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Ip',
            '==',
            '192.168.0.*',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    ip_address
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
            '192.168.0.1'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            '192.168.0.2'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            '192.168.1.1'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:IP channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Ip(\'192.168.0.1\', \'!=\')',
            'Client:IP',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Ip',
            '!=',
            '192.168.0.1',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    ip_address
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
            '192.168.0.1'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            '192.168.0.2'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            '192.168.1.1'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:IP channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Ip(\'192.168.0.1\', \'!=\')',
            'Client:IP',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Ip',
            '!=',
            '192.168.0.*',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    ip_address
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
            '192.168.0.1'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            '192.168.0.2'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            '192.168.1.1'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Client:Language delivery limitation.
     */
    function testAdServerClient_Language()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Language channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Language(\'en\', \'=~\')',
            'Client:Language',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Language',
            '=~',
            'en',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    language
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
            'it'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'pl'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'pl,en-us;q=0.7,en;q=0.3'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Language channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Language(\'en\', \'!~\')',
            'Client:Language',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Language',
            '!~',
            'en',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    language
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
            'it'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'pl'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'pl,en-us;q=0.7,en;q=0.3'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Client:Os delivery limitation.
     */
    function testAdServerClient_Os()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Os channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Os(\'linux\', \'=~\')',
            'Client:Os',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Os',
            '=~',
            'linux',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    os
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
            'xp'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'osx'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'linux'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Client:Os channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkClient_Os(\'linux\', \'!~\')',
            'Client:Language',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Client:Os',
            '!~',
            'linux',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    os
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
            'xp'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'osx'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'linux'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
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

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
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

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
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

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
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

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
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

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
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

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Geo:Areacode delivery limitation.
     *
     * Note: This test is for a freeform text-field type limitation,
     *       however, it only tests the simple =~ form of the
     *       operand, as all forms of matching are tested in the
     *       Client:Useragent plugin test.
     */
    function testAdServerGeo_Areacode()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Areacode channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Areacode(\'1234\', \'=~\')',
            'Geo:Areacode',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Areacode',
            '=~',
            '1234',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    geo_area_code
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
            123
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            12345
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Geo:City delivery limitation.
     */
    function testAdServerGeo_City()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:City channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_City(\'gb|london\', \'\')',
            'Geo:City',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:City',
            '',
            'GB|London',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country,
                    geo_city
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
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
            'AU',
            'London'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB',
            'London'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB',
            'Manchester'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Geo:Continent delivery limitation.
     */
    function testAdServerGeo_Continent()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Continent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Continent(\'OC\', \'=~\')',
            'Geo:Continent',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Continent',
            '=~',
            'OC',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country
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
            'AU'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'NZ'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Continent channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Continent(\'OC\', \'!~\')',
            'Geo:Continent',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Continent',
            '!~',
            'OC',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country
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
            'AU'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'NZ'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Geo:Country delivery limitation.
     */
    function testAdServerGeo_Country()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Country channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Country(\'GB,US\', \'=~\')',
            'Geo:Country',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Country',
            '=~',
            'GB,US',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country
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
            'AU'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'US'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Country channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Country(\'GB,US\', \'!~\')',
            'Geo:Country',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Country',
            '!~',
            'GB,US',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country
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
            'AU'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'US'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Geo:Dma delivery limitation.
     */
    function testAdServerGeo_Dma()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Dma channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Dma(\'514,626\', \'=~\')',
            'Geo:Dma',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Dma',
            '=~',
            '514,626',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    geo_dma_code
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
            123
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            514
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            626
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Dma channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Dma(\'514,626\', \'!~\')',
            'Geo:Dma',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Dma',
            '!~',
            '514,626',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    geo_dma_code
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
            123
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            514
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            626
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Geo:Latlong delivery limitation.
     */
    function testAdServerGeo_Latlong()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Latlong channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Latlong(\'10,20,30,40\', \'==\')',
            'Geo:Latlong',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Latlong',
            '==',
            '10,20,30,40',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    geo_latitude,
                    geo_longitude
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            5,
            25
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            15,
            25
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            15,
            35
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            25,
            35
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            25,
            45
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Latlong channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Latlong(\'10,20,30,40\', \'!=\')',
            'Geo:Latlong',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Latlong',
            '!=',
            '10,20,30,40',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    geo_latitude,
                    geo_longitude
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            5,
            25
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            15,
            25
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            15,
            35
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            25,
            35
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            25,
            45
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 4);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Geo:Netspeed delivery limitation.
     */
    function testAdServerGeo_Netspeed()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Netspeed channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Netspeed(\'cabledsl,corporate\', \'=~\')',
            'Geo:Netspeed',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Netspeed',
            '=~',
            'cabledsl,corporate',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    geo_netspeed
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
            'unknown'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'cabledsl'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'corporate'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Netspeed channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Netspeed(\'cabledsl,corporate\', \'!~\')',
            'Geo:Netspeed',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Netspeed',
            '!~',
            'cabledsl,corporate',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    geo_netspeed
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
            'unknown'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'cabledsl'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'corporate'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Geo:Organisation delivery limitation.
     *
     * Note: This test is for a freeform text-field type limitation,
     *       however, it only tests the simple =~ form of the
     *       operand, as all forms of matching are tested in the
     *       Client:Useragent plugin test.
     */
    function testAdServerGeo_Organisation()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Organisation channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Organisation(\'m3\', \'=~\')',
            'Geo:Organisation',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Organisation',
            '=~',
            'm3',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    geo_organisation
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
            'Example PLC'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'm3 Media Services Limited'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Geo:Postalcode delivery limitation.
     *
     * Note: This test is for a freeform text-field type limitation,
     *       however, it only tests the simple =~ form of the
     *       operand, as all forms of matching are tested in the
     *       Client:Useragent plugin test.
     */
    function testAdServerGeo_Postalcode()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Postalcode channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Postalcode(\'1234\', \'=~\')',
            'Geo:Postalcode',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Postalcode',
            '=~',
            '1234',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    geo_postal_code
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
            123
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            12345
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Geo:Region delivery limitation.
     */
    function testAdServerGeo_Region()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Geo:Region channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkGeo_Region(\'gb|t5,h9\', \'\')',
            'Geo:Region',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Geo:Region',
            '',
            'gb|t5,h9',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    country,
                    geo_region
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'timestamp',
            'integer',
            'integer',
            'integer',
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
            'AK'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB',
            '18'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '900b330941c4d3450c3332e6917a16e2',
            '2006-06-14 11:00:04',
            5,
            0,
            2,
            'GB',
            'T5'
        );
        $rows = $st->execute($aData);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Site:Pageurl delivery limitation.
     *
     * Note: This test is for a freeform text-field type limitation,
     *       however, it only tests the simple =~ form of the
     *       operand, as all forms of matching are tested in the
     *       Client:Useragent plugin test.
     */
    function testAdServerSite_Pageurl()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Site:Pageurl channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkSite_Pageurl(\'m3\', \'=~\')',
            'Site:Pageurl',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Site:Pageurl',
            '=~',
            'm3',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    https,
                    domain,
                    page,
                    query
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-14 11:00:04',
                    5,
                    0,
                    2,
                    0,
                    'www.example.com',
                    '/index.html',
                    ''
                )";
        $rows = $oDbh->exec($query);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    https,
                    domain,
                    page,
                    query
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-14 11:00:04',
                    5,
                    0,
                    2,
                    0,
                    'www.m3.net',
                    '/index.html',
                    ''
                )";
        $rows = $oDbh->exec($query);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Site:Referingpage delivery limitation.
     *
     * Note: This test is for a freeform text-field type limitation,
     *       however, it only tests the simple =~ form of the
     *       operand, as all forms of matching are tested in the
     *       Client:Useragent plugin test.
     */
    function testAdServerSite_Referingpage()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Site:Referingpage channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkSite_Referingpage(\'m3\', \'=~\')',
            'Site:Referingpage',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Site:Referingpage',
            '=~',
            'm3',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    referer
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-14 11:00:04',
                    5,
                    0,
                    2,
                    'www.example.com'
                )";
        $rows = $oDbh->exec($query);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    referer
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-14 11:00:04',
                    5,
                    0,
                    2,
                    'www.m3.net'
                )";
        $rows = $oDbh->exec($query);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Site:Source delivery limitation.
     *
     * Note: This test is for a freeform text-field type limitation,
     *       however, it only tests the simple =~ form of the
     *       operand, as all forms of matching are tested in the
     *       Client:Useragent plugin test.
     */
    function testAdServerSite_Source()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Site:Source channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkSite_Source(\'m3\', \'=~\')',
            'Site:Source',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Site:Source',
            '=~',
            'm3',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    channel
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-14 11:00:04',
                    5,
                    0,
                    2,
                    'example.com'
                )";
        $rows = $oDbh->exec($query);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['data_raw_ad_impression']}
                (
                    viewer_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    channel
                )
            VALUES
                (
                    '900b330941c4d3450c3332e6917a16e2',
                    '2006-06-14 11:00:04',
                    5,
                    0,
                    2,
                    'm3.net'
                )";
        $rows = $oDbh->exec($query);

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Time:Date delivery limitation.
     */
    function testAdServerTime_Date()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Time:Date channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkTime_Date(\'20060612\', \'==\')',
            'Time:Date',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Time:Date',
            '==',
            '20060612',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $this->_insertImpressions();

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}
            ORDER BY
                day";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-12');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-12 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-13 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 3";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Time:Date channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkTime_Date(\'20060612\', \'!=\')',
            'Time:Date',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Time:Date',
            '!=',
            '20060612',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $this->_insertImpressions();

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}
            ORDER BY
                day";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-13');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-12 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-13 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 3";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Time:Date channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkTime_Date(\'20060612\', \'>\')',
            'Time:Date',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Time:Date',
            '>',
            '20060612',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $this->_insertImpressions();

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}
            ORDER BY
                day";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-13');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-12 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-13 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 3";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Time:Date channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkTime_Date(\'20060612\', \'>=\')',
            'Time:Date',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Time:Date',
            '>=',
            '20060612',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $this->_insertImpressions();

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}
            ORDER BY
                day";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-12');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-13');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-12 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-13 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 3";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Time:Date channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkTime_Date(\'20060614\', \'<\')',
            'Time:Date',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Time:Date',
            '<',
            '20060614',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $this->_insertImpressions();

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}
            ORDER BY
                day";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-12');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-13');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-12 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-13 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 3";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Time:Date channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkTime_Date(\'20060614\', \'<=\')',
            'Time:Date',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Time:Date',
            '<=',
            '20060614',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $this->_insertImpressions();

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}
            ORDER BY
                day";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-12');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-13');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-12 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-13 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Time:Day delivery limitation.
     */
    function testAdServerTime_Day()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Time:Day channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkTime_Day(\'1\', \'=~\')',
            'Time:Day',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Time:Day',
            '=~',
            '1',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $this->_insertImpressions();

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}
            ORDER BY
                day";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-12');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-12 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-13 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 3";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Time:Day channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkTime_Day(\'1\', \'!~\')',
            'Time:Day',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Time:Day',
            '!~',
            '1',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $this->_insertImpressions();

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-13 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-14 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}
            ORDER BY
                day";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-13');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-12 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-13 23:59:59');
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

    /**
     * A method to perform basic end-to-end integration testing of the
     * Maintenance Forecasting Engine classes for the Ad Server for a
     * channel using the Time:Hour delivery limitation.
     */
    function testAdServerTime_Hour()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        $aConf['maintenance']['channelForecasting'] = true;

        $oDbh = &OA_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();

        $this->_prepareStatements();

        // Test nothing is in the database to begin with
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Time:Hour channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkTime_Hour(\'12\', \'=~\')',
            'Time:Hour',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Time:Hour',
            '=~',
            '12',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $this->_insertImpressions();

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 1);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
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
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add the Time:Hour channel, and required publisher and zone
        $aData = array(
            1,
            0,
            0,
            'Channel',
            'MAX_checkTime_Hour(\'12\', \'!~\')',
            'Time:Hour',
            1
        );
        $rows = $this->stChannel->execute($aData);

        $aData = array(
            1,
            'and',
            'Time:Hour',
            '!~',
            '12',
            0
        );
        $rows = $this->stAclsChannel->execute($aData);

        $query = "
            INSERT INTO
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']}
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

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);

        // Add data to be summarised
        $this->_insertImpressions();

        // Test that, after running the MFE, the correct data has been summarised
        $oDate = new Date('2006-06-15 13:01:01');
        $oServiceLocator->register('now', $oDate);
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->updateForecasts();
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                day,
                channel_id,
                zone_id,
                actual_impressions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_channel_daily']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2006-06-14');
        $this->assertEqual($aRow['channel_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['actual_impressions'], 2);

        $query = "
            SELECT
                count(*) AS number
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                end_run,
                updated_to
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $oRunEndDate = new Date($aRow['end_run']);
        $this->assertTrue($oAfterUpdateDate->after($oRunEndDate));
        $this->assertEqual($aRow['updated_to'], '2006-06-14 23:59:59');

        TestEnv::restoreEnv();
    }

}

?>
