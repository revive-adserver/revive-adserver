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

class Migration_122 extends Migration
{

    function Migration_122()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__clients__agencyid';
		$this->aTaskList_constructive[] = 'afterAddField__clients__agencyid';
		$this->aTaskList_constructive[] = 'beforeAddField__clients__comments';
		$this->aTaskList_constructive[] = 'afterAddField__clients__comments';
		$this->aTaskList_constructive[] = 'beforeAddField__clients__updated';
		$this->aTaskList_constructive[] = 'afterAddField__clients__updated';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__views';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__views';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__clicks';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__clicks';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__expire';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__expire';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__activate';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__activate';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__active';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__active';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__weight';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__weight';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__target';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__target';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__parent';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__parent';


		$this->aObjectMap['clients']['agencyid'] = array('fromTable'=>'clients', 'fromField'=>'agencyid');
		$this->aObjectMap['clients']['comments'] = array('fromTable'=>'clients', 'fromField'=>'comments');
		$this->aObjectMap['clients']['updated'] = array('fromTable'=>'clients', 'fromField'=>'updated');
    }



	function beforeAddField__clients__agencyid()
	{
		return $this->beforeAddField('clients', 'agencyid');
	}

	function afterAddField__clients__agencyid()
	{
		return $this->afterAddField('clients', 'agencyid');
	}

	function beforeAddField__clients__comments()
	{
		return $this->beforeAddField('clients', 'comments');
	}

	function afterAddField__clients__comments()
	{
		return $this->afterAddField('clients', 'comments');
	}

	function beforeAddField__clients__updated()
	{
		return $this->beforeAddField('clients', 'updated');
	}

	function afterAddField__clients__updated()
	{
		return $this->migrateData() && $this->afterAddField('clients', 'updated');
	}

	function beforeRemoveField__clients__views()
	{
		return $this->beforeRemoveField('clients', 'views');
	}

	function afterRemoveField__clients__views()
	{
		return $this->afterRemoveField('clients', 'views');
	}

	function beforeRemoveField__clients__clicks()
	{
		return $this->beforeRemoveField('clients', 'clicks');
	}

	function afterRemoveField__clients__clicks()
	{
		return $this->afterRemoveField('clients', 'clicks');
	}

	function beforeRemoveField__clients__expire()
	{
		return $this->beforeRemoveField('clients', 'expire');
	}

	function afterRemoveField__clients__expire()
	{
		return $this->afterRemoveField('clients', 'expire');
	}

	function beforeRemoveField__clients__activate()
	{
		return $this->beforeRemoveField('clients', 'activate');
	}

	function afterRemoveField__clients__activate()
	{
		return $this->afterRemoveField('clients', 'activate');
	}

	function beforeRemoveField__clients__active()
	{
		return $this->beforeRemoveField('clients', 'active');
	}

	function afterRemoveField__clients__active()
	{
		return $this->afterRemoveField('clients', 'active');
	}

	function beforeRemoveField__clients__weight()
	{
		return $this->beforeRemoveField('clients', 'weight');
	}

	function afterRemoveField__clients__weight()
	{
		return $this->afterRemoveField('clients', 'weight');
	}

	function beforeRemoveField__clients__target()
	{
		return $this->beforeRemoveField('clients', 'target');
	}

	function afterRemoveField__clients__target()
	{
		return $this->afterRemoveField('clients', 'target');
	}

	function beforeRemoveField__clients__parent()
	{
		return $this->beforeRemoveField('clients', 'parent');
	}

	function afterRemoveField__clients__parent()
	{
		return $this->afterRemoveField('clients', 'parent');
	}

	function migrateData()
	{
	    $prefix = $this->getPrefix();
	    $tableCampaigns = $this->oDBH->quoteIdentifier($prefix . 'campaigns',true);
	    $tableClients = $this->oDBH->quoteIdentifier($prefix.'clients',true);

        $sql = "UPDATE $tableClients SET parent = 0 WHERE parent IS NULL";
        $result = $this->oDBH->exec($sql);
        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Error updating data during migration 122: '.$result->getUserInfo());
        }

        $sql = "
        INSERT INTO
            $tableCampaigns
            (campaignid, campaignname, clientid, views, clicks, conversions,
            expire, activate, active, priority, weight, target_impression,
            target_click, target_conversion, anonymous, companion)
        SELECT
            clientid AS campaignid,
            clientname AS campaignname,
            parent AS clientid,
            views AS views,
            clicks AS clicks,
            '-1' AS conversions,
            expire AS expire,
            activate AS activate,
            active AS active,
            if (target > 0, 5, 0) AS priority,
            weight AS weight,
            target AS target_impression,
            0 AS target_click,
            0 AS target_conversion,
            'f' AS anonymous,
            0 AS companion
        FROM
            $tableClients
        WHERE
            parent > 0";
        $result = $this->oDBH->exec($sql);
        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Error migrating campaign/client data during migration 122: '.$result->getUserInfo());
        }

        $sql = "DELETE from $tableClients WHERE parent <> 0";
        $result = $this->oDBH->exec($sql);
        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Error deleting data during migration 122: '.$result->getUserInfo());
        }

        // Update sequence on PostgreSQL
        if ($this->oDBH->dbsyntax == 'pgsql') {
            $seqCampaigns = $this->oDBH->quote($this->oDBH->quoteIdentifier($prefix.'campaigns_campaignid_seq', true));
            $sql = "SELECT setval($seqCampaigns, MAX(campaignid)) FROM $tableCampaigns";
            $result = $this->oDBH->exec($sql);
            if (PEAR::isError($result)) {
                return $this->_logErrorAndReturnFalse('Error resetting campaigns sequence during migration 122: '.$result->getUserInfo());
            }
        }

        return true;
	}

}

?>