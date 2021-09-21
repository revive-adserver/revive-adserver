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

class Migration_123 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__affiliates__agencyid';
        $this->aTaskList_constructive[] = 'afterAddField__affiliates__agencyid';
        $this->aTaskList_constructive[] = 'beforeAddField__affiliates__mnemonic';
        $this->aTaskList_constructive[] = 'afterAddField__affiliates__mnemonic';
        $this->aTaskList_constructive[] = 'beforeAddField__affiliates__comments';
        $this->aTaskList_constructive[] = 'afterAddField__affiliates__comments';
        $this->aTaskList_constructive[] = 'beforeAddField__affiliates__last_accepted_agency_agreement';
        $this->aTaskList_constructive[] = 'afterAddField__affiliates__last_accepted_agency_agreement';
        $this->aTaskList_constructive[] = 'beforeAddField__affiliates__updated';
        $this->aTaskList_constructive[] = 'afterAddField__affiliates__updated';


        $this->aObjectMap['affiliates']['agencyid'] = ['fromTable' => 'affiliates', 'fromField' => 'agencyid'];
        $this->aObjectMap['affiliates']['mnemonic'] = ['fromTable' => 'affiliates', 'fromField' => 'mnemonic'];
        $this->aObjectMap['affiliates']['comments'] = ['fromTable' => 'affiliates', 'fromField' => 'comments'];
        $this->aObjectMap['affiliates']['last_accepted_agency_agreement'] = ['fromTable' => 'affiliates', 'fromField' => 'last_accepted_agency_agreement'];
        $this->aObjectMap['affiliates']['updated'] = ['fromTable' => 'affiliates', 'fromField' => 'updated'];
    }



    public function beforeAddField__affiliates__agencyid()
    {
        return $this->beforeAddField('affiliates', 'agencyid');
    }

    public function afterAddField__affiliates__agencyid()
    {
        return $this->afterAddField('affiliates', 'agencyid');
    }

    public function beforeAddField__affiliates__mnemonic()
    {
        return $this->beforeAddField('affiliates', 'mnemonic');
    }

    public function afterAddField__affiliates__mnemonic()
    {
        return $this->afterAddField('affiliates', 'mnemonic');
    }

    public function beforeAddField__affiliates__comments()
    {
        return $this->beforeAddField('affiliates', 'comments');
    }

    public function afterAddField__affiliates__comments()
    {
        return $this->afterAddField('affiliates', 'comments');
    }

    public function beforeAddField__affiliates__last_accepted_agency_agreement()
    {
        return $this->beforeAddField('affiliates', 'last_accepted_agency_agreement');
    }

    public function afterAddField__affiliates__last_accepted_agency_agreement()
    {
        return $this->afterAddField('affiliates', 'last_accepted_agency_agreement');
    }

    public function beforeAddField__affiliates__updated()
    {
        return $this->beforeAddField('affiliates', 'updated');
    }

    public function afterAddField__affiliates__updated()
    {
        return $this->afterAddField('affiliates', 'updated');
    }
}
