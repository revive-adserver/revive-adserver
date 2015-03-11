<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_613 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__show_capped_no_cookie';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__show_capped_no_cookie';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__show_capped_no_cookie';
		$this->aTaskList_constructive[] = 'afterAddField__zones__show_capped_no_cookie';


		$this->aObjectMap['campaigns']['show_capped_no_cookie'] = array('fromTable'=>'campaigns', 'fromField'=>'show_capped_no_cookie');
		$this->aObjectMap['zones']['show_capped_no_cookie'] = array('fromTable'=>'zones', 'fromField'=>'show_capped_no_cookie');
    }



	function beforeAddField__campaigns__show_capped_no_cookie()
	{
		return $this->beforeAddField('campaigns', 'show_capped_no_cookie');
	}

	function afterAddField__campaigns__show_capped_no_cookie()
	{
		return $this->afterAddField('campaigns', 'show_capped_no_cookie');
	}

	function beforeAddField__zones__show_capped_no_cookie()
	{
		return $this->beforeAddField('zones', 'show_capped_no_cookie');
	}

	function afterAddField__zones__show_capped_no_cookie()
	{
		return $this->afterAddField('zones', 'show_capped_no_cookie');
	}

}

?>