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
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plot.php
 */
require_once 'Image/Graph/Plot.php';

/**
 * Linechart.
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
class Image_Graph_Plot_Line extends Image_Graph_Plot
{

    /**
     * Gets the fill style of the element
     *
     * @return int A GD filestyle representing the fill style
     * @see Image_Graph_Fill
     * @access private
     */
    function _getFillStyle($ID = false)
    {
        return IMG_COLOR_TRANSPARENT;
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
        $y = ($y0 + $y1) / 2;
        $dx = abs($x1 - $x0) / 3;
        $dy = abs($y1 - $y0) / 5;
        $this->_canvas->addVertex(array('x' => $x0, 'y' => $y));
        $this->_canvas->addVertex(array('x' => $x0 + $dx, 'y' => $y - $dy * 2));
        $this->_canvas->addVertex(array('x' => $x1 - $dx, 'y' => $y + $dy));
        $this->_canvas->addVertex(array('x' => $x1, 'y' => $y - $dy));
        $this->_canvas->polygon(array('connect' => false));
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
        reset($this->_dataset);

        if ($this->_multiType == 'stacked100pct') {
            $total = $this->_getTotals();
        }

        $p1 = false;

        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];
            $dataset->_reset();
            $numPoints = 0;
            while ($point = $dataset->_next()) {
                if (($this->_multiType == 'stacked') ||
                    ($this->_multiType == 'stacked100pct'))
                {
                    $x = $point['X'];
                    if (!isset($current[$x])) {
                        $current[$x] = 0;
                    }
                    if ($this->_multiType == 'stacked') {
                        $py = $current[$x] + $point['Y'];
                    } else {
                        $py = 100 * ($current[$x] + $point['Y']) / $total['TOTAL_Y'][$x];
                    }
                    $current[$x] += $point['Y'];
                    $point['Y'] = $py;
                }

                if ($point['Y'] === null) {
                    if ($numPoints > 1) {
                        $this->_getLineStyle($key);
                        $this->_canvas->polygon(array('connect' => false, 'map_vertices' => true));
                    }
                    else {
                        $this->_canvas->reset();
                    }
                    $numPoints = 0;
                } else {
                    $p2['X'] = $this->_pointX($point);
                    $p2['Y'] = $this->_pointY($point);

                    $this->_canvas->addVertex(
                        $this->_mergeData(
                            $point,
                            array('x' => $p2['X'], 'y' => $p2['Y'])
                        )
                    );
                    $numPoints++;
                }
            }
            if ($numPoints > 1) {
                $this->_getLineStyle($key);
                $this->_canvas->polygon(array('connect' => false, 'map_vertices' => true));
            }
            else {
                $this->_canvas->reset();
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
