<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Graph - PEAR PHP OO Graph Rendering Utility.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 2.1 of the License, or (at your
 * option) any later version. This library is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details. You should have received a copy of
 * the GNU Lesser General Public License along with this library; if not, write
 * to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 * 02111-1307 USA
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Plot.php,v 1.20 2006/02/28 22:33:00 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plotarea/Element.php
 */
require_once 'Image/Graph/Plotarea/Element.php';

/**
 * Framework for a chart
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 * @abstract
 */
class Image_Graph_Plot extends Image_Graph_Plotarea_Element
{

    /**
     * The dataset to plot
     * @var Dataset
     * @access private
     */
    var $_dataset;

    /**
     * The marker to plot the data set as
     * @var Marker
     * @access private
     */
    var $_marker = null;

    /**
     * The dataselector to use for data marking
     * @var DataSelector
     * @access private
     */
    var $_dataSelector = null;

    /**
     * The Y axis to associate the plot with
     * @var int
     * @access private
     */
    var $_axisY = IMAGE_GRAPH_AXIS_Y;

    /**
     * The type of the plot if multiple datasets are used
     * @var string
     * @access private
     */
    var $_multiType = 'normal';

    /**
     * The title of the plot, used for legending in case of simple plots
     * @var string
     * @access private
     */
    var $_title = 'plot';

    /**
     * PlotType [Constructor]
     *
     * Valid values for multiType are:
     *
     * 'normal' Plot is normal, multiple datasets are displayes next to one
     * another
     *
     * 'stacked' Datasets are stacked on top of each other
     *
     * 'stacked100pct' Datasets are stacked and displayed as percentages of the
     * total sum
     *
     * I no title is specified a default is used, which is basically the plot
     * type (fx. for a 'Image_Graph_Plot_Smoothed_Area' default title is
     * 'Smoothed Area')
     *
     * @param Image_Graph_Dataset $dataset The data set (value containter) to
     *   plot or an array of datasets
     * @param string $multiType The type of the plot
     * @param string $title The title of the plot (used for legends,
     *   {@link Image_Graph_Legend})
     */
    function Image_Graph_Plot(& $dataset, $multiType = 'normal', $title = '')
    {
        if (!is_a($dataset, 'Image_Graph_Dataset')) {
            if (is_array($dataset)) {
                $keys = array_keys($dataset);
                foreach ($keys as $key) {
                    if (!is_a($dataset[$key], 'Image_Graph_Dataset')) {
                        $this->_error('Invalid dataset passed to ' . get_class($this));
                    }
                }
                unset($keys);
            } else {
                $this->_error('Invalid dataset passed to ' . get_class($this));
            }
        }

        parent::Image_Graph_Common();
        if ($dataset) {
            if (is_array($dataset)) {
                $this->_dataset =& $dataset;
            } else {
                $this->_dataset = array(&$dataset);
            }
        }
        if ($title) {
            $this->_title = $title;
        } else {
            $this->_title = str_replace('_', ' ', substr(get_class($this), 17));
        }

        $multiType = strtolower($multiType);
        if (($multiType == 'normal') ||
            ($multiType == 'stacked') ||
            ($multiType == 'stacked100pct'))
        {
            $this->_multiType = $multiType;
        } else {
            $this->_error(
                'Invalid multitype: ' . $multiType .
                ' expected (normal|stacked|stacked100pct)'
            );
            $this->_multiType = 'normal';
        }
    }

    /**
     * Sets the title of the plot, used for legend
     *
     * @param string $title The title of the plot
     */
    function setTitle($title)
    {
        $this->_title = $title;
    }
    
    /**
     * Parses the URL mapping data in the point and adds it to the parameter array used by
     * Image_Canvas
     * 
     * @param array $point The data point (from the dataset)
     * @param array $canvasData The The for the canvas method
     * @return array The union of the canvas data points and the appropriate points for the dataset
     * @access private 
     */
    function _mergeData($point, $canvasData)
    {       
        if (isset($point['data'])) {
            if (isset($point['data']['url'])) {
                $canvasData['url'] = $point['data']['url'];
            }
            if (isset($point['data']['target'])) {
                $canvasData['target'] = $point['data']['target']; 
            }
            if (isset($point['data']['alt'])) {
                $canvasData['alt'] = $point['data']['alt']; 
            }
            if (isset($point['data']['htmltags'])) {
                $canvasData['htmltags'] = $point['data']['htmltags']; 
            }
        }
        
        return $canvasData;        
    }

