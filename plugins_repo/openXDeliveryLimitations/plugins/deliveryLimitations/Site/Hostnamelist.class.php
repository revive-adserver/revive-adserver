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

use RV\Parser\DomainParser;

require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitations.php';
require_once RV_PATH . '/lib/max/Plugin/Translation.php';

/**
 * A Site delivery rule plugin, for filtering delivery of ads on the basis of a
 * whitelist/blacklist of the hostname of the website the ad is on.
 *
 * Valid comparison operators:
 * =x, !x
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_Site_Hostnamelist extends Plugins_DeliveryLimitations
{
    public $defaultComparison = '=~';

    /**
     * Override the parent contstructor to:
     *  - Set the comparison operators (which are bespoke to this plugin); and
     *  - Set the name of the delivery rule for use in the UI.
     */
    public function __construct()
    {
        $this->aOperations = [
            '=~' => MAX_Plugin_Translation::translate('Whitelist - Only deliver on these hostnames', $this->extension, $this->group),
            '!~' => MAX_Plugin_Translation::translate('Blacklist - Do not deliver on these hostnames', $this->extension, $this->group),
        ];
        $this->nameEnglish = 'Site - Hostname List';
    }

    /**
     * Override the parent method to display the UI for the delivery rule.
     */
    public function displayData()
    {
        $this->_displayMainUI();
    }

    /**
     * A private method for displaying the UI for the delivery rule when
     * the PHP intl extension is loaded, and the delivery rule is able to
     * be used.
     */
    public function _displayMainUI()
    {
        global $tabindex;
        // require_once is used here so that the JavaScript that updates lists
        // is only included once in the HTML, no matter times the plugin is
        // used for a single banner
        require_once RV_PATH . '/www/admin/plugins/Site/lib/updateList.php';
        echo "<div style=\"float: left;\">" .
            "<textarea rows='40' cols='70' name='acl[{$this->executionorder}][data]' tabindex='" . ($tabindex++) . "'>" .
            htmlspecialchars($this->data ?? "") .
            "</textarea>" .
            "</div>" .
            "<div style=\"margin-left: 15px; float: left;\">" .
            "<p>" . $this->translate('Enter hostnames below to remove matching entries from the list') . "</p>" .
            "<textarea rows='10' cols='50' name='removelist[{$this->executionorder}][data]' tabindex='" . ($tabindex++) . "'></textarea>" .
            "<br /><br />" .
            "<input id='removeDomains' type='button' value='" . $this->translate('Remove Hostnames') . "' onclick='deliveryRules_Site_UpdateList(\"acl[{$this->executionorder}][data]\", \"removelist[{$this->executionorder}][data]\", \"removeMessage{$this->executionorder}\");' />" .
            "<br /><br />" .
            "<div id='removeMessage{$this->executionorder}'></div>" .
            "</div>";
    }

    /**
     * Override the parent _preCompile() method for how the data as displayed
     * in the UI should be transformed for use in compiled delivery rule
     * evaluation. Specifically:
     *
     * - Convert hostnames into puny-code format;
     * - Create a lookup array, where existence of hostnames can be determined
     *   by the hostname as a key; and
     * - Flattens the lookup array into a string.
     *
     * @param string $sData The input data string.
     * @return string The transformed string.
     */
    public function _preCompile($sData)
    {
        $aData = explode("\n", $this->_sanitiseData($sData));
        $aData = array_map('idn_to_ascii', $aData);

        $aCompiledData = [];
        foreach ($aData as $hostname) {
            $aCompiledData[$hostname] = true;
        }

        return serialize($aCompiledData);
    }

    /**
     * Override the parent compile() method, because the parent doesn't
     * correctly call the _preCompile() method.
     *
     * @return string The delivery limitation in compiled form.
     */
    public function compile()
    {
        return $this->compileData($this->_preCompile($this->data));
    }

    /**
     * Override the parent getData() method, to call the _sanitiseData() method
     * on the provided data before returning it.
     *
     * @return string A "\n" separated string of sanitised hostnames.
     */
    public function getData()
    {
        return $this->_sanitiseData($this->data);
    }

    /**
     * A local private method to sanitise the registerable domain data.
     *
     *  What it does:
     *  - Parses the list of URLs / hostnames;
     *  - Filters out invalid hostnames;
     *  - Deduplicates and sorts the list.
     *
     * @param string $data A "\n" separated string of input hostnames
     *                      and/or URLs.
     * @return string A "\n" separated string of hostnames.
     */
    public function _sanitiseData($data)
    {
        /** @var DomainParser $oParser */
        $oParser = RV_getContainer()->get('domain.parser');

        $aData = [];
        foreach (explode("\n", $data) as $domain) {
            $aData[] = $oParser->getHostname('http://' . trim($domain));
        }

        $aData = array_unique(array_filter($aData));

        return implode("\n", $aData);
    }
}
