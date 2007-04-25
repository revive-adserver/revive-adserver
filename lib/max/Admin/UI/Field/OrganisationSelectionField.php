<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/Admin/UI/Field.php';
require_once MAX_PATH . '/lib/max/Admin/UI/OrganisationScope.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/common.php';

class Admin_UI_OrganisationSelectionField extends Admin_UI_Field
{
    /**
     * PHP4-style constructor
     *
     * @param array $aFieldSelectionNames A list of the predefined 'friendly' selections.
     * @param string $fieldSelectionDefault The default selection.
     */
    function Admin_UI_OrganisationSelectionField($name = 'OrganisationSelectionField', $defaultAdvertiser = 'all', $defaultPublisher = 'all', $filterBy = FILTER_NONE)
    {
        $this->_name = $name;
        $oScope = new Admin_UI_OrganisationScope();
        $oScope->setAdvertiserId($defaultAdvertiser);
        $oScope->setPublisherId($defaultPublisher);
        $this->_value = $oScope;
        $this->_filter = $filterBy;
    }

    function _getAdvertisers()
    {
        if (phpAds_isUser(phpAds_Admin)) {
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aParams = array();
                $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                $aParams = array('advertiser_id' => implode(',', array_keys($aTrackers)));
                $aAdvertisers = Admin_DA::getAdvertisers($aParams);
            } else {
                $aParams = array();
                $aAdvertisers = Admin_DA::getAdvertisers($aParams);
            }
        } elseif (phpAds_isUser(phpAds_Agency)) {
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aParams = array('agency_id' => phpAds_getUserID());
                $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                $aParams = array('advertiser_id' => implode(',', array_keys($aTrackers)));
                $aAdvertisers = Admin_DA::getAdvertisers($aParams);
            } else {
                $aParams = array('agency_id' => phpAds_getUserID());
                $aAdvertisers = Admin_DA::getAdvertisers($aParams);
            }
        } elseif (phpAds_isUser(phpAds_Publisher)) {
            $aAdvertisers = array();
            $aParams = array('publisher_id' => phpAds_getUserID(), 'placement_anonymous' => 'f');
            $aPlacementZones = Admin_DA::getPlacementZones($aParams, false, 'placement_id');
            $aAdZones = Admin_DA::getAdZones($aParams, false, 'ad_id');
            if (!empty($aPlacementZones)) {
                if ($this->_filter == FILTER_TRACKER_PRESENT) {
                    $aParams = array('placement_id' => implode(',', array_keys($aPlacementZones)));
                    $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                    $aParams = array('advertiser_id' => implode(',', array_keys($aTrackers)));
                    $aAdvertisers = Admin_DA::getAdvertisers($aParams);
                } else {
                    $aParams = array('placement_id' => implode(',', array_keys($aPlacementZones)));
                    $aAdvertisers = Admin_DA::getAdvertisers($aParams);
                }
            }
            if (!empty($aAdZones)) {
                if ($this->_filter == FILTER_TRACKER_PRESENT) {
                    $aParams = array('ad_id' => implode(',', array_keys($aAdZones)));
                    $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                    $aParams = array('advertiser_id' => implode(',', array_keys($aTrackers)));
                    $aAdvertisers += Admin_DA::getAdvertisers($aParams);
                } else {
                    $aParams = array('ad_id' => implode(',', array_keys($aAdZones)));
                    $aAdvertisers += Admin_DA::getAdvertisers($aParams);
                }
            }
        } elseif (phpAds_isUser(phpAds_Advertiser)) {
            $aAdvertisers = array();
            $aParams = array('advertiser_id' => phpAds_getUserID());
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                $aParams = array('advertiser_id' => implode(',', array_keys($aTrackers)));
                $aAdvertisers += Admin_DA::getAdvertisers($aParams);
            } else {
                $aAdvertisers = Admin_DA::getAdvertisers($aParams);
            }
        }

        // order the array by advertiser name
        foreach ($aAdvertisers as $key => $row) {
            $name[$key]  = strtolower($row['name']);
        }
        array_multisort($name, SORT_ASC, $aAdvertisers);
        // rewrite the array to preserve key
        foreach ($aAdvertisers as $row) {
            $aAdvertisersTmp[$row['advertiser_id']] = $row;
        }
        $aAdvertisers = $aAdvertisersTmp;

        return $aAdvertisers;
    }
    function _getPublishers()
    {
        if (phpAds_isUser(phpAds_Admin)) {
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aParams = array();
                $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                $aParams = array('advertiser_id' => implode(',', array_keys($aTrackers)));
                $aPlacementZones = Admin_DA::getPlacementZones($aParams, false, 'zone_id');
                $aAdZones = Admin_DA::getAdZones($aParams, false, 'zone_id');
                $aParams = array('zone_id' => implode(',', array_keys($aPlacementZones + $aAdZones)));
                $aPublishers = Admin_DA::getPublishers($aParams);
            } else {
                $aParams = array();
                $aPublishers = Admin_DA::getPublishers($aParams);
            }
        } elseif (phpAds_isUser(phpAds_Agency)) {
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aParams = array('agency_id' => phpAds_getUserID());
                $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                $aParams = array('advertiser_id' => implode(',', array_keys($aTrackers)));
                $aPlacementZones = Admin_DA::getPlacementZones($aParams, false, 'zone_id');
                $aAdZones = Admin_DA::getAdZones($aParams, false, 'zone_id');
                $aParams = array('zone_id' => implode(',', array_keys($aPlacementZones + $aAdZones)));
                $aPublishers = Admin_DA::getPublishers($aParams);
            } else {
                $aParams = array('agency_id' => phpAds_getUserID());
                $aPublishers = Admin_DA::getPublishers($aParams);
            }
        } elseif (phpAds_isUser(phpAds_Publisher)) {
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aParams = array('agency_id' => phpAds_getAgencyID());
                $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                $aParams = array('advertiser_id' => implode(',', array_keys($aTrackers)));
                $aPlacementZones = Admin_DA::getAdZones($aParams, false, 'zone_id');
                $aAdZones = Admin_DA::getAdZones($aParams, false, 'zone_id');
                $aParams = array('publisher_id' => phpAds_getUserID(), 'zone_id' => implode(',', array_keys($aPlacementZones + $aAdZones)));
                $aPublishers = Admin_DA::getPublishers($aParams);
            } else {
                $aParams = array('publisher_id' => phpAds_getUserID());
                $aPublishers = Admin_DA::getPublishers($aParams);
            }
        } elseif (phpAds_isUser(phpAds_Advertiser)) {
            $aPublishers = array();
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aParams = array('advertiser_id' => phpAds_getUserID());
                $aTrackers = Admin_DA::getTrackers($aTrackers, 'advertiser_id');
                if (!empty($aTrackers)) {
                    $aParams = array('advertiser_id' => phpAds_getUserID(), 'placement_anonymous' => 'f');
                    $aPlacementZones = Admin_DA::getPlacementZones($aParams, false, 'zone_id');
                    $aAdZones = Admin_DA::getAdZones($aParams, false, 'zone_id');
                    $aZones = $aPlacementZones + $aAdZones;
                    if (!empty($aZones)) {
                        $aParams = array('zone_id' => implode(',', array_keys($aZones)));
                        $aPublishers = Admin_DA::getPublishers($aParams);
                    }
                }
            } else {
                $aParams = array('advertiser_id' => phpAds_getUserID(), 'placement_anonymous' => 'f');
                $aPlacementZones = Admin_DA::getPlacementZones($aParams, false, 'zone_id');
                $aAdZones = Admin_DA::getAdZones($aParams, false, 'zone_id');
                $aZones = $aPlacementZones + $aAdZones;
                if (!empty($aZones)) {
                    $aParams = array('zone_id' => implode(',', array_keys($aZones)));
                    $aPublishers = Admin_DA::getPublishers($aParams);
                }
            }
        }        

        // order the array by publisher name
        foreach ($aPublishers as $key => $row) {
            $name[$key]  = strtolower($row['name']);
        }
        array_multisort($name, SORT_ASC, $aPublishers);
        // rewrite the array to preserve key
        foreach ($aPublishers as $row) {
            $aPublishersTmp[$row['publisher_id']] = $row;
        }
        $aPublishers = $aPublishersTmp;

        return $aPublishers;
    }
    function _hasAnonymousCampaigns()
    {
        $hasAnonymousCampaigns = false;
        
        if (phpAds_isUser(phpAds_Advertiser)) {
            $aParams = array(
                'placement_anonymous' => 't',
                'advertiser_id' => phpAds_getUserID(),
            );
        } elseif (phpAds_isUser(phpAds_Publisher)) {
            $aParams = array(
                'placement_anonymous' => 't',
                'publisher_id' => phpAds_getUserID(),
            );
        }
        
        if (!empty($aParams)) {
            $aPlacementZones = Admin_DA::getPlacementZones($aParams);
            if (!empty($aPlacementZones)) {
                $hasAnonymousCampaigns = true;
            } else {
                $aAdZones = Admin_DA::getAdZones($aParams);
                if (!empty($aAdZones)) {
                    $hasAnonymousCampaigns = true;
                }
            }
        }
        
        return $hasAnonymousCampaigns;
    }
    
    function display()
    {
        $name = $this->_name;
        $oScope = $this->_value;

        $hasAnonymousCampaigns = $this->_hasAnonymousCampaigns($aParams);
        
        $aAdvertisers = $this->_getAdvertisers();
        
        if (phpAds_isUser(phpAds_Advertiser)) {
            $advertiserId = phpAds_getUserID();
            echo "
        <input type='hidden' name='{$name}_advertiser' id='{$name}_advertiser' value='$advertiserId'>";
        } else {
            echo "
        <select name='{$name}_advertiser' id='{$name}_advertiser' tabindex='" . $this->_tabIndex++ . "'>
            <option value='all'>-- {$GLOBALS['strAllAdvertisers']} --</option>";
            if ($hasAnonymousCampaigns) {
                echo "
            <option value='anon'>-- {$GLOBALS['strAnonAdvertisers']} --</option>";
            }
            foreach ($aAdvertisers as $advertiserId=>$aAdvertiser) {
                $selected = $advertiserId == $oScope->_advertiserId ? " selected='selected'" : '';
                echo "
            <option value='$advertiserId'$selected>{$aAdvertiser['name']}</option>";
            }
            echo "
        </select>";
        }
        
        if (!phpAds_isUser(phpAds_Advertiser) && !phpAds_isUser(phpAds_Publisher)) {
            echo "
        <br /><br />";
        }

        $aPublishers = $this->_getPublishers();
        
        if (phpAds_isUser(phpAds_Publisher)) {
            echo "
        <input type='hidden' name='{$name}_publisher' id='{$name}_publisher' value='$publisherId'>";
        } else {
            echo "
        <select name='{$name}_publisher' id='{$name}_publisher' tabindex='" . $this->_tabIndex++ . "'>
            <option value='all'>-- {$GLOBALS['strAllPublishers']} --</option>";
            if ($hasAnonymousCampaigns) {
                echo "
            <option value='anon'>-- {$GLOBALS['strAnonPublishers']} --</option>";
            }
            foreach ($aPublishers as $publisherId=>$aPublisher) {
                $selected = $publisherId == $oScope->_publisherId ? " selected='selected'" : '';
                echo "
            <option value='$publisherId'$selected>{$aPublisher['name']}</option>";
            }
            echo "
        </select>";
        }
    }
    function setValueFromArray($aFieldValues)
    {
        $name = $this->_name;
        $oScope =& $this->_value;
        
        $publisherFieldName = $name . '_publisher';
        $advertiserFieldName = $name . '_advertiser';
        
        $anonymous = false;

        // Get advertiser scope...
        if (!empty($aFieldValues[$advertiserFieldName])) {
            if (is_numeric($aFieldValues[$advertiserFieldName])) {
                $advertiserId = $aFieldValues[$advertiserFieldName];
            } else {
                $advertiserId = false;
                if ($aFieldValues[$advertiserFieldName] == 'anon') {
                    $anonymous = true;
                }
            }
            $oScope->setAdvertiserId($advertiserId);
        }
        // Get publisher scope...
        if (!empty($aFieldValues[$publisherFieldName])) {
            if (is_numeric($aFieldValues[$publisherFieldName])) {
                $publisherId = $aFieldValues[$publisherFieldName];
            } else {
                $publisherId = false;
                if ($aFieldValues[$advertiserFieldName] == 'anon') {
                    $anonymous = true;
                }
            }
            $oScope->setPublisherId($publisherId);
        }
        $oScope->setAnonymous($anonymous);
    }
}

?>
