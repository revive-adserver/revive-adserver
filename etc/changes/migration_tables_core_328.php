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

class Migration_328 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__trackers__status';
        $this->aTaskList_constructive[] = 'afterAddField__trackers__status';
        $this->aTaskList_constructive[] = 'beforeAddField__trackers__type';
        $this->aTaskList_constructive[] = 'afterAddField__trackers__type';
        $this->aTaskList_constructive[] = 'beforeAddField__trackers__linkcampaigns';
        $this->aTaskList_constructive[] = 'afterAddField__trackers__linkcampaigns';
        $this->aTaskList_constructive[] = 'beforeAddField__trackers__variablemethod';
        $this->aTaskList_constructive[] = 'afterAddField__trackers__variablemethod';
        $this->aTaskList_constructive[] = 'beforeAddField__trackers__appendcode';
        $this->aTaskList_constructive[] = 'afterAddField__trackers__appendcode';
        $this->aTaskList_constructive[] = 'beforeAddField__trackers__updated';
        $this->aTaskList_constructive[] = 'afterAddField__trackers__updated';


        $this->aObjectMap['trackers']['status'] = ['fromTable' => 'trackers', 'fromField' => 'status'];
        $this->aObjectMap['trackers']['type'] = ['fromTable' => 'trackers', 'fromField' => 'type'];
        $this->aObjectMap['trackers']['linkcampaigns'] = ['fromTable' => 'trackers', 'fromField' => 'linkcampaigns'];
        $this->aObjectMap['trackers']['variablemethod'] = ['fromTable' => 'trackers', 'fromField' => 'variablemethod'];
        $this->aObjectMap['trackers']['appendcode'] = ['fromTable' => 'trackers', 'fromField' => 'appendcode'];
        $this->aObjectMap['trackers']['updated'] = ['fromTable' => 'trackers', 'fromField' => 'updated'];
    }



    public function beforeAddField__trackers__status()
    {
        return $this->beforeAddField('trackers', 'status');
    }

    public function afterAddField__trackers__status()
    {
        return $this->afterAddField('trackers', 'status');
    }

    public function beforeAddField__trackers__type()
    {
        return $this->beforeAddField('trackers', 'type');
    }

    public function afterAddField__trackers__type()
    {
        return $this->afterAddField('trackers', 'type');
    }

    public function beforeAddField__trackers__linkcampaigns()
    {
        return $this->beforeAddField('trackers', 'linkcampaigns');
    }

    public function afterAddField__trackers__linkcampaigns()
    {
        return $this->afterAddField('trackers', 'linkcampaigns');
    }

    public function beforeAddField__trackers__variablemethod()
    {
        return $this->beforeAddField('trackers', 'variablemethod');
    }

    public function afterAddField__trackers__variablemethod()
    {
        return $this->afterAddField('trackers', 'variablemethod');
    }

    public function beforeAddField__trackers__appendcode()
    {
        return $this->beforeAddField('trackers', 'appendcode');
    }

    public function afterAddField__trackers__appendcode()
    {
        return $this->afterAddField('trackers', 'appendcode');
    }

    public function beforeAddField__trackers__updated()
    {
        return $this->beforeAddField('trackers', 'updated');
    }

    public function afterAddField__trackers__updated()
    {
        return $this->afterAddField('trackers', 'updated');
    }
}
