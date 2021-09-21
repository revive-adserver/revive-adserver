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

class Migration_541 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__affiliates__an_website_id';
        $this->aTaskList_constructive[] = 'afterAddField__affiliates__an_website_id';
        $this->aTaskList_constructive[] = 'beforeAddField__affiliates__as_website_id';
        $this->aTaskList_constructive[] = 'afterAddField__affiliates__as_website_id';
        $this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__oac_website_id';
        $this->aTaskList_destructive[] = 'afterRemoveField__affiliates__oac_website_id';


        $this->aObjectMap['affiliates']['an_website_id'] = ['fromTable' => 'affiliates', 'fromField' => 'oac_website_id'];
        $this->aObjectMap['affiliates']['as_website_id'] = ['fromTable' => 'affiliates', 'fromField' => 'as_website_id'];
    }



    public function beforeAddField__affiliates__an_website_id()
    {
        return $this->beforeAddField('affiliates', 'an_website_id');
    }

    public function afterAddField__affiliates__an_website_id()
    {
        return $this->afterAddField('affiliates', 'an_website_id');
    }

    public function beforeAddField__affiliates__as_website_id()
    {
        return $this->beforeAddField('affiliates', 'as_website_id');
    }

    public function afterAddField__affiliates__as_website_id()
    {
        return $this->afterAddField('affiliates', 'as_website_id');
    }

    public function beforeRemoveField__affiliates__oac_website_id()
    {
        return $this->beforeRemoveField('affiliates', 'oac_website_id');
    }

    public function afterRemoveField__affiliates__oac_website_id()
    {
        return $this->afterRemoveField('affiliates', 'oac_website_id');
    }
}
