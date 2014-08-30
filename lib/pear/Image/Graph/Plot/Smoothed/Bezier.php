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
 * Include file Image/Graph/Plot.php
 */
require_once 'Image/Graph/Plot.php';

/**
 * Include file Image/Graph/Tool.php
 */
require_once 'Image/Graph/Tool.php';

/**
 * Bezier smoothed plottype.
 *
 * The framework for calculating the Bezier smoothed curve from the dataset.
 * Used in {@link Image_Graph_Plot_Smoothed_Line} and {@link
 * Image_Graph_Plot_Smoothed_Area}. Smoothed charts are only supported with non-
 * stacked types
 * @link http://homepages.borland.com/efg2lab/Graphics/Jean-
 * YvesQueinecBezierCurves.htm efg computer lab - description of bezier curves
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 * @abstract
 */
class Image_Graph_Plot_Smoothed_Bezier extends Image_Graph_Plot
{

    /**
     * Image_Graph_Plot_Smoothed_Bezier [Constructor]
     *
     * Only 'normal' multitype supported
     *
     * @param Dataset $dataset The data set (value containter) to plot
     * @param string $title The title of the plot (used for legends, {@link
     *   Image_Graph_Legend})
     */
    function Image_Graph_Plot_Smoothed_Bezier(& $dataset, $title = '')
    {
        parent::__construct($dataset, 'normal', $title);
    }

    /**
     * Return the minimum Y point
     *
     * @return double The minumum Y point
     * @access private
     */
    function _minimumY()
    {
        return 1.05 * parent::_minimumY();
    }

    /**
     * Return the maximum Y point
     *
     * @return double The maximum Y point
     * @access private
     */
    function _maximumY()
    {
        return 1.05 * parent::_maximumY();
    }

    /**
     * Calculates all Bezier points, for the curve
     *
     * @param array $p1 The actual point to calculate control points for
     * @param array $p0 The point "just before" $p1
     * @param array $p2 The point "just after" $p1
     * @param array $p3 The point "just after" $p2
     * @return array Array of Bezier points
     * @access private
     */
    function _getControlPoints($p1, $p0, $p2, $p3)
    {
        $p1 = $this->_pointXY($p1);
        if ($p2) {
            $p2 = $this->_pointXY($p2);
        }
        if (!$p0) {
            $p0['X'] = $p1['X'] - abs($p2['X'] - $p1['X']);
            $p0['Y'] = $p1['Y']; //-($p2['Y']-$p1['Y']);
        } else {
            $p0 = $this->_pointXY($p0);
        }
        if (!$p3) {
            $p3['X'] = $p1['X'] + 2*abs($p1['X'] - $p0['X']);
            $p3['Y'] = $p1['Y'];
        } else {
            $p3 = $this->_pointXY($p3);
        }

        if (!$p2) {
            $p2['X'] = $p1['X'] + abs($p1['X'] - $p0['X']);
            $p2['Y'] = $p1['Y'];
        }

        $pC1['X'] = Image_Graph_Tool::controlPoint($p0['X'], $p1['X'], $p2['X']);
        $pC1['Y'] = Image_Graph_Tool::controlPoint($p0['Y'], $p1['Y'], $p2['Y']);
        $pC2['X'] = Image_Graph_Tool::controlPoint($p3['X'], $p2['X'], $p1['X']);
        $pC2['Y'] = Image_Graph_Tool::controlPoint($p3['Y'], $p2['Y'], $p1['Y']);

        return array(
            'X' => $p1['X'],
            'Y' => $p1['Y'],
            'P1X' => $pC1['X'],
            'P1Y' => $pC1['Y'],
            'P2X' => $pC2['X'],
            'P2Y' => $pC2['Y']
        );
    }

    /**
     * Create legend sample data for the canvas.
     *
     * Common for all smoothed plots
     *
     * @access private
     */
    function _addSamplePoints($x0, $y0, $x1, $y1)
    {
        $p = abs($x1 - $x0);
        $cy = ($y0 + $y1) / 2;
        $h = abs($y1 - $y0);
        $dy = $h / 4;
        $dw = abs($x1 - $x0) / $p;
        for ($i = 0; $i < $p; $i++) {
            $v = 2 * pi() * $i / $p;
            $x = $x0 + $i * $dw;
            $y = $cy + 2 * $v * sin($v);
            $this->_canvas->addVertex(array('x' => $x, 'y' => $y));
        }
    }

}

?>
