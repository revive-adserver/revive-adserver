<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
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

	        $sql = OA_DB_SQL::sqlForInsert($tablePreference, $aValues);
	        $result = $this->oDBH->exec($sql);
	        return (!PEAR::isError($result));

            // THESE SHOULD BE MIGRATED FROM PAN CONFIG TO OA PREFERENCE TABLE
            // E-mail admin when clicks/views get low?
            //$phpAds_config['warn_admin'] = true;
            //
            // E-mail client when clicks/views get low?
            //$phpAds_config['warn_client'] = true;
            //
            // Minimum clicks/views before warning e-mail is sent
            //$phpAds_config['warn_limit'] = 100;
            //
            // Days before warning e-mail is sent
            //$phpAds_config['warn_limit_days'] = 1;
            //
            //$phpAds_config['default_banner_url'] = '';
            //$phpAds_config['default_banner_target'] = '';
	    }
	    else {
	        return false;
	    }
	}
}

?>