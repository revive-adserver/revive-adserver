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

class Migration_532 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__clients__oac_adnetwork_id';
        $this->aTaskList_constructive[] = 'afterAddField__clients__oac_adnetwork_id';


        $this->aObjectMap['clients']['oac_adnetwork_id'] = ['fromTable' => 'clients', 'fromField' => 'oac_adnetwork_id'];
    }



    public function beforeAddField__clients__oac_adnetwork_id()
    {
        return $this->beforeAddField('clients', 'oac_adnetwork_id');
    }

    public function afterAddField__clients__oac_adnetwork_id()
    {
        return $this->afterAddField('clients', 'oac_adnetwork_id');
    }
}
