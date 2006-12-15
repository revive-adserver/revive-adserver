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

/**
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Demian Turner <demian@m3.net>
 */

require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once 'Text/Password.php';

/**
 * A class for testing the Admin_DA class.
 */
class Admin_DaTest extends UnitTestCase
{
    // +---------------------------------------+
    // | Utility methods                       |
    // |                                       |
    // | for db connections and last inserted  |
    // | IDs                                   |
    // +---------------------------------------+
    var $dbh = null;

    function Admin_DaTest()
    {
        $this->UnitTestCase();
        $dbh =& MAX_DB::singleton();
    }

    function getLastRecordInserted($tableName, $tableIndexField)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $tableName = $conf['table']['prefix'] . $tableName;
        $sql = "SELECT MAX($tableIndexField) AS max FROM $tableName";
        $result = $dbh->getRow($sql, array(), DB_FETCHMODE_ASSOC);

        return (int) $result['max'];
    }

    // +---------------------------------------+
    // | Test relational/constraint-related    |
    // | private methods                       |
    // +---------------------------------------+

    function test_getStatsColumns()
    {
        $entities = array(
         'ad',
         'advertiser',
         'agency',
         'placement',
         'publisher',
         'zone',
         );
        foreach ($entities as $entity) {
            $ret = SqlBuilder::_getStatsColumns($entity);
            $this->assertTrue(is_array($ret));
            $this->assertEqual(count($ret), 5); //  each hash should have 5 elements
            $lastElement = array_pop($ret);
             //   last element should be the entity_id
            $this->assertEqual($entity . '_id', $lastElement);
        }
    }

    function test_getColumns()
    {
        //  load hash representing data structure
        require MAX_PATH . '/lib/max/data/data.entities.php';
        foreach ($entities as $entity => $hash) {
            $ret = SqlBuilder::_getColumns($entity, array(), true);
            $this->assertEqual($hash, $ret);
        }
    }

    function test_getPrimaryTable()
    {
        require MAX_PATH . '/lib/max/data/data.entities.php';
        foreach ($entities as $entity => $hash) {
            $ret = SqlBuilder::_getPrimaryTable($entity);
            $this->assertTrue(is_array($ret));
            $this->assertTrue(count($ret) == 1);
            $keys = array_keys($ret);
            $vals = array_values($ret);
            $this->assertTrue(is_string($keys[0]));
            $this->assertTrue(!is_null($vals[0]));
        }
    }

    function test_getTables()
    {
        require MAX_PATH . '/lib/max/data/data.entities.php';
        foreach ($entities as $entity => $hash) {
            $ret = SqlBuilder::_getTables($entity, array());
            $this->assertTrue(is_array($ret));
            $this->assertTrue(count($ret) == 1);
            $keys = array_keys($ret);
            $vals = array_values($ret);
            $this->assertTrue(is_string($keys[0]));
            $this->assertTrue(!is_null($vals[0]));
        }
    }

    function test_getLimitations()
    {
        require MAX_PATH . '/lib/max/data/data.entities.php';
        foreach ($entities as $entity => $hash) {
            $ret = SqlBuilder::_getLimitations($entity, array_flip($hash));
            $this->assertTrue(is_array($ret));
        }

    }

    // +---------------------------------------+
    // | Test SQL-related private methods      |
    // |                                       |
    // +---------------------------------------+
    function test_insert()
    {

        TestEnv::startTransaction();

        $aTable = array('zones' => 'foo');
        $aVariables = array(
            'affiliateid' => 23,
            'zonename' => 'foo',
            'description' => 'this is the desc');
        $ret = SqlBuilder::_insert($aTable, $aVariables);
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        TestEnv::rollbackTransaction();

    }

    function test_select()
    {
    }

