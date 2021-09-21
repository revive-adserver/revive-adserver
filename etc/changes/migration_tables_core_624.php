<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_624 extends Migration
{
    public function __construct()
    {
        $this->aTaskList_constructive[] = 'beforeAddField__agency__status';
        $this->aTaskList_constructive[] = 'afterAddField__agency__status';
        $this->aTaskList_destructive[] = 'beforeRemoveField__agency__active';
        $this->aTaskList_destructive[] = 'afterRemoveField__agency__active';


        $this->aObjectMap['agency']['status'] = ['fromTable' => 'agency', 'fromField' => 'status'];
    }



    public function beforeAddField__agency__status()
    {
        return $this->beforeAddField('agency', 'status');
    }

    public function afterAddField__agency__status()
    {
        return $this->afterAddField('agency', 'status');
    }

    public function beforeRemoveField__agency__active()
    {
        return $this->beforeRemoveField('agency', 'active');
    }

    public function afterRemoveField__agency__active()
    {
        return $this->afterRemoveField('agency', 'active');
    }
}
