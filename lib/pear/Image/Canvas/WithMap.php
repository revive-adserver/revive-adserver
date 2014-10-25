<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Canvas
 *
 * Canvas based creation of images to facilitate different output formats
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
 * @package    Image_Canvas
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 */

/**
 *  Class for handling different output formats including a HTML image map
 * 
 * @category   Images
 * @package    Image_Canvas
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 * @since      version 0.2.0
 * @abstract
 */
class Image_Canvas_WithMap extends Image_Canvas
{

    /**
     * The image map
     * @var Image_Canvas_ImageMap
     * @access private
     */
    var $_imageMap = null;

    /**
     * Create the canvas.
     *
     * Parameters available:
     *
     * 'width' The width of the graph on the canvas
     *
     * 'height' The height of the graph on the canvas
     *
     * 'left' The left offset of the graph on the canvas
     *
     * 'top' The top offset of the graph on the canvas
     * 
     * 'usemap' Initialize an image map
     *
     * @param array $params Parameter array
     * @abstract
     */
    function Image_Canvas_WithMap($params)
    {
        parent::Image_Canvas($params);
                
        if ((isset($params['usemap'])) && ($params['usemap'] === true)) {
            $this->_imageMap =& Image_Canvas::factory(
                'ImageMap',
                array(
                    'left' => $this->_left,
                    'top' => $this->_top,
                    'width' => $this->_width,
                    'height' => $this->_height
                )
            );
        }
    }
    /**
     * Draw a line
     *
     * Parameter array:
     * 'x0': int X start point
     * 'y0': int Y start point
     * 'x1': int X end point
     * 'y1': int Y end point
     * 'color': mixed [optional] The line color
     * @param array $params Parameter array
     */
    function line($params)
    {
        if (isset($this->_imageMap)) {
            $this->_imageMap->line($params);
        }
        parent::line($params);
    }

    /**
     * Adds vertex to a polygon
     *
     * Parameter array:
     * 'x': int X point
     * 'y': int Y point
     * @param array $params Parameter array
     */
    function addVertex($params)
    {
        if (isset($this->_imageMap)) {
            $this->_imageMap->addVertex($params);
        }
        parent::addVertex($params);
    }

    /**
     * Adds "splined" vertex to a polygon
     *
     * Parameter array:
     * 'x': int X point
     * 'y': int Y point
     * 'p1x': X Control point 1
     * 'p1y': Y Control point 1
     * 'p2x': X Control point 2
     * 'p2y': Y Control point 2
     * @param array $params Parameter array
     */
    function addSpline($params)
    {
        if (isset($this->_imageMap)) {
            $this->_imageMap->addSpline($params);
        }
        parent::addSpline($params);
    }

    /**
     * Draws a polygon
     *
     * Parameter array:
     * 'connect': bool [optional] Specifies whether the start point should be
     *   connected to the endpoint (closed polygon) or not (connected line)
     * 'fill': mixed [optional] The fill color
     * 'line': mixed [optional] The line color
     * @param array $params Parameter array
     */
    function polygon($params)
    {
        if (isset($this->_imageMap)) {
            $this->_imageMap->polygon($params);
        }
        parent::polygon($params);
    }

    /**
     * Draw a rectangle
     *
     * Parameter array:
     * 'x0': int X start point
     * 'y0': int Y start point
     * 'x1': int X end point
     * 'y1': int Y end point
     * 'fill': mixed [optional] The fill color
     * 'line': mixed [optional] The line color
     * @param array $params Parameter array
     */
    function rectangle($params)
    {
        if (isset($this->_imageMap)) {
            $this->_imageMap->rectangle($params);
        }        
        parent::rectangle($params);
    }

    /**
     * Draw an ellipse
     *
     * Parameter array:
     * 'x': int X center point
     * 'y': int Y center point
     * 'rx': int X radius
     * 'ry': int Y radius
     * 'fill': mixed [optional] The fill color
     * 'line': mixed [optional] The line color
     * @param array $params Parameter array
     */
    function ellipse($params)
    {
        if (isset($this->_imageMap)) {
            $this->_imageMap->ellipse($params);
        }        
        parent::ellipse($params);
    }

    /**
     * Draw a pie slice
     *
     * Parameter array:
     * 'x': int X center point
     * 'y': int Y center point
     * 'rx': int X radius
     * 'ry': int Y radius
     * 'v1': int The starting angle (in degrees)
     * 'v2': int The end angle (in degrees)
     * 'srx': int [optional] Starting X-radius of the pie slice (i.e. for a doughnut)
     * 'sry': int [optional] Starting Y-radius of the pie slice (i.e. for a doughnut)
     * 'fill': mixed [optional] The fill color
     * 'line': mixed [optional] The line color
     * @param array $params Parameter array
     */
    function pieslice($params)
    {
        if (isset($this->_imageMap)) {
            $this->_imageMap->pieslice($params);
        }        
        parent::pieslice($params);
    }

    /**
     * Writes text
     *
     * Parameter array:
     * 'x': int X-point of text
     * 'y': int Y-point of text
     * 'text': string The text to add
     * 'alignment': array [optional] Alignment
     * 'color': mixed [optional] The color of the text
     */
    function addText($params)
    {
        if (isset($this->_imageMap)) {
            $this->_imageMap->addText($params);
        }
        parent::addText($params);
    }

    /**
     * Overlay image
     *
     * Parameter array:
     * 'x': int X-point of overlayed image
     * 'y': int Y-point of overlayed image
     * 'filename': string The filename of the image to overlay
     * 'width': int [optional] The width of the overlayed image (resizing if possible)
     * 'height': int [optional] The height of the overlayed image (resizing if possible)
     * 'alignment': array [optional] Alignment
     */
    function image($params)
    {
        if (isset($this->_imageMap)) {
            $this->_imageMap->image($params);
        }
        parent::image($params);
    }

    /**
     * Get the imagemap
     * @return Image_Graph_ImageMap The image map (or false if none)
     */
    function &getImageMap()
    {
        $result = null;
        if (isset($this->_imageMap)) {
            $result =& $this->_imageMap;
        }
        return $result;
    }

}

?>
