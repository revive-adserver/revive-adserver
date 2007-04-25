<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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


require_once MAX_PATH.'/lib/OA/Upgrade/VersionController.php';
require_once MAX_PATH.'/lib/max/tests/util/DataGenerator.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    Openads Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 */
class Test_VersionController extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_VersionController()
    {
        $this->UnitTestCase();
    }

    function test_constructor()
    {
    }

    function test_getSchemaVersion()
    {
        $this->_createTestRecord('tables_test', 1001);
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->getSchemaVersion('tables_test'),1001,'wrong schema version retrieved');
    }

    function test_putSchemaVersion()
    {
        $this->_deleteTestRecord('tables_test', 1001);
        $this->_deleteTestRecord('tables_test', 1002);
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->putSchemaVersion('tables_test',1001),1001,'error inserting schema version');
        $this->assertEqual($oVerCtrl->putSchemaVersion('tables_test',1002),1002,'error updating schema version');
        $this->assertNotEqual($oVerCtrl->getSchemaVersion('tables_test'),1001,'wrong schema version retrieved');
        $this->_deleteTestRecord('tables_test', 1001);
        $this->_deleteTestRecord('tables_test', 1002);
    }

    function test_getApplicationVersion()
    {
        $this->_createTestRecord('max_version', 1001);
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->getSchemaVersion('max_version'),1001,'wrong application version retrieved');
    }

    function test_putApplicationVersion()
    {
        $this->_deleteTestRecord('max_version', 1001);
        $this->_deleteTestRecord('max_version', 1002);
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->putApplicationVersion(1001),1001,'error inserting application version');
        $this->assertEqual($oVerCtrl->putApplicationVersion(1002),1002,'error updating application version');
        $this->assertNotEqual($oVerCtrl->getApplicationVersion(1001),'wrong application version retrieved');
        $this->_deleteTestRecord('max_version', 1001);
        $this->_deleteTestRecord('max_version', 1002);
    }

    function test_getPluginVersion()
    {
        $this->_createTestRecord('plugin_test', 1001);
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->getSchemaVersion('plugin_test'),1001,'wrong plugin version retrieved');
    }

    function test_putPluginVersion()
    {
        $this->_deleteTestRecord('tables_test', 1001);
        $this->_deleteTestRecord('tables_test', 1002);
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->putPluginVersion('tables_test',1001),1001,'error inserting plugin version');
        $this->assertEqual($oVerCtrl->putPluginVersion('tables_test',1002),1002,'error updating plugin version');
        $this->assertNotEqual($oVerCtrl->getPluginVersion('tables_test'),1001,'wrong plugin version retrieved');
        $this->_deleteTestRecord('tables_test', 1001);
        $this->_deleteTestRecord('tables_test', 1002);
    }

    function _createTestRecord($name, $value)
    {
        $doApplicationVariable = OA_Dal::factoryDO('application_variable');
        $doApplicationVariable->name = $name;
        $doApplicationVariable->value = $value;
        $doApplicationVariable->delete();
        $appvar = DataGenerator::generateOne($doApplicationVariable);
        return $appVar;
    }

    function _deleteTestRecord($name, $value)
    {
        $doApplicationVariable = OA_Dal::factoryDO('application_variable');
        $doApplicationVariable->name = $name;
        $doApplicationVariable->value = $value;
        $doApplicationVariable->delete();
    }
}

?>
