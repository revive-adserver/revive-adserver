<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_622 extends Migration
{

    function __construct()
    {

		$this->aTaskList_constructive[] = 'beforeAlterField__clients__report';
		$this->aTaskList_constructive[] = 'afterAlterField__clients__report';
		$this->aTaskList_constructive[] = 'beforeAlterField__clients__reportdeactivate';
		$this->aTaskList_constructive[] = 'afterAlterField__clients__reportdeactivate';


    }



	function beforeAlterField__clients__report()
	{
		return $this->beforeAlterField('clients', 'report');
	}

	function afterAlterField__clients__report()
	{
		return $this->afterAlterField('clients', 'report');
	}

	function beforeAlterField__clients__reportdeactivate()
	{
		return $this->beforeAlterField('clients', 'reportdeactivate');
	}

	function afterAlterField__clients__reportdeactivate()
	{
		return $this->afterAlterField('clients', 'reportdeactivate');
	}

}
