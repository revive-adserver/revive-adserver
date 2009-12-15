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
 * Specfies the path to the system location of font files.
 *
 * Remember trailing slash!
 *
 * This is set by default on Windows systems to %SystemRoot%\Fonts\
 */
if (!defined('IMAGE_CANVAS_SYSTEM_FONT_PATH')) {
    if (isset($_SERVER['SystemRoot'])) {
        define('IMAGE_CANVAS_SYSTEM_FONT_PATH', $_SERVER['SystemRoot'] . '/Fonts/');
    } else {
        /**
          * @ignore
          */
        define('IMAGE_CANVAS_SYSTEM_FONT_PATH', '');
    }
}

/**
 *  Class for handling different output formats
 * 
 * @category   Images
 * @package    Image_Canvas
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 * @abstract
 */
class Image_Canvas
{

    /**
     * The leftmost pixel of the element on the canvas
     * @var int
     * @access private
     */
    var $_left = 0;

    /**
     * The topmost pixel of the element on the canvas
     * @var int
     * @access private
     */
    var $_top = 0;

    /**
     * The width of the graph
     * @var int
     * @access private
     */
    var $_width = 0;

    /**
     * The height of the graph
     * @var int
     * @access private
     */
    var $_height = 0;

    /**
     * Polygon vertex placeholder
     * @var array
     * @access private
     */
    var $_polygon = array();

    /**
     * The thickness of the line(s)
     * @var int
     * @access private
     */
    var $_thickness = 1;

    /**
     * The line style
     * @var mixed
     * @access private
     */
    var $_lineStyle = 'transparent';

    /**
     * The fill style
     * @var mixed
     * @access private
     */
    var $_fillStyle = 'transparent';

    /**
     * The font options
     * @var array
     * @access private
     */
    var $_font = array();

    /**
     * The default font
     * @var array
     * @access private
     */
    var $_defaultFont = array('name' => 'Courier New', 'color' => 'black', 'size' => 9);

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
     * @param array $params Parameter array
     * @abstract
     */
    function Image_Canvas($params)
    {
        if (isset($params['left'])) {
            $this->_left = $params['left'];
        }

        if (isset($params['top'])) {
            $this->_top = $params['top'];
        }

        if (isset($params['width'])) {
            $this->_width = $params['width'];
        }

        if (isset($params['height'])) {
            $this->_height = $params['height'];
        }
        
        $this->setDefaultFont($this->_defaultFont);
    }

    /**
     * Get the x-point from the relative to absolute coordinates
     *
     * @param float $x The relative x-coordinate (in percentage of total width)
     * @return float The x-coordinate as applied to the canvas
     * @access private
     */
    function _getX($x)
    {
        return floor($this->_left + $x);
    }

    /**
     * Get the y-point from the relative to absolute coordinates
     *
     * @param float $y The relative y-coordinate (in percentage of total width)
     * @return float The y-coordinate as applied to the canvas
     * @access private
     */
    function _getY($y)
    {
        return floor($this->_top + $y);
    }

    /**
     * Get the width of the canvas
     *
     * @return int The width
     */
    function getWidth()
    {
        return $this->_width;
    }

    /**
     * Get the height of the canvas
     *
     * @return int The height
     */
    function getHeight()
    {
        return $this->_height;
    }

    /**
     * Sets the thickness of the line(s) to be drawn
     *
     * @param int $thickness The actual thickness (in pixels)
     */
    function setLineThickness($thickness)
    {
        $this->_thickness = $thickness;
    }

    /**
     * Sets the color of the line(s) to be drawn
     *
     * @param mixed $color The color of the line
     */
    function setLineColor($color)
    {
        $this->_lineStyle = $color;
    }

    /**
     * Sets the style of the filling of drawn objects.
     *
     * This method gives simple access to setFillColor(), setFillImage() and
     * setGradientFill()
     *
     * @param mixed $fill The fill style
     */
    function setFill($fill)
    {
        if (is_array($fill)) {
            $this->setGradientFill($fill);
        } elseif (file_exists($fill)) {
            $this->setFillImage($fill);
        } else {
            $this->setFillColor($fill);
        }
    }

    /**
     * Sets the color of the filling of drawn objects
     *
     * @param mixed $color The fill color
     */
    function setFillColor($color)
    {
        $this->_fillStyle = $color;
    }

    /**
     * Sets an image that should be used for filling
     *
     * @param string $filename The filename of the image to fill with
     */
    function setFillImage($filename)
    {
    }

    /**
     * Sets a gradient fill
     *
     * @param array $gradient Gradient fill options
     */
    function setGradientFill($gradient)
    {
        $this->_fillStyle = $gradient;
    }

