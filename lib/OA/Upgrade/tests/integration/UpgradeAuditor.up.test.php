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
$Id $
*/

require_once MAX_PATH.'/lib/OA/Upgrade/DB_UpgradeAuditor.php';
require_once MAX_PATH.'/lib/OA/Upgrade/UpgradeAuditor.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    Openads Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 */
class Test_OA_UpgradeAuditor extends UnitTestCase
{
    var $path;

    var $oDBAuditor;

    /**
     * The constructor method.
     */
    function Test_OA_UpgradeAuditor()
    {
        $this->UnitTestCase();
        $this->path = MAX_PATH.'/lib/OA/Upgrade/tests/data/';

        Mock::generatePartial(
            'OA_DB_UpgradeAuditor',
            $mockDBAud = 'OA_DB_UpgradeAuditor'.rand(),
            array('mergeConfig','setupConfigDatabase','setupConfigTable','writeConfig','getConfigBackupName')
        );
        $this->oDBAuditor = new $mockDBAud($this);
    }

    function test_constructor()
    {
        $oAuditor = new OA_UpgradeAuditor();
        $this->assertNotNull($oAuditor->logTable);
    }

    function test_init()
    {
        $oAuditor = $this->_getAuditObject();
        $this->_dropAuditTable($oAuditor->prefix.$oAuditor->logTable);
        $this->assertTrue($oAuditor->init($oAuditor->oDbh, '', $this->oDBAuditor),'failed to initialise upgrade auditor');
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
        $oAuditor = $this->_getAuditObject();
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
        $oAuditor = $this->_getAuditObject();
        $this->_dropAuditTable($oAuditor->prefix.$oAuditor->logTable);
        $this->assertTrue($oAuditor->_createAuditTable(),'failed to createAuditTable');
        $aDBTables = $oAuditor->oDbh->manager->listTables();
        $this->assertTrue(in_array($oAuditor->prefix.$oAuditor->logTable, $aDBTables));
    }

    function test_checkCreateAuditTable()
    {
        $oAuditor = $this->_getAuditObject();
        $this->_dropAuditTable($oAuditor->prefix.$oAuditor->logTable);
        // test1 : table does not exist, should create table
        $this->assertTrue($oAuditor->_checkCreateAuditTable(),'failed to createAuditTable');
        $aDBTables = $oAuditor->oDbh->manager->listTables();
        $this->assertTrue(in_array($oAuditor->prefix.$oAuditor->logTable, $aDBTables));
        // test2 : table does exist, should return true
        $this->assertTrue($oAuditor->_checkCreateAuditTable(),'');
    }

    function test_logUpgradeAction()
    {
        $oAuditor = $this->_getAuditObject();
        $oAuditor->setKeyParams($this->_getAuditKeyParamsArray());
        $aAuditParams = $this->_getAuditParamsArray();
        $this->assertTrue($oAuditor->logUpgradeAction($aAuditParams[0]),'');
        $this->assertTrue($oAuditor->logUpgradeAction($aAuditParams[1]),'');
    }

    function test_queryAuditAll()
    {
        $oAuditor = $this->_getAuditObject();
        $aAuditKeyParams = $this->_getAuditKeyParamsArray();
        $aAuditParams = $this->_getAuditParamsArray();
        $aResult = $oAuditor->queryAuditAll();
        $this->assertIsa($aResult,'array','audit table query all result is not an array');
        $this->assertEqual(count($aResult),2,'incorrect number of elements on audit query result');
        foreach ($aResult AS $k=>$v)
        {
            $this->assertEqual($v['upgrade_name'],$aAuditKeyParams['upgrade_name'],'wrong upgrade name for audit query result '.$k);
            $this->assertEqual($v['version_to'],$aAuditKeyParams['version_to'],'wrong version_to for audit query result '.$k);
            $this->assertEqual($v['version_from'],$aAuditKeyParams['version_from'],'wrong version_from for audit query result '.$k);
            $this->assertEqual($v['logfile'],$aAuditKeyParams['logfile'],'wrong logfile for audit query result '.$k);
            $this->assertEqual($v['action'],$aAuditParams[$k]['action'],'wrong action for audit query result '.$k);
            $this->assertEqual($v['description'],$aAuditParams[$k]['description'],'wrong description for audit query result '.$k);
            $this->assertTrue(strtotime($v['updated']),'timestamp','invalid timestamp for audit query result '.$k);
            $aDate = getdate(strtotime($v['updated']));
            $aNow = getdate(strtotime(date('Y-m-d')));
            $this->assertEqual($aDate['year'],$aNow['year'],'wrong year in updated field for audit query result '.$k);
            $this->assertEqual($aDate['mon'],$aNow['mon'],'wrong month in updated field for audit query result '.$k);
            $this->assertEqual($aDate['mday'],$aNow['mday'],'wrong day in updated field for audit query result '.$k);
            if (array_key_exists('confbackup',$aAuditParams[$k]))
            {
                $this->assertEqual($v['confbackup'],$aAuditParams[$k]['confbackup'],'wrong confbackup for audit query result '.$k);
            }
            else
            {
                $this->assertNull($v['confbackup'],'confbackup should be null for audit query result '.$k);
            }
        }
    }