    /**
     * Sets the Y axis to plot the data
     *
     * @param int $axisY The Y axis (either IMAGE_GRAPH_AXIS_Y / 'y' or
     * IMAGE_GRAPH_AXIS_Y_SECONDARY / 'ysec' (defaults to IMAGE_GRAPH_AXIS_Y))
     * @access private
     */
    function _setAxisY($axisY)
    {
        if ($axisY == 'y') {
           $this->_axisY = IMAGE_GRAPH_AXIS_Y;
        } elseif ($axisY == 'ysec') {
           $this->_axisY = IMAGE_GRAPH_AXIS_Y_SECONDARY;
        } else {
            $this->_axisY = $axisY;
        }
    }

    /**
     * Sets the marker to 'display' data points on the graph
     *
     * @param Marker $marker The marker
     */
    function &setMarker(& $marker)
    {
        $this->add($marker);
        $this->_marker =& $marker;
        return $marker;
    }

    /**
     * Sets the dataselector to specify which data should be displayed on the
     * plot as markers and which are not
     *
     * @param DataSelector $dataSelector The dataselector
     */
    function setDataSelector(& $dataSelector)
    {
        $this->_dataSelector =& $dataSelector;
    }

    /**
     * Calculate marker point data
     *
     * @param array Point The point to calculate data for
     * @param array NextPoint The next point
     * @param array PrevPoint The previous point
     * @param array Totals The pre-calculated totals, if needed
     * @return array An array containing marker point data
     * @access private
     */
    function _getMarkerData($point, $nextPoint, $prevPoint, & $totals)
    {
        if (is_array($this->_dataset)) {
            if ($this->_multiType == 'stacked') {
                if (!isset($totals['SUM_Y'])) {
                    $totals['SUM_Y'] = array();
                }
                $x = $point['X'];
                if (!isset($totals['SUM_Y'][$x])) {
                    $totals['SUM_Y'][$x] = 0;
                }
            } elseif ($this->_multiType == 'stacked100pct') {
                $x = $point['X'];
                if ($totals['TOTAL_Y'][$x] != 0) {
                    if (!isset($totals['SUM_Y'])) {
                        $totals['SUM_Y'] = array();
                    }
                    if (!isset($totals['SUM_Y'][$x])) {
                        $totals['SUM_Y'][$x] = 0;
                    }
                }
            }

            if (isset($totals['ALL_SUM_Y'])) {
                $point['SUM_Y'] = $totals['ALL_SUM_Y'];
            }

            if (!$prevPoint) {
                $point['AX'] = -5;
                $point['AY'] = 5;
                $point['PPX'] = 0;
                $point['PPY'] = 0;
                $point['NPX'] = $nextPoint['X'];
                $point['NPY'] = $nextPoint['Y'];
            } elseif (!$nextPoint) {
                $point['AX'] = 5;
                $point['AY'] = 5;
                $point['PPX'] = $prevPoint['X'];
                $point['PPY'] = $prevPoint['Y'];
                $point['NPX'] = 0;
                $point['NPY'] = 0;
            } else {
                $point['AX'] = $this->_pointY($prevPoint) - $this->_pointY($nextPoint);
                $point['AY'] = $this->_pointX($nextPoint) - $this->_pointX($prevPoint);
                $point['PPX'] = $prevPoint['X'];
                $point['PPY'] = $prevPoint['Y'];
                $point['NPX'] = $nextPoint['X'];
                $point['NPY'] = $nextPoint['Y'];
            }

            $point['APX'] = $point['X'];
            $point['APY'] = $point['Y'];

            if ((isset($totals['MINIMUM_X'])) && ($totals['MINIMUM_X'] != 0)) {
                $point['PCT_MIN_X'] = 100 * $point['X'] / $totals['MINIMUM_X'];
            }
            if ((isset($totals['MAXIMUM_X'])) && ($totals['MAXIMUM_X'] != 0)) {
                $point['PCT_MAX_X'] = 100 * $point['X'] / $totals['MAXIMUM_X'];
            }

            if ((isset($totals['MINIMUM_Y'])) && ($totals['MINIMUM_Y'] != 0)) {
                $point['PCT_MIN_Y'] = 100 * $point['Y'] / $totals['MINIMUM_Y'];
            }
            if ((isset($totals['MAXIMUM_Y'])) && ($totals['MAXIMUM_Y'] != 0)) {
                $point['PCT_MAX_Y'] = 100 * $point['Y'] / $totals['MAXIMUM_Y'];
            }

            $point['LENGTH'] = sqrt($point['AX'] * $point['AX'] +
                $point['AY'] * $point['AY']);

            if ((isset($point['LENGTH'])) && ($point['LENGTH'] != 0)) {
                $point['ANGLE'] = asin($point['AY'] / $point['LENGTH']);
            }

            if ((isset($point['AX'])) && ($point['AX'] > 0)) {
                $point['ANGLE'] = pi() - $point['ANGLE'];
            }
            
            if ($this->_parent->_horizontal) {                
                $point['MARKER_Y1'] = $this->_pointY($point) -
                    (isset($totals['WIDTH']) ? $totals['WIDTH'] : 0);
    
                $point['MARKER_Y2'] = $this->_pointY($point) +
                    (isset($totals['WIDTH']) ? $totals['WIDTH'] : 0);
    
                $point['COLUMN_WIDTH'] = abs($point['MARKER_Y2'] -
                    $point['MARKER_Y1']) / count($this->_dataset);
    
                $point['MARKER_Y'] = $point['MARKER_Y1'] +
                    ((isset($totals['NUMBER']) ? $totals['NUMBER'] : 0) + 0.5) *
                    $point['COLUMN_WIDTH'];
    
                $point['MARKER_X'] = $this->_pointX($point);
    
                if ($this->_multiType == 'stacked') {
                    $point['MARKER_Y'] =
                        ($point['MARKER_Y1'] + $point['MARKER_Y2']) / 2;
    
                    $P1 = array('Y' => $totals['SUM_Y'][$x]);
                    $P2 = array('Y' => $totals['SUM_Y'][$x] + $point['Y']);
    
                    $point['MARKER_X'] =
                        ($this->_pointX($P1) + $this->_pointX($P2)) / 2;
                } elseif ($this->_multiType == 'stacked100pct') {
                    $x = $point['X'];
                    if ($totals['TOTAL_Y'][$x] != 0) {
                        $point['MARKER_Y'] =
                            ($point['MARKER_Y1'] + $point['MARKER_Y2']) / 2;
    
                        $P1 = array(
                            'Y' => 100 * $totals['SUM_Y'][$x] / $totals['TOTAL_Y'][$x]
                        );
    
                        $P2 = array(
                            'Y' => 100 * ($totals['SUM_Y'][$x] + $point['Y']) / $totals['TOTAL_Y'][$x]
                        );
    
                        $point['MARKER_X'] =
                            ($this->_pointX($P1) + $this->_pointX($P2)) / 2;
                    } else {
                        $point = false;
                    }
                }
            }
            else {
                $point['MARKER_X1'] = $this->_pointX($point) -
                    (isset($totals['WIDTH']) ? $totals['WIDTH'] : 0);
    
                $point['MARKER_X2'] = $this->_pointX($point) +
                    (isset($totals['WIDTH']) ? $totals['WIDTH'] : 0);
    
                $point['COLUMN_WIDTH'] = abs($point['MARKER_X2'] -
                    $point['MARKER_X1']) / count($this->_dataset);
    
                $point['MARKER_X'] = $point['MARKER_X1'] +
                    ((isset($totals['NUMBER']) ? $totals['NUMBER'] : 0) + 0.5) *
                    $point['COLUMN_WIDTH'];
    
                $point['MARKER_Y'] = $this->_pointY($point);
    
                if ($this->_multiType == 'stacked') {
                    $point['MARKER_X'] =
                        ($point['MARKER_X1'] + $point['MARKER_X2']) / 2;
    
                    $P1 = array('Y' => $totals['SUM_Y'][$x]);
                    $P2 = array('Y' => $totals['SUM_Y'][$x] + $point['Y']);
    
                    $point['MARKER_Y'] =
                        ($this->_pointY($P1) + $this->_pointY($P2)) / 2;
                } elseif ($this->_multiType == 'stacked100pct') {
                    $x = $point['X'];
                    if ($totals['TOTAL_Y'][$x] != 0) {
                        $point['MARKER_X'] =
                            ($point['MARKER_X1'] + $point['MARKER_X2']) / 2;
    
                        $P1 = array(
                            'Y' => 100 * $totals['SUM_Y'][$x] / $totals['TOTAL_Y'][$x]
                        );
    
                        $P2 = array(
                            'Y' => 100 * ($totals['SUM_Y'][$x] + $point['Y']) / $totals['TOTAL_Y'][$x]
                        );
    
                        $point['MARKER_Y'] =
                            ($this->_pointY($P1) + $this->_pointY($P2)) / 2;
                    } else {
                        $point = false;
                    }
                }
            }
            return $point;
        }
    }

