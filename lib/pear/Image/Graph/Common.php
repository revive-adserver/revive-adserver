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
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */

if (!function_exists('is_a')) {

    /**
     * Check if an object is of a given class, this function is available as of PHP 4.2.0, so if it exist it will not be declared
     *
     * @link http://www.php.net/manual/en/function.is-a.php PHP.net Online Manual for function is_a()
     * @param object $object The object to check class for
     * @param string $class_name The name of the class to check the object for
     * @return bool Returns TRUE if the object is of this class or has this class as one of its parents
     */
    function is_a($object, $class_name)
    {
        if (empty ($object)) {
            return false;
        }
        $object = is_object($object) ? get_class($object) : $object;
        if (strtolower($object) == strtolower($class_name)) {
            return true;
        }
        return is_a(get_parent_class($object), $class_name);
    }
}

/**
 * Include file Image/Canvas.php
 */
require_once 'Image/Canvas.php';

/**
 * The ultimate ancestor of all Image_Graph classes.
 *
 * This class contains common functionality needed by all Image_Graph classes.
 *
 * @category   Images
 * @package    Image_Graph
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 * @abstract
 */
class Image_Graph_Common
{

    /**
     * The parent container of the current Image_Graph object
     *
     * @var Image_Graph_Common
     * @access private
     */
    var $_parent = null;

    /**
     * The sub-elements of the current Image_Graph container object
     *
     * @var array
     * @access private
     */
    var $_elements;

    /**
     * The canvas for output.
     *
     * Enables support for multiple output formats.
     *
     * @var Image_Canvas
     * @access private
     */
    var $_canvas = null;
    
    /**
     * Is the object visible?
     * 
     * @var bool
     * @access private
     */
    var $_visible = true;

    /**
     * Constructor [Image_Graph_Common]
     */
    function Image_Graph_Common()
    {
    }

    /**
     * Resets the elements
     *
     * @access private
     */
    function _reset()
    {
        if (is_array($this->_elements)) {
            $keys = array_keys($this->_elements);
            foreach ($keys as $key) {
                if (is_object($this->_elements[$key])) {
                    $this->_elements[$key]->_setParent($this);
                    $result =& $this->_elements[$key]->_reset();
                    if (PEAR::isError($result)) {
                        return $result;
                    }
                }
            }
            unset($keys);
        }
        return true;
    }

    /**
     * Sets the parent. The parent chain should ultimately be a GraPHP object
     *
     * @see Image_Graph_Common
     * @param Image_Graph_Common $parent The parent
     * @access private
     */
    function _setParent(& $parent)
    {
        $this->_parent =& $parent;
        $this->_canvas =& $this->_parent->_getCanvas();

        if (is_array($this->_elements)) {
            $keys = array_keys($this->_elements);
            foreach ($keys as $key) {
                if (is_object($this->_elements[$key])) {
                    $this->_elements[$key]->_setParent($this);
                }
            }
            unset($keys);
        }
    }

    /**
     * Hide the element
     */
    function hide()
    {
        $this->_visible = false;
    }        

    /**
     * Get the canvas
     *
     * @return Image_Canvas The canvas
     * @access private
     */
    function &_getCanvas()
    { 
        if (($this->_canvas !== null) || ($this->_canvas !== false)) {
            return $this->_canvas;
        } elseif (is_a($this->_parent, 'Image_Graph_Common')) {
            $this->_canvas =& $this->_parent->_getCanvas();
            return $this->_canvas;
        } else {
            $this->_error('Invalid canvas');
            $result = null;
            return $result;
        }
    }

    /**
     * Adds an element to the objects element list.
     *
     * The new Image_Graph_elements parent is automatically set.
     *
     * @param Image_Graph_Common $element The new Image_Graph_element
     * @return Image_Graph_Common The new Image_Graph_element
     */
    function &add(& $element)
    {
        if (!is_a($element, 'Image_Graph_Font')) {
            $this->_elements[] = &$element;
        }
        $element->_setParent($this);
        return $element;
    }

    /**
     * Creates an object from the class and adds it to the objects element list.
     *
     * Creates an object from the class specified and adds it to the objects
     * element list. If only one parameter is required for the constructor of
     * the class simply pass this parameter as the $params parameter, unless the
     * parameter is an array or a reference to a value, in that case you must
     * 'enclose' the parameter in an array. Similar if the constructor takes
     * more than one parameter specify the parameters in an array.
     *
     * @see Image_Graph::factory()
     * @param string $class The class for the object
     * @param mixed $params The paramaters to pass to the constructor
     * @return Image_Graph_Common The new Image_Graph_element
     */
    function &addNew($class, $params = null, $additional = false)
    {
        include_once 'Image/Graph.php';
        $element =& Image_Graph::factory($class, $params);
        if ($additional === false) {
            $obj =& $this->add($element);
        } else {
            $obj =& $this->add($element, $additional);
        }
        return $obj;
    }

    /**
     * Shows an error message box on the canvas
     *
     * @param string $text The error text
     * @param array $params An array containing error specific details
     * @param int $error_code Error code
     * @access private
     */
    function _error($text, $params = false, $error_code = IMAGE_GRAPH_ERROR_GENERIC)
    {       
        if ((is_array($params)) && (count($params) > 0)) {
            foreach ($params as $name => $key) {
                if (isset($parameters)) {
                    $parameters .= ' ';
                } 
                else {
                    $parameters = '';
                }
                $parameters .= $name . '=' . $key;
            }
        }        
        $error =& PEAR::raiseError(
            $text .
            ($error_code != IMAGE_GRAPH_ERROR_GENERIC ? ' error:' . IMAGE_GRAPH_ERROR_GENERIC : '') .
            (isset($parameters) ? ' parameters:[' . $parameters . ']' : '')            
        );         
    }

    /**
     * Causes the object to update all sub elements coordinates
     *
     * (Image_Graph_Common, does not itself have coordinates, this is basically
     * an abstract method)
     *
     * @access private
     */
    function _updateCoords()
    {
        if (is_array($this->_elements)) {
            $keys = array_keys($this->_elements);
            foreach ($keys as $key) {
                if (is_object($this->_elements[$key])) {
                    $this->_elements[$key]->_updateCoords();
                }
            }
            unset($keys);
        }
        return true;
    }

    /**
     * Causes output to canvas
     *
     * The last method to call. Calling Done causes output to the canvas. All
     * sub elements done() method will be invoked
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        if (($this->_canvas == null) || (!is_a($this->_canvas, 'Image_Canvas'))) {
            return false;
        }

        if (is_array($this->_elements)) {
            $keys = array_keys($this->_elements);
            foreach ($keys as $key) {
                if (($this->_elements[$key]->_visible) && ($this->_elements[$key]->_done() === false)) {
                    return false;
                }
            }
            unset($keys);
        }
        return true;
    }

}

?>
