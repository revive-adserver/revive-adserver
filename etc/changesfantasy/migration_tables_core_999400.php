<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_999400 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddIndex__astro__astro_pkey';
        $this->aTaskList_constructive[] = 'afterAddIndex__astro__astro_pkey';
        $this->aTaskList_constructive[] = 'beforeRemoveIndex__astro__id_field';
        $this->aTaskList_constructive[] = 'afterRemoveIndex__astro__id_field';
    }



    public function beforeAddIndex__astro__astro_pkey()
    {
        return $this->beforeAddIndex('astro', 'astro_pkey');
    }

    public function afterAddIndex__astro__astro_pkey()
    {
        return $this->afterAddIndex('astro', 'astro_pkey');
    }

    public function beforeRemoveIndex__astro__id_field()
    {
        return $this->beforeRemoveIndex('astro', 'id_field');
    }

    public function afterRemoveIndex__astro__id_field()
    {
        return $this->afterRemoveIndex('astro', 'id_field');
    }
}
