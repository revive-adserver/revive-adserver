<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_628 extends Migration
{
    public function __construct()
    {
        $this->aTaskList_constructive[] = 'beforeAddIndex__acls__acls_pkey';
        $this->aTaskList_constructive[] = 'afterAddIndex__acls__acls_pkey';
        $this->aTaskList_constructive[] = 'beforeRemoveIndex__acls__bannerid';
        $this->aTaskList_constructive[] = 'afterRemoveIndex__acls__bannerid';
        $this->aTaskList_constructive[] = 'beforeRemoveIndex__acls__bannerid_executionorder';
        $this->aTaskList_constructive[] = 'afterRemoveIndex__acls__bannerid_executionorder';
        $this->aTaskList_constructive[] = 'beforeAddIndex__acls_channel__acls_channel_pkey';
        $this->aTaskList_constructive[] = 'afterAddIndex__acls_channel__acls_channel_pkey';
        $this->aTaskList_constructive[] = 'beforeRemoveIndex__acls_channel__channelid';
        $this->aTaskList_constructive[] = 'afterRemoveIndex__acls_channel__channelid';
        $this->aTaskList_constructive[] = 'beforeRemoveIndex__acls_channel__channelid_executionorder';
        $this->aTaskList_constructive[] = 'afterRemoveIndex__acls_channel__channelid_executionorder';
    }



    public function beforeAddIndex__acls__acls_pkey()
    {
        return $this->beforeAddIndex('acls', 'acls_pkey');
    }

    public function afterAddIndex__acls__acls_pkey()
    {
        return $this->afterAddIndex('acls', 'acls_pkey');
    }

    public function beforeRemoveIndex__acls__bannerid()
    {
        return $this->beforeRemoveIndex('acls', 'bannerid');
    }

    public function afterRemoveIndex__acls__bannerid()
    {
        return $this->afterRemoveIndex('acls', 'bannerid');
    }

    public function beforeRemoveIndex__acls__bannerid_executionorder()
    {
        return $this->beforeRemoveIndex('acls', 'bannerid_executionorder');
    }

    public function afterRemoveIndex__acls__bannerid_executionorder()
    {
        return $this->afterRemoveIndex('acls', 'bannerid_executionorder');
    }

    public function beforeAddIndex__acls_channel__acls_channel_pkey()
    {
        return $this->beforeAddIndex('acls_channel', 'acls_channel_pkey');
    }

    public function afterAddIndex__acls_channel__acls_channel_pkey()
    {
        return $this->afterAddIndex('acls_channel', 'acls_channel_pkey');
    }

    public function beforeRemoveIndex__acls_channel__channelid()
    {
        return $this->beforeRemoveIndex('acls_channel', 'channelid');
    }

    public function afterRemoveIndex__acls_channel__channelid()
    {
        return $this->afterRemoveIndex('acls_channel', 'channelid');
    }

    public function beforeRemoveIndex__acls_channel__channelid_executionorder()
    {
        return $this->beforeRemoveIndex('acls_channel', 'channelid_executionorder');
    }

    public function afterRemoveIndex__acls_channel__channelid_executionorder()
    {
        return $this->afterRemoveIndex('acls_channel', 'channelid_executionorder');
    }
}
