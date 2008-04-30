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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing DB_DataObjectsCommon
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DB_DataObjectCommonTest extends DalUnitTestCase
{
    /**
     * The constructor method.
     */
    function DB_DataObjectCommonTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        DataGenerator::cleanUp(
            array('agency', 'clients')
        );
    }

    function tearDown()
    {
        // assuming that all test data was created by DataGenerator
        // If it is necessary to recreate entire database we still could do it on the end
        // of each test by calling TestEnv::restoreEnv();
        //DataGenerator::cleanUp(array('banners'));
    }

    function testFactoryDAL()
    {
        $doClients = OA_Dal::factoryDO('clients');
        $dalClients = $doClients->factoryDAL();
        $this->assertIsA($dalClients, 'MAX_Dal_Common');
    }

    function testSetDefaultValue()
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');

        // Test 1 : Date Values

        $doCampaigns->expire = $doCampaigns->setDefaultValue('expire',6);
        $this->assertEqual($doCampaigns->expire,OA_Dal::noDateValue());

        $doCampaigns->activate = $doCampaigns->setDefaultValue('activate',6);
        $this->assertEqual($doCampaigns->expire,OA_Dal::noDateValue());

        $doCampaigns->updated = $doCampaigns->setDefaultValue('updated',6);
        $this->assertTrue(OA_Dal::isValidDate($doCampaigns->updated));
        $this->assertTrue(time()-strtotime($doCampaigns->updated) < 10, 'elapsed time exceeds margin of 10 seconds');
    }

    function testGetAll()
    {
        // test it returns empty array when no data
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $aCheck = $doCampaigns->getAll();
        $this->assertEqual($aCheck, array());

        // Insert campaigns with default data
        // and few additional records required for testing filters
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = $campaignName = 'test name';
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $aCampaignId = $dg->generate($doCampaigns, 2, true);
        $clientId = DataGenerator::getReferenceId('clients');

        $aCampaignId2 = $dg->generate('campaigns', 2, true);
        $clientId2 = DataGenerator::getReferenceId('clients');

        // test getting all records
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $aCheck = $doCampaigns->getAll();
        $this->assertEqual(count($aCheck), 4);

        $doCampaignsFilter = OA_Dal::factoryDO('campaigns');
        $doCampaignsFilter->clientid = $clientId;

        // test filtering and test that rows are not indexed by primary key
        $doCampaigns = clone($doCampaignsFilter);
        $aCheck = $doCampaigns->getAll();
        $this->assertEqual(count($aCheck), count($aCampaignId));
        $this->assertEqual(array_keys($aCheck), array(0, 1));

        // test indexing with primary keys
        $doCampaigns = clone($doCampaignsFilter);
        $aCheck = $doCampaigns->getAll(array(), $indexWithPrimaryKey = true);
        $aTest = array_keys($aCheck);
        sort($aTest);
        $this->assertEqual($aCampaignId, $aTest);
        foreach ($aCheck as $check) {
            $this->assertEqual($check['campaignname'], $campaignName);
        }

        // test flattening if only one field
        $doCampaigns = clone($doCampaignsFilter);
        $aCheck = $doCampaigns->getAll(array('campaignname'), $indexWithPrimaryKey = false, $flatten = true);
        foreach ($aCheck as $check) {
            $this->assertEqual($check, $campaignName);
        }
        // test that we don't have to use array if only one field is set
        $doCampaigns = clone($doCampaignsFilter);
        $aCheck2 = $doCampaigns->getAll('campaignname', $indexWithPrimaryKey = false, $flatten = true);
        $this->assertEqual($aCheck, $aCheck2);

        // test we could index by any field - not only by primary key
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $aCheck = $doCampaigns->getAll('campaignname', $indexBy = 'clientid', $flatten = true);
        $this->assertEqual(count($aCheck), 2);
        $this->assertEqual(array_keys($aCheck), array($clientId, $clientId2));
    }

    function testBelongsToAccount()
    {
        // Create dummy user
        $aUser = array(
            'contact_name' => 'contact',
            'email_address' => 'email@example.com',
            'username' => 'dummy'.rand(1,1000),
            'password' => 'password',
            'default_account_id' => 222,
        );
        $doUser = OA_Dal::factoryDO('users');
        $doUser->setFrom($aUser);
        $doUser->insert();

        // Test that user belong to itself
        $doAgencyInsert = OA_Dal::factoryDO('agency');
        $agencyid = DataGenerator::generateOne($doAgencyInsert);
        $doAgency = OA_Dal::staticGetDO('agency', $agencyid);
        $aUser = array(
            'contact_name' => 'contact',
            'email_address' => 'email@example.com',
            'username' => 'username'.rand(1,1000),
            'password' => 'password',
            'default_account_id' => $doAgency->account_id,
        );
        $userId = $doAgency->createUser($aUser);
        $this->assertTrue($doAgency->belongsToAccount($doAgency->account_id));
        $this->assertFalse($doAgency->belongsToAccount(222));

        // Create necessary test data
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyid;
        $doClients->reportlastdate = '2007-04-03 18:39:45';
        $clientId = DataGenerator::generateOne($doClients);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $clientId;
        $campaignId = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $campaignId;
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $bannerId = DataGenerator::generateOne($doBanners, true);

        // Test dependency on one level
        $doClients = OA_Dal::staticGetDO('clients', $clientId);
        $this->assertTrue($doClients->belongsToAccount($doAgency->account_id));
        $this->assertFalse($doClients->belongsToAccount(222));

        // Test dependency on two and more levels
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertTrue($doCampaigns->belongsToAccount($doClients->account_id));
        $this->assertFalse($doCampaigns->belongsToAccount(222));

        $doBanners = OA_Dal::staticGetDO('banners', $bannerId);
        $this->assertTrue($doBanners->belongsToAccount($doAgency->account_id));
        $this->assertFalse($doBanners->belongsToAccount(222));

        // Test that belongsToUser() will find and fetch data by itself
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->bannerid = $bannerId;
        $this->assertTrue($doBanners->belongsToAccount($doAgency->account_id));
        $this->assertFalse($doBanners->belongsToAccount(222));

        DataGenerator::cleanUp(array('banners'));
    }

    function testAddReferenceFilter()
    {
        // Create test data
        $agencyId1 = DataGenerator::generateOne('agency');
        $agencyId2 = DataGenerator::generateOne('agency');

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId1;
        $doClients->reportlastdate = '2007-04-03 18:39:45';
        $clientId1 = DataGenerator::generateOne($doClients);

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId2;
        $doClients->reportlastdate = '2007-04-03 18:39:45';
        $clientId2 = DataGenerator::generateOne($doClients);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $clientId1;
        $campaignId = DataGenerator::generate($doCampaigns, 2);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $clientId2;
        $campaignId = DataGenerator::generate($doCampaigns, 3);

        // Test all
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $this->assertEqual($doCampaigns->find(), 5);

        // Test filter by $agencyId1
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->addReferenceFilter('agency', $agencyId1);
        $this->assertEqual($doCampaigns->find(), 2);

        // Test filter by agency and client (should be the same as agency alone)
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->addReferenceFilter('agency', $agencyId1);
        $doCampaigns->addReferenceFilter('clients', $clientId1);
        $this->assertEqual($doCampaigns->find(), 2);

        // Test by clientId2
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->addReferenceFilter('clients', $clientId2);
        $this->assertEqual($doCampaigns->find(), 3);

        // Test that filtering by agencyId1 and clientId2 should give 0
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->addReferenceFilter('agency', $agencyId1);
        $doCampaigns->addReferenceFilter('clients', $clientId2);
        $this->assertEqual($doCampaigns->find(), 0);
    }

    function testAddListOrderBy()
    {
        // very quick test
        $data = array(
            'name' => array('name 1', 'name 2')
        );
        $dg = new DataGenerator();
        $dg->setData('agency', $data);
        $dg->generate('agency', 2);

        // Test that its found data and sorted in ASCendently
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->addListOrderBy('name', 'down');
        $aAgency = $doAgency->getAll('name');
        rsort($data['name']);
        $this->assertEqual($aAgency, $data['name']);

        // Test that its found data and sorted in DESCendently
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->addListOrderBy('name', 'up');
        $aAgency = $doAgency->getAll('name');
        sort($data['name']);
        $this->assertEqual($aAgency, $data['name']);
    }

    function testGetTableWithoutPrefix()
    {
        $table = 'agency';
        $doAgency = OA_Dal::factoryDO($table);
        $this->assertEqual($doAgency->getTableWithoutPrefix(), $table);

        $prefix = 'abc';
        $doAgency->_prefix = $prefix;
        $doAgency->__table = $prefix.$table;
        $this->assertEqual($doAgency->getTableWithoutPrefix(), $table);
    }

    function testGetUniqueValuesFromColumn()
    {
        $data = array(
            'name' => array(1, 1, 2, 2, 3) // 3 unique
        );
        $dg = new DataGenerator();
        $dg->setData('agency', $data);
        $dg->generate('agency', 5);

        // Test that it takes 3 unique variables
        $doAgency = OA_Dal::factoryDO('agency');
        $aUnique = $doAgency->getUniqueValuesFromColumn('name');
        $this->assertEqual($aUnique, array(1,2,3));

        $doAgency = OA_Dal::factoryDO('agency');
        $aUnique = $doAgency->getUniqueValuesFromColumn('name', $exceptValue = 2);
        $this->assertEqual(array_values($aUnique), array(1,3));
    }

    function testGetUniqueNameForDuplication()
    {
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = $name = 'test name';
        $agencyId = DataGenerator::generateOne($doAgency);

        // Test first duplication
        $doAgency = OA_Dal::staticGetDO('agency', $agencyId);
        $uniqueName = $doAgency->getUniqueNameForDuplication('name');
        $this->assertEqual($uniqueName, $name.' (2)');

        // Add that unique name to database
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = $uniqueName;
        DataGenerator::generateOne($doAgency);

        // Test second duplication
        $doAgency = OA_Dal::staticGetDO('agency', $agencyId);
        $uniqueName = $doAgency->getUniqueNameForDuplication('name');
        $this->assertEqual($uniqueName, $name.' (3)');
    }

    function testDeleteById()
    {
        // Create few records
        $aAgencyId = DataGenerator::generate('agency', 3);
        $agencyId = array_pop($aAgencyId);

        // Delete one
        $doAgency = OA_Dal::factoryDO('agency');
        $ret = $doAgency->deleteById($agencyId);
        $this->assertEqual($ret, 1); // one deleted

        // Test its deleted
        $doAgency = OA_Dal::factoryDO('agency');
        $aTestAgencyId = $doAgency->getAll('agencyid');
        $this->assertEqual(array_values($aTestAgencyId), array_values($aAgencyId));

        // Try to delete non-existing one
        $doAgency = OA_Dal::factoryDO('agency');
        PEAR::pushErrorHandling(null); // The operation would generate error message otherwise
        $ret = $doAgency->deleteById(null);
        PEAR::popErrorHandling();
        $this->assertFalse($ret);
    }

    /**
     * Test delete() and deleteOnCascade()
     *
     */
    function testDelete()
    {
        DataGenerator::cleanUp(array('audit'));
        // Create few records
        $aAgencyId = DataGenerator::generate('agency', 3);
        $agencyId = array_pop($aAgencyId);

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->reportlastdate = '2007-04-03 18:39:45';
        $aClientId1 = DataGenerator::generate($doClients, 2);

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId;
        $doClients->reportlastdate = '2007-04-03 18:39:45';
        $aClientId2 = DataGenerator::generate($doClients, 2);

        $doAgency = OA_Dal::staticGetDO('agency', $agencyId);
        // Test that onDeleteCascade is set
        $this->assertTrue($doAgency->onDeleteCascade);

        // Delete one agency
        $doAgency->delete();

        // Test that agency was deleted
        $doAgency = OA_Dal::factoryDO('agency');
        $aAgencyIdTest = $doAgency->getAll('agencyid');
        $this->assertEqual(array_values($aAgencyId), $aAgencyIdTest);
        // Test that associated clients were deleted as well
        $doClients = OA_Dal::factoryDO('clients');
        $aClientId1Test = $doClients->getAll('clientid');
        $this->assertEqual($aClientId1, $aClientId1Test); // only two should left
        DataGenerator::cleanUp(array('audit'));
    }

    function testUpdate()
    {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $bannerId1 = DataGenerator::generateOne($doBanners, true);
        $doBanners1 = OA_Dal::staticGetDO('banners', $bannerId1);

        // Update
        $comments = 'comments updated';
        $doBanners = OA_Dal::staticGetDO('banners', $bannerId1);
        $doBanners->comments = $comments;
        $time = time();
        // wait 1s
        sleep(1);
        $doBanners->update();

        $doBanners2 = OA_Dal::staticGetDO('banners', $bannerId1);

        // Test that it should update time automatically
        $this->assertTrue($doBanners2->refreshUpdatedFieldIfExists);

        // Test that comment was changed
        $this->assertNotEqual($doBanners1->comments, $doBanners2->comments);

        // Test that "updated" was updated
        $this->assertTrue(strtotime($doBanners1->updated) <= strtotime($doBanners2->updated));

        // Test updates is equal or greater than our checkpoint time
        $this->assertTrue($time <= strtotime($doBanners2->updated), 'Test that timestamp was refreshed (timestamp: '.$time.' is lower than ' . strtotime($doBanners2->updated));

        DataGenerator::cleanUp(array('banners'));
    }

    function testInsert()
    {
        $time = time();
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->comments = $comments = 'test123';
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $bannerId = DataGenerator::generateOne($doBanners, true);

        $doBanners = OA_Dal::staticGetDO('banners', $bannerId);

        // Test comment is the same
        $this->assertEqual($doBanners->comments, $comments);

        // Test updates is equal or greater than our checkpoint time
        $this->assertTrue($time <= strtotime($doBanners->updated));

        // Test slashes
        $string = "some slashes ' ' \' \\";
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->comments = $string;
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $bannerId = DataGenerator::generateOne($doBanners);

        $doBannersCheck = OA_Dal::staticGetDO('banners', $bannerId);
        $this->assertEqual($string, $doBannersCheck->comments);

        DataGenerator::cleanUp(array('banners'));
    }

    function testGetFirstPrimaryKey()
    {
        $doBanners = OA_Dal::factoryDO('banners');
        $key = $doBanners->getFirstPrimaryKey();
        $this->assertEqual($key, 'bannerid');
    }

    function testConnection()
    {
        $dbh = &OA_DB::singleton();

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->count();

        // First let's check if global object still keeps the correct reference
        global $_DB_DATAOBJECT;
        $dbh1 = &$_DB_DATAOBJECT['CONNECTIONS'][$doBanners->_database_dsn_md5];
        $this->assertReference($dbh, $dbh1);

        // Now take the connection from DataObject
        $dbh1 =& $doBanners->getDatabaseConnection();
        $this->assertIdentical($dbh, $dbh1);

        // But why this one doesn't work?
        // $this->assertReference($dbh, $dbh1);
    }

    function testAutoincrementsVsSerial()
    {
        $prefix = OA_Dal::getTablePrefix();
        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($prefix.'ad_category_assoc');
        $sqlInsert = "INSERT INTO {$table} (category_id, ad_id) VALUES (1, 1)";
        DBC::execute($sqlInsert);

        // Take generated primary key
        $doAd_category_assoc = OA_Dal::factoryDO('ad_category_assoc');
        $doAd_category_assoc->find($aufetch = true);
        $id1 = $doAd_category_assoc->ad_category_assoc_id;

        // Now lets generate new record using DataGenerator
        $id2 = DataGenerator::generateOne('ad_category_assoc');

        // Not only above code should work but also id2 should be equal id1+1
        $this->assertEqual($id2, $id1+1);
    }

    function testPrepAuditArray()
    {
        Mock::generatePartial(
            'DB_DataObjectCommon',
            $mockDo = 'DB_DataObjectCommon'.rand(),
            array('_cloneObjectFromDatabase')
        );

        $oDoOld = new $mockDo($this);
        $oDoOld->_database_dsn_md5 = 8888888;
        $oDoOld->_tableName = 'table1';
        $oDoOld->col1 = 111;
        $oDoOld->col2 = 'abc';
        $oMockDbh = new stdClass();
        $oMockDbh->database_name = 'dbtest';
        $aTable = array('col1'=>129,'col2'=>130);
        global $_DB_DATAOBJECT;
        $_DB_DATAOBJECT['CONNECTIONS'][$oDoOld->_database_dsn_md5] = $oMockDbh;
        $_DB_DATAOBJECT['INI'][$oMockDbh->database_name][$oDoOld->_tableName] = $aTable;

        // prepare *insert* audit values
        $aResult = $oDoOld->_prepAuditArray(1, null);
        $this->assertIsA($aResult, 'array');
        $this->assertEqual($aResult['col1'],111);
        $this->assertEqual($aResult['col2'],'abc');

        $oDoNew = clone($oDoOld);
        $oDoNew->col1 = 222;
        $oDoNew->col2 = 'def';

        $oDo = clone($oDoOld);
        $oDo->setReturnValue('_cloneObjectFromDatabase', $oDoNew);
        $oDo->_tableName = 'table1';

        // prepare *update* audit values
        $aResult = $oDo->_prepAuditArray(2, $oDoOld);
        $this->assertIsA($aResult, 'array');
        $this->assertEqual($aResult['col1']['was'],111);
        $this->assertEqual($aResult['col2']['was'],'abc');
        $this->assertEqual($aResult['col1']['is'],222);
        $this->assertEqual($aResult['col2']['is'],'def');

        // prepare *delete* audit values
        $oDo = clone($oDoNew);
        $oDo->_tableName = 'table1';
        $aResult = $oDo->_prepAuditArray(3, null);
        $this->assertIsA($aResult, 'array');
        $this->assertEqual($aResult['col1'],222);
        $this->assertEqual($aResult['col2'],'def');
    }

    function testAudit()
    {
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = true;

        Mock::generatePartial(
            'DB_DataObjectCommon',
            $mockDO = 'DB_DataObjectCommon'.rand(),
            array('_prepAuditArray','_buildAuditArray','_auditEnabled','insert','_getContext','_getContextId','getOwningAccountIds')
        );

        $oDO = new $mockDO($this);
        $aPrep = array('col1'=>111,'col2'=>'abc');
        $oDO->setReturnValue('_prepAuditArray', $aPrep);
        $oDO->expectOnce('_prepAuditArray');
        $oDO->setReturnValue('_buildAuditArray', null);
        $oDO->expectOnce('_buildAuditArray');
        $oDO->setReturnValue('_auditEnabled', true);
        $oDO->expectOnce('_auditEnabled');
        $oDO->setReturnValue('_getContextId', 2);
        $oDO->expectOnce('_getContextId');
        $oDO->setReturnValue('getOwningAccountIds', array(OA_ACCOUNT_MANAGER => 0));
        $oDO->expectOnce('getOwningAccountIds');

        $oDO->_tableName = $oDO->__table = 'table1';
        $oDO->col1 = 111;
        $oDO->col2 = 'abc';

        $oDO->doAudit = new $mockDO($oDO);
        $oDO->doAudit->setReturnValue('insert', 1);
        $oDO->doAudit->expectOnce('insert');

        $oDO->audit(1, null);

        $this->assertEqual($oDO->doAudit->actionid, 1);
        $this->assertEqual($oDO->doAudit->context, $oDO->_tableName);
        $this->assertEqual($oDO->doAudit->contextid, 2);
        $this->assertEqual(unserialize($oDO->doAudit->details), $aPrep);

        $oDO->tally();
        $oDO->doAudit->tally();
    }


    function testFormatValue()
    {
        $dbObject = new DB_DataObjectCommon();
        $dbObject->someValue = true;

        $valueType = array('booleanVar' => array('val' => true, 'type' => 145, 'expected' => 'true'),
                            'intVar1' => array('val' => 123, 'type' => 1, 'expected' => '123'),
                            'intVar2' => array('val' => 234, 'type' => 129, 'expected' => '234'),
                            'blobVar1'=> array('val' => '<p>12345</p>', 'type'=> 194, 'expected' => '&lt;p&gt;12345&lt;/p&gt;'),
                            'blobVar2'=> array('val' => '<p>012345</p>', 'type' => 66, 'expected' => '&lt;p&gt;012345&lt;/p&gt;'));

        foreach ($valueType as $name => $arr) {
            $dbObject->$name = $arr['val'];
            $result = $dbObject->_formatValue($name, $arr['type']);
            $this->assertNotNull($result, "Assert not null for field $name failed");
            $this->assertEqual($arr['expected'], $result, "Assert equals for field $name failed: got $result");
        }
    }


    function testBoolToStr()
    {
        $this->assertEqual(DB_DataObjectCommon::_boolToStr('t'),'true');
        $this->assertEqual(DB_DataObjectCommon::_boolToStr('1'),'true');
        $this->assertEqual(DB_DataObjectCommon::_boolToStr(1),'true');
        $this->assertEqual(DB_DataObjectCommon::_boolToStr(true),'true');
        $this->assertEqual(DB_DataObjectCommon::_boolToStr('true'),'true');

        $this->assertEqual(DB_DataObjectCommon::_boolToStr('f'),'false');
        $this->assertEqual(DB_DataObjectCommon::_boolToStr('0'),'false');
        $this->assertEqual(DB_DataObjectCommon::_boolToStr(0),'false');
        $this->assertEqual(DB_DataObjectCommon::_boolToStr(false),'false');
        $this->assertEqual(DB_DataObjectCommon::_boolToStr('false'),'false');
    }

}
