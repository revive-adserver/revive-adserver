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
 * @subpackage Grid
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 * @since      File available since Release 0.3.0dev2
 */

/**
 * Include file Image/Graph/Grid.php
 */
require_once 'Image/Graph/Grid.php';

/**
 * Display a line grid on the plotarea.
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
 * @since      Class available since Release 0.3.0dev2
 */
class Image_Graph_Grid_Polar extends Image_Graph_Grid
{

    /**
     * GridLines [Constructor]
     */
    function Image_Graph_Grid_Polar()
    {
        parent::__construct();
        $this->_lineStyle = 'lightgrey';
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
        
        $value = false;

        $p0 = array ('X' => '#min#', 'Y' => '#min#');
        if ($this->_primaryAxis->_type == IMAGE_GRAPH_AXIS_Y) {
            $p1 = array ('X' => '#min#', 'Y' => '#max#');
            $r0 = abs($this->_pointY($p1) - $this->_pointY($p0));
        } else {
            $p1 = array ('X' => '#max#', 'Y' => '#min#');
            $r0 = abs($this->_pointX($p1) - $this->_pointX($p0));
        }

        $cx = $this->_pointX($p0);
        $cy = $this->_pointY($p0);

        $span = $this->_primaryAxis->_axisSpan;

        while (($value = $this->_primaryAxis->_getNextLabel($value)) !== false) {
            $r = $r0 * ($value - $this->_primaryAxis->_getMinimum()) / $span;

            $this->_getLineStyle();
            $this->_canvas->ellipse(array('x' => $cx, 'y' => $cy, 'rx' => $r, 'ry' => $r));
        }
        
        $this->_canvas->endGroup();
        
        return true;
    }

}
?>
