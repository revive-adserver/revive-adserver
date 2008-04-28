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

class Migration_12934a extends Migration
{

    function Migration_12934a()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddIndex__affiliates__affiliates_agencyid';
		$this->aTaskList_constructive[] = 'afterAddIndex__affiliates__affiliates_agencyid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__banners__banners_campaignid';
		$this->aTaskList_constructive[] = 'afterAddIndex__banners__banners_campaignid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__clients__clients_agencyid';
		$this->aTaskList_constructive[] = 'afterAddIndex__clients__clients_agencyid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__zones__affiliateid';
		$this->aTaskList_constructive[] = 'afterAddIndex__zones__affiliateid';
    }

	function beforeAddIndex__affiliates__affiliates_agencyid()
	{
		return $this->beforeAddIndex('affiliates', 'affiliates_agencyid');
	}

	function afterAddIndex__affiliates__affiliates_agencyid()
	{
		return $this->afterAddIndex('affiliates', 'affiliates_agencyid');
	}

	function beforeAddIndex__banners__banners_campaignid()
	{
		return $this->beforeAddIndex('banners', 'banners_campaignid');
	}

	function afterAddIndex__banners__banners_campaignid()
	{
		return $this->afterAddIndex('banners', 'banners_campaignid');
	}

	function beforeAddIndex__clients__clients_agencyid()
	{
		return $this->beforeAddIndex('clients', 'clients_agencyid');
	}

	function afterAddIndex__clients__clients_agencyid()
	{
		return $this->afterAddIndex('clients', 'clients_agencyid');
	}

	function beforeAddIndex__zones__affiliateid()
	{
		return $this->beforeAddIndex('zones', 'affiliateid');
	}

	function afterAddIndex__zones__affiliateid()
	{
		return $this->afterAddIndex('zones', 'affiliateid');
	}


}

?>