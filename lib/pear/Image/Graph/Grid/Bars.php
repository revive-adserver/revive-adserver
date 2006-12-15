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
 * @version    CVS: $Id: Bars.php,v 1.10 2005/09/14 20:27:25 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */
 
/**
 * Include file Image/Graph/Grid.php
 */
require_once 'Image/Graph/Grid.php';

/**
 * Display alternating bars on the plotarea.
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
class Image_Graph_Grid_Bars extends Image_Graph_Grid
{

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
        $value = false;

        $previousValue = 0;

        $secondaryPoints = $this->_getSecondaryAxisPoints();

        while (($value = $this->_primaryAxis->_getNextLabel($value)) !== false) {
            if ($i == 1) {
                reset($secondaryPoints);
                list ($id, $previousSecondaryValue) = each($secondaryPoints);
                while (list ($id, $secondaryValue) = each($secondaryPoints)) {
                    if ($this->_primaryAxis->_type == IMAGE_GRAPH_AXIS_X) {
                        $p1 = array ('Y' => $secondaryValue, 'X' => $value);
                        $p2 = array ('Y' => $previousSecondaryValue, 'X' => $value);
                        $p3 = array ('Y' => $previousSecondaryValue, 'X' => $previousValue);
                        $p4 = array ('Y' => $secondaryValue, 'X' => $previousValue);
                    } else {
                        $p1 = array ('X' => $secondaryValue, 'Y' => $value);
                        $p2 = array ('X' => $previousSecondaryValue, 'Y' => $value);
                        $p3 = array ('X' => $previousSecondaryValue, 'Y' => $previousValue);
                        $p4 = array ('X' => $secondaryValue, 'Y' => $previousValue);
                    }

                    $this->_canvas->addVertex(array('x' => $this->_pointX($p1), 'y' => $this->_pointY($p1)));
                    $this->_canvas->addVertex(array('x' => $this->_pointX($p2), 'y' => $this->_pointY($p2)));
                    $this->_canvas->addVertex(array('x' => $this->_pointX($p3), 'y' => $this->_pointY($p3)));
                    $this->_canvas->addVertex(array('x' => $this->_pointX($p4), 'y' => $this->_pointY($p4)));

                    $this->_getFillStyle();
                    $this->_canvas->polygon(array('connect' => true));

                    $previousSecondaryValue = $secondaryValue;
                }
            }
            $i = 1 - $i;
            $previousValue = $value;
        }
        
        $this->_canvas->endGroup();
        
        return true;
    }

}

?>