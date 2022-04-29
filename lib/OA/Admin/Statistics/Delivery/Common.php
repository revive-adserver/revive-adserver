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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/Flexy.php';
require_once 'Image/Graph.php';

/**
 * A common class that defines a common "interface" and common methods for
 * classes that display delivery statistics.
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 */
class OA_Admin_Statistics_Delivery_Common extends OA_Admin_Statistics_Delivery_Flexy
{
    /**
     * @var mixed
     */
    public $welcomeText;

    /**
     * An array of the preference names, indexed by column name, that correspond
     * with the user preferences to enable/disable delivery statistics columns.
     *
     * @var array
     */
    public $aPrefNames;

    /**
     * A PHP5-style constructor that can be used to perform common
     * class instantiation by children classes.
     *
     * @param array $aParams An array of parameters. The array should
     *                       be indexed by the name of object variables,
     *                       with the values that those variables should
     *                       be set to. For example, the parameter:
     *                       $aParams = array('foo' => 'bar')
     *                       would result in $this->foo = bar.
     */
    public function __construct($aParams)
    {
        // Set the template directory for delivery statistcs
        $this->templateDir = MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/themes/';
        $this->aPrefNames = [];
        parent::__construct($aParams);
        // Delivery statistics columns can be enabled/disabled and re-ordered
        // via user preferences - set the preference column, and sort accordingly
        foreach ($this->aPlugins as $oPlugin) {
            $this->aPrefNames += $oPlugin->getPreferenceNames();
        }
        uksort($this->aColumns, [$this, '_columnSort']);
    }

    /**
     * A private method that can be inherited and used by children classes to
     * load the required plugins during instantiation.
     *
     * @access private
     */
    public function _loadPlugins()
    {
        require_once MAX_PATH . '/lib/OA/Admin/Statistics/Fields/Delivery/Default.php';
        $aPlugins['default'] = new OA_StatisticsFieldsDelivery_Default();
        require_once MAX_PATH . '/lib/OA/Admin/Statistics/Fields/Delivery/Affiliates.php';
        $aPlugins['affiliates'] = new OA_StatisticsFieldsDelivery_Affiliates();
        $this->aPlugins = $aPlugins;
    }


    /**
     * Add a plugin in the list of registered stats plugin
     */
    public function addPlugin($pluginName, $plugin)
    {
        $this->aPlugins[$pluginName] = $plugin;
    }
    /**
     * A private callback method to sort the delivery statistics columns by
     * the user configured preference values.
     *
     * @access private
     */
    public function _columnSort($a, $b)
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];
        $a = isset($this->aPrefNames[$a]) && isset($pref[$this->aPrefNames[$a] . '_rank']) ? $pref[$this->aPrefNames[$a] . '_rank'] : 100;
        $b = isset($this->aPrefNames[$b]) && isset($pref[$this->aPrefNames[$b] . '_rank']) ? $pref[$this->aPrefNames[$b] . '_rank'] : 100;
        return $a - $b;
    }

    /**
     * A private method that extends the parent
     * {@link OA_Admin_Statistics_Common::_summariseTotals{}} method to
     * also ...
     *
     * @access private
     * @param array   $aRows   An array of statistics to summarise.
     */
    public function _summariseTotals(&$aRows)
    {
        parent::_summariseTotals($aRows);
        // Custom
        foreach ($aRows as $row) {
            // Add conversion totals
            $aConversionTypes = [
                MAX_CONNECTION_AD_IMPRESSION,
                MAX_CONNECTION_AD_CLICK,
                MAX_CONNECTION_AD_ARRIVAL,
                MAX_CONNECTION_MANUAL
            ];
            foreach ($aConversionTypes as $conversionType) {
                if (isset($aRows['sum_conversions_' . $conversionType])) {
                    $this->aTotal['sum_conversions_' . $conversionType] += $row['sum_conversions_' . $conversionType];
                }
            }
        }
        // Calculate CTR and other columns
        $this->_summarizeStats($this->aTotal);
    }

    /**
     * Create the error string to display when delivery statistics are not available.
     *
     * @return string The error string to display.
     */
    public function showNoStatsString()
    {
        if (!empty($this->aDates['day_begin']) && !empty($this->aDates['day_end'])) {
            $startDate = new Date($this->aDates['day_begin']);
            $startDate = $startDate->format($GLOBALS['date_format']);
            $endDate = new Date($this->aDates['day_end']);
            $endDate = $endDate->format($GLOBALS['date_format']);
            return sprintf($GLOBALS['strNoStatsForPeriod'], $startDate, $endDate);
        }
        return $GLOBALS['strNoStats'];
    }

    /**
     * A private method that can be inherited and used by children classes to
     * calculate the CTR and SR ratios of the impressions, clicks and conversions
     * that are to be displayed.
     *
     * @access private
     * @param array Row of stats
     */
    public function _summarizeStats(&$row)
    {
        if (isset($row['children'])) {
            $row['num_children'] = count($row['children']);
        }
        foreach ($this->aPlugins as $oPlugin) {
            $oPlugin->summarizeStats($row);
        }
    }

    /**
     * Show the welcome text to advertisers
     *
     */
    public function showAdvertiserWelcome()
    {
        $pref = $GLOBALS['_MAX']['PREF'];

        // Show welcome message
        if ($pref['client_welcome'] == 't' && !empty($pref['client_welcome_msg'])) {
            $this->welcomeText = $pref['client_welcome_msg'];
        }
    }

    /**
    * Exports stats data to an array
    *
    * The array will look like:
    *
    * Array (
    *     'headers' => Array ( 0 => 'Col1', 1 => 'Col2', ... )
    *     'formats' => Array ( 0 => 'text', 1 => 'default', ... )
    *     'data'    => Array (
    *         0 => Array ( 0 => 'Entity 1', 1 => '5', ...),
    *         ...
    *     )
    * )
    *
    * @param array Stats array
    */
    public function exportArray()
    {
        $headers = [];
        $formats = [];
        $data = [];

        $tmp_formats = [];
        foreach ($this->aPlugins as $oPlugin) {
            $tmp_formats += $oPlugin->getFormats();
        }

        foreach ($this->aColumns as $ck => $cv) {
            if ($this->showColumn($ck)) {
                $headers[] = $cv;
                $formats[] = $tmp_formats[$ck];
            }
        }

        return [
            'headers' => $headers,
            'formats' => $formats,
            'data' => $data
        ];
    }
}
