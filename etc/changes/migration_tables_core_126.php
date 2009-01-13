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

class Migration_126 extends Migration
{

    function Migration_126()
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