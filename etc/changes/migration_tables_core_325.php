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

class Migration_325 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__agency__logout_url';
        $this->aTaskList_constructive[] = 'afterAddField__agency__logout_url';
        $this->aTaskList_constructive[] = 'beforeAddField__agency__active';
        $this->aTaskList_constructive[] = 'afterAddField__agency__active';
        $this->aTaskList_constructive[] = 'beforeAddField__agency__updated';
        $this->aTaskList_constructive[] = 'afterAddField__agency__updated';


        $this->aObjectMap['agency']['logout_url'] = ['fromTable' => 'agency', 'fromField' => 'logout_url'];
        $this->aObjectMap['agency']['active'] = ['fromTable' => 'agency', 'fromField' => 'active'];
        $this->aObjectMap['agency']['updated'] = ['fromTable' => 'agency', 'fromField' => 'updated'];
    }



    public function beforeAddField__agency__logout_url()
    {
        return $this->beforeAddField('agency', 'logout_url');
    }

    public function afterAddField__agency__logout_url()
    {
        return $this->afterAddField('agency', 'logout_url');
    }

    public function beforeAddField__agency__active()
    {
        return $this->beforeAddField('agency', 'active');
    }

    public function afterAddField__agency__active()
    {
        return $this->afterAddField('agency', 'active');
    }

    public function beforeAddField__agency__updated()
    {
        return $this->beforeAddField('agency', 'updated');
    }

    public function afterAddField__agency__updated()
    {
        return $this->afterAddField('agency', 'updated');
    }
}
