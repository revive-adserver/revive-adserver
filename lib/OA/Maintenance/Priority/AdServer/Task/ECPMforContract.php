<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ECPMCommon.php';

/**
 * A class to carry out the task of calculating eCPM values
 * within High Priority (by default) Campaigns.  This task
 * no longer calculates priorities, as prioritization will
 * be performed on demand at serve time.
 * 
 * For more information on details of eCPM algorithm see the
 * ad prioritisation algorithm.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Radek Maciaszek <radek@urbantrip.com>
 */
class OA_Maintenance_Priority_AdServer_Task_ECPMforContract extends OA_Maintenance_Priority_AdServer_Task_ECPMCommon
{
    /**
     * Task Name
     *
     * @var string
     */
    var $taskName = 'ECPM value calculation';

    /**
     * Stubbed out since we don't really need to use the code that calls this.
     */
    public function getZonesAllocationByAgency($agencyId) {}

    /**
     * Return a map whose keys are the campaign priority levels to be processed
     **/
    public function getCampaignPriorityLevelsToProcess()
    {
        if (empty ($GLOBALS['conf']['maintenance']['ecpmCampaignLevels'])) {
            $campaign_priorities = array (9,8,7,6);
        } else {
            $campaign_priorities = explode ("|", $GLOBALS['conf']['maintenance']['ecpmCampaignLevels']);
        }

        foreach ($campaign_priorities as $a_cp) {
            $enabled_cps[$a_cp] = 1;
        }

        return $enabled_cps;
    }

    /**
     * Calculates the eCPM values for all campaigns in the priority levels specified
     * by ecpmCampaignLevels
     */
    public function runAlgorithm()
    {
        $campaign_priorities = $this->getCampaignPriorityLevelsToProcess();
        $aAgenciesIds = $this->oDal->getAllAgenciesIds();

        foreach($aAgenciesIds as $agencyId) {
            foreach ($campaign_priorities as $priority => $x) {
                $aCampaignsInfo = $this->oDal->getAllCampaignsInfoByAgencyIdAndPriority($agencyId, $priority);
                if (is_array($aCampaignsInfo) && !empty($aCampaignsInfo)) {
                    $aCampaignsEcpms = array();
                    $aCampaignsDeliveries = $this->oDal->getAgencyPriorityCampaignsDeliveriesToDate($agencyId, $priority);

                    foreach($aCampaignsInfo as $campaignId => $aCampaign) {
                        $aCampaignsEcpms[$campaignId] =
                            OX_Util_Utils::getEcpm(
                                    $aCampaign[self::IDX_REVENUE_TYPE],
                                    $aCampaign[self::IDX_REVENUE],
                                    $aCampaignsDeliveries[$campaignId]['sum_impressions'],
                                    $aCampaignsDeliveries[$campaignId]['sum_clicks'],
                                    $aCampaignsDeliveries[$campaignId]['sum_conversions'],
                                    $aCampaign[self::IDX_ACTIVATE],
                                    $aCampaign[self::IDX_EXPIRE]
                                    );
                    }

                    $this->oDal->updateCampaignsEcpms($aCampaignsEcpms);
                }
            }
        }
    }
}

?>
