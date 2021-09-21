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
     * @var unknown_type
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
     * The final "child" implementation of the parental abstract method,
     * to produce a graph of the data for delivery statistics.
     *
     * @param array $aGraphFilterArray Filter array ...?
     * @return string Complete link ...?
     */
    public function showGraph($aGraphFilterArray)
    {
        global $conf, $GraphFile;
        if (!extension_loaded('gd')) {
            // GD isn't enabled in php install
            return 'noGD';
        }
        if (isset($this->aStatsData)) {
            // Put sum_clicks on right axis only when there are
            $aTempGraph = array_flip($aGraphFilterArray);
            $aClickKey = isset($aTempGraph['sum_clicks']) && !isset($aTempGraph['sum_ctr']) ? $aTempGraph['sum_clicks'] : false;
            /**
             * stat display fonfiguration array to determine how the data is visually displayed on the graph
             * field line:  if set to Image_Graph_Plot_Bar, then it will display as a Bar. Otherwise it will be a line (can be dotted, dashed or solid)
             * field params: set the color of the line
             * field axis:  determine whether data is connected with left-hand axis (1) or righthand-axis (2)
             */
            $aFieldStyle = [
                'sum_requests' => [
                    'line' => 'Image_Graph_Line_Solid',
                    'params' => ['#33cc00', 'transpartent'],
                    'axis' => '1',
                ],
                'sum_views' => [
                    'line' => 'Image_Graph_Line_Solid',
                    'params' => ['#006699', 'transparent'],
                    'axis' => '1',
                ],
                'sum_clicks' => [
                    'line' => 'Image_Graph_Plot_Bar',
                    'params' => ['#333333', 'transparent'],
                    'axis' => '1',
                    'background' => 'white@0.3'
                ],
                'sum_ctr' => [
                    'line' => 'Image_Graph_Line_Solid',
                    'params' => ['cadetblue', 'transparent'],
                    'axis' => '2',
                    'background' => 'white@0.3'
                ],
                'sum_conversions' => [
                    'line' => 'Image_Graph_Line_Solid',
                    'params' => ['#hh00hh', 'transparent'],
                    'axis' => '1',
                ],
                'sum_conversions_pending' => [
                    'line' => 'Image_Graph_Line_Solid',
                    'params' => ['#cccccc', 'transparent'],
                    'axis' => '1',
                ],
                'sum_sr_views' => [
                    'line' => 'Image_Graph_Line_Solid',
                    'params' => ['#0000cc', 'transparent'],
                    'axis' => '2',
                    'background' => 'white@0.3'
                ],
                'sum_sr_clicks' => [
                    'line' => 'Image_Graph_Line_Solid',
                    'params' => ['#cc0000', 'transparent'],
                    'axis' => '2',
                    'background' => 'white@0.3'
                ],
                'sum_revenue' => [
                    'line' => 'Image_Graph_Line_Solid',
                    'params' => ['#120024', 'transparent'],
                    'axis' => '1',
                ],
                'sum_cost' => [
                    'line' => 'Image_Graph_Line_Solid',
                    'params' => ['#123456', 'transparent'],
                    'axis' => '1',
                ],
                'sum_bv' => [
                    'line' => 'Image_Graph_Line_Solid',
                    'params' => ['#654321', 'transparent'],
                    'axis' => '1',
                ],
                'sum_revcpc' => [
                    'line' => 'Image_Graph_Line_Solid',
                    'params' => ['#666666', 'transparent'],
                    'axis' => '1',
                ],
                'sum_costcpc' => [
                    'line' => 'Image_Graph_Line_Solid',
                    'params' => ['#343434', 'transparent'],
                    'axis' => '1'
                ]
            ];
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
            $oCanvas = Image_Canvas::factory(
                $imageFormat,
                [
                    'width' => 800,
                    'height' => 400,
                    'usemap' => true
                ]
            );
            $oImagemap = $oCanvas->getImageMap();
            $oGraph = Image_Graph::factory('graph', $oCanvas);
            if (function_exists('ImageTTFBBox')) {
                // Add a TrueType font
                $Font = &$oGraph->addNew('ttf_font', 'arial.ttf');
                // Set the font size to 11 pixels
                $Font->setSize(8);
                $Font->setColor('#444444');
                $oGraph->setFont($Font);
            }
            $oPlotarea = $oGraph->addNew('plotarea');
            // Set gradient background
            $Fill = Image_Graph::factory(
                'gradient',
                [
                    IMAGE_GRAPH_GRAD_VERTICAL,
                    'lightgrey',
                    'white'
                ]
            );
            $oPlotarea->setFillStyle($Fill);
            // Aet grid for graph
            $Grid = &$oPlotarea->addNew(
                'bar_grid',
                null,
                IMAGE_GRAPH_AXIS_Y
            );
            $Grid->setFillColor('gray@0.2');
            // Creat a fake object to be able to add description to second Y Axis
            $Dataset2 = &Image_Graph::factory(
                'random',
                [0, 0, 100]
            );
            $PlotA = &$oPlotarea->addNew(
                'Image_Graph_Plot_Area',
                $Dataset2,
                IMAGE_GRAPH_AXIS_Y_SECONDARY
            );
            $PlotA->setTitle($strStatsArea);
            $AxisY = &$oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
            $AxisY->forceMinimum(.1);
            $AxisYsecondary = &$oPlotarea->getAxis(IMAGE_GRAPH_AXIS_Y_SECONDARY);
            $AxisY->setTitle('Value #', 'vertical');
            if ($aClickKey) {
                $AxisYsecondary->setTitle($this->aColumns[$aGraphFilterArray[$aClickKey]], 'vertical2');
                if (count($aTempGraph) < 3) {
                    $AxisY->setTitle($this->aColumns[$aGraphFilterArray[0]], 'vertical');
                }
            } else {
                $AxisYsecondary->setTitle('Value %', 'vertical2');
            }
            foreach ($aGraphFilterArray as $k) {
                $Dataset[$k] = &Image_Graph::factory('dataset');
                foreach ($this->aStatsData as $key => $record) {
                    // Split the date ($key) into days and year, and place the year on the second line
                    $patterns = ['/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/'];
                    $replace = ['\4-\3--\1\2'];
                    $key = preg_replace($patterns, $replace, $key);
                    $key = preg_split('/--/', $key);
                    if ($aFieldStyle[$k]['axis'] == 'X') {
                        $Dataset[$k]->addPoint($key[0] . "\n" . $key[1], $record[$k], IMAGE_GRAPH_AXIS_X);
                    } else {
                        if ($k == 'sum_ctr') {
                            $record[$k] *= 100;
                        }
                        $Dataset[$k]->addPoint($key[0] . "\n" . $key[1], $record[$k], IMAGE_GRAPH_AXIS_Y_SECONDARY);
                    }
                    $Dataset[$k]->setName($this->aColumns[$k]);
                }
                if ($aFieldStyle[$k]['axis'] == '1') {
                    if ($aFieldStyle[$k]['line'] == 'Image_Graph_Plot_Bar') {
                        $Plot[$k] = &$oPlotarea->addNew('bar', [&$Dataset[$k]]);
                        $Plot[$k]->setFillColor($aFieldStyle[$k]['background']);
                        $LineStyle = &Image_Graph::factory('Image_Graph_Line_Solid', $aFieldStyle[$k]['params']);
                        $Plot[$k]->setLineStyle($LineStyle);
                    } else {
                        $Plot[$k] = &$oPlotarea->addNew('smooth_line', [&$Dataset[$k]]);
                        $Plot[$k]->setFillColor($aFieldStyle[$k]['params'][0] . "@0.1");
                        $LineStyle = &Image_Graph::factory($aFieldStyle[$k]['line'], $aFieldStyle[$k]['params']);
                        $Plot[$k]->setLineStyle($LineStyle);
                    }
                } else {
                    $Plot[$k] = &$oPlotarea->addNew('area', [&$Dataset[$k]], IMAGE_GRAPH_AXIS_Y_SECONDARY);
                    $Plot[$k]->setFillColor($aFieldStyle[$k]['background']);
                    $LineStyle = &Image_Graph::factory('Image_Graph_Line_Solid', $aFieldStyle[$k]['params']);
                    $Plot[$k]->setLineStyle($LineStyle);
                    foreach ($Dataset[$k]->_data as $id => $val) {
                        // To determine the max value of the 2nd y axis
                        if (is_numeric($val['Y']) && (!isset($maxY2val) || $val['Y'] > $maxY2val)) {
                            $maxY2val = $val['Y'];
                        }
                    }
                }
            }
            $maxY2val += 5;
            $AxisYsecondary->forceMaximum($maxY2val);
            $oLegend = &$oPlotarea->addNew('legend');
            $oLegend->setFillColor('white@0.7');
            $oLegend->setFontSize(8);
            $oLegend->showShadow();
            $AxisX = &$oPlotarea->getAxis(IMAGE_GRAPH_AXIS_X);
            $oGraph->setPadding(10);
            $oGraph->setBackground(Image_Graph::factory('gradient', [IMAGE_GRAPH_GRAD_VERTICAL_MIRRORED, 'white', '#eeeeee']));
            // Output the Graph
            $tmpGraphFile = 'cache_' . md5(microtime() . rand(1, 1000)) . '.jpg';
            $oGraph->done();
            return($oGraph);
        }
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
