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


require_once MAX_PATH.'/lib/OA/Upgrade/DB_UpgradeAuditor.php';
require_once MAX_PATH.'/lib/OA/Upgrade/tests/integration/BaseUpgradeAuditor.up.test.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    Openads Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 */

class Test_OA_DB_UpgradeAuditor extends Test_OA_BaseUpgradeAuditor
{ 
    var $path;

    /**
     * The constructor method.
     */
    function Test_OA_DB_UpgradeAuditor()
    {
        $this->Test_OA_BaseUpgradeAuditor();
        $this->path = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        
        
        $this->aAuditParams[0][0] = array('info1'=>'UPGRADE STARTED',
                              'action'=>DB_UPGRADE_ACTION_UPGRADE_STARTED,
                             );
        $this->aAuditParams[0][1] = array('info1'=>'BACKUP STARTED',
                              'action'=>DB_UPGRADE_ACTION_BACKUP_STARTED,
                             );
        $this->aAuditParams[0][2] = array('info1'=>'copied table',
                              'tablename'=>'test_table1',
                              'tablename_backup'=>'test_table_bak1',
                              'table_backup_schema'=>serialize($this->_getFieldDefinitionArray(1)),
                              'action'=>DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED,
                             );
        $this->aAuditParams[0][3] = array('info1'=>'BACKUP COMPLETE',
                              'action'=>DB_UPGRADE_ACTION_BACKUP_SUCCEEDED,
                             );
        $this->aAuditParams[0][4] = array('info1'=>'UPGRADE SUCCEEDED',
                              'action'=>DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                             );

        $this->aAuditParams[1][0] = array('info1'=>'UPGRADE STARTED',
                              'action'=>DB_UPGRADE_ACTION_UPGRADE_STARTED,
                             );
        $this->aAuditParams[1][1] = array('info1'=>'BACKUP STARTED',
                              'action'=>DB_UPGRADE_ACTION_BACKUP_STARTED,
                             );
        $this->aAuditParams[1][2] = array('info1'=>'copied table',
                              'tablename'=>'test_table2',
                              'tablename_backup'=>'test_table_bak2',
                              'table_backup_schema'=>serialize($this->_getFieldDefinitionArray(2)),
                              'action'=>DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED,
                             );
        $this->aAuditParams[1][3] = array('info1'=>'BACKUP COMPLETE',
                              'action'=>DB_UPGRADE_ACTION_BACKUP_SUCCEEDED,
                             );
        $this->aAuditParams[1][4] = array('info1'=>'UPGRADE SUCCEEDED',
                              'action'=>DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                             );
    }

    function test_constructor()
    {
        $oAuditor = new OA_DB_UpgradeAuditor();
        $this->assertNotNull($oAuditor->logTable);
    }

    function test_init()
    {
        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');
        $this->_dropAuditTable($oAuditor->prefix.$oAuditor->logTable);
        $this->assertTrue($oAuditor->init($oAuditor->oDbh),'failed to initialise upgrade auditor');
        $aDBTables = $oAuditor->oDbh->manager->listTables();
        $this->assertTrue(in_array($oAuditor->prefix.$oAuditor->logTable, $aDBTables));
    }

    /**
     * test that param array is set
     * test that param values are quoted
     *
     */
    function test_setKeyParams()
    {
        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');
        $oAuditor->setKeyParams(array(
                                        'string'=>'test_tables',
                                        'integer'=>10,
                                        'escape'=>"openad's value",
                                     )
                               );
        $this->assertEqual($oAuditor->aParams['string'],'\'test_tables\'','wrong param value: string');
        $this->assertEqual($oAuditor->aParams['integer'],10,'wrong param value: integer');
        $this->assertEqual($oAuditor->aParams['escape'],"'openad\'s value'",'wrong param value: escape');
    }

