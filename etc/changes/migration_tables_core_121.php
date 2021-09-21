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

class Migration_121 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAlterField__acls__type';
        $this->aTaskList_constructive[] = 'afterAlterField__acls__type';
    }

    public function beforeAlterField__acls__type()
    {
        return $this->beforeAlterField('acls', 'type');
    }

    public function afterAlterField__acls__type()
    {
        return $this->afterAlterField('acls', 'type');
    }
}