    /**
     * Draws markers on the canvas
     *
     * @access private
     */
    function _drawMarker()
    {        
        if (($this->_marker) && (is_array($this->_dataset))) {
            $this->_canvas->startGroup(get_class($this) . '_marker');
            
            $totals = $this->_getTotals();
            $totals['WIDTH'] = $this->width() / ($this->_maximumX() + 2) / 2;

            $number = 0;
            $keys = array_keys($this->_dataset);
            foreach ($keys as $key) {
                $dataset =& $this->_dataset[$key];
                $totals['MINIMUM_X'] = $dataset->minimumX();
                $totals['MAXIMUM_X'] = $dataset->maximumX();
                $totals['MINIMUM_Y'] = $dataset->minimumY();
                $totals['MAXIMUM_Y'] = $dataset->maximumY();
                $totals['NUMBER'] = $number ++;
                $dataset->_reset();
                while ($point = $dataset->_next()) {
                    $prevPoint = $dataset->_nearby(-2);
                    $nextPoint = $dataset->_nearby();

                    $x = $point['X'];
                    $y = $point['Y'];
                    if (((!is_object($this->_dataSelector)) ||
                        ($this->_dataSelector->_select($point))) && ($point['Y'] !== null))
                    {

                        $point = $this->_getMarkerData(
                            $point,
                            $nextPoint,
                            $prevPoint,
                            $totals
                        );

                        if (is_array($point)) {
                            $this->_marker->_drawMarker(
                                $point['MARKER_X'],
                                $point['MARKER_Y'],
                                $point
                            );
                        }
                    }
                    if (!isset($totals['SUM_Y'])) {
                        $totals['SUM_Y'] = array();
                    }
                    if (isset($totals['SUM_Y'][$x])) {
                        $totals['SUM_Y'][$x] += $y;
                    } else {
                        $totals['SUM_Y'][$x] = $y;
                    }
                }
            }
            unset($keys);
            $this->_canvas->endGroup();
        }              
    }

