<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_626 extends Migration
{

    function __construct()
    {

		$this->aTaskList_constructive[] = 'beforeAlterField__banners__contenttype';
		$this->aTaskList_constructive[] = 'afterAlterField__banners__contenttype';
		$this->aTaskList_constructive[] = 'beforeAlterField__banners__storagetype';
		$this->aTaskList_constructive[] = 'afterAlterField__banners__storagetype';
		$this->aTaskList_constructive[] = 'beforeAlterField__banners__alt_contenttype';
		$this->aTaskList_constructive[] = 'afterAlterField__banners__alt_contenttype';


    }



	function beforeAlterField__banners__contenttype()
	{
		return $this->beforeAlterField('banners', 'contenttype');
	}

	function afterAlterField__banners__contenttype()
	{
		return $this->afterAlterField('banners', 'contenttype');
	}

	function beforeAlterField__banners__storagetype()
	{
		return $this->beforeAlterField('banners', 'storagetype');
	}

	function afterAlterField__banners__storagetype()
	{
		return $this->afterAlterField('banners', 'storagetype');
	}

	function beforeAlterField__banners__alt_contenttype()
	{
		return $this->beforeAlterField('banners', 'alt_contenttype');
	}

	function afterAlterField__banners__alt_contenttype()
	{
		return $this->afterAlterField('banners', 'alt_contenttype');
	}

}
