<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/Flexy.php';
require_once 'Image/Graph.php';

/**
 * A common class that defines a common "interface" and common methods for
 * classes that display delivery statistics.
 *
 * @package    OpenadsAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Admin_Statistics_Delivery_Common extends OA_Admin_Statistics_Delivery_Flexy
{

    /**
     * An array of the preference names, indexed by column name, that correspond
     * with the user preferences to enable/disable delivery statistics columns.
     *
     * @var unknown_type
     */
    var $aPrefNames;

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
    function __construct($aParams)
    {
        // Set the template directory for delivery statistcs
        $this->templateDir = MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/themes/';
        $this->aPrefNames  = array();
        parent::__construct($aParams);
        // Delivery statistics columns can be enabled/disabled and re-ordered
        // via user preferences - set the preference column, and sort accordingly
        foreach ($this->aPlugins as $oPlugin) {
            $this->aPrefNames += $oPlugin->getPreferenceNames();
        }
        uksort($this->aColumns, array($this, '_columnSort'));
    }

    /**
     * PHP4-style constructor
     *
     * @param array $aParams An array of parameters. The array should
     *                       be indexed by the name of object variables,
     *                       with the values that those variables should
     *                       be set to. For example, the parameter:
     *                       $aParams = array('foo' => 'bar')
     *                       would result in $this->foo = bar.
     */
    function OA_Admin_Statistics_Delivery_Common($aParams)
    {
        $this->__construct($aParams);
    }

    /**
     * A method that can be used in both the Flexy template and the
     * output() method to determine if a column should be visible,
     * or not.
     *
     * Overrides the parent method to actually test to see if the
     * columns should be visible or not.
     *
     * @param string $column The column name.
     * @return boolean True if the column is visible, false otherwise.
     */
    function showColumn($column)
    {
        return isset($this->aColumnVisible[$column]) ? $this->aColumnVisible[$column] : true;
    }

    /**
     * A private method that can be inherited and used by children classes to
     * load the required plugins during instantiation.
     *
     * @access private
     */
    function _loadPlugins()
    {
        $aPlugins = &MAX_Plugin::getPlugins('statisticsFieldsDelivery');
        uasort($aPlugins, array($this, '_pluginSort'));
        $this->aPlugins = $aPlugins;
    }

    /**
     * A private callback method to sort the delivery statistics columns by
     * the user configured preference values.
     *
     * @access private
     */
    function _columnSort($a, $b)
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];
        $a = isset($this->aPrefNames[$a]) && isset($pref[$this->aPrefNames[$a].'_rank']) ? $pref[$this->aPrefNames[$a].'_rank'] : 100;
        $b = isset($this->aPrefNames[$b]) && isset($pref[$this->aPrefNames[$b].'_rank']) ? $pref[$this->aPrefNames[$b].'_rank'] : 100;
        return $a - $b;
    }

    /**
     * The final "child" implementation of the parental abstract method,
     * to produce a graph of the data for delivery statistics.
     *
     * @param array $aGraphFilterArray Filter array ...?
     * @return string Complete link ...?
     */
    function showGraph($aGraphFilterArray)
    {
        global $conf, $GraphFile;
        if (!extension_loaded('gd')) {
            // GD isn't enabled in php install
            return 'noGD';
        }
        if (isset($this->aHistoryData)) {
            // Put sum_clicks on right axis only when there are
            $aTempGraph = array_flip($aGraphFilterArray);
            if (isset($aTempGraph['sum_clicks']) && !isset($aTempGraph['sum_ctr'])) {
                $aClickKey = $aTempGraph['sum_clicks'];
            } else {
                $aClickKey = false;
            }
            /**
             * stat display fonfiguration array to determine how the data is visually displayed on the graph
             * field line:  if set to Image_Graph_Plot_Bar, then it will display as a Bar. Otherwise it will be a line (can be dotted, dashed or solid)
             * field params: set the color of the line
             * field axis:  determine whether data is connected with left-hand axis (1) or righthand-axis (2)
             */
            $aFieldStyle = array(
                'sum_requests'            => array(
                    'line'       => 'Image_Graph_Line_Solid',
                    'params'     => array('#33cc00', 'transpartent'),
                    'axis'       => '1',
                ),
                'sum_views'               => array(
                    'line'       => 'Image_Graph_Line_Solid',
                    'params'     => array('#006699', 'transparent'),
                    'axis'       => '1',
                ),
                'sum_clicks'              => array(
                    'line'       => 'Image_Graph_Plot_Bar',
                    'params'     => array('#333333', 'transparent'),
                    'axis'       => '1',
                    'background' => 'white@0.3'
                ),
                'sum_ctr'                 => array(
                    'line'       => 'Image_Graph_Line_Solid',
                    'params'     => array('cadetblue', 'transparent'),
                    'axis'       => '2',
                    'background' => 'white@0.3'
                ),
                'sum_conversions'         => array(
                    'line'       => 'Image_Graph_Line_Solid',
                    'params'     => array('#hh00hh', 'transparent'),
                    'axis'       => '1',
                ),
                'sum_conversions_pending' => array(
                    'line'       => 'Image_Graph_Line_Solid',
                    'params'     => array('#cccccc', 'transparent'),
                    'axis'       => '1',
                ),
                'sum_sr_views'            => array(
                    'line'       => 'Image_Graph_Line_Solid',
                    'params'     => array('#0000cc', 'transparent'),
                    'axis'       => '2',
                    'background' => 'white@0.3'
                ),
                'sum_sr_clicks'           => array(
                    'line'       => 'Image_Graph_Line_Solid',
                    'params'     => array('#cc0000', 'transparent'),
                    'axis'       => '2',
                    'background' => 'white@0.3'
                ),
                'sum_revenue'             => array(
                    'line'       => 'Image_Graph_Line_Solid',
                    'params'     => array('#120024', 'transparent'),
                    'axis'       => '1',
                ),
                'sum_cost'                => array(
                    'line'       => 'Image_Graph_Line_Solid',
                    'params'     => array('#123456', 'transparent'),
                    'axis'       => '1',
                ),
                'sum_bv'                  => array(
                    'line'       => 'Image_Graph_Line_Solid',
                    'params'     => array('#654321', 'transparent'),
                    'axis'       => '1',
                ),
                'sum_revcpc'              => array(
                    'line'       => 'Image_Graph_Line_Solid',
                    'params'     => array('#666666', 'transparent'),
                    'axis'       => '1',
                ),
                'sum_costcpc'             => array(
                    'line'       => 'Image_Graph_Line_Solid',
                    'params'     => array('#343434', 'transparent'),
                    'axis'       => '1'
                )
            );
            if ($aClickKey) {
                $aFieldStyle[$aGraphFilterArray[$aClickKey]]['axis'] = '2';
            }
            if (function_exists("imagejpeg")) {
                $imageFormat = 'jpg';
            }
            if (function_exists("imagepng")) {
                $imageFormat = 'png';
            }
            // Create the graph
            $oCanvas =& Image_Canvas::factory(
                $imageFormat,
                array(
                    'width'  => 800,
                    'height' => 400,
                    'usemap' => true
                )
            );
            $oImagemap = $oCanvas->getImageMap();
            $oGraph =& Image_Graph::factory('graph', $oCanvas);
            if (function_exists('ImageTTFBBox')) {
                // Add a TrueType font
                $Font =& $oGraph->addNew('ttf_font', 'arial.ttf');
                // Set the font size to 11 pixels
                $Font->setSize(8);
                $Font->setColor('#444444');
                $oGraph->setFont($Font);
            }
            $oPlotarea =& $oGraph->addNew('plotarea');
            // Set gradient background
            $Fill =& Image_Graph::factory(
                'gradient',
                array(
                    IMAGE_GRAPH_GRAD_VERTICAL,
                    'lightgrey',
                    'white'
                )
            );
            $oPlotarea->setFillStyle($Fill);
            // Aet grid for graph
            $Grid =& $oPlotarea->addNew(
                'bar_grid',
                null,
                IMAGE_GRAPH_AXIS_Y
            );
            $Grid->setFillColor('gray@0.2');
            // Creat a fake object to be able to add description to second Y Axis
            $Dataset2 =& Image_Graph::factory(
                'random',
                array(0, 0,100)
            );
            $PlotA =& $oPlotarea->addNew(
                'Image_Graph_Plot_Area',
                $Dataset2,
                IMAGE_GRAPH_AXIS_Y_SECONDARY
            );
            $AxisY =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
            $AxisY->forceMinimum(.1);
            $AxisYsecondary =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y_SECONDARY);
            $AxisY->setTitle('Value #', 'vertical');
            if ($aClickKey) {
                $AxisYsecondary->setTitle($this->aColumns[$aGraphFilterArray[$aClickKey]], 'vertical2');
                if (count($aTempGraph) < 3) {
                    $AxisY->setTitle($this->aColumns[$aGraphFilterArray[0]], 'vertical');
                }
            } else {
                $AxisYsecondary->setTitle('Value %', 'vertical2');
            }
            foreach($aGraphFilterArray as $k) {
                $Dataset[$k] =& Image_Graph::factory('dataset');
                foreach ($this->aHistoryData as $key => $record) {
                    // Split the date ($key) into days and year, and place the year on the second line
                    $patterns = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/');
                    $replace = array ('\3-\4--\1\2');
                    $key = preg_replace($patterns, $replace, $key);
                    $key = preg_split('/--/', $key);
                    if ($aFieldStyle[$k]['axis'] == 'X') {
                        $Dataset[$k]->addPoint($key[0]."\n".$key[1], $record[$k], IMAGE_GRAPH_AXIS_X);
                    } else {
                        $Dataset[$k]->addPoint($key[0]."\n".$key[1], $record[$k], IMAGE_GRAPH_AXIS_Y_SECONDARY);
                    }
                    $Dataset[$k]->setName($this->aColumns[$k]);
                }
                if ($aFieldStyle[$k]['axis'] == '1') {
                    if ($aFieldStyle[$k]['line'] == 'Image_Graph_Plot_Bar') {
                        $Plot[$k] =& $oPlotarea->addNew('bar', array(&$Dataset[$k]) );
                        $Plot[$k]->setFillColor($aFieldStyle[$k]['background']);
                        $LineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', $aFieldStyle[$k]['params']);
                        $Plot[$k]->setLineStyle($LineStyle);
                    } else {
                        $Plot[$k] =& $oPlotarea->addNew('smooth_line', array(&$Dataset[$k]) );
                        $Plot[$k]->setFillColor($aFieldStyle[$k]['params'][0]."@0.1");
                        $LineStyle =& Image_Graph::factory($aFieldStyle[$k]['line'], $aFieldStyle[$k]['params']);
                        $Plot[$k]->setLineStyle($LineStyle);
                    }
                } else {
                    $Plot[$k] =& $oPlotarea->addNew('area', array(&$Dataset[$k]), IMAGE_GRAPH_AXIS_Y_SECONDARY);
                    $Plot[$k]->setFillColor($aFieldStyle[$k]['background']);
                    $LineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', $aFieldStyle[$k]['params']);
                    $Plot[$k]->setLineStyle($LineStyle);
                    foreach($Dataset[$k] as $id => $val) {
                        // To determine the max value of the 2nd y axis
                        if (is_numeric($val['Y']) && (!isset($maxY2val) || $val['Y'] > $maxY2val)) {
                            $maxY2val = $val['Y'];
                        }
                    }
                }
            }
            $maxY2val = $maxY2val + 5;
            $AxisYsecondary->forceMaximum($maxY2val);
            $oLegend =& $oPlotarea->addNew('legend');
            $oLegend->setFillColor('white@0.7');
            $oLegend->setFontSize(8);
            $oLegend->showShadow();
            $AxisX =& $oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
            $oGraph->setPadding(10);
            $oGraph->setBackground(Image_Graph::factory('gradient', array(IMAGE_GRAPH_GRAD_VERTICAL_MIRRORED, 'white', '#eeeeee')));
            // Output the Graph
            $tmpGraphFile = 'cache_' . md5( microtime() . rand(1,1000) ) . '.jpg';
            $oGraph->done();
            return($oGraph);
        }

    }


















    /**
     * A private method that can be inherited and used by children classes to
     * calculate the sum of the requests, impressions, clicks and conversions
     * that are to be displayed.
     *
     * @access private
     * @param array Rows of stats
     * @param boolean Calculate average data too
     */
    function _summarizeTotals(&$rows, $average = false)
    {
        foreach ($rows as $row) {
            foreach (array_keys($this->aColumns) as $k) {
                $this->aTotal[$k] += $row[$k];
            }

            // add conversion totals
            $conversion_types = array(
                MAX_CONNECTION_AD_IMPRESSION,
                MAX_CONNECTION_AD_CLICK,
                MAX_CONNECTION_AD_ARRIVAL,
                MAX_CONNECTION_MANUAL
            );
            foreach ($conversion_types as $conversion_type) {
                if (isset($row['sum_conversions_'.$conversion_type])) {
                    $this->aTotal['sum_conversions_'.$conversion_type] += $row['sum_conversions_'.$conversion_type];
                }
            }
        }

        $this->_summarizeStats($this->aTotal);

        if ($average) {
            $this->average = $this->summarizeAverage($this->aTotal, count($rows));
            $this->averageSpan = count($rows);
            $this->showAverage = $this->average !== false;
        }

        $this->noStatsAvailable = !$this->_hasActiveStats($this->aTotal);

        $this->_formatStats($this->aTotal, true);

        foreach (array_keys($rows) as $k) {
            $this->_formatStatsRecursive($rows[$k]);
        }

        $this->showTotals = true;
    }

    /**
     * A private method that can be inherited and used by children classes to
     * calculate if the rows of data to be displayed has an active row to display
     * or not.
     *
     * @access private
     * @param array Rows of stats
     * @return boolean The row is not empty
     */
    function _hasActiveStats($row)
    {
        foreach ($this->aPlugins as $oPlugin) {
            if ($oPlugin->isRowActive($row)) {
                return true;
            }
        }
        return false;
    }

    /**
     * A private method that can be inherited and used by children classes to
     * calculate the CTR and SR ratios of the impressions, clicks and conversions
     * that are to be displayed.
     *
     * @access private
     * @param array Row of stats
     */
    function _summarizeStats(&$row)
    {
        foreach ($this->aPlugins as $oPlugin) {
            $oPlugin->summarizeStats($row);
        }
    }

    /**
     * A private method that can be inherited and used by children classes to
     * format the rows of statistics that are to be displayed, according to the
     * user's preferences.
     *
     * @access private
     * @param array Row of stats
     * @param bool  Is total
     */
    function _formatStats(&$row, $is_total = false)
    {
        if (!$this->skipFormatting) {
            foreach ($this->aPlugins as $oPlugin) {
                $oPlugin->_formatStats($row, $is_total);
            }
        }
    }

    /**
     * Format a row of stats recursively according to the user preferences
     *
     * This function is useful when formatting stats for entities which also
     * have subentities
     *
     * @static
     *
     * @param array Row of stats
     */
    function _formatStatsRecursive(&$row)
    {
        $this->_formatStats($row);
        if (isset($row['subentities']) && is_array($row['subentities'])) {
            foreach (array_keys($row['subentities']) as $key) {
                $this->_formatStatsRecursive($row['subentities'][$key]);
            }
        }
    }

    /**
     * Calculate average requests, impressions, clicks and conversions
     *
     * @static
     *
     * @param array Total stats
     * @param array Number of entries
     * @return mixed Averages array or false on error
     */
    function summarizeAverage($total, $count, $min_count = 2)
    {
        if ($count < $min_count) {
            return false;
        }

        $average = array();
        foreach ($this->aPlugins as $oPlugin) {
            $average += $oPlugin->summarizeAverage($total, $count);
        }

        $this->_summarizeStats($average);
        $this->_formatStats($average, true);

        return $average;
    }

    /**
     * Output the error string when stats are not available
     *
     * @return string Error string
     */
    function showNoStatsString()
    {
        if (!empty($this->aDates['day_begin']) && !empty($this->aDates['day_end'])) {
            $startDate = new Date($this->aDates['day_begin']);
            $startDate = $startDate->format($GLOBALS['date_format']);
            $endDate   = new Date($this->aDates['day_end']);
            $endDate   = $endDate->format($GLOBALS['date_format']);
            return sprintf($GLOBALS['strNoStatsForPeriod'], $startDate, $endDate);
        }

        return $GLOBALS['strNoStats'];
    }

    /**
     * Show the welcome text to publishers
     *
     */
    function showPublisherWelcome()
    {
        $pref = $GLOBALS['_MAX']['PREF'];

        if ($pref['publisher_welcome'] == 't') {
            // Show welcome message
            if (!empty($pref['publisher_welcome_msg'])) {
                $this->welcomeText = $pref['publisher_welcome_msg'];
            }
        }


    }

    /**
     * Show the welcome text to advertisers
     *
     */
    function showAdvertiserWelcome()
    {
        $pref = $GLOBALS['_MAX']['PREF'];

        if ($pref['client_welcome'] == 't') {
            // Show welcome message
            if (!empty($pref['client_welcome_msg'])) {
                $this->welcomeText = $pref['client_welcome_msg'];
            }
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
    function exportArray()
    {
        $headers = array();
        $formats = array();
        $data    = array();

        $tmp_formats = array();
        foreach ($this->aPlugins as $oPlugin) {
            $tmp_formats += $oPlugin->getFormats();
        }

        foreach ($this->aColumns as $ck => $cv) {
            if ($this->showColumn($ck)) {
            $headers[] = $cv;
                $formats[] = $tmp_formats[$ck];
            }
        }

        return array(
            'headers' => $headers,
            'formats' => $formats,
            'data'    => $data
        );
    }

}

?>