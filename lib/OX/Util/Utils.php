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

require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A set of static utility methods
 *
 * @package    OpenX
 * @subpackage Utils
 */
class OX_Util_Utils
{
    /**
     * Returns campaign type based on given priority
     * Type => priorities mapping is as follows:
     *  - Contract:
     *        -1 (Override) OX_CAMPAIGN_TYPE_OVERRIDE
     *      1-10 (High)     OX_CAMPAIGN_TYPE_CONTRACT_NORMAL
     *  - Remnant:
     *         0 (Low)      OX_CAMPAIGN_TYPE_REMNANT
     *  - eCPM:
     *        -2 (Low)      OX_CAMPAIGN_TYPE_ECPM
     *
     * @param int $priority
     * @return unknown
     */
   static function getCampaignType($priority)
   {
       if (priority == null || priority == "") {
           return null;
       }

       if ($priority == 0) {
           return OX_CAMPAIGN_TYPE_REMNANT;
       }
       else if ($priority == -1) {
           return OX_CAMPAIGN_TYPE_OVERRIDE;
       }
       else if ($priority == -2) {
           return OX_CAMPAIGN_TYPE_ECPM;
       }
       else if ($priority > 0) {
           return OX_CAMPAIGN_TYPE_CONTRACT_NORMAL;
       }
       return null;
   }

    /**
     * Returns campaign translation key based on a given priority. Uses getCampaignType
     * to calculate the campaign type.
     * Type => labels map as follows:
     *  - Contract:
     *        -1 (Override) strOverride
     *      1-10 (High)     strStandardContract
     *  - Remnant
     *         0 (Low)      strRemnant
     *
     * @param int $priority
     * @return translation key for a given campaign type
     */
   static function getCampaignTypeTranslationKey($priority)
   {
       $type = OX_Util_Utils::getCampaignType($priority);

       if ($type == OX_CAMPAIGN_TYPE_REMNANT) {
           return 'strRemnant';
       }
       else if ($type == OX_CAMPAIGN_TYPE_OVERRIDE) {
           return 'strOverride';
       }
       else if ($type == OX_CAMPAIGN_TYPE_CONTRACT_NORMAL) {
           return 'strStandardContract';
       }
       else if ($type == OX_CAMPAIGN_TYPE_ECPM) {
           return 'strECPM';
       }
       return null;
   }


    /**
     * Returns campaign type description translation key based on a given priority.
     * Uses getCampaignType to calculate the campaign type.
     * Type => labels map as follows:
     *  - Contract:
     *        -1 (Override) strOverride
     *      1-10 (High)     strStandardContract
     *  - Remnant
     *         0 (Low)      strRemnant
     *
     * @param int $priority
     * @return translation key for a given campaign type description
     */
   static function getCampaignTypeDescriptionTranslationKey($priority)
   {
       $type = OX_Util_Utils::getCampaignType($priority);

       if ($type == OX_CAMPAIGN_TYPE_REMNANT) {
           return 'strRemnantInfo';
       }
       else if ($type == OX_CAMPAIGN_TYPE_OVERRIDE) {
           return 'strOverrideInfo';
       }
       else if ($type == OX_CAMPAIGN_TYPE_CONTRACT_NORMAL) {
           return 'strStandardContractInfo';
       }
       else if ($type == OX_CAMPAIGN_TYPE_ECPM) {
           return 'strECPMInfo';
       }
       return null;
   }


    /**
     * Returns campaign type name based on given priority.
     *
     * @param int $priority
     * @return name for given campaign type
     */
   static function getCampaignTypeName($priority)
   {
       $key = OX_Util_Utils::getCampaignTypeTranslationKey($priority);
       if ($key) {
           $name = $GLOBALS[$key];
       }
       return $name;
   }

