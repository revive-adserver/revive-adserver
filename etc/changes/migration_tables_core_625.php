<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_625 extends Migration
{
    public function __construct()
    {
        $this->aTaskList_constructive[] = 'beforeAlterField__application_variable__name';
        $this->aTaskList_constructive[] = 'afterAlterField__application_variable__name';
        $this->aTaskList_constructive[] = 'beforeAlterField__audit__context';
        $this->aTaskList_constructive[] = 'afterAlterField__audit__context';
    }



    public function beforeAlterField__application_variable__name()
    {
        return $this->beforeAlterField('application_variable', 'name');
    }

    public function afterAlterField__application_variable__name()
    {
        return $this->afterAlterField('application_variable', 'name');
    }

    public function beforeAlterField__audit__context()
    {
        return $this->beforeAlterField('audit', 'context');
    }

    public function afterAlterField__audit__context()
    {
        return $this->afterAlterField('audit', 'context');
    }
}
