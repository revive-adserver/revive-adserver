<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH.'/lib/OA/Upgrade/VersionController.php';
require_once MAX_PATH.'/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 */
class Test_VersionController extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
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

    function test_getComponentGroupVersion()
    {
        $this->_createTestRecord('plugin_test', 1001);
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->getSchemaVersion('plugin_test'),1001,'wrong plugin version retrieved');
        $this->_deleteTestRecord('plugin_test');
    }

    function test_putComponentGroupVersion()
    {
        $oVerCtrl = new OA_Version_Controller();
        $oVerCtrl->init(OA_DB::singleton(OA_DB::getDsn()));
        $this->assertEqual($oVerCtrl->putComponentGroupVersion('plugin_test',1001),1001,'error inserting plugin version');
        $this->assertEqual($oVerCtrl->putComponentGroupVersion('plugin_test',1002),1002,'error updating plugin version');
        $this->assertNotEqual($oVerCtrl->getComponentGroupVersion('plugin_test'),1001,'wrong plugin version retrieved');
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
