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

require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitationsCommaSeparatedData.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * A Client delivery limitation plugin, for filtering delivery of ads on the
 * basis of the viewer's language.
 *
 * Works with an array of language codes, eg.: 'en,pl,jp'.
 *
 * Valid comparison operators:
 * =~, !~
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_Client_Language extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    function __construct()
    {
        parent::__construct();
        $this->nameEnglish = 'Client - Language';
    }


    function init($data)
    {
        parent::init($data);
        $this->setAValues(array_keys($this->res));
    }

    function displayArrayData()
    {
        $tabindex =& $GLOBALS['tabindex'];

        echo "<div class='box'>";
        foreach ($this->res as $code => $name) {
            echo "<div class='boxrow'>";
            echo "<input tabindex='".($tabindex++)."' ";
            echo "type='checkbox' id='c_{$this->executionorder}_{$code}' name='acl[{$this->executionorder}][data][]' value='{$code}'".(in_array($code, $this->data) ? ' CHECKED' : '').">{$name}</div>";
        }
        echo "</div>";
    }

}

?>
