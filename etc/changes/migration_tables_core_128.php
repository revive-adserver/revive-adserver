<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_128 extends Migration
{

    function Migration_128()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveTable__config';
		$this->aTaskList_destructive[] = 'afterRemoveTable__config';


    }

	function beforeRemoveTable__config()
	{
		return $this->migrateData();
	}

	function afterRemoveTable__config()
	{
		return $this->afterRemoveTable('config');
	}
	
	
	function migrateData()
	{
	    $prefix = $this->getPrefix();
	    $tablePreference = $prefix . 'preference';
	    $aColumns = $this->oDBH->listTableFields($tablePreference);
	    
	    $sql = "
	       SELECT * from {$prefix}config";
	    $rsConfig = DBC::NewRecordSet($sql);
	    if ($rsConfig->find() && $rsConfig->fetch()) {
	        $aDataConfig = $rsConfig->toArray();
	        $aValues = array();
	        foreach($aDataConfig as $column => $value) {
	            if (in_array($column, $aColumns)) {
	                $aValues[$column] = $value;
	            }
	        }
	        
	        $sql = $this->sqlForInsert($tablePreference, $aValues);
	        $result = $this->oDBH->exec($sql);
	        return (!PEAR::isError($result));
	    }
	    else {
	        return false;
	    }
	}
	
	function sqlForInsert($table, $aValues)
	{
	    foreach($aValues as $column => $value) {
	        $aValues[$column] = DBC::makeLiteral($value);
	    }
        $sColumns = implode(",", array_keys($aValues));
        $sValues = implode(",", $aValues);
        return "INSERT INTO $table ($sColumns) VALUES ($sValues)";
	}
}

?>