    /**
     * Sets the font options.
     *
     * The $font array may have the following entries:
     *
     * 'name'    The name of the font. This name must either be supported
     * natively by the canvas or mapped to a font using the font-mapping scheme
     *
     * 'size'     Size in pixels
     *
     * 'angle'     The angle with which to write the text
     *
     * @param array $fontOptions The font options.
     */
    function setFont($fontOptions)
    {
        $this->_font = $fontOptions;

        if (!isset($this->_font['color'])) {
            $this->_font['color'] = 'black';
        }

        if (!(isset($this->_font['angle'])) || ($this->_font['angle'] === false)) {
            $this->_font['angle'] = 0;
        }
        
        if (isset($this->_font['angle'])) {
            if ((($this->_font['angle'] > 45) && ($this->_font['angle'] < 135)) ||
               (($this->_font['angle'] > 225) && ($this->_font['angle'] < 315))
            ) {
                $this->_font['vertical'] = true;
            }
        }
        
        if ((!isset($this->_font['file'])) && (isset($this->_font['name']))) {
            include_once 'Image/Canvas/Tool.php';
            $this->_font['file'] = Image_Canvas_Tool::fontMap($this->_font['name']);
        }
    }

    /**
     * Sets the default font options.
     *
     * The $font array may have the following entries:
     *
     * 'name'   The name of the font. This name must either be supported
     * natively by the canvas or mapped to a font using the font-mapping scheme
     *
     * 'size'   Size in pixels
     *
     * 'angle'  The angle with which to write the text
     *
     * @param array $fontOptions The font options.
     */
    function setDefaultFont($fontOptions)
    {
        $this->setFont($fontOptions);
        $this->_defaultFont = $this->_font;
    }

    /**
     * Resets the canvas.
     *
     * Includes fillstyle, linestyle, thickness and polygon
     *
     * @access private
     */
    function _reset()
    {
        $this->_lineStyle = false;
        $this->_fillStyle = false;
        $this->_thickness = 1;
        $this->_polygon = array();
        $this->_font = $this->_defaultFont;
    }
    
    /**
     * Reset the canvas.
     *
     * Includes fillstyle, linestyle, thickness and polygon
     */
    function reset() 
    {
        $this->_reset();
    }
    
    /**
     * Draw a line end
     *
     * Parameter array:
     * 'x': int X point
     * 'y': int Y point
     * 'end': string The end type of the end
     * 'angle': int [optional] The angle with which to draw the end
     * @param array $params Parameter array
     */
    function drawEnd($params) 
    {        
    }

    /**
     * Draw a line
     *
     * Parameter array:
     * 'x0': int X start point
     * 'y0': int Y start point
     * 'x1': int X end point
     * 'y1': int Y end point
     * 'end0': string [optional] The end type of end0 (the start)
     * 'end1': string [optional] The end type of end1 (the end)
     * 'size0': int [optional] The size of end0
     * 'size1': int [optional] The size of end1
     * 'color': mixed [optional] The line color
     * @param array $params Parameter array
     */
    function line($params)
    {
        $x0 = $this->_getX($params['x0']);
        $y0 = $this->_getY($params['y0']);
        $x1 = $this->_getX($params['x1']);
        $y1 = $this->_getY($params['y1']);
        if (isset($params['end0'])) {
            $angle = Image_Canvas_Tool::getAngle($x1, $y1, $x0, $y0);
            $this->drawEnd(
                array(
                    'end' => $params['end0'], 
                    'x' => $params['x0'], 
                    'y' => $params['y0'], 
                    'angle' => $angle,
                    'color' => (isset($params['color0']) ? $params['color0'] : false),
                    'size' => $params['size0']
                )
            );
        }    
        if (isset($params['end1'])) {
            $angle = Image_Canvas_Tool::getAngle($x0, $y0, $x1, $y1);
            //print "<pre>"; var_dump($params, $angle); print "</pre>";
            $this->drawEnd(
                array(
                    'end' => $params['end1'], 
                    'x' => $params['x1'], 
                    'y' => $params['y1'], 
                    'angle' => $angle,
                    'color' => (isset($params['color1']) ? $params['color1'] : false),
                    'size' => $params['size1']
                )
            );
        }    
        $this->_reset();
    }

    /**
     * Adds vertex to a polygon
     *
     * Parameter array:
     * 'x': int X point
     * 'y': int Y point
     * 'url': string [optional] URL to link the vertex to (must be used with 'map_vertices' in polygon() on a canvas that support image maps)
     * 'alt': string [optional] Alternative text to show in the image map (must be used with 'map_vertices' in polygon() on a canvas that support image maps)
     * 'target': string [optional] The link target on the image map (must be used with 'map_vertices' in polygon() on a canvas that support image maps)
     * 'mapsize': int [optional] The size of the "map", i.e. the size of the hot spot (must be used with 'map_vertices' in polygon() on a canvas that support image maps)
     * @param array $params Parameter array
     */
    function addVertex($params)
    {
        $params['X'] = $this->_getX($params['x']);
        $params['Y'] = $this->_getY($params['y']);
        $this->_polygon[] = $params;
    }

