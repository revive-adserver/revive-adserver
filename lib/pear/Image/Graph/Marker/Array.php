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
 * Include file Image/Graph/Marker.php
 */
require_once 'Image/Graph/Marker.php';

/**
 * A sequential array of markers.
 *
 * This is used for displaying different markers for datapoints on a chart.
 * This is done by adding multiple markers to a MarkerArrray structure.
 * The marker array will then when requested return the 'next' marker in
 * sequential order. It is possible to specify ID tags to each marker, which is
 * used to make sure some data uses a specific marker.
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
class Image_Graph_Marker_Array extends Image_Graph_Marker
{

    /**
     * The marker array
     * @var array
     * @access private
     */
    var $_markers = array ();

    /**
     * Add a marker style to the array
     *
     * @param Marker $marker The marker to add
     */
    function add(& $marker)
    {
        if (is_a($marker, 'Image_Graph_Element')) {
            parent::add($marker);
        }
        $this->_markers[] =& $marker;
        reset($this->_markers);
    }

    /**
     * Draw the marker on the canvas
     *
     * @param int $x The X (horizontal) position (in pixels) of the marker on
     *   the canvas
     * @param int $y The Y (vertical) position (in pixels) of the marker on the
     *   canvas
     * @param array $values The values representing the data the marker 'points'
     *   to
     * @access private
     */
    function _drawMarker($x, $y, $values = false)
    {
        $ID = key($this->_markers);
        if (!next($this->_markers)) {
            reset($this->_markers);
        }
        $marker =& $this->_markers[$ID];

        if ($marker != null) {
            $marker->_drawMarker($x, $y, $values);
        }
        parent::_drawMarker($x, $y, $values);
    }

}

?>
