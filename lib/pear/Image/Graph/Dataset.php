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
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */


/**
 * Data set used to represent a data collection to plot in a chart
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Dataset
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 * @abstract
 */
class Image_Graph_Dataset
{

    /**
     * The pointer of the data set
     * @var int
     * @access private
     */
    var $_posX = 0;

    /**
     * The minimum X value of the dataset
     * @var int
     * @access private
     */
    var $_minimumX = 0;

    /**
     * The maximum X value of the dataset
     * @var int
     * @access private
     */
    var $_maximumX = 0;

    /**
     * The minimum Y value of the dataset
     * @var int
     * @access private
     */
    var $_minimumY = 0;

    /**
     * The maximum Y value of the dataset
     * @var int
     * @access private
     */
    var $_maximumY = 0;

    /**
     * The number of points in the dataset
     * @var int
     * @access private
     */
    var $_count = 0;

    /**
     * The name of the dataset, used for legending
     * @var string
     * @access private
     */
    var $_name = '';

    /**
     * Image_Graph_Dataset [Constructor]
     */
    function Image_Graph_Dataset()
    {
    }

    /**
     * Sets the name of the data set, used for legending
     *
     * @param string $name The name of the dataset
     */
    function setName($name)
    {
        $this->_name = $name;
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
        if ($y !== null) {
            if (is_array($y)) {
                $maxY = max($y);
                $minY = min($y);
            } else {
                $maxY = $y;
                $minY = $y;
            }
        }

        if ($this->_count) {
            $this->_minimumX = min($x, $this->_minimumX);
            $this->_maximumX = max($x, $this->_maximumX);
            if ($y !== null) {
                $this->_minimumY = min($minY, $this->_minimumY);
                $this->_maximumY = max($maxY, $this->_maximumY);
            }
        } else {
            $this->_minimumX = $x;
            $this->_maximumX = $x;
            if ($y !== null) {
                $this->_minimumY = $minY;
                $this->_maximumY = $maxY;
            }
        }

        $this->_count++;
    }

    /**
     * The number of values in the dataset
     *
     * @return int The number of values in the dataset
     */
    function count()
    {
        return $this->_count;
    }

    /**
     * Gets a X point from the dataset
     *
     * @param var $x The variable to return an X value from, fx in a vector
     *   function data set
     * @return var The X value of the variable
     * @access private
     */
    function _getPointX($x)
    {
        return $x;
    }

    /**
     * Gets a Y point from the dataset
     *
     * @param var $x The variable to return an Y value from, fx in a vector
     *   function data set
     * @return var The Y value of the variable
     * @access private
     */
    function _getPointY($x)
    {
        return $x;
    }

    /**
     * Gets a ID from the dataset
     *
     * @param var $x The variable to return an Y value from, fx in a vector
     *   function data set
     * @return var The ID value of the variable
     * @access private
     */
    function _getPointID($x)
    {
        return false;
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
        return false;
    }

    /**
     * The minimum X value
     *
     * @return var The minimum X value
     */
    function minimumX()
    {
        return $this->_minimumX;
    }

    /**
     * The maximum X value
     *
     * @return var The maximum X value
     */
    function maximumX()
    {
        return $this->_maximumX;
    }

    /**
     * The minimum Y value
     *
     * @return var The minimum Y value
     */
    function minimumY()
    {
        return $this->_minimumY;
    }

    /**
     * The maximum Y value
     *
     * @return var The maximum Y value
     */
    function maximumY()
    {
        return $this->_maximumY;
    }

    /**
     * The first point
     *
     * @return array The last point
     */
    function first()
    {
        return array('X' => $this->minimumX(), 'Y' => $this->minimumY());
    }

    /**
     * The last point
     *
     * @return array The first point
     */
    function last()
    {
        return array('X' => $this->maximumX(), 'Y' => $this->maximumY());
    }
    
    /**
     * The minimum X value
     *
     * @param var $value The minimum X value
     * @access private
     */
    function _setMinimumX($value)
    {
        $this->_minimumX = $value;
    }

    /**
     * The maximum X value
     *
     * @param var $value The maximum X value
     * @access private
     */
    function _setMaximumX($value)
    {
        $this->_maximumX = $value;
    }

