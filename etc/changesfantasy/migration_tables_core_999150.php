<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_999150 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddIndex__astro__id_field';
        $this->aTaskList_constructive[] = 'afterAddIndex__astro__id_field';
    }



    public function beforeAddIndex__astro__id_field()
    {
        return $this->beforeAddIndex('astro', 'id_field');
    }

    public function afterAddIndex__astro__id_field()
    {
        return $this->afterAddIndex('astro', 'id_field');
    }
}
