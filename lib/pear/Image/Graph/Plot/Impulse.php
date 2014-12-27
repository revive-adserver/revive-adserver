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
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plot.php
 */
require_once 'Image/Graph/Plot.php';

/**
 * Impulse chart.
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
class Image_Graph_Plot_Impulse extends Image_Graph_Plot
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
        $x = ($x0 + $x1) / 2;
        $this->_canvas->line(array('x0' => $x, 'y0' => $y0, 'x1' => $x, 'y1' => $y1));
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

        $this->_canvas->startGroup(get_class($this) . '_' . $this->_title);
        $this->_clip(true);

        if ($this->_multiType == 'stacked100pct') {
            $total = $this->_getTotals();
        }
        $current = array();
        $number = 0;

        $minYaxis = $this->_parent->_getMinimum($this->_axisY);
        $maxYaxis = $this->_parent->_getMaximum($this->_axisY);

        $keys = array_keys($this->_dataset);
        foreach ($keys as $key) {
            $dataset =& $this->_dataset[$key];
            $dataset->_reset();
            while ($point = $dataset->_next()) {
                $x0 = $this->_pointX($point);
                if (($this->_multiType == 'stacked') ||
                    ($this->_multiType == 'stacked100pct'))
                {
                    $x = $point['X'];

                    if ($point['Y'] >= 0) {
                        if (!isset($current[$x])) {
                            $current[$x] = 0;
                        }

                        if ($this->_multiType == 'stacked') {
                            $p0 = array(
                                'X' => $point['X'],
                                'Y' => $current[$x]
                            );
                            $p1 = array(
                                'X' => $point['X'],
                                'Y' => $current[$x] + $point['Y']
                            );
                        } else {
                            $p0 = array(
                                'X' => $point['X'],
                                'Y' => 100 * $current[$x] / $total['TOTAL_Y'][$x]
                            );
                            $p1 = array(
                                'X' => $point['X'],
                                'Y' => 100 * ($current[$x] + $point['Y']) / $total['TOTAL_Y'][$x]
                            );
                        }
                        $current[$x] += $point['Y'];
                    } else {
                        if (!isset($currentNegative[$x])) {
                            $currentNegative[$x] = 0;
                        }

                        $p0 = array(
                                'X' => $point['X'],
                                'Y' => $currentNegative[$x]
                            );
                        $p1 = array(
                                'X' => $point['X'],
                                'Y' => $currentNegative[$x] + $point['Y']
                            );
                        $currentNegative[$x] += $point['Y'];
                    }
                } else {
                    $p0 = array('X' => $point['X'], 'Y' => 0);
                    $p1 = $point;
                }

                if ((($minY = min($p0['Y'], $p1['Y'])) < $maxYaxis) &&
                    (($maxY = max($p0['Y'], $p1['Y'])) > $minYaxis)
                ) {
                    $p0['Y'] = $minY;
                    $p1['Y'] = $maxY;

                    if ($p0['Y'] < $minYaxis) {
                        $p0['Y'] = '#min_pos#';
                    }
                    if ($p1['Y'] > $maxYaxis) {
                        $p1['Y'] = '#max_neg#';
                    }

                    $x1 = $this->_pointX($p0);
                    $y1 = $this->_pointY($p0);

                    $x2 = $this->_pointX($p1);
                    $y2 = $this->_pointY($p1);

                    if ($this->_multiType == 'normal') {
                        $offset = 5*$number;
                        $x1 += $offset;
                        $x2 += $offset;
                    }

                    $ID = $point['ID'];
                    if (($ID === false) && (count($this->_dataset) > 1)) {
                        $ID = $key;
                    }
                    $this->_getLineStyle($key);
                    $this->_canvas->line(
                        $this->_mergeData(
                            $point,
                            array(
                                'x0' => $x1,
                                'y0' => $y1,
                                'x1' => $x2,
                                'y1' => $y2
                            )
                        )
                    );
                }
            }
            $number++;
        }
        unset($keys);
        $this->_drawMarker();
        $this->_clip(false);
        $this->_canvas->endGroup();
        return true;
    }

}

?>
