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
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Line.php,v 1.2 2005/11/27 22:21:18 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plot.php
 */
require_once 'Image/Graph/Plot.php';

/**
 * Include file Image/Graph/Tool.php
 */
require_once 'Image/Graph/Tool.php';

/**
 * Fit the graph (to a line using linear regression).
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Plot_Fit_Line extends Image_Graph_Plot
{

    /**
     * Perform the actual drawing on the legend.
     *
     * @param int $x0 The top-left x-coordinate
     * @param int $y0 The top-left y-coordinate
     * @param int $x1 The bottom-right x-coordinate
     * @param int $y1 The bottom-right y-coordinate
     * @access private
     */
    function _drawLegendSample($x0, $y0, $x1, $y1)
    {
        $y = ($y0 + $y1) / 2;
        $dy = abs($y1 - $y0) / 6;
        $this->_canvas->addVertex(array('x' => $x0, 'y' => $y + $dy));
        $this->_canvas->addVertex(array('x' => $x1, 'y' => $y - $dy));
        $this->_canvas->polygon(array('connect' => false));
    }
    
    /**
     * Output the plot
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        if (Image_Graph_Plot::_done() === false) {
            return false;
        }

        $this->_canvas->startGroup(get_class($this) . '_' . $this->_title);
        $this->_clip(true);
        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];
            $dataset->_reset();
            $data = array();
            while ($point = $dataset->_next()) {
                $data[] = array(
                    'X' => $this->_pointX($point),
                    'Y' => $this->_pointY($point)
                );
            }

            $regression = Image_Graph_Tool::calculateLinearRegression($data);
            $this->_getLineStyle($key);
            $this->_canvas->line(
                array(
                    'x0' => $this->_left,
                    'y0' => $this->_left * $regression['slope'] + $regression['intersection'],
                    'x1' => $this->_right,
                    'y1' => $this->_right * $regression['slope'] + $regression['intersection']
                )
            );
        }
        $this->_clip(false);
        $this->_canvas->endGroup();
        
        return true;
    }
}

?>
