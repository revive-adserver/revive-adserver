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

use Sinergi\BrowserDetector\Browser;

/**
 * A Client delivery limitation plugin, for filtering delivery of ads on the
 * basis of the viewer's browser.
 *
 * Works with:
 * A comma separated list of valid browser codes. See the phpSniff.class.php
 * file for details of the valid browser codes.
 *
 * Valid comparison operators:
 * =~, !~
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_Client_Browser extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    protected static $aBrowsers = [
        'GC' => 'Chrome',
        'FX' => 'Firefox',
        'IE' => 'Internet Explorer',
        'SF' => 'Safari',
        'OP' => 'Opera',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->nameEnglish = 'Client - Browser (Deprecated)';
    }

    /**
     * Outputs the HTML to display the data for this limitation
     *
     * @return void
     */
    public function displayArrayData()
    {
        $tabindex = &$GLOBALS['tabindex'];

        $i = 0;

        echo "<table cellpadding='3' cellspacing='3'>";
        foreach (self::$aBrowsers as $key => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES);
            if ($i % 4 == 0) {
                echo "<tr>";
            }
            echo "<td><input type='checkbox' name='acl[{$this->executionorder}][data][]' value='$key'" . (in_array($key, $this->data) ? ' checked="checked"' : '') . " tabindex='" . ($tabindex++) . "'>" . $value . "</td>";
            if (($i + 1) % 4 == 0) {
                echo "</tr>";
            }
            $i++;
        }
        if (($i + 1) % 4 != 0) {
            echo "</tr>";
        }
        echo "</table>";
    }
}
