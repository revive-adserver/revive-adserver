<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_999100 extends Migration
{

    function Migration_999100()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__astro';
		$this->aTaskList_constructive[] = 'afterAddTable__astro';
		$this->aTaskList_constructive[] = 'beforeAddTable__bender';
		$this->aTaskList_constructive[] = 'afterAddTable__bender';


    }



	function beforeAddTable__astro()
	{
		return $this->beforeAddTable('astro');
	}

	function afterAddTable__astro()
	{
		return $this->afterAddTable('astro');
	}

	function beforeAddTable__bender()
	{
		return $this->beforeAddTable('bender');
	}

	function afterAddTable__bender()
	{
		return $this->afterAddTable('bender');
	}

}

?>