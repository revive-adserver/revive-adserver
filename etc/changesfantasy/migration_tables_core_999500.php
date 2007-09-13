<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_999500 extends Migration
{

    function Migration_999500()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveTable__bender';
		$this->aTaskList_destructive[] = 'afterRemoveTable__bender';
		$this->aTaskList_destructive[] = 'beforeRemoveField__klapaucius__text_field';
		$this->aTaskList_destructive[] = 'afterRemoveField__klapaucius__text_field';
		$this->aTaskList_destructive[] = 'beforeRemoveIndex__klapaucius__klapaucius_pkey';
		$this->aTaskList_destructive[] = 'afterRemoveField__klapaucius__klapaucius_pkey';


    }



	function beforeRemoveTable__bender()
	{
		return $this->beforeRemoveTable('bender');
	}

	function afterRemoveTable__bender()
	{
		return $this->afterRemoveTable('bender');
	}

	function beforeRemoveField__klapaucius__text_field()
	{
		return $this->beforeRemoveField('klapaucius', 'text_field');
	}

	function afterRemoveField__klapaucius__text_field()
	{
		return $this->afterRemoveField('klapaucius', 'text_field');
	}

	function beforeRemoveIndex__klapaucius__astro_pkey()
	{
		return $this->beforeRemoveIndex('klapaucius', 'klapaucius_pkey');
	}

	function afterRemoveField__klapaucius__astro_pkey()
	{
		return $this->afterRemoveIndex('klapaucius', 'klapaucius_pkey');
	}

}

?>