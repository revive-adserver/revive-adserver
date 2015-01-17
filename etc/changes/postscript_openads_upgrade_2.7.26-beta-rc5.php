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

$className = 'OA_UpgradePostscript_2_7_26_beta_rc5';

require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php';

class OA_UpgradePostscript_2_7_26_beta_rc5
{
    /**
     * @var OA_Upgrade
     */
    var $oUpgrade;

    /**
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    /**
     * DB table prefix
     *
     * @var unknown_type
     */
    var $prefix;
    var $tblAccountPreferenceAssoc;
    var $tblPreferences;

    function __construct()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];

        // Recompile the delivery limitations to update the compiled limitations as well
        $this->oUpgrade->addPostUpgradeTask('Recompile_Acls');

        $this->oDbh = &OA_DB::singleton();
        $aConf = $GLOBALS['_MAX']['CONF']['table'];
        $this->prefix = $aConf['prefix'];
        $this->tblPreferences = $aConf['prefix'].($aConf['preferences'] ? $aConf['preferences'] : 'preferences');
        $this->tblAccountPreferenceAssoc = $aConf['prefix'].($aConf['account_preference_assoc'] ? $aConf['account_preference_assoc'] : 'account_preference_assoc');

        $query = "SELECT preference_id
                  FROM ".$this->oDbh->quoteIdentifier($this->tblPreferences,true)."
                  WHERE preference_name = 'auto_alter_html_banners_for_click_tracking'";
        $rs = $this->oDbh->query($query);
        //check for error
        if (PEAR::isError($rs))
        {
            $this->logError($rs->getUserInfo());
            return false;
        }

        $preferenceId = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
        $preferenceId = $preferenceId['preference_id'];

        if (!empty($preferenceId)) {
            $sql = "DELETE FROM ".$this->oDbh->quoteIdentifier($this->tblAccountPreferenceAssoc,true)." WHERE preference_id = $preferenceId";
            $rs = $this->oDbh->exec($sql);
            //check for error
            if (PEAR::isError($rs))
            {
                $this->logError($rs->getUserInfo());
                return false;
            }
            $this->logOnly("Removed entries in account_preferences_assoc table related to auto_alter_html_banners_for_click_tracking");

            $sql = "DELETE FROM ".$this->oDbh->quoteIdentifier($this->tblPreferences,true)." WHERE preference_id = $preferenceId";
            $rs = $this->oDbh->exec($sql);
            //check for error
            if (PEAR::isError($rs))
            {
                $this->logError($rs->getUserInfo());
                return false;
            }
            $this->logOnly("Removed auto_alter_html_banners_for_click_tracking preference in preferences table");
        }

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