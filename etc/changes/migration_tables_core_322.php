<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_322 extends Migration
{

    function Migration_322()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__clients__comments';
		$this->aTaskList_constructive[] = 'afterAddField__clients__comments';
		$this->aTaskList_constructive[] = 'beforeAddField__clients__updated';
		$this->aTaskList_constructive[] = 'afterAddField__clients__updated';


		$this->aObjectMap['clients']['comments'] = array('fromTable'=>'clients', 'fromField'=>'comments');
		$this->aObjectMap['clients']['updated'] = array('fromTable'=>'clients', 'fromField'=>'updated');
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

	function migrateData()
	{
	    $prefix = $this->getPrefix();
	    $tableCampaigns = $prefix . 'campaigns';
	    $tableClients = $prefix . 'clients';
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
            return $this->_logErrorAndReturnFalse($result);
        }

        $sql = "DELETE from $tableClients WHERE parent <> 0";
        $result = $this->oDBH->exec($sql);
        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse($result);
        }

        return true;
	}

}

?>