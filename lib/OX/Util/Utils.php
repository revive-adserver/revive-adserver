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

/**
 * A set of static utility methods 
 * 
 * @author bernard@openx.org
 * $package OX.Util
 *
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
     *
     * @param int $priority
     * @return unknown
     */
   static function getCampaignType($priority)
   {
       if ($priority == 0) { //Remnant - Low priority 
           return OX_CAMPAIGN_TYPE_REMNANT;  
       }
       else if ($priority == -1) { //Contract - ($priority = -1 (Exclusive)
           return OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE;
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
       if ($priority == 0) { //Remnant - Low priority 
           return 'strRemnant';  
       }
       else if ($priority == -1) { //Contract - ($priority = -1 (Exclusive)
           return 'strExclusiveContract';
       }
       else if ($priority > 0) { //Contract - from 1 to 10 (High/Normal)
           return 'strStandardContract';
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
       if ($priority == 0) { //Remnant - Low priority 
           return 'strRemnantInfo';  
       }
       else if ($priority == -1) { //Contract - ($priority = -1 (Exclusive)
           return 'strExclusiveContractInfo';
       }
       else if ($priority > 0) { //Contract - from 1 to 10 (High/Normal)
           return 'strStandardContractInfo';
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
   
}

?>
