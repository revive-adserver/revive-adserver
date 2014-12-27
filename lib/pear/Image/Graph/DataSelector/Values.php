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
 * @subpackage DataSelector
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/DataSelector.php
 */
require_once 'Image/Graph/DataSelector.php';

/**
 * Filter out all but the specified values.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage DataSelector
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_DataSelector_Values extends Image_Graph_DataSelector {

    /**
     * The array with values that should be included
     * @var array
     * @access private
     */
    var $_values;

    /**
     * ValueArray [Constructor]
     *
     * @param array $valueArray The array to use as filter (default empty)
     */
    function &Image_Graph_DataSelector_Values($values)
    {
        parent::__construct();
        $this->_values = $values;
    }

    /**
     * Sets the array to use
     */
    function setValueArray($values)
    {
        $this->_values = $values;
    }

    /**
     * Check if a specified value should be 'selected', ie shown as a marker
     *
     * @param array $values The values to check
     * @return bool True if the Values should cause a marker to be shown, false
     *   if not
     * @access private
     */
     function _select($values)
     {
        return ( in_array($values['Y'], $this->_values) );
     }
}

?>
