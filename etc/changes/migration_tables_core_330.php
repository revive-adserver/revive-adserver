<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_330 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__variables__purpose';
        $this->aTaskList_constructive[] = 'afterAddField__variables__purpose';
        $this->aTaskList_constructive[] = 'beforeAddField__variables__reject_if_empty';
        $this->aTaskList_constructive[] = 'afterAddField__variables__reject_if_empty';
        $this->aTaskList_constructive[] = 'beforeAddField__variables__is_unique';
        $this->aTaskList_constructive[] = 'afterAddField__variables__is_unique';
        $this->aTaskList_constructive[] = 'beforeAddField__variables__unique_window';
        $this->aTaskList_constructive[] = 'afterAddField__variables__unique_window';
        $this->aTaskList_constructive[] = 'beforeAddField__variables__variablecode';
        $this->aTaskList_constructive[] = 'afterAddField__variables__variablecode';
        $this->aTaskList_constructive[] = 'beforeAddField__variables__hidden';
        $this->aTaskList_constructive[] = 'afterAddField__variables__hidden';
        $this->aTaskList_constructive[] = 'beforeAddField__variables__updated';
        $this->aTaskList_constructive[] = 'afterAddField__variables__updated';


        $this->aObjectMap['variables']['purpose'] = ['fromTable' => 'variables', 'fromField' => 'purpose'];
        $this->aObjectMap['variables']['reject_if_empty'] = ['fromTable' => 'variables', 'fromField' => 'reject_if_empty'];
        $this->aObjectMap['variables']['is_unique'] = ['fromTable' => 'variables', 'fromField' => 'is_unique'];
        $this->aObjectMap['variables']['unique_window'] = ['fromTable' => 'variables', 'fromField' => 'unique_window'];
        $this->aObjectMap['variables']['variablecode'] = ['fromTable' => 'variables', 'fromField' => 'variablecode'];
        $this->aObjectMap['variables']['hidden'] = ['fromTable' => 'variables', 'fromField' => 'hidden'];
        $this->aObjectMap['variables']['updated'] = ['fromTable' => 'variables', 'fromField' => 'updated'];
    }



    public function beforeAddField__variables__purpose()
    {
        return $this->beforeAddField('variables', 'purpose');
    }

    public function afterAddField__variables__purpose()
    {
        return $this->afterAddField('variables', 'purpose');
    }

    public function beforeAddField__variables__reject_if_empty()
    {
        return $this->beforeAddField('variables', 'reject_if_empty');
    }

    public function afterAddField__variables__reject_if_empty()
    {
        return $this->afterAddField('variables', 'reject_if_empty');
    }

    public function beforeAddField__variables__is_unique()
    {
        return $this->beforeAddField('variables', 'is_unique');
    }

    public function afterAddField__variables__is_unique()
    {
        return $this->afterAddField('variables', 'is_unique');
    }

    public function beforeAddField__variables__unique_window()
    {
        return $this->beforeAddField('variables', 'unique_window');
    }

    public function afterAddField__variables__unique_window()
    {
        return $this->afterAddField('variables', 'unique_window');
    }

    public function beforeAddField__variables__variablecode()
    {
        return $this->beforeAddField('variables', 'variablecode');
    }

    public function afterAddField__variables__variablecode()
    {
        return $this->afterAddField('variables', 'variablecode');
    }

    public function beforeAddField__variables__hidden()
    {
        return $this->beforeAddField('variables', 'hidden');
    }

    public function afterAddField__variables__hidden()
    {
        return $this->afterAddField('variables', 'hidden');
    }

    public function beforeAddField__variables__updated()
    {
        return $this->beforeAddField('variables', 'updated');
    }

    public function afterAddField__variables__updated()
    {
        return $this->afterAddField('variables', 'updated');
    }
}
