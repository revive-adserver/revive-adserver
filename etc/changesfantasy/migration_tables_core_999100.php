<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_999100 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddTable__astro';
        $this->aTaskList_constructive[] = 'afterAddTable__astro';
        $this->aTaskList_constructive[] = 'beforeAddTable__bender';
        $this->aTaskList_constructive[] = 'afterAddTable__bender';
    }



    public function beforeAddTable__astro()
    {
        return $this->beforeAddTable('astro');
    }

    public function afterAddTable__astro()
    {
        return $this->afterAddTable('astro');
    }

    public function beforeAddTable__bender()
    {
        return $this->beforeAddTable('bender');
    }

    public function afterAddTable__bender()
    {
        return $this->afterAddTable('bender');
    }
}
