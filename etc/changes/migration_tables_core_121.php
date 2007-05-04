<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

class Migration_121 extends Migration
{
    var $aAclsTypes = array(
        'weekday' => 'Time:Day'
    );

    function Migration_121()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAlterField__acls__type';
		$this->aTaskList_constructive[] = 'afterAlterField__acls__type';


    }



	function beforeAlterField__acls__type()
	{
		return $this->beforeAlterField('acls', 'type');
	}

	function afterAlterField__acls__type()
	{
	    return $this->migrateData();
	}

	function migrateData()
	{
	    $tableAcls = $this->getPrefix() . "acls";
	    $sql = "SELECT * FROM $tableAcls";
	    $rsAcls = DBC::NewRecordSet($sql);
	    if (!$rsAcls->find()) {
	        return false;
	    }
	    $aUpdates = array();
	    while ($rsAcls->fetch()) {
	        $bannerid = $rsAcls->get('bannerid');
	        $executionorder = $rsAcls->get('executionorder');
	        $oldType = $rsAcls->get('type');
	        if (!isset($this->aAclsTypes[$oldType])) {
	            $this->_logError("Unknown acls type: $oldType");
	            return false;
	        }
	        $type = $this->aAclsTypes[$oldType];
	        $oldComparison = $rsAcls->get('comparison');
	        $oldData = $rsAcls->get('data');
	        $aNewAclsData = MAX_limitationsGetAUpgradeForArray($oldComparison, $oldData);
	        $comparison = $aNewAclsData['op'];
	        $data = $aNewAclsData['data'];
	        $aUpdates []= "UPDATE acls SET type = '$type', comparison = '$comparison', data = '$data'
	        WHERE bannerid = $bannerid
	        AND executionorder = $executionorder";
	    }
	    
	    foreach($aUpdates as $update) {
	        $result = $this->oDBH->exec($update);
	        if (PEAR::isError($result)) {
	            $this->_logError("Couldn't execute update: $update");
	            return false;
	        }
	    }
	    return true;
	    /** @todo Migrate acls type, comparison and data for other fields*/
	}
}

?>