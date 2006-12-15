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
 * @version    CVS: $Id: Area.php,v 1.13 2005/11/27 22:21:17 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plot.php
 */
require_once 'Image/Graph/Plot.php';

/**
 * Area Chart plot.
 *
 * An area chart plots all data points similar to a {@link
 * Image_Graph_Plot_Line}, but the area beneath the line is filled and the whole
 * area 'the-line', 'the right edge', 'the x-axis' and 'the left edge' is
 * bounded. Smoothed charts are only supported with non-stacked types
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
class Image_Graph_Plot_Area extends Image_Graph_Plot
{

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
        $dx = abs($x1 - $x0) / 3;
        $dy = abs($y1 - $y0) / 3;
        $this->_canvas->addVertex(array('x' => $x0, 'y' => $y1));
        $this->_canvas->addVertex(array('x' => $x0, 'y' => $y0 + $dy));
        $this->_canvas->addVertex(array('x' => $x0 + $dx, 'y' => $y0));
        $this->_canvas->addVertex(array('x' => $x0 + 2*$dx, 'y' => $y0 + 2*$dy));
        $this->_canvas->addVertex(array('x' => $x1, 'y' => $y0 + $dy));
        $this->_canvas->addVertex(array('x' => $x1, 'y' => $y1));
        $this->_canvas->polygon(array('connect' => true));
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
        
        $this->_canvas->startGroup(get_class($this) . '_' . $this->_title);

        $this->_clip(true);        

        $base = array();
        if ($this->_multiType == 'stacked') {
            reset($this->_dataset);
            $key = key($this->_dataset);
            $dataset =& $this->_dataset[$key];

            $first = $dataset->first();
            $point = array ('X' => $first['X'], 'Y' => '#min_pos#');
            $base[] = array();
            $base[] = $this->_pointY($point);
            $first = $this->_pointX($point);
            $base[] = $first;
    
            $last = $dataset->last();
            $point = array ('X' => $last['X'], 'Y' => '#min_pos#');
            $base[] = array();
            $base[] = $this->_pointY($point);
            $base[] = $this->_pointX($point);
                    
            $current = array();
        }

        $minYaxis = $this->_parent->_getMinimum($this->_axisY);
        $maxYaxis = $this->_parent->_getMaximum($this->_axisY);

        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];
            $dataset->_reset();
            if ($this->_multiType == 'stacked') {
                $plotarea = array_reverse($base);
                $base = array();
                while ($point = $dataset->_next()) {
                    $x = $point['X'];
                    $p = $point;
                    if (isset($current[$x])) {
                        $p['Y'] += $current[$x];
                    } else {
                        $current[$x] = 0;
                    }
                    $x1 = $this->_pointX($p);
                    $y1 = $this->_pointY($p);
                    $plotarea[] = $x1;
                    $plotarea[] = $y1;
                    $plotarea[] = $point;
                    $base[] = array();
                    $base[] = $y1;
                    $base[] = $x1;
                    $current[$x] += $point['Y'];
                }
            } else {
                $first = true;
                $plotarea = array();
                while ($point = $dataset->_next()) {
                    if ($first) {
                        $firstPoint = array ('X' => $point['X'], 'Y' => '#min_pos#');
                        $plotarea[] = $this->_pointX($firstPoint);
                        $plotarea[] = $this->_pointY($firstPoint);
                        $plotarea[] = array();
                    }
                    $plotarea[] = $this->_pointX($point);
                    $plotarea[] = $this->_pointY($point);
                    $plotarea[] = $point;
                    $lastPoint = $point;
                    $first = false;
                }
                $endPoint['X'] = $lastPoint['X'];
                $endPoint['Y'] = '#min_pos#';
                $plotarea[] = $this->_pointX($endPoint);
                $plotarea[] = $this->_pointY($endPoint);
                $plotarea[] = array();
            }

            reset($plotarea);
            while (list(, $x) = each($plotarea)) {
                list(, $y) = each($plotarea);
                list(, $data) = each($plotarea);
                $this->_canvas->addVertex(
                    $this->_mergeData(
                        $data,
                        array('x' => $x, 'y' => $y)
                    )
                );
            }

            $this->_getFillStyle($key);
            $this->_getLineStyle($key);
            $this->_canvas->polygon(array('connect' => true, 'map_vertices' => true));
        }
        unset($keys);
        $this->_drawMarker();
        $this->_clip(false);
                
        $this->_canvas->endGroup();

        return true;
    }

}

?>