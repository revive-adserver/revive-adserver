<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_999150 extends Migration
{

    function Migration_999150()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddIndex__astro__id_field';
		$this->aTaskList_constructive[] = 'afterAddIndex__astro__id_field';


    }



	function beforeAddIndex__astro__id_field()
	{
		return $this->beforeAddIndex('astro', 'id_field');
	}

	function afterAddIndex__astro__id_field()
	{
		return $this->afterAddIndex('astro', 'id_field');
	}

}

?>