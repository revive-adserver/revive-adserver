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

class Migration_126 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__targetstats__campaignid';
		$this->aTaskList_constructive[] = 'afterAddField__targetstats__campaignid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__targetstats__targetstats_pkey';
		$this->aTaskList_constructive[] = 'afterAddIndex__targetstats__targetstats_pkey';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__targetstats__targetstats_pkey';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__targetstats__targetstats_pkey';
		$this->aTaskList_destructive[] = 'beforeRemoveField__targetstats__clientid';
		$this->aTaskList_destructive[] = 'afterRemoveField__targetstats__clientid';


		$this->aObjectMap['targetstats']['campaignid'] = array('fromTable'=>'targetstats', 'fromField'=>'campaignid');
    }



	function beforeAddField__targetstats__campaignid()
	{
		return $this->beforeAddField('targetstats', 'campaignid');
	}

	function afterAddField__targetstats__campaignid()
	{
		return $this->migrateData() && $this->afterAddField('targetstats', 'campaignid');
	}

	function beforeAddIndex__targetstats__targetstats_pkey()
	{
		return $this->beforeAddIndex('targetstats', 'targetstats_pkey');
	}

	function afterAddIndex__targetstats__targetstats_pkey()
	{
		return $this->afterAddIndex('targetstats', 'targetstats_pkey');
	}

	function beforeRemoveIndex__targetstats__targetstats_pkey()
	{
		return $this->beforeRemoveIndex('targetstats', 'targetstats_pkey');
	}

	function afterRemoveIndex__targetstats__targetstats_pkey()
	{
		return $this->afterRemoveIndex('targetstats', 'targetstats_pkey');
	}

	function beforeRemoveField__targetstats__clientid()
	{
		return $this->beforeRemoveField('targetstats', 'clientid');
	}

	function afterRemoveField__targetstats__clientid()
	{
		return $this->afterRemoveField('targetstats', 'clientid');
	}

	function migrateData()
	{
	    $table = $this->oDBH->quoteIdentifier($GLOBALS['_MAX']['CONF']['table']['prefix'].'targetstats',true);
	    $query = "
	       UPDATE {$table}
	       set campaignid = clientid";
	    $result = $this->oDBH->exec($query);
	    if (PEAR::isError($result))
	    {
	        return false;
	    }
	    return true;
	}
}

?>