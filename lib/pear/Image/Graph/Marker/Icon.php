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
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Marker.php
 */
require_once 'Image/Graph/Marker.php';

/**
 * Data marker using an image as icon.
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
class Image_Graph_Marker_Icon extends Image_Graph_Marker
{

    /**
     * Filename of the image icon
     * @var string
     * @access private
     */
    var $_filename;

    /**
     * X Point of the icon to use as data 'center'
     * @var int
     * @access private
     */
    var $_pointX = 0;

    /**
     * Y Point of the icon to use as data 'center'
     * @var int
     * @access private
     */
    var $_pointY = 0;

    /**
     * Create an icon marker
     *
     * @param string $filename The filename of the icon
     * @param int $width The 'new' width of the icon if it is to be resized
     * @param int $height The 'new' height of the icon if it is to be resized
     */
    function __construct($filename, $width = 0, $height = 0)
    {
        parent::__construct();
        $this->_filename = $filename;
    }

    /**
     * Set the X 'center' point of the marker
     *
     * @param int $x The X 'center' point of the marker
     */
    function setPointX($x)
    {
        $this->_pointX = $x;
    }

    /**
     * Set the Y 'center' point of the marker
     *
     * @param int $y The Y 'center' point of the marker
     */
    function setPointY($y)
    {
        $this->_pointY = $y;
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
        parent::_drawMarker($x, $y, $values);
        if ($this->_filename) {
            $this->_canvas->image(
            	array(
            		'x' => $x,
            		'y' => $y,
            		'filename' => $this->_filename,
					'alignment' => array('horizontal' => 'center', 'vertical' => 'center')
				)
			);
        }
    }

}

?>
