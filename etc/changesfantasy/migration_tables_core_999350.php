<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_999350 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeRemoveIndex__astro__astro_pkey';
        $this->aTaskList_constructive[] = 'afterRemoveIndex__astro__astro_pkey';
        $this->aTaskList_destructive[] = 'beforeRemoveField__astro__auto_renamed_field';
        $this->aTaskList_destructive[] = 'afterRemoveField__astro__auto_renamed_field';
    }



    public function beforeRemoveIndex__astro__astro_pkey()
    {
        return $this->beforeRemoveIndex('astro', 'astro_pkey');
    }

    public function afterRemoveIndex__astro__astro_pkey()
    {
        return $this->afterRemoveIndex('astro', 'astro_pkey');
    }

    public function beforeRemoveField__astro__auto_renamed_field()
    {
        return $this->beforeRemoveField('astro', 'auto_renamed_field');
    }

    public function afterRemoveField__astro__auto_renamed_field()
    {
        return $this->afterRemoveField('astro', 'auto_renamed_field');
    }
}
