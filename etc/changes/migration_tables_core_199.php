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

require_once MAX_PATH . '/etc/changes/StatMigration.php';
require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_199 extends Migration
{

    function Migration_199()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveTable__adclicks';
		$this->aTaskList_destructive[] = 'afterRemoveTable__adclicks';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__adstats';
		$this->aTaskList_destructive[] = 'afterRemoveTable__adstats';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__adviews';
		$this->aTaskList_destructive[] = 'afterRemoveTable__adviews';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__cache';
		$this->aTaskList_destructive[] = 'afterRemoveTable__cache';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__config';
		$this->aTaskList_destructive[] = 'afterRemoveTable__config';


    }



	function beforeRemoveTable__adclicks()
	{
		return $this->beforeRemoveTable('adclicks');
	}

	function afterRemoveTable__adclicks()
	{
		return $this->afterRemoveTable('adclicks');
	}

	function beforeRemoveTable__adstats()
	{
	    $migration = new StatMigration();
	    $migration->init($this->oDBH, $this->logFile);
		return $migration->correctCampaignTargets() && $this->beforeRemoveTable('adstats');
	}

	function afterRemoveTable__adstats()
	{
		return $this->afterRemoveTable('adstats');
	}

	function beforeRemoveTable__adviews()
	{
		return $this->beforeRemoveTable('adviews');
	}

	function afterRemoveTable__adviews()
	{
		return $this->afterRemoveTable('adviews');
	}

	function beforeRemoveTable__cache()
	{
		return $this->beforeRemoveTable('cache');
	}

	function afterRemoveTable__cache()
	{
		return $this->afterRemoveTable('cache');
	}

	function beforeRemoveTable__config()
	{
		return $this->beforeRemoveTable('config');
	}

	function afterRemoveTable__config()
	{
		return $this->afterRemoveTable('config');
	}

}

?>