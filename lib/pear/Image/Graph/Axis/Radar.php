<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Class for axis handling.
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
 * @subpackage Axis
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */
 
/**
 * Include file Image/Graph/Axis/Category.php
 */
require_once 'Image/Graph/Axis/Category.php';

/**
 * Displays an 'X'-axis in a radar plot chart.
 *
 * This axis maps the number of elements in the dataset to a angle (from 0-
 * 360 degrees). Displaying the axis consist of drawing a number of lines from
 * center to the edge of the 'circle' than encloses the radar plot. The labels
 * are drawn on the 'ends' of these radial lines.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Axis
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Axis_Radar extends Image_Graph_Axis_Category
{

    /**
     * Specifies the number of pixels, the labels is offsetted from the end of
     * the axis
     *
     * @var int
     * @access private
     */
    var $_distanceFromEnd = 5;

    /**
     * Gets the minimum value the axis will show.
     *
     * This is always 0
     *
     * @return double The minumum value
     * @access private
     */
    function _getMinimum()
    {
        return 0;
    }

    /**
     * Gets the maximum value the axis will show.
     *
     * This is always the number of labels passed to the constructor.
     *
     * @return double The maximum value
     * @access private
     */
    function _getMaximum()
    {
        return count($this->_labels);
    }

    /**
     * Calculate the delta value (the number of pixels representing one unit
     * on the axis)
     *
     * @return double The label interval
     * @access private
     */
    function _calcDelta()
    {
        if (abs($this->_getMaximum() - $this->_getMinimum()) == 0) {
            $this->_delta = false;
        } else {
            $this->_delta = 360 / ($this->_getMaximum() - $this->_getMinimum());
        }                
    }    

    /**
     * Get the pixel position represented by a value on the canvas
     *
     * @param double $value the value to get the pixel-point for
     * @return double The pixel position along the axis
     * @access private
     */
    function _point($value)
    {
        return (90 + (int) ($this->_value($value) * $this->_delta)) % 360;
    }

    /**
     * Get the size in pixels of the axis.
     *
     * For a radar plot this is always 0
     *
     * @return int The size of the axis
     * @access private
     */
    function _size()
    {
        return 0;
    }

    /**
     * Sets the distance from the end of the category lines to the label.
     *
     * @param int $distance The distance in pixels
     */
    function setDistanceFromEnd($distance = 5)
    {
        $this->_distanceFromEnd = $distance;
    }

    /**
     * Draws axis lines.
     *
     * @access private
     */
    function _drawAxisLines()
    {
    }

    /**
     * Output an axis tick mark.
     *
     * @param int $value The value to output
     * @access private
     */
    function _drawTick($value, $level = 1)
    {
        $centerX = (int) (($this->_left + $this->_right) / 2);
        $centerY = (int) (($this->_top + $this->_bottom) / 2);

        $radius = min($this->height(), $this->width()) / 2;

        $endPoint = array ('X' => $value, 'Y' => '#max#');
        $dX = $this->_pointX($endPoint);
        $dY = $this->_pointY($endPoint);

        $offX = ($dX - $centerX);
        $offY = ($dY - $centerY);

        $hyp = sqrt($offX*$offX + $offY*$offY);
        if ($hyp != 0) {
            $scale = $this->_distanceFromEnd / $hyp;
        } else {
            $scale = 1;
        }

        $adX = $dX + $offX * $scale;
        $adY = $dY + $offY * $scale;

        if (is_object($this->_dataPreProcessor)) {
            $labelText = $this->_dataPreProcessor->_process($value);
        } else {
            $labelText = $value;
        }

        if ((abs($dX - $centerX) < 1.5) && ($dY < $centerY)) {
            $align = IMAGE_GRAPH_ALIGN_BOTTOM + IMAGE_GRAPH_ALIGN_CENTER_X;
        } elseif ((abs($dX - $centerX) < 1.5) && ($dY > $centerY)) {
            $align = IMAGE_GRAPH_ALIGN_TOP + IMAGE_GRAPH_ALIGN_CENTER_X;
        } elseif ($dX < $centerX) {
            $align = IMAGE_GRAPH_ALIGN_RIGHT + IMAGE_GRAPH_ALIGN_CENTER_Y;
        } else {
            $align = IMAGE_GRAPH_ALIGN_LEFT + IMAGE_GRAPH_ALIGN_CENTER_Y;
        }
        $this->write($adX, $adY, $labelText, $align);

        $this->_getLineStyle();
        $this->_canvas->line(array('x0' => $centerX, 'y0' => $centerY, 'x1' => $dX, 'y1' => $dY));
    }

}

?>
