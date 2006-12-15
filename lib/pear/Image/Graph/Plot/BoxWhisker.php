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
 * @version    CVS: $Id: BoxWhisker.php,v 1.14 2005/11/27 22:21:17 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 * @since      File available since Release 0.3.0dev2
 */

/**
 * Include file Image/Graph/Plot.php
 */
require_once 'Image/Graph/Plot.php';

/**
 * Box & Whisker chart.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 * @since      Class available since Release 0.3.0dev2
 */
class Image_Graph_Plot_BoxWhisker extends Image_Graph_Plot
{
    /**
     * Whisker circle size
     * @var int
     * @access private
     */
    var $_whiskerSize = false;

    /**
     * Draws a box & whisker
     *
     * @param int $x The x position
     * @param int $w The width of the box
     * @param int $r The radius of the circle markers
     * @param int $y_min The Y position of the minimum value
     * @param int $y_q1 The Y position of the median of the first quartile
     * @param int $y_med The Y position of the median
     * @param int $y_q3 The Y position of the median of the third quartile
     * @param int $y_max The Y position of the maximum value
     * @param int $key The ID tag
     * @access private
     */
    function _drawBoxWhiskerV($x, $w, $r, $y_min, $y_q1, $y_med, $y_q3, $y_max, $key = false)
    {
        // draw circles
        $this->_getLineStyle();
        $this->_getFillStyle('min');
        $this->_canvas->ellipse(array('x' => $x, 'y' => $y_min, 'rx' => $r, 'ry' => $r));

        $this->_getLineStyle();
        $this->_getFillStyle('quartile1');
        $this->_canvas->ellipse(array('x' => $x, 'y' => $y_q1, 'rx' => $r, 'ry' => $r));

        $this->_getLineStyle();
        $this->_getFillStyle('median');
        $this->_canvas->ellipse(array('x' => $x, 'y' => $y_med, 'rx' => $r, 'ry' => $r));

        $this->_getLineStyle();
        $this->_getFillStyle('quartile3');
        $this->_canvas->ellipse(array('x' => $x, 'y' => $y_q3, $r, 'rx' => $r, 'ry' => $r));

        $this->_getLineStyle();
        $this->_getFillStyle('max');
        $this->_canvas->ellipse(array('x' => $x, 'y' => $y_max, $r, 'rx' => $r, 'ry' => $r));

        // draw box and lines

        $this->_getLineStyle();
        $this->_canvas->line(array('x0' => $x, 'y0' => $y_min, 'x1' => $x, 'y1' => $y_q1));
        $this->_getLineStyle();
        $this->_canvas->line(array('x0' => $x, 'y0' => $y_q3, 'x1' => $x, 'y1' => $y_max));

        $this->_getLineStyle();
        $this->_getFillStyle('box');
        $this->_canvas->rectangle(array('x0' => $x - $w, 'y0' => $y_q1, 'x1' => $x + $w, 'y1' => $y_q3));

        $this->_getLineStyle();
        $this->_canvas->line(array('x0' => $x - $w, 'y0' => $y_med, 'x1' => $x + $w, 'y1' => $y_med));
    }

