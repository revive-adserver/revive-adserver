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
 * basis of the viewer's Designated Market Area (US only).
 *
 * Works with:
 * A comma separated list of valid DMA codes. See the Dma.res.inc.php resource
 * file for details of the valid DMA codes.
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
class Plugins_DeliveryLimitations_Geo_Dma extends Plugins_DeliveryLimitations_CommaSeparatedData
{

    function Plugins_DeliveryLimitations_Geo_Dma()
    {
        $this->Plugins_DeliveryLimitations_ArrayData();
        $this->nameEnglish = 'GEO - Designated Market Area';
    }

    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    function isAllowed()
    {
        return ((isset($GLOBALS['_MAX']['GEO_DATA']['dma_code']))
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
