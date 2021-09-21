<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_611 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_destructive[] = 'beforeRemoveField__clients__lb_reporting';
        $this->aTaskList_destructive[] = 'afterRemoveField__clients__lb_reporting';
    }



    public function beforeRemoveField__clients__lb_reporting()
    {
        return $this->beforeRemoveField('clients', 'lb_reporting');
    }

    public function afterRemoveField__clients__lb_reporting()
    {
        return $this->afterRemoveField('clients', 'lb_reporting');
    }
}
