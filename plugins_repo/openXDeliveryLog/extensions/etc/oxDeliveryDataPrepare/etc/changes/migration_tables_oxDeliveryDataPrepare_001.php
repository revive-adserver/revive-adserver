<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_001 extends Migration
{

    function Migration_001()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__data_bkt_c';
		$this->aTaskList_constructive[] = 'afterAddTable__data_bkt_c';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_bucket_impression_backup';
		$this->aTaskList_constructive[] = 'afterAddTable__data_bucket_impression_backup';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_bkt_m';
		$this->aTaskList_constructive[] = 'afterAddTable__data_bkt_m';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_bk_r';
		$this->aTaskList_constructive[] = 'afterAddTable__data_bk_r';


    }



	function beforeAddTable__data_bkt_c()
	{
		return $this->beforeAddTable('data_bkt_c');
	}

	function afterAddTable__data_bkt_c()
	{
		return $this->afterAddTable('data_bkt_c');
	}

	function beforeAddTable__data_bucket_impression_backup()
	{
		return $this->beforeAddTable('data_bucket_impression_backup');
	}

	function afterAddTable__data_bucket_impression_backup()
	{
		return $this->afterAddTable('data_bucket_impression_backup');
	}

	function beforeAddTable__data_bkt_m()
	{
		return $this->beforeAddTable('data_bkt_m');
	}

	function afterAddTable__data_bkt_m()
	{
		return $this->afterAddTable('data_bkt_m');
	}

	function beforeAddTable__data_bk_r()
	{
		return $this->beforeAddTable('data_bk_r');
	}

	function afterAddTable__data_bk_r()
	{
		return $this->afterAddTable('data_bk_r');
	}

}

?>