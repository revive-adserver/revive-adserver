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

class Migration_131 extends Migration
{

    function Migration_131()
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