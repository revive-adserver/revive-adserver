<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_001 extends Migration
{

    function Migration_001()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__data_bkt_m_country';
		$this->aTaskList_constructive[] = 'afterAddTable__data_bkt_m_country';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_bkt_c_country';
		$this->aTaskList_constructive[] = 'afterAddTable__data_bkt_c_country';


    }


	function beforeAddTable__data_bkt_m_country()
	{
		return $this->beforeAddTable('data_bkt_m_country');
	}

	function afterAddTable__data_bkt_m_country()
	{
		return $this->afterAddTable('data_bkt_m_country');
	}

	function beforeAddTable__data_bkt_c_country()
	{
		return $this->beforeAddTable('data_bkt_c_country');
	}

	function afterAddTable__data_bkt_c_country()
	{
		return $this->afterAddTable('data_bkt_c_country');
	}
}

?>