    function test_createAuditTable()
    {
        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');
        $this->_dropAuditTable($oAuditor->prefix.$oAuditor->logTable);
        $this->assertTrue($oAuditor->_createAuditTable(),'failed to createAuditTable');
        $aDBTables = $oAuditor->oDbh->manager->listTables();
        $this->assertTrue(in_array($oAuditor->prefix.$oAuditor->logTable, $aDBTables));
    }

    function test_checkCreateAuditTable()
    {
        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');
        $this->_dropAuditTable($oAuditor->prefix.$oAuditor->logTable);
        // test1 : table does not exist, should create table
        $this->assertTrue($oAuditor->_checkCreateAuditTable(),'failed to createAuditTable');
        $aDBTables = $oAuditor->oDbh->manager->listTables();
        $this->assertTrue(in_array($oAuditor->prefix.$oAuditor->logTable, $aDBTables));
        // test2 : table does exist, should return true
        $this->assertTrue($oAuditor->_checkCreateAuditTable(),'');
    }
    

    function test_logAuditAction()
    {
        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');
    	$this->_test_logDBAuditAction($oAuditor);
		
    }

    function test_queryAuditByDBUpgradeId()
    {
        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');

        $aResult = $oAuditor->queryAuditByDBUpgradeId(1);
        $this->assertIsa($aResult,'array','not an array');
        $this->assertEqual(count($aResult),1,'incorrect number of elements');
    }

    function test_queryAuditByUpgradeId()
    {
        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');

        $aResult = $oAuditor->queryAuditByUpgradeId(1);
        $this->assertIsa($aResult,'array','not an array');
        $this->assertEqual(count($aResult),5,'incorrect number of elements');
        $aAuditKeyParams = $this->_getDBAuditKeyParamsArray();
        $aAuditParams = $this->aAuditParams[0];
        foreach ($aResult AS $k=>$v)
        {
            $this->assertEqual($v['schema_name'],$aAuditKeyParams['schema_name'],'wrong schema name for audit query result '.$k);
            $this->assertEqual($v['version'],$aAuditKeyParams['version'],'wrong version for audit query result '.$k);
            $this->assertEqual($v['timing'],$aAuditKeyParams['timing'],'wrong timing for audit query result '.$k);
            $this->assertEqual($v['action'],$aAuditParams[$k]['action'],'wrong action for audit query result '.$k);
            $this->assertEqual($v['info1'],$aAuditParams[$k]['info1'],'wrong info1 for audit query result '.$k);
            $this->assertTrue(strtotime($v['updated']),'timestamp','invalid timestamp for audit query result '.$k);
            $aDate = getdate(strtotime($v['updated']));
            $aNow = getdate(strtotime(date('Y-m-d')));
            $this->assertEqual($aDate['year'],$aNow['year'],'wrong year in updated field for audit query result '.$k);
            $this->assertEqual($aDate['mon'],$aNow['mon'],'wrong month in updated field for audit query result '.$k);
            $this->assertEqual($aDate['mday'],$aNow['mday'],'wrong day in updated field for audit query result '.$k);
            if (array_key_exists('info2',$aAuditParams[$k]))
            {
                $this->assertEqual($v['info2'],$aAuditParams[$k]['info2'],'wrong info2 for audit query result '.$k);
            }
            else
            {
                $this->assertNull($v['info2'],'info2 should be null for audit query result '.$k);
            }
            if (array_key_exists('tablename',$aAuditParams[$k]))
            {
                $this->assertEqual($v['tablename'],$aAuditParams[$k]['tablename'],'wrong tablename for audit query result '.$k);
            }
            else
            {
                $this->assertNull($v['tablename'],'tablename should be null for audit query result '.$k);
            }
            if (array_key_exists('tablename_backup',$aAuditParams[$k]))
            {
                $this->assertEqual($v['tablename_backup'],$aAuditParams[$k]['tablename_backup'],'wrong tablename_backup for audit query result '.$k);
            }
            else
            {
                $this->assertNull($v['tablename_backup'],'tablename_backup should be null for audit query result '.$k);
            }
            if (array_key_exists('table_backup_schema',$aAuditParams[$k]))
            {
                $aExpected = $this->_getFieldDefinitionArray(1);
                $aActual   = unserialize($v['table_backup_schema']);
                $this->assertEqual($v['table_backup_schema'],$aAuditParams[$k]['table_backup_schema'],'wrong table_backup_schema for audit query result '.$k);
                $this->assertTrue(isset($aActual['test_table1']),'test table definition not found in unserialised table_backup_schema for audit query result '.$k);
                $this->assertTrue(isset($aActual['test_table1']['fields']),'test table definition fields not found in unserialised table_backup_schema for audit query result '.$k);
                $this->assertEqual($aActual['test_table1']['fields']['type'],$aExpected['test_table1']['fields']['type'],'test table definition field type incorrect unserialised table_backup_schema for audit query result '.$k);
                $this->assertEqual($aActual['tetest_table1st']['fields']['length'],$aExpected['test_table1']['fields']['length'],'test table definition field type incorrect unserialised table_backup_schema for audit query result '.$k);
                $this->assertTrue(isset($aActual['test_table1']['indexes']),'test table definition fields not found in unserialised table_backup_schema for audit query result '.$k);
                $this->assertEqual($aActual['test_table1']['indexes']['primary'],$aExpected['test_table1']['indexes']['primary'],'test table definition field type incorrect unserialised table_backup_schema for audit query result '.$k);
            }
            else
            {
                $this->assertNull($v['table_backup_schema'],'table_backup_schema should be null for audit query result '.$k);
            }
        }
    }

