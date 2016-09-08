<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_621 extends Migration
{

    function __construct()
    {

		$this->aTaskList_constructive[] = 'beforeAlterField__banners__htmltemplate';
		$this->aTaskList_constructive[] = 'afterAlterField__banners__htmltemplate';
		$this->aTaskList_constructive[] = 'beforeAlterField__banners__htmlcache';
		$this->aTaskList_constructive[] = 'afterAlterField__banners__htmlcache';


    }



	function beforeAlterField__banners__htmltemplate()
	{
		return $this->beforeAlterField('banners', 'htmltemplate');
	}

	function afterAlterField__banners__htmltemplate()
	{
		return $this->afterAlterField('banners', 'htmltemplate');
	}

	function beforeAlterField__banners__htmlcache()
	{
		return $this->beforeAlterField('banners', 'htmlcache');
	}

	function afterAlterField__banners__htmlcache()
	{
		return $this->afterAlterField('banners', 'htmlcache');
	}

}
