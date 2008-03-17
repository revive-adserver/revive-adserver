<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_336 extends Migration
{

    function Migration_336()
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