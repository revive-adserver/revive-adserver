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

class Migration_334 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAlterField__variables__trackerid';
		$this->aTaskList_constructive[] = 'afterAlterField__variables__trackerid';
		$this->aTaskList_constructive[] = 'beforeAlterField__variables__datatype';
		$this->aTaskList_constructive[] = 'afterAlterField__variables__datatype';
		$this->aTaskList_destructive[] = 'beforeRemoveField__banners__priority';
		$this->aTaskList_destructive[] = 'afterRemoveField__banners__priority';
		$this->aTaskList_destructive[] = 'beforeRemoveField__campaigns__target';
		$this->aTaskList_destructive[] = 'afterRemoveField__campaigns__target';
		$this->aTaskList_destructive[] = 'beforeRemoveField__campaigns__optimise';
		$this->aTaskList_destructive[] = 'afterRemoveField__campaigns__optimise';
		$this->aTaskList_destructive[] = 'beforeRemoveField__campaigns_trackers__logstats';
		$this->aTaskList_destructive[] = 'afterRemoveField__campaigns_trackers__logstats';
		$this->aTaskList_destructive[] = 'beforeRemoveField__variables__variabletype';
		$this->aTaskList_destructive[] = 'afterRemoveField__variables__variabletype';


    }



	function beforeAlterField__variables__trackerid()
	{
		return $this->beforeAlterField('variables', 'trackerid');
	}

	function afterAlterField__variables__trackerid()
	{
		return $this->afterAlterField('variables', 'trackerid');
	}

	function beforeAlterField__variables__datatype()
	{
		return $this->beforeAlterField('variables', 'datatype');
	}

	/**
	 * After this alter command, anything which was "int" now needs to be "numeric"
	 *
	 * @return unknown
	 */
	function afterAlterField__variables__datatype()
	{
	    $prefix = $this->getPrefix();
	    $query = "UPDATE {$prefix}variables SET datatype='numeric' WHERE datatype=''";

	    return $this->oDBH->exec($query) && $this->afterAlterField('variables', 'datatype');
	}

	function beforeRemoveField__banners__priority()
	{
		return $this->beforeRemoveField('banners', 'priority');
	}

	function afterRemoveField__banners__priority()
	{
		return $this->afterRemoveField('banners', 'priority');
	}

	function beforeRemoveField__campaigns__target()
	{
		return $this->beforeRemoveField('campaigns', 'target');
	}

	function afterRemoveField__campaigns__target()
	{
		return $this->afterRemoveField('campaigns', 'target');
	}

	function beforeRemoveField__campaigns__optimise()
	{
		return $this->beforeRemoveField('campaigns', 'optimise');
	}

	function afterRemoveField__campaigns__optimise()
	{
		return $this->afterRemoveField('campaigns', 'optimise');
	}

	function beforeRemoveField__campaigns_trackers__logstats()
	{
		return $this->beforeRemoveField('campaigns_trackers', 'logstats');
	}

	function afterRemoveField__campaigns_trackers__logstats()
	{
		return $this->afterRemoveField('campaigns_trackers', 'logstats');
	}

	function beforeRemoveField__variables__variabletype()
	{
		return $this->beforeRemoveField('variables', 'variabletype');
	}

	function afterRemoveField__variables__variabletype()
	{
		return $this->afterRemoveField('variables', 'variabletype');
	}

}

?>