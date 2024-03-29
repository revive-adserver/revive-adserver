<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_998 extends Migration
{
    public function __construct()
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


        $this->aObjectMap['acls_channel']['channel_id'] = ['fromTable' => 'acls_channel', 'fromField' => 'channelid'];
        $this->aObjectMap['acls_channel']['newfield'] = ['fromTable' => 'acls_channel', 'fromField' => 'newfield'];
    }



    public function beforeAddTable__aardvark()
    {
        return $this->beforeAddTable('aardvark');
    }

    public function afterAddTable__aardvark()
    {
        return $this->afterAddTable('aardvark');
    }

    public function beforeAddField__acls_channel__channel_id()
    {
        return $this->beforeAddField('acls_channel', 'channel_id');
    }

    public function afterAddField__acls_channel__channel_id()
    {
        return $this->afterAddField('acls_channel', 'channel_id');
    }

    public function beforeAddField__acls_channel__newfield()
    {
        return $this->beforeAddField('acls_channel', 'newfield');
    }

    public function afterAddField__acls_channel__newfield()
    {
        return $this->afterAddField('acls_channel', 'newfield');
    }

    public function beforeAlterField__acls_channel__fields()
    {
        return $this->beforeAlterField('acls_channel', 'fields');
    }

    public function afterAlterField__acls_channel__fields()
    {
        return $this->afterAlterField('acls_channel', 'fields');
    }

    public function beforeAddIndex__acls_channel__channelid()
    {
        return $this->beforeAddIndex('acls_channel', 'channelid');
    }

    public function afterAddIndex__acls_channel__channelid()
    {
        return $this->afterAddIndex('acls_channel', 'channelid');
    }

    public function beforeAddIndex__acls_channel__channelid_executionorder()
    {
        return $this->beforeAddIndex('acls_channel', 'channelid_executionorder');
    }

    public function afterAddIndex__acls_channel__channelid_executionorder()
    {
        return $this->afterAddIndex('acls_channel', 'channelid_executionorder');
    }

    public function beforeRemoveField__acls_channel__channelid()
    {
        return $this->beforeRemoveField('acls_channel', 'channelid');
    }

    public function afterRemoveField__acls_channel__channelid()
    {
        return $this->afterRemoveField('acls_channel', 'channelid');
    }
}
