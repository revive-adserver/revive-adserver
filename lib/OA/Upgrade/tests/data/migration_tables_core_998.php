<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_998 extends Migration
{

    function Migration_998()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__aardvark';
		$this->aTaskList_constructive[] = 'afterAddTable__aardvark';
		$this->aTaskList_constructive[] = 'beforeAddField__acls_channel__channel_id';
		$this->aTaskList_constructive[] = 'afterAddField__acls_channel__channel_id';
		$this->aTaskList_constructive[] = 'beforeAddField__acls_channel__newfield';
		$this->aTaskList_constructive[] = 'afterAddField__acls_channel__newfield';
		$this->aTaskList_constructive[] = 'beforeAlterField__acls_channel__fields';
		$this->aTaskList_constructive[] = 'afterAlterField__acls_channel__fields';
		$this->aTaskList_constructive[] = 'beforeAddIndex__acls_channel__channelid';
		$this->aTaskList_constructive[] = 'afterAddIndex__acls_channel__channelid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__acls_channel__channelid_executionorder';
		$this->aTaskList_constructive[] = 'afterAddIndex__acls_channel__channelid_executionorder';
		$this->aTaskList_destructive[] = 'beforeRemoveField__acls_channel__channelid';
		$this->aTaskList_destructive[] = 'afterRemoveField__acls_channel__channelid';


		$this->aObjectMap['acls_channel']['channel_id'] = array('fromTable'=>'acls_channel', 'fromField'=>'channelid');
		$this->aObjectMap['acls_channel']['newfield'] = array('fromTable'=>'acls_channel', 'fromField'=>'newfield');
    }



	function beforeAddTable__aardvark()
	{
		return $this->beforeAddTable('aardvark');
	}

	function afterAddTable__aardvark()
	{
		return $this->afterAddTable('aardvark');
	}

	function beforeAddField__acls_channel__channel_id()
	{
		return $this->beforeAddField('acls_channel', 'channel_id');
	}

	function afterAddField__acls_channel__channel_id()
	{
		return $this->afterAddField('acls_channel', 'channel_id');
	}

	function beforeAddField__acls_channel__newfield()
	{
		return $this->beforeAddField('acls_channel', 'newfield');
	}

	function afterAddField__acls_channel__newfield()
	{
		return $this->afterAddField('acls_channel', 'newfield');
	}

	function beforeAlterField__acls_channel__fields()
	{
		return $this->beforeAlterField('acls_channel', 'fields');
	}

	function afterAlterField__acls_channel__fields()
	{
		return $this->afterAlterField('acls_channel', 'fields');
	}

	function beforeAddIndex__acls_channel__channelid()
	{
		return $this->beforeAddIndex('acls_channel', 'channelid');
	}

	function afterAddIndex__acls_channel__channelid()
	{
		return $this->afterAddIndex('acls_channel', 'channelid');
	}

	function beforeAddIndex__acls_channel__channelid_executionorder()
	{
		return $this->beforeAddIndex('acls_channel', 'channelid_executionorder');
	}

	function afterAddIndex__acls_channel__channelid_executionorder()
	{
		return $this->afterAddIndex('acls_channel', 'channelid_executionorder');
	}

	function beforeRemoveField__acls_channel__channelid()
	{
		return $this->beforeRemoveField('acls_channel', 'channelid');
	}

	function afterRemoveField__acls_channel__channelid()
	{
		return $this->afterRemoveField('acls_channel', 'channelid');
	}

}

?>