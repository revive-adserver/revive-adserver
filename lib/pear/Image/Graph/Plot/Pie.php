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
 * @version    CVS: $Id: Pie.php,v 1.19 2005/11/27 22:21:16 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plot.php
 */
require_once 'Image/Graph/Plot.php';

/**
 * 2D Piechart.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Plot_Pie extends Image_Graph_Plot
{

    /**
     * The radius of the 'pie' spacing
     * @access private
     * @var int
     */
    var $_radius = 3;

    /**
     * Explode pie slices.
     * @access private
     * @var mixed
     */
    var $_explode = false;

    /**
     * The starting angle of the plot
     * @access private
     * @var int
     */
    var $_startingAngle = 0;

    /**
     * The angle direction (1 = CCW, -1 = CW)
     * @access private
     * @var int
     */
    var $_angleDirection = 1;

    /**
     * The diameter of the pie plot
     * @access private
     * @var int
     */
    var $_diameter = false;
    
    /**
     * Group items below this limit together as "the rest"
     * @access private
     * @var double
     */
    var $_restGroupLimit = false;

    /**
     * Rest group title
     * @access private
     * @var string
     */
    var $_restGroupTitle = 'The rest';

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
        $y = ($y0 + $y1) / 2;
        $this->_canvas->pieslice(
        	array(
        		'x' => $x1, 
        		'y' => $y, 
        		'rx' => abs($x1 - $x0) / 2, 
        		'ry' => abs($y1 - $y0) / 2, 
        		'v1' => 45, 
        		'v2' => 315
        	)
    	);
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

        $y = $totals['CURRENT_Y'];
        
        if ($this->_angleDirection < 0) {
            $y = $totals['ALL_SUM_Y'] - $y;
        }

        $point['ANGLE'] = 360 * (($y + ($point['Y'] / 2)) / $totals['ALL_SUM_Y']) + $this->_startingAngle;
        $totals['CURRENT_Y'] += $point['Y'];

        $point['ANG_X'] = cos(deg2rad($point['ANGLE']));
        $point['ANG_Y'] = sin(deg2rad($point['ANGLE']));

        $point['AX'] = -10 * $point['ANG_X'];
        $point['AY'] = -10 * $point['ANG_Y'];

        if ((isset($totals['ALL_SUM_Y'])) && ($totals['ALL_SUM_Y'] != 0)) {
            $point['PCT_MIN_Y'] = $point['PCT_MAX_Y'] = (100 * $point['Y'] / $totals['ALL_SUM_Y']);
        }

        $point['LENGTH'] = 10; //$radius;

        $x = $point['X'];
        $explodeRadius = 0;
        if ((is_array($this->_explode)) && (isset($this->_explode[$x]))) {
            $explodeRadius = $this->_explode[$x];
        } elseif (is_numeric($this->_explode)) {
            $explodeRadius = $this->_explode;
        }

        $point['MARKER_X'] = $totals['CENTER_X'] +
            ($totals['RADIUS'] + $explodeRadius) * $point['ANG_X'];
        $point['MARKER_Y'] = $totals['CENTER_Y'] +
            ($totals['RADIUS'] + $explodeRadius) * $point['ANG_Y'];

        return $point;
    }

    /**
     * Draws markers on the canvas
     *
     * @access private
     */
    function _drawMarker()
    {

        if ($this->_marker) {
            $totals = $this->_getTotals();

            $totals['CENTER_X'] = (int) (($this->_left + $this->_right) / 2);
            $totals['CENTER_Y'] = (int) (($this->_top + $this->_bottom) / 2);

            $totals['CURRENT_Y'] = 0;
            $number = 0;
            
            $diameter = $this->_getDiameter();
            
            $keys = array_keys($this->_dataset);
            foreach ($keys as $key) {
                $dataset =& $this->_dataset[$key];

                if (count($this->_dataset) == 1) {
                    $totals['RADIUS0'] = false;
                    $totals['RADIUS'] = $diameter / 2;
                } else {
                    $dr = $diameter / (2 * count($this->_dataset));

                    $totals['RADIUS0'] = $number * $dr + ($number > 0 ? $this->_radius : 0);
                    $totals['RADIUS'] = ($number + 1) * $dr;
                }

                $totals['ALL_SUM_Y'] = 0;
                $totals['CURRENT_Y'] = 0;
                $dataset->_reset();
                while ($point = $dataset->_next()) {
                    $totals['ALL_SUM_Y'] += $point['Y'];
                }

                $dataset->_reset();
                $currentY = 0;
                $the_rest = 0;
                while ($point = $dataset->_next()) {
                    if (($this->_restGroupLimit !== false) && ($point['Y'] <= $this->_restGroupLimit)) {
                        $the_rest += $point['Y'];
                    }
                    else {
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
                }
                if ($the_rest > 0) {
                    $point = array('X' => $this->_restGroupTitle, 'Y' => $the_rest);                   
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
                $number++;
            }
            unset($keys);
        }
    }

    /**
     * Explodes a piece of this pie chart
     *
     * @param int $explode Radius to explode with (or an array)
     * @param string $x The 'x' value to explode or omitted
     */
    function explode($explode, $x = false)
    {
        if ($x === false) {
            $this->_explode = $explode;
        } else {
            $this->_explode[$x] = $explode;
        }
    }
    
    /**
     * Set the starting angle of the plot
     * 
     * East is 0 degrees
     * South is 90 degrees
     * West is 180 degrees
     * North is 270 degrees
     * 
     * It is also possible to specify the direction of the plot angles (i.e. clockwise 'cw' or 
     * counterclockwise 'ccw')
     */
    function setStartingAngle($angle = 0, $direction = 'ccw') 
    {
        $this->_startingAngle = ($angle % 360);
        $this->_angleDirection = ($direction == 'ccw' ? 1 : -1);
    }
    
    /**
     * Set the diameter of the pie plot (i.e. the number of pixels the
     * pie plot should be across)
     * 
     * Use 'max' for the maximum possible diameter
     * 
     * Use negative values for the maximum possible - minus this value (fx -2
     * to leave 1 pixel at each side)
     * 
     * @param mixed @diameter The number of pixels
     */
    function setDiameter($diameter)
    {
        $this->_diameter = $diameter;
    }
    
    /**
     * Set the limit for the y-value, where values below are grouped together
     * as "the rest"
     * 
     * @param double $limit The limit
     * @param string $title The title to display in the legends (default 'The
     * rest')
     */
    function setRestGroup($limit, $title = 'The rest')
    {
        $this->_restGroupLimit = $limit;
        $this->_restGroupTitle = $title;
    }    
    
    /**
     * Get the diameter of the plot
     * @return int The number of pixels the diameter is
     * @access private
     */
    function _getDiameter()
    {
        $diameter = 0;
        if ($this->_diameter === false) {
            $diameter = min($this->height(), $this->width()) * 0.75;
        }
        else {
            if ($this->_diameter === 'max') {
                $diameter = min($this->height(), $this->width());
            }
            elseif ($this->_diameter < 0) {
                $diameter = min($this->height(), $this->width()) + $this->_diameter;
            } else {
                $diameter = $this->_diameter;
            }
        }
        return $diameter;
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

        $number = 0;

        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];

            $totalY = 0;
            $dataset->_reset();
            while ($point = $dataset->_next()) {
                $totalY += $point['Y'];
            }

            $centerX = (int) (($this->_left + $this->_right) / 2);
            $centerY = (int) (($this->_top + $this->_bottom) / 2);
            $diameter = $this->_getDiameter();
            if ($this->_angleDirection < 0) {
                $currentY = $totalY;
            } else {                
                $currentY = 0; //rand(0, 100)*$totalY/100;
            }            
            $dataset->_reset();

            if (count($this->_dataset) == 1) {
                $radius0 = false;
                $radius1 = $diameter / 2;
            } else {
                $dr = $diameter / (2 * count($this->_dataset));

                $radius0 = $number * $dr + ($number > 0 ? $this->_radius : 0);
                $radius1 = ($number + 1) * $dr;
            }

            $the_rest = 0;
            while ($point = $dataset->_next()) {
                if (($this->_restGroupLimit !== false) && ($point['Y'] <= $this->_restGroupLimit)) {
                    $the_rest += $point['Y'];
                }
                else {
                    $angle1 = 360 * ($currentY / $totalY) + $this->_startingAngle;
                    $currentY += $this->_angleDirection * $point['Y'];
                    $angle2 = 360 * ($currentY / $totalY) + $this->_startingAngle;
    
                    $x = $point['X'];
                    $id = $point['ID'];
    
                    $dX = 0;
                    $dY = 0;
                    $explodeRadius = 0;
                    if ((is_array($this->_explode)) && (isset($this->_explode[$x]))) {
                        $explodeRadius = $this->_explode[$x];
                    } elseif (is_numeric($this->_explode)) {
                        $explodeRadius = $this->_explode;
                    }
    
                    if ($explodeRadius > 0) {
                        $dX = $explodeRadius * cos(deg2rad(($angle1 + $angle2) / 2));
                        $dY = $explodeRadius * sin(deg2rad(($angle1 + $angle2) / 2));
                    }
    
                    $ID = $point['ID'];
                    $this->_getFillStyle($ID);
                    $this->_getLineStyle($ID);
                    $this->_canvas->pieslice(
                        $this->_mergeData(
                            $point,
                        	array(
                        		'x' => $centerX + $dX, 
                        		'y' => $centerY + $dY, 
                        		'rx' => $radius1, 
                        		'ry' => $radius1, 
                        		'v1' => $angle1, 
                        		'v2' => $angle2, 
                        		'srx' => $radius0, 
                        		'sry' => $radius0
                        	)
                        )
                    );
                }
            }
            
            if ($the_rest > 0) {
                $angle1 = 360 * ($currentY / $totalY) + $this->_startingAngle;
                $currentY += $this->_angleDirection * $the_rest;
                $angle2 = 360 * ($currentY / $totalY) + $this->_startingAngle;

                $x = 'rest';
                $id = 'rest';

                $dX = 0;
                $dY = 0;
                $explodeRadius = 0;
                if ((is_array($this->_explode)) && (isset($this->_explode[$x]))) {
                    $explodeRadius = $this->_explode[$x];
                } elseif (is_numeric($this->_explode)) {
                    $explodeRadius = $this->_explode;
                }

                if ($explodeRadius > 0) {
                    $dX = $explodeRadius * cos(deg2rad(($angle1 + $angle2) / 2));
                    $dY = $explodeRadius * sin(deg2rad(($angle1 + $angle2) / 2));
                }

                $ID = $id;
                $this->_getFillStyle($ID);
                $this->_getLineStyle($ID);
                $this->_canvas->pieslice(
                    $this->_mergeData(
                        $point,
                        array(
                            'x' => $centerX + $dX, 
                            'y' => $centerY + $dY, 
                            'rx' => $radius1, 
                            'ry' => $radius1, 
                            'v1' => $angle1, 
                            'v2' => $angle2, 
                            'srx' => $radius0, 
                            'sry' => $radius0
                        )
                    )
                );
            }
            $number++;
        }
        unset($keys);
        $this->_drawMarker();
        return true;
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
                $the_rest = 0;
                while ($point = $dataset->_next()) {
                    $caption = $point['X'];
                    if (($this->_restGroupLimit !== false) && ($point['Y'] <= $this->_restGroupLimit)) {
                        $the_rest += $point['Y'];
                    }
                    else {    
                        $this->_canvas->setFont($param['font']);
                        $width = 20 + $param['width'] + $this->_canvas->textWidth($caption);
                        $param['maxwidth'] = max($param['maxwidth'], $width);
                        $x2 = $param['x'] + $width;
                        $y2 = $param['y'] + $param['height']+5;
                            
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
                        $y0 = $param['y'] - $param['height']/2;
                        $x1 = $param['x'] + $param['width'];
                        $y1 = $param['y'] + $param['height']/2;
        
                        if (!isset($param['simulate'])) {
                            $this->_getFillStyle($point['ID']);
                            $this->_getLineStyle($point['ID']);
                            $this->_drawLegendSample($x0, $y0, $x1, $y1);
        
                            if (($this->_marker) && ($dataset) && ($param['show_marker'])) {
                                $prevPoint = $dataset->_nearby(-2);
                                $nextPoint = $dataset->_nearby();
        
                                $p = $this->_getMarkerData($point, $nextPoint, $prevPoint, $totals);
                                if (is_array($point)) {
                                    $p['MARKER_X'] = $x+$param['width']/2;
                                    $p['MARKER_Y'] = $y;
                                    unset ($p['AVERAGE_Y']);
                                    $this->_marker->_drawMarker($p['MARKER_X'], $p['MARKER_Y'], $p);
                                }
                            }
                            $this->write($x + $param['width'] +10, $y, $caption, IMAGE_GRAPH_ALIGN_CENTER_Y | IMAGE_GRAPH_ALIGN_LEFT, $param['font']);
                        }
        
                        if (($param['align'] & IMAGE_GRAPH_ALIGN_VERTICAL) != 0) {
                            $param['y'] = $y2;
                        } else {
                            $param['x'] = $x2;
                        }                        
                    }
                }
                if ($the_rest > 0) {
                    $this->_canvas->setFont($param['font']);
                    $width = 20 + $param['width'] + $this->_canvas->textWidth($this->_restGroupTitle);
                    $param['maxwidth'] = max($param['maxwidth'], $width);
                    $x2 = $param['x'] + $width;
                    $y2 = $param['y'] + $param['height']+5;
                        
                    if ((($param['align'] & IMAGE_GRAPH_ALIGN_VERTICAL) != 0) && ($y2 > $param['bottom'])) {
                        $param['y'] = $param['top'];
                        $param['x'] = $x2;
                        $y2 = $param['y'] + $param['height'];
                    } elseif ((($param['align'] & IMAGE_GRAPH_ALIGN_VERTICAL) == 0) && ($x2 > $param['right'])) {
                        $param['x'] = $param['left'];
                        $param['y'] = $y2;
                        $x2 = $param['x'] + 20 + $param['width'] + $this->_canvas->textWidth($this->_restGroupTitle);
                    }
    
                    $x = $x0 = $param['x'];
                    $y = $param['y'];
                    $y0 = $param['y'] - $param['height']/2;
                    $x1 = $param['x'] + $param['width'];
                    $y1 = $param['y'] + $param['height']/2;
    
                    if (!isset($param['simulate'])) {
                        $this->_getFillStyle('rest');
                        $this->_getLineStyle('rest');
                        $this->_drawLegendSample($x0, $y0, $x1, $y1);
    
                        $this->write($x + $param['width'] + 10, $y, $this->_restGroupTitle, IMAGE_GRAPH_ALIGN_CENTER_Y | IMAGE_GRAPH_ALIGN_LEFT, $param['font']);
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