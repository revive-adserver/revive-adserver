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
 * @subpackage DataPreprocessor
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Array.php,v 1.6 2005/08/24 20:35:59 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */
 
/**
 * Include file Image/Graph/DataPreprocessor.php
 */
require_once 'Image/Graph/DataPreprocessor.php';

/**
 * Format data as looked up in an array.
 *
 * ArrayData is useful when a numercal value is to be translated to
 * something thats cannot directly be calculated from this value, this could for
 * example be a dataset meant to plot population of various countries. Since x-
 * values are numerical and they should really be country names, but there is no
 * linear correlation between the number and the name, we use an array to 'map'
 * the numbers to the name, i.e. $array[0] = 'Denmark'; $array[1] = 'Sweden';
 * ..., where the indexes are the numerical values from the dataset. This is NOT
 * usefull when the x-values are a large domain, i.e. to map unix timestamps to
 * date-strings for an x-axis. This is because the x-axis will selecte arbitrary
 * values for labels, which would in principle require the ArrayData to hold
 * values for every unix timestamp. However ArrayData can still be used to solve
 * such a situation, since one can use another value for X-data in the dataset
 * and then map this (smaller domain) value to a date. That is we for example
 * instead of using the unix-timestamp we use value 0 to represent the 1st date,
 * 1 to represent the next date, etc.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage DataPreprocessor
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_DataPreprocessor_Array extends Image_Graph_DataPreprocessor
{

    /**
     * The data label array
     * @var array
     * @access private
     */
    var $_dataArray;

    /**
     * Image_Graph_ArrayData [Constructor].
     *
     * @param array $array The array to use as a lookup table
     */
    function Image_Graph_DataPreprocessor_Array($array)
    {
        parent::Image_Graph_DataPreprocessor();
        $this->_dataArray = $array;
    }

    /**
     * Process the value
     *
     * @param var $value The value to process/format
     * @return string The processed value
     * @access private
     */
    function _process($value)
    {
        if ((is_array($this->_dataArray)) && (isset ($this->_dataArray[$value]))) {
            return $this->_dataArray[$value];
        } else {
            return $value;
        }
    }

}

?>