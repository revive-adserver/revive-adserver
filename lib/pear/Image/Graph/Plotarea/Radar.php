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
 * @subpackage Plotarea
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plotarea.php
 */
require_once 'Image/Graph/Plotarea.php';

/**
 * Plot area used for radar plots.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plotarea
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Plotarea_Radar extends Image_Graph_Plotarea
{

    /**
     * Create the plotarea, implicitely creates 2 normal axis
     */
    function Image_Graph_Plotarea_Radar()
    {
        parent::__construct();
        $this->_padding = array('left' => 10, 'top' => 10, 'right' => 10, 'bottom' => 10);
        $this->_axisX =& Image_Graph::factory('Image_Graph_Axis_Radar');
        $this->_axisX->_setParent($this);
        $this->_axisY =& Image_Graph::factory('Image_Graph_Axis', IMAGE_GRAPH_AXIS_Y);
        $this->_axisY->_setParent($this);
        $this->_axisY->_setMinimum(0);
    }

    /**
     * Get the width of the 'real' plotarea
     *
     * @return int The width of the 'real' plotarea, ie not including space occupied by padding and axis
     * @access private
     */
    function _plotWidth()
    {
        return (min($this->height(), $this->width())) * 0.80;
    }

    /**
     * Get the height of the 'real' plotarea
     *
     * @return int The height of the 'real' plotarea, ie not including space occupied by padding and axis
     * @access private
     */
    function _plotHeight()
    {
        return (min($this->height(), $this->width())) * 0.80;
    }

    /**
     * Left boundary of the background fill area
     *
     * @return int Leftmost position on the canvas
     * @access private
     */
    function _fillLeft()
    {
        return (int) (($this->_left + $this->_right - $this->_plotWidth()) / 2);
    }

    /**
     * Top boundary of the background fill area
     *
     * @return int Topmost position on the canvas
     * @access private
     */
    function _fillTop()
    {
        return (int) (($this->_top + $this->_bottom - $this->_plotHeight()) / 2);
    }

    /**
     * Right boundary of the background fill area
     *
     * @return int Rightmost position on the canvas
     * @access private
     */
    function _fillRight()
    {
        return (int) (($this->_left + $this->_right + $this->_plotWidth()) / 2);
    }

    /**
     * Bottom boundary of the background fill area
     *
     * @return int Bottommost position on the canvas
     * @access private
     */
    function _fillBottom()
    {
        return (int) (($this->_top + $this->_bottom + $this->_plotHeight()) / 2);
    }

    /**
     * Get the X pixel position represented by a value
     *
     * @param double $value The value to get the pixel-point for
     * @return double The pixel position along the axis
     * @access private
     */
    function _pointX($value)
    {
        if (is_array($value)) {
            if ($value['Y'] == '#min#') {
                $radius = 0;
            } elseif (($value['Y'] == '#max#') || ($value['Y'] === false)) {
                $radius = 1;
            } else {
                $radius = ($value['Y'] - $this->_axisY->_getMinimum()) /
                    ($this->_axisY->_getMaximum() - $this->_axisY->_getMinimum());
            }
            $x = ($this->_left + $this->_right) / 2 -
                $radius * ($this->_plotWidth() / 2) *
                cos(deg2rad($this->_axisX->_point($value['X'])));
        }
        return max($this->_plotLeft, min($this->_plotRight, $x));
    }

    /**
     * Get the Y pixel position represented by a value
     *
     * @param double $value The value to get the pixel-point for
     * @return double The pixel position along the axis
     * @access private
     */
    function _pointY($value)
    {
        if (is_array($value)) {
            if ($value['Y'] == '#min#') {
                $radius = 0;
            } elseif (($value['Y'] == '#max#') || ($value['Y'] === false)) {
                $radius = 1;
            } else {
                $radius = ($value['Y'] - $this->_axisY->_getMinimum()) /
                    ($this->_axisY->_getMaximum() - $this->_axisY->_getMinimum());
            }

            $y = ($this->_top + $this->_bottom) / 2 -
                $radius * ($this->_plotHeight() / 2) *
                sin(deg2rad($this->_axisX->_point($value['X'])));
        }
        return max($this->_plotTop, min($this->_plotBottom, $y));
    }

    /**
     * Update coordinates
     *
     * @access private
     */
    function _updateCoords()
    {
        if (is_array($this->_elements)) {
            $keys = array_keys($this->_elements);
            foreach ($keys as $key) {
                $element =& $this->_elements[$key];
                if (is_a($element, 'Image_Graph_Plot')) {
                    $this->_setExtrema($element);
                }
            }
            unset($keys);
        }

        $this->_calcEdges();

        $centerX = (int) (($this->_left + $this->_right) / 2);
        $centerY = (int) (($this->_top + $this->_bottom) / 2);
        $radius = min($this->_plotHeight(), $this->_plotWidth()) / 2;

        if (is_object($this->_axisX)) {
            $this->_axisX->_setCoords(
                $centerX - $radius,
                $centerY - $radius,
                $centerX + $radius,
                $centerY + $radius
            );
        }

        if (is_object($this->_axisY)) {
            $this->_axisY->_setCoords(
                $centerX,
                $centerY,
                $centerX - $radius,
                $centerY - $radius
            );
        }

        $this->_plotLeft = $this->_fillLeft();
        $this->_plotTop = $this->_fillTop();
        $this->_plotRight = $this->_fillRight();
        $this->_plotBottom = $this->_fillBottom();

        Image_Graph_Element::_updateCoords();
        
        if (is_object($this->_axisX)) {
            $this->_axisX->_updateCoords();
        }

        if (is_object($this->_axisY)) {
            $this->_axisY->_updateCoords();
        }
        
    }

}

?>
