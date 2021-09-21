<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_619 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_destructive[] = 'beforeRemoveField__zones__as_zone_id';
        $this->aTaskList_destructive[] = 'afterRemoveField__zones__as_zone_id';
        $this->aTaskList_destructive[] = 'beforeRemoveField__zones__is_in_ad_direct';
        $this->aTaskList_destructive[] = 'afterRemoveField__zones__is_in_ad_direct';
    }



    public function beforeRemoveField__zones__as_zone_id()
    {
        return $this->beforeRemoveField('zones', 'as_zone_id');
    }

    public function afterRemoveField__zones__as_zone_id()
    {
        return $this->afterRemoveField('zones', 'as_zone_id');
    }

    public function beforeRemoveField__zones__is_in_ad_direct()
    {
        return $this->beforeRemoveField('zones', 'is_in_ad_direct');
    }

    public function afterRemoveField__zones__is_in_ad_direct()
    {
        return $this->afterRemoveField('zones', 'is_in_ad_direct');
    }
}
