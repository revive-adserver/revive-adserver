<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_615 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__an_website_id';
		$this->aTaskList_destructive[] = 'afterRemoveField__affiliates__an_website_id';
		$this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__as_website_id';
		$this->aTaskList_destructive[] = 'afterRemoveField__affiliates__as_website_id';


    }



	function beforeRemoveField__affiliates__an_website_id()
	{
		return $this->beforeRemoveField('affiliates', 'an_website_id');
	}

	function afterRemoveField__affiliates__an_website_id()
	{
		return $this->afterRemoveField('affiliates', 'an_website_id');
	}

	function beforeRemoveField__affiliates__as_website_id()
	{
		return $this->beforeRemoveField('affiliates', 'as_website_id');
	}

	function afterRemoveField__affiliates__as_website_id()
	{
		return $this->afterRemoveField('affiliates', 'as_website_id');
	}

}

?>