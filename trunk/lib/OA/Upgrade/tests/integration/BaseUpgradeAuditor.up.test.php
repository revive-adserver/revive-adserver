<?php
require_once MAX_PATH.'/lib/OA/Upgrade/BaseUpgradeAuditor.php';

Mock::generate('OA_DB_UpgradeAuditor');
Mock::generate('OA_UpgradeAuditor');

class Test_OA_BaseUpgradeAuditor extends UnitTestCase
{
    var $aAuditParams = array();

	function Test_OA_BaseUpgradeAuditor()
	{
		$this->UnitTestCase();
	}

	function _getFieldDefinitionArray($id)
    {
        $table = 'test_table'.$id;
        $aDef  = array($table=>array('fields'=>array(), 'indexes'=>array()));
        $aDef[$table]['fields']['test_field'.$id]  = array('type'=>'test_type','length'=>1);
        $aDef[$table]['indexes']['test_index'.$id] = array('primary'=>true);
        return $aDef;
    }

	function _getAuditObject( $classToTest )
    {
    	$oAuditor = new $classToTest();
        $oDbh = OA_DB::singleton(OA_DB::getDsn());
        $oAuditor->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $oAuditor->oDbh = $oDbh;
        return $oAuditor;
    }

    function _dropAuditTable($table_name)
    {
        $oTable = new OA_DB_Table();
        $aDBTables = OA_DB_Table::listOATablesCaseSensitive();
        if (in_array($table_name, $aDBTables))
        {
            $this->assertTrue($oTable->dropTable($table_name),'error dropping audit table '.$table_name);
        }
        $aDBTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertFalse(in_array($table_name, $aDBTables), '_dropAuditTable');
    }

   	function _test_logDBAuditAction($oAuditor, $auditDataToLog=null, $keyParamsToSet=null)
   	{
   		if(is_null($auditDataToLog))
   		{
   			$auditDataToLog = $this->aAuditParams;
   		}
   		if(is_null($keyParamsToSet))
   		{
   			$keyParamsToSet = $this->_getDBAuditKeyParamsArray();
   		}
        $oAuditor->auditId = 1;
        $oAuditor->setKeyParams($keyParamsToSet);
        $this->assertTrue($oAuditor->logAuditAction($auditDataToLog[0][0]),'');
        $this->assertTrue($oAuditor->logAuditAction($auditDataToLog[0][1]),'');
        $this->assertTrue($oAuditor->logAuditAction($auditDataToLog[0][2]),'');
        $this->assertTrue($oAuditor->logAuditAction($auditDataToLog[0][3]),'');
        $this->assertTrue($oAuditor->logAuditAction($auditDataToLog[0][4]),'');

		//case the array to log concerns two audit
		// in some test cases we log only one test case
		if(is_array($auditDataToLog[1]))
		{
	        $oAuditor->auditId = 2;
	        $oAuditor->setKeyParams($keyParamsToSet);
	        $this->assertTrue($oAuditor->logAuditAction($auditDataToLog[1][0]),'');
	        $this->assertTrue($oAuditor->logAuditAction($auditDataToLog[1][1]),'');
	        $this->assertTrue($oAuditor->logAuditAction($auditDataToLog[1][2]),'');
	        $this->assertTrue($oAuditor->logAuditAction($auditDataToLog[1][3]),'');
	        $this->assertTrue($oAuditor->logAuditAction($auditDataToLog[1][4]),'');
        }
	}

    function test_updateAuditAction()
    {

        // to be written!
    }

    function _getUpgradeAuditKeyParamsArray()
    {
        return array(
                     'upgrade_name'=>'openads_upgrade_2.0.0.xml',
                     'version_from'=>'1.0.0',
                     'version_to'=>'2.0.0',
                     'logfile'=>'test/openads_upgrade_2.0.0.log',
                    );
    }

    function _getDBAuditKeyParamsArray()
    {
        return array(
                     'schema_name'=>'test_schema',
                     'version'=>2,
                     'timing'=>0,
                    );
    }

}
?>