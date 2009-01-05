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

    function OA_UpgradePostscript_2_7_12_dev()
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
