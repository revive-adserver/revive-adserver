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

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_131 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddIndex__affiliates__agencyid';
		$this->aTaskList_constructive[] = 'afterAddIndex__affiliates__agencyid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__banners__campaignid';
		$this->aTaskList_constructive[] = 'afterAddIndex__banners__campaignid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__clients__agencyid';
		$this->aTaskList_constructive[] = 'afterAddIndex__clients__agencyid';


    }



	function beforeAddIndex__affiliates__agencyid()
	{
		return $this->beforeAddIndex('affiliates', 'agencyid');
	}

	function afterAddIndex__affiliates__agencyid()
	{
		return $this->afterAddIndex('affiliates', 'agencyid');
	}

	function beforeAddIndex__banners__campaignid()
	{
		return $this->beforeAddIndex('banners', 'campaignid');
	}

	function afterAddIndex__banners__campaignid()
	{
		return $this->afterAddIndex('banners', 'campaignid');
	}

	function beforeAddIndex__clients__agencyid()
	{
		return $this->beforeAddIndex('clients', 'agencyid');
	}

	function afterAddIndex__clients__agencyid()
	{
		return $this->afterAddIndex('clients', 'agencyid');
	}

}

?>