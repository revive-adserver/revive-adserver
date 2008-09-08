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
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_DeliveryLimitations_Client_Language extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    function Plugins_DeliveryLimitations_Client_Language()
    {
        $this->Plugins_DeliveryLimitations_ArrayData();
        $this->nameEnglish = 'Language';
    }


    function init($data)
    {
        parent::init($data);
        $this->setAValues(array_keys($this->res));
    }


    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    function isAllowed()
    {
        return ((isset($GLOBALS['_MAX']['GEO_DATA']['country_code']))
            || $GLOBALS['_MAX']['CONF']['geotargeting']['showUnavailable']);
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
