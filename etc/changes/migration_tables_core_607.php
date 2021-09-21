<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_607 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__ecpm_enabled';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__ecpm_enabled';


        $this->aObjectMap['campaigns']['ecpm_enabled'] = ['fromTable' => 'campaigns', 'fromField' => 'ecpm_enabled'];
    }



    public function beforeAddField__campaigns__ecpm_enabled()
    {
        return $this->beforeAddField('campaigns', 'ecpm_enabled');
    }

    public function afterAddField__campaigns__ecpm_enabled()
    {
        return $this->afterAddField('campaigns', 'ecpm_enabled');
    }
}
