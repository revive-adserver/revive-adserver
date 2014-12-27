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

define ('FILTER_NONE',0);
define ('FILTER_TRACKER_PRESENT',1);
define ('FILTER_ZONE_INVENTORY_DOMAIN_PAGE_INDEXED',2);
define ('FILTER_ZONE_INVENTORY_COUNTRY_INDEXED',3);
define ('FILTER_ZONE_INVENTORY_SOURCE_INDEXED',4);
define ('FILTER_ZONE_INVENTORY_CHANNEL_INDEXED',5);

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
    var $_name;
    /* @var string */
    var $_value;
    /* @var integer */
    var $_tabIndex;
    /* @var integer */
    var $_filter;

    function __construct()
    {
        $this->coreParams = OA_Admin_Statistics_Common::getCoreParams();
    }

    function setName($name)
    {
        $this->_name = $name;
    }

    function setValue($value)
    {
        $this->_value = $value;
    }

    function getValue()
    {
        return $this->_value;
    }

    function setFilter($filter)
    {
        switch ($filter) {
            case 'tracker-present' : $this->_filter = FILTER_TRACKER_PRESENT; break;
            case 'zone-inventory-domain-page-indexed' : $this->_filter = FILTER_ZONE_INVENTORY_DOMAIN_PAGE_INDEXED; break;
            case 'zone-inventory-country-indexed' : $this->_filter = FILTER_ZONE_INVENTORY_COUNTRY_INDEXED; break;
            case 'zone-inventory-source-indexed' : $this->_filter = FILTER_ZONE_INVENTORY_SOURCE_INDEXED; break;
            case 'zone-inventory-channel-indexed' : $this->_filter = FILTER_ZONE_INVENTORY_CHANNEL_INDEXED; break;
            default : $this->_filter = FILTER_NONE; break;
        }
    }
    function setValueFromArray($aFieldValues)
    {
        $name = $this->_name;
        if (!is_null($aFieldValues[$name])) {
            $this->_value = $aFieldValues[$name];
        }
    }

    // e.g. multisort($a, "'name'", true, 0, "'id'", false, 2));
    // This works like MYSQL 'ORDER BY id DESC, name ASC'
    function multiSort($array)
    {
        for($i = 1; $i < func_num_args(); $i += 3) {
            $key = func_get_arg($i);
            if (is_string($key)) {
                $key = '"'.$key.'"';
            }
            $order = true;
            if($i + 1 < func_num_args()) {
                $order = func_get_arg($i + 1);
            }
            $type = 0;
            if($i + 2 < func_num_args()) {
                $type = func_get_arg($i + 2);
            }

            switch($type) {
            case 1: // Case insensitive natural.
                $t = 'strcasecmp($a[' . $key . '], $b[' . $key . '])';
                break;
            case 2: // Numeric.
                $t = '($a[' . $key . '] == $b[' . $key . ']) ? 0:(($a[' . $key . '] < $b[' . $key . ']) ? -1 : 1)';
                break;
            case 3: // Case sensitive string.
                $t = 'strcmp($a[' . $key . '], $b[' . $key . '])';
                break;
            case 4: // Case insensitive string.
                $t = 'strcasecmp($a[' . $key . '], $b[' . $key . '])';
                break;
            default: // Case sensitive natural.
                $t = 'strnatcmp($a[' . $key . '], $b[' . $key . '])';
                break;
            }

            usort($array, create_function('$a, $b', '; return ' . ($order ? '' : '-') . '(' . $t . ');'));
        }
        return $array;
    }

}

?>
