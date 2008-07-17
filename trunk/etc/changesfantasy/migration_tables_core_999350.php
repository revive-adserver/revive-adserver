<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_999350 extends Migration
{

    function Migration_999350()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeRemoveIndex__astro__astro_pkey';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__astro__astro_pkey';
		$this->aTaskList_destructive[] = 'beforeRemoveField__astro__auto_renamed_field';
		$this->aTaskList_destructive[] = 'afterRemoveField__astro__auto_renamed_field';


    }



	function beforeRemoveIndex__astro__astro_pkey()
	{
		return $this->beforeRemoveIndex('astro', 'astro_pkey');
	}

	function afterRemoveIndex__astro__astro_pkey()
	{
		return $this->afterRemoveIndex('astro', 'astro_pkey');
	}

	function beforeRemoveField__astro__auto_renamed_field()
	{
		return $this->beforeRemoveField('astro', 'auto_renamed_field');
	}

	function afterRemoveField__astro__auto_renamed_field()
	{
		return $this->afterRemoveField('astro', 'auto_renamed_field');
	}

}

?>