<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_999500 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_destructive[] = 'beforeRemoveTable__bender';
        $this->aTaskList_destructive[] = 'afterRemoveTable__bender';
        $this->aTaskList_destructive[] = 'beforeRemoveField__klapaucius__text_field';
        $this->aTaskList_destructive[] = 'afterRemoveField__klapaucius__text_field';
        $this->aTaskList_destructive[] = 'beforeRemoveIndex__klapaucius__klapaucius_pkey';
        $this->aTaskList_destructive[] = 'afterRemoveField__klapaucius__klapaucius_pkey';
    }



    public function beforeRemoveTable__bender()
    {
        return $this->beforeRemoveTable('bender');
    }

    public function afterRemoveTable__bender()
    {
        return $this->afterRemoveTable('bender');
    }

    public function beforeRemoveField__klapaucius__text_field()
    {
        return $this->beforeRemoveField('klapaucius', 'text_field');
    }

    public function afterRemoveField__klapaucius__text_field()
    {
        return $this->afterRemoveField('klapaucius', 'text_field');
    }

    public function beforeRemoveIndex__klapaucius__astro_pkey()
    {
        return $this->beforeRemoveIndex('klapaucius', 'klapaucius_pkey');
    }

    public function afterRemoveField__klapaucius__astro_pkey()
    {
        return $this->afterRemoveIndex('klapaucius', 'klapaucius_pkey');
    }
}
