<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_618 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_destructive[] = 'beforeRemoveField__clients__an_adnetwork_id';
        $this->aTaskList_destructive[] = 'afterRemoveField__clients__an_adnetwork_id';
        $this->aTaskList_destructive[] = 'beforeRemoveField__clients__as_advertiser_id';
        $this->aTaskList_destructive[] = 'afterRemoveField__clients__as_advertiser_id';
    }



    public function beforeRemoveField__clients__an_adnetwork_id()
    {
        return $this->beforeRemoveField('clients', 'an_adnetwork_id');
    }

    public function afterRemoveField__clients__an_adnetwork_id()
    {
        return $this->afterRemoveField('clients', 'an_adnetwork_id');
    }

    public function beforeRemoveField__clients__as_advertiser_id()
    {
        return $this->beforeRemoveField('clients', 'as_advertiser_id');
    }

    public function afterRemoveField__clients__as_advertiser_id()
    {
        return $this->afterRemoveField('clients', 'as_advertiser_id');
    }
}
