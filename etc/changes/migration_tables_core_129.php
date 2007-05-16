<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_129 extends Migration
{

    function Migration_129()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__preference__warn_limit_days';
		$this->aTaskList_constructive[] = 'afterAddField__preference__warn_limit_days';


		$this->aObjectMap['preference']['warn_limit_days'] = array('fromTable'=>'preference', 'fromField'=>'warn_limit_days');
    }



	function beforeAddField__preference__warn_limit_days()
	{
		return $this->beforeAddField('preference', 'warn_limit_days');
	}

	function afterAddField__preference__warn_limit_days()
	{
		return $this->afterAddField('preference', 'warn_limit_days');
	}

	function migrateData()
	{
	    $prefix = $this->getPrefix();
	    $tablePreference = $prefix . 'preference';

	        copy(
	           MAX_PATH.'/etc/changes/tests/data/config_2_0_12.inc.php',
	           MAX_PATH.'/var/config.inc.php'
	        );
	        
	        // Migrate PAN config variables
	        $phpAdsNew = new OA_phpAdsNew();
            $aPanConfig = $phpAdsNew->_getPANConfig();
            $aValues['warn_limit_days']                 = $aPanConfig['warn_limit_days'] ? $aPanConfig['warn_limit_days'] : 1;
            
            unlink(MAX_PATH.'/var/config.inc.php');
            
	        $sql = OA_DB_SQL::sqlForInsert($tablePreference, $aValues);
	        $result = $this->oDBH->exec($sql);
	        return (!PEAR::isError($result));
	}

}

?>