    /**
     * Get the minimum X value from the dataset
     *
     * @return double The minimum X value
     * @access private
     */
    function _minimumX()
    {
        if (!is_array($this->_dataset)) {
            return 0;
        }

        $min = false;
        if (is_array($this->_dataset)) {
            $keys = array_keys($this->_dataset);
            foreach ($keys as $key) {
                if ($min === false) {
                    $min = $this->_dataset[$key]->minimumX();
                } else {
                    $min = min($min, $this->_dataset[$key]->minimumX());
                }
            }
            unset($keys);
        }
        return $min;
    }

    /**
     * Get the maximum X value from the dataset
     *
     * @return double The maximum X value
     * @access private
     */
    function _maximumX()
    {
        if (!is_array($this->_dataset)) {
            return 0;
        }

        $max = 0;
        if (is_array($this->_dataset)) {
            $keys = array_keys($this->_dataset);
            foreach ($keys as $key) {
                $max = max($max, $this->_dataset[$key]->maximumX());
            }
            unset($keys);
        }
        return $max;
    }

    /**
     * Get the minimum Y value from the dataset
     *
     * @return double The minimum Y value
     * @access private
     */
    function _minimumY()
    {
        if (!is_array($this->_dataset)) {
            return 0;
        }

        $min = false;
        if (is_array($this->_dataset)) {
            $keys = array_keys($this->_dataset);
            foreach ($keys as $key) {
                if ($this->_multiType == 'normal') {
                    if ($min === false) {
                        $min = $this->_dataset[$key]->minimumY();
                    } else {
                        $min = min($min, $this->_dataset[$key]->minimumY());
                    }
                } else {
                    if ($min === false) {
                        $min = 0;
                    }
                    $dataset =& $this->_dataset[$key];
                    $dataset->_reset();
                    while ($point = $dataset->_next()) {
                        if ($point['Y'] < 0) {
                            $x = $point['X'];
                            if ((!isset($total)) || (!isset($total[$x]))) {
                                $total[$x] = $point['Y'];
                            } else {
                                $total[$x] += $point['Y'];
                            }
                            if (isset($min)) {
                                $min = min($min, $total[$x]);
                            } else {
                                $min = $total[$x];
                            }
                        }
                    }
                }
            }
            unset($keys);
        }
        return $min;
    }

