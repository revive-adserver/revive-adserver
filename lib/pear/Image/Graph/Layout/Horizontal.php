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
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Layout.php
 */
require_once 'Image/Graph/Layout.php';

/**
 * Layout for displaying two elements side by side.
 *
 * This splits the area contained by this element in two, side by side by
 * a specified percentage (relative to the left side). A layout can be nested.
 * Fx. a HorizontalLayout can layout two {@link Image_Graph_Layout_Vertical}s to
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
class Image_Graph_Layout_Horizontal extends Image_Graph_Layout
{

    /**
     * Part1 of the layout
     * @var GraPHPElemnt
     * @access private
     */
    var $_part1 = false;

    /**
     * Part2 of the layout
     * @var GraPHPElemnt
     * @access private
     */
    var $_part2 = false;

    /**
     * The percentage of the graph where the split occurs
     * @var int
     * @access private
     */
    var $_percentage;

    /**
     * An absolute position where the split occurs
     * @var int
     * @access private
     */
    var $_absolute;

    /**
     * HorizontalLayout [Constructor]
     *
     * @param Image_Graph_Element $part1 The 1st part of the layout
     * @param Image_Graph_Element $part2 The 2nd part of the layout
     * @param int $percentage The percentage of the layout to split at
     */
    function Image_Graph_Layout_Horizontal(& $part1, & $part2, $percentage = 50)
    {
        parent::__construct();
        if (!is_a($part1, 'Image_Graph_Layout')) {
            $this->_error(
                'Cannot create layout on non-layouable parts: ' . get_class($part1),
                array('part1' => &$part1, 'part2' => &$part2)
            );
        } elseif (!is_a($part2, 'Image_Graph_Layout')) {
            $this->_error(
                'Cannot create layout on non-layouable parts: ' . get_class($part2),
                array('part1' => &$part1, 'part2' => &$part2)
            );
        } else {
            $this->_part1 =& $part1;
            $this->_part2 =& $part2;
            $this->add($this->_part1);
            $this->add($this->_part2);
        };
        if ($percentage === 'auto') {
            $this->_percentage = false;
            $this->_absolute = 'runtime';
        } else {
            $this->_absolute = false;
            $this->_percentage = max(0, min(100, $percentage));
        }
        $this->_split();
        $this->_padding = array('left' => 0, 'top' => 0, 'right' => 0, 'bottom' => 0);
    }

    /**
     * Gets the absolute size of one of the parts.
     *
     * @param string $part The name of the part - auto_part(1|2)
     * @return int The number of pixels the edge should be pushed
	 * @since 0.3.0dev2
     * @access private
     */    
    function _getAbsolute(&$part)
    {
        $part1Size = $this->_part1->_getAutoSize();
        $part2Size = $this->_part2->_getAutoSize();
        $this->_percentage = false;
        if (($part1Size !== false) and ($part2Size !== false)) {
            $width = $this->_fillWidth() * $part1Size / ($part1Size + $part2Size);
        } elseif ($part1Size !== false) {
            $width = $part1Size;
        } elseif ($part2Size !== false) {
            $width = -$part2Size;
        } else {
            $width = $this->_fillWidth() / 2;
        }
        if ($part == 'auto_part2') {
            $width = -$width;
        }

        return $width;
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
                $this->_part1->_push('right', "$split1%");
                $this->_part2->_push('left', "$split2%");
            } else {
                $this->_part1->_push('right', 'auto_part1');
                $this->_part2->_push('left', 'auto_part2');
            }
        }
    }

    /**
     * Output the layout to the canvas
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        if (($this->_part1) && ($this->_part2)) {
            return (($this->_part1->_done()) && ($this->_part2->_done()));            
        }
        return true;
    }

}

?>
