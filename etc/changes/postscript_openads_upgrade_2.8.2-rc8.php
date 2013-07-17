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

$className = 'OA_UpgradePostscript_2_8_2_rc8';

require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php';

class OA_UpgradePostscript_2_8_2_rc8
{
    /**
     * @var OA_Upgrade
     */
    var $oUpgrade;

    /**
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];

        $this->oDbh = &OA_DB::singleton();
        $aConf = $GLOBALS['_MAX']['CONF']['table'];

        $prefix = $aConf['prefix'];
        foreach (array(
            'tblAppVar'    => 'application_variable',
            'tblAccounts'  => 'accounts',
            'tblAgency'    => 'agency',
            'tblClients'   => 'clients',
            'tblCampaigns' => 'campaigns',
            'tblBanners'   => 'banners',
            'tblAcls'      => 'acls',
            'tblPrefs'     => 'preferences',
            'tblAccPrefs'  => 'account_preference_assoc',
        ) as $k => $v) {
            $$k = $this->oDbh->quoteIdentifier($prefix.($aConf[$v] ? $aConf[$v] : $v), true);
        }

        // Get admin account ID
        $adminAccountId = (int)$this->oDbh->queryOne("SELECT value FROM {$tblAppVar} WHERE name = 'admin_account_id'");
        if (PEAR::isError($adminAccountId)) {
            $this->logError("No admin account ID");
            return false;
        }

        // Get preference ID for timezone
        $tzId = $this->oDbh->queryOne("SELECT preference_id FROM {$tblPrefs} WHERE preference_name = 'timezone'");
        if (empty($tzId) || PEAR::isError($tzId)) {
            // Upgrading from 2.4 maybe?
            $tzId = 0;
            $this->logOnly("No timezone preference available, using default server timezone");
            $adminTz = date_default_timezone_get();
            if (empty($adminTz)) {
                // C'mon you should have set the timezone in your php.ini!
                $this->logOnly("No default server timezone, using UTC");
                $adminTz = 'UTC';
            }
        } else {
            // Get admin timezone
            $adminTz = $this->oDbh->queryOne("SELECT value FROM {$tblAccPrefs} WHERE preference_id = {$tzId} AND account_id = {$adminAccountId}");
            if (empty($adminTz) || PEAR::isError($adminTz)) {
                $this->logOnly("No admin timezone, using UTC");
                $adminTz = 'UTC';
            }
        }

        $joinList = "{$tblBanners} b JOIN
                    {$tblCampaigns} ca USING (campaignid) JOIN
                    {$tblClients} cl USING (clientid) JOIN
                    {$tblAgency} a USING (agencyid) LEFT JOIN
                    {$tblAccPrefs} p ON (p.account_id = a.account_id AND p.preference_id = {$tzId})";

        $tzPart = "COALESCE(p.value, ".$this->oDbh->quote($adminTz).")";

        $wherePart = "
                    ac.bannerid = b.bannerid AND
                	ac.type LIKE 'deliveryLimitations:Time:%' AND
                	ac.data NOT LIKE '%@%'
        ";

        if ($this->oDbh->dbsyntax == 'pgsql') {
            $query = "
                UPDATE
                    {$tblAcls} ac
                SET
                    data = data || '@' || {$tzPart}
                FROM
                    {$joinList}
                WHERE
                    {$wherePart}
            ";
        } else {
            $query = "
                UPDATE
                    {$tblAcls} ac,
                    {$joinList}
                SET
                    ac.data = CONCAT(ac.data, '@', {$tzPart})
                WHERE
                    {$wherePart}
            ";
        }

        $ret = $this->oDbh->exec($query);
        if (PEAR::isError($ret)) {
            $this->logError($ret->getUserInfo());
            return false;
        }

        // Rebuild ACLs
        $this->oUpgrade->addPostUpgradeTask('Recompile_Acls');

        // Also rebuild banner cache for OX-5184
        $this->oUpgrade->addPostUpgradeTask('Rebuild_Banner_Cache');

        $this->logOnly("Appended timezone information to {$ret} time based delivery limitations");
        return true;
    }

    function logOnly($msg)
    {
        $this->oUpgrade->oLogger->logOnly($msg);
    }


    function logError($msg)
    {
        $this->oUpgrade->oLogger->logError($msg);
    }

}