    /**
     * Draws a box & whisker
     *
     * @param int $y The x position
     * @param int $h The width of the box
     * @param int $r The radius of the circle markers
     * @param int $x_min The Y position of the minimum value
     * @param int $x_q1 The Y position of the median of the first quartile
     * @param int $x_med The Y position of the median
     * @param int $x_q3 The Y position of the median of the third quartile
     * @param int $x_max The Y position of the maximum value
     * @param int $key The ID tag
     * @access private
     */
    function _drawBoxWhiskerH($y, $h, $r, $x_min, $x_q1, $x_med, $x_q3, $x_max, $key = false)
    {
        // draw circles
        $this->_getLineStyle();
        $this->_getFillStyle('min');
        $this->_canvas->ellipse(array('x' => $x_min, 'y' => $y, 'rx' => $r, 'ry' => $r));

        $this->_getLineStyle();
        $this->_getFillStyle('quartile1');
        $this->_canvas->ellipse(array('x' => $x_q1, 'y' => $y, 'rx' => $r, 'ry' => $r));

        $this->_getLineStyle();
        $this->_getFillStyle('median');
        $this->_canvas->ellipse(array('x' => $x_med, 'y' => $y, 'rx' => $r, 'ry' => $r));

        $this->_getLineStyle();
        $this->_getFillStyle('quartile3');
        $this->_canvas->ellipse(array('x' => $x_q3, 'y' => $y, $r, 'rx' => $r, 'ry' => $r));

        $this->_getLineStyle();
        $this->_getFillStyle('max');
        $this->_canvas->ellipse(array('x' => $x_max, 'y' => $y, $r, 'rx' => $r, 'ry' => $r));

        // draw box and lines

        $this->_getLineStyle();
        $this->_canvas->line(array('x0' => $x_min, 'y0' => $y, 'x1' => $x_q1, 'y1' => $y));
        $this->_getLineStyle();
        $this->_canvas->line(array('x0' => $x_q3, 'y0' => $y, 'x1' => $x_max, 'y1' => $y));

        $this->_getLineStyle();
        $this->_getFillStyle('box');
        $this->_canvas->rectangle(array('x0' => $x_q1, 'y0' => $y - $h, 'x1' => $x_q3, 'y1' => $y + $h));

        $this->_getLineStyle();
        $this->_canvas->line(array('x0' => $x_med, 'y0' => $y - $h, 'x1' => $x_med, 'y1' => $y + $h));
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
        $x = round(($x0 + $x1) / 2);
        $h = abs($y1 - $y0) / 9;
        $w = round(abs($x1 - $x0) / 5);
        $r = 2;//round(abs($x1 - $x0) / 13);
        $this->_drawBoxWhiskerV($x, $w, $r, $y1, $y1 - 2 * $h, $y1 - 4 * $h, $y0 + 3 * $h, $y0);
    }
    
    /**
     * Sets the whisker circle size
     *
     * @param int $size Size (radius) of the whisker circle/dot
     */
    function setWhiskerSize($size = false)
    {
        $this->_whiskerSize = $size;
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

        if ($this->_multiType == 'stacked100pct') {
            $total = $this->_getTotals();
        }
        $current = array();
        $number = 0;
        $width = floor(0.5 * $this->_parent->_labelDistance(IMAGE_GRAPH_AXIS_X) / 2);

        if ($this->_whiskerSize !== false) {
            $r = $this->_whiskerSize;
        } else {            
            $r = min(5, $width / 10);
        }

        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];
            $dataset->_reset();
            while ($data = $dataset->_next()) {
                if ($this->_parent->_horizontal) {
                    $point['X'] = $data['X'];
                    $y = $data['Y'];
    
                    $min = min($y);
                    $max = max($y);
                    $q1 = $dataset->_median($y, 'first');
                    $med = $dataset->_median($y, 'second');
                    $q3 = $dataset->_median($y, 'third');
    
                    $point['Y'] = $min;
                    $y = $this->_pointY($point);
                    $x_min = $this->_pointX($point);
    
                    $point['Y'] = $max;
                    $x_max = $this->_pointX($point);
    
                    $point['Y'] = $q1;
                    $x_q1 = $this->_pointX($point);
    
                    $point['Y'] = $med;
                    $x_med = $this->_pointX($point);
    
                    $point['Y'] = $q3;
                    $x_q3 = $this->_pointX($point);
    
                    $this->_drawBoxWhiskerH($y, $width, $r, $x_min, $x_q1, $x_med, $x_q3, $x_max, $key);
                }
                else {
                    $point['X'] = $data['X'];
                    $y = $data['Y'];
    
                    $min = min($y);
                    $max = max($y);
                    $q1 = $dataset->_median($y, 'first');
                    $med = $dataset->_median($y, 'second');
                    $q3 = $dataset->_median($y, 'third');
    
                    $point['Y'] = $min;
                    $x = $this->_pointX($point);
                    $y_min = $this->_pointY($point);
    
                    $point['Y'] = $max;
                    $y_max = $this->_pointY($point);
    
                    $point['Y'] = $q1;
                    $y_q1 = $this->_pointY($point);
    
                    $point['Y'] = $med;
                    $y_med = $this->_pointY($point);
    
                    $point['Y'] = $q3;
                    $y_q3 = $this->_pointY($point);
    
                    $this->_drawBoxWhiskerV($x, $width, $r, $y_min, $y_q1, $y_med, $y_q3, $y_max, $key);
                }
            }
        }
        unset($keys);
        $this->_drawMarker();

        $this->_clip(false);        

        $this->_canvas->endGroup();
        return true;
    }

}

?>