    function test_queryAuditBackupTablesByUpgradeId()
    {
        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');

        $aResult = $oAuditor->queryAuditBackupTablesByUpgradeId(1);
        $this->assertIsa($aResult,'array','audit table query result is not an array');
        $this->assertEqual(count($aResult),1,'incorrect number of elements');
    }

    function test_updateAuditBackupDroppedById()
    {
        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');
        $this->assertTrue($oAuditor->updateAuditBackupDroppedById(3, 'dropped by test'),'error updating backup table (dropped) audit record');
        $aResult = $oAuditor->queryAuditBackupTablesByUpgradeId(1);
        $this->assertIsa($aResult,'array','not an array');
        $this->assertEqual(count($aResult),0,'incorrect number of elements');
        $aResult = $oAuditor->queryAuditByDBUpgradeId(3);
        $this->assertEqual(DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED, $aResult[0]['action'], 'wrong action');
        $this->assertEqual(1, $aResult[0]['upgrade_action_id'], 'wrong audit id');
        $this->assertEqual(3, $aResult[0]['database_action_id'], 'wrong db audit id');
        $this->assertEqual('test_table1',$aResult[0]['tablename'],'wrong tablename_backup for audit query result');
        $this->assertEqual('test_table_bak1',$aResult[0]['tablename_backup'],'wrong tablename_backup for audit query result');
        $this->assertEqual('dropped by test', $aResult[0]['info2'], 'wrong reason');
    }

