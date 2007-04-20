<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_116 extends Migration
{

    function Migration_116()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__ad_category_assoc';
		$this->aTaskList_constructive[] = 'afterAddTable__ad_category_assoc';
		$this->aTaskList_constructive[] = 'beforeAddTable__category';
		$this->aTaskList_constructive[] = 'afterAddTable__category';


    }



	function beforeAddTable__ad_category_assoc()
	{
		return $this->beforeAddTable('ad_category_assoc');
	}

	function afterAddTable__ad_category_assoc()
	{
		return $this->afterAddTable('ad_category_assoc');
	}

	function beforeAddTable__category()
	{
		return $this->beforeAddTable('category');
	}

	function afterAddTable__category()
	{
		return $this->afterAddTable('category');
	}

}

?>