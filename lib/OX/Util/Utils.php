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

/**
 * A set of static utility methods
 *
 * @package    OpenX
 * @subpackage Utils
 * @author     Bernard Lange <bernard.lange@openx.org>
 */
class OX_Util_Utils
{
    /**
     * Returns campaign type based on given priority
     * Type => priorities mapping is as follows:
     *  - Contract:
     *      -1 (Exclusive) OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE
     *      1-10 (High) OX_CAMPAIGN_TYPE_CONTRACT_NORMAL
     *  - Remnant (OX_CAMPAIGN_TYPE_REMNANT):
     *      0 (Low)
     *  - eCPM (OX_CAMPAIGN_TYPE_ECPM):
     *      -2 (Low)
     *
     * @param int $priority
     * @return unknown
     */
   static function getCampaignType($priority)
   {
       if (priority == null || priority == "") {
           return null;
       }

       if ($priority == 0) { //Remnant - Low priority
           return OX_CAMPAIGN_TYPE_REMNANT;
       }
       else if ($priority == -1) { //Contract - ($priority = -1 (Exclusive)
           return OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE;
       }
       else if ($priority == -2) { //Low priority - ($priority = -2 (eCPM)
           return OX_CAMPAIGN_TYPE_ECPM;
       }
       else if ($priority > 0) { //Contract - from 1 to 10 (High/Normal)
           return OX_CAMPAIGN_TYPE_CONTRACT_NORMAL;
       }

       return null;
   }

    /**
     * Returns campaign translation key based on a given priority. Uses getCampaignType
     * to calculate the campaign type.
     * Type => labels map as follows:
     *  - Contract:
     *      -1 (Exclusive) strExclusiveContract
     *      1-10 (High) strStandardContract
     *  - Remnant
     *      0 (Low) strRemnant
     *
     * @param int $priority
     * @return translation key for a given campaign type
     */
   static function getCampaignTypeTranslationKey($priority)
   {
       $type = OX_Util_Utils::getCampaignType($priority);

       if ($type == OX_CAMPAIGN_TYPE_REMNANT) { //Remnant - Low priority
           return 'strRemnant';
       }
       else if ($type == OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE) { //Contract - ($priority = -1 (Exclusive)
           return 'strExclusiveContract';
       }
       else if ($type == OX_CAMPAIGN_TYPE_CONTRACT_NORMAL) { //Contract - from 1 to 10 (High/Normal)
           return 'strStandardContract';
       }
       else if ($type == OX_CAMPAIGN_TYPE_ECPM) { //eCPM - Low priority
           return 'strECPM';
       }

       //no type yet no key, sorry
       return null;
   }


    /**
     * Returns campaign type description translation key based on a given priority.
     * Uses getCampaignType to calculate the campaign type.
     * Type => labels map as follows:
     *  - Contract:
     *      -1 (Exclusive) strExclusiveContract
     *      1-10 (High) strStandardContract
     *  - Remnant
     *      0 (Low) strRemnant
     *
     * @param int $priority
     * @return translation key for a given campaign type description
     */
   static function getCampaignTypeDescriptionTranslationKey($priority)
   {
       $type = OX_Util_Utils::getCampaignType($priority);

       if ($type == OX_CAMPAIGN_TYPE_REMNANT) { //Remnant - Low priority
           return 'strRemnantInfo';
       }
       else if ($type == OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE) { //Contract - ($priority = -1 (Exclusive)
           return 'strExclusiveContractInfo';
       }
       else if ($type == OX_CAMPAIGN_TYPE_CONTRACT_NORMAL) { //Contract - from 1 to 10 (High/Normal)
           return 'strStandardContractInfo';
       }
       else if ($type == OX_CAMPAIGN_TYPE_ECPM) { //Remnant - Low priority ($priority = -2)
           return 'strECPMInfo';
       }

       //no type yet no key, sorry
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
            //unknown status
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


}

?>