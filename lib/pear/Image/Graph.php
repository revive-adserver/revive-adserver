<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Graph - Main class for the graph creation.
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
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Graph.php,v 1.58 2005/11/27 18:48:05 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */


/**
 * Include PEAR.php
 */
require_once 'PEAR.php';

/**
 * Include file Image/Graph/Element.php
 */
require_once 'Image/Graph/Element.php';

/**
 * Include file Image/Graph/Constants.php
 */
require_once 'Image/Graph/Constants.php';

/**
 * Main class for the graph creation.
 *
 * This is the main class, it manages the canvas and performs the final output
 * by sequentialy making the elements output their results. The final output is
 * handled using the {@link Image_Canvas} classes which makes it possible
 * to use different engines (fx GD, PDFlib, libswf, etc) for output to several
 * formats with a non-intersecting API.
 *
 * This class also handles coordinates and the correct managment of setting the
 * correct coordinates on child elements.
 *
 * @category   Images
 * @package    Image_Graph
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph extends Image_Graph_Element
{

    /**
     * Show generation time on graph
     * @var bool
     * @access private
     */
    var $_showTime = false;

    /**
     * Display errors on the canvas
     * @var boolean
     * @access private
     */
    var $_displayErrors = false;

    /**
     * Image_Graph [Constructor].
     *
     * If passing the 3 parameters they are defined as follows:'
     * 
     * Fx.:
     * 
     * $Graph =& new Image_Graph(400, 300);
     * 
     * or using the factory method:
     * 
     * $Graph =& Image_Graph::factory('graph', array(400, 300));
     * 
     * This causes a 'png' canvas to be created by default. 
     * 
     * Otherwise use a single parameter either as an associated array or passing
     * the canvas along to the constructor:
     *
     * 1) Create a new canvas with the following parameters:
     *
     * 'canvas' - The canvas type, can be any of 'gd', 'jpg', 'png' or 'svg'
     * (more to come) - if omitted the default is 'gd'
     *
     * 'width' - The width of the graph
     *
     * 'height' - The height of the graph
     * 
     * An example of this usage:
     * 
     * $Graph =& Image_Graph::factory('graph', array(array('width' => 400,
     * 'height' => 300, 'canvas' => 'jpg')));
     * 
     * NB! In thïs case remember the "double" array (see {@link Image_Graph::
     * factory()})
     * 
     * 2) Use the canvas specified, pass a valid Image_Canvas as
     * parameter. Remember to pass by reference, i. e. &amp;$canvas, fx.:
     *
     * $Graph =& new Image_Graph($Canvas);
     *
     * or using the factory method:
     *
     * $Graph =& Image_Graph::factory('graph', $Canvas));
     *
     * @param mixed $params The width of the graph, an indexed array
     * describing a new canvas or a valid {@link Image_Canvas} object
     * @param int $height The height of the graph in pixels
     * @param bool $createTransparent Specifies whether the graph should be
     *   created with a transparent background (fx for PNG's - note: transparent
     *   PNG's is not supported by Internet Explorer!)
     */
    function Image_Graph($params, $height = false, $createTransparent = false)
    {
        parent::Image_Graph_Element();

        $this->setFont(Image_Graph::factory('Image_Graph_Font'));

        if (defined('IMAGE_GRAPH_DEFAULT_CANVAS_TYPE')) {
            $canvasType = IMAGE_GRAPH_DEFAULT_CANVAS_TYPE;
        } else {
            $canvasType = 'png'; // use GD as default, if nothing else is specified
        }

        if (is_array($params)) {
            if (isset($params['canvas'])) {
                $canvasType = $params['canvas'];
            }

            $width = 0;
            $height = 0;

            if (isset($params['width'])) {
                $width = $params['width'];
            }

            if (isset($params['height'])) {
                $height = $params['height'];
            }
        } elseif (is_a($params, 'Image_Canvas')) {
            $this->_canvas =& $params;
            $width = $this->_canvas->getWidth();
            $height = $this->_canvas->getHeight();
        } elseif (is_numeric($params)) {
            $width = $params;
        }

        if ($this->_canvas == null) {
            include_once 'Image/Canvas.php';
            $this->_canvas =&
                Image_Canvas::factory(
                    $canvasType,
                    array('width' => $width, 'height' => $height)
                );
        }

        $this->_setCoords(0, 0, $width - 1, $height - 1);
    }

    /**
     * Gets the canvas for this graph.
     *
     * The canvas is set by either passing it to the constructor {@link
     * Image_Graph::ImageGraph()} or using the {@link Image_Graph::setCanvas()}
     * method.
     *
     * @return Image_Canvas The canvas used by this graph
     * @access private
     * @since 0.3.0dev2
     */
    function &_getCanvas()
    {
        return $this->_canvas;
    }

    /**
     * Sets the canvas for this graph.
     *
     * Calling this method makes this graph use the newly specified canvas for
     * handling output. This method should be called whenever multiple
     * 'outputs' are required. Invoke this method after calls to {@link
     * Image_Graph:: done()} has been performed, to switch canvass.
     *
     * @param Image_Canvas $canvas The new canvas
     * @return Image_Canvas The new canvas
     * @since 0.3.0dev2
     */
    function &setCanvas(&$canvas)
    {
        if (!is_a($this->_canvas, 'Image_Canvas')) {
            return $this->_error('The canvas introduced is not an Image_Canvas object');
        }
        
        $this->_canvas =& $canvas;
        $this->_setCoords(
            0,
            0,
            $this->_canvas->getWidth() - 1,
            $this->_canvas->getHeight() - 1
        );
        return $this->_canvas;
    }

    /**
     * Gets a very precise timestamp
     *
     * @return The number of seconds to a lot of decimals
     * @access private
     */
    function _getMicroTime()
    {
        list($usec, $sec) = explode(' ', microtime()); 
        return ((float)$usec + (float)$sec); 
    }

    /**
     * Gets the width of this graph.
     *
     * The width is returned as 'defined' by the canvas.
     *
     * @return int the width of this graph
     */
    function width()
    {
        return $this->_canvas->getWidth();
    }

    /**
     * Gets the height of this graph.
     *
     * The height is returned as 'defined' by the canvas.
     *
     * @return int the height of this graph
     */
    function height()
    {
        return $this->_canvas->getHeight();
    }

    /**
     * Enables displaying of errors on the output.
     *
     * Use this method to enforce errors to be displayed on the output. Calling
     * this method makes PHP uses this graphs error handler as default {@link
     * Image_Graph::_default_error_handler()}.
     */
    function displayErrors()
    {
        $this->_displayErrors = true;
        set_error_handler(array(&$this, '_default_error_handler'));
    }

    /**
     * Sets the log method for this graph.
     *
     * Use this method to enable logging. This causes any errors caught
     * by either the error handler {@see Image_Graph::displayErrors()}
     * or explicitly by calling {@link Image_Graph_Common::_error()} be
     * logged using the specified logging method.
     *
     * If a filename is specified as log method, a Log object is created (using
     * the 'file' handler), with a handle of 'Image_Graph Error Log'.
     *
     * Logging requires {@link Log}.
     *
     * @param mixed $log The log method, either a Log object or filename to log
     * to
	 * @since 0.3.0dev2
     */
    function setLog($log)
    {
    }

    /**
     * Factory method to create Image_Graph objects.
     *
     * Used for 'lazy including', i.e. loading only what is necessary, when it
     * is necessary. If only one parameter is required for the constructor of
     * the class simply pass this parameter as the $params parameter, unless the
     * parameter is an array or a reference to a value, in that case you must
     * 'enclose' the parameter in an array. Similar if the constructor takes
     * more than one parameter specify the parameters in an array, i.e
     *
     * Image_Graph::factory('MyClass', array($param1, $param2, &$param3));
     *
     * Variables that need to be passed by reference *must* have the &amp;
     * before the variable, i.e:
     *
     * Image_Graph::factory('line', &$Dataset);
     *
     * or
     *
     * Image_graph::factory('bar', array(array(&$Dataset1, &$Dataset2),
     * 'stacked'));
     *
     * Class name can be either of the following:
     *
     * 1 The 'real' Image_Graph class name, i.e. Image_Graph_Plotarea or
     * Image_Graph_Plot_Line
     *
     * 2 Short class name (leave out Image_Graph) and retain case, i.e.
     * Plotarea, Plot_Line *not* plot_line
     *
     * 3 Class name 'alias', the following are supported:
     *
     * 'graph' = Image_Graph
     *
     * 'plotarea' = Image_Graph_Plotarea
     *
     * 'line' = Image_Graph_Plot_Line
     *
     * 'area' = Image_Graph_Plot_Area
     *
     * 'bar' = Image_Graph_Plot_Bar
     *
     * 'pie' = Image_Graph_Plot_Pie
     *
     * 'radar' = Image_Graph_Plot_Radar
     *
     * 'step' = Image_Graph_Plot_Step
     *
     * 'impulse' = Image_Graph_Plot_Impulse
     *
     * 'dot' or 'scatter' = Image_Graph_Plot_Dot
     *
     * 'smooth_line' = Image_Graph_Plot_Smoothed_Line
     *
     * 'smooth_area' = Image_Graph_Plot_Smoothed_Area

     * 'dataset' = Image_Graph_Dataset_Trivial
     *
     * 'random' = Image_Graph_Dataset_Random
     *
     * 'function' = Image_Graph_Dataset_Function
     *
     * 'vector' = Image_Graph_Dataset_VectorFunction
     *
     * 'category' = Image_Graph_Axis_Category
     *
     * 'axis' = Image_Graph_Axis
     *
     * 'axis_log' = Image_Graph_Axis_Logarithmic
     *
     * 'title' = Image_Graph_Title
     *
     * 'line_grid' = Image_Graph_Grid_Lines
     *
     * 'bar_grid' = Image_Graph_Grid_Bars
     *
     * 'polar_grid' = Image_Graph_Grid_Polar
     *
     * 'legend' = Image_Graph_Legend
     *
     * 'font' = Image_Graph_Font
     *
     * 'ttf_font' = Image_Graph_Font
     * 
     * 'Image_Graph_Font_TTF' = Image_Graph_Font (to maintain BC with Image_Graph_Font_TTF)
     *
     * 'gradient' = Image_Graph_Fill_Gradient
     *
     * 'icon_marker' = Image_Graph_Marker_Icon
     *
     * 'value_marker' = Image_Graph_Marker_Value
     *
     * @param string $class The class for the new object
     * @param mixed $params The paramaters to pass to the constructor
     * @return object A new object for the class
     * @static
     */
    function &factory($class, $params = null)
    {
    	static $Image_Graph_classAliases = array(
			'graph'          => 'Image_Graph',
			'plotarea'       => 'Image_Graph_Plotarea',            

			'line'           => 'Image_Graph_Plot_Line',
			'area'           => 'Image_Graph_Plot_Area',
			'bar'            => 'Image_Graph_Plot_Bar',
			'smooth_line'    => 'Image_Graph_Plot_Smoothed_Line',
			'smooth_area'    => 'Image_Graph_Plot_Smoothed_Area',
			'pie'            => 'Image_Graph_Plot_Pie',
			'radar'          => 'Image_Graph_Plot_Radar',
			'step'           => 'Image_Graph_Plot_Step',
			'impulse'        => 'Image_Graph_Plot_Impulse',
			'dot'            => 'Image_Graph_Plot_Dot',
            'scatter'        => 'Image_Graph_Plot_Dot',

			'dataset'        => 'Image_Graph_Dataset_Trivial',
			'random'         => 'Image_Graph_Dataset_Random',
			'function'       => 'Image_Graph_Dataset_Function',
			'vector'         => 'Image_Graph_Dataset_VectorFunction',

            'category'       => 'Image_Graph_Axis_Category',
			'axis'           => 'Image_Graph_Axis',
			'axis_log'       => 'Image_Graph_Axis_Logarithmic',

			'title'          => 'Image_Graph_Title',

			'line_grid'      => 'Image_Graph_Grid_Lines',
			'bar_grid'       => 'Image_Graph_Grid_Bars',
			'polar_grid'     => 'Image_Graph_Grid_Polar',

			'legend'         => 'Image_Graph_Legend',
			'font'			 => 'Image_Graph_Font',
			'ttf_font'       => 'Image_Graph_Font',
			'Image_Graph_Font_TTF' => 'Image_Graph_Font', // BC with Image_Graph_Font_TTF
			'gradient'       => 'Image_Graph_Fill_Gradient',

			'icon_marker'    => 'Image_Graph_Marker_Icon',
			'value_marker'   => 'Image_Graph_Marker_Value'
		);
    		    		    	
        if (substr($class, 0, 11) != 'Image_Graph') {
        	if (isset($Image_Graph_classAliases[$class])) {
        		$class = $Image_Graph_classAliases[$class];
        	} else {
        		$class = 'Image_Graph_' . $class;
        	}
        }

        include_once str_replace('_', '/', $class) . '.php';

        $obj = null;

        if (is_array($params)) {
            switch (count($params)) {
            case 1:
                $obj =& new $class(
                    $params[0]
                );
                break;

            case 2:
                $obj =& new $class(
                    $params[0],
                    $params[1]
                );
                break;

            case 3:
                $obj =& new $class(
                    $params[0],
                    $params[1],
                    $params[2]
                );
                break;

            case 4:
                $obj =& new $class(
                    $params[0],
                    $params[1],
                    $params[2],
                    $params[3]
                );
                break;

            case 5:
                $obj =& new $class(
                    $params[0],
                    $params[1],
                    $params[2],
                    $params[3],
                    $params[4]
                );
                break;

            case 6:
                $obj =& new $class(
                    $params[0],
                    $params[1],
                    $params[2],
                    $params[3],
                    $params[4],
                    $params[5]
                );
                break;

            case 7:
                $obj =& new $class(
                    $params[0],
                    $params[1],
                    $params[2],
                    $params[3],
                    $params[4],
                    $params[5],
                    $params[6]
                );
                break;

            case 8:
                $obj =& new $class(
                    $params[0],
                    $params[1],
                    $params[2],
                    $params[3],
                    $params[4],
                    $params[5],
                    $params[6],
                    $params[7]
                );
                break;

            case 9:
                $obj =& new $class(
                    $params[0],
                    $params[1],
                    $params[2],
                    $params[3],
                    $params[4],
                    $params[5],
                    $params[6],
                    $params[7],
                    $params[8]
                );
                break;

            case 10:
                $obj =& new $class(
                    $params[0],
                    $params[1],
                    $params[2],
                    $params[3],
                    $params[4],
                    $params[5],
                    $params[6],
                    $params[7],
                    $params[8],
                    $params[9]
                );
                break;

            default:
                $obj =& new $class();
                break;

            }
        } else {
            if ($params == null) {
                $obj =& new $class();
            } else {
                $obj =& new $class($params);
            }
    	}
        return $obj;
    }

    /**
     * Factory method to create layouts.
     *
     * This method is used for easy creation, since using {@link Image_Graph::
     * factory()} does not work with passing newly created objects from
     * Image_Graph::factory() as reference, this is something that is
     * fortunately fixed in PHP5. Also used for 'lazy including', i.e. loading
     * only what is necessary, when it is necessary.
     *
     * Use {@link Image_Graph::horizontal()} or {@link Image_Graph::vertical()}
     * instead for easier access.
     *
     * @param mixed $layout The type of layout, can be either 'Vertical'
     *   or 'Horizontal' (case sensitive)
     * @param Image_Graph_Element $part1 The 1st part of the layout
     * @param Image_Graph_Element $part2 The 2nd part of the layout
     * @param int $percentage The percentage of the layout to split at
     * @return Image_Graph_Layout The newly created layout object
     * @static
     */
    function &layoutFactory($layout, &$part1, &$part2, $percentage = 50)
    {
        if (($layout != 'Vertical') && ($layout != 'Horizontal')) {
            return $this->_error('Layouts must be either \'Horizontal\' or \'Vertical\'');
        }
        
        if (!(is_a($part1, 'Image_Graph_Element'))) {
            return $this->_error('Part 1 is not a valid Image_Graph element');
        }
        
        if (!(is_a($part2, 'Image_Graph_Element'))) {
            return $this->_error('Part 2 is not a valid Image_Graph element');
        }
        
        if ((!is_numeric($percentage)) || ($percentage < 0) || ($percentage > 100)) {
            return $this->_error('Percentage has to be a number between 0 and 100');
        }
        
        include_once "Image/Graph/Layout/$layout.php";
        $class = "Image_Graph_Layout_$layout";
        $obj =& new $class($part1, $part2, $percentage);
        return $obj;
    }

    /**
     * Factory method to create horizontal layout.
     *
     * See {@link Image_Graph::layoutFactory()}
     *
     * @param Image_Graph_Element $part1 The 1st (left) part of the layout
     * @param Image_Graph_Element $part2 The 2nd (right) part of the layout
     * @param int $percentage The percentage of the layout to split at
     *   (percentage of total height from the left side)
     * @return Image_Graph_Layout The newly created layout object
     * @static
     */
    function &horizontal(&$part1, &$part2, $percentage = 50)
    {
        $obj =& Image_Graph::layoutFactory('Horizontal', $part1, $part2, $percentage);
        return $obj;
    }

    /**
     * Factory method to create vertical layout.
     *
     * See {@link Image_Graph::layoutFactory()}
     *
     * @param Image_Graph_Element $part1 The 1st (top) part of the layout
     * @param Image_Graph_Element $part2 The 2nd (bottom) part of the layout
     * @param int $percentage The percentage of the layout to split at
     *   (percentage of total width from the top edge)
     * @return Image_Graph_Layout The newly created layout object
     * @static
     */
    function &vertical(&$part1, &$part2, $percentage = 50)
    {
        $obj =& Image_Graph::layoutFactory('Vertical', $part1, $part2, $percentage);
        return $obj;
    }

    /**
     * The error handling routine set by set_error_handler().
     *
     * This method is used internaly by Image_Graph and PHP as a proxy for {@link
     * Image_Graph::_error()}. 
     *
     * @param string $error_type The type of error being handled.
     * @param string $error_msg The error message being handled.
     * @param string $error_file The file in which the error occurred.
     * @param integer $error_line The line in which the error occurred.
     * @param string $error_context The context in which the error occurred.
     * @access private
     */
    function _default_error_handler($error_type, $error_msg, $error_file, $error_line, $error_context)
    {
        switch( $error_type ) {
        case E_ERROR:
            $level = 'error';
            break;

        case E_USER_ERROR:
            $level = 'user error';
            break;

        case E_WARNING:
            $level = 'warning';
            break;

        case E_USER_WARNING:
            $level = 'user warning';
            break;

        case E_NOTICE:
            $level = 'notice';
            break;

        case E_USER_NOTICE:
            $level = 'user notice';
            break;

        default:
            $level = '(unknown)';
            break;

        }

        $this->_error("PHP $level: $error_msg",
            array(
                'type' => $error_type,
                'file' => $error_file,
                'line' => $error_line,
                'context' => $error_context
            )
        );
    }

    /**
     * Displays the errors on the error stack.
     *
     * Invoking this method cause all errors on the error stack to be displayed
     * on the graph-output, by calling the {@link Image_Graph::_displayError()}
     * method.
     *
     * @access private
     */
    function _displayErrors()
    {
        return true;
    }

    /**
     * Display an error from the error stack.
     *
     * This method writes error messages caught from the {@link Image_Graph::
     * _default_error_handler()} if {@Image_Graph::displayErrors()} was invoked,
     * and the error explicitly set by the system using {@link
     * Image_Graph_Common::_error()}.
     *
     * @param int $x The horizontal position of the error message
     * @param int $y The vertical position of the error message
     * @param array $error The error context
     *
     * @access private
     */
    function _displayError($x, $y, $error)
    {
    }

    /**
     * Outputs this graph using the canvas.
     *
     * This causes the graph to make all elements perform their output. Their
     * result is 'written' to the output using the canvas, which also performs
     * the actual output, fx. it being to a file or directly to the browser
     * (in the latter case, the canvas will also make sure the correct HTTP
     * headers are sent, making the browser handle the output correctly, if
     * supported by it).
     * 
     * Parameters are the ones supported by the canvas, common ones are:
     * 
     * 'filename' To output to a file instead of browser
     * 
     * 'tohtml' Return a HTML string that encompasses the current graph/canvas - this
     * implies an implicit save using the following parameters: 'filename' The "temporary"
     * filename of the graph, 'filepath' A path in the file system where Image_Graph can
     * store the output (this file must be in DOCUMENT_ROOT scope), 'urlpath' The URL that the
     * 'filepath' corresponds to (i.e. filepath + filename must be reachable from a browser using
     * urlpath + filename) 
     *
     * @param mixed $param The output parameters to pass to the canvas
     * @return bool Was the output 'good' (true) or 'bad' (false).
     */
    function done($param = false)
    {
        $result = $this->_reset();
        if (PEAR::isError($result)) {
            return $result;
        }
        return $this->_done($param);
    }

    /**
     * Outputs this graph using the canvas.
     *
     * This causes the graph to make all elements perform their output. Their
     * result is 'written' to the output using the canvas, which also performs
     * the actual output, fx. it being to a file or directly to the browser
     * (in the latter case, the canvas will also make sure the correct HTTP
     * headers are sent, making the browser handle the output correctly, if
     * supported by it).
     *
     * @param mixed $param The output parameters to pass to the canvas
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done($param = false)
    {
        $timeStart = $this->_getMicroTime();

        if ($this->_shadow) {
            $this->setPadding(20);
            $this->_setCoords(
                $this->_left,
                $this->_top,
                $this->_right - 10,
                $this->_bottom - 10);
        }

        $result = $this->_updateCoords();        
        if (PEAR::isError($result)) {
            return $result;
        }

        if ($this->_getBackground()) {
            $this->_canvas->rectangle(
            	array(
                	'x0' => $this->_left,
                	'y0' => $this->_top,
                	'x1' => $this->_right,
                	'y1' => $this->_bottom
                )
            );
        }

        $result = parent::_done();
        if (PEAR::isError($result)) {
            return $result;
        }

        if ($this->_displayErrors) {
            $this->_displayErrors();
        }

        $timeEnd = $this->_getMicroTime();

        if (($this->_showTime) || 
            ((isset($param['showtime'])) && ($param['showtime'] === true))
        ) {
            $text = 'Generated in ' .
                sprintf('%0.3f', $timeEnd - $timeStart) . ' sec';
            $this->write(
                $this->_right,
                $this->_bottom,
                $text,
                IMAGE_GRAPH_ALIGN_RIGHT + IMAGE_GRAPH_ALIGN_BOTTOM,
                array('color' => 'red')
            );
        }
               
		if (isset($param['filename'])) {
            if ((isset($param['tohtml'])) && ($param['tohtml'])) {
                return $this->_canvas->toHtml($param);
            }
            else {
                return $this->_canvas->save($param);
            }
		} else {
			return $this->_canvas->show($param);
		}
    }
}

?>