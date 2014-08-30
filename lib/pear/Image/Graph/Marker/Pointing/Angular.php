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
 * @subpackage Marker
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Marker/Pointing.php
 */
require_once 'Image/Graph/Marker/Pointing.php';

/**
 * Marker that points 'away' from the graph.
 *
 * Use this as a marker for displaying another marker pointing to the original
 * point on the graph - where the 'pointer' is calculated as line orthogonal to
 * a line drawn between the points neighbours to both sides (an approximate
 * tangent). This should make an the pointer appear to point 'straight' out from
 * the graph. The 'head' of the pointer is then another marker of any choice.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Marker
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Marker_Pointing_Angular extends Image_Graph_Marker_Pointing
{

    /**
     * The length of the angular marker
     * @var int
     * @access private
     */
    var $_radius;

    /**
     * Image_Graph_AngularPointingMarker [Constructor]
     * @param int $radius The 'length' of the pointer
     * @param Marker $markerEnd The ending marker that represents 'the head of
     * the pin'
     */
    function Image_Graph_Marker_Pointing_Angular($radius, & $markerEnd)
    {
        parent::__construct(0, 0, $markerEnd);
        $this->_radius = $radius;
    }

    /**
     * Draw the marker on the canvas
     * @param int $x The X (horizontal) position (in pixels) of the marker on
     * the canvas
     * @param int $y The Y (vertical) position (in pixels) of the marker on the
     * canvas
     * @param array $values The values representing the data the marker 'points'
     * to
     * @access private
     */
    function _drawMarker($x, $y, $values = false)
    {
        if ((isset($values['LENGTH'])) && ($values['LENGTH'] != 0)) {
            $this->_deltaX = - $values['AX'] * $this->_radius / $values['LENGTH'];
            $this->_deltaY = - $values['AY'] * $this->_radius / $values['LENGTH'];
        }

        if ((isset($values['NPY'])) && (isset($values['APY'])) &&
            (isset($values['PPY'])) && ($values['NPY'] > $values['APY']) &&
            ($values['PPY'] > $values['APY']))
        {
            $this->_deltaX = - $this->_deltaX;
            $this->_deltaY = - $this->_deltaY;
        }
        parent::_drawMarker($x, $y, $values);
    }

}

?>
