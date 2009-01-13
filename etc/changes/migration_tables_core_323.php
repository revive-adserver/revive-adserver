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

class Migration_323 extends Migration
{

    function Migration_323()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__comments';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__comments';
		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__last_accepted_agency_agreement';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__last_accepted_agency_agreement';
		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__updated';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__updated';


		$this->aObjectMap['affiliates']['comments'] = array('fromTable'=>'affiliates', 'fromField'=>'comments');
		$this->aObjectMap['affiliates']['last_accepted_agency_agreement'] = array('fromTable'=>'affiliates', 'fromField'=>'last_accepted_agency_agreement');
		$this->aObjectMap['affiliates']['updated'] = array('fromTable'=>'affiliates', 'fromField'=>'updated');
    }



	function beforeAddField__affiliates__comments()
	{
		return $this->beforeAddField('affiliates', 'comments');
	}

	function afterAddField__affiliates__comments()
	{
		return $this->afterAddField('affiliates', 'comments');
	}

	function beforeAddField__affiliates__last_accepted_agency_agreement()
	{
		return $this->beforeAddField('affiliates', 'last_accepted_agency_agreement');
	}

	function afterAddField__affiliates__last_accepted_agency_agreement()
	{
		return $this->afterAddField('affiliates', 'last_accepted_agency_agreement');
	}

	function beforeAddField__affiliates__updated()
	{
		return $this->beforeAddField('affiliates', 'updated');
	}

	function afterAddField__affiliates__updated()
	{
		return $this->afterAddField('affiliates', 'updated');
	}

}

?>