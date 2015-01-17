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

require_once MAX_PATH.'/lib/OA/Upgrade/Migration.php';
require_once MAX_PATH.'/lib/OA/Dal.php';

class Migration_609 extends Migration
{
    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__activate_time';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__activate_time';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__expire_time';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__expire_time';
		$this->aTaskList_destructive[] = 'beforeRemoveField__campaigns__expire';
		$this->aTaskList_destructive[] = 'afterRemoveField__campaigns__expire';
		$this->aTaskList_destructive[] = 'beforeRemoveField__campaigns__activate';
		$this->aTaskList_destructive[] = 'afterRemoveField__campaigns__activate';


		$this->aObjectMap['campaigns']['activate_time'] = array('fromTable'=>'campaigns', 'fromField'=>'activate_time');
		$this->aObjectMap['campaigns']['expire_time'] = array('fromTable'=>'campaigns', 'fromField'=>'expire_time');
    }



	function beforeAddField__campaigns__activate_time()
	{
		return $this->beforeAddField('campaigns', 'activate_time');
	}

	function afterAddField__campaigns__activate_time()
	{
		return $this->afterAddField('campaigns', 'activate_time');
	}

	function beforeAddField__campaigns__expire_time()
	{
		return $this->beforeAddField('campaigns', 'expire_time');
	}

	function afterAddField__campaigns__expire_time()
	{
		return $this->afterAddField('campaigns', 'expire_time') && $this->migrateActivateExpire();
	}

	function beforeRemoveField__campaigns__expire()
	{
		return $this->beforeRemoveField('campaigns', 'expire');
	}

	function afterRemoveField__campaigns__expire()
	{
		return $this->afterRemoveField('campaigns', 'expire');
	}

	function beforeRemoveField__campaigns__activate()
	{
		return $this->beforeRemoveField('campaigns', 'activate');
	}

	function afterRemoveField__campaigns__activate()
	{
		return $this->afterRemoveField('campaigns', 'activate');
	}

	function migrateActivateExpire()
	{
	    $oDbh = $this->oDBH;

        $prefix = $this->getPrefix();
        foreach (array(
            'tblAppVar'    => 'application_variable',
            'tblAccounts'  => 'accounts',
            'tblAgency'    => 'agency',
            'tblClients'   => 'clients',
            'tblCampaigns' => 'campaigns',
            'tblPrefs'     => 'preferences',
            'tblAccPrefs'  => 'account_preference_assoc',
        ) as $k => $v) {
            $$k = $oDbh->quoteIdentifier($prefix.($aConf[$v] ? $aConf[$v] : $v), true);
        }

        // Get admin account ID
        $adminAccountId = (int)$oDbh->queryOne("SELECT value FROM {$tblAppVar} WHERE name = 'admin_account_id'");
        if (PEAR::isError($adminAccountId)) {
            return $this->_logErrorAndReturnFalse("No admin account ID");
        }

        // Get preference ID for timezone
        $tzId = $oDbh->queryOne("SELECT preference_id FROM {$tblPrefs} WHERE preference_name = 'timezone'");
        if (empty($tzId) || PEAR::isError($tzId)) {
            // Upgrading from 2.4 maybe?
            $tzId = 0;
            $this->_log("No timezone preference available, using default server timezone");
            $adminTz = date_default_timezone_get();
            if (empty($adminTz)) {
                // C'mon you should have set the timezone in your php.ini!
                $this->_log("No default server timezone, using UTC");
                $adminTz = 'UTC';
            }
        } else {
            // Get admin timezone
            $adminTz = $oDbh->queryOne("SELECT value FROM {$tblAccPrefs} WHERE preference_id = {$tzId} AND account_id = {$adminAccountId}");
            if (empty($adminTz) || PEAR::isError($adminTz)) {
                $this->_log("No admin timezone, using UTC");
                $adminTz = 'UTC';
            }
        }

        $this->_log("Starting Migration");

        $useTransaction = $oDbh->supports('transactions');

        if ($useTransaction) {
            $oDbh->beginTransaction();
        }
        $oStmt = $oDbh->prepare("UPDATE {$tblCampaigns} SET activate_time = ?, expire_time = ? WHERE campaignid = ?", array('timestamp', 'timestamp', 'integer'));

        $query = "SELECT a.agencyid, COALESCE(p.value, ".$oDbh->quote($adminTz).") AS tz FROM {$tblAgency} a LEFT JOIN {$tblAccPrefs} p ON (a.account_id = p.account_id AND p.preference_id = {$tzId})";
        foreach ($oDbh->getAssoc($query) as $agencyId => $tz) {
            $this->_log("Converting agency ID {$agencyId}");
            $query = "SELECT campaignid, activate, expire FROM {$tblCampaigns} JOIN {$tblClients} USING (clientid) WHERE agencyid = {$agencyId}";
            foreach ($oDbh->getAssoc($query) as $campaignId => $aCampaign) {
                $this->_log("Converting campaign ID {$campaignId} (a: {$aCampaign['activate']}, e: {$aCampaign['expire']})");
                $result = $oStmt->execute(array(
                    $this->_convertDate($aCampaign['activate'], $tz, 0),
                    $this->_convertDate($aCampaign['expire'],   $tz, 1),
                    $campaignId
                ));
                if (PEAR::isError($result)) {
                    if ($useTransaction) {
                        $oDbh->rollback();
                    }
                    return $this->_logErrorAndReturnFalse("Error: ".$result->getDebugInfo());
                }
            }
        }
        if ($useTransaction) {
            $oDbh->commit();
        }

        $this->_log("Migration completed");

	    return true;
	}

	function _convertDate($date, $tz, $end)
	{
	    if (empty($date) || $date == '0000-00-00') {
	        return null;
	    }
	    $oDate = new Date($date);
	    $oDate->setTZByID($tz);
	    if ($end) {
	        $oDate->setHour(23);
	        $oDate->setMinute(59);
	        $oDate->setSecond(59);
	    }
	    $oDate->toUTC();
	    return $oDate->getDate(DATE_FORMAT_ISO);
	}

}

?>