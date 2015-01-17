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

class Migration_336 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAlterField__session__sessiondata';
		$this->aTaskList_constructive[] = 'afterAlterField__session__sessiondata';
		$this->aTaskList_constructive[] = 'beforeAlterField__zones__what';
		$this->aTaskList_constructive[] = 'afterAlterField__zones__what';
		$this->aTaskList_constructive[] = 'beforeAlterField__zones__chain';
		$this->aTaskList_constructive[] = 'afterAlterField__zones__chain';
		$this->aTaskList_constructive[] = 'beforeAlterField__zones__prepend';
		$this->aTaskList_constructive[] = 'afterAlterField__zones__prepend';
		$this->aTaskList_constructive[] = 'beforeAlterField__zones__append';
		$this->aTaskList_constructive[] = 'afterAlterField__zones__append';


    }



	function beforeAlterField__session__sessiondata()
	{
		return $this->beforeAlterField('session', 'sessiondata');
	}

	function afterAlterField__session__sessiondata()
	{
		return $this->afterAlterField('session', 'sessiondata');
	}

	function beforeAlterField__zones__what()
	{
		return $this->beforeAlterField('zones', 'what');
	}

	function afterAlterField__zones__what()
	{
		return $this->afterAlterField('zones', 'what');
	}

	function beforeAlterField__zones__chain()
	{
		return $this->beforeAlterField('zones', 'chain');
	}

	function afterAlterField__zones__chain()
	{
		return $this->afterAlterField('zones', 'chain');
	}

	function beforeAlterField__zones__prepend()
	{
		return $this->beforeAlterField('zones', 'prepend');
	}

	function afterAlterField__zones__prepend()
	{
		return $this->afterAlterField('zones', 'prepend');
	}

	function beforeAlterField__zones__append()
	{
		return $this->beforeAlterField('zones', 'append');
	}

	function afterAlterField__zones__append()
	{
		return $this->afterAlterField('zones', 'append');
	}

}

?>