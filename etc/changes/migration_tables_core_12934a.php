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

class Migration_12934a extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddIndex__affiliates__affiliates_agencyid';
        $this->aTaskList_constructive[] = 'afterAddIndex__affiliates__affiliates_agencyid';
        $this->aTaskList_constructive[] = 'beforeAddIndex__banners__banners_campaignid';
        $this->aTaskList_constructive[] = 'afterAddIndex__banners__banners_campaignid';
        $this->aTaskList_constructive[] = 'beforeAddIndex__clients__clients_agencyid';
        $this->aTaskList_constructive[] = 'afterAddIndex__clients__clients_agencyid';
        $this->aTaskList_constructive[] = 'beforeAddIndex__zones__affiliateid';
        $this->aTaskList_constructive[] = 'afterAddIndex__zones__affiliateid';
    }

    public function beforeAddIndex__affiliates__affiliates_agencyid()
    {
        return $this->beforeAddIndex('affiliates', 'affiliates_agencyid');
    }

    public function afterAddIndex__affiliates__affiliates_agencyid()
    {
        return $this->afterAddIndex('affiliates', 'affiliates_agencyid');
    }

    public function beforeAddIndex__banners__banners_campaignid()
    {
        return $this->beforeAddIndex('banners', 'banners_campaignid');
    }

    public function afterAddIndex__banners__banners_campaignid()
    {
        return $this->afterAddIndex('banners', 'banners_campaignid');
    }

    public function beforeAddIndex__clients__clients_agencyid()
    {
        return $this->beforeAddIndex('clients', 'clients_agencyid');
    }

    public function afterAddIndex__clients__clients_agencyid()
    {
        return $this->afterAddIndex('clients', 'clients_agencyid');
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
