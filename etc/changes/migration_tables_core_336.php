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

class Migration_336 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAlterField__session__sessiondata';
        $this->aTaskList_constructive[] = 'afterAlterField__session__sessiondata';
        $this->aTaskList_constructive[] = 'beforeAlterField__zones__what';
        $this->aTaskList_constructive[] = 'afterAlterField__zones__what';
        $this->aTaskList_constructive[] = 'beforeAlterField__zones__chain';
        $this->aTaskList_constructive[] = 'afterAlterField__zones__chain';
        $this->aTaskList_constructive[] = 'beforeAlterField__zones__prepend';
        $this->aTaskList_constructive[] = 'afterAlterField__zones__prepend';
        $this->aTaskList_constructive[] = 'beforeAlterField__zones__append';
        $this->aTaskList_constructive[] = 'afterAlterField__zones__append';
    }



    public function beforeAlterField__session__sessiondata()
    {
        return $this->beforeAlterField('session', 'sessiondata');
    }

    public function afterAlterField__session__sessiondata()
    {
        return $this->afterAlterField('session', 'sessiondata');
    }

    public function beforeAlterField__zones__what()
    {
        return $this->beforeAlterField('zones', 'what');
    }

    public function afterAlterField__zones__what()
    {
        return $this->afterAlterField('zones', 'what');
    }

    public function beforeAlterField__zones__chain()
    {
        return $this->beforeAlterField('zones', 'chain');
    }

    public function afterAlterField__zones__chain()
    {
        return $this->afterAlterField('zones', 'chain');
    }

    public function beforeAlterField__zones__prepend()
    {
        return $this->beforeAlterField('zones', 'prepend');
    }

    public function afterAlterField__zones__prepend()
    {
        return $this->afterAlterField('zones', 'prepend');
    }

    public function beforeAlterField__zones__append()
    {
        return $this->beforeAlterField('zones', 'append');
    }

    public function afterAlterField__zones__append()
    {
        return $this->afterAlterField('zones', 'append');
    }
}
