<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_005 extends Migration
{

    function Migration_005()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__ext_market_general_pref__account_id';
		$this->aTaskList_constructive[] = 'afterAddField__ext_market_general_pref__account_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__ext_market_general_pref__ext_market_general_pref_pkey';
		$this->aTaskList_constructive[] = 'afterAddIndex__ext_market_general_pref__ext_market_general_pref_pkey';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__ext_market_general_pref__ext_market_general_pref_pkey';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__ext_market_general_pref__ext_market_general_pref_pkey';


		$this->aObjectMap['ext_market_general_pref']['account_id'] = array('fromTable'=>'ext_market_general_pref', 'fromField'=>'account_id');
    }



	function beforeAddField__ext_market_general_pref__account_id()
	{
		return $this->beforeAddField('ext_market_general_pref', 'account_id');
	}

	function afterAddField__ext_market_general_pref__account_id()
	{
		return $this->afterAddField('ext_market_general_pref', 'account_id');
	}

	function beforeAddIndex__ext_market_general_pref__ext_market_general_pref_pkey()
	{
		return $this->beforeAddIndex('ext_market_general_pref', 'ext_market_general_pref_pkey');
	}

	function afterAddIndex__ext_market_general_pref__ext_market_general_pref_pkey()
	{
		return $this->afterAddIndex('ext_market_general_pref', 'ext_market_general_pref_pkey');
	}

	function beforeRemoveIndex__ext_market_general_pref__ext_market_general_pref_pkey()
	{
		return $this->beforeRemoveIndex('ext_market_general_pref', 'ext_market_general_pref_pkey');
	}

	function afterRemoveIndex__ext_market_general_pref__ext_market_general_pref_pkey()
	{
		return $this->afterRemoveIndex('ext_market_general_pref', 'ext_market_general_pref_pkey');
	}

}

?>