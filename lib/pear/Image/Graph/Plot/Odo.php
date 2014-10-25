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
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plot.php
 */
require_once 'Image/Graph/Plot.php';

/**
 * Include file Image/Graph/Tool.php
 */
require_once 'Image/Graph/Tool.php';

/**
 * 2D Odochart.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Maxime Delorme <mdelorme@tennaxia.com>
 * @copyright  Copyright (C) 2005 Maxime Delorme
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Plot_Odo extends Image_Graph_Plot
{
    /**
     * the percent of the radius of the chart that will be use as the width of the range
     * @access private
     * @var int
     */
    var $_radiusPercent = 50;

    /**
     * the minimun value of the chart or the start value
     * @access private
     * @var int
     */
    var $_value_min = 0;

    /**
     * the maximum value of the chart or the end value
     * @access private
     * @var int
     */
    var $_value_max = 100;

    /**
     * the start angle
     * @access private
     * @var int
     */
    var $_deg_offset = 135;

    /**
     * the angle of the chart , the length of the chart
     * 180 min a half circle
     * @access private
     * @var int
     */
    var $_deg_width = 270;

    /**
     * the length of the big ticks
     * the small ones will be half ot it, the values 160% of it
     * 180 min a half circle
     * @access private
     * @var int
     */
    var $_tickLength = 14;

    /**
     * how many small ticks a  big tick appears
     * the small ticks appear every 6°
     * so with the default value of 5, every 30° there is a value and a big tick
     * 180 min a half circle
     * @access private
     * @var int
     */
    var $_axisTicks = 5;
    
    /**
     * Arrow marker
     * @access private
     * @var Image_Graph_Marker
     */
    var $_arrowMarker;
    
    /**
     * Range marker fill style
     * @access private
     * @var Image_Graph_Fill
     */
    var $_rangeFillStyle = null;
    
    /**
     * The width of the arrow
     * @access private
     * @var int
     */
    var $_arrowWidth = 5;    

    /**
     * The length of the arrow
     * @access private
     * @var int
     */
    var $_arrowLength = 80;
    
    /**
     * The radius of the plot
     * @access private
     * @var int
     */
    var $_radius = false;
    
    /**
     * The total Y
     * @access private
     * @var int
     */
    var $_totalY = false;

    /**
     * Center X of odometer "circle"
     * @access private
     * @var int
     */
    var $_centerX = false;

    /**
     * Center y of odometer "circle"
     * @access private
     * @var int
     */
    var $_centerY = false;

    /**
     * Plot_Odo [Constructor]
     *
     * dataset with one data per arrow
     * @param Image_Graph_Dataset $dataset The data set (value containter) to
     *   plot or an array of datasets
     *   {@link Image_Graph_Legend}
     */
    function Image_Graph_Plot_Odo(&$dataset)
    {
        parent::__construct($dataset);
        
        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];
            if (isset($min)) {
                $min = min($dataset->minimumY(), $min);
            }
            else {
                $min = $dataset->minimumY();
            }
            if (isset($max)) {
                $max = max($dataset->maximumY(), $max);
            }
            else {
                $max = $dataset->maximumY();
            }
        }
        $this->_value_min = $min;
        $this->_value_max = $max;
    }

    /**
     * Set the center of the odometer
     * 
     * @param int $centerX The center x point
     * @param int $centerY The center y point
     */
    function setCenter($centerX, $centerY)
    {
        $this->_centerX = $centerX;
        $this->_centerY = $centerY;
    }

    /**
     * Convert a value to the angle position onto the odometer
     *
     * @access private
     * @param int $value the value to convert
     * @return int the angle'position onto the odometer
     */
    function _value2angle($value)
    {
        return $this->_deg_width * (($value - $this->_value_min) / $this->_totalY) + $this->_deg_offset;
    }
    
    /**
     * set some internal var
     *
     * @access private
     */
    function _initialize()
    {
        $v1 = $this->_deg_offset;
        $v2 = $this->_deg_offset + $this->_deg_width;
        
        $dimensions = Image_Graph_Tool::calculateArcDimensionAndCenter($v1, $v2);
        
        $radiusX = ($this->width() / 2) / $dimensions['rx'];
        $radiusY = ($this->height() / 2) / $dimensions['ry'];
        
        $this->_radius = min($radiusX, $radiusY);
        
        if ($this->_marker) {
            $this->_radius = $this->_radius * 0.85;
        } 
        
        //the center of the plot
        if ($this->_centerX === false) {  
            $this->_centerX = (int) (($this->_left + $this->_right) / 2) +
                $this->_radius * ($dimensions['cx'] - 0.5);
        }
        
        if ($this->_centerY === false) {
            $this->_centerY = (int) (($this->_top + $this->_bottom) / 2) +
                $this->_radius * ($dimensions['cy'] - 0.5);
        }
        
        //the max range
        $this->_totalY = abs($this->_value_max - $this->_value_min);
    }

    /**
     * set min and max value of the range
     *
     * @access public
     * @param integer $value_min the minimun value of the chart or the start value
     * @param integer $value_max the maximum value of the chart or the end value
     */
    function setRange($value_min, $value_max)
    {
       $this->_value_min = $value_min;
       $this->_value_max = $value_max;
    }

    /**
     * Set start's angle and amplitude of the chart
     *
     * @access public
     * @param integer $deg_offset the start angle
     * @param integer $deg_width the angle of the chart (the length)
     */
    function setAngles($deg_offset, $deg_width)
    {
       $this->_deg_offset = min(360, abs($deg_offset));
       $this->_deg_width = min(360, abs($deg_width));
    }

    /**
     * set the width of the chart
     *
     * @access public
     * @param string $radius_percent a value between 0 and 100
     */
    function setRadiusWidth($radius_percent)
    {
       $this->_radiusPercent = $radius_percent;
    }
    
    /**
     * set the width and length of the arrow (in percent of the total plot "radius")
     * 
     * @param int length The length in percent
     * @param int width The width in percent  
     */
    function setArrowSize($length, $width)
    {
        $this->_arrowWidth = max(0, min(100, $width));
        $this->_arrowLength = max(0, min(100, $length));
    }

    /**
     * Set the arrow marker
     * @param Image_Graph_Marker $marker The marker to set for arrow marker
     */
    function setArrowMarker(&$marker)
    {
        $this->_arrowMarker =& $marker;
    }
     

    /**
     * Output the plot
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        if (parent::_done() === false) {
            return false;
        }
        $this->_initialize();
        $this->_drawRange();
        $this->_drawAxis();
        $this->_drawArrow();
        $this->_drawMarker();
        return true;
    }

    /**
     * set the length of the ticks
     *
     * @access public
     * @param string $radius_percent a value between 0 and 100
     */
    function setTickLength($radius)
    {
        $this->_tickLength = $radius;
    }

    /**
     * set the length of the ticks
     *
     * @access public
     * @param string $radius_percent a value between 0 and 100
     */
    function setAxisTicks($int)
    {
        $this->_axisTicks = $int;
    }

    /**
     * Draw the outline and the axis
     *
     * @access private
     */
    function _drawAxis()
    {
        //draw outline
        $this->_getLineStyle();
        $this->_canvas->pieslice(
                    array(
                            'x' => $this->_centerX,
                            'y' => $this->_centerY,
                            'rx' => $this->_radius,
                            'ry' => $this->_radius,
                            'v1' => $this->_deg_offset,
                            'v2' => $this->_deg_offset+$this->_deg_width,
                            'srx' => $this->_radius * (1 - $this->_radiusPercent / 100),
                            'sry' => $this->_radius * (1 - $this->_radiusPercent / 100)
                        )
                    );
                    
        //step for every 6°
        $step = (int) ($this->_totalY / $this->_deg_width * 6);
        $value = $this->_value_min;
        $i = 0;
        while ($value <= $this->_value_max) {
            $angle = $this->_value2angle($value);

            $cos = cos(deg2rad($angle));
            $sin = sin(deg2rad($angle));
            $point = array('Y' => $value);
            $point['AX'] = $cos;
            $point['AY'] = $sin;
            $point['LENGTH'] = 1;
            $x = $this->_centerX + $this->_radius * $cos;
            $y = $this->_centerY + $this->_radius * $sin;
            $deltaX = - $cos * $this->_tickLength ;
            $deltaY = - $sin * $this->_tickLength ;
            $this->_getLineStyle();
            if(($i % $this->_axisTicks) == 0){
                $this->_canvas->line(array('x0' => $x, 'y0' => $y, 'x1' => $x + $deltaX, 'y1' => $y + $deltaY));
                if ($this->_arrowMarker) {
                    $this->_arrowMarker->_drawMarker($x + $deltaX * 1.6, $y + $deltaY *1.6, $point);
                }
            } else {
                $this->_canvas->line(array('x0' => $x, 'y0' => $y, 'x1' => $x + $deltaX * 0.5, 'y1' => $y + $deltaY * 0.5));
            }
            $i++;
            $value += $step;
        }

    }

    /**
     * Set the line style of the arrows
     *
     * @param Image_Graph_Line $lineStyle The line style of the Arrow
     * @see Image_Graph_Line
     * @access public
     */
    function setArrowLineStyle($lineStyle)
    {
        $this->_arrowLineStyle = &$lineStyle;
    }

    /**
     * Set the fillstyle of the arrows
     *
     * @param Image_Graph_Fill $fillStyle The fill style of the arrows
     * @see Image_Graph_Fill
     * @access public
     */
    function setArrowFillStyle($fillStyle)
    {
        $this->_arrowFillStyle = &$fillStyle;
    }

    /**
     * Draw the arrows
     *
     * @access private
     */
    function _drawArrow()
    {
        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];
            $dataset->_reset();
            $this->setLineStyle($this->_arrowLineStyle);
            $this->setFillStyle($this->_arrowFillStyle);
            while ($point = $dataset->_next()) {
                $ID = $point['ID'];
                $this->_getFillStyle($ID);
                $this->_getLineStyle($ID);
                $deg = $this->_value2angle($point['Y']);
                list($xr,$yr) = Image_Graph_Tool::rotate($this->_centerX + $this->_arrowLength * $this->_radius / 100, $this->_centerY, $this->_centerX, $this->_centerY, $deg);
                $this->_canvas->addVertex(array('x' => $xr, 'y' => $yr));
                list($xr,$yr) = Image_Graph_Tool::rotate($this->_centerX, $this->_centerY - $this->_arrowWidth * $this->_radius/100, $this->_centerX, $this->_centerY, $deg);
                $this->_canvas->addVertex(array('x' => $xr, 'y' => $yr));
                list($xr,$yr) = Image_Graph_Tool::rotate($this->_centerX - $this->_arrowWidth * $this->_radius / 100, $this->_centerY, $this->_centerX, $this->_centerY, $deg);
                $this->_canvas->addVertex(array('x' => $xr, 'y' => $yr));
                list($xr,$yr) = Image_Graph_Tool::rotate($this->_centerX,$this->_centerY + $this->_arrowWidth * $this->_radius / 100, $this->_centerX, $this->_centerY, $deg);
                $this->_canvas->addVertex(array('x' => $xr, 'y' => $yr));
                $this->_canvas->polygon(array('connect' => true));
            }
        }
    }

    /**
     * Calculate marker point data
     *
     * @param array $point The point to calculate data for
     * @param array $nextPoint The next point
     * @param array $prevPoint The previous point
     * @param array $totals The pre-calculated totals, if needed
     * @return array An array containing marker point data
     * @access private
     */
    function _getMarkerData($point, $nextPoint, $prevPoint, &$totals)
    {
        $point = parent::_getMarkerData($point, $nextPoint, $prevPoint, $totals);
 
        $point['ANGLE'] = $this->_value2angle($point['Y']);

        $point['ANG_X'] = cos(deg2rad($point['ANGLE']));
        $point['ANG_Y'] = sin(deg2rad($point['ANGLE']));

        $point['AX'] = -$point['ANG_X'];
        $point['AY'] = -$point['ANG_Y'];

        $point['LENGTH'] = 2.5; //$radius;

        $point['MARKER_X'] = $totals['CENTER_X'] +
            $totals['ODO_RADIUS']  * $point['ANG_X'];
        $point['MARKER_Y'] = $totals['CENTER_Y'] +
            $totals['ODO_RADIUS'] * $point['ANG_Y'];

        return $point;
    }

    /**
     * Draws markers of the arrows on the canvas
     *
     * @access private
     */
    function _drawMarker()
    {

        if ($this->_marker) {
            $this->_marker->_radius += $this->_radius / 2;
            $totals = $this->_getTotals();

            $totals['CENTER_X'] = $this->_centerX;
            $totals['CENTER_Y'] = $this->_centerY;


            /* $keys = array_keys($this->_dataset);
            foreach ($keys as $key) { */
                $dataset =& $this->_dataset[0];

                $totals['RADIUS0'] = false;
                $totals['ODO_RADIUS'] = 1.1 * $this->_radius * $this->_arrowLength / 100;
                $totals['ALL_SUM_Y'] = $this->_totalY;

                $dataset->_reset();
                while ($point = $dataset->_next()) {
                    if ((!is_object($this->_dataSelector)) ||
                         ($this->_dataSelector->select($point))
                    ) {
                        $point = $this->_getMarkerData(
                            $point,
                            false,
                            false,
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
                }
            /* }
            unset($keys); */
        }
    }

    /**
     * Set range
     *
     * dataset with two data start and end value of the range
     * @param Image_Graph_Dataset $dataset The data set (value containter) to
     *   plot or an array of datasets
     *
     */
    function addRangeMarker($min, $max, $id = false)
    {
        $this->_range[] = 
            array(
                'min' => max($this->_value_min, min($min, $max)), 
                'max' => min($this->_value_max, max($min, $max)), 
                'id' => $id
            );
    }

    /**
     * Set the fillstyle of the ranges
     *
     * @param Image_Graph_Fill $fillStyle The fill style of the range
     * @see Image_Graph_Fill
     * @access public
     */
    function &setRangeMarkerFillStyle(&$rangeMarkerFillStyle)
    {
        $this->_rangeFillStyle = $rangeMarkerFillStyle;
    }

    /**
     * Draw the ranges
     *
     * @access private
     */
    function _drawRange()
    {
        if($this->_range){
            $radius0 = $this->_radius * (1 - $this->_radiusPercent/100);
            foreach ($this->_range as $range) {
                $angle1 = $this->_value2angle($range['min']);
                $angle2 = $this->_value2angle($range['max']);

                if (is_object($this->_rangeFillStyle)) {
                    $this->_canvas->setFill($this->_rangeFillStyle->_getFillStyle($range['id']));
                } elseif ($this->_rangeFillStyle != null) {
                    $this->_canvas->setFill($this->_rangeFillStyle);
                }                
                $this->_getLineStyle();
                $this->_canvas->Pieslice(
                    array(
                        'x' => $this->_centerX,
                        'y' => $this->_centerY,
                        'rx' => $this->_radius,
                        'ry' => $this->_radius,
                        'v1' => $angle1,
                        'v2' => $angle2,
                        'srx' => $radius0,
                        'sry' => $radius0
                    )
                );
            }
        }
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
        $dx = abs($x1 - $x0) / 4;
        $this->_canvas->addVertex(array('x' => $x0 + $dx      , 'y' => $y1));
        $this->_canvas->addVertex(array('x' => ($x0 + $x1) / 2, 'y' => $y0 ));
        $this->_canvas->addVertex(array('x' => $x1 - $dx      , 'y' => $y1));
        $this->_canvas->polygon(array('connect' => true));
    }

    /**
     * Draw a sample for use with legend
     *
     * @param array $param The parameters for the legend
     * @access private
     */
    function _legendSample(&$param)
    {
        if (is_array($this->_dataset)) {

            $this->_canvas->startGroup(get_class($this) . '_' . $this->_title);
            $this->_clip(true);
            
            $totals = $this->_getTotals();
            $totals['CENTER_X'] = (int) (($this->_left + $this->_right) / 2);
            $totals['CENTER_Y'] = (int) (($this->_top + $this->_bottom) / 2);
            $totals['RADIUS'] = min($this->height(), $this->width()) * 0.75 * 0.5;
            $totals['CURRENT_Y'] = 0;

            if (is_a($this->_fillStyle, "Image_Graph_Fill")) {
                $this->_fillStyle->_reset();
            }

            $count = 0;
            $keys = array_keys($this->_dataset);
            foreach ($keys as $key) {
                $dataset =& $this->_dataset[$key];
                $count++;

                $dataset->_reset();
                while ($point = $dataset->_next()) {
                    $caption = $point['X'];

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
                    $y0 = $param['y'] - $param['height'] / 2;
                    $x1 = $param['x'] + $param['width'];
                    $y1 = $param['y'] + $param['height'] / 2;

                    if (!isset($param['simulate'])) {
                        $this->_getFillStyle($point['ID']);
                        $this->_getLineStyle($point['ID']);
                        $this->_drawLegendSample($x0, $y0, $x1, $y1);

                        if (($this->_marker) && ($dataset) && ($param['show_marker'])) {
                            $prevPoint = $dataset->_nearby(-2);
                            $nextPoint = $dataset->_nearby();

                            $p = $this->_getMarkerData($point, $nextPoint, $prevPoint, $totals);
                            if (is_array($point)) {
                                $p['MARKER_X'] = $x+$param['width'] / 2;
                                $p['MARKER_Y'] = $y;
                                unset ($p['AVERAGE_Y']);
                                $this->_marker->_drawMarker($p['MARKER_X'], $p['MARKER_Y'], $p);
                            }
                        }
                        $this->write($x + $param['width'] + 10, $y, $caption, IMAGE_GRAPH_ALIGN_CENTER_Y | IMAGE_GRAPH_ALIGN_LEFT, $param['font']);
                    }

                    if (($param['align'] & IMAGE_GRAPH_ALIGN_VERTICAL) != 0) {
                        $param['y'] = $y2;
                    } else {
                        $param['x'] = $x2;
                    }
                }
            }
            unset($keys);
            $this->_clip(false);
            $this->_canvas->endGroup();
        }
    }
}
?>
