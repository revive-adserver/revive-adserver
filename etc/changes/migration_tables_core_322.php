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

class Migration_322 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__clients__comments';
		$this->aTaskList_constructive[] = 'afterAddField__clients__comments';
		$this->aTaskList_constructive[] = 'beforeAddField__clients__updated';
		$this->aTaskList_constructive[] = 'afterAddField__clients__updated';


		$this->aObjectMap['clients']['comments'] = array('fromTable'=>'clients', 'fromField'=>'comments');
		$this->aObjectMap['clients']['updated'] = array('fromTable'=>'clients', 'fromField'=>'updated');
    }



	function beforeAddField__clients__comments()
	{
		return $this->beforeAddField('clients', 'comments');
	}

	function afterAddField__clients__comments()
	{
		return $this->afterAddField('clients', 'comments');
	}

	function beforeAddField__clients__updated()
	{
		return $this->beforeAddField('clients', 'updated');
	}

	function afterAddField__clients__updated()
	{
		return $this->afterAddField('clients', 'updated');
	}

}

?>