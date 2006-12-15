<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: Day.plugin.php 5821 2006-10-31 11:33:28Z andrew@m3.net $
*/

require_once MAX_PATH . '/plugins/deliveryLimitations/DeliveryLimitations.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/plugins/deliveryLimitations/DeliveryLimitationsCommaSeparatedData.php';

/**
 * @package    MaxPlugin
 * @subpackage DeliveryLimitations
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */

/**
 * A Time delivery limitation plugin base class.
 *
 * Works with:
 * A comma separated list of numbers, in the range specified in the constructor.
 *
 * Valid comparison operators:
 * ==, !=
 *
 * @package    MaxPlugin
 * @subpackage DeliveryLimitations
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 */
class Plugins_DeliveryLimitations_AbstractTimePlugin extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    /**
     * Initializes the object with range $min - $max.
     *
     * @param int $min
     * @param int $max
     * @return Plugins_DeliveryLimitations_Time_Base
     */
    function Plugins_DeliveryLimitations_Time_Base($min, $max)
    {
        $this->Plugins_DeliveryLimitations_ArrayData();
        $this->setAValues(range($min, $max));
    }
}