    function test_getTableStatus()
    {
        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');
        $aResult = $oAuditor->getTableStatus('database_action');
        $this->assertIsa($aResult,'array','not an array');
        $this->assertEqual(count($aResult),1,'incorrect number of elements');
        $this->assertEqual($aResult[0]['rows'],'10','incorrect rows');
        $this->assertEqual($aResult[0]['auto_increment'],'11','incorrect auto_increment value');
        $this->assertTrue($aResult[0]['data_length'],'incorrect data length');
    }

// DEPRECATED METHODS
//    function test_queryAuditAll()
//    {
//        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');
//        $aAuditKeyParams = $this->_getAuditKeyParamsArray();
//        $aAuditParams = $this->_getAuditParamsArray();
//        $aResult = $oAuditor->queryAuditAll();
//        $this->assertIsa($aResult,'array','audit table query all result is not an array');
//        $this->assertEqual(count($aResult),5,'incorrect number of elements on audit query result');
//        foreach ($aResult AS $k=>$v)
//        {
//            $this->assertEqual($v['schema_name'],$aAuditKeyParams['schema_name'],'wrong schema name for audit query result '.$k);
//            $this->assertEqual($v['version'],$aAuditKeyParams['version'],'wrong version for audit query result '.$k);
//            $this->assertEqual($v['timing'],$aAuditKeyParams['timing'],'wrong timing for audit query result '.$k);
//            $this->assertEqual($v['action'],$aAuditParams[$k]['action'],'wrong action for audit query result '.$k);
//            $this->assertEqual($v['info1'],$aAuditParams[$k]['info1'],'wrong info1 for audit query result '.$k);
//            $this->assertTrue(strtotime($v['updated']),'timestamp','invalid timestamp for audit query result '.$k);
//            $aDate = getdate(strtotime($v['updated']));
//            $aNow = getdate(strtotime(date('Y-m-d')));
//            $this->assertEqual($aDate['year'],$aNow['year'],'wrong year in updated field for audit query result '.$k);
//            $this->assertEqual($aDate['mon'],$aNow['mon'],'wrong month in updated field for audit query result '.$k);
//            $this->assertEqual($aDate['mday'],$aNow['mday'],'wrong day in updated field for audit query result '.$k);
//            if (array_key_exists('info2',$aAuditParams[$k]))
//            {
//                $this->assertEqual($v['info2'],$aAuditParams[$k]['info2'],'wrong info2 for audit query result '.$k);
//            }
//            else
//            {
//                $this->assertNull($v['info2'],'info2 should be null for audit query result '.$k);
//            }
//            if (array_key_exists('tablename',$aAuditParams[$k]))
//            {
//                $this->assertEqual($v['tablename'],$aAuditParams[$k]['tablename'],'wrong tablename for audit query result '.$k);
//            }
//            else
//            {
//                $this->assertNull($v['tablename'],'tablename should be null for audit query result '.$k);
//            }
//            if (array_key_exists('tablename_backup',$aAuditParams[$k]))
//            {
//                $this->assertEqual($v['tablename_backup'],$aAuditParams[$k]['tablename_backup'],'wrong tablename_backup for audit query result '.$k);
//            }
//            else
//            {
//                $this->assertNull($v['tablename_backup'],'tablename_backup should be null for audit query result '.$k);
//            }
//            if (array_key_exists('table_backup_schema',$aAuditParams[$k]))
//            {
//                $aExpected = $this->_getFieldDefinitionArray();
//                $aActual   = unserialize($v['table_backup_schema']);
//                $this->assertEqual($v['table_backup_schema'],$aAuditParams[$k]['table_backup_schema'],'wrong table_backup_schema for audit query result '.$k);
//                $this->assertTrue(isset($aActual['test']),'test table definition not found in unserialised table_backup_schema for audit query result '.$k);
//                $this->assertTrue(isset($aActual['test']['fields']),'test table definition fields not found in unserialised table_backup_schema for audit query result '.$k);
//                $this->assertEqual($aActual['test']['fields']['type'],$aExpected['test']['fields']['type'],'test table definition field type incorrect unserialised table_backup_schema for audit query result '.$k);
//                $this->assertEqual($aActual['test']['fields']['length'],$aExpected['test']['fields']['length'],'test table definition field type incorrect unserialised table_backup_schema for audit query result '.$k);
//                $this->assertTrue(isset($aActual['test']['indexes']),'test table definition fields not found in unserialised table_backup_schema for audit query result '.$k);
//                $this->assertEqual($aActual['test']['indexes']['primary'],$aExpected['test']['indexes']['primary'],'test table definition field type incorrect unserialised table_backup_schema for audit query result '.$k);
//            }
//            else
//            {
//                $this->assertNull($v['table_backup_schema'],'table_backup_schema should be null for audit query result '.$k);
//            }
//        }
//    }
//
//    function test_queryAudit()
//    {
//        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');
//        $aKeyParams = $this->_getDBAuditKeyParamsArray();
//
//        $version = $aKeyParams['version'];
//        $timing  = $aKeyParams['timing'];
//        $schema  = $aKeyParams['schema_name'];
//
//        $aResult = $oAuditor->queryAudit($version, $timing, $schema);
//        $this->assertIsa($aResult,'array','audit table query result is not an array');
//        $this->assertEqual(count($aResult),5,'incorrect number of elements on audit query result');
//
//        $aResult = $oAuditor->queryAudit($version, $timing, $schema, DB_UPGRADE_ACTION_UPGRADE_STARTED);
//        $this->assertIsa($aResult,'array','audit table query result is not an array');
//        $this->assertEqual(count($aResult),1,'incorrect number of elements on audit query result: '.DB_UPGRADE_ACTION_UPGRADE_STARTED);
//        $this->assertEqual($aResult[0]['action'],DB_UPGRADE_ACTION_UPGRADE_STARTED,'wrong action for audit query result');
//
//        $aResult = $oAuditor->queryAudit($version, $timing, $schema, DB_UPGRADE_ACTION_BACKUP_STARTED);
//        $this->assertIsa($aResult,'array','audit table query result is not an array');
//        $this->assertEqual(count($aResult),1,'incorrect number of elements on audit query result: '.DB_UPGRADE_ACTION_BACKUP_STARTED);
//        $this->assertEqual($aResult[0]['action'],DB_UPGRADE_ACTION_BACKUP_STARTED,'wrong action for audit query result');
//
//        $aResult = $oAuditor->queryAudit($version, $timing, $schema, DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED);
//        $this->assertIsa($aResult,'array','audit table query result is not an array');
//        $this->assertEqual(count($aResult),1,'incorrect number of elements on audit query result: '.DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED);
//        $this->assertEqual($aResult[0]['action'],DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED,'wrong action for audit query result');
//
//        $aResult = $oAuditor->queryAudit($version, $timing, $schema, DB_UPGRADE_ACTION_BACKUP_SUCCEEDED);
//        $this->assertIsa($aResult,'array','audit table query result is not an array');
//        $this->assertEqual(count($aResult),1,'incorrect number of elements on audit query result: '.DB_UPGRADE_ACTION_BACKUP_SUCCEEDED);
//        $this->assertEqual($aResult[0]['action'],DB_UPGRADE_ACTION_BACKUP_SUCCEEDED,'wrong action for audit query result');
//
//        $aResult = $oAuditor->queryAudit($version, $timing, $schema, DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED);
//        $this->assertIsa($aResult,'array','audit table query result is not an array');
//        $this->assertEqual(count($aResult),1,'incorrect number of elements on audit query result: '.DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED);
//        $this->assertEqual($aResult[0]['action'],DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED,'wrong action for audit query result');
//    }
//
//    function test_queryAuditForABackup()
//    {
//        $oAuditor = $this->_getAuditObject();
//
//        $aResult = $oAuditor->queryAuditForABackup('test_table_bak');
//        $this->assertIsa($aResult,'array','audit table query result is not an array');
//        $this->assertEqual(count($aResult),1,'incorrect number of elements on audit backup query result');
//        $this->assertEqual($aResult[0]['tablename_backup'],'test_table_bak','wrong tablename_backup for audit query result');
//    }
//
//    function test_updateAuditBackupDroppedByName()
//    {
//        $oAuditor = $this->_getAuditObject();
//        $this->assertTrue($oAuditor->updateAuditBackupDroppedByName('test_table_bak'),'error updating backup table (dropped) audit record');
//        $aResult = $oAuditor->queryAuditForABackup('test_table_bak');
//        $this->assertIsa($aResult,'array','audit table query result is not an array');
//        $this->assertEqual(count($aResult),0,'incorrect number of elements on audit backup query result');
//        $this->assertNotEqual($aResult[0]['tablename_backup'],'test_table_bak','wrong tablename_backup for audit query result');
//    }

//    function _getAuditParamsArray()
//    {
//        $aAudit[0][0] = array('info1'=>'UPGRADE STARTED',
//                              'action'=>DB_UPGRADE_ACTION_UPGRADE_STARTED,
//                             );
//        $aAudit[0][1] = array('info1'=>'BACKUP STARTED',
//                              'action'=>DB_UPGRADE_ACTION_BACKUP_STARTED,
//                             );
//        $aAudit[0][2] = array('info1'=>'copied table',
//                              'tablename'=>'test_table',
//                              'tablename_backup'=>'test_table_bak',
//                              'table_backup_schema'=>serialize($this->_getFieldDefinitionArray()),
//                              'action'=>DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED,
//                             );
//        $aAudit[0][3] = array('info1'=>'BACKUP COMPLETE',
//                              'action'=>DB_UPGRADE_ACTION_BACKUP_SUCCEEDED,
//                             );
//        $aAudit[0][4] = array('info1'=>'UPGRADE SUCCEEDED',
//                              'action'=>DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED,
//                             );
//
//        $aAudit[1][0] = array('info1'=>'UPGRADE STARTED',
//                              'action'=>DB_UPGRADE_ACTION_UPGRADE_STARTED,
//                             );
//        $aAudit[1][1] = array('info1'=>'BACKUP STARTED',
//                              'action'=>DB_UPGRADE_ACTION_BACKUP_STARTED,
//                             );
//        $aAudit[1][2] = array('info1'=>'copied table',
//                              'tablename'=>'test_table',
//                              'tablename_backup'=>'test_table_bak',
//                              'table_backup_schema'=>serialize($this->_getFieldDefinitionArray()),
//                              'action'=>DB_UPGRADE_ACTION_BACKUP_TABLE_COPIED,
//                             );
//        $aAudit[1][3] = array('info1'=>'BACKUP COMPLETE',
//                              'action'=>DB_UPGRADE_ACTION_BACKUP_SUCCEEDED,
//                             );
//        $aAudit[1][4] = array('info1'=>'UPGRADE SUCCEEDED',
//                              'action'=>DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED,
//                             );
//        return $aAudit;
//    }

/*
seems to be a problem with LIKE in an MDB2 query
works in phpMyAdmin on MySQL 5.0.22 but not via this routine
*/
    function test_listBackups()
    {
        $oAuditor = $this->_getAuditObject('OA_DB_UpgradeAuditor');
        $oTable = new OA_DB_Table();
        $oTable->init($this->path.'schema_test_backups.xml');
        $this->assertTrue($oTable->createTable('z_test1'),'error creating test backup z_test1');
        $this->assertTrue($oTable->createTable('z_test2'),'error creating test backup z_test2');
        $this->assertTrue($oTable->createTable('z_test3'),'error creating test backup z_test3');
        $aExistingTables = $oTable->oDbh->manager->listTables();
        $this->assertTrue(in_array($oAuditor->prefix.'z_test1', $aExistingTables), '_listBackups');
        $this->assertTrue(in_array($oAuditor->prefix.'z_test2', $aExistingTables), '_listBackups');
        $this->assertTrue(in_array($oAuditor->prefix.'z_test3', $aExistingTables), '_listBackups');

        $aBackupTables = $oAuditor->_listBackups();
        $this->assertIsA($aBackupTables,'array','backup array not an array');
        $this->assertEqual(count($aBackupTables),3,'wrong number of backups found in database: expected 3 got '.count($aBackupTables));
    }
    

}

?>
