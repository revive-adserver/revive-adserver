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
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Layout/Horizontal.php
 */
require_once 'Image/Graph/Layout/Horizontal.php';

/**
 * Layout for displaying two elements on top of each other.
 *
 * This splits the area contained by this element in two on top of each other
 * by a specified percentage (relative to the top). A layout can be nested.
 * Fx. a {@link Image_Graph_Layout_Horizontal} can layout two VerticalLayout's to
 * make a 2 by 2 matrix of 'element-areas'.
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
class Image_Graph_Layout_Vertical extends Image_Graph_Layout_Horizontal
{

    /**
     * Gets the absolute size of one of the parts.
     *
     * @param string $part The name of the part - auto_part(1|2)
     * @return int The number of pixels the edge should be pushed
	 * -
     * @access private
     */
    function _getAbsolute(&$part)
    {
        $part1Size = $this->_part1->_getAutoSize();
        $part2Size = $this->_part2->_getAutoSize();
        $this->_percentage = false;
        if (($part1Size !== false) and ($part2Size !== false)) {
            $height = $this->_fillHeight() * $part1Size / ($part1Size + $part2Size);
        } elseif ($part1Size !== false) {
            $height = $part1Size;
        } elseif ($part2Size !== false) {
            $height = -$part2Size;
        } else {
            $height = $this->_fillHeight() / 2;
        }

        if ($part == 'auto_part2') {
//            $height = $this->_fillHeight() - $height;
        }

        return $height;
    }

    /**
     * Splits the layout between the parts, by the specified percentage
     *
     * @access private
     */
    function _split()
    {
        if (($this->_part1) && ($this->_part2)) {
            if ($this->_percentage !== false) {
                $split1 = 100 - $this->_percentage;
                $split2 = $this->_percentage;
                $this->_part1->_push('bottom', "$split1%");
                $this->_part2->_push('top', "$split2%");
            } else {
                $this->_part1->_push('bottom', 'auto_part1');
                $this->_part2->_push('top', 'auto_part2');
            }
        }
    }

}

?>
