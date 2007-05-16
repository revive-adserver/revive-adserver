<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/phpAdsNew.php');
require_once(MAX_PATH.'/lib/OA/DB/Sql.php');

class Migration_119 extends Migration
{

    function Migration_119()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__preference';
		$this->aTaskList_constructive[] = 'afterAddTable__preference';
		$this->aTaskList_constructive[] = 'beforeAddTable__preference_advertiser';
		$this->aTaskList_constructive[] = 'afterAddTable__preference_advertiser';
		$this->aTaskList_constructive[] = 'beforeAddTable__preference_publisher';
		$this->aTaskList_constructive[] = 'afterAddTable__preference_publisher';


    }



	function beforeAddTable__preference()
	{
		return $this->beforeAddTable('preference');
	}

	function afterAddTable__preference()
	{
		return $this->migrateData() && $this->afterAddTable('preference');
	}

	function beforeAddTable__preference_advertiser()
	{
		return $this->beforeAddTable('preference_advertiser');
	}

	function afterAddTable__preference_advertiser()
	{
		return $this->afterAddTable('preference_advertiser');
	}

	function beforeAddTable__preference_publisher()
	{
		return $this->beforeAddTable('preference_publisher');
	}

	function afterAddTable__preference_publisher()
	{
		return $this->afterAddTable('preference_publisher');
	}


	function migrateData()
	{
	    $prefix = $this->getPrefix();
	    $tablePreference = $prefix . 'preference';
	    $aColumns = $this->oDBH->manager->listTableFields($tablePreference);

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

	        copy(
	           MAX_PATH.'/etc/changes/tests/data/config_2_0_12.inc.php',
	           MAX_PATH.'/var/config.inc.php'
	        );
	        
	        // Migrate PAN config variables
	        $phpAdsNew = new OA_phpAdsNew();
            $aPanConfig = $phpAdsNew->_getPANConfig();
            $aValues['warn_admin']                 = $aPanConfig['warn_admin'] ? 't' : 'f';
            $aValues['warn_client']                = $aPanConfig['warn_client'] ? 't' : 'f';
            $aValues['warn_limit']                 = $aPanConfig['warn_limit'] ? $aPanConfig['warn_limit'] : 100;
            $aValues['default_banner_url']         = $aPanConfig['default_banner_url'];
            $aValues['default_banner_destination'] = $aPanConfig['default_banner_target'];
            
            unlink(MAX_PATH.'/var/config.inc.php');
            
	        $sql = OA_DB_SQL::sqlForInsert($tablePreference, $aValues);
	        $result = $this->oDBH->exec($sql);
	        return (!PEAR::isError($result));
	    }
	    else {
	        return false;
	    }
	}
}

?>