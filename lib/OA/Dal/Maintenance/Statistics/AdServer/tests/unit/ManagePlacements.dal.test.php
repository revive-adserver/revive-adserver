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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Factory.php';

// pgsql execution time before refactor: 67.073s
// pgsql execution time after refactor: s

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_* classes.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Dal_Maintenance_Statistics_AdServer_ManagePlacements extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_AdServer_ManagePlacements()
    {
        $this->UnitTestCase();
    }

    /**
     * Tests the managePlacements() method.
     */
    function testManagePlacements()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $aConf['maintenance']['operationInterval'] = 60;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        $oDate = new Date();
        // Insert the base test data
        $query = "
            INSERT INTO
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
                (
                    campaignid, campaignname, clientid, views, clicks, conversions, expire, activate, active
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'integer',
            'integer',
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1, 'Test Campaign 1', 1, -1, -1, -1, OA_Dal::noDateValue(), OA_Dal::noDateValue(), 't'
        );
        $rows = $st->execute($aData);
        $aData = array(
            2, 'Test Campaign 2', 1, 10, -1, -1, OA_Dal::noDateValue(), OA_Dal::noDateValue(), 't'
        );
        $rows = $st->execute($aData);
        $aData = array(
            3, 'Test Campaign 3', 1, -1, 10, -1, OA_Dal::noDateValue(), OA_Dal::noDateValue(), 't'
        );
        $rows = $st->execute($aData);
        $aData = array(
            4, 'Test Campaign 4', 1, -1, -1, 10, OA_Dal::noDateValue(), OA_Dal::noDateValue(), 't'
        );
        $rows = $st->execute($aData);
        $aData = array(
            5, 'Test Campaign 5', 1, 10, 10, 10, OA_Dal::noDateValue(), OA_Dal::noDateValue(), 't'
        );
        $rows = $st->execute($aData);
        $aData = array(
            6, 'Test Campaign 6', 1, -1, -1, -1, '2004-06-06', OA_Dal::noDateValue(), 't'
        );
        $rows = $st->execute($aData);
        $aData = array(
            7, 'Test Campaign 7', 1, -1, -1, -1, OA_Dal::noDateValue(), '2004-06-06', 'f'
        );
        $rows = $st->execute($aData);
        $query = "
            INSERT INTO
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['clients'],true)}
                (
                    clientid,
                    contact,
                    email
                )
            VALUES
                (
                    1,
                    'Test Contact',
                    'postmaster@localhost'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['banners'],true)}
                (
                    bannerid,
                    campaignid,
                    htmltemplate,
                    htmlcache,
                    url,
                    bannertext,
                    compiledlimitation,
                    append
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1, 1, '', '', '', '', '', ''
        );
        $rows = $st->execute($aData);
        $aData = array(
            2, 2, '', '', '', '', '', ''
        );
        $rows = $st->execute($aData);
        $aData = array(
            3, 2, '', '', '', '', '', ''
        );
        $rows = $st->execute($aData);
        $aData = array(
            4, 2, '', '', '', '', '', ''
        );
        $rows = $st->execute($aData);
        $aData = array(
            5, 3, '', '', '', '', '', ''
        );
        $rows = $st->execute($aData);
        $aData = array(
            6, 4, '', '', '', '', '', ''
        );
        $rows = $st->execute($aData);
        $aData = array(
            7, 5, '', '', '', '', '', ''
        );
        $rows = $st->execute($aData);
        $aData = array(
            8, 6, '', '', '', '', '', ''
        );
        $rows = $st->execute($aData);
        $aData = array(
            9, 7, '', '', '', '', '', ''
        );
        $rows = $st->execute($aData);
        // Test with no summarised data
        $report = $dsa->managePlacements($oDate);
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2004-06-06');
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 'f');
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 7";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], '2004-06-06');
        $this->assertEqual($aRow['active'], 't');
        // Insert the summary test data - Part 1
        $query = "
            INSERT INTO
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    hour,
                    ad_id,
                    creative_id,
                    zone_id,
                    impressions,
                    clicks,
                    conversions
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            60, 17, '2004-06-06 17:00:00', '2004-06-06 17:59:59', 17, 1, 0, 0, 1, 1, 1
        );
        $rows = $st->execute($aData);
        $aData = array(
            60, 17, '2004-06-06 17:00:00', '2004-06-06 17:59:59', 17, 2, 0, 0, 1, 1, 1
        );
        $rows = $st->execute($aData);
        $aData = array(
            60, 17, '2004-06-06 17:00:00', '2004-06-06 17:59:59', 17, 3, 0, 0, 1, 0, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            60, 17, '2004-06-06 17:00:00', '2004-06-06 17:59:59', 17, 4, 0, 0, 8, 0, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            60, 17, '2004-06-06 17:00:00', '2004-06-06 17:59:59', 17, 5, 0, 0, 1000, 5, 1000
        );
        $rows = $st->execute($aData);
        $aData = array(
            60, 17, '2004-06-06 17:00:00', '2004-06-06 17:59:59', 17, 6, 0, 0, 1000, 1000, 1000
        );
        $rows = $st->execute($aData);
        $aData = array(
            60, 17, '2004-06-06 17:00:00', '2004-06-06 17:59:59', 17, 7, 2, 0, 0, 4, 6
        );
        $rows = $st->execute($aData);
        $aData = array(
            60, 17, '2004-06-06 17:00:00', '2004-06-06 17:59:59', 17, 8, 2, 0, 0, 4, 6
        );
        $rows = $st->execute($aData);
        // Test with summarised data
        $report = $dsa->managePlacements($oDate);
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 'f');
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 'f');
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2004-06-06');
        $this->assertEqual($aRow['activate'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['active'], 'f');
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 7";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], OA_Dal::noDateValue());
        $this->assertEqual($aRow['activate'], '2004-06-06');
        $this->assertEqual($aRow['active'], 't');
        TestEnv::restoreEnv();
        // Final test to ensure that placements expired as a result of limitations met are
        // not re-activated in the event that their expiration date has not yet been reached
        $query = "
            INSERT INTO
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
                    (
                        campaignid,
                        campaignname,
                        clientid,
                        views,
                        clicks,
                        conversions,
                        expire,
                        activate,
                        active
                    )
                VALUES
                    (
                        1,
                        'Test Campaign 1',
                        1,
                        10,
                        -1,
                        -1,
                        '2005-12-09',
                        '2005-12-07',
                        'f'
                    )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['clients'],true)}
                    (
                        clientid,
                        contact,
                        email
                    )
                VALUES
                    (
                        1,
                        'Test Contact',
                        'postmaster@localhost'
                    )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['banners'],true)}
                    (
                        bannerid,
                        campaignid,
                        htmltemplate,
                        htmlcache,
                        url,
                        bannertext,
                        compiledlimitation,
                        append
                    )
                VALUES
                    (
                        1,
                        1,
                        '',
                        '',
                        '',
                        '',
                        '',
                        ''
                    )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)}
                    (
                        operation_interval,
                        operation_interval_id,
                        interval_start,
                        interval_end,
                        hour,
                        ad_id,
                        creative_id,
                        zone_id,
                        impressions,
                        clicks,
                        conversions
                    )
                VALUES
                    (
                        60,
                        25,
                        '2005-12-08 00:00:00',
                        '2004-12-08 00:59:59',
                        0,
                        1,
                        0,
                        0,
                        100,
                        1,
                        0
                     )";
        $rows = $oDbh->exec($query);
        $oDate = new Date('2005-12-08 01:00:01');
        $report = $dsa->managePlacements($oDate);
        $query = "
            SELECT
                *
            FROM
                {$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)}
            WHERE
                campaignid = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2005-12-09');
        $this->assertEqual($aRow['activate'], '2005-12-07');
        $this->assertEqual($aRow['active'], 'f');
        TestEnv::restoreEnv();
        TestEnv::restoreConfig();
    }
}

?>
