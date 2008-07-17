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


require_once MAX_PATH.'/lib/OA/Upgrade/VersionController.php';
require_once MAX_PATH.'/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
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
        $this->_deleteTestRecord('tables_test');
    }

    function test_putSchemaVersion()
    {
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->putSchemaVersion('tables_test',1001),1001,'error inserting schema version');
        $this->assertEqual($oVerCtrl->putSchemaVersion('tables_test',1002),1002,'error updating schema version');
        $this->assertNotEqual($oVerCtrl->getSchemaVersion('tables_test'),1001,'wrong schema version retrieved');
        $this->_deleteTestRecord('tables_test');
    }

    function test_getApplicationVersion()
    {
        $this->_createTestRecord('oa_version', 1001);
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->getApplicationVersion(),1001,'wrong application version retrieved');
        $this->_deleteTestRecord('oa_version');
    }

    function test_getApplicationVersionMax()
    {
        $this->_createTestRecord('max_version', 1001);
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->getApplicationVersion('max'),1001,'wrong application version retrieved');
        $this->_deleteTestRecord('max_version');
    }

    function test_putApplicationVersion()
    {
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->putApplicationVersion(1001),1001,'error inserting application version');
        $this->assertEqual($oVerCtrl->putApplicationVersion(1002),1002,'error updating application version');
        $this->assertNotEqual($oVerCtrl->getApplicationVersion(),1001,'wrong application version retrieved');
        $this->_deleteTestRecord('oa_version');
    }

    function test_getPluginVersion()
    {
        $this->_createTestRecord('plugin_test', 1001);
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->getSchemaVersion('plugin_test'),1001,'wrong plugin version retrieved');
        $this->_deleteTestRecord('plugin_test');
    }

    function test_putPluginVersion()
    {
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->putPluginVersion('plugin_test',1001),1001,'error inserting plugin version');
        $this->assertEqual($oVerCtrl->putPluginVersion('plugin_test',1002),1002,'error updating plugin version');
        $this->assertNotEqual($oVerCtrl->getPluginVersion('plugin_test'),1001,'wrong plugin version retrieved');
        $this->_deleteTestRecord('plugin_test');
    }

    function _createTestRecord($name, $value)
    {
        $doApplicationVariable = OA_Dal::factoryDO('application_variable');
        $doApplicationVariable->name = $name;
        $doApplicationVariable->value = $value;
        $doApplicationVariable->delete();
        $appVar = DataGenerator::generateOne($doApplicationVariable);
        $this->assertTrue($appVar, 'Failed to create test record: '.$name.' = '.$value);
        return $appVar;
    }

    function _deleteTestRecord($name)
    {
        $doApplicationVariable = OA_Dal::factoryDO('application_variable');
        $doApplicationVariable->name = $name;
        $this->assertTrue($doApplicationVariable->delete(), 'Failed to delete test record: '.$name);
    }
}

?>
