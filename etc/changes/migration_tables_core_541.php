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

class Migration_541 extends Migration
{

    function Migration_541()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__an_website_id';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__an_website_id';
		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__as_website_id';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__as_website_id';
		$this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__oac_website_id';
		$this->aTaskList_destructive[] = 'afterRemoveField__affiliates__oac_website_id';


		$this->aObjectMap['affiliates']['an_website_id'] = array('fromTable'=>'affiliates', 'fromField'=>'oac_website_id');
		$this->aObjectMap['affiliates']['as_website_id'] = array('fromTable'=>'affiliates', 'fromField'=>'as_website_id');
    }



	function beforeAddField__affiliates__an_website_id()
	{
		return $this->beforeAddField('affiliates', 'an_website_id');
	}

	function afterAddField__affiliates__an_website_id()
	{
		return $this->afterAddField('affiliates', 'an_website_id');
	}

	function beforeAddField__affiliates__as_website_id()
	{
		return $this->beforeAddField('affiliates', 'as_website_id');
	}

	function afterAddField__affiliates__as_website_id()
	{
		return $this->afterAddField('affiliates', 'as_website_id');
	}

	function beforeRemoveField__affiliates__oac_website_id()
	{
		return $this->beforeRemoveField('affiliates', 'oac_website_id');
	}

	function afterRemoveField__affiliates__oac_website_id()
	{
		return $this->afterRemoveField('affiliates', 'oac_website_id');
	}

}

?>