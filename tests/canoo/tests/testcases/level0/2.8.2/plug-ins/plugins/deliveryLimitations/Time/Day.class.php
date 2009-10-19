<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: Day.class.php 39260 2009-07-03 14:20:27Z matteo.beccati $
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
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_DeliveryLimitations_Time_Day extends Plugins_DeliveryLimitations_AbstractTimePlugin
{
    /**
     * Calls the parent constructor with the values of 0 and 6.
     *
     * @return Plugins_DeliveryLimitations_Time_Day
     */
    function Plugins_DeliveryLimitations_Time_Day()
    {
        $this->Plugins_DeliveryLimitations_Time_Base(0, 6);
    }

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate('Day of week');
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