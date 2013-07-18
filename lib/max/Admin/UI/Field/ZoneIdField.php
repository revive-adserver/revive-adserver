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

class Admin_UI_ZoneIdField extends Admin_UI_Field
{
    function display()
    {
        echo "
        <select name='{$this->_name}' tabindex='".($this->_tabIndex++)."'>";
        $this->displayZonesAsOptionList();
        echo "
        </select>";
    }

    function getZones()
    {
        global $list_filters;

        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $aParams = array();
            $aPublishers = Admin_DA::getPublishers($aParams);
            // set publisher id if list is to be filtered by publisher
            if (isset($list_filters['publisher'])) {
                $aParams = array('publisher_id' => $list_filters['publisher']);
            } else { // else use all publishers
                $aParams = array('publisher_id' => implode(',',array_keys($aPublishers)));
            }
            if (isset($this->_filter)) {
                $aParams['zone_inventory_forecast_type'] = $this->getForecastType();
            }
            $aZones = Admin_DA::getZones($aParams);
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $aParams = array('agency_id' => OA_Permission::getEntityId());
            $aPublishers = Admin_DA::getPublishers($aParams);
            // set publisher id if list is to be filtered by publisher
            if (isset($list_filters['publisher'])) {
                $aParams = array('publisher_id' => $list_filters['publisher']);
            } else { // else use all of this agency's publishers
                $aParams = array('publisher_id' => implode(',',array_keys($aPublishers)));
            }
            if (isset($this->_filter)) {
                $aParams['zone_inventory_forecast_type'] = $this->getForecastType();
            }
            $aZones = Admin_DA::getZones($aParams);
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $aParams = array('publisher_id' => OA_Permission::getEntityId());
            $aPublishers = Admin_DA::getPublishers($aParams);
            $aParams = array('publisher_id' => implode(',',array_keys($aPublishers)));
            if (isset($this->_filter)) {
                $aParams['zone_inventory_forecast_type'] = $this->getForecastType();
            }
            $aZones = Admin_DA::getZones($aParams);
        } else {
            $aPublishers = array();
            $aZones = array();
        }

        $aZoneArray = array();
        foreach ($aPublishers as $publisherId => $aPublisher) {
            foreach ($aZones as $zoneId => $aZone) {
                if ($aZone['publisher_id'] == $publisherId) {
                    $aZoneArray[$zoneId] = phpads_buildName($publisherId, MAX_getPublisherName($aPublisher['name'])) . " - " . phpAds_buildName($zoneId, MAX_getZoneName($aZone['name']));
                }
            }
        }

        return $aZoneArray;
    }

    function getForecastType ()
    {
        switch ($this->_filter) {
        case FILTER_ZONE_INVENTORY_DOMAIN_PAGE_INDEXED :
            return 1;
            break;
        case FILTER_ZONE_INVENTORY_COUNTRY_INDEXED :
            return 2;
            break;
        case FILTER_ZONE_INVENTORY_SOURCE_INDEXED :
            return 4;
            break;
        case FILTER_ZONE_INVENTORY_CHANNEL_INDEXED :
            return 8;
            break;
        }
    }

    function displayZonesAsOptionList()
    {
        $aZones = $this->getZones();
        foreach ($aZones as $zoneId => $aZone) {
            $selected = $zoneId == $this->getValue() ? " selected='selected'" : '';
            echo "<option value='$zoneId'$selected>$aZone</option>";
        }
    }
}

?>
