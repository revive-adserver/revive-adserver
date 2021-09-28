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
    public function __construct($name = 'OrganisationSelectionField', $defaultAdvertiser = 'all', $defaultPublisher = 'all', $filterBy = FILTER_NONE)
    {
        parent::__construct();
        $this->_name = $name;
        $oScope = new Admin_UI_OrganisationScope();
        $oScope->setAdvertiserId($defaultAdvertiser);
        $oScope->setPublisherId($defaultPublisher);
        $this->_value = $oScope;
        $this->_filter = $filterBy;
    }

    public function _getAdvertisers()
    {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aParams = [];
                $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                $aParams = $this->coreParams + ['advertiser_id' => implode(',', array_keys($aTrackers))];
                $aAdvertisers = Admin_DA::getAdvertisers($aParams);
            } else {
                $aParams = $this->coreParams;
                $aAdvertisers = Admin_DA::getAdvertisers($aParams);
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aParams = ['agency_id' => OA_Permission::getEntityId()];
                $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                $aParams = $this->coreParams + ['advertiser_id' => implode(',', array_keys($aTrackers))];
                $aAdvertisers = Admin_DA::getAdvertisers($aParams);
            } else {
                $aParams = $this->coreParams + ['agency_id' => OA_Permission::getEntityId()];
                $aAdvertisers = Admin_DA::getAdvertisers($aParams);
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $aAdvertisers = [];
            $aParams = ['publisher_id' => OA_Permission::getEntityId(), 'placement_anonymous' => 'f'];
            $aPlacementZones = Admin_DA::getPlacementZones($aParams, false, 'placement_id');
            $aAdZones = Admin_DA::getAdZones($aParams, false, 'ad_id');
            if (!empty($aPlacementZones)) {
                if ($this->_filter == FILTER_TRACKER_PRESENT) {
                    $aParams = ['placement_id' => implode(',', array_keys($aPlacementZones))];
                    $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                    $aParams = $this->coreParams + ['advertiser_id' => implode(',', array_keys($aTrackers))];
                    $aAdvertisers = Admin_DA::getAdvertisers($aParams);
                } else {
                    $aParams = $this->coreParams + ['placement_id' => implode(',', array_keys($aPlacementZones))];
                    $aAdvertisers = Admin_DA::getAdvertisers($aParams);
                }
            }
            if (!empty($aAdZones)) {
                if ($this->_filter == FILTER_TRACKER_PRESENT) {
                    $aParams = ['ad_id' => implode(',', array_keys($aAdZones))];
                    $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                    $aParams = $this->coreParams + ['advertiser_id' => implode(',', array_keys($aTrackers))];
                    $aAdvertisers += Admin_DA::getAdvertisers($aParams);
                } else {
                    $aParams = $this->coreParams + ['ad_id' => implode(',', array_keys($aAdZones))];
                    $aAdvertisers += Admin_DA::getAdvertisers($aParams);
                }
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $aAdvertisers = [];
            $aParams = $this->coreParams + ['advertiser_id' => OA_Permission::getEntityId()];
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                $aParams = $this->coreParams + ['advertiser_id' => implode(',', array_keys($aTrackers))];
                $aAdvertisers += Admin_DA::getAdvertisers($aParams);
            } else {
                $aAdvertisers = Admin_DA::getAdvertisers($aParams);
            }
        }

        // order the array by advertiser name
        foreach ($aAdvertisers as $key => $row) {
            $name[$key] = strtolower($row['name']);
        }
        array_multisort($name, SORT_ASC, $aAdvertisers);
        // rewrite the array to preserve key
        foreach ($aAdvertisers as $row) {
            $aAdvertisersTmp[$row['advertiser_id']] = $row;
        }
        $aAdvertisers = $aAdvertisersTmp;

        return $aAdvertisers;
    }
    public function _getPublishers()
    {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aParams = [];
                $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                $aParams = ['advertiser_id' => implode(',', array_keys($aTrackers))];
                $aPlacementZones = Admin_DA::getPlacementZones($aParams, false, 'zone_id');
                $aAdZones = Admin_DA::getAdZones($aParams, false, 'zone_id');
                $aParams = ['zone_id' => implode(',', array_keys($aPlacementZones + $aAdZones))];
                $aPublishers = Admin_DA::getPublishers($aParams);
            } else {
                $aParams = [];
                $aPublishers = Admin_DA::getPublishers($aParams);
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aParams = ['agency_id' => OA_Permission::getEntityId()];
                $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                $aParams = ['advertiser_id' => implode(',', array_keys($aTrackers))];
                $aPlacementZones = Admin_DA::getPlacementZones($aParams, false, 'zone_id');
                $aAdZones = Admin_DA::getAdZones($aParams, false, 'zone_id');
                $aParams = ['zone_id' => implode(',', array_keys($aPlacementZones + $aAdZones))];
                $aPublishers = Admin_DA::getPublishers($aParams);
            } else {
                $aParams = ['agency_id' => OA_Permission::getEntityId()];
                $aPublishers = Admin_DA::getPublishers($aParams);
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aParams = ['agency_id' => OA_Permission::getAgencyId()];
                $aTrackers = Admin_DA::getTrackers($aParams, false, 'advertiser_id');
                $aParams = ['advertiser_id' => implode(',', array_keys($aTrackers))];
                $aPlacementZones = Admin_DA::getAdZones($aParams, false, 'zone_id');
                $aAdZones = Admin_DA::getAdZones($aParams, false, 'zone_id');
                $aParams = ['publisher_id' => OA_Permission::getEntityId(), 'zone_id' => implode(',', array_keys($aPlacementZones + $aAdZones))];
                $aPublishers = Admin_DA::getPublishers($aParams);
            } else {
                $aParams = ['publisher_id' => OA_Permission::getEntityId()];
                $aPublishers = Admin_DA::getPublishers($aParams);
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $aPublishers = [];
            if ($this->_filter == FILTER_TRACKER_PRESENT) {
                $aParams = ['advertiser_id' => OA_Permission::getEntityId()];
                $aTrackers = Admin_DA::getTrackers($aParams, 'advertiser_id');
                if (!empty($aTrackers)) {
                    $aParams = ['advertiser_id' => OA_Permission::getEntityId(), 'placement_anonymous' => 'f'];
                    $aPlacementZones = Admin_DA::getPlacementZones($aParams, false, 'zone_id');
                    $aAdZones = Admin_DA::getAdZones($aParams, false, 'zone_id');
                    $aZones = $aPlacementZones + $aAdZones;
                    if (!empty($aZones)) {
                        $aParams = ['zone_id' => implode(',', array_keys($aZones))];
                        $aPublishers = Admin_DA::getPublishers($aParams);
                    }
                }
            } else {
                $aParams = ['advertiser_id' => OA_Permission::getEntityId(), 'placement_anonymous' => 'f'];
                $aPlacementZones = Admin_DA::getPlacementZones($aParams, false, 'zone_id');
                $aAdZones = Admin_DA::getAdZones($aParams, false, 'zone_id');
                $aZones = $aPlacementZones + $aAdZones;
                if (!empty($aZones)) {
                    $aParams = ['zone_id' => implode(',', array_keys($aZones))];
                    $aPublishers = Admin_DA::getPublishers($aParams);
                }
            }
        }

        // order the array by publisher name
        foreach ($aPublishers as $key => $row) {
            $name[$key] = strtolower($row['name']);
        }
        array_multisort($name, SORT_ASC, $aPublishers);
        // rewrite the array to preserve key
        foreach ($aPublishers as $row) {
            $aPublishersTmp[$row['publisher_id']] = $row;
        }
        $aPublishers = $aPublishersTmp;

        return $aPublishers;
    }
    public function _hasAnonymousCampaigns()
    {
        $hasAnonymousCampaigns = false;
        
        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $aParams = [
                'placement_anonymous' => 't',
                'advertiser_id' => OA_Permission::getEntityId(),
            ];
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $aParams = [
                'placement_anonymous' => 't',
                'publisher_id' => OA_Permission::getEntityId(),
            ];
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
    
    public function display()
    {
        $name = $this->_name;
        $oScope = $this->_value;

        $hasAnonymousCampaigns = $this->_hasAnonymousCampaigns();
        
        $aAdvertisers = $this->_getAdvertisers();
        
        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $advertiserId = OA_Permission::getEntityId();
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
            foreach ($aAdvertisers as $advertiserId => $aAdvertiser) {
                $selected = $advertiserId == $oScope->_advertiserId ? " selected='selected'" : '';
                echo "
            <option value='$advertiserId'$selected>" . htmlspecialchars($aAdvertiser['name']) . "</option>";
            }
            echo "
        </select>";
        }
        
        if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) && !OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            echo "
        <br /><br />";
        }

        $aPublishers = $this->_getPublishers();
        
        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $publisherId = key($aPublishers);
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
            foreach ($aPublishers as $publisherId => $aPublisher) {
                $selected = $publisherId == $oScope->_publisherId ? " selected='selected'" : '';
                echo "
            <option value='$publisherId'$selected>" . htmlspecialchars($aPublisher['name']) . "</option>";
            }
            echo "
        </select>";
        }
    }
    public function setValueFromArray($aFieldValues)
    {
        $name = $this->_name;
        $oScope = $this->_value;
        
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
