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

class Migration_331 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddIndex__affiliates__agencyid';
        $this->aTaskList_constructive[] = 'afterAddIndex__affiliates__agencyid';
        $this->aTaskList_constructive[] = 'beforeAddIndex__campaigns__clientid';
        $this->aTaskList_constructive[] = 'afterAddIndex__campaigns__clientid';
        $this->aTaskList_constructive[] = 'beforeAddIndex__clients__agencyid';
        $this->aTaskList_constructive[] = 'afterAddIndex__clients__agencyid';
        $this->aTaskList_constructive[] = 'beforeAddIndex__trackers__clientid';
        $this->aTaskList_constructive[] = 'afterAddIndex__trackers__clientid';
        $this->aTaskList_constructive[] = 'beforeAddIndex__variables__variables_is_unique';
        $this->aTaskList_constructive[] = 'afterAddIndex__variables__variables_is_unique';
        $this->aTaskList_constructive[] = 'beforeAddIndex__variables__trackerid';
        $this->aTaskList_constructive[] = 'afterAddIndex__variables__trackerid';
        $this->aTaskList_constructive[] = 'beforeAddIndex__zones__affiliateid';
        $this->aTaskList_constructive[] = 'afterAddIndex__zones__affiliateid';
    }



    public function beforeAddIndex__affiliates__agencyid()
    {
        return $this->beforeAddIndex('affiliates', 'agencyid');
    }

    public function afterAddIndex__affiliates__agencyid()
    {
        return $this->afterAddIndex('affiliates', 'agencyid');
    }

    public function beforeAddIndex__campaigns__clientid()
    {
        return $this->beforeAddIndex('campaigns', 'clientid');
    }

    public function afterAddIndex__campaigns__clientid()
    {
        return $this->afterAddIndex('campaigns', 'clientid');
    }

    public function beforeAddIndex__clients__agencyid()
    {
        return $this->beforeAddIndex('clients', 'agencyid');
    }

    public function afterAddIndex__clients__agencyid()
    {
        return $this->afterAddIndex('clients', 'agencyid');
    }

    public function beforeAddIndex__trackers__clientid()
    {
        return $this->beforeAddIndex('trackers', 'clientid');
    }

    public function afterAddIndex__trackers__clientid()
    {
        return $this->afterAddIndex('trackers', 'clientid');
    }

    public function beforeAddIndex__variables__variables_is_unique()
    {
        return $this->beforeAddIndex('variables', 'variables_is_unique');
    }

    public function afterAddIndex__variables__variables_is_unique()
    {
        return $this->afterAddIndex('variables', 'variables_is_unique');
    }

    public function beforeAddIndex__variables__trackerid()
    {
        return $this->beforeAddIndex('variables', 'trackerid');
    }

    public function afterAddIndex__variables__trackerid()
    {
        return $this->afterAddIndex('variables', 'trackerid');
    }

    public function beforeAddIndex__zones__affiliateid()
    {
        return $this->beforeAddIndex('zones', 'affiliateid');
    }

    public function afterAddIndex__zones__affiliateid()
    {
        return $this->afterAddIndex('zones', 'affiliateid');
    }
}