    /**
     * The minimum Y value
     *
     * @param var $value The minimum X value
     * @access private
     */
    function _setMinimumY($value)
    {
        $this->_minimumY = $value;
    }

    /**
     * The maximum Y value
     *
     * @param var $value The maximum X value
     * @access private
     */
    function _setMaximumY($value)
    {
        $this->_maximumY = $value;
    }

    /**
     * The interval between 2 adjacent X values
     *
     * @return var The interval
     * @access private
     */
    function _stepX()
    {
        return 1;
    }

    /**
     * The interval between 2 adjacent Y values
     *
     * @return var The interval
     * @access private
     */
    function _stepY()
    {
        return 1;
    }

    /**
     * Reset the intertal dataset pointer
     *
     * @return var The first X value
     * @access private
     */
    function _reset()
    {
        $this->_posX = $this->_minimumX;
        return $this->_posX;
    }

    /**
     * Get a point close to the internal pointer
     *
     * @param int Step Number of points next to the internal pointer, negative
     *   Step is towards lower X values, positive towards higher X values
     * @return array The point
     * @access private
     */
    function _nearby($step = 0)
    {
        $x = $this->_getPointX($this->_posX + $this->_stepX() * $step);
        $y = $this->_getPointY($this->_posX + $this->_stepX() * $step);
        $ID = $this->_getPointID($this->_posX + $this->_stepX() * $step);
        $data = $this->_getPointData($this->_posX + $this->_stepX() * $step);
        if (($x === false) || ($y === false)) {
            return false;
        } else {
            return array ('X' => $x, 'Y' => $y, 'ID' => $ID, 'data' => $data);
        }
    }

    /**
     * Get the next point the internal pointer refers to and advance the pointer
     *
     * @return array The next point
     * @access private
     */
    function _next()
    {
        if ($this->_posX > $this->_maximumX) {
            return false;
        }

        $x = $this->_getPointX($this->_posX);
        $y = $this->_getPointY($this->_posX);
        $ID = $this->_getPointID($this->_posX);
        $data = $this->_getPointData($this->_posX);
        $this->_posX += $this->_stepX();

        return array ('X' => $x, 'Y' => $y, 'ID' => $ID, 'data' => $data);
    }

    /**
     * Get the average of the dataset's Y points
     *
     * @return var The Y-average across the dataset
     * @access private
     */
    function _averageY()
    {
        $posX = $this->_minimumX;
        $count = 0;
        $total = 0;
        while ($posX < $this->_maximumX) {
            $count ++;
            $total += $this->_getPointY($posX);
            $posX += $this->_stepX();
        }

        if ($count != 0) {
            return $total / $count;
        } else {
            return false;
        }
    }

    /**
     * Get the median of the array passed Y points
     *
     * @param array $data The data-array to get the median from
     * @param int $quartile The quartile to return the median from
     * @return var The Y-median across the dataset from the specified quartile
     * @access private
     */
    function _median($data, $quartile = 'second')
    {
        sort($data);
        $point = (count($data) - 1) / 2;

        if ($quartile == 'first') {
            $lowPoint = 0;
            $highPoint = floor($point);
        } elseif ($quartile == 'third') {
            $lowPoint = round($point);
            $highPoint = count($data) - 1;
        } else {
            $lowPoint = 0;
            $highPoint = count($data) - 1;
        }

        $point = ($lowPoint + $highPoint) / 2;

        if (floor($point) != $point) {
            $point = floor($point);
            return ($data[$point] + $data[($point + 1)]) / 2;
        } else {
            return $data[$point];
        }
    }

    /**
     * Get the median of the datasets Y points
     *
     * @param int $quartile The quartile to return the median from
     * @return var The Y-median across the dataset from the specified quartile
     * @access private
     */
    function _medianY($quartile = 'second')
    {
        $pointsY = array();
        $posX = $this->_minimumX;
        while ($posX <= $this->_maximumX) {
            $pointsY[] = $this->_getPointY($posX);
            $posX += $this->_stepX();
        }
        return $this->_median($pointsY, $quartile);
    }

}
?>
