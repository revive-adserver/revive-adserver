<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Class file containing a axis marker used for explicitly highlighting a area
 * on the graph, based on an interval specified on an axis.
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
class Image_Graph_Axis_Marker_Area extends Image_Graph_Grid
{

    /**
     * The lower bound
     * @var double
     * @access private
     */
    var $_lower = false;

    /**
     * The upper bound
     * @var double
     * @access private
     */
    var $_upper = false;

    /**
     * [Constructor]
     */
    function __construct()
    {
        parent::__construct();
        $this->_lineStyle = false;
    }

    /**
     * Sets the lower bound of the area (value on the axis)
     *
     * @param double $lower the lower bound
     */
    function setLowerBound($lower)
    {
        $this->_lower = $lower;
    }

    /**
     * Sets the upper bound of the area (value on the axis)
     *
     * @param double $upper the upper bound
     */
    function setUpperBound($upper)
    {
        $this->_upper = $upper;
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

        $this->_lower = max($this->_primaryAxis->_getMinimum(), $this->_lower);
        $this->_upper = min($this->_primaryAxis->_getMaximum(), $this->_upper);

        $secondaryPoints = $this->_getSecondaryAxisPoints();

        reset($secondaryPoints);
        list ($id, $previousSecondaryValue) = each($secondaryPoints);
        while (list ($id, $secondaryValue) = each($secondaryPoints)) {
            if ($this->_primaryAxis->_type == IMAGE_GRAPH_AXIS_X) {
                $p1 = array ('Y' => $secondaryValue, 'X' => $this->_lower);
                $p2 = array ('Y' => $previousSecondaryValue, 'X' => $this->_lower);
                $p3 = array ('Y' => $previousSecondaryValue, 'X' => $this->_upper);
                $p4 = array ('Y' => $secondaryValue, 'X' => $this->_upper);
            } else {
                $p1 = array ('X' => $secondaryValue, 'Y' => $this->_lower);
                $p2 = array ('X' => $previousSecondaryValue, 'Y' => $this->_lower);
                $p3 = array ('X' => $previousSecondaryValue, 'Y' => $this->_upper);
                $p4 = array ('X' => $secondaryValue, 'Y' => $this->_upper);
            }

            $this->_canvas->addVertex(array('x' => $this->_pointX($p1), 'y' => $this->_pointY($p1)));
            $this->_canvas->addVertex(array('x' => $this->_pointX($p2), 'y' => $this->_pointY($p2)));
            $this->_canvas->addVertex(array('x' => $this->_pointX($p3), 'y' => $this->_pointY($p3)));
            $this->_canvas->addVertex(array('x' => $this->_pointX($p4), 'y' => $this->_pointY($p4)));

            $previousSecondaryValue = $secondaryValue;

            $this->_getLineStyle();
            $this->_getFillStyle();
            $this->_canvas->polygon(array('connect' => true));
        }

        $this->_canvas->endGroup();

        return true;
    }

}

?>
