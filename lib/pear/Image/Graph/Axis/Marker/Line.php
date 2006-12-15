<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Class file containing a axis marker used for explicitly highlighting a point
 * (line) on the graph, based on an value specified on an axis.
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
 * @subpackage Grid
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Line.php,v 1.11 2005/08/03 21:21:58 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Grid.php
 */
require_once 'Image/Graph/Grid.php';

/**
 * Display a grid
 *
 * {@link Image_Graph_Grid}
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Grid
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Axis_Marker_Line extends Image_Graph_Grid
{

    /**
     * The value
     * @var double
     * @access private
     */
    var $_value = false;

    /**
     * Sets the value of the line marker (value on the axis)
     *
     * @param double $value the value
     */
    function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * Output the grid
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        if (parent::_done() === false) {
            return false;
        }

        if (!$this->_primaryAxis) {
            return false;
        }
        
        $this->_canvas->startGroup(get_class($this));

        $i = 0;

        $this->_value = min($this->_primaryAxis->_getMaximum(), max($this->_primaryAxis->_getMinimum(), $this->_value));

        $secondaryPoints = $this->_getSecondaryAxisPoints();

        reset($secondaryPoints);
        list ($id, $previousSecondaryValue) = each($secondaryPoints);
        while (list ($id, $secondaryValue) = each($secondaryPoints)) {
            if ($this->_primaryAxis->_type == IMAGE_GRAPH_AXIS_X) {
                $p1 = array ('X' => $this->_value, 'Y' => $secondaryValue);
                $p2 = array ('X' => $this->_value, 'Y' => $previousSecondaryValue);
            } else {
                $p1 = array ('X' => $secondaryValue, 'Y' => $this->_value);
                $p2 = array ('X' => $previousSecondaryValue, 'Y' => $this->_value);
            }

            $x1 = $this->_pointX($p1);
            $y1 = $this->_pointY($p1);
            $x2 = $this->_pointX($p2);
            $y2 = $this->_pointY($p2);

            $previousSecondaryValue = $secondaryValue;

            $this->_getLineStyle();
            $this->_canvas->line(array('x0' => $x1, 'y0' => $y1, 'x1' => $x2, 'y1' => $y2));
        }
        
        $this->_canvas->endGroup();
        
        return true;
    }

}

?>