    /**
     * Returns campaign status translation key based on a given campaign status.
     */
   static function getCampaignStatusTranslationKey($status)
   {
       switch($status) {
            case OA_ENTITY_STATUS_PENDING:
                return 'strCampaignStatusPending';

            case OA_ENTITY_STATUS_RUNNING:
               return 'strCampaignStatusRunning';

            case OA_ENTITY_STATUS_PAUSED:
               return 'strCampaignStatusPaused';

            case OA_ENTITY_STATUS_AWAITING:
               return 'strCampaignStatusAwaiting';

            case OA_ENTITY_STATUS_EXPIRED:
               return 'strCampaignStatusExpired';

            case OA_ENTITY_STATUS_INACTIVE:
               return 'strCampaignStatusInactive';

            case OA_ENTITY_STATUS_APPROVAL:
               return 'strCampaignStatusApproval';

            case OA_ENTITY_STATUS_REJECTED:
               return 'strCampaignStatusRejected';
            break;
       }
       return null;
   }

    /**
     * Returns campaign status translated text based on given status.
     *
     * @param int $priority
     * @return name for given campaign type
     */
   static function getCampaignStatusName($status)
   {
       $key = OX_Util_Utils::getCampaignStatusTranslationKey($status);
       if ($key) {
           $name = $GLOBALS[$key];
       }
       return $name;
   }

   /**
    * Calculates the effective CPM (eCPM)
    *
    * @param int $revenueType revenue type (CPM, CPA, etc) as defined in constants.php.
    * @param double $revenue revenue amount, eg 1.55.  CPM, CPC, CPA: the rate. Tenancy: the total.
    * @param int $impressions the number of impressions.
    * @param int $clicks the number of clicks
    * @param int $conversions the number of conversions.
    * @param string $startDate start date of the campaign. Required for tenancy.
    * @param string $endDate end date of the campaign. Required for tenancy.
    * @param double defaultClickRatio click ratio to use when there are no impressions.
    *                                 If null, uses the value in the config file.
    * @param double defaultConversionRatio conversion ratio to use when there are no impressions.
    *                                 If null, uses the value in the config file.
    *
    * @return double the eCPM
    */
   public static function getEcpm($revenueType, $revenue, $impressions = 0, $clicks = 0, $conversions = 0,
        $startDate = null, $endDate = null, $defaultClickRatio = null, $defaultConversionRatio = null)
   {
       $ecpm = 0.0;

       switch($revenueType) {
           case MAX_FINANCE_CPM:
               // eCPM = CPM
               return $revenue;
               break;
           case MAX_FINANCE_CPC:
               if ($impressions != 0) {
                   $ecpm = $revenue * $clicks / $impressions * 1000;
               } else {
                   if (!$defaultClickRatio) {
                       $defaultClickRatio = $GLOBALS['_MAX']['CONF']['priority']['defaultClickRatio'];
                   }
                   $ecpm = $defaultClickRatio * $revenue * 1000;
               }
               break;
           case MAX_FINANCE_CPA:
               if ($impressions != 0) {
                   $ecpm = $revenue * $conversions / $impressions * 1000;
               } else {
                   if (!$defaultConversionRatio) {
                       $defaultConversionRatio = $GLOBALS['_MAX']['CONF']['priority']['defaultConversionRatio'];
                   }
                   $ecpm = $defaultConversionRatio * $revenue * 1000;
               }
               break;
           case MAX_FINANCE_MT:
               if ($impressions != 0) {
                   if ($startDate && $endDate) {
                       $oStart = new Date($startDate);
                       $oStart->setTZbyID('UTC');
                       $oEnd = new Date($endDate);
                       $oEnd->setTZbyID('UTC');
                       $oNow = new Date(date('Y-m-d'));
                       $oNow->setTZbyID('UTC');

                       $daysInCampaign = new Date_Span();
                       $daysInCampaign->setFromDateDiff($oStart, $oEnd);
                       $daysInCampaign = ceil($daysInCampaign->toDays());

                       $daysSoFar = new Date_Span();
                       $daysSoFar->setFromDateDiff($oStart, $oNow);
                       $daysSoFar = ceil($daysSoFar->toDays());

                       $ecpm = ($revenue / $daysInCampaign) * $daysSoFar / $impressions * 1000;
                   } else {
                       // Not valid without start and end dates.
                       $ecpm = 0.0;
                   }
               } else {
                   $ecpm = 0.0;
               }
               break;
       }
       return $ecpm;
   }
}

?>