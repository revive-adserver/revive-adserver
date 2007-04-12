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
$Id $
*/


require_once MAX_PATH.'/lib/OA/DB.php';
require_once MAX_PATH.'/lib/OA/DB/Table.php';

require_once MAX_PATH.'/www/devel/lib/openads/DB_Upgrade.php';


/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    Openads Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 */
class Test_DB_Upgrade extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_DB_Upgrade()
    {
        $this->UnitTestCase();
    }

    function test_constructor()
    {
        $oDB_Upgrade = & new OA_DB_Upgrade();
        $this->assertIsA($oDB_Upgrade, 'OA_DB_Upgrade', 'OA_DB_Upgrade not instantiated');
        $this->assertIsA($oDB_Upgrade->oSchema, 'MDB2_Schema', 'MDB2_Schema not instantiated');
        $this->assertIsA($oDB_Upgrade->oSchema->db, 'MDB2_Driver_Common', 'MDB2_Driver_Common not instantiated');
    }

    function test_dropRecoveryFile()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $this->assertTrue($oDB_Upgrade->_dropRecoveryFile(),'failed to write recovery file');
    }

    function test_seekRecoveryFile()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $aResult = $oDB_Upgrade->_seekRecoveryFile();
        $this->assertIsA($aResult,'array','failed to find recovery file');
        $this->assertEqual($aResult['timingInt'],0,'error in recovery array: timingStr');
        $this->assertEqual($aResult['versionTo'],2,'error in recovery array: versionTo');
        $this->assertTrue(isset($aResult['updated']),'error in recovery array: updated');
    }

    function test_pickupRecoveryFile()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $this->assertTrue($oDB_Upgrade->_pickupRecoveryFile(),'failed to remove recovery file');
    }

    /**
     * a problem with mdb2_schema is that field definitions are held in arrays that are not ordered
     * this is a problem when it comes to creating a multi-key index that must be ordered properly
     * mdb2_schema will be patched to define an 'order' key for an index field definition
     * this method sorts the fields into the right order
     *
     */
    function test_sortIndexFields()
    {
        $fields = 'B_field1, E_field2, A_field3, D_field4, C_field5';
        $aFields = explode(',', $fields);
        $aResult = array('fields'=> array(
                                            $aFields[3]=>array('order'=>'4','sorting'=>'ascending'),
                                            $aFields[1]=>array('order'=>'2','sorting'=>'ascending'),
                                            $aFields[4]=>array('order'=>'5','sorting'=>'ascending'),
                                            $aFields[2]=>array('order'=>'3','sorting'=>'ascending'),
                                            $aFields[0]=>array('order'=>'1','sorting'=>'ascending'),
                                            )
                         );
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $aResult = $oDB_Upgrade->_sortIndexFields($aResult);
        $i = 0;
        foreach ($aResult['fields'] AS $field_name => $field_def)
        {
            $this->assertEqual($field_name,$aFields[$i],'field in wrong position');
            $i++;
        }
    }

    function test_getPreviousTablename()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $oDB_Upgrade->aChanges  = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile(MAX_PATH.'/www/devel/tests/unit/changes_test_rename.xml');
        $this->assertEqual($oDB_Upgrade->_getPreviousTablename('table1_renamed'), 'table1', 'wrong previous table name');
    }

    function test_getPreviousFieldname()
    {
        $oDB_Upgrade = $this->_newDBUpgradeObject();
        $oDB_Upgrade->aChanges  = $oDB_Upgrade->oSchema->parseChangesetDefinitionFile(MAX_PATH.'/www/devel/tests/unit/changes_test_rename.xml');
        $this->assertEqual($oDB_Upgrade->_getPreviousFieldname('table1', 'b_id_field_renamed'), 'b_id_field', 'wrong previous field name');
    }

    function _newDBUpgradeObject($timing='constructive')
    {
        $oDB_Upgrade = & new OA_DB_Upgrade();
        $oDB_Upgrade->timingStr = $timing;
        $oDB_Upgrade->timingInt = ($timing ? 0 : 1);
        $oDB_Upgrade->prefix = '';
        $oDB_Upgrade->versionFrom = 1;
        $oDB_Upgrade->versionTo = 2;
        $oDB_Upgrade->logFile = MAX_PATH . "/var/DB_Upgrade.dev.test.log";
        return $oDB_Upgrade;
    }

}

?>