    /**
     * Get the maximum Y value from the dataset
     *
     * @return double The maximum Y value
     * @access private
     */
    function _maximumY()
    {
        if ($this->_multiType == 'stacked100pct') {
            return 100;
        }

        $maxY = 0;
        if (is_array($this->_dataset)) {
            $keys = array_keys($this->_dataset);
            foreach ($keys as $key) {
                $dataset =& $this->_dataset[$key];

                if ($this->_multiType == 'normal') {
                    if (isset($maxY)) {
                        $maxY = max($maxY, $dataset->maximumY());
                    } else {
                        $maxY = $dataset->maximumY();
                    }
                } else {
                    $dataset->_reset();
                    while ($point = $dataset->_next()) {
                        if ($point['Y'] > 0) {
                            $x = $point['X'];
                            if ((!isset($total)) || (!isset($total[$x]))) {
                                $total[$x] = $point['Y'];
                            } else {
                                $total[$x] += $point['Y'];
                            }
                            if (isset($maxY)) {
                                $maxY = max($maxY, $total[$x]);
                            } else {
                                $maxY = $total[$x];
                            }
                        }
                    }
                }
            }
            unset($keys);
        }
        return $maxY;
    }

    /**
     * Get the X pixel position represented by a value
     *
     * @param double $point The value to get the pixel-point for
     * @return double The pixel position along the axis
     * @access private
     */
    function _pointX($point)
    {
        $point['AXIS_Y'] = $this->_axisY;
        return parent::_pointX($point);
    }

    /**
     * Get the Y pixel position represented by a value
     *
     * @param double $point the value to get the pixel-point for
     * @return double The pixel position along the axis
     * @access private
     */
    function _pointY($point)
    {
        $point['AXIS_Y'] = $this->_axisY;
        return parent::_pointY($point);
    }

    /**
     * Update coordinates
     *
     * @access private
     */
    function _updateCoords()
    {
        $this->_setCoords($this->_parent->_plotLeft, $this->_parent->_plotTop, $this->_parent->_plotRight, $this->_parent->_plotBottom);
        parent::_updateCoords();
    }

    /**
     * Get the dataset
     *
     * @return Image_Graph_Dataset The dataset(s)
     */
    function &dataset()
    {
        return $this->_dataset;
    }

    /**
     * Calulate totals
     *
     * @return array An associated array with the totals
     * @access private
     */
    function _getTotals()
    {
        $total = array(
            'MINIMUM_X' => $this->_minimumX(),
            'MAXIMUM_X' => $this->_maximumX(),
            'MINIMUM_Y' => $this->_minimumY(),
            'MAXIMUM_Y' => $this->_maximumY()
        );
        $total['ALL_SUM_Y'] = 0;

        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];

