<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_001 extends Migration
{

    function Migration_001()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__data_bucket_click';
		$this->aTaskList_constructive[] = 'afterAddTable__data_bucket_click';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_bucket_impression_backup';
		$this->aTaskList_constructive[] = 'afterAddTable__data_bucket_impression_backup';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_bucket_impression';
		$this->aTaskList_constructive[] = 'afterAddTable__data_bucket_impression';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_bucket_impression_country';
		$this->aTaskList_constructive[] = 'afterAddTable__data_bucket_impression_country';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_bucket_request';
		$this->aTaskList_constructive[] = 'afterAddTable__data_bucket_request';


    }



	function beforeAddTable__data_bucket_click()
	{
		return $this->beforeAddTable('data_bucket_click');
	}

	function afterAddTable__data_bucket_click()
	{
		return $this->afterAddTable('data_bucket_click');
	}

	function beforeAddTable__data_bucket_impression_backup()
	{
		return $this->beforeAddTable('data_bucket_impression_backup');
	}

	function afterAddTable__data_bucket_impression_backup()
	{
		return $this->afterAddTable('data_bucket_impression_backup');
	}

	function beforeAddTable__data_bucket_impression()
	{
		return $this->beforeAddTable('data_bucket_impression');
	}

	function afterAddTable__data_bucket_impression()
	{
		return $this->afterAddTable('data_bucket_impression');
	}

	function beforeAddTable__data_bucket_impression_country()
	{
		return $this->beforeAddTable('data_bucket_impression_country');
	}

	function afterAddTable__data_bucket_impression_country()
	{
		return $this->afterAddTable('data_bucket_impression_country');
	}

	function beforeAddTable__data_bucket_request()
	{
		return $this->beforeAddTable('data_bucket_request');
	}

	function afterAddTable__data_bucket_request()
	{
		return $this->afterAddTable('data_bucket_request');
	}

}

?>