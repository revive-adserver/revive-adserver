<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_999250 extends Migration
{

    function Migration_999250()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__astro__auto_field';
		$this->aTaskList_constructive[] = 'afterAddField__astro__auto_field';
		$this->aTaskList_constructive[] = 'beforeAddIndex__astro__astro_pkey';
		$this->aTaskList_constructive[] = 'afterAddIndex__astro__astro_pkey';


		$this->aObjectMap['astro']['auto_field'] = array('fromTable'=>'astro', 'fromField'=>'auto_field');
    }



	function beforeAddField__astro__auto_field()
	{
		return $this->beforeAddField('astro', 'auto_field');
	}

	function afterAddField__astro__auto_field()
	{
		return $this->afterAddField('astro', 'auto_field');
	}

	function beforeAddIndex__astro__astro_pkey()
	{
		return $this->beforeAddIndex('astro', 'astro_pkey');
	}

	function afterAddIndex__astro__astro_pkey()
	{
		return $this->afterAddIndex('astro', 'astro_pkey');
	}

}

?>