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

class Migration_326 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAlterField__campaigns__priority';
		$this->aTaskList_constructive[] = 'afterAlterField__campaigns__priority';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__target_impression';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__target_impression';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__target_click';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__target_click';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__target_conversion';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__target_conversion';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__companion';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__companion';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__comments';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__comments';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__revenue';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__revenue';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__revenue_type';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__revenue_type';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__updated';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__updated';


		$this->aObjectMap['campaigns']['target_impression'] = array('fromTable'=>'campaigns', 'fromField'=>'target');
		$this->aObjectMap['campaigns']['target_click'] = array('fromTable'=>'campaigns', 'fromField'=>'target_click');
		$this->aObjectMap['campaigns']['target_conversion'] = array('fromTable'=>'campaigns', 'fromField'=>'target_conversion');
		$this->aObjectMap['campaigns']['companion'] = array('fromTable'=>'campaigns', 'fromField'=>'companion');
		$this->aObjectMap['campaigns']['comments'] = array('fromTable'=>'campaigns', 'fromField'=>'comments');
		$this->aObjectMap['campaigns']['revenue'] = array('fromTable'=>'campaigns', 'fromField'=>'revenue');
		$this->aObjectMap['campaigns']['revenue_type'] = array('fromTable'=>'campaigns', 'fromField'=>'revenue_type');
		$this->aObjectMap['campaigns']['updated'] = array('fromTable'=>'campaigns', 'fromField'=>'updated');
    }

    /**
     * Backup the priorities field before altering
     *
     * @return boolean
     */
	function beforeAlterField__campaigns__priority()
	{
	    $prefix = $this->getPrefix();
	    $statement = $this->aSQLStatements['table_copy_temp'];
	    $query      = sprintf($statement, $prefix . 'campaigns_325', $prefix . 'campaigns');
        $result     = $this->oDBH->exec($query);
        if (PEAR::isError($result))
        {
            $this->_log('error copying campaigns table for priority migration');
            return false;
        }

        if ($this->oDBH->dbsyntax == 'pgsql') {
            $campaignsTable = $this->oDBH->quoteidentifier($prefix.'campaigns',true);
            $query  = "ALTER TABLE {$campaignsTable} ALTER priority DROP DEFAULT";
            $result = $this->oDBH->exec($query);
            if (PEAR::isError($result))
            {
                $this->_log('error dropping campaigns table default for priority migration');
                return false;
            }
            $query  = "UPDATE {$campaignsTable} SET priority = '0'";
            $result = $this->oDBH->exec($query);
            if (PEAR::isError($result))
            {
                $this->_log('error zeroing campaigns table priority');
                return false;
            }
        }

		return $this->beforeAlterField('campaigns', 'priority');
	}

	/**
	 * Restore the data from the backed up table substituting 'h' => 5, 'm' => 3, 'l' => 0
	 *
	 * @return boolean
	 */
	function afterAlterField__campaigns__priority()
	{
        // Restore the campaigns.priority value mapping old->new values
        $prefix = $this->getPrefix();
        $tbl_campaigns     = $this->oDBH->quoteIdentifier($prefix . 'campaigns',true);
        $tbl_campaigns_325 = $this->oDBH->quoteIdentifier($prefix . 'campaigns_325',true);

        if ($this->oDBH->dbsyntax == 'pgsql') {
            $updateTables = "{$tbl_campaigns}";
            $updatePrefix = '';
            $updateFrom   = "FROM {$tbl_campaigns_325}";
        } else {
            $updateTables = "{$tbl_campaigns}, {$tbl_campaigns_325}";
            $updatePrefix = "{$tbl_campaigns}.";
            $updateFrom   = '';
        }

        $query = "
            UPDATE
                {$updateTables}
            SET
                {$updatePrefix}priority = 5
            {$updateFrom}
            WHERE
                {$tbl_campaigns}.campaignid={$tbl_campaigns_325}.campaignid
              AND {$tbl_campaigns_325}.priority='h'
        ";
        $result = $this->oDBH->exec($query);
        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Unable to copy campaign priorities for high priority campaigns');
        }
        $query = "
            UPDATE
                {$updateTables}
            SET
                {$updatePrefix}priority = 3
            {$updateFrom}
            WHERE
                {$tbl_campaigns}.campaignid={$tbl_campaigns_325}.campaignid
              AND {$tbl_campaigns_325}.priority='m'
        ";
        $result = $this->oDBH->exec($query);
        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Unable to copy campaign priorities for medium priority campaigns');
        }
        $query = "
            UPDATE
                {$updateTables}
            SET
                {$updatePrefix}priority = 0
            {$updateFrom}
            WHERE
                {$tbl_campaigns}.campaignid={$tbl_campaigns_325}.campaignid
              AND {$tbl_campaigns_325}.priority='l'
        ";
        $result = $this->oDBH->exec($query);
        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Unable to copy campaign priorities for low priority campaigns');
        }
		return $this->afterAlterField('campaigns', 'priority');
	}

	function beforeAddField__campaigns__target_impression()
	{
		$this->beforeAddField('campaigns', 'target_impression');
	}

	function afterAddField__campaigns__target_impression()
	{
		return $this->afterAddField('campaigns', 'target_impression');
	}

	function beforeAddField__campaigns__target_click()
	{
		return $this->beforeAddField('campaigns', 'target_click');
	}

	function afterAddField__campaigns__target_click()
	{
		return $this->afterAddField('campaigns', 'target_click');
	}

	function beforeAddField__campaigns__target_conversion()
	{
		return $this->beforeAddField('campaigns', 'target_conversion');
	}

	function afterAddField__campaigns__target_conversion()
	{
		return $this->afterAddField('campaigns', 'target_conversion');
	}

	function beforeAddField__campaigns__companion()
	{
		return $this->beforeAddField('campaigns', 'companion');
	}

	function afterAddField__campaigns__companion()
	{
		return $this->afterAddField('campaigns', 'companion');
	}

	function beforeAddField__campaigns__comments()
	{
		return $this->beforeAddField('campaigns', 'comments');
	}

	function afterAddField__campaigns__comments()
	{
		return $this->afterAddField('campaigns', 'comments');
	}

	function beforeAddField__campaigns__revenue()
	{
		return $this->beforeAddField('campaigns', 'revenue');
	}

	function afterAddField__campaigns__revenue()
	{
		return $this->afterAddField('campaigns', 'revenue');
	}

	function beforeAddField__campaigns__revenue_type()
	{
		return $this->beforeAddField('campaigns', 'revenue_type');
	}

	function afterAddField__campaigns__revenue_type()
	{
		return $this->afterAddField('campaigns', 'revenue_type');
	}

	function beforeAddField__campaigns__updated()
	{
		return $this->beforeAddField('campaigns', 'updated');
	}

	function afterAddField__campaigns__updated()
	{
		return $this->afterAddField('campaigns', 'updated');
	}
}

?>
