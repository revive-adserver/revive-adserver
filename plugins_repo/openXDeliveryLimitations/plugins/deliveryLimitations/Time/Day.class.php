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

require_once dirname(__FILE__) . '/AbstractTimePlugin.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation/Common.php';

/**
 * A Time delivery limitation plugin, for blocking delivery of ads on the basis
 * of the day of the week.
 *
 * Works with:
 * A comma separated list of numbers, in the range 0 - 6, representing the
 * days of the week from Sunday (0) to Saturday (6).
 *
 * Valid comparison operators:
 * =~, !~
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_Time_Day extends Plugins_DeliveryLimitations_AbstractTimePlugin
{
    /**
     * Calls the parent constructor with the values of 0 and 6.
     *
     * @return Plugins_DeliveryLimitations_Time_Day
     */
    function __construct()
    {
        $this->Plugins_DeliveryLimitations_Time_Base(0, 6);

        $this->nameEnglish = 'Time - Day of week';
    }

    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    function isAllowed($page = false)
    {
        return ($page != 'channel-acl.php');
    }

    /**
     * Outputs the HTML to display the data for this limitation
     *
     * @return void
     */
    function displayArrayData()
    {
        $tabindex =& $GLOBALS['tabindex'];
        echo "<table width='275' cellpadding='0' cellspacing='0' border='0'>";
		for ($i = 0; $i < 7; $i++) {
			if ($i % 4 == 0) echo "<tr>";
			echo "<td><input type='checkbox' name='acl[{$this->executionorder}][data][]' value='$i'".(in_array($i, $this->data) ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;{$this->res[$i]}&nbsp;&nbsp;</td>";
			if (($i + 1) % 4 == 0) echo "</tr>";
		}
		if (($i + 1) % 4 != 0) echo "</tr>";
		echo "</table>";
    }

    /**
     * A method to return an instance to be used by the MPE
     *
     * @param unknown_type $aDeliveryLimitation
     */
    function getMpeClassInstance($aDeliveryLimitation)
    {
        return new OA_Maintenance_Priority_DeliveryLimitation_Common($aDeliveryLimitation);
    }
}

?>