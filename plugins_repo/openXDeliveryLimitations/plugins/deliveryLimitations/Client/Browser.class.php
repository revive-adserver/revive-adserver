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
require_once dirname(__FILE__) . '/lib/phpSniff/phpSniff.class.php';

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
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Chris Nutting <chris.nutting@openx.org>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openx.org>
 */
class Plugins_DeliveryLimitations_Client_Browser extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    function Plugins_DeliveryLimitations_Client_Browser()
    {
        $this->Plugins_DeliveryLimitations_ArrayData();
        $phpSniff = new phpSniff('', false);
        $this->setAValues($phpSniff->_browsers);
        $this->nameEnglish = 'Client - Browser';
    }


    /**
     * Returns true if this plugin is available in the current context,
     * false otherwise.
     *
     * @return boolean
     */
    function isAllowed()
    {
        return !empty($GLOBALS['_MAX']['CONF']['Client']['sniff']);
    }


    function displayArrayData()
    {
        $tabindex =& $GLOBALS['tabindex'];

        $i = 0;

        $browsers = array_flip($this->_aValues);

		echo "<table cellpadding='3' cellspacing='3'>";
		foreach ($browsers as $key => $value) {
			if ($i % 4 == 0) echo "<tr>";
			echo "<td><input type='checkbox' name='acl[{$this->executionorder}][data][]' value='$key'".(in_array($key, $this->data) ? ' checked="checked"' : '')." tabindex='".($tabindex++)."'>".ucfirst($value)."</td>";
			if (($i + 1) % 4 == 0) echo "</tr>";
			$i++;
		}
		if (($i + 1) % 4 != 0) echo "</tr>";
		echo "</table>";
    }

}

?>
