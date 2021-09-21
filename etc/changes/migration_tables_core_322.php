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

class Migration_322 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__clients__comments';
        $this->aTaskList_constructive[] = 'afterAddField__clients__comments';
        $this->aTaskList_constructive[] = 'beforeAddField__clients__updated';
        $this->aTaskList_constructive[] = 'afterAddField__clients__updated';


        $this->aObjectMap['clients']['comments'] = ['fromTable' => 'clients', 'fromField' => 'comments'];
        $this->aObjectMap['clients']['updated'] = ['fromTable' => 'clients', 'fromField' => 'updated'];
    }



    public function beforeAddField__clients__comments()
    {
        return $this->beforeAddField('clients', 'comments');
    }

    public function afterAddField__clients__comments()
    {
        return $this->afterAddField('clients', 'comments');
    }

    public function beforeAddField__clients__updated()
    {
        return $this->beforeAddField('clients', 'updated');
    }

    public function afterAddField__clients__updated()
    {
        return $this->afterAddField('clients', 'updated');
    }
}
