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

require_once __DIR__ . '/Subdivision1.class.php';

/**
 * A Geo delivery limitation plugin, for filtering delivery of ads on the
 * basis of the viewer's country and region.
 *
 * Works with:
 * A string of format "CC|list" where "CC" is a valid country code and "list"
 * is a comma separated list of valid region codes. See the Region.res.inc.php
 * resource file for details of the valid country and region codes that can be
 * used with this plugin. (Note that the Country.res.inc.php resource file
 * contains a DIFFERENT list of valid country codes.)
 *
 * Valid comparison operators:
 * ==, !=
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 *
 * @TODO Does this need to be updated to use =~ and !~ comparison operators?
 */
class Plugins_DeliveryLimitations_Geo_Subdivision2 extends Plugins_DeliveryLimitations_Geo_Subdivision1
{
    use \RV\Extension\DeliveryLimitations\GeoLimitationTrait;

    public function __construct()
    {
        parent::__construct();
        $this->nameEnglish = 'Geo - Level 2 Subdivision';
    }

    protected function getSubdivisions($countryCode)
    {
        $aSubdivisions = [];

        foreach ($this->res[1][$countryCode] as $aLevel1) {
            foreach ($aLevel1 as $key => $value) {
                $aSubdivisions[$key] = $value;
            }
        }

        asort($aSubdivisions);

        return $aSubdivisions;
    }
}
