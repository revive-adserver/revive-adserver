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
 * @subpackage Dataset
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Dataset.php
 */
require_once 'Image/Graph/Dataset.php';

/**
 * Trivial data set, simply add points (x, y) 1 by 1
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Dataset
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Dataset_Trivial extends Image_Graph_Dataset
{

    /**
     * Data storage
     * @var array
     * @access private
     */
    var $_data;

    /**
     * Image_Graph_Dataset_Trivial [Constructor]
     *
     * Pass an associated array ($data[$x] = $y) to the constructor for easy
     * data addition. Alternatively (if multiple entries with same x value is
     * required) pass an array with (x, y) values: $data[$id] = array('x' => $x,
     * 'y' => $y);
     *
     * NB! If passing the 1st type array at this point, the x-values will also
     * be used for ID tags, i.e. when using {@link Image_Graph_Fill_Array}. In
     * the 2nd type the key/index of the "outermost" array will be the id tag
     * (i.e. $id in the example)
     *
     * @param array $dataArray An associated array with values to the dataset
     */
    function __construct($dataArray = false)
    {
        parent::__construct();
        $this->_data = array ();
        if (is_array($dataArray)) {
            reset($dataArray);
            $keys = array_keys($dataArray);
            foreach ($keys as $x) {
                $y =& $dataArray[$x];
                if ((is_array($y)) && (isset($y['x'])) && (isset($y['y']))) {
                    $this->addPoint($y['x'], $y['y'], (isset($y['id']) ? $y['id'] : $x));
                } else {
                    $this->addPoint($x, $y, $x);
                }
            }
        }
    }

    /**
     * Add a point to the dataset
     *
     * $ID can contain either the ID of the point, i.e. 'DK', 123, 'George', etc. or it can contain
     * values used for creation of the HTML image map. This is achieved using is an an associated array
     * with the following values:
     *
     * 'url' The URL to create the link to
     *
     * 'alt' [optional] The alt text on the link
     *
     * 'target' [optional] The target of the link
     *
     * 'htmltags' [optional] An associated array with html tags (tag as key), fx. 'onMouseOver' => 'history.go(-1);', 'id' => 'thelink'
     *
     * @param int $x The X value to add
     * @param int $y The Y value to add, can be omited
     * @param var $ID The ID of the point
     */
    function addPoint($x, $y = false, $ID = false)
    {
        parent::addPoint($x, $y, $ID);

        if (is_array($ID)) {
            $data = $ID;
            $ID = (isset($data['id']) ? $data['id'] : false);
        } else {
            $data = false;
        }

        $this->_data[] = array ('X' => $x, 'Y' => $y, 'ID' => $ID, 'data' => $data);
        if (!is_numeric($x)) {
            $this->_maximumX = count($this->_data);
        }
    }

    /**
     * The first point
     *
     * @return array The last point
     */
    function first()
    {
        reset($this->_data);
        return current($this->_data);
    }

    /**
     * The last point
     *
     * @return array The first point
     */
    function last()
    {
        return end($this->_data);
    }

    /**
     * Gets a X point from the dataset
     *
     * @param var $x The variable to return an X value from, fx in a
     *   vector function data set
     * @return var The X value of the variable
     * @access private
     */
    function _getPointX($x)
    {
        if (isset($this->_data[$x])) {
            return $this->_data[$x]['X'];
        } else {
            return false;
        }
    }

    /**
     * Gets a Y point from the dataset
     *
     * @param var $x The variable to return an Y value from, fx in a
     *   vector function data set
     * @return var The Y value of the variable
     * @access private
     */
    function _getPointY($x)
    {
        if (isset($this->_data[$x])) {
            return $this->_data[$x]['Y'];
        } else {
            return false;
        }
    }

    /**
     * Gets a ID from the dataset
     *
     * @param var $x The variable to return an Y value from, fx in a
     *   vector function data set
     * @return var The ID value of the variable
     * @access private
     */
    function _getPointID($x)
    {
        if (isset($this->_data[$x])) {
            return $this->_data[$x]['ID'];
        } else {
            return false;
        }
    }

    /**
     * Gets point data from the dataset
     *
     * @param var $x The variable to return an Y value from, fx in a vector
     *   function data set
     * @return array The data for the point
     * @access private
     */
    function _getPointData($x)
    {
        if (isset($this->_data[$x])) {
            return $this->_data[$x]['data'];
        } else {
            return false;
        }
    }

    /**
     * The number of values in the dataset
     *
     * @return int The number of values in the dataset
     */
    function count()
    {
        return count($this->_data);
    }

    /**
     * Reset the intertal dataset pointer
     *
     * @return var The first X value
     * @access private
     */
    function _reset()
    {
        $this->_posX = 0;
        return $this->_posX;
    }

    /**
     * Get the next point the internal pointer refers to and advance the pointer
     *
     * @return array The next point
     * @access private
     */
    function _next()
    {
        if ($this->_posX >= $this->count()) {
            return false;
        }
        $x = $this->_getPointX($this->_posX);
        $y = $this->_getPointY($this->_posX);
        $ID = $this->_getPointID($this->_posX);
        $data = $this->_getPointData($this->_posX);
        $this->_posX += $this->_stepX();

        return array('X' => $x, 'Y' => $y, 'ID' => $ID, 'data' => $data);
    }

}

?>
