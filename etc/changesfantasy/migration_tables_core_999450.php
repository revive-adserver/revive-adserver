<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_999450 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_destructive[] = 'beforeAddTable__klapaucius';
        $this->aTaskList_destructive[] = 'afterAddTable__klapaucius';

        $this->aTaskList_destructive[] = 'beforeRemoveTable__astro';
        $this->aTaskList_destructive[] = 'afterRemoveTable__astro';

        $this->aObjectMap['klapaucius'] = ['fromTable' => 'astro'];
    }

    public function beforeAddTable__klapaucius()
    {
        return $this->beforeAddTable('klapaucius');
    }

    public function afterAddTable__klapaucius()
    {
        return $this->afterAddTable('klapaucius');
    }

    public function beforeRemoveTable__astro()
    {
        return $this->beforeRemoveTable('astro');
    }

    public function afterRemoveTable__astro()
    {
        return $this->afterRemoveTable('astro');
    }
}
