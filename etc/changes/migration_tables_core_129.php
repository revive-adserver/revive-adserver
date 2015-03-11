<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/phpAdsNew.php');
require_once(MAX_PATH.'/lib/OA/DB/Sql.php');

class Migration_129 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__ad_zone_assoc__priority_factor';
		$this->aTaskList_constructive[] = 'afterAddField__ad_zone_assoc__priority_factor';
		$this->aTaskList_constructive[] = 'beforeAddField__ad_zone_assoc__to_be_delivered';
		$this->aTaskList_constructive[] = 'afterAddField__ad_zone_assoc__to_be_delivered';
		$this->aTaskList_constructive[] = 'beforeAddField__data_summary_ad_zone_assoc__to_be_delivered';
		$this->aTaskList_constructive[] = 'afterAddField__data_summary_ad_zone_assoc__to_be_delivered';
		$this->aTaskList_constructive[] = 'beforeAddField__preference__warn_limit_days';
		$this->aTaskList_constructive[] = 'afterAddField__preference__warn_limit_days';


		$this->aObjectMap['ad_zone_assoc']['priority_factor'] = array('fromTable'=>'ad_zone_assoc', 'fromField'=>'priority_factor');
		$this->aObjectMap['ad_zone_assoc']['to_be_delivered'] = array('fromTable'=>'ad_zone_assoc', 'fromField'=>'to_be_delivered');
		$this->aObjectMap['data_summary_ad_zone_assoc']['to_be_delivered'] = array('fromTable'=>'data_summary_ad_zone_assoc', 'fromField'=>'to_be_delivered');
		$this->aObjectMap['preference']['warn_limit_days'] = array('fromTable'=>'preference', 'fromField'=>'warn_limit_days');
    }



	function beforeAddField__ad_zone_assoc__priority_factor()
	{
		return $this->beforeAddField('ad_zone_assoc', 'priority_factor');
	}

	function afterAddField__ad_zone_assoc__priority_factor()
	{
		return $this->afterAddField('ad_zone_assoc', 'priority_factor');
	}

	function beforeAddField__ad_zone_assoc__to_be_delivered()
	{
		return $this->beforeAddField('ad_zone_assoc', 'to_be_delivered');
	}

	function afterAddField__ad_zone_assoc__to_be_delivered()
	{
		return $this->afterAddField('ad_zone_assoc', 'to_be_delivered');
	}

	function beforeAddField__data_summary_ad_zone_assoc__to_be_delivered()
	{
		return $this->beforeAddField('data_summary_ad_zone_assoc', 'to_be_delivered');
	}

	function afterAddField__data_summary_ad_zone_assoc__to_be_delivered()
	{
		return $this->afterAddField('data_summary_ad_zone_assoc', 'to_be_delivered');
	}

	function beforeAddField__preference__warn_limit_days()
	{
		return $this->beforeAddField('preference', 'warn_limit_days');
	}

	function afterAddField__preference__warn_limit_days()
	{
		return $this->afterAddField('preference', 'warn_limit_days');
	}

	function migrateData()
	{
        $phpAdsNew = new OA_phpAdsNew();
        $aPanConfig = $phpAdsNew->_getPANConfig();
        $aValues['warn_limit_days'] = $aPanConfig['warn_limit_days'] ? $aPanConfig['warn_limit_days'] : 1;

        $sql = OA_DB_SQL::sqlForInsert('preference', $aValues);
        $result = $this->oDBH->exec($sql);
        return (!PEAR::isError($result));
	}

}

?>