    function test_queryAudit()
    {
        $oAuditor = $this->_getAuditObject();
        $aKeyParams = $this->_getAuditKeyParamsArray();

        $versionTo      = $aKeyParams['version_to'];
        $versionFrom    = $aKeyParams['version_from'];
        $upgradeName    = $aKeyParams['upgrade_name'];

        $aResult = $oAuditor->queryAudit($versionTo, $versionFrom, $upgradeName);
        $this->assertIsa($aResult,'array','audit table query result is not an array');
        $this->assertEqual(count($aResult),2,'incorrect number of elements on audit query result');

        $aResult = $oAuditor->queryAudit($versionTo, $versionFrom, $upgradeName, UPGRADE_ACTION_UPGRADE_SUCCEEDED);
        $this->assertIsa($aResult,'array','audit table query result is not an array');
        $this->assertEqual(count($aResult),1,'incorrect number of elements on audit query result: '.UPGRADE_ACTION_UPGRADE_SUCCEEDED);
        $this->assertEqual($aResult[0]['action'],UPGRADE_ACTION_UPGRADE_SUCCEEDED,'wrong action for audit query result');

        $aResult = $oAuditor->queryAudit($versionTo, $versionFrom, $upgradeName, UPGRADE_ACTION_UPGRADE_FAILED);
        $this->assertIsa($aResult,'array','audit table query result is not an array');
        $this->assertEqual(count($aResult),1,'incorrect number of elements on audit query result: '.UPGRADE_ACTION_UPGRADE_FAILED);
        $this->assertEqual($aResult[0]['action'],UPGRADE_ACTION_UPGRADE_FAILED,'wrong action for audit query result');

    }


    function _getAuditObject()
    {
        $oAuditor = new OA_UpgradeAuditor();
        $oDbh = OA_DB::singleton(OA_DB::getDsn());
        $oAuditor->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $oAuditor->oDbh = &$oDbh;
        return $oAuditor;
    }

    function _dropAuditTable($table_name)
    {
        $oTable = new OA_DB_Table();
        $aDBTables = $oTable->oDbh->manager->listTables();
        if (in_array($table_name, $aDBTables))
        {
            $this->assertTrue($oTable->dropTable($table_name),'error dropping audit table '.$table_name);
        }
        $aDBTables = $oTable->oDbh->manager->listTables();
        $this->assertFalse(in_array($table_name, $aDBTables), '_dropAuditTable');
    }

    function _getAuditKeyParamsArray()
    {
        return array(
                     'upgrade_name'=>'openads_upgrade_2.0.0.xml',
                     'version_from'=>'1.0.0',
                     'version_to'=>'2.0.0',
                     'logfile'=>'openads_upgrade_2.0.0.log',
                    );
    }

    function _getAuditParamsArray()
    {
        $aAudit[0] = array('description'=>'UPGRADE SUCCEEDED',
                           'action'=>UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                           'confbackup'=>'old.config.inc.php'
                          );
        $aAudit[1] = array('description'=>'UPGRADE FAILED',
                           'action'=>UPGRADE_ACTION_UPGRADE_FAILED,
                          );
        return $aAudit;
    }


}

?>
