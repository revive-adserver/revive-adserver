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

class Migration_999 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddTable__bandicoot';
        $this->aTaskList_constructive[] = 'afterAddTable__bandicoot';
        $this->aTaskList_constructive[] = 'beforeRenameField__campaigns__campaign_id';
        $this->aTaskList_constructive[] = 'afterRenameField__campaigns__campaign_id';
        $this->aTaskList_constructive[] = 'beforeAlterField__campaigns__fields';
        $this->aTaskList_constructive[] = 'afterAlterField__campaigns__fields';
        $this->aTaskList_constructive[] = 'beforeRemoveTable__affiliates';
        $this->aTaskList_constructive[] = 'afterRemoveTable__affiliates';


        $this->aObjectMap['campaigns']['campaign_id'] = ['fromTable' => 'campaigns', 'fromField' => 'campaignid'];
    }



    public function beforeAddTable__bandicoot()
    {
        return $this->beforeAddTable('bandicoot');
    }

    public function afterAddTable__bandicoot()
    {
        return $this->afterAddTable('bandicoot');
    }

    public function beforeRenameField__campaigns__campaign_id()
    {
        return $this->beforeRenameField('campaigns', 'campaign_id');
    }

    public function afterRenameField__campaigns__campaign_id()
    {
        return $this->afterRenameField('campaigns', 'campaign_id');
    }

    public function beforeAlterField__campaigns__fields()
    {
        return $this->beforeAlterField('campaigns', 'fields');
    }

    public function afterAlterField__campaigns__fields()
    {
        return $this->afterAlterField('campaigns', 'fields');
    }

    public function beforeRemoveTable__affiliates()
    {
        return $this->beforeRemoveTable('affiliates');
    }

    public function afterRemoveTable__affiliates()
    {
        return $this->afterRemoveTable('affiliates');
    }
}
