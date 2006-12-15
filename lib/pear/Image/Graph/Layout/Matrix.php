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
 * @subpackage Layout
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Matrix.php,v 1.8 2005/08/24 20:35:58 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Layout.php
 */
require_once 'Image/Graph/Layout.php';

/**
 * Layout for displaying elements in a matix.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Layout
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Layout_Matrix extends Image_Graph_Layout
{

    /**
     * Layout matrix
     * @var array
     * @access private
     */
    var $_matrix = false;

    /**
     * The number of rows
     * @var int
     * @access private
     */
    var $_rows = false;

    /**
     * The number of columns
     * @var int
     * @access private
     */
    var $_cols = false;

    /**
     * Image_Graph_Layout_Matrix [Constructor]
     *
     * @param int $rows The number of rows
     * @param int $cols The number of cols
     * @param bool $autoCreate Specifies whether the matrix should automatically
     *   be filled with newly created Image_Graph_Plotares objects, or they will
     *   be added manually
     */
    function Image_Graph_Layout_Matrix($rows, $cols, $autoCreate = true)
    {
        parent::Image_Graph_Layout();

        $this->_rows = $rows;
        $this->_cols = $cols;
        if (($this->_rows > 0) && ($this->_cols > 0)) {
            $this->_matrix = array(array());
            for ($i = 0; $i < $this->_rows; $i++) {
                for ($j = 0; $j < $this->_cols; $j++) {
                    if ($autoCreate) {
                        $this->_matrix[$i][$j] =& $this->addNew('plotarea');
                        $this->_pushEdges($i, $j);
                    } else {
                        $this->_matrix[$i][$j] = false;
                    }
                }
            }
        }
    }

    /**
     * Pushes the edges on the specified position in the matrix
     *
     * @param int $row The row
     * @param int $col The column
     * @access private
     */
    function _pushEdges($row, $col)
    {
        if ((isset($this->_matrix[$row])) && (isset($this->_matrix[$row][$col]))) {
            $height = 100/$this->_rows;
            $width = 100/$this->_cols;
            if ($col > 0) {
                $this->_matrix[$row][$col]->_push('left', round($col*$width) . '%');
            }
            if ($col+1 < $this->_cols) {
                $this->_matrix[$row][$col]->_push('right', round(100-($col+1)*$width) . '%');
            }
            if ($row > 0) {
                $this->_matrix[$row][$col]->_push('top', round($row*$height) . '%');
            }
            if ($row+1 < $this->_rows) {
                $this->_matrix[$row][$col]->_push('bottom', round(100-($row+1)*$height) . '%');
            }
        }
    }

    /**
     * Get the area on the specified position in the matrix
     *
     * @param int $row The row
     * @param int $col The column
     * @return Image_Graph_Layout The element of position ($row, $col) in the
     *   matrix
     */
    function &getEntry($row, $col)
    {
        if ((isset($this->_matrix[$row])) && (isset($this->_matrix[$row][$col]))) {
            return $this->_matrix[$row][$col];
        } else {
            $result = null;
            return $result;
        }
    }

    /**
     * Get the area on the specified position in the matrix
     *
     * @param int $row The row
     * @param int $col The column
     * @param Image_Graph_Layout $element The element to set in the position
     *   ($row, $col) in the matrix
     */
    function setEntry($row, $col, &$element)
    {
        $this->_matrix[$row][$col] =& $element;
        $this->_pushEdges($row, $col);
    }

    /**
     * Update coordinates
     *
     * @access private
     */
    function _updateCoords()
    {
        for ($i = 0; $i < $this->_rows; $i++) {
            for ($j = 0; $j < $this->_cols; $j++) {
                $element =& $this->getEntry($i, $j);
                $this->add($element);
            }
        }
        parent::_updateCoords();
    }

    /**
     * Output the layout to the canvas
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        $result = true;
        for ($i = 0; $i < $this->_rows; $i++) {
            for ($j = 0; $j < $this->_cols; $j++) {
                $element =& $this->getEntry($i, $j);
                if ($element) {
                    if (!$element->_done()) {
                        $result = false;
                    }
                }
            }
        }
        return $result;
    }

}

?>