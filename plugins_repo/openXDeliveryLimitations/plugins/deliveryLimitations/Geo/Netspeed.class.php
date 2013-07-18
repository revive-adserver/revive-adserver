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

/**
 * A Geo delivery limitation plugin, for filtering delivery of ads on the
 * basis of the viewer's internet speed connection.
 *
 * Works with:
 * A comma separated list of valid netspeed values. See the Netspeed.res.inc.php
 * resource file for details of the valid netspeed codes.
 *
 * Valid comparison operators:
 * =~, !~
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_DeliveryLimitations_Geo_Netspeed extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    function __construct()
    {
        parent::__construct();
        $this->nameEnglish = 'Geo - Net Speed';
    }

    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    function isAllowed()
    {
        return ((isset($GLOBALS['_MAX']['GEO_DATA']['netspeed']))
            || $GLOBALS['_MAX']['CONF']['geotargeting']['showUnavailable']);
    }

    /**
     * Outputs the HTML to display the data for this limitation
     *
     * @return void
     */
    function displayArrayData()
    {
        $tabindex =& $GLOBALS['tabindex'];
        echo "<table width='300' cellpadding='0' cellspacing='0' border='0'>";
        $i = 0;
        foreach ($this->res as $value => $name) {
            if ($i % 2 == 0) echo "<tr>";
            echo "<td><input type='checkbox' name='acl[{$this->executionorder}][data][]' value='$value'".(in_array($value, $this->data) ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;{$name}</td>";
            if (($i + 1) % 2 == 0) echo "</tr>";
            $i++;
        }
		echo "</table>";
    }

}

?>
