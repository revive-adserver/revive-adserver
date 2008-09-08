<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id$
*/

require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitations.php';

/**
 * A Geo delivery limitation plugin, for filtering delivery of ads on the
 * basis of the viewer's postal code (US/Canada only).
 *
 * Valid comparison operators:
 * ==, !=,=~,!~,=x,!x
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 */
class Plugins_DeliveryLimitations_Geo_Postalcode extends Plugins_DeliveryLimitations
{

    function Plugins_DeliveryLimitations_Geo_Postalcode()
    {
        $this->Plugins_DeliveryLimitations();
        $this->columnName = 'geo_postal_code';
    }

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('US/Canada Postal Code', $this->extension, $this->group);
    }

    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    function isAllowed()
    {
        return ((isset($GLOBALS['_MAX']['GEO_DATA']['postal_code']))
            || $GLOBALS['_MAX']['CONF']['geotargeting']['showUnavailable']);
    }
}

?>
