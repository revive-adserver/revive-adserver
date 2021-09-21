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

class Migration_002 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__testplugin_table__test_newfield';
        $this->aTaskList_constructive[] = 'afterAddField__testplugin_table__test_newfield';


        $this->aObjectMap['testplugin_table']['test_newfield'] = ['fromTable' => 'testplugin_table', 'fromField' => 'test_newfield'];
    }



    public function beforeAddField__testplugin_table__test_newfield()
    {
        return $this->beforeAddField('testplugin_table', 'test_newfield');
    }

    public function afterAddField__testplugin_table__test_newfield()
    {
        return $this->afterAddField('testplugin_table', 'test_newfield');
    }
}
