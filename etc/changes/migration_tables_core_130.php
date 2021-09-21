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

class Migration_130 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAlterField__acls__logical';
        $this->aTaskList_constructive[] = 'afterAlterField__acls__logical';
    }



    public function beforeAlterField__acls__logical()
    {
        return $this->beforeAlterField('acls', 'logical');
    }

    public function afterAlterField__acls__logical()
    {
        return $this->afterAlterField('acls', 'logical');
    }
}
