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

define('FILTER_NONE', 0);
define('FILTER_TRACKER_PRESENT', 1);
define('FILTER_ZONE_INVENTORY_DOMAIN_PAGE_INDEXED', 2);
define('FILTER_ZONE_INVENTORY_COUNTRY_INDEXED', 3);
define('FILTER_ZONE_INVENTORY_SOURCE_INDEXED', 4);
define('FILTER_ZONE_INVENTORY_CHANNEL_INDEXED', 5);

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Common.php';

/**
 * Abstract data field object, used to supply reports, statistics, and other admin UI screens with parameters.
 *
 * Always use the factory method to instantiate fields -- it will create
 * the right subclass for you.
 *
 * @abstract
 * @package    Max
 */
class Admin_UI_Field
{
    /* @var string */
    public $_name;
    /* @var string */
    public $_value;
    /* @var integer */
    public $_tabIndex;
    /* @var integer */
    public $_filter;

    public function __construct()
    {
        $this->coreParams = OA_Admin_Statistics_Common::getCoreParams();
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setValue($value)
    {
        $this->_value = $value;
    }

    public function getValue()
    {
        return $this->_value;
    }

    public function setFilter($filter)
    {
        switch ($filter) {
            case 'tracker-present': $this->_filter = FILTER_TRACKER_PRESENT; break;
            case 'zone-inventory-domain-page-indexed': $this->_filter = FILTER_ZONE_INVENTORY_DOMAIN_PAGE_INDEXED; break;
            case 'zone-inventory-country-indexed': $this->_filter = FILTER_ZONE_INVENTORY_COUNTRY_INDEXED; break;
            case 'zone-inventory-source-indexed': $this->_filter = FILTER_ZONE_INVENTORY_SOURCE_INDEXED; break;
            case 'zone-inventory-channel-indexed': $this->_filter = FILTER_ZONE_INVENTORY_CHANNEL_INDEXED; break;
            default: $this->_filter = FILTER_NONE; break;
        }
    }
    public function setValueFromArray($aFieldValues)
    {
        $name = $this->_name;
        if (!is_null($aFieldValues[$name])) {
            $this->_value = $aFieldValues[$name];
        }
    }

    // e.g. multisort($a, "'name'", true, 0, "'id'", false, 2));
    // This works like MYSQL 'ORDER BY id DESC, name ASC'
    public function multiSort($array, ...$other)
    {
        while (!empty($other)) {
            $key = array_shift($other);
            $order = array_shift($other) ?? true;
            $type = array_shift($other) ?? 0;

            $mult = $order ? 1 : -1;

            usort($array, function ($a, $b) use ($mult, $type, $key) {
                switch ($type) {
                    case 1: // Case insensitive natural.
                        return $mult * strcasecmp($a[$key], $b[$key]);

                    case 2: // Numeric.
                        return $a[$key] == $b[$key] ? 0 : $mult * ($a[$key] < $b[$key] ? -1 : 1);

                    case 3: // Case sensitive string.
                        return $mult * strcmp($a[$key], $b[$key]);

                    case 4: // Case insensitive string.
                        return $mult * strcasecmp($a[$key], $b[$key]);
                }

                return $mult * strnatcmp($a[$key], $b[$key]);
            });
        }

        return $array;
    }
}
