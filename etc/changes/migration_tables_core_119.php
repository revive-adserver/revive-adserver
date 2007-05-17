<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
$Id: Acls.dal.test.php 5552 2007-04-03 19:52:40Z andrew.hill@openads.org $
*/

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/phpAdsNew.php');
require_once(MAX_PATH.'/lib/OA/DB/Sql.php');

class Migration_119 extends Migration
{

    function Migration_119()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__preference';
		$this->aTaskList_constructive[] = 'afterAddTable__preference';
		$this->aTaskList_constructive[] = 'beforeAddTable__preference_advertiser';
		$this->aTaskList_constructive[] = 'afterAddTable__preference_advertiser';
		$this->aTaskList_constructive[] = 'beforeAddTable__preference_publisher';
		$this->aTaskList_constructive[] = 'afterAddTable__preference_publisher';


    }



	function beforeAddTable__preference()
	{
		return $this->beforeAddTable('preference');
	}

	function afterAddTable__preference()
	{
		return $this->migrateData() && $this->afterAddTable('preference');
	}

	function beforeAddTable__preference_advertiser()
	{
		return $this->beforeAddTable('preference_advertiser');
	}

	function afterAddTable__preference_advertiser()
	{
		return $this->afterAddTable('preference_advertiser');
	}

	function beforeAddTable__preference_publisher()
	{
		return $this->beforeAddTable('preference_publisher');
	}

	function afterAddTable__preference_publisher()
	{
		return $this->afterAddTable('preference_publisher');
	}


	function migrateData()
	{
	    $prefix = $this->getPrefix();
	    $tablePreference = $prefix . 'preference';
	    $aColumns = $this->oDBH->manager->listTableFields($tablePreference);

	    $sql = "
	       SELECT * from {$prefix}config";
	    $rsConfig = DBC::NewRecordSet($sql);
	    if ($rsConfig->find() && $rsConfig->fetch()) {
	        $aDataConfig = $rsConfig->toArray();
	        $aValues = array();
	        foreach($aDataConfig as $column => $value) {
	            if (in_array($column, $aColumns)) {
	                $aValues[$column] = $value;
	            }
	        }

	        copy(
	           MAX_PATH.'/etc/changes/tests/data/config_2_0_12.inc.php',
	           MAX_PATH.'/var/config.inc.php'
	        );

	        // Migrate PAN config variables
	        $phpAdsNew = new OA_phpAdsNew();
            $aPanConfig = $phpAdsNew->_getPANConfig();
            $aValues['warn_admin']                 = $aPanConfig['warn_admin'] ? 't' : 'f';
            $aValues['warn_client']                = $aPanConfig['warn_client'] ? 't' : 'f';
            $aValues['warn_limit']                 = $aPanConfig['warn_limit'] ? $aPanConfig['warn_limit'] : 100;
            $aValues['default_banner_url']         = $aPanConfig['default_banner_url'];
            $aValues['default_banner_destination'] = $aPanConfig['default_banner_target'];

            unlink(MAX_PATH.'/var/config.inc.php');

	        $sql = OA_DB_SQL::sqlForInsert($tablePreference, $aValues);
	        $result = $this->oDBH->exec($sql);
	        return (!PEAR::isError($result));
	    }
	    else {
	        return false;
	    }
	}
}

?>