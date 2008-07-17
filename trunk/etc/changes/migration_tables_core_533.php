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

class Migration_533 extends Migration
{

    function Migration_533()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__oac_country_code';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__oac_country_code';
		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__oac_language_id';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__oac_language_id';
		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__oac_category_id';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__oac_category_id';


		$this->aObjectMap['affiliates']['oac_country_code'] = array('fromTable'=>'affiliates', 'fromField'=>'oac_country_code');
		$this->aObjectMap['affiliates']['oac_language_id'] = array('fromTable'=>'affiliates', 'fromField'=>'oac_language_id');
		$this->aObjectMap['affiliates']['oac_category_id'] = array('fromTable'=>'affiliates', 'fromField'=>'oac_category_id');
    }



	function beforeAddField__affiliates__oac_country_code()
	{
		return $this->beforeAddField('affiliates', 'oac_country_code');
	}

	function afterAddField__affiliates__oac_country_code()
	{
		return $this->afterAddField('affiliates', 'oac_country_code');
	}

	function beforeAddField__affiliates__oac_language_id()
	{
		return $this->beforeAddField('affiliates', 'oac_language_id');
	}

	function afterAddField__affiliates__oac_language_id()
	{
		return $this->afterAddField('affiliates', 'oac_language_id');
	}

	function beforeAddField__affiliates__oac_category_id()
	{
		return $this->beforeAddField('affiliates', 'oac_category_id');
	}

	function afterAddField__affiliates__oac_category_id()
	{
		return $this->afterAddField('affiliates', 'oac_category_id');
	}

}

?>