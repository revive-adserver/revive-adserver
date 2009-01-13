<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

class Migration_334 extends Migration
{

    function Migration_334()
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