            $dataset->_reset();
            while ($point = $dataset->_next()) {
                $x = $point['X'];
                
                if (is_numeric($point['Y'])) {
                    $total['ALL_SUM_Y'] += $point['Y'];
                    if (isset($total['TOTAL_Y'][$x])) {
                        $total['TOTAL_Y'][$x] += $point['Y'];
                    } else {
                        $total['TOTAL_Y'][$x] = $point['Y'];
                    }
                }
                
                if (is_numeric($point['X'])) {
                    if (isset($total['TOTAL_X'][$x])) {
                        $total['TOTAL_X'][$x] += $point['X'];
                    } else {
                        $total['TOTAL_X'][$x] = $point['X'];
                    }
                }
            }
        }
        unset($keys);
        return $total;
    }

    /**
     * Perform the actual drawing on the legend.
     *
     * @param int $x0 The top-left x-coordinate
     * @param int $y0 The top-left y-coordinate
     * @param int $x1 The bottom-right x-coordinate
     * @param int $y1 The bottom-right y-coordinate
     * @access private
     */
    function _drawLegendSample($x0, $y0, $x1, $y1)
    {
        $this->_canvas->rectangle(array('x0' => $x0, 'y0' => $y0, 'x1' => $x1, 'y1' => $y1));
    }

    /**
     * Draw a sample for use with legend
     *
     * @param array $param The parameters for the legend
     * @access private
     */
    function _legendSample(&$param)
    {
        if (!is_array($this->_dataset)) {
            return false;
        }

        if (is_a($this->_fillStyle, 'Image_Graph_Fill')) {
            $this->_fillStyle->_reset();
        }

        $count = 0;
        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];
            $count++;

            $caption = ($dataset->_name ? $dataset->_name : $this->_title);

            $this->_canvas->setFont($param['font']);
            $width = 20 + $param['width'] + $this->_canvas->textWidth($caption);
            $param['maxwidth'] = max($param['maxwidth'], $width);
            $x2 = $param['x'] + $width;
            $y2 = $param['y'] + $param['height'] + 5;

            if ((($param['align'] & IMAGE_GRAPH_ALIGN_VERTICAL) != 0) && ($y2 > $param['bottom'])) {
                $param['y'] = $param['top'];
                $param['x'] = $x2;
                $y2 = $param['y'] + $param['height'];
            } elseif ((($param['align'] & IMAGE_GRAPH_ALIGN_VERTICAL) == 0) && ($x2 > $param['right'])) {
                $param['x'] = $param['left'];
                $param['y'] = $y2;
                $x2 = $param['x'] + 20 + $param['width'] + $this->_canvas->textWidth($caption);
            }

            $x = $x0 = $param['x'];
            $y = $param['y'];
            $y0 = $param['y'];
            $x1 = $param['x'] + $param['width'];
            $y1 = $param['y'] + $param['height'];

            if (!isset($param['simulate'])) {
                $this->_getFillStyle($key);
                $this->_getLineStyle();
                $this->_drawLegendSample($x0, $y0, $x1, $y1);

                if (($this->_marker) && ($dataset) && ($param['show_marker'])) {
                    $dataset->_reset();
                    $point = $dataset->_next();
                    $prevPoint = $dataset->_nearby(-2);
                    $nextPoint = $dataset->_nearby();

                    $tmp = array();
                    $point = $this->_getMarkerData($point, $nextPoint, $prevPoint, $tmp);
                    if (is_array($point)) {
                        $point['MARKER_X'] = $x+$param['width']/2;
                        $point['MARKER_Y'] = $y;
                        unset ($point['AVERAGE_Y']);
                        $this->_marker->_drawMarker($point['MARKER_X'], $point['MARKER_Y'], $point);
                    }
                }
                $this->write($x + $param['width'] + 10, $y + $param['height'] / 2, $caption, IMAGE_GRAPH_ALIGN_CENTER_Y | IMAGE_GRAPH_ALIGN_LEFT, $param['font']);
            }

            if (($param['align'] & IMAGE_GRAPH_ALIGN_VERTICAL) != 0) {
                $param['y'] = $y2;
            } else {
                $param['x'] = $x2;
            }
        }
        unset($keys);
    }
    
}

?>