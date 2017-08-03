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

require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitations.php';
require_once RV_PATH . '/lib/max/Plugin/Translation.php';

/**
 * A Site delivery rule plugin, for filtering delivery of ads on the basis of a
 * whitelist/blacklist of the domain name of the website the ad is on.
 *
 * Valid comparison operators:
 * =~, !~
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_Site_Domainlist extends Plugins_DeliveryLimitations
{
    var $defaultComparison = '=~';

    /**
     * Override the parent contstructor:
     *  - Set the valid comparison operators (which are bespoke to this plugin);
     *  - Set the column name for storing data; and
     *  - Set the name of the delivery rule for use in the UI.
     */
    function __construct()
    {
        $this->aOperations = array(
            '=~' => MAX_Plugin_Translation::translate('Whitelist - Only deliver on these domains', $oPlugin->module, $oPlugin->package),
            '!~' => MAX_Plugin_Translation::translate('Blacklist - Do not deliver on these domains', $oPlugin->module, $oPlugin->package)
        );

        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($aConf['database']['type'] == 'mysql' || $aConf['database']['type'] == 'mysqli') {
            $this->columnName = 'CONCAT(IF(https=1, \'https://\', \'http://\'), domain, page, IF(query<>\'\', \'?\', \'\'),query)';
        } else {
            $this->columnName = 'IF(https=1, \'https://\', \'http://\') || domain || page || IF(query<>\'\', \'?\', \'\') || query';
        }

        $this->nameEnglish = 'Site - Domain List';
    }
    
    function displayData()
    {
    	global $tabindex;
        require_once RV_PATH . '/www/admin/plugins/Site/lib/updateList.php';
        echo
            "<div style=\"float: left;\">" .
                "<textarea rows='40' cols='70' name='acl[{$this->executionorder}][data]' tabindex='".($tabindex++)."'>" .
                  htmlspecialchars(isset($this->data) ? $this->data : "") .
                "</textarea>" .
            "</div>" .                        
            "<div style=\"margin-left: 15px; float: left;\">" .
              "<p>" . $this->translate('Enter domains below to remove matching entries from the list') . "</p>" .
              "<textarea rows='10' cols='50' name='removelist[{$this->executionorder}][data]' tabindex='".($tabindex++)."'></textarea>" .
              "<br /><br />" .
              "<input id='removeDomains' type='button' value='" . $this->translate('Remove Domains') . "' onclick='updateList(\"acl[{$this->executionorder}][data]\", \"removelist[{$this->executionorder}][data]\", \"removeMessage{$this->executionorder}\");' />" .
              "<br /><br />" .
              "<div id='removeMessage{$this->executionorder}'></div>" .
            "</div>";

    }    

    /**
     * Override the parent getData() method, to call the _sanitiseData() method
     * on the provided data before returning it.
     *
     * @return string A "\n" separated string of sanitised page domains.
     */
    function getData()
    {
        return $this->_sanitiseData($this->data); 
    }
    
    /**
     * A local private method to sanitise the domain data.
     *
     *  For each input line:
     *  - Trims whitespace;
     *  - Converts to lowercase;
     * 
     *  - Trims any forward slashes from the input;
     *  - Ignores any input that is not a strings/has no length;
     *  - Ignores any input that does not contain a "." character;
     *  - Parses the domain out of the input;
     *  - Converts the domain to UTF8 (if PHP intl extension installed);
     *  - Filters the domain to ensure only valid URL characters;
     *  - Removes the "www." prefix from the domain;
     *  - Deduplicates the list of domains; and
     *  - Sorts the domains into ascending order.
     * 
     * @param string $data A "\n" separated string of input page domains.
     * @return string A "\n" separated string of sanitised input.
     */
    function _sanitiseData($data)
    {
        $aData = explode("\n", $data);
        $aSanitisedData = [];
        foreach ($aData as $key => $url) {
            $url = trim($url);
            $url = strtolower($url);


            // TO DO
            if ($this->_validDomainString($url)) {
                $domain = parse_url($url, PHP_URL_HOST);
                if (!$domain && (strpos($url, "http://") === false || strpos($url, "https://") === false)) {
                    $domain = parse_url("http://" . $url, PHP_URL_HOST);
                }
                if ($this->_validDomainString($domain)) {
                    $domain = function_exists('idn_to_utf8') ? idn_to_utf8($domain) : $domain;
                    if ($this->_validDomainString($domain)) {
                        $domain = filter_var($domain, FILTER_SANITIZE_URL);
                        if ($this->_validDomainString($domain) && substr($domain, 0, 4) === "www.") {
                            $domain = substr($domain, 4);
                        }
                        if ($this->_validDomainString($domain)) {
                            array_push($aSanitisedData, $domain);
                        }
                    }
                }
            }
        }
        $aSanitisedData = array_unique($aSanitisedData);
        sort($aSanitisedData);
        return implode($aSanitisedData, "\n");
    }
    
    /**
     * A local private method to detect common reasons that would mean a string
     * can not be a valid domain.
     * 
     * @param string $domain The string to test
     * @return boolean If the string can potentially be a valid domain string
     *                 or not.
     */
    function _validDomainString($domain) {
        if (is_string($domain) && strlen($domain) && strpos($domain, ".") !== false) {
            // The supplied value is a string, is not empty, and has a "." char
            return true;
        }
        return false;
    }
    
    
}

?>