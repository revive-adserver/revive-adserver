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

$className = 'OA_UpgradePostscript_2_7_11_dev';

require_once MAX_PATH . '/lib/OA/DB/Table.php';

class OA_UpgradePostscript_2_7_11_dev
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

    function OA_UpgradePostscript_2_7_11_dev()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        $this->oDbh = &OA_DB::singleton();
        $aConf = $GLOBALS['_MAX']['CONF']['table'];
        $this->prefix = $aConf['prefix'];
        $this->tblCampaigns = $aConf['prefix'].($aConf['campaigns'] ? $aConf['campaigns'] : 'campaigns');

        $this->queryUpdateTemplate = "UPDATE ".$this->oDbh->quoteIdentifier($this->tblCampaigns,true)."
                                      SET revenue_type = %s
                                      WHERE campaignid in (%s)";

        $query = 'SELECT campaignid, clicks, conversions
                    FROM '.$this->oDbh->quoteIdentifier($this->tblCampaigns,true).' c
                    WHERE c.revenue_type IS NULL ';

        $rs = $this->oDbh->query($query);

        //check for error
        if (PEAR::isError($rs))
        {
            $this->logError($rs->getUserInfo());
            return false;
        }

        /*
          process campaigns and derive the revenue_type from set limits
          if (conversions set) -> revenue type is CPA
          else if (clicks set) -> revenue type is CPC
          else if (impressions set) -> revenue type is CPM
          else -> default to CPM
        */

        $aCPMCampaigns = array();
        $aCPCCampaigns = array();
        $aCPACampaigns = array();
        while ($aCampaign = $rs->fetchRow(MDB2_FETCHMODE_ASSOC))
        {
            if ($aCampaign['conversions'] > 0)
            {
                $aCPACampaigns[] = $aCampaign['campaignid'];
            }
            else if ($aCampaign['clicks'] > 0)
            {
                $aCPCCampaigns[] = $aCampaign['campaignid'];
            }
            else {//views set or no limits CPM as well
                $aCPMCampaigns[] = $aCampaign['campaignid'];
            }
        }

        /*
          update campaigns accordingly
          'MAX_FINANCE_CPM',    1);
          'MAX_FINANCE_CPC',    2);
          'MAX_FINANCE_CPA',    3);
        */
        $cpmCount = count($aCPMCampaigns);
        $cpcCount = count($aCPCCampaigns);
        $cpaCount = count($aCPACampaigns);
        $count = $cpmCount +  $cpcCount + $cpaCount;

        $this->logOnly("Found " + $count + " campaign(s) to set missing revenue type: "
            + ($cpmCount > 0 ? "$cpmCount to CPM,": '')
            + ($cpcCount > 0 ? "$cpcCount to CPC," : '')
            + ($cpaCount > 0 ? "$cpaCount to CPA" : ''));


        if ($cpmCount > 0)
        {
            $query = sprintf($this->queryUpdateTemplate, MAX_FINANCE_CPM, implode(',', $aCPMCampaigns));
            $result = $this->oDbh->exec($query);
            if (PEAR::isError($result))
            {
                $this->logError($result->getUserInfo());
                return false;
            }
            else
            {
                $this->logOnly("Successfully updated 'revenue_type' of $result campaign(s) to CPM");
            }
        }
        if ($cpcCount > 0)
        {
            $query = sprintf($this->queryUpdateTemplate, MAX_FINANCE_CPC, implode(',', $aCPCCampaigns));
            $result = $this->oDbh->exec($query);
            if (PEAR::isError($result))
            {
                $this->logError($result->getUserInfo());
                return false;
            }
            else
            {
                $this->logOnly("Successfully updated 'revenue_type' of $result campaign(s) to CPC");
            }
        }

        if ($cpaCount > 0)
        {
            $query = sprintf($this->queryUpdateTemplate, MAX_FINANCE_CPA, implode(',', $aCPACampaigns));
            $result = $this->oDbh->exec($query);
            if (PEAR::isError($result))
            {
                $this->logError($result->getUserInfo());
                return false;
            }
            else
            {
                $this->logOnly("Successfully updated 'revenue_type' of $result campaign(s) to CPA");
            }
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
