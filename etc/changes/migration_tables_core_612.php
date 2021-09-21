<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_612 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__type';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__type';
        $this->aTaskList_constructive[] = 'beforeAddField__clients__type';
        $this->aTaskList_constructive[] = 'afterAddField__clients__type';
        $this->aTaskList_constructive[] = 'beforeAddIndex__clients__clients_agencyid_type';
        $this->aTaskList_constructive[] = 'afterAddIndex__clients__clients_agencyid_type';
        $this->aTaskList_constructive[] = 'beforeRemoveIndex__clients__clients_agencyid';
        $this->aTaskList_constructive[] = 'afterRemoveIndex__clients__clients_agencyid';


        $this->aObjectMap['campaigns']['type'] = ['fromTable' => 'campaigns', 'fromField' => 'type'];
        $this->aObjectMap['clients']['type'] = ['fromTable' => 'clients', 'fromField' => 'type'];
    }



    public function beforeAddField__campaigns__type()
    {
        return $this->beforeAddField('campaigns', 'type');
    }

    public function afterAddField__campaigns__type()
    {
        return $this->afterAddField('campaigns', 'type');
    }

    public function beforeAddField__clients__type()
    {
        return $this->beforeAddField('clients', 'type');
    }

    public function afterAddField__clients__type()
    {
        return $this->afterAddField('clients', 'type');
    }

    public function beforeAddIndex__clients__clients_agencyid_type()
    {
        return $this->beforeAddIndex('clients', 'clients_agencyid_type');
    }

    public function afterAddIndex__clients__clients_agencyid_type()
    {
        return $this->afterAddIndex('clients', 'clients_agencyid_type');
    }

    public function beforeRemoveIndex__clients__clients_agencyid()
    {
        return $this->beforeRemoveIndex('clients', 'clients_agencyid');
    }

    public function afterRemoveIndex__clients__clients_agencyid()
    {
        return $this->afterRemoveIndex('clients', 'clients_agencyid');
    }
}
