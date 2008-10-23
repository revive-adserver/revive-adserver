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

require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

class Migration_531 extends Migration
{

    function Migration_531()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__oac_website_id';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__oac_website_id';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__oac_banner_id';
		$this->aTaskList_constructive[] = 'afterAddField__banners__oac_banner_id';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__oac_campaign_id';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__oac_campaign_id';
		$this->aTaskList_destructive[] = 'beforeRemoveField__preference__instance_id';
		$this->aTaskList_destructive[] = 'afterRemoveField__preference__instance_id';


		$this->aObjectMap['affiliates']['oac_website_id'] = array('fromTable'=>'affiliates', 'fromField'=>'oac_website_id');
		$this->aObjectMap['banners']['oac_banner_id'] = array('fromTable'=>'banners', 'fromField'=>'oac_banner_id');
		$this->aObjectMap['campaigns']['oac_campaign_id'] = array('fromTable'=>'campaigns', 'fromField'=>'oac_campaign_id');
    }



	function beforeAddField__affiliates__oac_website_id()
	{
		return $this->beforeAddField('affiliates', 'oac_website_id');
	}

	function afterAddField__affiliates__oac_website_id()
	{
		return $this->afterAddField('affiliates', 'oac_website_id');
	}

	function beforeAddField__banners__oac_banner_id()
	{
		return $this->beforeAddField('banners', 'oac_banner_id');
	}

	function afterAddField__banners__oac_banner_id()
	{
		return $this->afterAddField('banners', 'oac_banner_id');
	}

	function beforeAddField__campaigns__oac_campaign_id()
	{
		return $this->beforeAddField('campaigns', 'oac_campaign_id');
	}

	function afterAddField__campaigns__oac_campaign_id()
	{
		return $this->afterAddField('campaigns', 'oac_campaign_id');
	}

	function beforeRemoveField__preference__instance_id()
	{
		return $this->migrateInstanceId() && $this->beforeRemoveField('preference', 'instance_id');
	}

	function afterRemoveField__preference__instance_id()
	{
		return $this->afterRemoveField('preference', 'instance_id');
	}

	function migrateInstanceId()
	{
	    $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $tblPref  = $this->oDBH->quoteIdentifier($prefix.'preference', true);
        $tblAVar  = $this->oDBH->quoteIdentifier($prefix.'application_variable', true);

	    $query = "SELECT instance_id
	               FROM {$tblPref}
	               WHERE agencyid = 0";
	    $instanceId = $this->oDBH->queryOne($query);
	    if (PEAR::isError($instanceId))
	    {
	       $this->_log("Error retrieving instance_id");
	       $instanceId = '';
	    }
	    if (empty($instanceId))
	    {
	        $this->_log("Empty instance_id, generating new for platform_hash");
            $instanceId = sha1(uniqid('', true));
	    }
	    $query = "INSERT INTO {$tblAVar}
	               (name, value)
	               VALUES
	               ('platform_hash', '{$instanceId}')";
	    $result = $this->oDBH->exec($query);
	    if (PEAR::isError($result))
	    {
	       $this->_logError("Could not migrate instance_id to platform_hash");
	    }
	    return true;
	}
}

?>
