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
 * @package    Max
 */
abstract class Admin_UI_Field
{
    /** @var string */
    public $_name;
    /** @var string */
    public $_value;
    /** @var integer */
    public $_tabIndex;
    /** @var integer */
    public $_filter;
    /** @var array */
    protected $coreParams;

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
        $this->_filter = match ($filter) {
            'tracker-present' => FILTER_TRACKER_PRESENT,
            'zone-inventory-domain-page-indexed' => FILTER_ZONE_INVENTORY_DOMAIN_PAGE_INDEXED,
            'zone-inventory-country-indexed' => FILTER_ZONE_INVENTORY_COUNTRY_INDEXED,
            'zone-inventory-source-indexed' => FILTER_ZONE_INVENTORY_SOURCE_INDEXED,
            'zone-inventory-channel-indexed' => FILTER_ZONE_INVENTORY_CHANNEL_INDEXED,
            default => FILTER_NONE,
        };
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

            usort($array, fn($a, $b) => match ($type) {
                1 => $mult * strcasecmp($a[$key], $b[$key]),
                2 => $a[$key] == $b[$key] ? 0 : $mult * ($a[$key] < $b[$key] ? -1 : 1),
                3 => $mult * strcmp($a[$key], $b[$key]),
                4 => $mult * strcasecmp($a[$key], $b[$key]),
                default => $mult * strnatcmp($a[$key], $b[$key]),
            });
        }

        return $array;
    }
}
