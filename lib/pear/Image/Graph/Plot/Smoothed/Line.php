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
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plot/Smoothed/Bezier.php
 */
require_once 'Image/Graph/Plot/Smoothed/Bezier.php';

/**
 * Bezier smoothed line chart.
 *
 * Similar to a {@link Image_Graph_Plot_Line}, but the interconnecting lines
 * between two datapoints are smoothed using a Bezier curve, which enables the
 * chart to appear as a nice curved plot instead of the sharp edges of a
 * conventional {@link Image_Graph_Plot_Line}. Smoothed charts are only supported
 * with non-stacked types
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
class Image_Graph_Plot_Smoothed_Line extends Image_Graph_Plot_Smoothed_Bezier
{

    /**
     * Gets the fill style of the element
     *
     * @return int A GD filestyle representing the fill style
     * @see Image_Graph_Fill
     * @access private
     */
    function _getFillStyle($ID = false)
    {
        return IMG_COLOR_TRANSPARENT;
    }

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
        $this->_addSamplePoints($x0, $y0, $x1, $y1);
        $this->_canvas->polygon(array('connect' => false));
    }

    /**
     * Output the Bezier smoothed plot as an Line Chart
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        if (parent::_done() === false) {
            return false;
        }

        $this->_canvas->startGroup(get_class($this) . '_' . $this->_title);
        $this->_clip(true);
        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];
            $dataset->_reset();
            $numPoints = 0;
            while ($p1 = $dataset->_next()) {
                if ($p1['Y'] === null) {
                    if ($numPoints > 1) {
                        $this->_getLineStyle($key);
                        $this->_canvas->polygon(array('connect' => false, 'map_vertices' => true));
                    }
                    else {
                        $this->_canvas->reset();
                    }
                    $numPoints = 0;
                } else {
                    $p0 = $dataset->_nearby(-2);
                    $p2 = $dataset->_nearby(0);
                    $p3 = $dataset->_nearby(1);

                    if (($p0) && ($p0['Y'] === null)) {
                        $p0 = false;
                    }
                    if (($p2) && ($p2['Y'] === null)) {
                        $p2 = false;
                    }
                    if (($p3) && ($p3['Y'] === null)) {
                        $p3 = false;
                    }

                    if ($p2) {
                        $cp = $this->_getControlPoints($p1, $p0, $p2, $p3);
                        $this->_canvas->addSpline(
                            $this->_mergeData(
                                $p1,
	                    	  array(
    	                        	'x' => $cp['X'],
	                               	'y' => $cp['Y'],
	                            	'p1x' => $cp['P1X'],
	                            	'p1y' => $cp['P1Y'],
	                            	'p2x' => $cp['P2X'],
	                            	'p2y' => $cp['P2Y']
                                )
	                        )
	                    );
					} else {
                        $x = $this->_pointX($p1);
                        $y = $this->_pointY($p1);
                        $this->_canvas->addVertex(
                            $this->_mergeData(
                                $p1,
                                array('x' => $x, 'y' => $y)
                            )
                        );
                    }
                    $numPoints++;
                }
            }
            if ($numPoints > 1) {
                $this->_getLineStyle();
                $this->_canvas->polygon(array('connect' => false, 'map_vertices' => true));
            }
            else {
                $this->_canvas->reset();
            }
        }
        unset($keys);
        $this->_drawMarker();
        $this->_clip(false);
        $this->_canvas->endGroup();
        return true;
    }

}
?>
