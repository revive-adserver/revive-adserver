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
