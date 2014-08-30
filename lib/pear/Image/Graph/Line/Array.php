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
 * @subpackage Line
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Common.php
 */
require_once 'Image/Graph/Common.php';

/**
 * A sequential array of linestyles.
 *
 * This is used for multiple objects within the same element with different line
 * styles. This is done by adding multiple line styles to a LineArrray
 * structure. The linearray will then when requested return the 'next' linestyle
 * in sequential order. It is possible to specify ID tags to each linestyle,
 * which is used to make sure some data uses a specific linestyle (i.e. in a
 * multiple-/stackedbarchart you name the {@link Image_Graph_Dataset}s and uses
 * this name as ID tag when adding the dataset's associated linestyle to the
 * linearray.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Line
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Line_Array extends Image_Graph_Common
{

    /**
     * The fill array
     * @var array
     * @access private
     */
    var $_lineStyles = array ();

    /**
     * Add a line style to the array
     *
     * @param Image_Graph_Line $style The style to add
     */
    function add(& $style, $id = false)
    {
        if (is_a($style, 'Image_Graph_Element')) {
            parent::add($style);
        }
        if ($id === false) {
            $this->_lineStyles[] =& $style;
        } else {
            $this->_lineStyles[$id] =& $style;
        }
        reset($this->_lineStyles);

    }

    /**
     * Add a color to the array
     *
     * @param int $color The color
     * @param string $id The id or name of the color
     */
    function addColor($color, $id = false)
    {
        if ($id !== false) {
            $this->_lineStyles[$id] = $color;
        } else {
            $this->_lineStyles[] = $color;
        }
        reset($this->_lineStyles);
    }

    /**
     * Return the linestyle
     *
     * @return int A GD Linestyle
     * @access private
     */
    function _getLineStyle($ID = false)
    {
        if (($ID === false) || (!isset($this->_lineStyles[$ID]))) {
            $ID = key($this->_lineStyles);
            if (!next($this->_lineStyles)) {
                reset($this->_lineStyles);
            }
        }
        $lineStyle =& $this->_lineStyles[$ID];

        if (is_object($lineStyle)) {
            return $lineStyle->_getLineStyle($ID);
        } elseif ($lineStyle !== null) {
            return $lineStyle;
        } else {
            return parent::_getLineStyle($ID);
        }
    }

}

?>
