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
 * @subpackage Layout
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plotarea/Element.php
 */
require_once 'Image/Graph/Plotarea/Element.php';

/**
 * Defines an area of the graph that can be layout'ed.
 *
 * Any class that extends this abstract class can be used within a layout on the canvas.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Layout
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 * @abstract
 */
class Image_Graph_Layout extends Image_Graph_Plotarea_Element
{

    /**
     * Has the coordinates already been updated?
     * @var bool
     * @access private
     */
    var $_updated = false;

    /**
     * Alignment of the area for each vertice (left, top, right, bottom)
     * @var array
     * @access private
     */
    var $_alignSize = array ('left' => 0, 'top' => 0, 'right' => 0, 'bottom' => 0);

    /**
     * Image_Graph_Layout [Constructor]
     */
    function __construct()
    {
        parent::__construct();
        $this->_padding = array('left' => 2, 'top' => 2, 'right' => 2, 'bottom' => 2);
    }

    /**
     * Resets the elements
     *
     * @access private
     */
    function _reset()
    {
        parent::_reset();
        $this->_updated = false;
    }

    /**
     * Calculate the edge offset for a specific edge
     * @param array $alignSize The alignment of the edge
     * @param int $offset The offset/posision of the at 0% edge
     * @param int $total The total size (width or height) of the element
     * @param int $multiplier +/- 1 if the edge should pushed either toward more
     * negative or positive values
	 * @since 0.3.0dev2
     * @access private
     */
    function _calcEdgeOffset($alignSize, $offset, $total, $multiplier)
    {
        if ($alignSize['unit'] == 'percentage') {
            return $offset + $multiplier * ($total * $alignSize['value'] / 100);
        } elseif ($alignSize['unit'] == 'pixels') {
            if (($alignSize['value'] == 'auto_part1') || ($alignSize['value'] == 'auto_part2')) {
                $alignSize['value'] = $multiplier * $this->_parent->_getAbsolute($alignSize['value']);
            }
            if ($alignSize['value'] < 0) {
                return $offset + $multiplier * ($total + $alignSize['value']);
            } else {
                return $offset + $multiplier * $alignSize['value'];
            }
        }
        return $offset;
    }

    /**
     * Calculate the edges
     *
     * @access private
     */
    function _calcEdges()
    {
        if ((is_array($this->_alignSize)) && (!$this->_updated)) {
            $left = $this->_calcEdgeOffset(
                $this->_alignSize['left'],
                $this->_parent->_fillLeft(),
                $this->_parent->_fillWidth(),
                +1
            );
            $top = $this->_calcEdgeOffset(
                $this->_alignSize['top'],
                $this->_parent->_fillTop(),
                $this->_parent->_fillHeight(),
                +1
            );
            $right = $this->_calcEdgeOffset(
                $this->_alignSize['right'],
                $this->_parent->_fillRight(),
                $this->_parent->_fillWidth(),
                -1
            );
            $bottom = $this->_calcEdgeOffset(
                $this->_alignSize['bottom'],
                $this->_parent->_fillBottom(),
                $this->_parent->_fillHeight(),
                -1
            );

            $this->_setCoords(
                $left + $this->_padding['left'],
                $top + $this->_padding['top'],
                $right - $this->_padding['right'],
                $bottom - $this->_padding['bottom']
            );
        }
    }

    /**
     * Update coordinates
     *
     * @access private
     */
    function _updateCoords()
    {
        $this->_calcEdges();
        parent::_updateCoords();
    }

    /**
     * Pushes an edge of area a specific distance 'into' the canvas
     *
     * @param int $edge The edge of the canvas to align relative to
     * @param int $size The number of pixels or the percentage of the canvas total size to occupy relative to the selected alignment edge
     * @access private
     */
    function _push($edge, $size = '100%')
    {
        $result = array();
        if (preg_match("/([0-9]*)\%/D", $size, $result)) {
            $this->_alignSize[$edge] = array(
                'value' => min(100, max(0, $result[1])),
                'unit' => 'percentage'
            );
        } else {
            $this->_alignSize[$edge] = array(
                'value' => $size,
                'unit' => 'pixels'
            );
        }
    }

    /**
     * Sets the coordinates of the element
     *
     * @param int $left The leftmost pixel of the element on the canvas
     * @param int $top The topmost pixel of the element on the canvas
     * @param int $right The rightmost pixel of the element on the canvas
     * @param int $bottom The bottommost pixel of the element on the canvas
     * @access private
     */
    function _setCoords($left, $top, $right, $bottom)
    {
        parent::_setCoords($left, $top, $right, $bottom);
        $this->_updated = true;
    }

    /**
     * Returns the calculated "auto" size
     *
     * @return int The calculated auto size
     * @access private
     */
    function _getAutoSize()
    {
        return false;
    }

}

?>
