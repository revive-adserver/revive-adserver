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

$className = 'OA_UpgradePostscript_2_7_12_dev';

require_once MAX_PATH . '/lib/OA/DB/Table.php';

class OA_UpgradePostscript_2_7_12_dev
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
    var $tblCampaigns;

    function __construct()
    {

    }

    function execute($aParams)
    {
        // Insert the required application variable flag to ensure that
        // when the maintenance script next runs, it will process all
        // raw data into the new bucket format, so that any raw data not
        // previously summarised will be accounted for

        $this->oUpgrade = & $aParams[0];
        $this->oDbh = &OA_DB::singleton();
        $aConf = $GLOBALS['_MAX']['CONF']['table'];
        $this->tblApplicationVariable = $aConf['prefix'].($aConf['application_variable'] ? $aConf['application_variable'] : 'application_variable');

        $query = "
            INSERT INTO
                " . $this->oDbh->quoteIdentifier($this->tblApplicationVariable, true) . "
                (
                    name,
                    value
                )
            VALUES
                (
                    'mse_process_raw',
                    '1'
                )";

        $this->logOnly("Setting application variable flag to ensure ME processes old sytle raw data on next run...");
        $rs = $this->oDbh->exec($query);

        // Check for errors
        if (PEAR::isError($rs))
        {
            $this->logError($rs->getUserInfo());
            return false;
        }

        $this->logOnly("Application variable flag to ensure ME processes old sytle raw data on next run correctly set.");
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