    /**
     * Adds "splined" vertex to a polygon
     *
     * Parameter array:
     * 'x': int X point
     * 'y': int Y point
     * 'p1x': int X Control point 1
     * 'p1y': int Y Control point 1
     * 'p2x': int X Control point 2
     * 'p2y': int Y Control point 2
     * 'url': string [optional] URL to link the vertex to (must be used with 'map_vertices' in polygon() on a canvas that support image maps)
     * 'alt': string [optional] Alternative text to show in the image map (must be used with 'map_vertices' in polygon() on a canvas that support image maps)
     * 'target': string [optional] The link target on the image map (must be used with 'map_vertices' in polygon() on a canvas that support image maps)
     * 'mapsize': int [optional] The size of the "map", i.e. the size of the hot spot (must be used with 'map_vertices' in polygon() on a canvas that support image maps)
     * @param array $params Parameter array
     */
    function addSpline($params)
    {
        $params['X'] = $this->_getX($params['x']);
        $params['Y'] = $this->_getY($params['y']);
        $params['P1X'] = $this->_getX($params['p1x']);
        $params['P1Y'] = $this->_getY($params['p1y']);
        $params['P2X'] = $this->_getX($params['p2x']);
        $params['P2Y'] = $this->_getY($params['p2y']);
        $this->_polygon[] = $params;
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
        $this->_reset();
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
        $this->_reset();
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
        $this->_reset();
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
        $this->_reset();
    }

    /**
     * Get the width of a text,
     *
     * @param string $text The text to get the width of
     * @return int The width of the text
     */
    function textWidth($text)
    {
    }

    /**
     * Get the height of a text,
     *
     * @param string $text The text to get the height of
     * @return int The height of the text
     */
    function textHeight($text)
    {
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
        $this->_reset();
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
    }
    
    /**
     * Set clipping to occur
     * 
     * Parameter array:
     * 
     * 'x0': int X point of Upper-left corner
     * 'y0': int X point of Upper-left corner
     * 'x1': int X point of lower-right corner
     * 'y1': int Y point of lower-right corner
     */
    function setClipping($params = false) 
    {
    }       

    /**
     * Start a group.
     *
     * What this does, depends on the canvas/format.
     *
     * @param string $name The name of the group
     */
    function startGroup($name = false)
    {
    }

    /**
     * End the "current" group.
     *
     * What this does, depends on the canvas/format.
     */
    function endGroup()
    {
    }   

    /**
     * Output the result of the canvas to the browser
     *
     * @param array $params Parameter array, the contents and meaning depends on the actual Canvas
     * @abstract
     */
    function show($params = false)
    {
        if ($params === false) {
            header('Expires: Tue, 2 Jul 1974 17:41:00 GMT'); // Date in the past
            header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1
            header('Pragma: no-cache');
        }
    }

    /**
     * Save the result of the canvas to a file
     *
     * Parameter array:
     * 'filename': string The file to output to
     * @param array $params Parameter array, the contents and meaning depends on the actual Canvas
     * @abstract
     */
    function save($params = false)
    {
    }

    /**
     * Get a canvas specific HTML tag.
     * 
     * This method implicitly saves the canvas to the filename in the 
     * filesystem path specified and parses it as URL specified by URL path
     * 
     * Parameter array:
     * 'filename': string
     * 'filepath': string Path to the file on the file system. Remember the final slash
     * 'urlpath': string Path to the file available through an URL. Remember the final slash
     */
    function toHtml($params)
    {
        $this->save(array('filename' => $params['filepath'] . $params['filename']));        
    }

    /**
     * Canvas factory method.
     *
     * Supported canvass are:
     *
     * 'png': output in PNG format (using GD)
     *
     * 'jpg': output in JPEG format (using GD)
     *
     * 'pdf': output in PDF format (using PDFlib)
     *
     * 'svg': output in SVG format
     * 
     * 'imagemap': output as a html image map
     *
     * An example of usage:
     * 
     * <code>
     * <?php
     * $Canvas =& Image_Graph::factory('png', 
     *     array('width' => 800, 'height' => 600, 'antialias' => 'native')
     * );
     * ?>
     * </code>
     *
     * @param string $canvas The canvas type
     * @param array $params The parameters for the canvas constructor
     * @return Image_Canvas The newly created canvas
     * @static
     */
    function &factory($canvas, $params)
    {
        $canvas = strtoupper($canvas);
        
        if (($canvas == 'PNG') || ($canvas == 'GD')) {
            $canvas = 'GD_PNG';
        }
        if (($canvas == 'JPG') || ($canvas == 'JPEG')) {
            $canvas = 'GD_JPG';
        }
        
        if ($canvas == 'IMAGEMAP') {
            $canvas = 'ImageMap';
        }

        $class = 'Image_Canvas_'. $canvas;
        include_once 'Image/Canvas/'. str_replace('_', '/', $canvas) . '.php';
        
        $obj =& new $class($params);
        return $obj;
    }

}

?>
