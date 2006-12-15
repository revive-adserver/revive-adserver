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
 * @version    CVS: $Id: Band.php,v 1.12 2005/11/27 22:21:16 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 * @since      File available since Release 0.3.0dev2
 */

/**
 * Include file Image/Graph/Plot.php
 */
require_once 'Image/Graph/Plot.php';

/**
 * "Band" (area chart with min AND max) chart.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 * @since      Class available since Release 0.3.0dev2
 */
class Image_Graph_Plot_Band extends Image_Graph_Plot
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
        $h = abs($y1 - $y0) / 6;
        $w = round(abs($x1 - $x0) / 5);
        $y = ($y0 + $y1) / 2;

        $this->_canvas->addVertex(array('x' => $x0, 'y' => $y - $h * 3));
        $this->_canvas->addVertex(array('x' => $x0 + $w, 'y' => $y - 4 * $h));
        $this->_canvas->addVertex(array('x' => $x0 + 2 * $w, 'y' => $y - $h * 2));
        $this->_canvas->addVertex(array('x' => $x0 + 3 * $w, 'y' => $y - $h * 4));
        $this->_canvas->addVertex(array('x' => $x0 + 4 * $w, 'y' => $y - $h * 3));
        $this->_canvas->addVertex(array('x' => $x1, 'y' => $y - $h * 2));
        $this->_canvas->addVertex(array('x' => $x1, 'y' => $y + $h * 3));
        $this->_canvas->addVertex(array('x' => $x0 + 4 * $w, 'y' => $y + $h));
        $this->_canvas->addVertex(array('x' => $x0 + 3 * $w, 'y' => $y + 2 * $h));
        $this->_canvas->addVertex(array('x' => $x0 + 2 * $w, 'y' => $y + 1 * $h));
        $this->_canvas->addVertex(array('x' => $x0 + 1 * $w, 'y' => $y));
        $this->_canvas->addVertex(array('x' => $x0, 'y' => $y + $h));

        $this->_getLineStyle();
        $this->_getFillStyle();
        $this->_canvas->polygon(array('connect' => true));
    }

    /**
     * Output the plot
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        if (parent::_done() === false) {
            return false;
        }

        if (!is_array($this->_dataset)) {
            return false;
        }

        $current = array();

        $this->_canvas->startGroup(get_class($this) . '_' . $this->_title);

        $this->_clip(true);        


        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];
            $dataset->_reset();
            $upperBand = array();
            $lowerBand = array();
            while ($data = $dataset->_next()) {
                if ($this->_parent->_horizontal) {
                    $point['X'] = $data['X'];
    
                    $point['Y'] = $data['Y']['high'];
                    $y = $this->_pointY($point);
                    $x_high = $this->_pointX($point);
    
                    $point['Y'] = $data['Y']['low'];
                    $x_low = $this->_pointX($point);
       
                    $data = array('X' => $x_high, 'Y' => $y);
                    if (isset($point['data'])) {
                        $data['data'] = $point['data'];
                    } else {
                        $data['data'] = array();
                    }             
                    $upperBand[] = $data;
                    
                    $data = array('X' => $x_low, 'Y' => $y);
                    if (isset($point['data'])) {
                        $data['data'] = $point['data'];
                    } else {
                        $data['data'] = array();
                    }              
                    $lowerBand[] = $data;
                }
                else {
                    $point['X'] = $data['X'];
                    $y = $data['Y'];
    
                    $point['Y'] = $data['Y']['high'];
                    $x = $this->_pointX($point);
                    $y_high = $this->_pointY($point);
    
                    $point['Y'] = $data['Y']['low'];
                    $y_low = $this->_pointY($point);
       
                    $data = array('X' => $x, 'Y' => $y_high);
                    if (isset($point['data'])) {
                        $data['data'] = $point['data'];
                    } else {
                        $data['data'] = array();
                    }             
                    $upperBand[] = $data;
                    
                    $data = array('X' => $x, 'Y' => $y_low);
                    if (isset($point['data'])) {
                        $data['data'] = $point['data'];
                    } else {
                        $data['data'] = array();
                    }              
                    $lowerBand[] = $data;
                }
            }
            $lowerBand = array_reverse($lowerBand);
            foreach ($lowerBand as $point) {
                $this->_canvas->addVertex(
                    $this->_mergeData(
                        $point['data'],
                        array('x' => $point['X'], 'y' => $point['Y'])
                    )
                );
            }
            foreach ($upperBand as $point) {
                $this->_canvas->addVertex(                
                    $this->_mergeData(
                        $point['data'],
                        array('x' => $point['X'], 'y' => $point['Y'])
                    )
                );
            }
            unset($upperBand);
            unset($lowerBand);

            $this->_getLineStyle($key);
            $this->_getFillStyle($key);
            $this->_canvas->polygon(array('connect' => true, 'map_vertices' => true));
        }
        unset($keys);
        $this->_drawMarker();
        $this->_clip(false);        

        $this->_canvas->endGroup();

        return true;
    }

}

?>