//    $aActiveAdvertisers = Admin_DA::_getEntities('advertiser', $aParams


    // +---------------------------------------+
    // | Test public methods                   |
    // |                                       |
    // +---------------------------------------+

    // +---------------------------------------+
    // | placementZones                        |
    // +---------------------------------------+
    function testAddPlacementZone()
    {
        // starting the transaction or subtransaction
        // for details look at lib/pear/DB/mysql_SGL.php
        TestEnv::startTransaction();

        $ret = Admin_DA::addPlacementZone(array('zone_id' => 1, 'placement_id' => 2));
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        TestEnv::rollbackTransaction();
    }

    function testPlacementZones()
    {

        TestEnv::startTransaction();

        $ret = Admin_DA::addPlacementZone(array('zone_id' => rand(1,999), 'placement_id' => rand(1,999)));
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        $retVar = Admin_DA::getPlacementZones(array('placement_zone_assoc_id' => $ret));

        $this->assertTrue(is_array($retVar[$ret]));
        TestEnv::rollbackTransaction();
    }

    // +---------------------------------------+
    // | limitations                           |
    // +---------------------------------------+
    function testGetDeliveryLimitations()
    {
        //  FIXME: needs real data

        TestEnv::startTransaction();

        $ret = Admin_DA::getDeliveryLimitations(array('zone_id' => 1, 'placement_id' => 2));
        $this->assertTrue(is_array($ret));

        TestEnv::rollbackTransaction();
    }

    function testAddLimitation()
    {
        //  a bug with transactions causes this valid insert to fail

        TestEnv::startTransaction();
        $ret = Admin_DA::addLimitation(array(
            'bannerid' => rand(1,999),
            'executionorder' => rand(1,9),
            'logical' => 'and',
            'type' => 'foo',
            ));
        $this->assertTrue(is_int($ret));
        TestEnv::rollbackTransaction();
    }

    // +---------------------------------------+
    // | variables                             |
    // +---------------------------------------+
    function testGetVariables()
    {

        TestEnv::startTransaction();

        $ret = Admin_DA::addVariable(array(
            'trackerid' => rand(1,999),
            'name' => 'foo',
            'description' => 'bar',
            'datatype' => 'string',
            'purpose' => 'basket_value',
            ));
        $this->assertTrue(is_int($ret));
        $retVar = Admin_DA::getVariables(array('variableid' => $ret));
        /*
        Array
        (
            [58] => Array
                (
                    [variable_id] => 58
                    [tracker_id] => 520
                    [name] => foo
                    [type] => string
                )

        )
        */
        $this->assertTrue(is_array($retVar[$ret]));
        TestEnv::rollbackTransaction();
    }

    function testAddVariable()
    {

        TestEnv::startTransaction();

        $ret = Admin_DA::addVariable(array(
            'trackerid' => rand(1,999),
            'name' => 'foo',
            'description' => 'bar',
            'datatype' => 'string',
            'purpose' => 'basket_value',
            ));
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        TestEnv::rollbackTransaction();
    }

    // +---------------------------------------+
    // | trackers                              |
    // +---------------------------------------+
    function testGetTracker()
    {

        TestEnv::startTransaction();

        $id = Admin_DA::addTracker(array(
            'trackername' => 'foo',
            'description' => 'bar',
            'clientid' => rand(1,9999),
            ));

        $ret = Admin_DA::getTracker($id);
        // should look like this
        /*
        Array
        (
            [advertiser_id] => 123
            [tracker_id] => 11
            [name] => sdfasdf
            [description] => desc
            [viewwindow] => 22
            [clickwindow] => 33
            [blockwindow] => 55
        )
        */
        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret));
        $this->assertTrue(array_key_exists('advertiser_id', $ret));
        $this->assertTrue(array_key_exists('tracker_id', $ret));
        $this->assertTrue(array_key_exists('name', $ret));
        $this->assertTrue(array_key_exists('description', $ret));
        $this->assertTrue(array_key_exists('viewwindow', $ret));
        $this->assertTrue(array_key_exists('clickwindow', $ret));
        $this->assertTrue(array_key_exists('blockwindow', $ret));

        TestEnv::rollbackTransaction();
    }

    function testAddTracker()
    {

        TestEnv::startTransaction();

        $ret = Admin_DA::addTracker(array(
            'trackername' => 'foo',
            'description' => 'bar',
            'clientid' => rand(1,9999),
            ));
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        TestEnv::rollbackTransaction();
    }

    function testDuplicateTracker()
    {

        TestEnv::startTransaction();

        $trackerId = Admin_DA::addTracker(array(
            'trackername' => 'foo',
            'description' => 'bar',
            'clientid' => rand(1,9999),
            ));
        $this->assertTrue(is_int($trackerId));
        $this->assertTrue($trackerId > 0);

        $tracker1 = Admin_DA::getTracker($trackerId);

        $ret = Admin_DA::duplicateTracker($trackerId);
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        $tracker2 = Admin_DA::getTracker($trackerId);
        $this->assertTrue(is_array($tracker2));
        $this->assertTrue(count($ret));

        //  compare two trackers
        $this->assertEqual($tracker1, $tracker2);

        TestEnv::rollbackTransaction();
    }
    // +---------------------------------------+
    // | placements                            |
    // +---------------------------------------+
    function testGetPlacement()
    {

        TestEnv::startTransaction();
        $id = Admin_DA::addPlacement(array(
            'campaignname' => 'foo',
            'clientid' => rand(1,9999),
            'views' => rand(1,9999),
            'clicks' => rand(1,9999),
            'conversions' => rand(1,9999),
            ));

        $ret = Admin_DA::getPlacement($id);

        // should look like this
        /*
        Array
        (
            [advertiser_id] => 123
            [placement_id] => 1
            [name] => mycampaign
            [active] => t
            [views] => -1
            [clicks] => -1
            [conversions] => -1
            [expire] => 2005-11-01
            [activate] => 0000-00-00
            [priority] => l
            [weight] => 1
            [target_impression] => 0
            [target_click] => 0
            [target_conversion] => 0
            [anonymous] => f
        )
        */
        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret));
        $this->assertTrue(array_key_exists('advertiser_id', $ret));
        $this->assertTrue(array_key_exists('placement_id', $ret));
        $this->assertTrue(array_key_exists('name', $ret));
        $this->assertTrue(array_key_exists('active', $ret));
        $this->assertTrue(array_key_exists('views', $ret));
        $this->assertTrue(array_key_exists('clicks', $ret));
        $this->assertTrue(array_key_exists('conversions', $ret));
        $this->assertTrue(array_key_exists('expire', $ret));
        $this->assertTrue(array_key_exists('activate', $ret));
        $this->assertTrue(array_key_exists('priority', $ret));
        $this->assertTrue(array_key_exists('weight', $ret));
        $this->assertTrue(array_key_exists('target_impression', $ret));
        $this->assertTrue(array_key_exists('target_click', $ret));
        $this->assertTrue(array_key_exists('target_conversion', $ret));
        $this->assertTrue(array_key_exists('anonymous', $ret));

        TestEnv::rollbackTransaction();
    }

    function testGetPlacements()
    {

        TestEnv::startTransaction();

        $id = Admin_DA::addPlacement(array(
            'campaignname' => 'foo',
            'clientid' => rand(1,9999),
            'views' => rand(1,9999),
            'clicks' => rand(1,9999),
            'conversions' => rand(1,9999),
            ));

        $res = Admin_DA::getPlacements(array(
            'placement_id' => $id),
            true);

        $this->assertTrue(is_array($res));
        $this->assertTrue(count($res));

        TestEnv::rollbackTransaction();
    }


    function testDuplicatePlacement()
    {

        TestEnv::startTransaction();

        $placementId = Admin_DA::addPlacement(array(
            'campaignname' => 'foo',
            'clientid' => rand(1,9999),
            'views' => rand(1,9999),
            'clicks' => rand(1,9999),
            'conversions' => rand(1,9999),
            ));
        $this->assertTrue(is_int($placementId));
        $this->assertTrue($placementId > 0);

        $placement1 = Admin_DA::getPlacement($placementId);

        $ret = Admin_DA::duplicatePlacement($placementId);
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        $placement2 = Admin_DA::getPlacement($ret);
        $this->assertTrue(is_array($placement2));
        $this->assertTrue(count($placement2));

        //  compare two placements
        unset($placement1['placement_id']);
        unset($placement2['placement_id']);
        unset($placement1['name']);
        unset($placement2['name']);
        $this->assertEqual($placement1, $placement2);

        TestEnv::rollbackTransaction();
    }
    // +---------------------------------------+
    // | agencies                              |
    // +---------------------------------------+
    function testGetAgency()
    {

        TestEnv::startTransaction();

        $id = Admin_DA::addAgency(array(
            'name' => 'foo',
            'contact' => 'bar',
            'username' => 'user',
            'email' => 'agent@example.com',
            ));

        $ret = Admin_DA::getAgency($id);

        // should look like this
        /*
        Array
        (
            [agency_id] => 1
            [name] => my agency
            [contact] => foo bar
            [email] => foo@example.com
            [username] => Ronald
            [password] => Reagan
            [permissions] => 33
            [language] => chinese
        )
        */
        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret));
        $this->assertTrue(array_key_exists('agency_id', $ret));
        $this->assertTrue(array_key_exists('name', $ret));
        $this->assertTrue(array_key_exists('contact', $ret));
        $this->assertTrue(array_key_exists('email', $ret));

        TestEnv::rollbackTransaction();
    }

    function testGetAgencies()
    {

        TestEnv::startTransaction();

        $id = Admin_DA::addAgency(array(
            'name' => 'foo',
            'contact' => 'bar',
            'username' => 'user',
            'email' => 'agent@example.com',
            ));

        $agencies = Admin_DA::getAgencies(array('agency_id' => $id));
        $this->assertTrue(count($agencies) == 1);
        $aKey = array_keys($agencies);
        $id = $aKey[0];
        $this->assertTrue(is_int($id));
        $this->assertTrue(is_array($agencies[$id]));
        $this->assertTrue(array_key_exists('agency_id', $agencies[$id]));
        $this->assertTrue(array_key_exists('name', $agencies[$id]));

        TestEnv::rollbackTransaction();

    }

    function test_updateAgencyActiveStatus_activate()
    {

        TestEnv::startTransaction();

        // add test agency
        $id = Admin_DA::addAgency(
            array(
                'name' => 'foo',
                'contact' => 'bar',
                'username' => 'user',
                'email' => 'agent@example.com',
                'active' => 0,
                )
            );

        // ACTIVATE AGENCY
        $ret = Admin_DA::_updateAgencyActiveStatus($id, true);

        // test _update did not return an error
        $this->assertFalse(is_a($ret, 'pear_error'));

        // test _update returned true
        $this->assertTrue($ret);

        // get agency active status
        $aAgency = Admin_DA::getAgencies(array('agency_id' => $id));

        // Test return values
        $this->assertTrue(count($aAgency) == 1);
        $this->assertTrue($aAgency[$id]['agency_id'] == $id);
        $this->assertTrue($aAgency[$id]['active'] == 1);

        // Test return keys
        $this->assertTrue(array_key_exists('agency_id', $aAgency[$id]));
        $this->assertTrue(array_key_exists('name', $aAgency[$id]));
        $this->assertTrue(array_key_exists('active', $aAgency[$id]));


        // DEACTIVATE AGENCY
         $ret = Admin_DA::_updateAgencyActiveStatus($id, false);

        // test _update did not return an error
        $this->assertFalse(is_a($ret, 'pear_error'));

        // test _update returned true
        $this->assertTrue($ret);

        // get agency active status
        $aAgency = Admin_DA::getAgencies(array('agency_id' => $id));

        // Test return values
        $this->assertTrue(count($aAgency) == 1);
        $this->assertTrue($aAgency[$id]['agency_id'] == $id);
        $this->assertTrue($aAgency[$id]['active'] == 0);

        // Test return keys
        $this->assertTrue(array_key_exists('agency_id', $aAgency[$id]));
        $this->assertTrue(array_key_exists('name', $aAgency[$id]));
        $this->assertTrue(array_key_exists('active', $aAgency[$id]));

        TestEnv::rollbackTransaction();
    }

    function test_updateAgencyActiveStatus_deactivate()
    {

        TestEnv::startTransaction();

        // add test agency
        $id = Admin_DA::addAgency(
            array(
                'name' => 'foo',
                'contact' => 'bar',
                'username' => 'user',
                'email' => 'agent@example.com',
                'active' => 1,
                )
            );

        // DEACTIVATE AGENCY
         $ret = Admin_DA::_updateAgencyActiveStatus($id, false);

        // test _update did not return an error
        $this->assertFalse(is_a($ret, 'pear_error'));

        // test _update returned true
        $this->assertTrue($ret);

        // get agency active status
        $aAgency = Admin_DA::getAgencies(array('agency_id' => $id));

        // Test return values
        $this->assertTrue(count($aAgency) == 1);
        $this->assertTrue($aAgency[$id]['agency_id'] == $id);
        $this->assertTrue($aAgency[$id]['active'] == 0);

        // Test return keys
        $this->assertTrue(array_key_exists('agency_id', $aAgency[$id]));
        $this->assertTrue(array_key_exists('name', $aAgency[$id]));
        $this->assertTrue(array_key_exists('active', $aAgency[$id]));

        TestEnv::rollbackTransaction();
    }

    function test_updateAgencyActiveStatus_deactivateWhenInactive()
    {

        TestEnv::startTransaction();

        // add test agency
        $id = Admin_DA::addAgency(
            array(
                'name' => 'foo',
                'contact' => 'bar',
                'username' => 'user',
                'email' => 'agent@example.com',
                'active' => 0,
                )
            );

        Pear::pushErrorHandling(null);

        // DEACTIVATE AGENCY
        $ret = Admin_DA::_updateAgencyActiveStatus($id, false);
        // test _update did not return an error
        $this->assertTrue(is_a($ret, 'pear_error'));
        $this->assertTrue($ret->getCode() == MAX_ERROR_NOAFFECTEDROWS);

        Pear::popErrorHandling();


        TestEnv::rollbackTransaction();
    }

    function testGetAgenciesCampaignStats()
    {

        $dbh =& MAX_DB::singleton();
        // INSERT test data
        $agencyId = Admin_DA::addAgency(
            array(
                'name' => 'foo',
                'contact' => 'bar',
                'username' => 'user',
                'email' => 'agent@example.com',
                'active' => 1,
                )
            );
        // Define clients
        $clientsTable = $conf['table']['prefix'] . 'clients';
        $sql = "

        INSERT INTO {$clientsTable} (clientid, agencyid, clientname, contact, email, clientusername, clientpassword, permissions, language, report, reportinterval, reportlastdate, reportdeactivate)
        VALUES
            (1,1,'Test Advertiser 1','James Floyd','james@m3.net','','',0,'english','t',7,'2005-05-10','t'),
            (2,2,'Test Advertiser 2','James Floyd','james@m3.net','','',0,'english','t',7,'2005-05-10','t');";
        $result = $dbh->query($sql);

        // define campaigns
        $campaignTable = $conf['table']['prefix'] . 'campaigns';
        $sql = "INSERT INTO {$campaignTable}(campaignid, campaignname, clientid, views, clicks, conversions, expire, activate, active, priority, weight, target_impression, target_click, target_conversion,  anonymous, companion)
            VALUES
                (1,'Test Advertiser 1 - Default Campaign',1,-1,-1,-1,'2005-06-10','0000-00-00','t',0,1,0,0,0,'f',0),
                (2,'Test Advertiser 1 - Campaign 2',1,-1,-1,-1,'0000-00-00','0000-00-00','t',0,1,0,0,0,'f',0),
                (3,'Test Advertiser 2 - Default Campaign',2,-1,-1,-1,'2005-06-10','0000-00-00','t',0,1,0,0,0,'f',0),
                (4,'Test Advertiser 2 - Campaign 2',2,-1,-1,-1,'0000-00-00','0000-00-00','t',0,1,0,0,0,'f',0)";
        $result = $dbh->query($sql);

        // define ads
        $bannerTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO {$bannerTable} (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype)
            VALUES
                (1,1,'t','gif',0,'sql','468x60.gif','','','',468,60,1,0,'_blank','http://www.google.com','Google','','','','f','',0,0,0,'','',0,0,'','',''),
                (2,2,'t','gif',0,'sql','','','','',0,0,1,0,'','','','','','','t','',0,0,0,'','',0,0,'','','gif'),
                (3,3,'t','gif',0,'sql','468x60.gif','','','',468,60,1,0,'_blank','http://www.google.com','Google','','','','f','',0,0,0,'','',0,0,'','',''),
                (4,4,'t','gif',0,'sql','','','','',0,0,1,0,'','','','','','','t','',0,0,0,'','',0,0,'','','gif')";

        $result = $dbh->query($sql);

        // define stats
        $statsTable = $conf['table']['prefix'] . 'data_summary_ad_hourly';
        $sql = "INSERT INTO {$statsTable}
            (data_summary_ad_hourly_id, day, hour, ad_id, creative_id, zone_id, requests, impressions, clicks, conversions, total_basket_value)
            VALUES
                (1,'2005-05-22',9,1,0,0,0,100,100,0,NULL),
                (2,'2005-05-22',10,1,0,0,0,100,100,0,NULL),
                (3,'2005-05-22',10,2,0,0,0,100,100,0,NULL),
                (4,'2005-05-22',10,3,0,0,0,100,100,0,NULL),
                (5,'2005-05-22',11,1,0,0,0,100,100,0,NULL),
                (6,'2005-05-22',11,2,0,0,0,100,100,0,NULL),
                (7,'2005-05-22',11,3,0,0,0,100,100,0,NULL),
                (8,'2005-05-22',12,1,0,0,0,100,100,0,NULL),
                (9,'2005-05-22',12,2,0,0,0,100,100,0,NULL),
                (10,'2005-05-22',12,3,0,0,0,100,100,0,NULL),
                (11,'2005-05-22',12,4,0,0,0,100,100,0,NULL),
                (12,'2005-05-22',13,1,0,0,0,100,100,0,NULL),
                (13,'2005-05-22',13,2,0,0,0,100,100,0,NULL),
                (14,'2005-05-22',13,3,0,0,0,100,100,0,NULL),
                (15,'2005-05-22',13,4,0,0,0,100,100,0,NULL),
                (16,'2005-05-22',14,1,0,0,0,100,100,0,NULL),
                (17,'2005-05-22',14,2,0,0,0,100,100,0,NULL),
                (18,'2005-05-22',15,1,0,0,0,100,100,0,NULL),
                (19,'2005-05-22',15,2,0,0,0,100,100,0,NULL),
                (20,'2005-05-22',16,1,0,0,0,100,100,0,NULL),
                (21,'2005-05-22',16,2,0,0,0,100,100,0,NULL),
                (22,'2005-05-22',17,1,0,0,0,100,100,0,NULL),
                (23,'2005-05-22',18,1,0,0,0,100,100,0,NULL),
                (24,'2005-05-22',19,1,0,0,0,100,100,0,NULL),
                (25,'2005-05-22',20,1,0,0,0,100,100,0,NULL),
                (26,'2005-05-22',21,1,0,0,0,100,100,0,NULL),
                (27,'2005-05-22',22,1,0,0,0,100,100,0,NULL),
                (28,'2005-05-22',23,1,0,0,0,100,100,0,NULL),
                (29,'2005-05-23',0,1,0,0,0,100,100,0,NULL),
                (30,'2005-05-23',1,1,0,0,0,100,100,0,NULL),
                (31,'2005-05-23',2,1,0,0,0,100,100,0,NULL),
                (32,'2005-05-23',3,1,0,0,0,100,100,0,NULL),
                (33,'2005-05-23',4,1,0,0,0,100,100,0,NULL),
                (34,'2005-05-23',5,1,0,0,0,100,100,0,NULL),
                (35,'2005-05-23',6,1,0,0,0,100,100,0,NULL),
                (36,'2005-05-23',7,1,0,0,0,100,100,0,NULL),
                (37,'2005-05-23',8,1,0,0,0,100,100,0,NULL),
                (38,'2005-05-23',9,1,0,0,0,100,100,0,NULL)";
        $result = $dbh->query($sql);

        // test 1 - get data for a single hour for a singe agency
        $aAgencies = array(1);
        $oStart = new Date('2005-05-22 10:00:00');
        $oEnd = new Date('2005-05-22 10:00:01');
        $aData = Admin_DA::getAgenciesCampaignStats($aAgencies, $oStart, $oEnd);

        $this->assertTrue(count($aData) == 1);
        $this->assertTrue(count($aData['2005-05-22']) == 1);
        $this->assertTrue(count($aData['2005-05-22'][10]) == 1);
        $this->assertTrue(count($aData['2005-05-22'][10][1]) == 2);
        $this->assertTrue($aData['2005-05-22'][10][1]['totalImpressions'] == 200);
        $this->assertTrue($aData['2005-05-22'][10][1]['totalClicks'] == 200);

        // test 1 - get data for a single hour where two agencies defined
        $aAgencies = array(1,2);
        $oStart = new Date('2005-05-22 12:00:00');
        $oEnd = new Date('2005-05-22 12:00:01');
        $aData = Admin_DA::getAgenciesCampaignStats($aAgencies, $oStart, $oEnd);

        $this->assertTrue(count($aData) == 1);
        $this->assertTrue(count($aData['2005-05-22']) == 1);
        $this->assertTrue(count($aData['2005-05-22'][12]) == 2);
        $this->assertTrue(count($aData['2005-05-22'][12][1]) == 2);
        $this->assertTrue($aData['2005-05-22'][12][1]['totalImpressions'] == 200);
        $this->assertTrue($aData['2005-05-22'][12][1]['totalClicks'] == 200);
        $this->assertTrue($aData['2005-05-22'][12][2]['totalImpressions'] == 200);
        $this->assertTrue($aData['2005-05-22'][12][2]['totalClicks'] == 200);

        // basic test of all range
        $aAgencies = array(1,2);
        $oStart = new Date('2005-05-22 09:00:00');
        $oEnd = new Date('2005-05-23 09:00:01');
        $aData = Admin_DA::getAgenciesCampaignStats($aAgencies, $oStart, $oEnd);

        $this->assertTrue(count($aData) == 2);
        $this->assertTrue(count($aData['2005-05-22']) == 15);
        $this->assertTrue(count($aData['2005-05-23']) == 10);

//        print '<pre>'; print_r($aData); print '</pre>';

        TestEnv::rollbackTransaction();
    }

    // +---------------------------------------+
    // | advertisers                           |
    // +---------------------------------------+

    // +---------------------------------------+
    // | ads                                   |
    // +---------------------------------------+
    // FIMXE: do duplicate and add methods
    function testGetAd()
    {

        TestEnv::startTransaction();

        $id = Admin_DA::addAd(array(
            'campaignid' => rand(1, 999),
            'active' => 't',
            'contenttype' => 'gif',
            'pluginversion' => rand(1, 999),
            ));

        $ret = Admin_DA::getAd($id);
        // should look like this
        /*
        Array
        (
            [ad_id] => 1
            [placement_id] => 234234
            [active] => t
            [name] => desc
            [type] => sql
            [contenttype] => gif
            [pluginversion] => 1
            [filename] => sdfasdf
            [imageurl] => http://img.com
            [htmltemplate] => foo
            [htmlcache] => bar
            [width] => 5
            [height] => 6
            [weight] => 3
            [seq] => 1
            [target] =>
            [url] => http://localhost/phpMyAdmin/
            [alt] =>
            [status] =>
            [bannertext] => asdasdfad
            [autohtml] => t
            [adserver] =>
            [block] => 0
            [capping] => 0
            [session_capping] => 0
            [compiledlimitation] => asdfasdf
            [append] => asdfasdf
            [appendtype] => 1
            [bannertype] => 2
            [alt_filename] =>
            [alt_imageurl] =>
            [alt_contenttype] => gif
        )
        */
        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret));
        $this->assertTrue(array_key_exists('ad_id', $ret));
        $this->assertTrue(array_key_exists('placement_id', $ret));
        $this->assertTrue(array_key_exists('active', $ret));
        $this->assertTrue(array_key_exists('name', $ret));
        $this->assertTrue(array_key_exists('type', $ret));
        $this->assertTrue(array_key_exists('contenttype', $ret));
        $this->assertTrue(array_key_exists('pluginversion', $ret));
        $this->assertTrue(array_key_exists('filename', $ret));
        $this->assertTrue(array_key_exists('imageurl', $ret));
        $this->assertTrue(array_key_exists('htmltemplate', $ret));
        $this->assertTrue(array_key_exists('htmlcache', $ret));
        $this->assertTrue(array_key_exists('width', $ret));
        $this->assertTrue(array_key_exists('height', $ret));
        $this->assertTrue(array_key_exists('weight', $ret));
        $this->assertTrue(array_key_exists('seq', $ret));
        $this->assertTrue(array_key_exists('target', $ret));
        $this->assertTrue(array_key_exists('url', $ret));
        $this->assertTrue(array_key_exists('alt', $ret));
        $this->assertTrue(array_key_exists('status', $ret));
        $this->assertTrue(array_key_exists('bannertext', $ret));
        $this->assertTrue(array_key_exists('autohtml', $ret));
        $this->assertTrue(array_key_exists('adserver', $ret));
        $this->assertTrue(array_key_exists('block', $ret));
        $this->assertTrue(array_key_exists('capping', $ret));
        $this->assertTrue(array_key_exists('session_capping', $ret));
        $this->assertTrue(array_key_exists('compiledlimitation', $ret));
        $this->assertTrue(array_key_exists('append', $ret));
        $this->assertTrue(array_key_exists('appendtype', $ret));
        $this->assertTrue(array_key_exists('bannertype', $ret));
        $this->assertTrue(array_key_exists('alt_filename', $ret));
        $this->assertTrue(array_key_exists('alt_imageurl', $ret));
        $this->assertTrue(array_key_exists('alt_contenttype', $ret));

        TestEnv::rollbackTransaction();
    }

    // +---------------------------------------+
    // | zones                                 |
    // +---------------------------------------+
    function testAddZone()
    {
        $name = & new Text_Password();

        TestEnv::startTransaction();

        $ret = Admin_DA::addZone(array(
            'publisher_id' => rand(1, 999),
            'type' => rand(0, 4),
            'name' => $name->create(),
            ));
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        TestEnv::rollbackTransaction();
    }

    function testGetZone()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh  =&MAX_DB::singleton();

        TestEnv::startTransaction();

        $id = Admin_DA::addZone(
            array(
                'publisher_id' => rand(1, 999),
                'type' => rand(0, 4),
                'name' => 'quux',
            )
        );
        $this->assertTrue(is_int($id));
        $this->assertTrue($id > 0);

        // Get zone record as control element
        $query = 'SELECT * FROM '.$conf['table']['prefix'].'zones WHERE zoneid = ' . $id;
        $aZone1 = $dbh->getRow($query);
        $this->assertTrue(is_array($aZone1));

        // Massage results so as to be comparable with Admin_DA::getZone()
        Admin_DA::_switch($aZone1, 'affiliateid', 'publisher_id');
        Admin_DA::_switch($aZone1, 'zonename', 'name');
        Admin_DA::_switch($aZone1, 'delivery', 'type');
        Admin_DA::_switch($aZone1, 'zoneid', 'zone_id');
        unset($aZone1['zonetype']);
        unset($aZone1['updated']);
        $aZone1 = array_filter($aZone1, 'strlen');
        $aZone2 = Admin_DA::getZone($id);

        /*
        Array
        (
            [zone_id] => 80
            [publisher_id] => 508
            [name] => toufreacli
            [type] => 3
            [description] =>
            [width] => 0
            [height] => 0
            [chain] =>
            [prepend] =>
            [append] =>
            [appendtype] => 0
            [forceappend] => f
            [inventory_forecast_type] => 0
        )
        */

        $this->assertTrue(is_array($aZone2));
        $this->assertTrue(count($aZone2) > 0);
        $this->assertTrue(array_key_exists('zone_id', $aZone2));
        $this->assertTrue(array_key_exists('publisher_id', $aZone2));
        $this->assertTrue(array_key_exists('name', $aZone2));
        $this->assertTrue(array_key_exists('type', $aZone2));
        $this->assertTrue(array_key_exists('description', $aZone2));
        $this->assertTrue(array_key_exists('width', $aZone2));
        $this->assertTrue(array_key_exists('height', $aZone2));
        $this->assertTrue(array_key_exists('chain', $aZone2));
        $this->assertTrue(array_key_exists('prepend', $aZone2));
        $this->assertTrue(array_key_exists('append', $aZone2));
        $this->assertTrue(array_key_exists('appendtype', $aZone2));
        $this->assertTrue(array_key_exists('forceappend', $aZone2));
        $this->assertTrue(array_key_exists('inventory_forecast_type', $aZone2));
        $this->assertTrue(array_key_exists('comments', $aZone2));
        $this->assertTrue(array_key_exists('cost', $aZone2));
        $this->assertTrue(array_key_exists('cost_type', $aZone2));
        $this->assertTrue(array_key_exists('cost_variable_id', $aZone2));
        $this->assertTrue(array_key_exists('technology_cost', $aZone2));
        $this->assertTrue(array_key_exists('technology_cost_type', $aZone2));
        $this->assertTrue(array_key_exists('block', $aZone2));
        $this->assertTrue(array_key_exists('capping', $aZone2));
        $this->assertTrue(array_key_exists('session_capping', $aZone2));

        $aZone2 = array_filter($aZone2, 'strlen');
        $this->assertEqual($aZone1, $aZone2);

        TestEnv::rollbackTransaction();
    }

    //  FIXME: why does getZones() have a v. different return type
    //  from getZone()?
    function testGetZones()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh =& MAX_DB::singleton();
        TestEnv::startTransaction();

        $ret = Admin_DA::addZone(
            array(
                'publisher_id' => rand(1, 999),
                'type' => rand(0, 4),
                'name' => 'quux',
            )
        );
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        //  get zone record as control element
        $query = 'SELECT * FROM '.$conf['table']['prefix'].'zones WHERE zoneid = ' . $ret;
        $aZone1 = $dbh->getRow($query);
        $this->assertTrue(is_array($aZone1));

        //  massage results so as to be comparable with Admin_DA::getZone()
        Admin_DA::_switch($aZone1, 'affiliateid', 'publisher_id');
        Admin_DA::_switch($aZone1, 'zonename', 'name');
        Admin_DA::_switch($aZone1, 'delivery', 'type');
        Admin_DA::_switch($aZone1, 'zoneid', 'zone_id');
        unset($aZone1['zonetype']);
        unset($aZone1['appendtype']);
        unset($aZone1['forceappend']);
        unset($aZone1['inventory_forecast_type']);
        unset($aZone1['height']);
        unset($aZone1['width']);
        unset($aZone1['updated']);
        unset($aZone1['block']);
        unset($aZone1['capping']);
        unset($aZone1['session_capping']);
        $aZone1 = array_filter($aZone1, 'strlen');

        $aZone2 = Admin_DA::getZones(array('zone_id' => $ret));
        /*
        Array
        (
            [80] => Array
                (
                    [zone_id] => 80
                    [publisher_id] => 508
                    [name] => toufreacli
                    [type] => 3
                )

        )
        */
        $this->assertTrue(is_array($aZone2[$ret]));
        $this->assertEqual($aZone1, $aZone2[$ret]);

        TestEnv::rollbackTransaction();
    }

    function testDuplicateZone()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh =& MAX_DB::singleton();
        TestEnv::startTransaction();

        $id = Admin_DA::addZone(array(
            'publisher_id' => rand(1, 999),
            'type' => rand(0, 4),
            'name' => 'quux',
            ));
        $this->assertTrue(is_int($id));
        $this->assertTrue($id > 0);

        //  get zone record as control element
        $query = 'SELECT * FROM '.$conf['table']['prefix'].'zones WHERE zoneid = ' . $id;
        $aZone1 = $dbh->getRow($query);
        $this->assertTrue(is_array($aZone1));


        $ret = Admin_DA::duplicateZone($id);
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        $query = 'SELECT * FROM '.$conf['table']['prefix'].'zones WHERE zoneid = ' . $ret;
        $aZone2 = $dbh->getRow($query);
        $this->assertTrue(is_array($aZone2));

        //  unset zoneid and name as these are unique
        unset($aZone1['zoneid']);
        unset($aZone2['zoneid']);
        unset($aZone1['zonename']);
        unset($aZone2['zonename']);
        $this->assertEqual($aZone1, $aZone2);

        TestEnv::rollbackTransaction();
    }

    function testAddCategory()
    {
        $name = & new Text_Password();

        TestEnv::startTransaction();

        $ret = Admin_DA::addCategory(array('name' => $name->create()));
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        TestEnv::rollbackTransaction();
    }

    function testAddAdCategory()
    {

        TestEnv::startTransaction();

        $ret = Admin_DA::addAdCategory(array('ad_id' => 1, 'category_id' => 2));
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        TestEnv::rollbackTransaction();
    }

    function testAddAdZone()
    {

        TestEnv::startTransaction();

        $this->_generateStats();
        $ret = Admin_DA::addAdZone(array('zone_id' => 1, 'ad_id' => 1));
        $this->assertTrue(is_int($ret));
        $this->assertTrue($ret > 0);

        TestEnv::rollbackTransaction();
    }

    function testDeleteImage()
    {
        //  this test fails on the _getLimitations and the method
        //  also doesn't seem to be called anywhere

#        TestEnv::startTransaction();
#        $ret = Admin_DA::_deleteEntity('image', 1);
    }

    // +---------------------------------------+
    // | Test helper methods                   |
    // |                                       |
    // +---------------------------------------+
    function test_Switch()
    {
        $input = array(
            'fooName' => 'fooValue',
            'barName' => 'barValue');
        $name = 'fooName';
        $legacyName = 'replacedFooName';
        $output = $input;
        Admin_DA::_switch($output, $name, $legacyName);

        //  determine that the desired field name has been removed
        $this->assertTrue(!array_key_exists($name, $output));

        //  determine that the legacy name has been inserted
        $this->assertTrue(array_key_exists($legacyName, $output));

        //  make sure extra keys not altered
        $this->assertTrue(array_key_exists('barName', $output));

        //  make sure existing value has new key
        $this->assertEqual('fooValue', $output[$legacyName]);

        //  assert key swapped successfully
        $this->assertEqual($input[$name], $output[$legacyName]);
    }


    //  the 3rd arg to any DA call sets the key value of the returned array
    //  this tests that all possible  keys are set correctly
    function testReturnByColumnType()
    {

        TestEnv::startTransaction();

        $id = Admin_DA::addPlacement(array(
            'campaignname' => 'foo',
            'clientid' => rand(1,9999),
            'views' => rand(1,9999),
            'clicks' => rand(1,9999),
            'conversions' => rand(1,9999),
            ));

        $ret = Admin_DA::getPlacements(array(
            'placement_id' => $id),
            true);
        $stats = each($ret);
        foreach ($stats[1] as $k => $v) {
            $tmp = Admin_DA::getPlacements(array(
                'placement_id' => $id),
                true,
                $k);
            $resKey = each($tmp);
            $this->assertEqual($resKey['key'], $v);
        }

        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret));

        TestEnv::rollbackTransaction();
    }

    function test_getUniqueName()
    {
        $entities = array();
        for ($x = 0; $x < 20; $x++) {
            $entities[] = array('name' => 'foo_' . $x);
        }
        $control = array('name' => 'foo_7');
        $orig = $control;
        Admin_DA::_getUniqueName($control, $entities, 'copy');
        $this->assertTrue(is_array($control));
        $this->assertTrue(array_key_exists('name', $control));
        $this->assertNotEqual($orig, $control);
    }

    // +---------------------------------------+
    // | Test cache methods                    |
    // |                                       |
    // +---------------------------------------+

    function testFromCacheGetPlacements()
    {

        TestEnv::startTransaction();

        $id = Admin_DA::addPlacement(array(
            'campaignname' => 'foo',
            'clientid' => rand(1,9999),
            'views' => rand(1,9999),
            'clicks' => rand(1,9999),
            'conversions' => rand(1,9999),
            ));

        $ret = Admin_DA::fromCache('getPlacements', array(
            'placement_id' => $id));
        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret));

        $stats = each($ret);
        $this->assertTrue(array_key_exists('advertiser_id', $stats[1]));
        $this->assertTrue(array_key_exists('placement_id', $stats[1]));
        $this->assertTrue(array_key_exists('name', $stats[1]));
        $this->assertTrue(array_key_exists('active', $stats[1]));

        TestEnv::rollbackTransaction();
    }

    function testFromCacheGetPlacement()
    {

        TestEnv::startTransaction();

        $id = Admin_DA::addPlacement(array(
            'campaignname' => 'foo',
            'clientid' => rand(1,9999),
            'views' => rand(1,9999),
            'clicks' => rand(1,9999),
            'conversions' => rand(1,9999),
            ));

        $res = Admin_DA::fromCache('getPlacement', $id);
        $this->assertTrue(is_array($res));
        $this->assertTrue(count($res));

        TestEnv::rollbackTransaction();
    }

    // +---------------------------------------+
    // | Test stats methods                    |
    // |                                       |
    // +---------------------------------------+
    function testGetPlacementsStats()
    {

        TestEnv::startTransaction();

        $this->_generateStats();
        $ret = Admin_DA::getPlacementsStats(array('advertiser_id' => 1));
        $this->assertTrue(is_array($ret));

        $stats = each($ret);

        /*
        Array
        (
            [advertiser_id] => 1
            [placement_id] => 1
            [name] => test  campaign
            [active] => t
            [num_children] => 1
            [sum_requests] => 13009
            [sum_views] => 9439
            [sum_clicks] => 14123
            [sum_conversions] => 11575
        )
        */

        $this->assertTrue(array_key_exists('sum_requests', $stats[1]));
        $this->assertTrue(array_key_exists('sum_views', $stats[1]));
        $this->assertTrue(array_key_exists('sum_clicks', $stats[1]));
        $this->assertTrue(array_key_exists('sum_conversions', $stats[1]));

        TestEnv::rollbackTransaction();
    }

    function testGetPlacementsStatsTwoParams()
    {

        TestEnv::startTransaction();

        $this->_generateStats();
        $ret = Admin_DA::getPlacementsStats(array('advertiser_id' => 1, 'placement_id' => 1));
        $this->assertTrue(is_array($ret));

        $stats = each($ret);
        $this->assertTrue(array_key_exists('sum_requests', $stats[1]));
        $this->assertTrue(array_key_exists('sum_views', $stats[1]));
        $this->assertTrue(array_key_exists('sum_clicks', $stats[1]));
        $this->assertTrue(array_key_exists('sum_conversions', $stats[1]));

        TestEnv::rollbackTransaction();
    }

    function testGetAdvertisersStats()
    {

        TestEnv::startTransaction();

        $this->_generateStats();
        $ret = Admin_DA::getAdvertisersStats(array('agency_id' => 1));
        $this->assertTrue(is_array($ret));

        $stats = each($ret);
        $this->assertTrue(array_key_exists('sum_requests', $stats[1]));
        $this->assertTrue(array_key_exists('sum_views', $stats[1]));
        $this->assertTrue(array_key_exists('sum_clicks', $stats[1]));
        $this->assertTrue(array_key_exists('sum_conversions', $stats[1]));

        TestEnv::rollbackTransaction();
    }

    function testGetPublishersStats()
    {

        TestEnv::startTransaction();

        $this->_generateStats();
        $ret = Admin_DA::getPublishersStats(array('agency_id' => 1));
        $this->assertTrue(is_array($ret));

        $stats = each($ret);
        $this->assertTrue(array_key_exists('sum_requests', $stats[1]));
        $this->assertTrue(array_key_exists('sum_views', $stats[1]));
        $this->assertTrue(array_key_exists('sum_clicks', $stats[1]));
        $this->assertTrue(array_key_exists('sum_conversions', $stats[1]));

        TestEnv::rollbackTransaction();
    }

    function testGetZonesStats()
    {

        TestEnv::startTransaction();

        $this->_generateStats();
        $ret = Admin_DA::getZonesStats(array('publisher_id' => 1));
        $this->assertTrue(is_array($ret));

        $stats = each($ret);
        $this->assertTrue(array_key_exists('sum_requests', $stats[1]));
        $this->assertTrue(array_key_exists('sum_views', $stats[1]));
        $this->assertTrue(array_key_exists('sum_clicks', $stats[1]));
        $this->assertTrue(array_key_exists('sum_conversions', $stats[1]));

        TestEnv::rollbackTransaction();
    }

    function testGetAdsStats()
    {

        TestEnv::startTransaction();

        $this->_generateStats();
        $ret = Admin_DA::getAdsStats(array('placement_id' => 1));
        $this->assertTrue(is_array($ret));

        $stats = each($ret);
        $this->assertTrue(array_key_exists('sum_requests', $stats[1]));
        $this->assertTrue(array_key_exists('sum_views', $stats[1]));
        $this->assertTrue(array_key_exists('sum_clicks', $stats[1]));
        $this->assertTrue(array_key_exists('sum_conversions', $stats[1]));

        TestEnv::rollbackTransaction();
    }

    // +---------------------------------------+
    // | Test cache stats methods              |
    // |                                       |
    // +---------------------------------------+
    //  all stats come from data_summary_ad_hourly
    function testFromCacheGetPlacementsStats()
    {

        TestEnv::startTransaction();

        $this->_generateStats();

        $ret = Admin_DA::fromCache('getPlacementsStats', array('advertiser_id' => 1));
        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret));
        $stats = each($ret);
        $this->assertTrue(array_key_exists('sum_requests', $stats[1]));
        $this->assertTrue(array_key_exists('sum_views', $stats[1]));
        $this->assertTrue(array_key_exists('sum_clicks', $stats[1]));
        $this->assertTrue(array_key_exists('sum_conversions', $stats[1]));

        TestEnv::rollbackTransaction();
    }

    function testFromCacheGetAdvertisersStats()
    {

        TestEnv::startTransaction();

        $this->_generateStats();

        $res = Admin_DA::fromCache('getAdvertisersStats', array('agency_id' => 1));
        $this->assertTrue(is_array($res));
        $this->assertTrue(count($res));

        TestEnv::rollbackTransaction();
    }

    function testFromCacheGetPublishersStats()
    {

        TestEnv::startTransaction();

        $this->_generateStats();

        $res = Admin_DA::fromCache('getPublishersStats', array('agency_id' => 1));
        $this->assertTrue(is_array($res));
        $this->assertTrue(count($res));

        TestEnv::rollbackTransaction();
    }

    function testFromCacheGetZonesStats()
    {

        TestEnv::startTransaction();

        $this->_generateStats();

        $res = Admin_DA::fromCache('getZonesStats', array('publisher_id' => 1));
        $this->assertTrue(is_array($res));
        $this->assertTrue(count($res));

        TestEnv::rollbackTransaction();
    }

    function testFromCacheGetAdsStats()
    {
        TestEnv::startTransaction();

        $this->_generateStats();

        $res = Admin_DA::fromCache('getAdsStats', array('placement_id' => 1));
        $this->assertTrue(is_array($res));
        $this->assertTrue(count($res));

        TestEnv::rollbackTransaction();
    }

    function _generateStats()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh =& MAX_DB::singleton();
        // Populate data_summary_ad_hourly
        $statsTable = $conf['table']['prefix'] . 'data_summary_ad_hourly';
        for ($hour = 0; $hour < 24; $hour ++) {
            $sql = "INSERT INTO $statsTable
                (   data_summary_ad_hourly_id,
                    day,
                    hour,
                    ad_id,
                    creative_id,
                    zone_id,
                    requests,
                    impressions,
                    clicks,
                    conversions,
                    total_basket_value
                )
                VALUES(
                '',
                NOW(),
                $hour,
                1, -- banner id
                ".rand(1, 999).",
                ".rand(1, 999).",
                ".rand(1, 999).",
                ".rand(1, 999).",
                ".rand(1, 999).",
                ".rand(1, 999).",
                0
                )";
            $result = $dbh->query($sql);
        }

        // Populate campaigns table
        $campaignsTable = $conf['table']['prefix'] . 'campaigns';
        $sql = "
            INSERT INTO
                $campaignsTable
                    (
                        campaignid,
                        campaignname,
                        clientid,
                        views,
                        clicks,
                        conversions,
                        expire,
                        activate,
                        active,
                        priority,
                        weight,
                        target_impression,
                        target_click,
                        target_conversion,
                        anonymous,
                        companion
                    )
                VALUES
                    (
                        1,
                        'test campaign',
                        1,
                        477,
                        788,
                        34,
                        '0000-00-00',
                        '0000-00-00',
                        't',
                        '1',
                        1,
                        0,
                        0,
                        0,
                        'f',
                        1
                    )";
        $result = $dbh->query($sql);

        // Add a banner
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "
            INSERT INTO
                $bannersTable
                    (
                        bannerid,
                        campaignid,
                        active,
                        contenttype,
                        pluginversion,
                        storagetype,
                        filename,
                        imageurl,
                        htmltemplate,
                        htmlcache,
                        width,
                        height,
                        weight,
                        seq,
                        target,
                        url,
                        alt,
                        status,
                        bannertext,
                        description,
                        autohtml,
                        adserver,
                        block,
                        capping,
                        session_capping,
                        compiledlimitation,
                        append,
                        appendtype,
                        bannertype,
                        alt_filename,
                        alt_imageurl,
                        alt_contenttype
                    )
                VALUES
                    (
                        1,
                        1,
                        't',
                        'gif',
                        0,
                        'web',
                        'test.gif',
                        '',
                        '',
                        '',
                        468,
                        60,
                        1,
                        0,
                        '',
                        'http://exapmle.com',
                        '',
                        'asdf',
                        'tyerterty',
                        '',
                        'f',
                        '',
                        0,
                        0,
                        0,
                        'phpAds_aclCheckDate(\'20050502\', \'!=\') and phpAds_aclCheckClientIP(\'2.22.22.2\', \'!=\') and phpAds_aclCheckLanguage(\'(sq)|(eu)|(fo)|(fi)\', \'!=\')',
                        '',
                        0,
                        0,
                        '',
                        '',
                        ''
                    )";
        $result = $dbh->query($sql);

        // Add an agency record
        $agencyTable = $conf['table']['prefix'] . 'agency';
        $sql = "INSERT INTO $agencyTable ( `agencyid` , `name` , `contact` , `email` , `username` , `password` , `permissions` , `language` , `logout_url` , `active`)  VALUES (1, 'test agency', 'sdfsdfsdf', 'demian@phpkitchen.com', 'Demian Turner', '', 0, '', 'logout.com', 1)";
        $result = $dbh->query($sql);

        // Add a client record (advertiser)
        $clientsTable = $conf['table']['prefix'] . 'clients';
        $sql = "
            INSERT INTO
                $clientsTable
                    (
                        clientid,
                        agencyid,
                        clientname,
                        contact,
                        email,
                        clientusername,
                        clientpassword,
                        permissions,
                        language,
                        report,
                        reportinterval,
                        reportlastdate,
                        reportdeactivate
                    )
                VALUES
                    (
                        1,
                        1,
                        'test client',
                        'yes',
                        'demian@phpkitchen.com',
                        'Demian Turner',
                        '',
                        59,
                        '',
                        't',
                        7,
                        '2005-03-21',
                        't'
                    )";
        $result = $dbh->query($sql);

        // Add an affiliate (publisher) record
        $publisherTable = $conf['table']['prefix'] . 'affiliates';
        $sql = "
            INSERT INTO
                $publisherTable
                    (
                        affiliateid,
                        agencyid,
                        name,
                        mnemonic,
                        contact,
                        email,
                        website,
                        username,
                        password,
                        permissions,
                        language,
                        publiczones
                    )
                VALUES
                    (
                        1,
                        1,
                        'test publisher',
                        'ABC',
                        'foo bar',
                        'foo@example.com',
                        'www.example.com',
                        'foo',
                        'bar',
                        NULL,
                        NULL,
                        'f'
                    )";
        $result = $dbh->query($sql);

        // Add zone record
        $zonesTable = $conf['table']['prefix'] . 'zones';
        $sql = "
            INSERT INTO
                $zonesTable
                    (
                        zoneid,
                        affiliateid,
                        zonename,
                        description,
                        delivery,
                        zonetype,
                        category,
                        width,
                        height,
                        ad_selection,
                        chain,
                        prepend,
                        append,
                        appendtype,
                        forceappend,
                        inventory_forecast_type
                    )
                VALUES
                    (
                        1,
                        1,
                        'Demian Turner - Default',
                        '',
                        0,
                        3,
                        '',
                        468,
                        60,
                        1,
                        1,
                        '',
                        '',
                        0,
                        'f',
                        0
                    )";
        $result = $dbh->query($sql);
    }

}

?>
