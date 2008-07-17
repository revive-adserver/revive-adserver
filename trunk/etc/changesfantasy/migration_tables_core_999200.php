<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_999200 extends Migration
{

    function Migration_999200()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__astro__id_changed_field';
		$this->aTaskList_constructive[] = 'afterAddField__astro__id_changed_field';
		$this->aTaskList_constructive[] = 'beforeAddField__astro__text_field';
		$this->aTaskList_constructive[] = 'afterAddField__astro__text_field';
		$this->aTaskList_constructive[] = 'beforeAddIndex__astro__id_field';
		$this->aTaskList_constructive[] = 'afterAddIndex__astro__id_field';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__astro__id_field';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__astro__id_field';
		$this->aTaskList_destructive[] = 'beforeRemoveField__astro__id_field';
		$this->aTaskList_destructive[] = 'afterRemoveField__astro__id_field';


		$this->aObjectMap['astro']['id_changed_field'] = array('fromTable'=>'astro', 'fromField'=>'id_field');
		$this->aObjectMap['astro']['text_field'] = array('fromTable'=>'astro', 'fromField'=>'desc_field');
    }



	function beforeAddField__astro__id_changed_field()
	{
		return $this->beforeAddField('astro', 'id_changed_field');
	}

	function afterAddField__astro__id_changed_field()
	{
		return $this->afterAddField('astro', 'id_changed_field');
	}

	function beforeAddField__astro__text_field()
	{
		return $this->beforeAddField('astro', 'text_field');
	}

	function afterAddField__astro__text_field()
	{
		return $this->afterAddField('astro', 'text_field');
	}

	function beforeAddIndex__astro__id_field()
	{
		return $this->beforeAddIndex('astro', 'id_field');
	}

	function afterAddIndex__astro__id_field()
	{
		return $this->afterAddIndex('astro', 'id_field');
	}

	function beforeRemoveIndex__astro__id_field()
	{
		return $this->beforeRemoveIndex('astro', 'id_field');
	}

	function afterRemoveIndex__astro__id_field()
	{
		return $this->afterRemoveIndex('astro', 'id_field');
	}

	function beforeRemoveField__astro__id_field()
	{
		return $this->beforeRemoveField('astro', 'id_field');
	}

	function afterRemoveField__astro__id_field()
	{
		return $this->afterRemoveField('astro', 'id_field');
	}

}

?>