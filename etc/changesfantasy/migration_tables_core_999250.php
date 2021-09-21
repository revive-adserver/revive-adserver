<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_999250 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__astro__auto_field';
        $this->aTaskList_constructive[] = 'afterAddField__astro__auto_field';
        $this->aTaskList_constructive[] = 'beforeAddIndex__astro__astro_pkey';
        $this->aTaskList_constructive[] = 'afterAddIndex__astro__astro_pkey';


        $this->aObjectMap['astro']['auto_field'] = ['fromTable' => 'astro', 'fromField' => 'auto_field'];
    }



    public function beforeAddField__astro__auto_field()
    {
        return $this->beforeAddField('astro', 'auto_field');
    }

    public function afterAddField__astro__auto_field()
    {
        return $this->afterAddField('astro', 'auto_field');
    }

    public function beforeAddIndex__astro__astro_pkey()
    {
        return $this->beforeAddIndex('astro', 'astro_pkey');
    }

    public function afterAddIndex__astro__astro_pkey()
    {
        return $this->afterAddIndex('astro', 'astro_pkey');
    }
}
