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
 * A bar chart.
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
class Image_Graph_Plot_Bar extends Image_Graph_Plot
{

    /**
     * The space between 2 bars (should be a multipla of 2)
     * @var int
     * @access private
     */
    var $_space = 4;

    /**
     * The width of the bars
     * @var array
     * @access private
     */
    var $_width = 'auto';

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
        $dx = abs($x1 - $x0) / 7;
        $this->_canvas->rectangle(array('x0' => $x0 + $dx, 'y0' => $y0, 'x1' => $x1 - $dx, 'y1' => $y1));
    }

    /**
     * Set the spacing between 2 neighbouring bars
     *
     * @param int $space The number of pixels between 2 bars, should be a
     *   multipla of 2 (ie an even number)
     */
    function setSpacing($space)
    {
        $this->_space = (int) ($space / 2);
    }

    /**
     * Set the width of a bars.
     *
     * Specify 'auto' to auto calculate the width based on the positions on the
     * x-axis.
     *
     * Supported units are:
     *
     * '%' The width is specified in percentage of the total plot width
     *
     * 'px' The width specified in pixels
     *
     * @param string $width The width of any bar
     * @param string $unit The unit of the width
     */
    function setBarWidth($width, $unit = false)
    {
        if ($width == 'auto') {
            $this->_width = $width;
        } else {
            $this->_width = array(
                'width' => $width,
                'unit' => $unit
            );
        }
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

        if (!is_array($this->_dataset)) {
            return false;
        }

        $this->_canvas->startGroup(get_class($this) . '_' . $this->_title);

        $this->_clip(true);        

        if ($this->_width == 'auto') {
            $width = $this->_parent->_labelDistance(IMAGE_GRAPH_AXIS_X) / 2;            
        } elseif ($this->_width['unit'] == '%') {
            $width = $this->_width['width'] * $this->width() / 200;
        } elseif ($this->_width['unit'] == 'px') {
            $width = $this->_width['width'] / 2;
        }
       
        if ($this->_multiType == 'stacked100pct') {
            $total = $this->_getTotals();
        }

        $minYaxis = $this->_parent->_getMinimum($this->_axisY);
        $maxYaxis = $this->_parent->_getMaximum($this->_axisY);

        $number = 0;
        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];
            $dataset->_reset();
            while ($point = $dataset->_next()) {
                
                if ($this->_parent->_horizontal) {
                    $y1 = $this->_pointY($point) - $width;
                    $y2 = $this->_pointY($point) + $width;
                    
                    if ($y2 - $this->_space > $y1 + $this->_space) {
                        /*
                         * Take bar spacing into account _only_ if the space doesn't
                         * turn the bar "inside-out", i.e. if the actual bar width
                         * is smaller than the space between the bars
                         */
                        $y2 -= $this->_space;
                        $y1 += $this->_space;
                    }
                }
                else {               
                    $x1 = $this->_pointX($point) - $width;
                    $x2 = $this->_pointX($point) + $width;
                    
                    if ($x2 - $this->_space > $x1 + $this->_space) {
                        /*
                         * Take bar spacing into account _only_ if the space doesn't
                         * turn the bar "inside-out", i.e. if the actual bar width
                         * is smaller than the space between the bars
                         */
                        $x2 -= $this->_space;
                        $x1 += $this->_space;
                    }
                }                   
                    

                if (($this->_multiType == 'stacked') ||
                    ($this->_multiType == 'stacked100pct'))
                {
                    $x = $point['X'];

                    if ($point['Y'] >= 0) {
                        if (!isset($current[$x])) {
                            $current[$x] = 0;
                        }

                        if ($this->_multiType == 'stacked') {
                            $p0 = array(
                                'X' => $point['X'],
                                'Y' => $current[$x]
                            );
                            $p1 = array(
                                'X' => $point['X'],
                                'Y' => $current[$x] + $point['Y']
                            );
                        } else {
                            $p0 = array(
                                'X' => $point['X'],
                                'Y' => 100 * $current[$x] / $total['TOTAL_Y'][$x]
                            );
                            $p1 = array(
                                'X' => $point['X'],
                                'Y' => 100 * ($current[$x] + $point['Y']) / $total['TOTAL_Y'][$x]
                            );
                        }
                        $current[$x] += $point['Y'];
                    } else {
                        if (!isset($currentNegative[$x])) {
                            $currentNegative[$x] = 0;
                        }

                        $p0 = array(
                                'X' => $point['X'],
                                'Y' => $currentNegative[$x]
                            );
                        $p1 = array(
                                'X' => $point['X'],
                                'Y' => $currentNegative[$x] + $point['Y']
                            );
                        $currentNegative[$x] += $point['Y'];
                    }
                } else {
                    if (count($this->_dataset) > 1) {
                        $w = 2 * ($width - $this->_space) / count($this->_dataset);                        
                        if ($this->_parent->_horizontal) {
                            $y2 = ($y1 = ($y1 + $y2) / 2  - ($width - $this->_space) + $number * $w) + $w;
                        }
                        else {
                            $x2 = ($x1 = ($x1 + $x2) / 2  - ($width - $this->_space) + $number * $w) + $w;
                        }
                    }
                    $p0 = array('X' => $point['X'], 'Y' => 0);
                    $p1 = $point;
                }

                if ((($minY = min($p0['Y'], $p1['Y'])) < $maxYaxis) &&
                    (($maxY = max($p0['Y'], $p1['Y'])) > $minYaxis)
                ) {
                    $p0['Y'] = $minY;
                    $p1['Y'] = $maxY;

                    if ($p0['Y'] < $minYaxis) {
                        $p0['Y'] = '#min_pos#';
                    }
                    if ($p1['Y'] > $maxYaxis) {
                        $p1['Y'] = '#max_neg#';
                    }

                    if ($this->_parent->_horizontal) {
                        $x1 = $this->_pointX($p0);
                        $x2 = $this->_pointX($p1);
                    }
                    else {                       
                        $y1 = $this->_pointY($p0);
                        $y2 = $this->_pointY($p1);
                    }

                    $ID = $point['ID'];
                    if (($ID === false) && (count($this->_dataset) > 1)) {
                        $ID = $key;
                    }
                    $this->_getFillStyle($ID);
                    $this->_getLineStyle($ID);

                    if (($y1 != $y2) && ($x1 != $x2)) {
                        $this->_canvas->rectangle(
                            $this->_mergeData(
                                $point,
                            	array(
                            		'x0' => min($x1, $x2),
                                	'y0' => min($y1, $y2),
                                	'x1' => max($x1, $x2),
                                	'y1' => max($y1, $y2)
                                )
                            )
                        );
                    }
                }
            }
            $number ++;
        }
        unset($keys);

        $this->_drawMarker();

        $this->_clip(false);        
        
        $this->_canvas->endGroup();        

        return true;
    }
}

?>
