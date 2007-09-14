<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_999450 extends Migration
{

    function Migration_999450()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeAddTable__klapaucius';
		$this->aTaskList_destructive[] = 'afterAddTable__klapaucius';

		$this->aTaskList_destructive[] = 'beforeRemoveTable__astro';
		$this->aTaskList_destructive[] = 'afterRemoveTable__astro';

	   $this->aObjectMap['klapaucius'] = array('fromTable'=>'astro');
    }

	function beforeAddTable__klapaucius()
	{
		return $this->beforeAddTable('klapaucius');
	}

	function afterAddTable__klapaucius()
	{
		return $this->afterAddTable('klapaucius');
	}

	function beforeRemoveTable__astro()
	{
		return $this->beforeRemoveTable('astro');
	}

	function afterRemoveTable__astro()
	{
		return $this->afterRemoveTable('astro');
	}
}

?>