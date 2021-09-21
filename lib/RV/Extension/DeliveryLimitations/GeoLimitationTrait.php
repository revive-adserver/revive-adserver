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

namespace RV\Extension\DeliveryLimitations;

use RV\Extension\GeoTargetingComponentInterface;

trait GeoLimitationTrait
{
    /**
     * @return array
     */
    private function getGeoCapabilities()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $oGeoComponent = \OX_Component::factoryByComponentIdentifier($aConf['geotargeting']['type']);

        if (!$oGeoComponent instanceof GeoTargetingComponentInterface) {
            return [];
        }

        return $oGeoComponent->getCapabilities();
    }

    /**
     * @param string $capability
     *
     * @return bool
     */
    private function hasCapability($capability)
    {
        return $GLOBALS['_MAX']['CONF']['geotargeting']['showUnavailable'] ||
            isset($this->getGeoCapabilities()[$capability]);
    }
}
